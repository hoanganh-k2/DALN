<?php

namespace App\Http\Livewire\Dashboard\Receptionist\Reservation;

use App\Models\Reservation;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RoomDetail;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $check_in;
    public $status;

    protected $queryString = [
        'search' => ['except' => ''],
        'check_in' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = ['status:confirmed' => 'statusConfirmed', 'status:checkin' => 'statusCheckIn', 'status:checkout' => 'statusCheckOut'];

    public function render()
    {
        return view('livewire.dashboard.receptionist.reservation.index', [
            'reservations' => Reservation::filter(['search' => $this->search, 'check_in' => $this->check_in, 'status' => $this->status])->latest()->paginate(50)
        ])->layoutData(['title' => 'Reservation | Hollux']);
    }

    public function confirm($code)
    {
        $reservation = Reservation::firstWhere('code', $code);
        

        $reservation = Reservation::firstWhere('code', $code);
        if (!$reservation) {
            session()->flash('error', 'Reservation không tồn tại.');
            return;
        }

        // Cập nhật trạng thái reservation
        $reservation->update(['status' => 'confirmed']);
        $this->emitSelf('status:confirmed');
        session()->flash('message', 'xác nhận thành công!');
    }

    public function checkIn($code)
{
    $reservation = Reservation::with('roomDetails')->firstWhere('code', $code);

    if (!$reservation) {
        session()->flash('error', 'Reservation không tồn tại.');
        return;
    }
    // Số phòng cần gán
    $numRooms = (int) $reservation->total_rooms;
    // Tìm phòng RoomDetail còn trống thuộc loại phòng đó
    $availableRooms = RoomDetail::where('room_id', $reservation->room_id)
        ->where('is_available', 'true')
        ->take($numRooms)
        ->get();
    if ($availableRooms->count() < $numRooms) {
        session()->flash('error', 'Không đủ phòng trống để check-in.');
        return;
    }
    // Gán phòng vào reservation
    $confirmedRooms = collect();
    foreach ($availableRooms as $room) {
        $reservation->roomDetails()->attach($room->id, [
            'status' => 'check in',
            'price' => $reservation->total_price / $numRooms, // nếu muốn chia theo giá
        ]);
        // Đánh dấu phòng đã sử dụng
        $room->update(['is_available' => 'false']);
        $confirmedRooms->push($room);
    }
    

    // Cập nhật trạng thái reservation
    $reservation->update([
        'status' => 'check in',
        'check_in_time' => \Carbon\Carbon::now()->format('H:i:s')
    ]);
     $roomTypeId = $confirmedRooms->first()->room_id; // vì tất cả đều giống nhau
    $roomType = Room::find($roomTypeId);

    if ($roomType) {
        $usedRooms = RoomDetail::where('room_id', $roomTypeId)
            ->where('is_available', 'false')
            ->count();

        $roomType->update([
            'available' => $roomType->total_rooms - $usedRooms
        ]);
    }

    $this->emitSelf('status:checkin');
    session()->flash('message', 'Check-in thành công!');
}


    public function checkOut($code)
    {
        $reservation = Reservation::firstWhere('code', $code);
        $room = Room::firstWhere('code', $reservation->room->code);
        foreach ($reservation->roomDetails as $roomdetail) {
            $roomdetail->update(['is_available' => 'true']);

            // Cập nhật pivot status
            $reservation->roomDetails()->updateExistingPivot($roomdetail->id, ['status' => 'checked out']);
        }
        $reservation->update(['status' => 'check out', 'check_out_time' => Carbon::now()->format('H:i:s')]);
        $room->available = $room->available + $reservation->total_rooms;
        $room->save();
        $this->emitSelf('status:checkout');
    }

    public function statusConfirmed()
    {
        $this->dispatchBrowserEvent('status:confirmed');
    }

    public function statusCheckIn()
    {
        $this->dispatchBrowserEvent('status:checkin');
    }

    public function statusCheckOut()
    {
        $this->dispatchBrowserEvent('status:checkout');
    }
}
