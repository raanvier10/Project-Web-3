<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'program_category',
        'name',
        'age',
        'domicile',
        'job',
        'phone',
        'parent_phone',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    /**
     * Belongs to a registration.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
