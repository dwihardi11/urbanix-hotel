<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $hotel = Hotel::where('is_active', true)->first();
        $roomTypes = RoomType::withCount('rooms')
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        $featuredRooms = Room::with(['roomType', 'amenities'])
            ->where('is_active', true)
            ->where('status', 'available')
            ->take(6)
            ->get();

        return view('frontend.home', compact('hotel', 'roomTypes', 'featuredRooms'));
    }

    public function about()
    {
        $hotel = Hotel::where('is_active', true)->first();
        
        return view('frontend.about', compact('hotel'));
    }

    public function contact()
    {
        $hotel = Hotel::where('is_active', true)->first();
        
        return view('frontend.contact', compact('hotel'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'room_type' => 'nullable|exists:room_types,id',
            'guests' => 'nullable|integer|min:1',
        ]);

        $availableRooms = $this->bookingService->getAvailableRooms(
            $request->check_in,
            $request->check_out,
            $request->room_type
        );

        if ($request->filled('guests')) {
            $availableRooms = $availableRooms->filter(function ($room) use ($request) {
                return $room->roomType->capacity >= $request->guests;
            });
        }

        $roomTypes = RoomType::where('is_active', true)->get();

        return view('frontend.search', [
            'rooms' => $availableRooms,
            'roomTypes' => $roomTypes,
            'checkIn' => $request->check_in,
            'checkOut' => $request->check_out,
            'selectedType' => $request->room_type,
            'guests' => $request->guests,
        ]);
    }
}
