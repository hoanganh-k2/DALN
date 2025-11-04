<?php

namespace App\Http\Livewire\Dashboard\Receptionist\Room;

use App\Models\Room;
use Livewire\Component;

class Show extends Component
{
    public Room $room;

    public function render()
    {
        return view('livewire.dashboard.receptionist.room.show')->layoutData(['title' => 'Room Detail | Hollux']);
    }

    public function mount(Room $room)
    {
        $this->room = $room->load(['reservations' => function($query) {
            $query->whereIn('status', ['waiting', 'confirmed', 'check in'])
                  ->with('user')
                  ->orderBy('check_in', 'desc');
        }, 'facilities', 'reviews']);
    }
}
