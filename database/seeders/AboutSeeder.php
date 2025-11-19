<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create([
            'title' => 'Starting From the Travelers',
            'text' => 'Hotel offers accommodation with a fitness centre, free private parking, a shared lounge and a terrace. This 4-star hotel offers room service and a concierge service. The accommodation offers a 24-hour front desk, airport transfers, a shared kitchen and free Wi-Fi in all areas.',
            'image' => 'img/about/about.jpg'
        ]);
    }
}
