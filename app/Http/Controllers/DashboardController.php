<?php

namespace App\Http\Controllers;

use App\Models\CoursePackage;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\RegistrationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Peserta Dashboard — Overview.
     */
    public function index()
    {
        $user = Auth::user();

        $registrations = Registration::query()
            ->where('user_id', $user->id)
            ->with(['coursePackage', 'payment', 'detail'])
            ->latest()
            ->get();

        $totalPackages = $registrations->count();
        $pendingPayments = $registrations->filter(fn ($registration) => $registration->display_status === 'Menunggu Pembayaran')->count();
        $verifyingPayments = $registrations->filter(fn ($registration) => $registration->display_status === 'Menunggu Verifikasi')->count();
        $paidCount = $registrations->filter(fn ($registration) => $registration->display_status === 'Lunas')->count();

        return view('dashboard.index', compact(
            'user',
            'registrations',
            'totalPackages',
            'pendingPayments',
            'verifyingPayments',
            'paidCount'
        ));
    }

    public function packages()
    {
        $packages = CoursePackage::orderByRaw('CASE WHEN original_price IS NOT NULL AND original_price > price THEN 1 ELSE 0 END DESC')
            ->orderBy('category')
            ->orderBy('price')
            ->get();

        return view('dashboard.packages', compact('packages'));
    }

    public function showRegistrationForm(CoursePackage $package)
    {
        // FIX: Cek apakah paket masih aktif
        if (!$package->is_active) {
            return redirect()->route('dashboard.packages')
                ->with('error', 'Paket kursus ini sudah tidak tersedia.');
        }



        // FIX: Cek duplikasi registrasi (pending/active/rejected)
        $existingRegistration = Registration::where('user_id', Auth::id())
            ->where('course_package_id', $package->id)
            ->whereIn('status', ['pending', 'active', 'rejected'])
            ->first();

        if ($existingRegistration) {
            // Redirect ke payment jika masih pending, atau ke transactions jika sudah aktif/ditolak
            if ($existingRegistration->status === 'pending') {
                return redirect()->route('dashboard.payment', $existingRegistration->id)
                    ->with('error', 'Anda sudah terdaftar di paket ini. Silakan selesaikan pembayaran.');
            }

            if ($existingRegistration->status === 'rejected') {
                return redirect()->route('dashboard.transactions')
                    ->with('error', 'Pendaftaran Anda sebelumnya ditolak. Silakan cek riwayat transaksi untuk mengunggah ulang bukti pembayaran.');
            }

            return redirect()->route('dashboard.transactions')
                ->with('error', 'Anda sudah aktif di paket kursus ini.');
        }

        return view('dashboard.register', compact('package'));
    }

    public function register(Request $request, CoursePackage $package)
    {
        // FIX: Re-validate paket aktif di sisi server
        if (!$package->is_active) {
            return redirect()->route('dashboard.packages')
                ->with('error', 'Paket kursus ini sudah tidak tersedia.');
        }



        // FIX: Re-validate duplikasi di sisi server (mencegah race condition form submit ganda)
        $existingRegistration = Registration::where('user_id', Auth::id())
            ->where('course_package_id', $package->id)
            ->whereIn('status', ['pending', 'active', 'rejected'])
            ->first();

        if ($existingRegistration) {
            if ($existingRegistration->status === 'rejected') {
                return redirect()->route('dashboard.transactions')
                    ->with('error', 'Pendaftaran Anda sebelumnya ditolak. Silakan cek riwayat transaksi untuk mengunggah ulang bukti pembayaran.');
            }
            return redirect()->route('dashboard.transactions')
                ->with('error', 'Anda sudah terdaftar di paket kursus ini.');
        }

        $isKids = $package->category === 'kids';

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'age' => ['required', 'integer', 'min:' . ($isKids ? '4' : '16'), 'max:' . ($isKids ? '15' : '100')],
            'domicile' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'job' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'phone' => [$isKids ? 'nullable' : 'required', 'string', 'regex:/^08[0-9]{10,11}$/'],
            'parent_phone' => [$isKids ? 'required' : 'nullable', 'string', 'regex:/^08[0-9]{10,11}$/'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi (tanpa angka/karakter khusus).',
            'age.required' => 'Usia wajib diisi.',
            'age.integer' => 'Usia harus berupa angka.',
            'age.min' => $isKids
                ? 'Usia minimal 4 tahun untuk program Kids.'
                : 'Usia minimal 16 tahun untuk program Dewasa. Silakan pilih paket Kids untuk usia di bawah 16 tahun.',
            'age.max' => $isKids
                ? 'Usia maksimal 15 tahun untuk program Kids. Silakan pilih paket Dewasa untuk usia 16 tahun ke atas.'
                : 'Usia maksimal 100 tahun.',
            'domicile.required' => 'Domisili wajib diisi.',
            'domicile.regex' => 'Domisili hanya boleh berisi huruf dan spasi (tanpa angka/karakter khusus).',
            'job.required' => 'Pekerjaan wajib diisi.',
            'job.regex' => 'Pekerjaan hanya boleh berisi huruf dan spasi (tanpa angka/karakter khusus).',
            'phone.required' => 'No. WhatsApp wajib diisi.',
            'phone.regex' => 'No. WhatsApp harus diawali "08" dan terdiri dari 12-13 digit angka.',
            'parent_phone.required' => 'No. WhatsApp orang tua wajib diisi.',
            'parent_phone.regex' => 'No. WhatsApp orang tua harus diawali "08" dan terdiri dari 12-13 digit angka.',
        ]);

        // FIX: Gunakan model boot untuk generate registration number (anti-collision)
        $registration = Registration::create([
            'user_id' => Auth::id(),
            'course_package_id' => $package->id,
            'program_category' => $package->category,
            'status' => 'pending',
        ]);

        RegistrationDetail::create([
            'registration_id' => $registration->id,
            'program_category' => $package->category,
            'name' => $request->name,
            'age' => $request->age,
            'domicile' => $request->domicile,
            'job' => $request->job,
            'phone' => $isKids ? null : $request->phone,
            'parent_phone' => $isKids ? $request->parent_phone : null,
        ]);

        return redirect()->route('dashboard.payment', $registration->id)
            ->with('success', 'Pendaftaran berhasil! Silakan lanjutkan pembayaran.');
    }

    public function cancelRegistration(Registration $registration)
    {
        $this->authorizeRegistration($registration);

        // Hanya boleh batal jika status masih pending atau rejected (ditolak admin)
        if (!in_array($registration->status, ['pending', 'rejected']) || ($registration->payment && !in_array($registration->payment->payment_status, ['pending', 'rejected']))) {
            return redirect()->route('dashboard.transactions')
                ->with('error', 'Pendaftaran ini tidak dapat dibatalkan.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($registration) {
            // Hapus detail
            if ($registration->detail) {
                $registration->detail->delete();
            }

            // Hapus payment dan filenya
            if ($registration->payment) {
                if ($registration->payment->proof_of_payment_path) {
                    Storage::disk('public')->delete($registration->payment->proof_of_payment_path);
                }
                $registration->payment->delete();
            }

            // Hapus registrasi
            $registration->delete();
        });

        return redirect()->route('dashboard.packages')
            ->with('success', 'Pendaftaran berhasil dibatalkan.');
    }

    public function showPayment(Registration $registration)
    {
        $this->authorizeRegistration($registration);

        $registration->load(['coursePackage', 'payment', 'detail']);

        if ($registration->coursePackage->trashed() || !$registration->coursePackage->is_active) {
            return redirect()->route('dashboard.transactions')
                ->with('error', 'Paket kursus ini sudah dihapus atau tidak aktif. Silakan batalkan pendaftaran.');
        }

        return view('dashboard.payment', compact('registration'));
    }

    public function uploadPayment(Request $request, Registration $registration)
    {
        $this->authorizeRegistration($registration);

        if ($registration->coursePackage->trashed() || !$registration->coursePackage->is_active) {
            return redirect()->route('dashboard.transactions')
                ->with('error', 'Pembayaran ditolak. Paket kursus ini sudah dihapus atau tidak aktif.');
        }

        // FIX: Cegah re-upload jika pembayaran sudah valid (race condition dengan admin)
        if ($registration->payment && $registration->payment->payment_status === 'valid') {
            return redirect()->route('dashboard.transactions')
                ->with('success', 'Pembayaran Anda sudah diverifikasi. Tidak perlu upload ulang.');
        }

        $request->validate([
            'proof_of_payment' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'min:1'],
        ], [
            'proof_of_payment.required' => 'Bukti pembayaran wajib diunggah.',
            'proof_of_payment.image' => 'File harus berupa gambar.',
            'proof_of_payment.mimes' => 'Format file harus JPG, JPEG, PNG, atau WebP.',
            'proof_of_payment.max' => 'Ukuran file maksimal 2MB.',
            'proof_of_payment.min' => 'File tidak valid atau kosong.',
        ]);

        // Validasi tambahan: pastikan file benar-benar gambar valid (bukan file rename)
        $uploadedFile = $request->file('proof_of_payment');
        $realMime = $uploadedFile->getMimeType();
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($realMime, $allowedMimes)) {
            return back()->withErrors(['proof_of_payment' => 'File yang diunggah bukan gambar yang valid.']);
        }

        // FIX: Bungkus dalam transaction agar file + database konsisten
        $path = null;

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($registration, $uploadedFile, &$path) {
                // Hapus file bukti pembayaran lama agar tidak bocor storage
                if ($registration->payment && $registration->payment->proof_of_payment_path) {
                    Storage::disk('public')->delete($registration->payment->proof_of_payment_path);
                }

                // Simpan dengan nama hash agar nama file asli tidak bisa dieksploitasi
                $path = $uploadedFile->store('payments', 'public');

                Payment::updateOrCreate(
                    ['registration_id' => $registration->id],
                    [
                        'amount' => $registration->coursePackage->price,
                        'proof_of_payment_path' => $path,
                        'payment_status' => 'pending',
                        'admin_notes' => null,
                    ]
                );

                // FIX: Sinkronisasi status registrasi kembali ke 'pending' jika sebelumnya 'rejected'
                $registration->update(['status' => 'pending']);
            });
        } catch (\Throwable $e) {
            // Jika gagal, hapus file yang sudah terlanjur diupload
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            return back()->with('error', 'Terjadi kesalahan saat mengunggah bukti pembayaran. Silakan coba lagi.');
        }

        return redirect()->route('dashboard.transactions')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');
    }

    public function transactions()
    {
        $registrations = Registration::query()
            ->where('user_id', Auth::id())
            ->with(['coursePackage', 'payment', 'detail'])
            ->latest()
            ->get();

        return view('dashboard.transactions', compact('registrations'));
    }

    /**
     * Authorize that the current user owns the registration.
     */
    private function authorizeRegistration(Registration $registration): void
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
