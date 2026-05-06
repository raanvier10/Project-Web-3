@extends('layouts.dashboard')

@section('page-title', 'Overview')

@section('dashboard-content')
<div class="page-enter space-y-8">
    <section class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-gray-400">Overview</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Selamat Datang, {{ $user->name }}! 👋
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-gray-400 sm:text-base">
                Kelola program kursus dan pembayaran Anda di sini.
            </p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <article class="float-card glow-stat group cursor-default h-full">
            <div class="mb-3 flex items-start justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9); box-shadow: 0 4px 16px rgba(255,133,187,0.2);">
                    <i class="fas fa-book-open text-primary-600"></i>
                </div>
            </div>
            <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Total Paket</p>
            <p class="mt-1 text-3xl font-extrabold tabular-nums text-gray-900">{{ $totalPackages }}</p>
        </article>

        <article class="float-card glow-stat group cursor-default h-full">
            <div class="mb-3 flex items-start justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A); box-shadow: 0 4px 16px rgba(251,191,36,0.15);">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
                @if($pendingPayments > 0)
                    <span class="pulse-dot mt-2 mr-1 bg-amber-400"></span>
                @endif
            </div>
            <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Menunggu Bayar</p>
            <p class="mt-1 text-3xl font-extrabold tabular-nums text-gray-900">{{ $pendingPayments }}</p>
        </article>

        <article class="float-card glow-stat group cursor-default h-full">
            <div class="mb-3 flex items-start justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE); box-shadow: 0 4px 16px rgba(59,130,246,0.12);">
                    <i class="fas fa-hourglass-half text-blue-600"></i>
                </div>
                @if($verifyingPayments > 0)
                    <span class="pulse-dot mt-2 mr-1 bg-blue-400"></span>
                @endif
            </div>
            <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Verifikasi</p>
            <p class="mt-1 text-3xl font-extrabold tabular-nums text-gray-900">{{ $verifyingPayments }}</p>
        </article>

        <article class="float-card glow-stat group cursor-default h-full">
            <div class="mb-3 flex items-start justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0); box-shadow: 0 4px 16px rgba(16,185,129,0.15);">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                </div>
            </div>
            <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Lunas</p>
            <p class="mt-1 text-3xl font-extrabold tabular-nums text-gray-900">{{ $paidCount }}</p>
        </article>
    </section>

    <section class="grid grid-cols-1 gap-5 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div class="float-card h-full">
                <div class="mb-5 flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                        <i class="fas fa-bolt text-xs text-primary-600"></i>
                    </div>
                    <h2 class="text-base font-bold text-gray-900">Aksi Cepat</h2>
                </div>

                <div class="space-y-2.5">
                    <a href="{{ route('dashboard.packages') }}" class="group flex items-center space-x-4 rounded-2xl border border-transparent p-4 transition-all duration-300 hover:border-primary-100 hover:bg-gradient-to-r hover:from-primary-50/80 hover:to-pink-50/60">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-primary-200/40" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                            <i class="fas fa-plus text-primary-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900 transition-colors group-hover:text-primary-700">Daftar Paket Baru</p>
                            <p class="mt-0.5 text-xs text-gray-400">Lihat dan pilih paket kursus</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300 transition-all group-hover:translate-x-1 group-hover:text-primary-400"></i>
                    </a>

                    <a href="{{ route('dashboard.transactions') }}" class="group flex items-center space-x-4 rounded-2xl border border-transparent p-4 transition-all duration-300 hover:border-blue-100 hover:bg-gradient-to-r hover:from-blue-50/80 hover:to-indigo-50/60">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-blue-200/40" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                            <i class="fas fa-receipt text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900 transition-colors group-hover:text-blue-700">Riwayat Transaksi</p>
                            <p class="mt-0.5 text-xs text-gray-400">Lihat semua transaksi Anda</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300 transition-all group-hover:translate-x-1 group-hover:text-blue-400"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="float-card h-full">
                <div class="mb-5 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg" style="background: linear-gradient(135deg, #F3E8FF, #E9D5FF);">
                            <i class="fas fa-history text-xs text-purple-600"></i>
                        </div>
                        <h2 class="text-base font-bold text-gray-900">Transaksi Terbaru</h2>
                    </div>

                    @if($registrations->count() > 0)
                        <a href="{{ route('dashboard.transactions') }}" class="flex items-center gap-1 text-xs font-bold text-primary-600 transition-colors hover:text-primary-700">
                            <span>Lihat Semua</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    @endif
                </div>

                @if($registrations->count() > 0)
                    <div class="space-y-2.5">
                        @foreach($registrations->take(3) as $index => $registration)
                            <div class="flex items-center space-x-4 rounded-2xl p-3.5 transition-all duration-300 hover:bg-gray-50/80 group" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ $index * 0.1 }}s; opacity: 0;">
                                <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl transition-transform duration-300 group-hover:scale-110 {{ $registration->coursePackage->category === 'kids' ? 'bg-purple-50 ring-1 ring-purple-100' : 'bg-primary-50 ring-1 ring-primary-100' }}">
                                    <i class="fas {{ $registration->coursePackage->category === 'kids' ? 'fa-child text-purple-500' : 'fa-user-graduate text-primary-500' }} text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-bold text-gray-900">{{ $registration->coursePackage->name }}</p>
                                    <p class="mt-0.5 text-xs text-gray-400">{{ $registration->created_at->format('d M Y') }} · <span class="font-mono text-gray-300">{{ $registration->registration_number }}</span></p>
                                </div>
                                <span class="status-badge {{ $registration->status_badge_class }}">
                                    {{ $registration->display_status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-10 text-center">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full" style="background: linear-gradient(135deg, #FFF0F6, #FFE0EC);">
                            <i class="fas fa-inbox text-2xl text-primary-300"></i>
                        </div>
                        <p class="mb-1 text-sm font-medium text-gray-500">Belum ada transaksi</p>
                        <p class="mb-4 text-xs text-gray-400">Mulai dengan memilih paket kursus</p>
                        <a href="{{ route('dashboard.packages') }}" class="inline-flex items-center text-sm font-bold text-primary-600 transition-colors hover:text-primary-700">
                            <i class="fas fa-plus mr-1.5"></i> Daftar Paket Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
