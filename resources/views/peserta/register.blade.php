@extends('layouts.dashboard')

@section('page-title', 'Formulir Pendaftaran')

@section('dashboard-content')
{{-- Breadcrumb --}}
<div class="flex items-center space-x-2.5 text-sm mb-7">
    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-primary-600 transition-colors flex items-center space-x-1.5">
        <i class="fas fa-th-large text-xs"></i>
        <span>Dashboard</span>
    </a>
    <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
    <a href="{{ route('dashboard.packages') }}" class="text-gray-400 hover:text-primary-600 transition-colors">Paket Kursus</a>
    <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
    <span class="text-gray-700 font-semibold">Pendaftaran</span>
</div>

<div class="max-w-3xl mx-auto">
    {{-- Package Info Card --}}
    <div class="float-card mb-6 !p-5" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 transition-all duration-300 hover:scale-110" style="background: linear-gradient(135deg, {{ $package->category === 'kids' ? '#F3E8FF, #E9D5FF' : '#FFE0EC, #FFC2D9' }}); box-shadow: 0 4px 16px {{ $package->category === 'kids' ? 'rgba(139,92,246,0.12)' : 'rgba(199,78,131,0.12)' }};">
                <i class="fas {{ $package->category === 'kids' ? 'fa-child text-purple-500' : 'fa-user-graduate text-primary-600' }} text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center flex-wrap gap-2 mb-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $package->category === 'kids' ? 'text-purple-600 bg-purple-50' : 'text-primary-700 bg-primary-50' }}">
                        <i class="fas {{ $package->category === 'kids' ? 'fa-child' : 'fa-user-graduate' }} mr-1"></i>
                        {{ $package->category_label }}
                    </span>
                    <span class="text-gray-300 text-xs">•</span>
                    <span class="text-gray-400 text-xs">{{ $package->amount }} pertemuan</span>
                </div>
                <h2 class="text-lg font-extrabold text-gray-900 truncate">{{ $package->name }}</h2>
                @if($package->descriptions)
                <p class="text-gray-400 text-xs mt-0.5 truncate">{{ $package->descriptions }}</p>
                @endif
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-xl font-extrabold" style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    {{ $package->formatted_price }}
                </p>
            </div>
        </div>
    </div>

    {{-- Registration Form --}}
    <div class="float-card" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.1s; opacity: 0;">
        <div class="flex items-center space-x-2 mb-6">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                <i class="fas fa-user-plus text-xs text-primary-600"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900">Formulir Pendaftaran</h3>
                <p class="text-gray-400 text-[11px]">{{ $package->category === 'kids' ? 'Diisi oleh orang tua / wali' : 'Lengkapi data diri Anda' }}</p>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl flex items-start space-x-3" style="background: linear-gradient(135deg, rgba(239,68,68,0.04), rgba(252,165,165,0.02)); border: 1px solid rgba(239,68,68,0.12);">
            <i class="fas fa-exclamation-triangle text-red-400 text-sm mt-0.5"></i>
            <div>
                <p class="text-sm font-bold text-red-600 mb-1">Mohon periksa kembali data Anda:</p>
                <ul class="text-xs text-red-500 space-y-0.5">
                    @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('dashboard.register.submit', $package->id) }}" id="registerForm">
            @csrf

            <div class="space-y-5">
                {{-- ========== NAMA ========== --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user mr-2 text-primary-400 text-xs"></i>
                        {{ $package->category === 'kids' ? 'Nama Lengkap Anak' : 'Nama Lengkap' }}
                        <span class="text-red-400 ml-0.5">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-input-premium @error('name') !border-red-300 focus:!border-red-400 focus:!ring-red-100 @enderror"
                           placeholder="{{ $package->category === 'kids' ? 'Masukkan nama lengkap anak' : 'Masukkan nama lengkap Anda' }}" required
                           id="input-name">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1 text-[10px]"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- ========== USIA ========== --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-birthday-cake mr-2 text-primary-400 text-xs"></i>
                        {{ $package->category === 'kids' ? 'Usia Anak' : 'Usia' }}
                        <span class="text-red-400 ml-0.5">*</span>
                    </label>
                    <input type="number" name="age" value="{{ old('age') }}"
                           class="form-input-premium @error('age') !border-red-300 focus:!border-red-400 focus:!ring-red-100 @enderror"
                           placeholder="{{ $package->category === 'kids' ? 'Contoh: 8' : 'Contoh: 25' }}"
                           min="1" max="{{ $package->category === 'kids' ? '17' : '100' }}" required
                           id="input-age">
                    @error('age')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1 text-[10px]"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- ========== DOMISILI ========== --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt mr-2 text-primary-400 text-xs"></i>
                        Domisili
                        <span class="text-red-400 ml-0.5">*</span>
                    </label>
                    <input type="text" name="domicile" value="{{ old('domicile') }}"
                           class="form-input-premium @error('domicile') !border-red-300 focus:!border-red-400 focus:!ring-red-100 @enderror"
                           placeholder="Contoh: Jakarta Selatan" required
                           id="input-domicile">
                    @error('domicile')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1 text-[10px]"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- ========== PEKERJAAN ========== --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-briefcase mr-2 text-primary-400 text-xs"></i>
                        {{ $package->category === 'kids' ? 'Pekerjaan Orang Tua' : 'Pekerjaan' }}
                        <span class="text-red-400 ml-0.5">*</span>
                    </label>
                    <input type="text" name="job" value="{{ old('job') }}"
                           class="form-input-premium @error('job') !border-red-300 focus:!border-red-400 focus:!ring-red-100 @enderror"
                           placeholder="{{ $package->category === 'kids' ? 'Contoh: PNS / Wiraswasta' : 'Contoh: Mahasiswi / Ibu Rumah Tangga' }}" required
                           id="input-job">
                    @error('job')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1 text-[10px]"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- ========== NO WHATSAPP ========== --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fab fa-whatsapp mr-2 text-green-500 text-xs"></i>
                        {{ $package->category === 'kids' ? 'No. WhatsApp Orang Tua' : 'No. WhatsApp' }}
                        <span class="text-red-400 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="{{ $package->category === 'kids' ? 'parent_phone' : 'phone' }}" value="{{ old($package->category === 'kids' ? 'parent_phone' : 'phone') }}"
                               class="form-input-premium !pl-[72px] @error('phone') !border-red-300 focus:!border-red-400 focus:!ring-red-100 @enderror @error('parent_phone') !border-red-300 focus:!border-red-400 focus:!ring-red-100 @enderror"
                               placeholder="8123456789" required
                               id="input-whatsapp">
                        <div class="absolute left-0 top-0 bottom-0 w-16 rounded-l-xl flex items-center justify-center text-sm font-bold text-gray-500 pointer-events-none" style="background: rgba(0,0,0,0.03); border-right: 1.5px solid rgba(0,0,0,0.06);">
                            +62
                        </div>
                    </div>
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1 text-[10px]"></i>{{ $message }}</p>
                    @enderror
                    @error('parent_phone')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1 text-[10px]"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-gray-400 text-[11px] mt-1.5 flex items-center">
                        <i class="fas fa-info-circle mr-1 text-[9px]"></i>
                        Pastikan nomor aktif dan bisa dihubungi via WhatsApp
                    </p>
                </div>
            </div>

            {{-- Terms Notice --}}
            <div class="mt-7 p-4 rounded-2xl flex items-start space-x-3" style="background: linear-gradient(135deg, rgba(255,133,187,0.04), rgba(199,78,131,0.02)); border: 1px solid rgba(255,133,187,0.1);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                    <i class="fas fa-shield-halved text-[10px] text-primary-600"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-600 mb-0.5">Keamanan Data</p>
                    <p class="text-[11px] text-gray-400 leading-relaxed">
                        Dengan mendaftar, Anda akan diarahkan ke halaman pembayaran. Data yang Anda masukkan hanya digunakan untuk keperluan administrasi kursus dan tidak akan dibagikan ke pihak lain.
                    </p>
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex items-center space-x-3 mt-7">
                <a href="{{ route('dashboard.packages') }}"
                   class="px-6 py-3.5 rounded-xl text-gray-500 font-bold text-sm border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 flex items-center"
                   id="btn-back">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali
                </a>
                <button type="submit"
                        class="flex-1 py-3.5 rounded-xl text-white font-bold text-sm transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 relative overflow-hidden group flex items-center justify-center"
                        style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);"
                        id="btn-submit">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Daftar & Lanjut ke Pembayaran
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
