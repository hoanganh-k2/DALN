<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities = [
            [
                'Swimming Pool',
                'room',
                'Swim in a private pool with your friends!',
                'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
                '67b971a1466e3ffbf01a26fcf842bacc85feb7a2'
            ],
            [
                'Library',
                'public',
                'Read as many books as you want for free here!',
                'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
                '06ab599a280090150bbbdba527ece643855842c3'
            ],
            [
                'Marketplace',
                'public',
                'Shop easily in the market that we have provided!',
                'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
                'f0903398b6625e0d2c58a6ae6a2d626ca21c8fb1'
            ],
            [
                'Kitchen',
                'room',
                'Want a private kitchen in your room? We\'ve provided it!',
                'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
                'd5f74d17b239ebd6a7f9accf369b0c017aae2811'
            ],
            [
                'Cafe',
                'public',
                'Rest by looking at the beautiful scenery at our cafe!',
                'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
                '8350bb155dcf4cd92716cc2c3f93e1010c49e39e'
            ],
            [
                'Bathroom',
                'room',
                'Clean up in our fully equipped private bathroom!',
                'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
                '2b7563186c78f9a2a555c82b500f62dc9a616ee4'
            ],
            [
                'Living room',
                'room',
                'Welcome your friends to your hotel room\'s living room!',
                'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
                '7f99d296472f767a6e65bf088af047d37c0f5e52'
            ],
        ];

        for ($i=1; $i <= count($facilities); $i++) { 
            Facility::create([
                'code' => $facilities[$i - 1][4],
                'name' => $facilities[$i - 1][0],
                'type' => $facilities[$i - 1][1],
                'image' => 'img/facilities/fasilitas-' . $i . '.jpg',
                'description' => $facilities[$i - 1][2],
                'explanation' => '<p>' . $facilities[$i - 1][3] . '</p>',
            ]);
        }
    }
}
