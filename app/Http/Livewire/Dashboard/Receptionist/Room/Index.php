<?php

namespace App\Http\Livewire\Dashboard\Receptionist\Room;

use App\Models\Room;
use Livewire\Component;

class Index extends Component
{
    public $floors;
    public $selectedFloor;

    public function render()
    {
        $rooms = $this->loadRooms();
        
        return view('livewire.dashboard.receptionist.room.index', [
            'rooms' => $rooms
        ])->layoutData(['title' => 'Room Management | Hollux']);
    }

    public function mount()
    {
        // Lấy danh sách tầng
        $this->floors = Room::select('floor')
            ->whereNotNull('floor')
            ->distinct()
            ->orderBy('floor')
            ->pluck('floor')
            ->toArray();
        
        // Mặc định chọn tầng đầu tiên
        $this->selectedFloor = $this->floors[0] ?? 1;
    }

    public function selectFloor($floor)
    {
        $this->selectedFloor = $floor;
    }

    public function loadRooms()
    {
        if ($this->selectedFloor) {
            return Room::with(['reservations' => function($query) {
                    $query->whereIn('status', ['waiting', 'confirmed', 'check in']);
                }])
                ->where('floor', $this->selectedFloor)
                ->orderBy('room_number')
                ->get();
        }
        
        return collect();
    }

    public function getRoomStatus($room)
    {
        $activeReservations = $room->reservations->whereIn('status', ['waiting', 'confirmed', 'check in']);
        
        if ($activeReservations->count() > 0) {
            if ($activeReservations->where('status', 'check in')->count() > 0) {
                return 'occupied'; // Đang có khách
            } elseif ($activeReservations->where('status', 'confirmed')->count() > 0) {
                return 'reserved'; // Đã đặt trước
            } else {
                return 'waiting'; // Đang chờ xác nhận
            }
        }
        
        return 'available'; // Còn trống
    }

    protected $listeners = ['openRoomDetail', 'markRoomCleaned'];

    public function openRoomDetail($roomCode)
    {
        return redirect()->route('dashboard.receptionist.rooms.show', $roomCode);
    }

    public function markRoomCleaned($roomCode)
    {
        $room = Room::where('code', $roomCode)->first();
        if ($room) {
            $room->cleaning_status = 'clean';
            $room->save();
            session()->flash('message', "Phòng {$room->room_number} đã được đánh dấu sạch.");
        }
    }

    public function markRoomDirty($roomCode)
    {
        $room = Room::where('code', $roomCode)->first();
        if ($room) {
            $room->cleaning_status = 'dirty';
            $room->save();
            session()->flash('message', "Phòng {$room->room_number} cần dọn dẹp.");
        }
    }

    public function markRoomCleaning($roomCode)
    {
        $room = Room::where('code', $roomCode)->first();
        if ($room) {
            $room->cleaning_status = 'cleaning';
            $room->save();
            session()->flash('message', "Phòng {$room->room_number} đang được dọn dẹp.");
        }
    }
}
