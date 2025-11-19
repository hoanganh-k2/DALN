<?php

namespace App\Http\Livewire\Dashboard\Receptionist\Room;

use App\Models\RoomDetail;
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
        $this->floors = RoomDetail::select('floor')
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

    // public function loadRooms()
    // {
    //     if ($this->selectedFloor) {
    //         return RoomDetail::with(['reservations' => function ($query) {
    //             $query->whereIn('status', ['waiting', 'confirmed', 'check in']);
    //         }])
    //             ->where('floor', $this->selectedFloor)
    //             ->orderBy('room_number')
    //             ->get();
    //     }

    //     return collect();
    // }

    public function loadRooms()
    {
        if ($this->selectedFloor) {
            return RoomDetail::where('floor', $this->selectedFloor)
                ->orderBy('room_number')
                ->with(['reservations' => function($q){
                    $q->whereIn('reservation_room_details.status', ['waiting', 'confirmed', 'check in']);
                }])
                ->get();
        }

        return collect();
    }


    // public function getRoomStatus($room)
    // {
    //     $activeReservations = $room->reservations->whereIn('status', ['waiting', 'confirmed', 'check in']);

    //     if ($activeReservations->count() > 0) {
    //         if ($activeReservations->where('status', 'check in')->count() > 0) {
    //             return 'occupied'; // Đang có khách
    //         } elseif ($activeReservations->where('status', 'confirmed')->count() > 0) {
    //             return 'reserved'; // Đã đặt trước
    //         } else {
    //             return 'waiting'; // Đang chờ xác nhận
    //         }
    //     }

    //     return 'available'; // Còn trống
    // }

    public function getRoomStatus($room)
{
    // Lấy danh sách reservation của RoomDetail theo pivot status
    $activeReservations = $room->reservations->filter(function ($reservation) {
        return in_array($reservation->pivot->status, ['confirmed', 'check in']);
    });

    if ($activeReservations->count() > 0) {

        // Đang ở check-in → có khách
        if ($activeReservations->contains(function($res) { return $res->pivot->status === 'check in'; })) {
            return 'occupied';
        }

        // Đã đặt trước nhưng chưa check-in
        if ($activeReservations->contains(function($res) { return $res->pivot->status === 'confirmed'; })) {
            return 'reserved';
        }
    }
    return 'available'; // Không có reservation nào đang active
}



    protected $listeners = ['openRoomDetail', 'markRoomCleaned'];

    public function openRoomDetail($roomCode)
    {
        return redirect()->route('dashboard.receptionist.rooms.show', $roomCode);
    }

    public function markRoomCleaned($roomCode)
    {
        $room = RoomDetail::where('code', $roomCode)->first();
        if ($room) {
            $room->cleaning_status = 'clean';
            $room->save();
            session()->flash('message', "Phòng {$room->room_number} đã được đánh dấu sạch.");
        }
    }

    public function markRoomDirty($roomCode)
    {
        $room = RoomDetail::where('code', $roomCode)->first();
        if ($room) {
            $room->cleaning_status = 'dirty';
            $room->save();
            session()->flash('message', "Phòng {$room->room_number} cần dọn dẹp.");
        }
    }

    public function markRoomCleaning($roomCode)
    {
        $room = RoomDetail::where('code', $roomCode)->first();
        if ($room) {
            $room->cleaning_status = 'cleaning';
            $room->save();
            session()->flash('message', "Phòng {$room->room_number} đang được dọn dẹp.");
        }
    }
}
