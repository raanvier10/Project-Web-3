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
     * Boot: auto-generate registration_number on creating.
     * Uses timestamp prefix + random suffix to minimize collision risk.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = self::generateUniqueRegistrationNumber();
            }
        });
    }

    /**
     * Generate a unique registration number with format: EFA-YYMMDD-XXXX
     */
    public static function generateUniqueRegistrationNumber(): string
    {
        $maxAttempts = 5;

        for ($i = 0; $i < $maxAttempts; $i++) {
            $number = 'EFA-' . now()->format('ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));

            if (!self::where('registration_number', $number)->exists()) {
                return $number;
            }
        }

        // Fallback: use timestamp for guaranteed uniqueness
        return 'EFA-' . now()->format('ymd') . '-' . strtoupper(uniqid());
    }

    /**
     * A registration belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A registration belongs to a course package.
     * withTrashed: agar paket yang sudah dihapus tetap tampil di laporan/riwayat.
     */
    public function coursePackage()
    {
        return $this->belongsTo(CoursePackage::class)->withTrashed();
    }

    /**
     * A registration has one detail (form data).
     */
    public function detail()
    {
        return $this->hasOne(RegistrationDetail::class);
    }

    /**
     * A registration has one payment.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the combined status for display purposes.
     * Priority: payment_status > registration status
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->payment) {
            return match ($this->payment->payment_status) {
                'valid', 'verified', 'paid' => 'Lunas',
                'rejected' => 'Ditolak',
                'pending' => 'Menunggu Verifikasi',
                default => 'Menunggu Verifikasi',
            };
        }

        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'active' => 'Lunas',
            'rejected' => 'Ditolak',
            default => 'Menunggu Pembayaran',
        };
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->display_status) {
            'Lunas' => 'status-paid',
            'Ditolak' => 'status-rejected',
            'Menunggu Verifikasi' => 'status-verifying',
            'Menunggu Pembayaran' => 'status-pending',
            default => 'status-pending',
        };
    }

    /**
     * Get progress step (1-4).
     */
    public function getProgressStepAttribute(): int
    {
        return match ($this->display_status) {
            'Menunggu Pembayaran' => 1,
            'Menunggu Verifikasi' => 2,
            'Lunas' => 4,
            'Ditolak' => 3,
            default => 1,
        };
    }
}
