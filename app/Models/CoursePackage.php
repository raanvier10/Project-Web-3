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

    /**
     * Count active registrations (paid/valid) for this package.
     */
    public function getActiveRegistrationsCountAttribute(): int
    {
        return $this->registrations()
            ->where('status', 'active')
            ->count();
    }

    /**
     * Get remaining available slots.
     * Returns null if amount is 0 (unlimited).
     */
    public function getRemainingSlotsAttribute(): ?int
    {
        if ($this->amount <= 0) {
            return null; // unlimited
        }

        return max(0, $this->amount - $this->active_registrations_count);
    }

    /**
     * Check if this package is fully booked.
     */
    public function getIsFullAttribute(): bool
    {
        if ($this->amount <= 0) {
            return false; // unlimited slots
        }

        return $this->active_registrations_count >= $this->amount;
    }

    /**
     * Scope: only active packages that still have available slots.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->where('amount', 0) // unlimited
                  ->orWhereRaw('amount > (SELECT COUNT(*) FROM registrations WHERE registrations.course_package_id = course_packages.id AND registrations.status = ?)' , ['active']);
            });
    }
}
