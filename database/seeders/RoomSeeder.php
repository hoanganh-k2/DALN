<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            [
                // 0
                'Standard',
                '10',
                'The bedroom with the cheapest price but still quality',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '400',
                '6d0929022a3f483cee01a71c8bb07cd497e12a2a'
            ],
            [
                // 1
                'Superior',
                '8',
                'Bedrooms with better interiors and views',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '450',
                'a325d27311d54f329d8efc903fa29147c87cb474'
            ],
            [
                // 2
                'Deluxe',
                '7',
                'A large bedroom with a luxurious and elegant interior',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '300',
                'b04ccf712c8bf355b8d6ffbd8677190c52e5e1af'
            ],
            [
                // 3
                'Junior Suite',
                '5',
                'The bedroom is accompanied by a large wardrobe and a living room',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '500',
                'c004fc694adae94c9915ce4908d331fee3ac2e16'
            ],
            [
                // 4
                'Suite',
                '4',
                'Bedroom with separate living room and kitchen',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '500',
                '0d512be37d5472ffad8b38e631b1f6d4ac52406e'
            ],
            [
                // 5
                'Presidential Suite',
                '2',
                'The best rooms with interiors and complete facilities inside',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '800',
                '7ecf1c829efcf26958228f456ea648f07407e4c6'
            ],
            [
                // 6
                'Single',
                '10',
                'Rooms suitable for backpackers with complete facilities',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '420',
                'ef96f87eb0697be3d8f8d3338528752542d0fe18'
            ],
            [
                // 7
                'Twin',
                '8',
                'A suitable bedroom to stay with a partner or friends',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '450',
                'd2e35973667acbcc21bf806fa9c4816811f93480'
            ],
            [
                // 8
                'Double',
                '8',
                'Bedrooms that are suitable for your honeymoon',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '460',
                'e68df0c1d217535de4a78bfac1935024187dad2c'
            ],
            [
                // 9
                'Family',
                '5',
                'A bedroom that is suitable for a vacation with family',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '480',
                'd38e58c1f31900d29e1f95f729bab3e78f96a366'
            ],
            [
                // 10
                'Connecting',
                '5',
                'A suitable bedroom for your group with a separate bedroom',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '500',
                '92a4173c7dfd3fddbf45506ddd46d9bfaf706299'
            ],
            [
                // 11
                'Murphy',
                '2',
                'You can easily turn your bedroom into a living room',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '420',
                'd0694a03e5dd6aac9814f28bb14a90effea15b01'
            ],
            [
                // 12
                'Accessible',
                '8',
                'Rooms suitable for people with disabilities',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '400',
                '85dfe0fe296ce37d036a48e28e1dffd7037d0fd3'
            ],
            [
                // 13
                'Cabana',
                '2',
                'Spacious bedroom with private pool for you',
                'This room offers a premium King or Double bed with luxury linens, a dedicated workspace, and a $55$-inch Smart TV, ensuring a comfortable and productive stay with all modern amenities.',
                '600',
                'd3535f13cb58a761833f745c69cee5d8d689125b'
            ],
        ];

        for ($i=1; $i <=count($rooms); $i++) { 
            Room::create([
                'code' => $rooms[$i - 1][5],
                'name' => $rooms[$i - 1][0],
                'total_rooms' => $rooms[$i - 1][1],
                'available' => $rooms[$i - 1][1],
                'image' => 'img/rooms/' . $i . '.jpg',
                'description' => $rooms[$i - 1][2],
                'explanation' => '<p>' . $rooms[$i - 1][3] . '</p>',
                'price' => $rooms[$i - 1][4],
            ]);
        }
    }
}
