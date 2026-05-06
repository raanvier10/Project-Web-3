<?php

namespace App\Http\Controllers;

use App\Models\CoursePackage;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Peserta Dashboard — Overview.
     */
    public function index()
    {
        $user = auth()->user();
        $registrations = Registration::with(['coursePackage', 'payment', 'detail'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $totalPackages = $registrations->count();
        $pendingPayments = $registrations->filter(fn($r) => $r->display_status === 'Menunggu Pembayaran')->count();
        $verifyingPayments = $registrations->filter(fn($r) => $r->display_status === 'Menunggu Verifikasi')->count();
        $paidCount = $registrations->filter(fn($r) => $r->display_status === 'Lunas')->count();

        return view('peserta.index', compact(
            'user',
            'registrations',
            'totalPackages',
            'pendingPayments',
            'verifyingPayments',
            'paidCount'
        ));
    }

    /**
     * List available course packages.
     */
    public function packages()
    {
        $packages = CoursePackage::where('is_active', true)->get();
        return view('peserta.packages', compact('packages'));
    }

    /**
     * Show registration form for a specific package.
     */
    public function showRegistrationForm(CoursePackage $package)
    {
        return view('peserta.register', compact('package'));
    }

    /**
     * Process registration.
     */
    public function register(Request $request, CoursePackage $package)
    {
        $user = auth()->user();

        $registration = Registration::create([
            'registration_number' => 'EFA-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'course_package_id' => $package->id,
            'program_category' => $package->category,
            'status' => 'pending',
        ]);

        // Create registration detail based on form input
        $rules = [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:100',
            'domicile' => 'required|string|max:255',
            'job' => 'required|string|max:255',
        ];

        if ($package->category === 'kids') {
            $rules['parent_phone'] = 'required|string|max:20';
        } else {
            $rules['phone'] = 'required|string|max:20';
        }

        $detailData = $request->validate($rules);

        $detailData['registration_id'] = $registration->id;
        $detailData['program_category'] = $package->category;

        \App\Models\RegistrationDetail::create($detailData);

        return redirect()->route('dashboard.payment', $registration->id)
            ->with('success', 'Pendaftaran berhasil! Silakan lakukan pembayaran.');
    }

    /**
     * Show payment page.
     */
    public function showPayment(Registration $registration)
    {
        $this->authorizeRegistration($registration);
        $registration->load(['coursePackage', 'payment']);

        return view('peserta.payment', compact('registration'));
    }

    /**
     * Upload payment proof.
     */
    public function uploadPayment(Request $request, Registration $registration)
    {
        $this->authorizeRegistration($registration);

        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $path = $request->file('proof_of_payment')->store('payments', 'public');

        // Create or update payment record
        $payment = $registration->payment;
        if ($payment) {
            $payment->update([
                'proof_of_payment_path' => $path,
                'payment_status' => 'pending',
                'admin_notes' => null,
            ]);
        } else {
            \App\Models\Payment::create([
                'registration_id' => $registration->id,
                'amount' => $registration->coursePackage->price,
                'proof_of_payment_path' => $path,
                'payment_status' => 'pending',
            ]);
        }

        return redirect()->route('dashboard.payment', $registration->id)
            ->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    /**
     * Show transaction history.
     */
    public function transactions()
    {
        $registrations = Registration::with(['coursePackage', 'payment', 'detail'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peserta.transactions', compact('registrations'));
    }

    /**
     * Authorize that the current user owns the registration.
     */
    private function authorizeRegistration(Registration $registration): void
    {
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
