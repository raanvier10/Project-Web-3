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
     * Accessor: formatted price with Rupiah prefix.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Accessor: human-readable category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return $this->category === 'kids' ? 'Kids' : 'Dewasa';
    }

    /**
     * A package has many registrations.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
