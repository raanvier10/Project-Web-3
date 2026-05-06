<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'amount',
        'proof_of_payment_path',
        'payment_status',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Belongs to a registration.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
