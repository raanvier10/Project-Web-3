@extends('layouts.owner')

@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Analitik pendapatan dan riwayat transaksi sukses')

@section('owner-content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4 no-print">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(245,158,11,0.08), rgba(217,119,6,0.04)); border: 1px solid rgba(245,158,11,0.12);">
            <i class="fas fa-chart-line text-amber-500 text-xs"></i>
            <span class="text-amber-600 text-xs font-semibold">Keuangan</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Laporan & Analitik</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Pantau aliran dana dan pendapatan dari setiap transaksi pendaftaran.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('owner.reports.export.excel', request()->all()) }}" class="admin-btn !bg-emerald-50 !text-emerald-600 hover:!bg-emerald-100 hover:-translate-y-0.5 border border-emerald-100">
            <i class="fas fa-file-excel mr-2"></i> Export Excel
        </a>
        <button onclick="window.print()" class="admin-btn admin-btn-outline" id="btn-print">
            <i class="fas fa-print mr-2"></i> Cetak
        </button>
    </div>
</div>

{{-- Search & Filter --}}
<div class="admin-float-card !p-5 mb-6" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
    <div class="flex items-center space-x-2 mb-4">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
            <i class="fas fa-filter text-xs text-blue-600"></i>
        </div>
        <h3 class="text-base font-bold text-gray-900">Filter Laporan</h3>
    </div>
    <form method="GET" action="{{ route('owner.reports') }}" id="reportFilterForm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Date From --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-calendar mr-2 text-blue-400 text-xs"></i> Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-form-input" id="filter-date-from">
            </div>
            {{-- Date To --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-calendar mr-2 text-blue-400 text-xs"></i> Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-form-input" id="filter-date-to">
            </div>
            {{-- Package --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-box-open mr-2 text-blue-400 text-xs"></i> Paket Kursus</label>
                <select name="package_id" class="admin-form-select" id="filter-report-package">
                    <option value="">Semua Paket</option>
                    @foreach($packages as $pkg)
                    <option value="{{ $pkg->id }}" {{ request('package_id') == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Status --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-info-circle mr-2 text-blue-400 text-xs"></i> Status</label>
                <select name="status" class="admin-form-select" id="filter-report-status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif / Lunas</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
        </div>

        <div class="mt-5 flex items-center justify-end border-t border-gray-100 pt-5 gap-3">
            @if(request()->hasAny(['date_from', 'date_to', 'package_id', 'status']))
                <a href="{{ route('owner.reports') }}" class="text-sm font-semibold text-gray-500 hover:text-red-500 transition-colors">
                    Reset Filter
                </a>
            @endif
            <button type="submit" class="admin-btn admin-btn-primary px-6" style="background: linear-gradient(135deg, #EC4899, #E11D48); box-shadow: 0 4px 12px rgba(225,29,72,0.2);">
                <i class="fas fa-search mr-2"></i> Terapkan Filter
            </button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    {{-- Total Revenue --}}
    <div class="admin-float-card flex items-center p-6" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 mr-5" style="background: linear-gradient(135deg, #ECFDF5, #D1FAE5);">
            <i class="fas fa-wallet text-2xl text-emerald-500"></i>
        </div>
        <div>
            <p class="text-gray-400 text-sm font-semibold mb-1 uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-3xl font-extrabold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- This Month Revenue --}}
    <div class="admin-float-card flex items-center p-6" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.1s; opacity: 0;">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 mr-5" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A);">
            <i class="fas fa-calendar-check text-2xl text-amber-500"></i>
        </div>
        <div>
            <p class="text-gray-400 text-sm font-semibold mb-1 uppercase tracking-wider">Pendapatan Bulan Ini</p>
            <h3 class="text-3xl font-extrabold text-gray-900">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

{{-- Transactions Table --}}
<div class="admin-float-card !p-0 overflow-hidden" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.2s; opacity: 0;">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-900">Riwayat Pembayaran Valid</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tgl Bayar</th>
                    <th>Peserta</th>
                    <th>Paket Kursus</th>
                    <th>Jumlah</th>
                    <th class="text-center">Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td class="text-gray-500 text-sm whitespace-nowrap">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <p class="font-bold text-gray-900 text-sm">{{ $payment->registration->user->name ?? 'User dihapus' }}</p>
                    </td>
                    <td>
                        <span class="px-3 py-1 rounded-full bg-pink-50 text-pink-600 text-xs font-semibold">
                            {{ $payment->registration->coursePackage->name ?? 'Paket dihapus' }}
                        </span>
                    </td>
                    <td class="font-bold text-emerald-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>
                        <div class="flex justify-center">
                            @if($payment->proof_of_payment_path)
                                <div class="flex items-center space-x-1.5">
                                    <a href="{{ asset('storage/' . $payment->proof_of_payment_path) }}" target="_blank" class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors" title="Lihat Bukti">
                                        <i class="fas fa-image text-xs"></i>
                                    </a>
                                    <a href="{{ asset('storage/' . $payment->proof_of_payment_path) }}" download class="w-8 h-8 rounded-lg flex items-center justify-center bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors" title="Download Bukti">
                                        <i class="fas fa-download text-xs"></i>
                                    </a>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs italic">Tanpa bukti</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-16">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A);">
                            <i class="fas fa-receipt text-2xl text-amber-500"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Belum ada transaksi</p>
                        <p class="text-gray-400 text-xs">Belum ada pembayaran yang divalidasi sejauh ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($payments->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $payments->links() }}
        </div>
    @endif
</div>

{{-- Layout Khusus Cetak (Hanya tampil saat diprint) --}}
@php
    $dateFrom = request()->filled('date_from') ? \Carbon\Carbon::parse(request()->date_from)->format('d/m/Y') : '';
    $dateTo = request()->filled('date_to') ? \Carbon\Carbon::parse(request()->date_to)->format('d/m/Y') : '';
    $tanggalText = ($dateFrom || $dateTo) ? ($dateFrom ?: 'Awal') . ' s/d ' . ($dateTo ?: 'Sekarang') : 'Semua Waktu';
    
    $paketText = 'Semua Paket';
    if (request()->filled('package_id')) {
        $pkg = \App\Models\CoursePackage::find(request()->package_id);
        if ($pkg) $paketText = $pkg->name;
    }
    
    $statusText = 'Semua Status';
    if (request()->filled('status')) {
        $statusMap = [
            'pending' => 'Menunggu Pembayaran',
            'active' => 'Aktif / Lunas',
            'rejected' => 'Ditolak'
        ];
        $statusText = $statusMap[request()->status] ?? ucfirst(request()->status);
    }
@endphp
<div class="print-only" style="display: none;">
    <h2 class="print-title">LAPORAN KEUANGAN EFA</h2>
    
    <table class="print-info-table">
        <tr>
            <td style="width: 100px;">Periode</td>
            <td style="width: 10px;">:</td>
            <td>{{ $tanggalText }}</td>
        </tr>
        <tr>
            <td>Paket Kursus</td>
            <td>:</td>
            <td>{{ $paketText }}</td>
        </tr>
        <tr>
            <td>Status Transaksi</td>
            <td>:</td>
            <td>{{ $statusText }}</td>
        </tr>
    </table>

    <table class="print-data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal Bayar</th>
                <th width="35%">Peserta</th>
                <th width="20%">Paket Kursus</th>
                <th width="20%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $i => $payment)
            <tr>
                <td style="text-align: center;">{{ $i + 1 }}</td>
                <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $payment->registration->user->name ?? 'User dihapus' }}</td>
                <td>{{ $payment->registration->coursePackage->name ?? 'Paket dihapus' }}</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Total Pendapatan Filter Saat Ini:</td>
                <td style="font-weight: bold;">Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        @page {
            size: portrait;
            margin: 1cm;
        }
        .admin-sidebar, .admin-header, .admin-toast,
        [id="sidebarOverlay"], footer,
        form, .admin-btn, a.admin-btn,
        .admin-float-card, .grid, .no-print {
            display: none !important;
        }
        .admin-bg {
            background: #fff !important;
        }
        .lg\:ml-64 {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .print-only {
            display: block !important;
        }
        .print-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .print-info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 12px;
        }
        .print-info-table td {
            padding: 2px 0;
            border: none;
        }
        .print-data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .print-data-table th, .print-data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        .print-data-table th {
            text-align: center;
            font-weight: bold;
        }
    }
</style>
@endsection
