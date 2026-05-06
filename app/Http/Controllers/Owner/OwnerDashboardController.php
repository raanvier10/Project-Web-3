<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\CoursePackage;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,staff',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
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
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,staff',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
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
        // Simple financial query
        $payments = Payment::with(['registration.user', 'registration.coursePackage'])
            ->where('payment_status', 'valid')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalRevenue = Payment::where('payment_status', 'valid')->sum('amount');
        $thisMonthRevenue = Payment::where('payment_status', 'valid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        return view('owner.reports', compact('payments', 'totalRevenue', 'thisMonthRevenue'));
    }

    private function ensureStaff(User $user): void
    {
        if (!in_array($user->role, ['admin', 'staff'])) {
            abort(404);
        }
    }
}
