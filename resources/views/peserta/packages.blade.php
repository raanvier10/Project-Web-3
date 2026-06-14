@extends('layouts.dashboard')

@section('page-title', 'Pilih Paket Kursus')

@section('dashboard-content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(255,133,187,0.08), rgba(199,78,131,0.04)); border: 1px solid rgba(255,133,187,0.12);">
            <i class="fas fa-box-open text-primary-500 text-xs"></i>
            <span class="text-primary-600 text-xs font-semibold">Paket Kursus</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Pilih Paket Kursus</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Pilih paket kursus bahasa Inggris yang sesuai dengan kebutuhan Anda.</p>
    </div>
    <a href="{{ route('dashboard.transactions') }}"
       class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold text-gray-600 transition-all duration-300 hover:bg-gray-100 border border-gray-200"
       id="btn-my-transactions">
        <i class="fas fa-receipt mr-2"></i>
        Transaksi Saya
    </a>
</div>

{{-- Category Tabs --}}
<div class="mb-6 overflow-x-auto pb-2 -mx-1">
    <div class="inline-flex items-center space-x-1.5 p-1.5 rounded-2xl" style="background: rgba(255,255,255,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(0,0,0,0.04);">
        <button onclick="filterPackages('all')" class="filter-tab active" data-filter="all" id="filter-all">
            Semua Paket
        </button>
        <button onclick="filterPackages('adult')" class="filter-tab" data-filter="adult" id="filter-adult">
            <span class="w-1.5 h-1.5 rounded-full bg-primary-400 mr-1.5 inline-block"></span> Dewasa
        </button>
        <button onclick="filterPackages('kids')" class="filter-tab" data-filter="kids" id="filter-kids">
            <span class="w-1.5 h-1.5 rounded-full bg-purple-400 mr-1.5 inline-block"></span> Kids
        </button>
    </div>
</div>

@if($packages->count() > 0)
    {{-- Package Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5" id="packagesGrid">
        @foreach($packages as $index => $package)
        <div class="package-item" data-category="{{ $package->category }}" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ $index * 0.08 }}s; opacity: 0;">
            <div class="float-card h-full flex flex-col !p-0 overflow-hidden group">
                {{-- Card Header with Gradient --}}
                <div class="relative p-6 pb-4" style="background: linear-gradient(135deg, {{ $package->category === 'kids' ? 'rgba(139,92,246,0.06), rgba(243,232,255,0.8)' : 'rgba(255,133,187,0.06), rgba(255,240,246,0.8)' }});">
                    {{-- Category Badge --}}
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $package->category === 'kids' ? 'text-purple-700 bg-purple-100' : 'text-primary-700 bg-primary-100' }}">
                            <i class="fas {{ $package->category === 'kids' ? 'fa-child' : 'fa-user-graduate' }} mr-1.5"></i>
                            {{ $package->category_label }}
                        </span>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-6" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #E9D5FF, #D8B4FE)' : 'linear-gradient(135deg, #FFC2D9, #FFA3C7)' }}; box-shadow: 0 4px 12px {{ $package->category === 'kids' ? 'rgba(139,92,246,0.15)' : 'rgba(199,78,131,0.15)' }};">
                            <i class="fas fa-book-open text-sm {{ $package->category === 'kids' ? 'text-purple-600' : 'text-primary-600' }}"></i>
                        </div>
                    </div>

                    {{-- Package Name --}}
                    <h3 class="text-lg font-extrabold text-gray-900 mb-1 group-hover:text-primary-700 transition-colors">{{ $package->name }}</h3>

                    {{-- Price --}}
                    <div class="flex items-baseline space-x-1">
                        <span class="text-2xl font-extrabold" style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $package->formatted_price }}
                        </span>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 pt-4 flex-1 flex flex-col">
                    {{-- Features --}}
                    <div class="space-y-3 mb-6 flex-1">
                        <div class="flex items-center space-x-3">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                                <i class="fas fa-calendar-check text-[10px] text-primary-600"></i>
                            </div>
                            <span class="text-sm text-gray-600"><strong class="text-gray-800">{{ $package->amount }}</strong> pertemuan</span>
                        </div>

                        @if($package->descriptions)
                        <div class="flex items-start space-x-3">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                                <i class="fas fa-info text-[10px] text-blue-600"></i>
                            </div>
                            <span class="text-sm text-gray-500 leading-relaxed">{{ $package->descriptions }}</span>
                        </div>
                        @endif

                        <div class="flex items-center space-x-3">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                                <i class="fas fa-check text-[10px] text-emerald-600"></i>
                            </div>
                            <span class="text-sm text-gray-600">Sertifikat kelulusan</span>
                        </div>
                    </div>

                    {{-- Register Button --}}
                    @if($package->is_active)
                    <a href="{{ route('dashboard.register', $package->id) }}"
                       class="w-full py-3.5 rounded-xl text-white font-bold text-sm text-center transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 relative overflow-hidden group/btn flex items-center justify-center"
                       style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);"
                       id="btn-register-{{ $package->id }}">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Daftar Sekarang
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                    @else
                    <button type="button" disabled
                        class="w-full py-3.5 rounded-xl font-bold text-sm flex items-center justify-center cursor-not-allowed"
                        style="background: linear-gradient(135deg, #E5E7EB, #D1D5DB); color: #9CA3AF;"
                        id="btn-register-{{ $package->id }}">
                        <i class="fas fa-ban mr-2 opacity-60"></i>
                        Tidak Tersedia
                    </button>
                    @endif
                </div>
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
                <i class="fas fa-box-open text-4xl text-primary-300"></i>
            </div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Paket Tersedia</h3>
        <p class="text-gray-400 text-sm max-w-sm mx-auto">Paket kursus sedang dalam persiapan. Silakan cek kembali nanti.</p>
    </div>
@endif
@endsection

@section('scripts')
<script>
    function filterPackages(category) {
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.filter === category);
        });
        document.querySelectorAll('.package-item').forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = '';
                card.style.animation = 'pageEnter 0.4s ease forwards';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection
