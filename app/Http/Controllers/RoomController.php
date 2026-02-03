<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;
use App\Services\BookingService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $query = Room::with(['roomType', 'hotel', 'amenities'])
            ->where('is_active', true);

        if ($request->filled('room_type')) {
            $query->where('room_type_id', $request->room_type);
        }

        if ($request->filled('price_min')) {
            $query->where('price_per_night', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max);
        }

        if ($request->filled('amenities')) {
            $amenityIds = $request->amenities;
            $query->whereHas('amenities', function ($q) use ($amenityIds) {
                $q->whereIn('amenities.id', $amenityIds);
            }, '>=', count($amenityIds));
        }

        // Sorting
        $sortBy = $request->get('sort', 'price_asc');
        switch ($sortBy) {
            case 'price_desc':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'type':
                $query->orderBy('room_type_id');
                break;
            default:
                $query->orderBy('price_per_night', 'asc');
        }

        $rooms = $query->paginate(12)->withQueryString();
        $roomTypes = RoomType::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->get();

        return view('frontend.rooms.index', compact('rooms', 'roomTypes', 'amenities'));
    }

    public function show(Room $room, Request $request)
    {
        $room->load(['roomType', 'hotel', 'amenities']);

        // Similar rooms
        $similarRooms = Room::with(['roomType', 'amenities'])
            ->where('room_type_id', $room->room_type_id)
            ->where('id', '!=', $room->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        // Check availability if dates provided
        $isAvailable = true;
        $priceCalculation = null;
        
        if ($request->filled(['check_in', 'check_out'])) {
            $isAvailable = $this->bookingService->checkAvailability(
                $room->id,
                $request->check_in,
                $request->check_out
            );
            
            if ($isAvailable) {
                $priceCalculation = $this->bookingService->calculatePrice(
                    $room,
                    $request->check_in,
                    $request->check_out
                );
            }
        }

        return view('frontend.rooms.show', compact(
            'room',
            'similarRooms',
            'isAvailable',
            'priceCalculation'
        ));
    }

    public function checkAvailability(Room $room, Request $request)
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

        $priceCalculation = null;
        if ($isAvailable) {
            $priceCalculation = $this->bookingService->calculatePrice(
                $room,
                $request->check_in,
                $request->check_out
            );
        }

        return response()->json([
            'available' => $isAvailable,
            'price' => $priceCalculation,
        ]);
    }

    public function getCalendarEvents(Room $room, Request $request)
    {
        $events = $this->bookingService->getBookingsForCalendar(
            $room->id,
            $request->start ?? now()->startOfMonth()->format('Y-m-d'),
            $request->end ?? now()->endOfMonth()->format('Y-m-d')
        );

        return response()->json($events);
    }
}
