<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomReview;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::role('user')->skip(1)->take(20)->get()->pluck('id');
        // Lấy room codes từ database thay vì hardcode
        $roomCodes = Room::pluck('code')->toArray();
        $faker = \Faker\Factory::create();

        for ($i=0; $i < count($users); $i++) { 
            for ($j=0; $j < count($roomCodes); $j++) { 
                RoomReview::create([
                    'code' => bin2hex(random_bytes(20)),
                    'user_id' => $users[$i],
                    'room_code' => $roomCodes[$j],
                    'message' => $faker->sentence(),
                    'star' => $faker->numberBetween(3, 5),
                    'date' => $faker->date()
                ]);
            }
        }

        for ($i=0; $i < count($roomCodes); $i++) { 
            $room = Room::firstWhere('code', $roomCodes[$i]);
            $allReviews = RoomReview::where('room_code', $room->code)->get();

            if (count($allReviews) > 0) {
                $rate = 0;

                foreach ($allReviews as $review) {
                    $rate += $review->star;
                }

                $rate /= $allReviews->count();
            } else {
                $rate = 0;
            }

            $room->update([
                'rate' => $rate,
                'views' => $faker->numberBetween(1000, 100000)
            ]);
        }
    }
}
