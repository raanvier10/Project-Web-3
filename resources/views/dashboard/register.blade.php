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
    <div class="relative overflow-hidden rounded-2xl mb-6" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #7C3AED 0%, #8B5CF6 40%, #A78BFA 100%)' : ($package->category === 'teens' ? 'linear-gradient(135deg, #2563EB 0%, #3B82F6 40%, #60A5FA 100%)' : 'linear-gradient(135deg, #C74E83 0%, #E8699F 40%, #FF85BB 100%)') }};">
        {{-- Decorative --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full" style="background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
            <div class="absolute bottom-0 -left-8 w-32 h-32 rounded-full" style="background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 16px 16px;"></div>
        </div>

        <div class="relative z-10 p-6 sm:p-8 flex items-start space-x-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                <i class="fas {{ $package->category === 'kids' ? 'fa-child' : ($package->category === 'teens' ? 'fa-user-friends' : 'fa-user-graduate') }} text-2xl text-white"></i>
            </div>
            <div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 text-white/90" style="background: rgba(255,255,255,0.15);">
                    {{ $package->category_label }}
                </span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-white">{{ $package->name }}</h2>
                <p class="text-white/60 text-sm mt-1 max-w-md">{{ $package->descriptions }}</p>
                {{-- Price with discount --}}
                @if($package->has_discount)
                <div class="flex items-center space-x-2 mt-3">
                    <span class="text-white/50 text-sm line-through font-medium">{{ $package->formatted_original_price }}</span>
                    @php $discountPct = round((1 - $package->price / $package->original_price) * 100); @endphp
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold" style="background: rgba(255,255,255,0.2); color: #fff;">
                        <i class="fas fa-bolt mr-0.5 text-[8px]"></i> HEMAT {{ $discountPct }}%
                    </span>
                </div>
                <p class="text-2xl font-extrabold text-white mt-1">
                    {{ $package->formatted_price }}
                    <span class="text-white/40 text-sm font-normal">/program</span>
                </p>
                @else
                <p class="text-2xl font-extrabold text-white mt-3">
                    {{ $package->formatted_price }}
                    <span class="text-white/40 text-sm font-normal">/program</span>
                </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Registration Form --}}
    <div class="float-card">
        <div class="flex items-center space-x-3 mb-7 pb-5" style="border-bottom: 1px dashed rgba(0,0,0,0.06);">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #F3E8FF, #E9D5FF)' : ($package->category === 'teens' ? 'linear-gradient(135deg, #DBEAFE, #BFDBFE)' : 'linear-gradient(135deg, #FFE0EC, #FFC2D9)') }};">
                <i class="fas fa-file-pen {{ $package->category === 'kids' ? 'text-purple-600' : ($package->category === 'teens' ? 'text-blue-600' : 'text-primary-600') }}"></i>
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
                    {{ in_array($package->category, ['kids', 'teens']) ? 'Nama Anak' : 'Nama Lengkap' }}
                    <span class="text-red-400 ml-0.5">*</span>
                </label>
                <div class="relative group">
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required maxlength="255"
                        pattern="[a-zA-Z\s]+" title="Hanya boleh berisi huruf dan spasi"
                        placeholder="{{ in_array($package->category, ['kids', 'teens']) ? 'Masukkan nama anak' : 'Masukkan nama lengkap' }}"
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
                    <input type="number" id="age" name="age" value="{{ old('age') }}" required
                        min="{{ $package->category === 'kids' ? '4' : ($package->category === 'teens' ? '11' : '16') }}"
                        max="{{ $package->category === 'kids' ? '10' : ($package->category === 'teens' ? '15' : '150') }}"
                        placeholder="Masukkan usia"
                        class="form-input-premium @error('age') !border-red-300 !bg-red-50/30 @enderror" />
                    <p class="text-gray-400 text-[11px] mt-1.5 flex items-center">
                        <i class="fas fa-info-circle mr-1 text-gray-300"></i>
                        @if($package->category === 'kids')
                            Rentang usia program Kids: <strong class="ml-1 text-gray-500">4 – 10 tahun</strong>
                        @elseif($package->category === 'teens')
                            Rentang usia program Teens: <strong class="ml-1 text-gray-500">11 – 15 tahun</strong>
                        @else
                            Rentang usia program Dewasa: <strong class="ml-1 text-gray-500">16 tahun ke atas</strong>
                        @endif
                    </p>
                    {{-- Age warning banner (shown by JS) --}}
                    <div id="ageWarningBanner" class="hidden mt-2 p-3 rounded-xl flex items-start space-x-2.5" style="background: linear-gradient(135deg, rgba(239,68,68,0.06), rgba(252,165,165,0.04)); border: 1px solid rgba(239,68,68,0.15);">
                        <i class="fas fa-exclamation-triangle text-red-400 text-sm mt-0.5 flex-shrink-0"></i>
                        <p class="text-red-600 text-xs leading-relaxed" id="ageWarningText"></p>
                    </div>
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
                    {{ in_array($package->category, ['kids', 'teens']) ? 'Pekerjaan Orang Tua' : 'Pekerjaan' }}
                    <span class="text-red-400 ml-0.5">*</span>
                </label>
                <input type="text" id="job" name="job" value="{{ old('job') }}" required maxlength="255"
                    placeholder="{{ in_array($package->category, ['kids', 'teens']) ? 'Pekerjaan orang tua' : 'Masukkan pekerjaan Anda' }}"
                    class="form-input-premium @error('job') !border-red-300 !bg-red-50/30 @enderror" />
                @error('job')
                <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            @if(in_array($package->category, ['kids', 'teens']))
            <div class="form-group">
                <label for="parent_phone" class="form-label">
                    <i class="fab fa-whatsapp text-xs mr-1.5 text-green-500"></i>
                    No. WhatsApp Orang Tua <span class="text-red-400 ml-0.5">*</span>
                </label>
                <input type="tel" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" required maxlength="13"
                    placeholder="Contoh: 081234567890"
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
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required maxlength="13"
                    placeholder="Contoh: 081234567890"
                    class="form-input-premium @error('phone') !border-red-300 !bg-red-50/30 @enderror" />
                @error('phone')
                <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Terms Notice --}}
            <label class="mt-7 p-4 rounded-2xl flex items-start space-x-3 cursor-pointer transition-all duration-300 hover:shadow-md" style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, rgba(167,139,250,0.04), rgba(124,58,237,0.02))' : ($package->category === 'teens' ? 'linear-gradient(135deg, rgba(96,165,250,0.04), rgba(37,99,235,0.02))' : 'linear-gradient(135deg, rgba(255,133,187,0.04), rgba(199,78,131,0.02))') }}; border: 1px solid {{ $package->category === 'kids' ? 'rgba(167,139,250,0.2)' : ($package->category === 'teens' ? 'rgba(96,165,250,0.2)' : 'rgba(255,133,187,0.2)') }};">
                <div class="flex items-center h-5 mt-1 relative">
                    <input id="terms-checkbox" type="checkbox" name="terms" required
                           class="w-5 h-5 {{ $package->category === 'kids' ? 'text-purple-600 border-purple-300 focus:ring-purple-500' : ($package->category === 'teens' ? 'text-blue-600 border-blue-300 focus:ring-blue-500' : 'text-primary-600 border-primary-300 focus:ring-primary-500') }} bg-white rounded cursor-pointer transition-colors"
                           onchange="document.getElementById('submitRegistration').disabled = !this.checked; if(this.checked){ document.getElementById('submitRegistration').classList.remove('opacity-60', 'cursor-not-allowed'); document.getElementById('submitRegistration').classList.add('hover:-translate-y-0.5', 'active:translate-y-0'); } else { document.getElementById('submitRegistration').classList.add('opacity-60', 'cursor-not-allowed'); document.getElementById('submitRegistration').classList.remove('hover:-translate-y-0.5', 'active:translate-y-0'); }">
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-700 mb-1">Saya menyetujui Syarat dan Ketentuan</p>
                    <p class="text-[11px] text-gray-500 leading-relaxed">
                        Dengan mendaftar, Anda menyetujui bahwa data yang Anda masukkan digunakan untuk keperluan administrasi kursus dan Anda akan diarahkan ke halaman pembayaran.
                    </p>
                </div>
            </label>

            {{-- Submit --}}
            <div class="pt-5 flex flex-col sm:flex-row items-center gap-3" style="border-top: 1px dashed rgba(0,0,0,0.06);">
                <a href="javascript:void(0)" 
                   onclick="showUniversalModal({
                       title: 'Batalkan Pesanan?',
                       description: 'Apakah kamu yakin untuk membatalkan pendaftaran? Data yang Anda isi tidak akan disimpan.',
                       confirmText: 'Ya, Batalkan',
                       onConfirm: () => { window.location.href = '{{ route('dashboard.packages') }}'; }
                   })"
                   class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-gray-50 hover:border-gray-300 transition-all text-center">
                    <i class="fas fa-arrow-left mr-1.5"></i> Kembali
                </a>
                <button type="submit" id="submitRegistration" disabled
                    class="w-full sm:flex-1 py-4 rounded-xl text-white font-bold text-sm transition-all duration-300 transform flex items-center justify-center space-x-2 relative overflow-hidden group opacity-60 cursor-not-allowed"
                    style="background: {{ $package->category === 'kids' ? 'linear-gradient(135deg, #8B5CF6 0%, #A78BFA 50%, #7C3AED 100%)' : ($package->category === 'teens' ? 'linear-gradient(135deg, #3B82F6 0%, #60A5FA 50%, #2563EB 100%)' : 'linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%)') }}; box-shadow: {{ $package->category === 'kids' ? '0 4px 20px rgba(124,58,237,0.25)' : ($package->category === 'teens' ? '0 4px 20px rgba(59,130,246,0.25)' : '0 4px 20px rgba(199,78,131,0.25)') }};">
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
    const packageCategory = '{{ $package->category }}';
    const minAge = packageCategory === 'kids' ? 4 : (packageCategory === 'teens' ? 11 : 16);
    const maxAge = packageCategory === 'kids' ? 10 : (packageCategory === 'teens' ? 15 : 150);

    const ageInput = document.getElementById('age');
    const ageWarning = document.getElementById('ageWarningBanner');
    const ageWarningText = document.getElementById('ageWarningText');
    const submitBtn = document.getElementById('submitRegistration');
    const termsCheckbox = document.getElementById('terms-checkbox');

    function validateAge() {
        const val = parseInt(ageInput.value);
        if (!ageInput.value || isNaN(val)) {
            ageWarning.classList.add('hidden');
            ageInput.classList.remove('!border-red-300', '!bg-red-50/30');
            return true;
        }

        let warning = '';
        if (packageCategory === 'kids') {
            if (val < 4) warning = 'Usia terlalu kecil. Program Kids untuk anak usia 4–10 tahun.';
            else if (val > 10) warning = 'Usia melebihi batas program Kids (maks. 10 tahun). Silakan pilih paket Teens atau Dewasa.';
        } else if (packageCategory === 'teens') {
            if (val < 11) warning = 'Usia terlalu kecil. Program Teens untuk anak usia 11–15 tahun.';
            else if (val > 15) warning = 'Usia melebihi batas program Teens (maks. 15 tahun). Silakan pilih paket Dewasa untuk usia 16 tahun ke atas.';
        } else {
            if (val < 16) warning = 'Usia di bawah 16 tahun tidak dapat mendaftar program Dewasa. Silakan pilih paket Kids atau Teens.';
            else if (val > 150) warning = 'Usia tidak valid.';
        }

        if (warning) {
            ageWarningText.textContent = warning;
            ageWarning.classList.remove('hidden');
            ageInput.classList.add('!border-red-300', '!bg-red-50/30');
            return false;
        } else {
            ageWarning.classList.add('hidden');
            ageInput.classList.remove('!border-red-300', '!bg-red-50/30');
            return true;
        }
    }

    ageInput.addEventListener('input', validateAge);
    ageInput.addEventListener('change', validateAge);

    // Validate on page load (in case old value is present)
    validateAge();

    let submitting = false;
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        // Check age validity before submit
        if (!validateAge()) {
            e.preventDefault();
            ageInput.focus();
            return;
        }
        if (submitting) { e.preventDefault(); return; }
        submitting = true;
        const btn = document.getElementById('submitRegistration');
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    });
</script>
@endsection