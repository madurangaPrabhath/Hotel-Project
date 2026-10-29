<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['room_title' => 'Deluxe Bed Room', 'description' => 'Spacious deluxe room with king size bed, city view and modern amenities.', 'price' => 120, 'wifi' => 'yes', 'room_type' => 'deluxe', 'image' => 'images/room1.jpg'],
            ['room_title' => 'Premium Bed Room', 'description' => 'Premium room with queen size bed, balcony and complimentary breakfast.', 'price' => 90, 'wifi' => 'yes', 'room_type' => 'premium', 'image' => 'images/room2.jpg'],
            ['room_title' => 'Regular Bed Room', 'description' => 'Comfortable regular room with twin beds, ideal for families.', 'price' => 60, 'wifi' => 'no', 'room_type' => 'regular', 'image' => 'images/room3.jpg'],
            ['room_title' => 'Deluxe Suite', 'description' => 'Luxury suite with living area, jacuzzi and panoramic view.', 'price' => 200, 'wifi' => 'yes', 'room_type' => 'deluxe', 'image' => 'images/room4.jpg'],
            ['room_title' => 'Premium Twin', 'description' => 'Premium twin room perfect for business travelers.', 'price' => 85, 'wifi' => 'yes', 'room_type' => 'premium', 'image' => 'images/room5.jpg'],
            ['room_title' => 'Regular Single', 'description' => 'Cozy single room with all essential amenities.', 'price' => 45, 'wifi' => 'no', 'room_type' => 'regular', 'image' => 'images/room6.jpg'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}