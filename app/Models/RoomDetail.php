<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'code',
        'name',
        'room_number',
        'is_available',
        'floor',
        'cleaning_status',
        'image',
        'description',
        'price',
    ];
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_room_details')
         ->withPivot(['price', 'status'])
        ->withTimestamps();
    }
    public function getFullRoomNumberAttribute()
    {
        return $this->floor && $this->room_number 
            ? "Tầng {$this->floor} - Phòng {$this->room_number}" 
            : $this->name;
    }
    public function scopeByFloor($query, $floor)
    {
        return $query->where('floor', $floor);
    }
    public function room()
{
    return $this->belongsTo(Room::class); // Room là loại phòng
}

}
