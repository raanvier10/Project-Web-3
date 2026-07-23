@extends('layouts.dashboard')

@section('page-title', 'Riwayat Transaksi')

@section('dashboard-content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(255,133,187,0.08), rgba(199,78,131,0.04)); border: 1px solid rgba(255,133,187,0.12);">
            <i class="fas fa-receipt text-primary-500 text-xs"></i>
            <span class="text-primary-600 text-xs font-semibold">Semua Transaksi</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Riwayat Transaksi</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Pantau semua pendaftaran dan status pembayaran Anda.</p>
    </div>
    <a href="{{ route('dashboard.packages') }}"
       class="inline-flex items-center px-6 py-3 rounded-xl text-white font-bold text-sm transition-all duration-300 transform hover:-translate-y-0.5 relative overflow-hidden group"
       style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);"
       id="btn-new-registration">
        <span class="relative z-10 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            <span class="hidden sm:inline">Daftar Baru</span>
        </span>
        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
    </a>
</div>

@if($registrations->count() > 0)
    {{-- Status Filter Tabs --}}
    <div class="mb-6 overflow-x-auto pb-2 -mx-1">
        <div class="inline-flex items-center space-x-1.5 p-1.5 rounded-2xl" style="background: rgba(255,255,255,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(0,0,0,0.04);">
            <button onclick="filterTransactions('all')" class="filter-tab active" data-filter="all">
                Semua <span class="ml-1 px-1.5 py-0.5 rounded-md bg-white/60 text-[10px] font-bold text-gray-500">{{ $registrations->count() }}</span>
            </button>
            <button onclick="filterTransactions('Menunggu Pembayaran')" class="filter-tab" data-filter="Menunggu Pembayaran">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 mr-1.5 inline-block"></span> Bayar
            </button>
            <button onclick="filterTransactions('Menunggu Verifikasi')" class="filter-tab" data-filter="Menunggu Verifikasi">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 mr-1.5 inline-block"></span> Verifikasi
            </button>
            <button onclick="filterTransactions('Lunas')" class="filter-tab" data-filter="Lunas">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 inline-block"></span> Lunas
            </button>
            <button onclick="filterTransactions('Ditolak')" class="filter-tab" data-filter="Ditolak">
                <span class="w-1.5 h-1.5 rounded-full bg-red-400 mr-1.5 inline-block"></span> Ditolak
            </button>
        </div>
    </div>

    {{-- Transaction Cards --}}
    <div class="space-y-4" id="transactionsGrid">
        @foreach($registrations as $index => $reg)
        <div class="transaction-card" data-status="{{ $reg->display_status }}" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ $index * 0.08 }}s; opacity: 0;">
            <div class="float-card !p-5 hover:!shadow-xl">
                <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                    {{-- Left: Package Info --}}
                    <div class="flex items-start space-x-4 flex-1 min-w-0">
                        <div class="w-13 h-13 rounded-2xl flex items-center justify-center flex-shrink-0 transition-transform duration-300 hover:scale-110" style="width: 52px; height: 52px; {{ $reg->coursePackage->category === 'kids' ? 'background: linear-gradient(135deg, #F3E8FF, #E9D5FF); box-shadow: 0 4px 12px rgba(139,92,246,0.1);' : ($reg->coursePackage->category === 'teens' ? 'background: linear-gradient(135deg, #DBEAFE, #BFDBFE); box-shadow: 0 4px 12px rgba(59,130,246,0.1);' : 'background: linear-gradient(135deg, #FFE0EC, #FFC2D9); box-shadow: 0 4px 12px rgba(255,133,187,0.1);') }}">
                            <i class="fas {{ $reg->coursePackage->category === 'kids' ? 'fa-child text-purple-500' : ($reg->coursePackage->category === 'teens' ? 'fa-user-friends text-blue-500' : 'fa-user-graduate text-primary-500') }} text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center flex-wrap gap-2 mb-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $reg->coursePackage->category === 'kids' ? 'text-purple-600 bg-purple-50' : ($reg->coursePackage->category === 'teens' ? 'text-blue-600 bg-blue-50' : 'text-primary-600 bg-primary-50') }}">
                                    {{ $reg->coursePackage->category_label }}
                                </span>
                                <span class="text-xs text-gray-300 font-mono">{{ $reg->registration_number }}</span>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 truncate">{{ $reg->coursePackage->name }}</h3>
                            <p class="text-gray-400 text-xs mt-0.5 flex items-center flex-wrap gap-x-2">
                                <span><i class="fas fa-calendar mr-1"></i>{{ $reg->created_at->format('d M Y, H:i') }}</span>
                                @if($reg->detail)
                                <span><i class="fas fa-user mr-1"></i>{{ $reg->detail->name }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Center: Progress Mini Tracker --}}
                    <div class="flex items-center space-x-1 px-3 flex-shrink-0">
                        @php $step = $reg->progress_step; @endphp
                        @for($i = 1; $i <= 4; $i++)
                        <div class="flex items-center">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold transition-all duration-300
                                {{ $step >= $i ? ($i === 3 && $reg->display_status === 'Ditolak' ? 'bg-red-500 text-white' : ($i === 4 ? 'text-white' : 'text-white')) : 'bg-gray-100 text-gray-400' }}"
                                @if($step >= $i)
                                    @if($i === 3 && $reg->display_status === 'Ditolak')
                                        {{-- red is already set above --}}
                                    @elseif($i === 4)
                                        style="background: linear-gradient(135deg, #10B981, #34D399);"
                                    @else
                                        style="background: linear-gradient(135deg, #E8699F, #FF85BB);"
                                    @endif
                                @endif>
                                @if($i === 3 && $reg->display_status === 'Ditolak')
                                    <i class="fas fa-times"></i>
                                @elseif($step >= $i)
                                    <i class="fas fa-check"></i>
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                            @if($i < 4)
                            <div class="w-4 h-[2px] rounded {{ $step > $i ? 'bg-primary-300' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                        @endfor
                    </div>

                    {{-- Right: Price + Status + Action --}}
                    <div class="flex items-center gap-3 lg:flex-col lg:items-end lg:gap-2">
                        <p class="text-lg font-extrabold text-gray-900">{{ $reg->coursePackage->formatted_price }}</p>
                        <span class="status-badge {{ $reg->status_badge_class }}">
                            {{ $reg->display_status }}
                        </span>
                        @if($reg->display_status === 'Menunggu Pembayaran')
                        <a href="{{ route('dashboard.payment', $reg->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold text-white transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #E8699F, #FF85BB);">
                            <i class="fas fa-credit-card mr-1.5"></i> Bayar
                        </a>
                        @elseif($reg->display_status === 'Ditolak')
                        <a href="{{ route('dashboard.payment', $reg->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold text-white bg-red-500 hover:bg-red-600 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                            <i class="fas fa-redo mr-1.5"></i> Upload Ulang
                        </a>
                        @elseif($reg->display_status === 'Menunggu Verifikasi')
                        <a href="{{ route('dashboard.payment', $reg->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold text-blue-600 transition-all hover:shadow-sm" style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE);">
                            <i class="fas fa-eye mr-1.5"></i> Lihat
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Rejection note --}}
                @if($reg->display_status === 'Ditolak' && $reg->payment && $reg->payment->admin_notes)
                <div class="mt-4 p-3.5 rounded-xl flex items-start space-x-2.5" style="background: linear-gradient(135deg, rgba(239,68,68,0.04), rgba(252,165,165,0.02)); border: 1px solid rgba(239,68,68,0.1);">
                    <i class="fas fa-exclamation-triangle text-red-400 text-sm mt-0.5"></i>
                    <p class="text-xs text-red-600">
                        <strong>Catatan Admin:</strong> {{ $reg->payment->admin_notes }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@else
    {{-- Empty State --}}
    <div class="float-card text-center py-20">
        <div class="relative w-28 h-28 mx-auto mb-6">
            <div class="absolute inset-0 rounded-full animate-pulse-glow" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);"></div>
            <div class="relative w-28 h-28 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #FFF0F6, #FFE0EC);">
                <i class="fas fa-inbox text-4xl text-primary-300"></i>
            </div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Transaksi</h3>
        <p class="text-gray-400 text-sm mb-8 max-w-sm mx-auto">Anda belum memiliki transaksi. Mulai dengan memilih paket kursus yang tersedia.</p>
        <a href="{{ route('dashboard.packages') }}"
           class="inline-flex items-center px-8 py-3.5 rounded-xl text-white font-bold text-sm transition-all duration-300 transform hover:-translate-y-0.5 relative overflow-hidden group"
           style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);">
            <span class="relative z-10 flex items-center">
                <i class="fas fa-book-open mr-2"></i> Lihat Paket Kursus
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
        </a>
    </div>
@endif
@endsection

@section('scripts')
<script>
    function filterTransactions(status) {
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.filter === status);
