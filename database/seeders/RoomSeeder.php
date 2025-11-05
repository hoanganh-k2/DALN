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
        $roomTypes = [
            'Standard' => [
                'description' => 'The bedroom with the cheapest price but still quality',
                'explanation' => 'Dictumst aliquam consectetuer gravida erat platea quis. Senectus ex nisi pulvinar lacus consequat elementum ipsum per.',
                'price' => 20, // $20/night (converted from 500k VND)
                'total_rooms' => 20, // Mỗi phòng chỉ 1 giường
                'floors' => [1, 2, 3, 4, 5],
                'prefix' => 'ST'
            ],
            'Superior' => [
                'description' => 'Bedrooms with better interiors and views',
                'explanation' => 'Pharetra eu curae natoque ipsum laoreet conubia ullamcorper senectus. Maecenas volutpat fermentum turpis.',
                'price' => 32, // $32/night (converted from 800k VND)
                'total_rooms' => 12,
                'floors' => [6, 7, 8],
                'prefix' => 'SUP'
            ],
            'Deluxe' => [
                'description' => 'A large bedroom with a luxurious and elegant interior',
                'explanation' => 'Lorem mattis cras primis nisi interdum sagittis sapien felis. Class eleifend non euismod ut aenean volutpat mus congue.',
                'price' => 48, // $48/night (converted from 1.2tr VND)
                'total_rooms' => 16,
                'floors' => [9, 10, 11, 12],
                'prefix' => 'DLX'
            ],
            'Junior Suite' => [
                'description' => 'The bedroom is accompanied by a large wardrobe and a living room',
                'explanation' => 'Pretium curabitur hac nibh tellus montes maecenas augue laoreet lectus quam posuere.',
                'price' => 72, // $72/night (converted from 1.8tr VND)
                'total_rooms' => 12,
                'floors' => [13, 14, 15],
                'prefix' => 'JS'
            ],
            'Presidential Suite' => [
                'description' => 'The best rooms with interiors and complete facilities inside',
                'explanation' => 'Torquent morbi inceptos platea fusce ultrices ut pede. Urna amet sit condimentum etiam dictum conubia hendrerit.',
                'price' => 140, // $140/night (converted from 3.5tr VND)
                'total_rooms' => 4,
                'floors' => [16],
                'prefix' => 'PS'
            ]
        ];

        $imageIndex = 1;
        $cleaningStatuses = ['clean', 'dirty', 'clean', 'clean']; // Phần lớn phòng sạch

        foreach ($roomTypes as $roomName => $roomData) {
            foreach ($roomData['floors'] as $floor) {
                // Tạo 4 phòng cho mỗi tầng (01, 02, 03, 04)
                for ($roomNum = 1; $roomNum <= 4; $roomNum++) {
                    $roomNumber = $roomData['prefix'] . $floor . '0' . $roomNum;
                    $code = strtolower(str_replace(' ', '', $roomName)) . '_' . strtolower($roomNumber);

                    Room::create([
                        'code' => $code,
                        'floor' => $floor,
                        'room_number' => $roomNumber,
                        'name' => $roomName,
                        'total_rooms' => $roomData['total_rooms'],
                        'available' => $roomData['total_rooms'],
                        'cleaning_status' => $cleaningStatuses[array_rand($cleaningStatuses)],
                        'image' => 'img/rooms/' . $imageIndex . '.jpg',
                        'description' => $roomData['description'],
                        'explanation' => '<p>' . $roomData['explanation'] . '</p>',
                        'price' => $roomData['price'],
                    ]);

                    $imageIndex = ($imageIndex % 14) + 1;
                }
            }
        }
    }
}
