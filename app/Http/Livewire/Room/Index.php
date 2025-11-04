<?php

namespace App\Http\Livewire\Room;

use App\Models\Room;
use Livewire\Component;

class Index extends Component
{
    public $rooms;

    public function render()
    {
        return view('livewire.room.index')->layout('layouts.main', ['title' => 'Rooms | Hollux']);
    }

    public function mount()
    {
        // Lấy 1 phòng đại diện cho mỗi loại phòng (5 loại: Standard, Superior, Deluxe, Junior Suite, Presidential Suite)
        $roomTypes = ['Standard', 'Superior', 'Deluxe', 'Junior Suite', 'Presidential Suite'];
        $rooms = collect();
        
        foreach ($roomTypes as $type) {
            $room = Room::where('name', $type)->first();
            if ($room) {
                $rooms->push($room);
            }
        }
        
        $this->fill([
            'rooms' => $rooms
        ]);
    }
}
