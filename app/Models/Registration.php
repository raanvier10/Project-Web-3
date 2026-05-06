<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'user_id',
        'course_package_id',
        'program_category',
        'status',
    ];

    /**
     * Accessor: human-readable display status.
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->payment && $this->payment->payment_status === 'rejected') {
            return 'Ditolak';
        }

        return match ($this->status) {
            'pending' => $this->payment ? 'Menunggu Verifikasi' : 'Menunggu Pembayaran',
            'active'  => 'Lunas',
            'rejected' => 'Ditolak',
            default   => ucfirst($this->status),
        };
    }

    /**
     * Accessor: CSS class for the status badge.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->display_status) {
            'Menunggu Pembayaran' => 'status-pending',
            'Menunggu Verifikasi' => 'status-verifying',
            'Lunas'               => 'status-paid',
            'Ditolak'             => 'status-rejected',
            default               => 'status-pending',
        };
    }

    /**
     * Accessor: progress step number (1-4).
     */
    public function getProgressStepAttribute(): int
    {
        if ($this->display_status === 'Ditolak') return 3;
        if ($this->display_status === 'Lunas') return 4;
        if ($this->display_status === 'Menunggu Verifikasi') return 2;
        return 1;
    }

    /**
     * Belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to a course package.
     */
    public function coursePackage()
    {
        return $this->belongsTo(CoursePackage::class);
    }

    /**
     * Has one payment.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Has one registration detail.
     */
    public function detail()
    {
        return $this->hasOne(RegistrationDetail::class);
    }
}
