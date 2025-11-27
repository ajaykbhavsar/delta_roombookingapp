<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class SystemLog extends Model
{
    protected $fillable = [
        'action',
        'payload',
        'performed_by',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public static function record(string $action, array $payload = []): void
    {
        static::create([
            'action' => $action,
            'payload' => empty($payload) ? null : $payload,
            'performed_by' => Auth::id(),
        ]);
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}

