<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo 100 reservations ngẫu nhiên cho tất cả loại phòng
        Reservation::factory(100)->create();

        // Cập nhật available cho TẤT CẢ các phòng
        $rooms = Room::all();
        
        foreach ($rooms as $room) {
            // Tính số phòng còn trống dựa trên các reservation active
            $bookedRooms = $room->reservations()
                ->whereIn('status', ['waiting', 'confirmed', 'check in'])
                ->sum('total_rooms');
            
            $available = max(0, (int) $room->total_rooms - (int) $bookedRooms);
            
            $room->update(['available' => $available]);
        }
    }
}
