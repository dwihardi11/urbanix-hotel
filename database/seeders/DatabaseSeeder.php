<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Amenity;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@urbanix.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Receptionist
        User::create([
            'name' => 'Receptionist',
            'email' => 'reception@urbanix.com',
            'password' => Hash::make('password'),
            'role' => 'receptionist',
            'is_active' => true,
        ]);

        // Create Hotel
        $hotel = Hotel::create([
            'name' => 'Urbanix Hotel Jakarta',
            'description' => 'Experience luxury and comfort in the heart of Jakarta. Urbanix Hotel offers premium accommodations with world-class amenities and exceptional service.',
            'address' => 'Jl. Sudirman No. 123',
            'city' => 'Jakarta',
            'state' => 'DKI Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '10220',
            'phone' => '+62 21 1234 5678',
            'email' => 'info@urbanix-hotel.com',
            'policies' => "Check-in: 14:00\nCheck-out: 12:00\nNo smoking in rooms\nPets not allowed\nFree cancellation up to 24 hours before check-in",
            'is_active' => true,
        ]);

        // Create Room Types
        $roomTypes = [
            [
                'name' => 'Standard Room',
                'description' => 'Comfortable room with essential amenities for a pleasant stay.',
                'base_price' => 500000,
                'capacity' => 2,
                'bed_type' => 'Queen Size',
                'size_sqm' => 25,
            ],
            [
                'name' => 'Deluxe Room',
                'description' => 'Spacious room with premium amenities and city view.',
                'base_price' => 850000,
                'capacity' => 2,
                'bed_type' => 'King Size',
                'size_sqm' => 35,
            ],
            [
                'name' => 'Executive Suite',
                'description' => 'Luxurious suite with separate living area and panoramic views.',
                'base_price' => 1500000,
                'capacity' => 3,
                'bed_type' => 'King Size',
                'size_sqm' => 55,
            ],
            [
                'name' => 'Presidential Suite',
                'description' => 'Ultimate luxury with private terrace, jacuzzi, and butler service.',
                'base_price' => 3500000,
                'capacity' => 4,
                'bed_type' => 'King Size',
                'size_sqm' => 100,
            ],
        ];

        foreach ($roomTypes as $type) {
            RoomType::create($type);
        }

        // Create Amenities
        $amenities = [
            ['name' => 'Free WiFi', 'icon' => 'bi-wifi', 'category' => 'connectivity'],
            ['name' => 'Air Conditioning', 'icon' => 'bi-snow', 'category' => 'comfort'],
            ['name' => 'Mini Bar', 'icon' => 'bi-cup-straw', 'category' => 'dining'],
            ['name' => 'Room Service', 'icon' => 'bi-bell', 'category' => 'service'],
            ['name' => 'Flat Screen TV', 'icon' => 'bi-tv', 'category' => 'entertainment'],
            ['name' => 'Safe Box', 'icon' => 'bi-safe', 'category' => 'security'],
            ['name' => 'Coffee Maker', 'icon' => 'bi-cup-hot', 'category' => 'dining'],
            ['name' => 'Bathtub', 'icon' => 'bi-droplet', 'category' => 'bathroom'],
            ['name' => 'Rain Shower', 'icon' => 'bi-cloud-rain', 'category' => 'bathroom'],
            ['name' => 'Work Desk', 'icon' => 'bi-laptop', 'category' => 'business'],
            ['name' => 'City View', 'icon' => 'bi-building', 'category' => 'view'],
            ['name' => 'Pool Access', 'icon' => 'bi-water', 'category' => 'facility'],
            ['name' => 'Gym Access', 'icon' => 'bi-heart-pulse', 'category' => 'facility'],
            ['name' => 'Spa Access', 'icon' => 'bi-flower1', 'category' => 'facility'],
            ['name' => 'Breakfast Included', 'icon' => 'bi-egg-fried', 'category' => 'dining'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }

        // Create Rooms
        $standardAmenities = [1, 2, 5, 6, 10]; // WiFi, AC, TV, Safe, Work Desk
        $deluxeAmenities = [1, 2, 3, 4, 5, 6, 7, 9, 10, 11]; // + Mini Bar, Room Service, Coffee, Shower, City View
        $suiteAmenities = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]; // + Bathtub, Pool, Gym
        $presidentialAmenities = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]; // All amenities

        // Standard Rooms (101-105)
        for ($i = 1; $i <= 5; $i++) {
            $room = Room::create([
                'hotel_id' => $hotel->id,
                'room_type_id' => 1,
                'room_number' => '10' . $i,
                'floor' => '1',
                'price_per_night' => 500000,
                'description' => 'Comfortable standard room on the first floor.',
            ]);
            $room->amenities()->attach($standardAmenities);
        }

        // Deluxe Rooms (201-205)
        for ($i = 1; $i <= 5; $i++) {
            $room = Room::create([
                'hotel_id' => $hotel->id,
                'room_type_id' => 2,
                'room_number' => '20' . $i,
                'floor' => '2',
                'price_per_night' => 850000,
                'description' => 'Spacious deluxe room with city view.',
            ]);
            $room->amenities()->attach($deluxeAmenities);
        }

        // Executive Suites (301-303)
        for ($i = 1; $i <= 3; $i++) {
            $room = Room::create([
                'hotel_id' => $hotel->id,
                'room_type_id' => 3,
                'room_number' => '30' . $i,
                'floor' => '3',
                'price_per_night' => 1500000,
                'description' => 'Luxurious executive suite with premium amenities.',
            ]);
            $room->amenities()->attach($suiteAmenities);
        }

        // Presidential Suite (401)
        $room = Room::create([
            'hotel_id' => $hotel->id,
            'room_type_id' => 4,
            'room_number' => '401',
            'floor' => '4',
            'price_per_night' => 3500000,
            'description' => 'The ultimate luxury experience with private terrace and butler service.',
        ]);
        $room->amenities()->attach($presidentialAmenities);
    }
}
