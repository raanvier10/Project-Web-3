<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursePackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'descriptions',
        'features',
        'original_price',
        'price',
        'amount',
        'is_active',
        'whatsapp_link',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'price' => 'decimal:2',
        'amount' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * A course package has many registrations.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Scope: only active packages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted price (Rupiah).
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted original price (Rupiah).
     */
    public function getFormattedOriginalPriceAttribute(): string
    {
        return $this->original_price ? 'Rp ' . number_format($this->original_price, 0, ',', '.') : '';
    }

    /**
     * Check if package has discount.
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Get category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'kids' => 'Kids',
            'teens' => 'Teens',
            default => 'Dewasa',
        };
    }
}
