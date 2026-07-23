@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan Statistik & Data Terbaru')

@section('admin-content')
{{-- Welcome Hero Banner --}}
<div class="relative overflow-hidden rounded-3xl mb-8" style="background: linear-gradient(135deg, #852252 0%, #C74E83 30%, #E8699F 60%, #FF85BB 100%); min-height: 160px;">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full animate-float" style="background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);"></div>
        <div class="absolute bottom-0 -left-16 w-48 h-48 rounded-full animate-float-slow" style="background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>

    <div class="relative z-10 px-8 py-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                <span class="admin-pulse-dot bg-green-300"></span>
                <span class="text-white/80 text-xs font-medium">Admin Panel Aktif</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                Selamat Datang, {{ auth()->user()->name }}! 🛡️
            </h1>
            <p class="text-white/60 mt-2 text-sm max-w-md">Kelola paket kursus, verifikasi pembayaran, dan pantau peserta dari sini.</p>
        </div>
        <a href="{{ route('admin.payments') }}" class="inline-flex items-center px-6 py-3 rounded-xl text-primary-700 font-bold text-sm shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-0.5" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(8px);">
            <i class="fas fa-credit-card mr-2"></i>
            Verifikasi Pembayaran
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-8">
    {{-- Total Paket --}}
    <div class="admin-float-card group cursor-default" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0s; opacity: 0;">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9); box-shadow: 0 4px 16px rgba(199,78,131,0.15);">
                <i class="fas fa-box-open text-primary-700"></i>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Paket Kursus</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $totalPackages }}</p>
        <p class="text-[10px] text-gray-400 mt-1"><span class="text-primary-600 font-bold">{{ $activePackages }}</span> aktif</p>
    </div>

    {{-- Pending Payments --}}
    <div class="admin-float-card group cursor-default" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.08s; opacity: 0;">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A); box-shadow: 0 4px 16px rgba(251,191,36,0.15);">
                <i class="fas fa-clock text-amber-600"></i>
            </div>
            @if($pendingPayments > 0)
            <span class="admin-pulse-dot bg-amber-400 mt-2"></span>
            @endif
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Menunggu Verifikasi</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $pendingPayments }}</p>
        <p class="text-[10px] text-gray-400 mt-1">pembayaran pending</p>
    </div>

    {{-- Valid / Lunas --}}
    <div class="admin-float-card group cursor-default" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.16s; opacity: 0;">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0); box-shadow: 0 4px 16px rgba(16,185,129,0.15);">
                <i class="fas fa-check-circle text-emerald-600"></i>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Pembayaran Valid</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $validPayments }}</p>
        <p class="text-[10px] text-gray-400 mt-1">peserta aktif</p>
    </div>

    {{-- Total Revenue --}}
    <div class="admin-float-card group cursor-default" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.24s; opacity: 0;">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3" style="background: linear-gradient(135deg, #FCE7F3, #FBCFE8); box-shadow: 0 4px 16px rgba(236,72,153,0.12);">
                <i class="fas fa-wallet text-pink-600"></i>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Total Pemasukan</p>
        <p class="text-2xl font-extrabold text-gray-900 mt-1 tabular-nums">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-[10px] text-gray-400 mt-1">dari pembayaran valid</p>
    </div>
</div>

