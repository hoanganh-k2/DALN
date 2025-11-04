<?php

namespace App\Http\Livewire\Dashboard\Receptionist\Reservation;

use App\Models\Reservation;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

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

    protected $listeners = ['status:confirmed' => 'statusConfirmed', 'status:checkin' => 'statusCheckIn', 'status:checkout' => 'statusCheckOut', 'status:canceled' => 'statusCanceled'];

    public function render()
    {
        return view('livewire.dashboard.receptionist.reservation.index', [
            'reservations' => Reservation::filter(['search' => $this->search, 'check_in' => $this->check_in, 'status' => $this->status])->latest()->paginate(50)
        ])->layoutData(['title' => 'Reservation | Hollux']);
    }

    public function confirm($code)
    {
        $reservation = Reservation::firstWhere('code', $code);
        $reservation->update(['status' => 'confirmed']);
        
        // Cập nhật trạng thái phòng
        $room = Room::find($reservation->room_id);
        if ($room) {
            // Giảm số phòng available
            $room->available = max(0, $room->available - $reservation->total_rooms);
            $room->save();
        }
        
        $this->emitSelf('status:confirmed');
        session()->flash('message', 'Đã xác nhận đặt phòng thành công!');
    }

    public function checkIn($code)
    {
        $reservation = Reservation::firstWhere('code', $code);
        $reservation->update(['status' => 'check in']);
        
        // Cập nhật trạng thái phòng - phòng đang được sử dụng
        $room = Room::find($reservation->room_id);
        if ($room) {
            // Đánh dấu phòng cần dọn sau khi check-in (đang sử dụng)
            $room->cleaning_status = 'clean'; // Phòng sạch khi khách vào
            $room->save();
        }
        
        $this->emitSelf('status:checkin');
        session()->flash('message', 'Check-in thành công! Phòng đã sẵn sàng cho khách.');
    }

    public function checkOut($code)
    {
        $reservation = Reservation::firstWhere('code', $code);
        $room = Room::find($reservation->room_id);
        
        $reservation->update(['status' => 'check out']);
        
        if ($room) {
            // Tính lại số phòng available
            $room->available = $room->total_rooms - array_sum(
                $room->reservations
                    ->whereIn('status', ['waiting', 'confirmed', 'check in'])
                    ->pluck('total_rooms')
                    ->toArray()
            );
            
            // Đánh dấu phòng cần dọn sau khi check-out
            $room->cleaning_status = 'dirty';
            $room->save();
        }
        
        $this->emitSelf('status:checkout');
        session()->flash('message', 'Check-out thành công! Phòng cần dọn dẹp.');
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

    public function statusCanceled()
    {
        $this->dispatchBrowserEvent('status:canceled');
    }

    public function cancel($code)
    {
        $reservation = Reservation::firstWhere('code', $code);
        $room = Room::find($reservation->room_id);
        
        $reservation->update(['status' => 'canceled']);
        
        if ($room) {
            // Hoàn lại số phòng available
            $room->available = $room->total_rooms - array_sum(
                $room->reservations
                    ->whereIn('status', ['waiting', 'confirmed', 'check in'])
                    ->pluck('total_rooms')
                    ->toArray()
            );
            $room->save();
        }
        
        $this->emitSelf('status:canceled');
        session()->flash('message', 'Đã hủy đặt phòng.');
    }
}
