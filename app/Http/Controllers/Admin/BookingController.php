<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $query = Booking::with(['room.roomType', 'guest']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('check_in', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('check_out', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', '%' . $search . '%')
                    ->orWhereHas('guest', function ($gq) use ($search) {
                        $gq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    });
            });
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::with(['roomType', 'hotel'])
            ->where('is_active', true)
            ->where('status', '!=', 'maintenance')
            ->get();

        return view('admin.bookings.create', compact('rooms'));
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
            'special_requests' => 'nullable|string',
        ]);

        // Check availability
        if (!$this->bookingService->checkAvailability(
            $validated['room_id'],
            $validated['check_in'],
            $validated['check_out']
        )) {
            return back()->withErrors(['room_id' => 'Room is not available for selected dates.'])
                ->withInput();
        }

        $validated['user_id'] = auth()->id();
        $booking = $this->bookingService->createBooking($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking created successfully. Code: ' . $booking->booking_code);
    }

    public function show(Booking $booking)
    {
        $booking->load(['room.roomType', 'room.hotel', 'room.amenities', 'guest', 'user']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::with(['roomType', 'hotel'])
            ->where('is_active', true)
            ->get();
        $booking->load(['room', 'guest']);

        return view('admin.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
            'payment_status' => 'required|in:unpaid,partial,paid',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string',
            'cancellation_reason' => 'nullable|string',
        ]);

        $booking->update($validated);

        // Handle status changes
        if ($validated['status'] === 'checked_in' && $booking->status !== 'checked_in') {
            $booking->room->update(['status' => 'occupied']);
            $booking->update(['checked_in_at' => now()]);
        } elseif ($validated['status'] === 'checked_out' && $booking->status !== 'checked_out') {
            $booking->room->update(['status' => 'available']);
            $booking->update(['checked_out_at' => now()]);
        } elseif ($validated['status'] === 'cancelled') {
            $booking->update(['cancelled_at' => now()]);
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->status === 'checked_in') {
            return back()->withErrors(['error' => 'Cannot delete a checked-in booking.']);
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function confirm(Booking $booking)
    {
        $booking->confirm();
        
        return back()->with('success', 'Booking confirmed successfully.');
    }

    public function checkIn(Booking $booking)
    {
        $booking->checkIn();
        
        return back()->with('success', 'Guest checked in successfully.');
    }

    public function checkOut(Booking $booking)
    {
        $booking->checkOut();
        
        return back()->with('success', 'Guest checked out successfully.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $booking->cancel($request->cancellation_reason);
        
        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function calendar()
    {
        $rooms = Room::with('roomType')
            ->where('is_active', true)
            ->orderBy('room_number')
            ->get();

        return view('admin.bookings.calendar', compact('rooms'));
    }

    public function calendarEvents(Request $request)
    {
        $bookings = Booking::with(['room', 'guest'])
            ->whereNotIn('status', ['cancelled'])
            ->when($request->room_id, function ($query) use ($request) {
                $query->where('room_id', $request->room_id);
            })
            ->whereBetween('check_in', [$request->start, $request->end])
            ->orWhereBetween('check_out', [$request->start, $request->end])
            ->get();

        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->guest->name . ' - ' . $booking->room->room_number,
                'start' => $booking->check_in->format('Y-m-d'),
                'end' => $booking->check_out->addDay()->format('Y-m-d'),
                'color' => match($booking->status) {
                    'pending' => '#ffc107',
                    'confirmed' => '#0d6efd',
                    'checked_in' => '#198754',
                    default => '#6c757d',
                },
                'url' => route('admin.bookings.show', $booking),
            ];
        });

        return response()->json($events);
    }
}
