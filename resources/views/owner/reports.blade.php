@extends('layouts.owner')

@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Analitik pendapatan dan riwayat transaksi sukses')

@section('owner-content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
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
    </div>
</div>

{{-- Search & Filter --}}
<div class="admin-float-card !p-4 mb-6" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
    <form method="GET" action="{{ route('owner.reports') }}" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Dates --}}
            <div>
                <label class="admin-form-label text-xs mb-1.5">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-form-input !py-2 max-w-[200px]">
            </div>
            <div>
                <label class="admin-form-label text-xs mb-1.5">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-form-input !py-2 max-w-[200px]">
            </div>
        </div>
        
        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit" class="admin-btn admin-btn-primary flex-1 md:flex-none">
                <i class="fas fa-filter mr-1.5"></i> Filter
            </button>
            @if(request()->hasAny(['date_from', 'date_to']))
            <a href="{{ route('owner.reports') }}" class="admin-btn admin-btn-outline flex-1 md:flex-none justify-center">
                <i class="fas fa-times"></i>
            </a>
            @endif
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
@endsection
