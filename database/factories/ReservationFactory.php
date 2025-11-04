<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = ['waiting', 'confirmed', 'check in', 'check out', 'canceled'];
        
        // Lấy random room từ tất cả các loại phòng
        $room = \App\Models\Room::inRandomOrder()->first();
        
        // Tạo ngày check-in và check-out hợp lý
        $checkIn = $this->faker->dateTimeBetween('-1 months', '+2 months');
        
        // Tính số ngày ở (1-7 đêm)
        $days = $this->faker->numberBetween(1, 7);
        
        // Tính ngày check-out = check-in + số ngày
        $checkOut = (clone $checkIn)->modify("+{$days} days");
        
        // Mỗi phòng chỉ đặt 1 (vì total_rooms = 1)
        $totalRooms = 1;
        
        // Tính tổng giá = giá phòng × số đêm × số phòng
        $totalPrice = $room->price * $days * $totalRooms;

        return [
            'code' => str(uniqid('HLX-') . date('Ymd'))->upper(),
            'user_id' => $this->faker->numberBetween(1, 200),
            'room_id' => $room->id,
            'date' => $this->faker->dateTimeBetween('-2 months'),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => Arr::random($statuses),
            'total_rooms' => $totalRooms,
            'total_price' => $totalPrice,
            'message' => $this->faker->sentence()
        ];
    }
}
