<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'descriptions',
        'price',
        'amount',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'amount' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * A course package has many registrations.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

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
     * Get category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return $this->category === 'kids' ? 'Kids' : 'Dewasa';
    }
}
