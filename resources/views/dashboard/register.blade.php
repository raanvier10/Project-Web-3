@extends('layouts.dashboard')

@section('page-title', 'Form Pendaftaran')

@section('dashboard-content')
{{-- Breadcrumb --}}
<div class="flex items-center space-x-2.5 text-sm mb-7">
    <a href="{{ route('dashboard.packages') }}" class="text-gray-400 hover:text-primary-600 transition-colors flex items-center space-x-1.5">
        <i class="fas fa-book-open text-xs"></i>
        <span>Paket Kursus</span>
    </a>
    <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
    <span class="text-gray-700 font-semibold">Pendaftaran</span>
</div>

<div class="max-w-3xl mx-auto">
    {{-- Package Info Banner --}}
    <div class="relative overflow-hidden rounded-2xl mb-6" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #7C3AED 0%, #8B5CF6 40%, #A78BFA 100%)' : 'linear-gradient(135deg, #C74E83 0%, #E8699F 40%, #FF85BB 100%)' }};">
        {{-- Decorative --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full" style="background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
            <div class="absolute bottom-0 -left-8 w-32 h-32 rounded-full" style="background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 16px 16px;"></div>
        </div>

        <div class="relative z-10 p-6 sm:p-8 flex items-start space-x-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                <i class="fas {{ $package->category === 'kids' ? 'fa-child' : 'fa-user-graduate' }} text-2xl text-white"></i>
            </div>
            <div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 text-white/90" style="background: rgba(255,255,255,0.15);">
                    {{ $package->category_label }}
                </span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-white">{{ $package->name }}</h2>
                <p class="text-white/60 text-sm mt-1 max-w-md">{{ $package->descriptions }}</p>
                <p class="text-2xl font-extrabold text-white mt-3">
                    {{ $package->formatted_price }}
                    <span class="text-white/40 text-sm font-normal">/program</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Registration Form --}}
    <div class="float-card">
        <div class="flex items-center space-x-3 mb-7 pb-5" style="border-bottom: 1px dashed rgba(0,0,0,0.06);">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #F3E8FF, #E9D5FF)' : 'linear-gradient(135deg, #FFE0EC, #FFC2D9)' }};">
                <i class="fas fa-file-pen {{ $package->category === 'kids' ? 'text-purple-600' : 'text-primary-600' }}"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Form Pendaftaran</h3>
                <p class="text-gray-400 text-xs mt-0.5">Lengkapi data berikut untuk program <strong>{{ $package->category_label }}</strong></p>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.register.submit', $package->id) }}" id="registrationForm" novalidate class="space-y-5">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="fas fa-user text-xs mr-1.5 text-gray-400"></i>
                    {{ $package->category === 'kids' ? 'Nama Anak' : 'Nama Lengkap' }}
                    <span class="text-red-400 ml-0.5">*</span>
                </label>
                <div class="relative group">
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required maxlength="255"
                        placeholder="{{ $package->category === 'kids' ? 'Masukkan nama anak' : 'Masukkan nama lengkap' }}"
                        class="form-input-premium @error('name') !border-red-300 !bg-red-50/30 @enderror" />
                    <div class="form-input-glow"></div>
                </div>
                @error('name')
                <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Age --}}
                <div class="form-group">
                    <label for="age" class="form-label">
                        <i class="fas fa-calendar-day text-xs mr-1.5 text-gray-400"></i>
                        Usia <span class="text-red-400 ml-0.5">*</span>
                    </label>
                    <input type="number" id="age" name="age" value="{{ old('age') }}" required min="1" max="100"
                        placeholder="Masukkan usia"
                        class="form-input-premium @error('age') !border-red-300 !bg-red-50/30 @enderror" />
                    @error('age')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Domicile --}}
                <div class="form-group">
                    <label for="domicile" class="form-label">
                        <i class="fas fa-map-marker-alt text-xs mr-1.5 text-gray-400"></i>
                        Domisili <span class="text-red-400 ml-0.5">*</span>
                    </label>
                    <input type="text" id="domicile" name="domicile" value="{{ old('domicile') }}" required maxlength="255"
                        placeholder="Kota tempat tinggal"
                        class="form-input-premium @error('domicile') !border-red-300 !bg-red-50/30 @enderror" />
                    @error('domicile')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Job --}}
            <div class="form-group">
                <label for="job" class="form-label">
                    <i class="fas fa-briefcase text-xs mr-1.5 text-gray-400"></i>
                    {{ $package->category === 'kids' ? 'Pekerjaan Orang Tua' : 'Pekerjaan' }}
                    <span class="text-red-400 ml-0.5">*</span>
                </label>
                <input type="text" id="job" name="job" value="{{ old('job') }}" required maxlength="255"
                    placeholder="{{ $package->category === 'kids' ? 'Pekerjaan orang tua' : 'Masukkan pekerjaan Anda' }}"
                    class="form-input-premium @error('job') !border-red-300 !bg-red-50/30 @enderror" />
                @error('job')
                <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            @if($package->category === 'kids')
            <div class="form-group">
                <label for="parent_phone" class="form-label">
                    <i class="fab fa-whatsapp text-xs mr-1.5 text-green-500"></i>
                    No. WhatsApp Orang Tua <span class="text-red-400 ml-0.5">*</span>
                </label>
                <input type="tel" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" required maxlength="20"
                    placeholder="08xxxxxxxxxx"
                    class="form-input-premium @error('parent_phone') !border-red-300 !bg-red-50/30 @enderror" />
                @error('parent_phone')
                <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
            @else
            <div class="form-group">
                <label for="phone" class="form-label">
                    <i class="fab fa-whatsapp text-xs mr-1.5 text-green-500"></i>
                    No. WhatsApp <span class="text-red-400 ml-0.5">*</span>
                </label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required maxlength="20"
                    placeholder="08xxxxxxxxxx"
                    class="form-input-premium @error('phone') !border-red-300 !bg-red-50/30 @enderror" />
                @error('phone')
                <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Submit --}}
            <div class="pt-5 flex flex-col sm:flex-row items-center gap-3" style="border-top: 1px dashed rgba(0,0,0,0.06);">
                <a href="{{ route('dashboard.packages') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-gray-50 hover:border-gray-300 transition-all text-center">
                    <i class="fas fa-arrow-left mr-1.5"></i> Kembali
                </a>
                <button type="submit" id="submitRegistration"
                    class="w-full sm:flex-1 py-4 rounded-xl text-white font-bold text-sm transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2 relative overflow-hidden group"
                    style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);">
                    <span class="relative z-10 flex items-center">
                        <span>Daftar & Lanjut Bayar</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let submitting = false;
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        if (submitting) { e.preventDefault(); return; }
        submitting = true;
        const btn = document.getElementById('submitRegistration');
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    });
</script>
@endsection