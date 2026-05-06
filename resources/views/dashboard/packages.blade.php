@extends('layouts.dashboard')

@section('page-title', 'Paket Kursus')

@section('dashboard-content')
{{-- Page Header with decorative --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(255,133,187,0.08), rgba(199,78,131,0.04)); border: 1px solid rgba(255,133,187,0.12);">
            <i class="fas fa-book-open text-primary-500 text-xs"></i>
            <span class="text-primary-600 text-xs font-semibold">Program Tersedia</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Paket Kursus</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Pilih paket kursus bahasa Inggris yang sesuai untuk Anda.</p>
    </div>
</div>

{{-- Category Filter Tabs --}}
<div class="tab-rail mb-8 inline-flex">
    <button onclick="filterPackages('all')" class="filter-tab active" id="filter-all" data-filter="all">
        <i class="fas fa-th-large mr-1.5 text-xs"></i> Semua
    </button>
    <button onclick="filterPackages('kids')" class="filter-tab" id="filter-kids" data-filter="kids">
        <i class="fas fa-child mr-1.5 text-xs"></i> Kids
    </button>
    <button onclick="filterPackages('adult')" class="filter-tab" id="filter-adult" data-filter="adult">
        <i class="fas fa-user-graduate mr-1.5 text-xs"></i> Adult
    </button>
</div>

{{-- Packages Grid --}}
@if($packages->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="packagesGrid">
    @foreach($packages as $index => $package)
    <div class="course-card-premium" data-category="{{ $package->category }}" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ $index * 0.12 }}s; opacity: 0;">
        <div class="float-card relative overflow-hidden group">
            {{-- Decorative corner gradient --}}
            <div class="absolute -top-20 -right-20 w-40 h-40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: radial-gradient(circle, {{ $package->category === 'kids' ? 'rgba(139,92,246,0.06)' : 'rgba(255,133,187,0.08)' }} 0%, transparent 70%);"></div>

            {{-- Top: Category + Slot --}}
            <div class="flex items-center justify-between mb-5">
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $package->category === 'kids' ? 'text-purple-700' : 'text-primary-700' }}" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #F3E8FF, #E9D5FF)' : 'linear-gradient(135deg, #FFE0EC, #FFC2D9)' }};">
                    <i class="fas {{ $package->category === 'kids' ? 'fa-child' : 'fa-user-graduate' }} mr-1.5"></i>
                    {{ $package->category_label }}
                </span>
                @if($package->amount > 0)
                <div class="flex items-center space-x-1.5 text-xs text-gray-400">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                    <span>{{ $package->amount }} slot</span>
                </div>
                @endif
            </div>

            {{-- Package Name --}}
            <h3 class="text-xl font-extrabold text-gray-900 mb-2 group-hover:text-primary-700 transition-colors">{{ $package->name }}</h3>

            {{-- Description --}}
            <p class="text-gray-500 text-sm leading-relaxed mb-5">{{ $package->descriptions }}</p>

            {{-- Price --}}
            <div class="mb-6 flex items-end space-x-2">
                <p class="text-3xl font-extrabold" style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    {{ $package->formatted_price }}
                </p>
                <span class="text-gray-400 text-xs mb-1.5 font-medium">/program</span>
            </div>

            {{-- Features --}}
            @if($package->features)
            <div class="pt-5 mb-6" style="border-top: 1px dashed rgba(0,0,0,0.06);">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em] mb-3">Fasilitas Program</p>
                <div class="grid grid-cols-1 gap-2">
                    @foreach(explode('|', $package->features) as $feature)
                    <div class="flex items-center space-x-2.5 text-sm text-gray-600">
                        <div class="w-5 h-5 rounded-md flex items-center justify-center flex-shrink-0" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #F3E8FF, #E9D5FF)' : 'linear-gradient(135deg, #FFE0EC, #FFC2D9)' }};">
                            <i class="fas fa-check text-[9px] {{ $package->category === 'kids' ? 'text-purple-600' : 'text-primary-600' }}"></i>
                        </div>
                        <span>{{ trim($feature) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- CTA Button --}}
            <a href="{{ route('dashboard.register', $package->id) }}"
               class="w-full inline-flex items-center justify-center px-6 py-4 rounded-2xl text-white font-bold text-sm transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 group/btn relative overflow-hidden"
               style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);"
               id="register-pkg-{{ $package->id }}">
                <span class="relative z-10 flex items-center">
                    <i class="fas fa-pen-to-square mr-2"></i>
                    Daftar Sekarang
                    <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="float-card text-center py-16">
    <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-5" style="background: linear-gradient(135deg, #FFF0F6, #FFE0EC);">
        <i class="fas fa-box-open text-3xl text-primary-300"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Paket</h3>
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

        document.querySelectorAll('.course-card-premium').forEach((card, i) => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = '';
                card.style.animation = 'none';
                card.offsetHeight; // trigger reflow
                card.style.animation = `pageEnter 0.4s ease forwards`;
                card.style.animationDelay = `${i * 0.08}s`;
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection