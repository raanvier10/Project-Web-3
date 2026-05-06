<?php

namespace App\Http\Controllers;

use App\Models\CoursePackage;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\RegistrationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $packages = CoursePackage::active()
            ->orderBy('category')
            ->orderBy('price')
            ->get();

        return view('dashboard.packages', compact('packages'));
    }

    public function showRegistrationForm(CoursePackage $package)
    {
        return view('dashboard.register', compact('package'));
    }

    public function register(Request $request, CoursePackage $package)
    {
        $isKids = $package->category === 'kids';

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:100'],
            'domicile' => ['required', 'string', 'max:255'],
            'job' => ['required', 'string', 'max:255'],
            'phone' => [$isKids ? 'nullable' : 'required', 'string', 'max:20'],
            'parent_phone' => [$isKids ? 'required' : 'nullable', 'string', 'max:20'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'age.required' => 'Usia wajib diisi.',
            'age.integer' => 'Usia harus berupa angka.',
            'age.min' => 'Usia minimal 1 tahun.',
            'domicile.required' => 'Domisili wajib diisi.',
            'job.required' => 'Pekerjaan wajib diisi.',
            'phone.required' => 'No. WhatsApp wajib diisi.',
            'parent_phone.required' => 'No. WhatsApp orang tua wajib diisi.',
        ]);

        $registration = Registration::create([
            'registration_number' => 'EFA-' . strtoupper(Str::random(8)),
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

    public function showPayment(Registration $registration)
    {
        $this->authorizeRegistration($registration);

        $registration->load(['coursePackage', 'payment', 'detail']);

        return view('dashboard.payment', compact('registration'));
    }

    public function uploadPayment(Request $request, Registration $registration)
    {
        $this->authorizeRegistration($registration);

        $request->validate([
            'proof_of_payment' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'proof_of_payment.required' => 'Bukti pembayaran wajib diunggah.',
            'proof_of_payment.image' => 'File harus berupa gambar.',
            'proof_of_payment.mimes' => 'Format file harus JPG, JPEG, PNG, atau WebP.',
            'proof_of_payment.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $request->file('proof_of_payment')->store('payments', 'public');

        Payment::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'amount' => $registration->coursePackage->price,
                'proof_of_payment_path' => $path,
                'payment_status' => 'pending',
                'admin_notes' => null,
            ]
        );

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
