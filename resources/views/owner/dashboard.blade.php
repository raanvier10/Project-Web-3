@extends('layouts.owner')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan operasional dan staff')

@section('owner-content')
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
                <span class="text-white/80 text-xs font-medium">Owner Panel Aktif</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                Selamat Datang, {{ auth()->user()->name }}!
            </h1>
            <p class="text-white/60 mt-2 text-sm max-w-md">Pantau operasional, pantau pembayaran, dan kelola staff dari sini.</p>
        </div>
        <a href="{{ route('owner.staff') }}" class="inline-flex items-center px-6 py-3 rounded-xl text-primary-700 font-bold text-sm shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-0.5" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(8px);">
            <i class="fas fa-user-gear mr-2"></i>
            Kelola Staff
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-8">
    {{-- Total Staff --}}
    <div class="admin-float-card group cursor-default" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0s; opacity: 0;">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE); box-shadow: 0 4px 16px rgba(59,130,246,0.15);">
                <i class="fas fa-user-gear text-blue-600"></i>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Staff</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $totalStaff }}</p>
        <p class="text-[10px] text-gray-400 mt-1">akun staff aktif</p>
    </div>

    {{-- Total Paket --}}
    <div class="admin-float-card group cursor-default" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.08s; opacity: 0;">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9); box-shadow: 0 4px 16px rgba(199,78,131,0.15);">
                <i class="fas fa-box-open text-primary-700"></i>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Paket Kursus</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $totalPackages }}</p>
        <p class="text-[10px] text-gray-400 mt-1"><span class="text-primary-600 font-bold">{{ $activePackages }}</span> aktif</p>
    </div>

    {{-- Pending Payments --}}
    <div class="admin-float-card group cursor-default" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.16s; opacity: 0;">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A); box-shadow: 0 4px 16px rgba(251,191,36,0.15);">
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

{{-- Quick Actions + Recent Staff --}}
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
                <a href="{{ route('owner.staff') }}" class="group flex items-center space-x-4 p-4 rounded-2xl transition-all duration-300 hover:bg-gradient-to-r hover:from-blue-50/80 hover:to-primary-50/60 border border-transparent hover:border-primary-100">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-blue-200/40" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                        <i class="fas fa-user-gear text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition-colors">Kelola Staff</p>
                        <p class="text-gray-400 text-xs mt-0.5">Tambah, edit, atau hapus akun staff</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-blue-400 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Staff --}}
    <div class="lg:col-span-3">
        <div class="admin-float-card h-full" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.38s; opacity: 0;">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                        <i class="fas fa-user-plus text-xs text-blue-600"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Staff Terbaru</h3>
                </div>
                @if($recentStaff->count() > 0)
                <a href="{{ route('owner.staff') }}" class="text-primary-600 text-xs font-bold hover:text-primary-700 transition-colors flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
                @endif
            </div>

            @if($recentStaff->count() > 0)
                <div class="space-y-2.5">
                    @foreach($recentStaff as $index => $staff)
                    <div class="flex items-center space-x-4 p-3.5 rounded-2xl transition-all duration-300 hover:bg-gray-50/80 group" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ 0.4 + $index * 0.08 }}s; opacity: 0;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-blue-50 ring-1 ring-blue-100 transition-transform duration-300 group-hover:scale-110">
                            <i class="fas fa-user text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $staff->name }}</p>
                            <p class="text-gray-400 text-xs mt-0.5 truncate">{{ $staff->email }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-xs text-gray-400">{{ $staff->created_at->format('d M Y') }}</p>
                            <span class="admin-badge admin-badge-active text-[10px] !px-2 !py-0.5">Staff</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                        <i class="fas fa-user-plus text-2xl text-blue-300"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Belum ada staff</p>
                    <p class="text-gray-400 text-xs">Tambahkan akun staff untuk mulai mengelola tim.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
