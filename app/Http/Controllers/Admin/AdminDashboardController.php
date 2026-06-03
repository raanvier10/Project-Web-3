<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoursePackage;
use App\Models\Registration;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    /**
     * Admin Dashboard — Overview statistics.
     */
    public function index()
    {
        $totalPackages      = CoursePackage::count();
        $activePackages     = CoursePackage::where('is_active', true)->count();
        $totalRegistrations = Registration::count();
        $pendingPayments    = Payment::where('payment_status', 'pending')->count();
        $validPayments      = Payment::where('payment_status', 'valid')->count();
        $totalRevenue        = Payment::where('payment_status', 'valid')
                                ->sum('amount');

        // Recent pending payments for quick action
        $recentPending = Payment::with(['registration.user', 'registration.coursePackage'])
            ->where('payment_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Recent registrations
        $recentRegistrations = Registration::with(['user', 'coursePackage', 'detail'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPackages',
            'activePackages',
            'totalRegistrations',
            'pendingPayments',
            'validPayments',
            'totalRevenue',
            'recentPending',
            'recentRegistrations'
        ));
    }

    /**
     * Course Packages management — list all.
     */
    public function packages()
    {
        $packages = CoursePackage::latest()->get();
        return view('admin.packages', compact('packages'));
    }

    /**
     * Store a new course package.
     */
    public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|in:kids,adult',
            'descriptions' => 'nullable|string',
            'features'     => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'amount'       => 'required|integer|min:0',
            'is_active'    => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        CoursePackage::create($validated);

        return redirect()->route('admin.packages')->with('success', 'Paket kursus berhasil ditambahkan.');
    }

    /**
     * Update an existing course package.
     */
    public function updatePackage(Request $request, CoursePackage $package)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|in:kids,adult',
            'descriptions' => 'nullable|string',
            'features'     => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'amount'       => 'required|integer|min:0',
        ]);

        $package->update($validated);

        return redirect()->route('admin.packages')->with('success', 'Paket kursus berhasil diperbarui.');
    }

    /**
     * Toggle package active status.
     */
    public function togglePackage(CoursePackage $package)
    {
        $package->update(['is_active' => !$package->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $package->is_active,
            'message' => $package->is_active ? 'Paket diaktifkan.' : 'Paket dinonaktifkan.',
        ]);
    }

    /**
     * Delete a course package.
     */
    public function deletePackage(CoursePackage $package)
    {
        // Check if package has registrations
        if ($package->registrations()->exists()) {
            return redirect()->route('admin.packages')
                ->with('error', 'Paket tidak bisa dihapus karena sudah ada peserta terdaftar.');
        }

        $package->delete();

        return redirect()->route('admin.packages')->with('success', 'Paket kursus berhasil dihapus.');
    }

    /**
     * Payment Verification — list pending payments.
     */
    public function payments(Request $request)
    {
        $query = Payment::with(['registration.user', 'registration.coursePackage', 'registration.detail']);

        // Status filter
        $status = $request->get('status', 'pending');
        if ($status !== 'all') {
            $query->where('payment_status', $status);
        }

        $payments = $query->latest()->get();

        return view('admin.payments', compact('payments', 'status'));
    }

    /**
     * Show payment detail (invoice).
     */
    public function paymentDetail(Payment $payment)
    {
        $payment->load(['registration.user', 'registration.coursePackage', 'registration.detail']);

        return response()->json([
            'id' => $payment->id,
            'amount' => number_format($payment->amount, 0, ',', '.'),
            'payment_status' => $payment->payment_status,
            'proof_of_payment_path' => $payment->proof_of_payment_path
                ? asset('storage/' . $payment->proof_of_payment_path)
                : null,
            'admin_notes' => $payment->admin_notes,
            'created_at' => $payment->created_at->format('d M Y, H:i'),
            'registration' => [
                'registration_number' => $payment->registration->registration_number,
                'status' => $payment->registration->status,
                'created_at' => $payment->registration->created_at->format('d M Y, H:i'),
            ],
            'user' => [
                'name' => $payment->registration->user->name,
                'email' => $payment->registration->user->email,
                'phone' => $payment->registration->user->phone,
            ],
            'package' => [
                'name' => $payment->registration->coursePackage->name,
                'category' => $payment->registration->coursePackage->category,
                'price' => number_format($payment->registration->coursePackage->price, 0, ',', '.'),
            ],
            'detail' => $payment->registration->detail ? [
                'name' => $payment->registration->detail->name,
                'age' => $payment->registration->detail->age,
                'domicile' => $payment->registration->detail->domicile,
                'job' => $payment->registration->detail->job,
                'phone' => $payment->registration->detail->phone,
                'parent_phone' => $payment->registration->detail->parent_phone,
            ] : null,
        ]);
    }

    /**
     * Accept (validate) a payment.
     */
    public function acceptPayment(Payment $payment)
    {
        $payment->update(['payment_status' => 'valid']);
        $payment->registration->update(['status' => 'active']);

        return redirect()->route('admin.payments')
            ->with('success', 'Pembayaran berhasil divalidasi dan registrasi diaktifkan.');
    }

    /**
     * Reject a payment with reason.
     */
    public function rejectPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $payment->update([
            'payment_status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        $payment->registration->update(['status' => 'rejected']);

        return redirect()->route('admin.payments')
            ->with('success', 'Pembayaran ditolak. Peserta akan menerima pemberitahuan.');
    }

    /**
     * Participants management — list accepted registrations.
     */
    public function participants(Request $request)
    {
        $query = Registration::with(['user', 'coursePackage', 'detail', 'payment'])
            ->whereHas('payment', function ($q) {
                $q->where('payment_status', 'valid');
            })
            ->where('status', 'active');

        // Filter by package
        if ($request->filled('package_id')) {
            $query->where('course_package_id', $request->package_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('detail', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%")
                       ->orWhere('domicile', 'like', "%{$search}%");
                });
            });
        }

        $participants = $query->latest()->get();
        $packages = CoursePackage::where('is_active', true)->get();

        return view('admin.participants', compact('participants', 'packages'));
    }

    /**
     * Reports with filtering.
     */
    public function reports(Request $request)
    {
        $query = Registration::with(['user', 'coursePackage', 'detail', 'payment']);

        // Date filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Package filter
        if ($request->filled('package_id')) {
            $query->where('course_package_id', $request->package_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->get();
        $packages = CoursePackage::all();

        // Aggregate stats
        $totalAmount = $registrations->sum(function ($reg) {
            return $reg->payment ? $reg->payment->amount : 0;
        });
        $validCount = $registrations->filter(function ($reg) {
            return $reg->payment && $reg->payment->payment_status === 'valid';
        })->count();

        return view('admin.reports', compact('registrations', 'packages', 'totalAmount', 'validCount'));
    }

    /**
     * Export reports as CSV (Excel-compatible).
     */
    public function exportExcel(Request $request)
    {
        $query = Registration::with(['user', 'coursePackage', 'detail', 'payment']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('package_id')) {
            $query->where('course_package_id', $request->package_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_efa_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, [
                'No',
                'No. Registrasi',
                'Nama Peserta',
                'Email',
                'Telepon',
                'Paket Kursus',
                'Kategori',
                'Asal/Domisili',
                'Jumlah Bayar',
                'Status Pembayaran',
                'Tanggal Daftar',
            ]);

            foreach ($registrations as $i => $reg) {
                fputcsv($file, [
                    $i + 1,
                    $reg->registration_number,
                    $reg->detail ? $reg->detail->name : $reg->user->name,
                    $reg->user->email,
                    $reg->detail ? ($reg->detail->phone ?? $reg->detail->parent_phone) : $reg->user->phone,
                    $reg->coursePackage->name,
                    $reg->coursePackage->category === 'kids' ? 'Kids' : 'Dewasa',
                    $reg->detail ? $reg->detail->domicile : '-',
                    $reg->payment ? $reg->payment->amount : 0,
                    $reg->payment ? $reg->payment->payment_status : 'belum bayar',
                    $reg->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
