<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'unique_id',
        'location_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model to ensure every location receives a unique identifier.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            if (empty($location->unique_id)) {
                $location->unique_id = static::generateUniqueId();
            }
        });
    }

    /**
     * Generate a unique identifier for the location.
     */
    protected static function generateUniqueId(): string
    {
        do {
            $uniqueId = 'LOC-' . strtoupper(substr(uniqid(), -8));
        } while (static::where('unique_id', $uniqueId)->exists());

        return $uniqueId;
    }

      /**
     * Get all rooms for this location
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get all bookings for this location (through rooms)
     */
    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Room::class);
    }
}