{{-- Quick Actions + Recent Pending --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-5 mb-8">
    {{-- Quick Actions --}}
    <div class="lg:col-span-2">
        <div class="admin-float-card h-full" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.3s; opacity: 0;">
            <div class="flex items-center space-x-2 mb-5">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                    <i class="fas fa-bolt text-xs text-primary-700"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900">Aksi Cepat</h3>
            </div>
            <div class="space-y-2.5">

                <a href="{{ route('admin.payments') }}" class="group flex items-center space-x-4 p-4 rounded-2xl transition-all duration-300 hover:bg-gradient-to-r hover:from-amber-50/80 hover:to-yellow-50/60 border border-transparent hover:border-amber-100">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-amber-200/40" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A);">
                        <i class="fas fa-credit-card text-amber-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-amber-700 transition-colors">Verifikasi Pembayaran</p>
                        <p class="text-gray-400 text-xs mt-0.5">{{ $pendingPayments }} menunggu verifikasi</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-amber-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                <a href="{{ route('admin.reports') }}" class="group flex items-center space-x-4 p-4 rounded-2xl transition-all duration-300 hover:bg-gradient-to-r hover:from-emerald-50/80 hover:to-green-50/60 border border-transparent hover:border-emerald-100">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-emerald-200/40" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                        <i class="fas fa-chart-bar text-emerald-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-emerald-700 transition-colors">Laporan & Export</p>
                        <p class="text-gray-400 text-xs mt-0.5">Download PDF / Excel</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Pending Payments --}}
    <div class="lg:col-span-3">
        <div class="admin-float-card h-full" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.38s; opacity: 0;">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A);">
                        <i class="fas fa-hourglass-half text-xs text-amber-600"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Pembayaran Menunggu Verifikasi</h3>
                </div>
                @if($recentPending->count() > 0)
                <a href="{{ route('admin.payments') }}" class="text-primary-600 text-xs font-bold hover:text-primary-700 transition-colors flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
                @endif
            </div>

            @if($recentPending->count() > 0)
                <div class="space-y-2.5">
                    @foreach($recentPending as $index => $payment)
                    <div class="flex items-center space-x-4 p-3.5 rounded-2xl transition-all duration-300 hover:bg-gray-50/80 group" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ 0.4 + $index * 0.08 }}s; opacity: 0;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-amber-50 ring-1 ring-amber-100 transition-transform duration-300 group-hover:scale-110">
                            <i class="fas fa-receipt text-amber-500 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $payment->registration->user->name }}</p>
                            <p class="text-gray-400 text-xs mt-0.5 truncate">
                                {{ $payment->registration->coursePackage->name }} · <span class="font-mono text-gray-300">{{ $payment->registration->registration_number }}</span>
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <span class="admin-badge admin-badge-pending text-[10px] !px-2 !py-0.5">Pending</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                        <i class="fas fa-check-double text-2xl text-primary-300"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Semua pembayaran sudah diverifikasi</p>
                    <p class="text-gray-400 text-xs">Tidak ada pembayaran pending saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Recent Registrations --}}
<div class="admin-float-card" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.45s; opacity: 0;">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #FCE7F3, #FBCFE8);">
                <i class="fas fa-user-plus text-xs text-pink-600"></i>
            </div>
            <h3 class="text-base font-bold text-gray-900">Registrasi Terbaru</h3>
        </div>
        <a href="{{ route('admin.participants') }}" class="text-primary-600 text-xs font-bold hover:text-primary-700 transition-colors flex items-center space-x-1">
            <span>Lihat Semua</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    @if($recentRegistrations->count() > 0)
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Peserta</th>
                    <th>Paket</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRegistrations as $reg)
                <tr>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                                <i class="fas fa-user text-primary-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $reg->detail ? $reg->detail->name : $reg->user->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $reg->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="font-semibold text-gray-700">{{ $reg->coursePackage->name }}</td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $reg->coursePackage->category === 'kids' ? 'text-purple-600 bg-purple-50' : ($reg->coursePackage->category === 'teens' ? 'text-blue-600 bg-blue-50' : 'text-primary-700 bg-primary-50') }}">
                            {{ $reg->coursePackage->category_label }}
                        </span>
                    </td>
                    <td class="text-gray-500 text-sm">{{ $reg->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="admin-badge {{ $reg->display_status === 'Lunas' ? 'admin-badge-valid' : ($reg->display_status === 'Ditolak' ? 'admin-badge-rejected' : 'admin-badge-pending') }}">
                            {{ $reg->display_status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-10">
        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
            <i class="fas fa-users text-2xl text-primary-300"></i>
        </div>
        <p class="text-gray-500 text-sm font-medium">Belum ada registrasi.</p>
    </div>
    @endif
</div>
@endsection
