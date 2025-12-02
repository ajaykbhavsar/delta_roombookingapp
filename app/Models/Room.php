<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'room_no',
        'description',
        'is_active',
        'room_status',
        'occupancy_status',
        'location_id',
        'room_type_id',
        'base_rate',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_rate' => 'decimal:2',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class)
            ->withDefault([
                'name' => '—',
                'location_id' => null,
            ]);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class)
            ->withDefault([
                'name' => '—',
                'base_rate' => 0,
            ]);
    }

    public function type()
{
    return $this->belongsTo(RoomType::class, 'room_type_id');
}
}

