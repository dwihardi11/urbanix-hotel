<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingService
{
    /**
     * Check if a room is available for given dates
     */
    public function checkAvailability(int $roomId, string $checkIn, string $checkOut): bool
    {
        $room = Room::find($roomId);
        
        if (!$room || !$room->is_active || $room->status === 'maintenance') {
            return false;
        }

        return $room->isAvailableForDates($checkIn, $checkOut);
    }

    /**
     * Get all available rooms for given dates
     */
    public function getAvailableRooms(string $checkIn, string $checkOut, ?int $roomTypeId = null, ?int $hotelId = null)
    {
        $query = Room::with(['roomType', 'hotel', 'amenities'])
            ->where('is_active', true)
            ->where('status', '!=', 'maintenance');

        if ($roomTypeId) {
            $query->where('room_type_id', $roomTypeId);
        }

        if ($hotelId) {
            $query->where('hotel_id', $hotelId);
        }

        $rooms = $query->get();

        return $rooms->filter(function ($room) use ($checkIn, $checkOut) {
            return $room->isAvailableForDates($checkIn, $checkOut);
        });
    }

    /**
     * Calculate total price for a booking
     */
    public function calculatePrice(Room $room, string $checkIn, string $checkOut): array
    {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        
        $totalNights = $checkInDate->diffInDays($checkOutDate);
        
        if ($totalNights < 1) {
            $totalNights = 1;
        }

        $pricePerNight = $room->price_per_night;
        $subtotal = $pricePerNight * $totalNights;
        
        // Apply discounts for longer stays
        $discount = 0;
        if ($totalNights >= 7) {
            $discount = $subtotal * 0.10; // 10% discount for 7+ nights
        } elseif ($totalNights >= 3) {
            $discount = $subtotal * 0.05; // 5% discount for 3+ nights
        }

        $totalPrice = $subtotal - $discount;

        return [
            'price_per_night' => $pricePerNight,
            'total_nights' => $totalNights,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total_price' => $totalPrice,
        ];
    }

    /**
     * Generate unique booking code
     */
    public function generateBookingCode(): string
    {
        do {
            $code = 'URB-' . strtoupper(Str::random(8));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }

    /**
     * Create a new booking
     */
    public function createBooking(array $data): Booking
    {
        // Create or find guest
        $guest = Guest::updateOrCreate(
            ['email' => $data['guest_email'] ?? null, 'phone' => $data['guest_phone']],
            [
                'name' => $data['guest_name'],
                'email' => $data['guest_email'] ?? null,
                'phone' => $data['guest_phone'],
                'id_type' => $data['id_type'] ?? 'ktp',
                'id_number' => $data['id_number'],
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'country' => $data['country'] ?? 'Indonesia',
            ]
        );

        $room = Room::findOrFail($data['room_id']);
        $priceCalculation = $this->calculatePrice($room, $data['check_in'], $data['check_out']);

        $booking = Booking::create([
            'booking_code' => $this->generateBookingCode(),
            'room_id' => $data['room_id'],
            'guest_id' => $guest->id,
            'user_id' => $data['user_id'] ?? null,
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'total_nights' => $priceCalculation['total_nights'],
            'total_price' => $priceCalculation['total_price'],
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'special_requests' => $data['special_requests'] ?? null,
        ]);

        return $booking->load(['room.roomType', 'room.hotel', 'guest']);
    }

    /**
     * Get bookings for calendar display
     */
    public function getBookingsForCalendar(int $roomId, string $startDate, string $endDate): array
    {
        $bookings = Booking::where('room_id', $roomId)
            ->whereNotIn('status', ['cancelled'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in', [$startDate, $endDate])
                    ->orWhereBetween('check_out', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('check_in', '<=', $startDate)
                            ->where('check_out', '>=', $endDate);
                    });
            })
            ->get();

        return $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->guest->name,
                'start' => $booking->check_in->format('Y-m-d'),
                'end' => $booking->check_out->format('Y-m-d'),
                'color' => $this->getStatusColor($booking->status),
                'status' => $booking->status,
            ];
        })->toArray();
    }

    /**
     * Get color for booking status
     */
    private function getStatusColor(string $status): string
    {
        return match($status) {
            'pending' => '#ffc107',
            'confirmed' => '#0d6efd',
            'checked_in' => '#198754',
            'checked_out' => '#6c757d',
            default => '#6c757d',
        };
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::pending()->count(),
            'today_checkins' => Booking::where('check_in', $today)->whereIn('status', ['confirmed'])->count(),
            'today_checkouts' => Booking::where('check_out', $today)->whereIn('status', ['checked_in'])->count(),
            'monthly_revenue' => Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->whereIn('status', ['confirmed', 'checked_in', 'checked_out'])
                ->sum('total_price'),
            'occupancy_rate' => $this->calculateOccupancyRate(),
            'total_rooms' => Room::where('is_active', true)->count(),
            'available_rooms' => Room::available()->count(),
        ];
    }

    /**
     * Calculate current occupancy rate
     */
    private function calculateOccupancyRate(): float
    {
        $totalRooms = Room::where('is_active', true)->count();
        
        if ($totalRooms === 0) {
            return 0;
        }

        $occupiedRooms = Room::where('status', 'occupied')->count();
        
        return round(($occupiedRooms / $totalRooms) * 100, 1);
    }
}
