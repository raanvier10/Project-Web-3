@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
  <!-- Left Panel: Branding -->
  <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900">
    <!-- Decorative elements -->
    <div class="absolute inset-0">
      <div class="absolute top-20 -left-20 w-80 h-80 bg-primary-400/20 rounded-full blur-3xl animate-float"></div>
      <div class="absolute bottom-20 -right-20 w-96 h-96 bg-primary-300/15 rounded-full blur-3xl animate-float-slow"></div>
      <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-white/5 rounded-full blur-2xl animate-float" style="animation-delay:-4s"></div>
      <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20 w-full">
      <!-- Logo -->
      <div class="flex items-center space-x-3 mb-12">
        <img src="/images/EFA.svg" alt="Logo EFA" class="w-14 h-14 object-contain drop-shadow-lg" />
        <span class="font-extrabold text-2xl text-white tracking-wide" style="font-family:'Oswald',sans-serif;">EFA</span>
      </div>

      <h2 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-6">
        <span data-i18n="reg_hero_1">Bergabunglah</span><br>
        <span class="text-primary-200" data-i18n="reg_hero_2">Bersama Kami</span>
      </h2>
      <p class="text-primary-100/80 text-lg leading-relaxed mb-10 max-w-md" data-i18n="reg_hero_desc">
        Daftarkan dirimu sekarang dan mulai perjalanan belajar bahasa Inggris bersama komunitas akhwat yang suportif.
      </p>

      <!-- Features list -->
      <div class="space-y-4 max-w-md">
        <div class="flex items-center space-x-4">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-graduation-cap text-primary-200"></i>
          </div>
          <div>
            <p class="text-white font-semibold text-sm" data-i18n="reg_feat1_title">Pengajar Berpengalaman</p>
            <p class="text-primary-200/60 text-xs" data-i18n="reg_feat1_desc">Dibimbing oleh tutor profesional & bersertifikat</p>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-laptop text-primary-200"></i>
          </div>
          <div>
            <p class="text-white font-semibold text-sm" data-i18n="reg_feat2_title">Belajar Online Fleksibel</p>
            <p class="text-primary-200/60 text-xs" data-i18n="reg_feat2_desc">Akses kelas kapan saja, di mana saja</p>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-users text-primary-200"></i>
          </div>
          <div>
            <p class="text-white font-semibold text-sm" data-i18n="reg_feat3_title">Komunitas Suportif</p>
            <p class="text-primary-200/60 text-xs" data-i18n="reg_feat3_desc">Bergabung dengan 300+ alumni dari seluruh Indonesia</p>
          </div>
        </div>
      </div>

      <!-- Stats -->
      <div class="flex items-center space-x-8 mt-12">
        <div>
          <p class="text-2xl font-bold text-white">300+</p>
          <p class="text-primary-200/60 text-xs" data-i18n="reg_stat1">Alumni</p>
        </div>
        <div class="w-px h-10 bg-white/20"></div>
        <div>
          <p class="text-2xl font-bold text-white">4.9</p>
          <p class="text-primary-200/60 text-xs">Rating</p>
        </div>
        <div class="w-px h-10 bg-white/20"></div>
        <div>
          <p class="text-2xl font-bold text-white">15</p>
          <p class="text-primary-200/60 text-xs" data-i18n="reg_stat3">Program</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Panel: Register Form -->
  <div class="w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white relative overflow-y-auto">
    <!-- Mobile decorative -->
    <div class="absolute top-0 right-0 w-72 h-72 bg-primary-100/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 lg:hidden"></div>

    <div class="w-full max-w-md mx-auto px-6 sm:px-8 py-10 relative z-10">
      <!-- Mobile Logo -->
      <div class="flex items-center justify-center space-x-2 mb-8 lg:hidden">
        <img src="/images/LogoEFA.svg" alt="Logo EFA" class="w-12 h-12 object-contain" />
        <span class="font-bold text-2xl text-primary-700 font-oswal">EFA</span>
      </div>

      <!-- Back link -->
      <a href="/" class="inline-flex items-center text-sm text-gray-400 hover:text-primary-600 transition mb-6 group">
        <i class="fas fa-arrow-left mr-2 text-xs group-hover:-translate-x-1 transition-transform"></i>
        <span data-i18n="auth_back">Kembali ke Beranda</span>
      </a>

      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2" data-i18n="reg_title">Buat Akun Baru ✨</h1>
        <p class="text-gray-500 text-sm" data-i18n="reg_subtitle">Isi data di bawah untuk mendaftar ke program EFA</p>
      </div>

      <!-- Error Messages -->
      @if ($errors->any())
      <div class="mb-5 p-4 rounded-2xl bg-red-50/80 border border-red-100 backdrop-blur-sm">
        <div class="flex items-start space-x-3">
          <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center">
            <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
          </div>
          <div class="pt-1">
            @foreach ($errors->all() as $error)
              <p class="text-red-600 text-sm font-medium">{{ $error }}</p>
            @endforeach
          </div>
        </div>
      </div>
      @endif

      <!-- Register Form -->
      <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
          <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5" data-i18n="reg_name_label">Nama Lengkap</label>
          <div class="relative group">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500 transition">
              <i class="fas fa-user text-sm"></i>
            </div>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name') }}"
              required
              autocomplete="name"
              autofocus
              maxlength="255"
              placeholder="Masukkan nama lengkap"
              data-placeholder-id="Masukkan nama lengkap"
              data-placeholder-en="Enter your full name"
              class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-gray-100 bg-gray-50/80 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white transition-all duration-300 @error('name') border-red-300 @enderror"
            />
          </div>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
          <div class="relative group">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500 transition">
              <i class="fas fa-envelope text-sm"></i>
            </div>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              required
              autocomplete="email"
              maxlength="255"
              placeholder="nama@email.com"
              class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-gray-100 bg-gray-50/80 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white transition-all duration-300 @error('email') border-red-300 @enderror"
            />
          </div>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
          <div class="relative group">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500 transition">
              <i class="fas fa-lock text-sm"></i>
            </div>
            <input
              type="password"
              id="password"
              name="password"
              required
              minlength="8"
              placeholder="Minimal 8 karakter"
              data-placeholder-id="Minimal 8 karakter"
              data-placeholder-en="Minimum 8 characters"
              class="w-full pl-11 pr-12 py-3.5 rounded-xl border-2 border-gray-100 bg-gray-50/80 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white transition-all duration-300 @error('password') border-red-300 @enderror"
            />
            <button
              type="button"
              id="togglePassword"
              class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition"
              aria-label="Toggle password visibility"
            >
              <i class="fas fa-eye text-sm" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5" data-i18n="reg_confirm_label">Konfirmasi Password</label>
          <div class="relative group">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500 transition">
              <i class="fas fa-lock text-sm"></i>
            </div>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required
              minlength="8"
              placeholder="Ketik ulang password"
              data-placeholder-id="Ketik ulang password"
              data-placeholder-en="Re-enter your password"
              class="w-full pl-11 pr-12 py-3.5 rounded-xl border-2 border-gray-100 bg-gray-50/80 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100 focus:bg-white transition-all duration-300"
            />
            <button
              type="button"
              id="toggleConfirm"
              class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition"
              aria-label="Toggle password visibility"
            >
              <i class="fas fa-eye text-sm" id="eyeIconConfirm"></i>
            </button>
          </div>
        </div>

        <!-- Terms -->
        <div class="flex items-start">
          <input
            type="checkbox"
            name="terms"
            id="terms"
            required
            class="w-4 h-4 mt-0.5 rounded-md border-2 border-gray-200 text-primary-600 focus:ring-primary-400 focus:ring-offset-0 transition"
          />
          <label for="terms" class="ml-2.5 text-sm text-gray-500 leading-snug" data-i18n="reg_terms_html">
            Saya menyetujui Syarat & Ketentuan dan Kebijakan Privasi
          </label>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          id="registerButton"
          class="w-full py-4 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 text-white font-bold text-sm shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 hover:from-primary-500 hover:to-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-200 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2"
        >
          <span data-i18n="reg_submit">Daftar Sekarang</span>
          <i class="fas fa-arrow-right text-xs"></i>
        </button>
      </form>

      <!-- Divider -->
      <div class="relative my-6">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
        <div class="relative flex justify-center"><span class="bg-white px-4 text-xs text-gray-400 uppercase tracking-wider" data-i18n="auth_or">atau</span></div>
      </div>

      <!-- Login link -->
      <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl border-2 border-gray-100 text-gray-700 font-semibold text-sm hover:border-primary-200 hover:bg-primary-50/50 hover:text-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-100 transition-all duration-300 flex items-center justify-center space-x-2">
        <i class="fas fa-sign-in-alt text-xs"></i>
        <span data-i18n="reg_login_link">Sudah Punya Akun? Masuk</span>
      </a>

      <!-- Security badge -->
      <div class="mt-6 text-center">
        <p class="text-xs text-gray-400 flex items-center justify-center space-x-1.5">
          <i class="fas fa-shield-alt text-primary-300"></i>
          <span data-i18n="auth_security">Data Anda aman & terenkripsi</span>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // ========== I18N SYSTEM ==========
  const authTranslations = {
    en: {
      reg_hero_1: "Join Us", reg_hero_2: "Today",
      reg_hero_desc: "Register now and start your English learning journey with a supportive akhwat community.",
      reg_feat1_title: "Experienced Tutors", reg_feat1_desc: "Guided by professional & certified tutors",
      reg_feat2_title: "Flexible Online Learning", reg_feat2_desc: "Access classes anytime, anywhere",
      reg_feat3_title: "Supportive Community", reg_feat3_desc: "Join 300+ alumni from across Indonesia",
      reg_stat1: "Alumni", reg_stat3: "Programs",
      auth_back: "Back to Home",
      reg_title: "Create New Account ✨", reg_subtitle: "Fill in the form below to register for EFA programs",
      reg_name_label: "Full Name",
      reg_confirm_label: "Confirm Password",
      reg_terms_html: "I agree to the Terms & Conditions and Privacy Policy",
      reg_submit: "Register Now",
      auth_or: "or",
      reg_login_link: "Already Have an Account? Sign In",
      auth_security: "Your data is safe & encrypted",
    },
    id: {
      reg_hero_1: "Bergabunglah", reg_hero_2: "Bersama Kami",
      reg_hero_desc: "Daftarkan dirimu sekarang dan mulai perjalanan belajar bahasa Inggris bersama komunitas akhwat yang suportif.",
      reg_feat1_title: "Pengajar Berpengalaman", reg_feat1_desc: "Dibimbing oleh tutor profesional & bersertifikat",
      reg_feat2_title: "Belajar Online Fleksibel", reg_feat2_desc: "Akses kelas kapan saja, di mana saja",
      reg_feat3_title: "Komunitas Suportif", reg_feat3_desc: "Bergabung dengan 300+ alumni dari seluruh Indonesia",
      reg_stat1: "Alumni", reg_stat3: "Program",
      auth_back: "Kembali ke Beranda",
      reg_title: "Buat Akun Baru ✨", reg_subtitle: "Isi data di bawah untuk mendaftar ke program EFA",
      reg_name_label: "Nama Lengkap",
      reg_confirm_label: "Konfirmasi Password",
      reg_terms_html: "Saya menyetujui Syarat & Ketentuan dan Kebijakan Privasi",
      reg_submit: "Daftar Sekarang",
      auth_or: "atau",
      reg_login_link: "Sudah Punya Akun? Masuk",
      auth_security: "Data Anda aman & terenkripsi",
    }
  };

  // Apply language from localStorage
  (function() {
    const lang = localStorage.getItem('efa_lang') || 'id';
    document.getElementById('htmlRoot').lang = lang;
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (authTranslations[lang] && authTranslations[lang][key]) {
        el.textContent = authTranslations[lang][key];
      }
    });
    // Update placeholders based on language
    document.querySelectorAll('[data-placeholder-' + lang + ']').forEach(el => {
      el.placeholder = el.getAttribute('data-placeholder-' + lang);
    });
  })();

  // Toggle password
  document.getElementById('togglePassword').addEventListener('click', () => {
    const pw = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    const isHidden = pw.type === 'password';
    pw.type = isHidden ? 'text' : 'password';
    icon.classList.toggle('fa-eye', !isHidden);
    icon.classList.toggle('fa-eye-slash', isHidden);
  });

  // Toggle confirm password
  document.getElementById('toggleConfirm').addEventListener('click', () => {
    const pw = document.getElementById('password_confirmation');
    const icon = document.getElementById('eyeIconConfirm');
    const isHidden = pw.type === 'password';
    pw.type = isHidden ? 'text' : 'password';
    icon.classList.toggle('fa-eye', !isHidden);
    icon.classList.toggle('fa-eye-slash', isHidden);
  });

  // Prevent double submit
  let submitting = false;
  document.getElementById('registerForm').addEventListener('submit', (e) => {
    if (submitting) { e.preventDefault(); return; }
    submitting = true;
    const btn = document.getElementById('registerButton');
    const lang = localStorage.getItem('efa_lang') || 'id';
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> ' + (lang === 'en' ? 'Processing...' : 'Memproses...');
  });
</script>
@endsection