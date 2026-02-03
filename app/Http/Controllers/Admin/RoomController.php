<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['hotel', 'roomType', 'amenities']);

        if ($request->filled('room_type')) {
            $query->where('room_type_id', $request->room_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->orderBy('room_number')->paginate(15);
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function create()
    {
        $hotels = Hotel::where('is_active', true)->get();
        $roomTypes = RoomType::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->get();

        return view('admin.rooms.create', compact('hotels', 'roomTypes', 'amenities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:10',
            'floor' => 'nullable|string|max:10',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');
                $images[] = $path;
            }
        }

        $room = Room::create([
            'hotel_id' => $validated['hotel_id'],
            'room_type_id' => $validated['room_type_id'],
            'room_number' => $validated['room_number'],
            'floor' => $validated['floor'],
            'price_per_night' => $validated['price_per_night'],
            'description' => $validated['description'],
            'images' => $images,
        ]);

        if (!empty($validated['amenities'])) {
            $room->amenities()->attach($validated['amenities']);
        }

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        $room->load(['hotel', 'roomType', 'amenities', 'bookings' => function ($query) {
            $query->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                ->orderBy('check_in');
        }]);

        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $hotels = Hotel::where('is_active', true)->get();
        $roomTypes = RoomType::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->get();
        $room->load('amenities');

        return view('admin.rooms.edit', compact('room', 'hotels', 'roomTypes', 'amenities'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:10',
            'floor' => 'nullable|string|max:10',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
            'is_active' => 'boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $images = $room->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');
                $images[] = $path;
            }
        }

        $room->update([
            'hotel_id' => $validated['hotel_id'],
            'room_type_id' => $validated['room_type_id'],
            'room_number' => $validated['room_number'],
            'floor' => $validated['floor'],
            'price_per_night' => $validated['price_per_night'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'is_active' => $request->boolean('is_active'),
            'images' => $images,
        ]);

        $room->amenities()->sync($validated['amenities'] ?? []);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Delete images
        if ($room->images) {
            foreach ($room->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }

    public function deleteImage(Room $room, int $index)
    {
        $images = $room->images ?? [];
        
        if (isset($images[$index])) {
            Storage::disk('public')->delete($images[$index]);
            unset($images[$index]);
            $room->update(['images' => array_values($images)]);
        }

        return back()->with('success', 'Image deleted successfully.');
    }
}
