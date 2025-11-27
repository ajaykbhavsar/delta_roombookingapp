<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'unique_id',
        'title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the templates associated with this product.
     */
    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    /**
     * Boot the model and generate unique_id on creating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->unique_id)) {
                $product->unique_id = static::generateUniqueId();
            }
        });
    }

    /**
     * Generate a unique ID for the product
     */
    protected static function generateUniqueId(): string
    {
        do {
            $uniqueId = 'PRD-' . strtoupper(substr(uniqid(), -8));
        } while (static::where('unique_id', $uniqueId)->exists());

        return $uniqueId;
    }
}
