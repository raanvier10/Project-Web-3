<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\CoursePackage;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class OwnerDashboardController extends Controller
{
    /**
     * Owner Dashboard - Overview statistics.
     */
    public function index()
    {
        $totalStaff = User::whereIn('role', ['admin', 'staff'])->count();
        $totalPackages = CoursePackage::count();
        $activePackages = CoursePackage::where('is_active', true)->count();
        $pendingPayments = Payment::where('payment_status', 'pending')->count();
        $totalRevenue = Payment::where('payment_status', 'valid')->sum('amount');

        $recentStaff = User::whereIn('role', ['admin', 'staff'])
            ->latest()
            ->take(5)
            ->get();

        return view('owner.dashboard', compact(
            'totalStaff',
            'totalPackages',
            'activePackages',
            'pendingPayments',
            'totalRevenue',
            'recentStaff'
        ));
    }

    /**
     * Staff management - list staff accounts.
     */
    public function staff(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'staff']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $staff = $query->latest()->get();

        return view('owner.staff', compact('staff'));
    }

    /**
     * Store a new staff account.
     */
    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users,email|ends_with:@gmail.com',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,staff',
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->symbols()],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi (tanpa angka/karakter khusus).',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.ends_with' => 'Email harus menggunakan domain @gmail.com.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.mixed' => 'Password harus mengandung huruf besar dan huruf kecil.',
            'password.symbols' => 'Password harus mengandung karakter simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('owner.staff')
            ->with('success', 'Akun staff berhasil dibuat.');
    }

    /**
     * Update an existing staff account.
     */
    public function updateStaff(Request $request, User $user)
    {
        $this->ensureStaff($user);

        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
                'ends_with:@gmail.com',
            ],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,staff',
            'password' => ['nullable', 'string', 'confirmed', Password::min(8)->mixedCase()->symbols()],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi (tanpa angka/karakter khusus).',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.ends_with' => 'Email harus menggunakan domain @gmail.com.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.mixed' => 'Password harus mengandung huruf besar dan huruf kecil.',
            'password.symbols' => 'Password harus mengandung karakter simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('owner.staff')
            ->with('success', 'Akun staff berhasil diperbarui.');
    }

    /**
     * Delete a staff account.
     */
    public function deleteStaff(User $user)
    {
        $this->ensureStaff($user);

        $user->delete();

        return redirect()->route('owner.staff')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }

    /**
     * Financial Reports for Owner.
     */
    public function reports(Request $request)
    {
        $query = Payment::with(['registration.user', 'registration.coursePackage'])
            ->where('payment_status', 'valid');

        // Date filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Package filter
        if ($request->filled('package_id')) {
            $query->whereHas('registration', function($q) use ($request) {
                $q->where('course_package_id', $request->package_id);
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->whereHas('registration', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(15);

        $totalRevenue = Payment::where('payment_status', 'valid')->sum('amount');
        $thisMonthRevenue = Payment::where('payment_status', 'valid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $packages = \App\Models\CoursePackage::all();

        return view('owner.reports', compact('payments', 'totalRevenue', 'thisMonthRevenue', 'packages'));
    }

    /**
     * Export owner reports as CSV (Excel-compatible).
     */
    public function exportExcel(Request $request)
    {
        $query = Payment::with(['registration.user', 'registration.coursePackage'])
            ->where('payment_status', 'valid');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('package_id')) {
            $query->whereHas('registration', function($q) use ($request) {
                $q->where('course_package_id', $request->package_id);
            });
        }
        if ($request->filled('status')) {
            $query->whereHas('registration', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $payments = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_keuangan_efa_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, [
                'No',
                'Tanggal Bayar',
                'Peserta',
                'Paket Kursus',
                'Jumlah (Rp)',
            ]);

            foreach ($payments as $i => $payment) {
                fputcsv($file, [
                    $i + 1,
                    $payment->created_at->format('Y-m-d H:i:s'),
                    $payment->registration->user->name ?? 'User dihapus',
                    $payment->registration->coursePackage->name ?? 'Paket dihapus',
                    $payment->amount,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function ensureStaff(User $user): void
    {
        if (!in_array($user->role, ['admin', 'staff'])) {
            abort(404);
        }
    }
}
