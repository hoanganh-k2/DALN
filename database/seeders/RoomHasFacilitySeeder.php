<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomHasFacility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomHasFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy facilities từ database
        $facilities = Facility::pluck('code', 'type')->toArray();
        $rooms = Room::all();

        foreach ($rooms as $room) {
            // Gán tiện nghi dựa trên loại phòng
            if (str_contains($room->name, 'Presidential Suite')) {
                // Presidential Suite có đầy đủ tiện nghi
                foreach ($facilities as $type => $code) {
                    RoomHasFacility::create([
                        'room_id' => $room->id,
                        'facility_code' => $code
                    ]);
                }
            } elseif (str_contains($room->name, 'Junior Suite')) {
                // Junior Suite có một số tiện nghi cao cấp
                $selectedTypes = ['wifi', 'ac', 'tv', 'pool', 'parking'];
                foreach ($selectedTypes as $type) {
                    if (isset($facilities[$type])) {
                        RoomHasFacility::create([
                            'room_id' => $room->id,
                            'facility_code' => $facilities[$type]
                        ]);
                    }
                }
            } elseif (str_contains($room->name, 'Deluxe')) {
                // Deluxe có tiện nghi trung cấp
                $selectedTypes = ['wifi', 'ac', 'tv', 'parking'];
                foreach ($selectedTypes as $type) {
                    if (isset($facilities[$type])) {
                        RoomHasFacility::create([
                            'room_id' => $room->id,
                            'facility_code' => $facilities[$type]
                        ]);
                    }
                }
            } elseif (str_contains($room->name, 'Superior')) {
                // Superior có tiện nghi cơ bản +
                $selectedTypes = ['wifi', 'ac', 'tv'];
                foreach ($selectedTypes as $type) {
                    if (isset($facilities[$type])) {
                        RoomHasFacility::create([
                            'room_id' => $room->id,
                            'facility_code' => $facilities[$type]
                        ]);
                    }
                }
            } else {
                // Standard có tiện nghi cơ bản
                $selectedTypes = ['wifi', 'ac'];
                foreach ($selectedTypes as $type) {
                    if (isset($facilities[$type])) {
                        RoomHasFacility::create([
                            'room_id' => $room->id,
                            'facility_code' => $facilities[$type]
                        ]);
                    }
                }
            }
        }
    }
}
