<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    public const ID_PROOF_TYPES = [
        'aadhar' => 'Aadhar',
        'passport' => 'Passport',
        'driving_license' => 'Driving License',
        'other' => 'Other',
    ];

    public const ROOM_STATUS_OPTIONS = [
        'dirty' => 'Dirty',
        'clean' => 'Clean',
        'needs_maintenance' => 'Needs Maintenance',
    ];

    public const OCCUPANCY_STATUS_OPTIONS = [
        'empty' => 'Empty',
        'occupied' => 'Occupied',
        'reserved' => 'Reserved',
        'under_maintenance' => 'Under Maintenance',
    ];

    public const BOOKING_TYPE_OPTIONS = [
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
    ];

    public const PAYMENT_TYPE_OPTIONS = [
        'cash' => 'Cash',
        'card' => 'Card',
        'upi' => 'UPI',
        'online' => 'Online',
        'credit' => 'Credit',
    ];

    public const PAYMENT_STATUS_OPTIONS = [
        'paid' => 'Paid',
        'pending' => 'Pending',
        'partially_paid' => 'Partially Paid',
    ];

    public const BOOKING_STATUS_OPTIONS = [
        'confirmed' => 'Confirmed',
        'pending' => 'Pending',
        'cancelled' => 'Cancelled',
        'checked_in' => 'Checked In',
        'checked_out' => 'Checked Out',
    ];

    public const LOCATION_OPTIONS = [
        'ground_floor' => 'Ground Floor',
        'first_floor' => 'First Floor',
        'second_floor' => 'Second Floor',
        'third_floor' => 'Third Floor',
        'other' => 'Other',
    ];

    protected $fillable = [
        'reference_no',
        'room_id',
        'room_type_id',
        'created_by',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'address',
        'id_proof_type',
        'id_number',
        'location',
        'room_status',
        'occupancy_status',
        'additional_description',
        'booking_type',
        'check_in_at',
        'check_out_at',
        'guest_count',
        'room_rate',
        'discount',
        'service_charges',
        'total_amount',
        'payment_type',
        'payment_status',
        'payment_details',
        'is_repeat_customer',
        'notes',
        'booking_status',
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
        'room_rate' => 'decimal:2',
        'discount' => 'decimal:2',
        'service_charges' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_repeat_customer' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if (! $user->isAdmin()) {
            $query->where('created_by', $user->id);
        }

        return $query;
    }

    public static function generateReference(): string
    {
        do {
            $reference = 'BK-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        } while (static::where('reference_no', $reference)->exists());

        return $reference;
    }
}


