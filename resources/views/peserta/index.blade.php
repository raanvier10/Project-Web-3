@extends('layouts.dashboard')

@section('page-title', 'Overview')

@section('dashboard-content')
{{-- Welcome Hero Banner --}}
<div class="relative overflow-hidden rounded-3xl mb-8" style="background: linear-gradient(135deg, #C74E83 0%, #E8699F 30%, #FF85BB 60%, #FFA3C7 100%); min-height: 180px;">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full animate-float" style="background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);"></div>
        <div class="absolute bottom-0 -left-16 w-48 h-48 rounded-full animate-float-slow" style="background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>

    <div class="relative z-10 px-8 py-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                <span class="pulse-dot bg-green-300"></span>
                <span class="text-white/80 text-xs font-medium">Dashboard Aktif</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                Selamat Datang, {{ $user->name }}! 👋
            </h1>
            <p class="text-white/60 mt-2 text-sm max-w-md">Kelola program kursus dan pembayaran Anda dengan mudah melalui dashboard ini.</p>
        </div>
        <a href="{{ route('dashboard.packages') }}" class="inline-flex items-center px-6 py-3 rounded-xl text-primary-700 font-bold text-sm shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-0.5" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(8px);">
            <i class="fas fa-plus mr-2"></i>
            Daftar Paket Baru
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-8">
    {{-- Total Paket --}}
    <div class="float-card glow-stat group cursor-default">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9); box-shadow: 0 4px 16px rgba(255,133,187,0.2);">
                <i class="fas fa-book-open text-primary-600"></i>
            </div>
            <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center">
                <i class="fas fa-arrow-trend-up text-xs text-primary-400"></i>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Total Paket</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $totalPackages }}</p>
    </div>

    {{-- Menunggu Bayar --}}
    <div class="float-card glow-stat group cursor-default">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A); box-shadow: 0 4px 16px rgba(251,191,36,0.15);">
                <i class="fas fa-clock text-amber-600"></i>
            </div>
            @if($pendingPayments > 0)
            <span class="pulse-dot bg-amber-400 mt-2 mr-1"></span>
            @endif
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Menunggu Bayar</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $pendingPayments }}</p>
    </div>

    {{-- Menunggu Verifikasi --}}
    <div class="float-card glow-stat group cursor-default">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE); box-shadow: 0 4px 16px rgba(59,130,246,0.12);">
                <i class="fas fa-hourglass-half text-blue-600"></i>
            </div>
            @if($verifyingPayments > 0)
            <span class="pulse-dot bg-blue-400 mt-2 mr-1"></span>
            @endif
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Verifikasi</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $verifyingPayments }}</p>
    </div>

    {{-- Lunas --}}
    <div class="float-card glow-stat group cursor-default">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0); box-shadow: 0 4px 16px rgba(16,185,129,0.15);">
                <i class="fas fa-check-circle text-emerald-600"></i>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">Lunas</p>
        <p class="text-3xl font-extrabold text-gray-900 mt-1 tabular-nums">{{ $paidCount }}</p>
    </div>
</div>

{{-- Quick Actions + Recent Transactions --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
    {{-- Quick Actions --}}
    <div class="lg:col-span-2">
        <div class="float-card h-full">
            <div class="flex items-center space-x-2 mb-5">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                    <i class="fas fa-bolt text-xs text-primary-600"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900">Aksi Cepat</h3>
            </div>
            <div class="space-y-2.5">
                <a href="{{ route('dashboard.packages') }}" class="group flex items-center space-x-4 p-4 rounded-2xl transition-all duration-300 hover:bg-gradient-to-r hover:from-primary-50/80 hover:to-pink-50/60 border border-transparent hover:border-primary-100" id="action-packages">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-primary-200/40" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                        <i class="fas fa-plus text-primary-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-primary-700 transition-colors">Daftar Paket Baru</p>
                        <p class="text-gray-400 text-xs mt-0.5">Lihat dan pilih paket kursus</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-primary-400 group-hover:translate-x-1 transition-all"></i>
                </a>
                <a href="{{ route('dashboard.transactions') }}" class="group flex items-center space-x-4 p-4 rounded-2xl transition-all duration-300 hover:bg-gradient-to-r hover:from-blue-50/80 hover:to-indigo-50/60 border border-transparent hover:border-blue-100" id="action-transactions">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-blue-200/40" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                        <i class="fas fa-receipt text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition-colors">Riwayat Transaksi</p>
                        <p class="text-gray-400 text-xs mt-0.5">Lihat semua transaksi Anda</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-blue-400 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="lg:col-span-3">
        <div class="float-card h-full">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #F3E8FF, #E9D5FF);">
                        <i class="fas fa-history text-xs text-purple-600"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Transaksi Terbaru</h3>
                </div>
                @if($registrations->count() > 0)
                <a href="{{ route('dashboard.transactions') }}" class="text-primary-600 text-xs font-bold hover:text-primary-700 transition-colors flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
                @endif
            </div>

            @if($registrations->count() > 0)
                <div class="space-y-2.5">
                    @foreach($registrations->take(3) as $index => $reg)
                    <div class="flex items-center space-x-4 p-3.5 rounded-2xl transition-all duration-300 hover:bg-gray-50/80 group" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform duration-300 group-hover:scale-110 {{ $reg->coursePackage->category === 'kids' ? 'bg-purple-50 ring-1 ring-purple-100' : ($reg->coursePackage->category === 'teens' ? 'bg-blue-50 ring-1 ring-blue-100' : 'bg-primary-50 ring-1 ring-primary-100') }}">
                            <i class="fas {{ $reg->coursePackage->category === 'kids' ? 'fa-child text-purple-500' : ($reg->coursePackage->category === 'teens' ? 'fa-user-friends text-blue-500' : 'fa-user-graduate text-primary-500') }} text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $reg->coursePackage->name }}</p>
                            <p class="text-gray-400 text-xs mt-0.5">{{ $reg->created_at->format('d M Y') }} · <span class="font-mono text-gray-300">{{ $reg->registration_number }}</span></p>
                        </div>
                        <span class="status-badge {{ $reg->status_badge_class }}">
                            {{ $reg->display_status }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #FFF0F6, #FFE0EC);">
                        <i class="fas fa-inbox text-2xl text-primary-300"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Belum ada transaksi</p>
                    <p class="text-gray-400 text-xs mb-4">Mulai dengan memilih paket kursus</p>
                    <a href="{{ route('dashboard.packages') }}" class="inline-flex items-center text-primary-600 text-sm font-bold hover:text-primary-700 transition-colors">
                        <i class="fas fa-plus mr-1.5"></i> Daftar Paket Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
