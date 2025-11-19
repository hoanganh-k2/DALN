<?php

namespace App\Http\Livewire\Dashboard\Receptionist\Room;

use App\Models\Room;
use App\Models\RoomDetail;
use Livewire\Component;

class Show extends Component
{
    public RoomDetail $room;

    public function render()
    {
        return view('livewire.dashboard.receptionist.room.show')->layoutData(['title' => 'Room Detail | Hollux']);
    }

    // public function mount(RoomDetail $room)
    // {
    //     $this->room = $room->load(['reservations' => function ($query) {
    //         $query->whereIn('status', ['waiting', 'confirmed', 'check in'])
    //             ->with('user')
    //             ->orderBy('check_in', 'desc');
    //     }, 'facilities', 'reviews']);
    // }
    
    public function mount(RoomDetail $room)
    {
        $this->room = $room->load([
            'room', // load thông tin room type
            'reservations' => function ($query) {
                $query->whereIn('reservation_room_details.status', ['waiting', 'confirmed', 'check in'])
                      ->with('user')
                      ->orderBy('check_in', 'desc');
            }
        ]);
    }

}
