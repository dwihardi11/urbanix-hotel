<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function create(Room $room, Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $isAvailable = $this->bookingService->checkAvailability(
            $room->id,
            $request->check_in,
            $request->check_out
        );

        if (!$isAvailable) {
            return redirect()->route('rooms.show', $room)
                ->with('error', 'Maaf, kamar tidak tersedia untuk tanggal yang dipilih.');
        }

        $priceCalculation = $this->bookingService->calculatePrice(
            $room,
            $request->check_in,
            $request->check_out
        );

        $room->load(['roomType', 'hotel', 'amenities']);

        return view('frontend.booking.create', [
            'room' => $room,
            'checkIn' => $request->check_in,
            'checkOut' => $request->check_out,
            'price' => $priceCalculation,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email',
            'guest_phone' => 'required|string|max:20',
            'id_type' => 'required|in:ktp,sim,passport',
            'id_number' => 'required|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'special_requests' => 'nullable|string|max:500',
        ]);

        // Double check availability
        if (!$this->bookingService->checkAvailability(
            $validated['room_id'],
            $validated['check_in'],
            $validated['check_out']
        )) {
            return back()->withErrors(['room_id' => 'Maaf, kamar sudah tidak tersedia.'])
                ->withInput();
        }

        $booking = $this->bookingService->createBooking($validated);

        return redirect()->route('booking.confirmation', $booking->booking_code)
            ->with('success', 'Booking berhasil! Silakan simpan kode booking Anda.');
    }

    public function confirmation(string $bookingCode)
    {
        $booking = Booking::with(['room.roomType', 'room.hotel', 'guest'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        return view('frontend.booking.confirmation', compact('booking'));
    }

    public function search()
    {
        // Redirect to login if not authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Silakan login untuk melihat booking Anda.');
        }

        // Get bookings for logged in user based on email
        $bookings = Booking::with(['room.roomType', 'room.hotel', 'guest'])
            ->whereHas('guest', function ($query) {
                $query->where('email', auth()->user()->email);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.booking.search', compact('bookings'));
    }

    public function find(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
            'guest_phone' => 'required|string',
        ]);

        $booking = Booking::with(['room.roomType', 'room.hotel', 'guest'])
            ->where('booking_code', $request->booking_code)
            ->whereHas('guest', function ($query) use ($request) {
                $query->where('phone', $request->guest_phone);
            })
            ->first();

        if (!$booking) {
            return back()->withErrors(['booking_code' => 'Booking tidak ditemukan.'])
                ->withInput();
        }

        return view('frontend.booking.detail', compact('booking'));
    }
}
