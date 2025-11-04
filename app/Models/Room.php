<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the full room number with floor (for receptionist view)
     *
     * @return string
     */
    public function getFullRoomNumberAttribute()
    {
        return $this->floor && $this->room_number 
            ? "Tầng {$this->floor} - Phòng {$this->room_number}" 
            : $this->name;
    }

    /**
     * Scope to filter rooms by floor
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $floor
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFloor($query, $floor)
    {
        return $query->where('floor', $floor);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'], function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    /**
     * Get all of the reservations for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get all of the facilities for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facilities(): HasMany
    {
        return $this->hasMany(RoomHasFacility::class);
    }

    /**
     * Get all of the reviews for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(RoomReview::class, 'room_code', 'code');
    }
}
