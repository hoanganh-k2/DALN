<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\FacilityReview;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilityReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::role('user')->skip(30)->take(20)->get()->pluck('id');
        // Lấy facility codes từ database thay vì hardcode
        $facilityCodes = Facility::pluck('code')->toArray();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($facilityCodes); $j++) {
                FacilityReview::create([
                    'code' => bin2hex(random_bytes(20)),
                    'user_id' => $users[$i],
                    'facility_code' => $facilityCodes[$j],
                    'message' => $faker->sentence(),
                    'star' => $faker->numberBetween(3, 5),
                    'date' => $faker->date()
                ]);
            }
        }

        for ($i = 0; $i < count($facilityCodes); $i++) {
            $facility = Facility::firstWhere('code', $facilityCodes[$i]);
            $allReviews = FacilityReview::where('facility_code', $facility->code)->get();

            if (count($allReviews) > 0) {
                $rate = 0;

                foreach ($allReviews as $review) {
                    $rate += $review->star;
                }

                $rate /= $allReviews->count();
            } else {
                $rate = 0;
            }

            $facility->update([
                'rate' => $rate,
                'views' => $faker->numberBetween(1000, 100000)
            ]);
        }
    }
}
