<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomDetail;
use Illuminate\Support\Str;


class RoomDetailSeeder extends Seeder
{
    public function run()
    {
        $cleaningStatuses = ['clean', 'dirty', 'cleaning'];

        $rooms = Room::all(); // Lấy tất cả loại phòng
        $imageIndex = 1;
        foreach ($rooms as $room) {
            for ($i = 1; $i <= $room->total_rooms; $i++) {
                RoomDetail::create([
                    'room_id' => $room->id,
                    'name' => $room->name . ' ' . $i,
                    'code' => strtoupper(substr($room->name, 0, 3)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . Str::random(4),
                    'room_number' => strtoupper(substr($room->name, 0, 3)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'is_available' => 'true',
                    'floor' => $room->id,
                    'cleaning_status' => 'clean',
                    'image' => 'img/rooms/' . $imageIndex . '.jpg',
                    'description' => $room->description,
                    'price' => $room->price,
                ]);
            }
        }
    }
}
