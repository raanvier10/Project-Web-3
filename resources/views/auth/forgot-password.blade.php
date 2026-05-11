@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row">
  {{-- LEFT PANEL --}}
  <div class="hidden lg:flex lg:w-[52%] relative overflow-hidden" style="background: linear-gradient(135deg, #C74E83 0%, #E8699F 30%, #FF85BB 60%, #FFA3C7 100%);">
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full animate-float" style="background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);"></div>
      <div class="absolute bottom-10 -right-32 w-[480px] h-[480px] rounded-full animate-float-slow" style="background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
      <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>
    </div>

    <div class="relative z-10 flex flex-col justify-between w-full px-12 xl:px-16 2xl:px-20 py-14">
      <div class="flex items-center space-x-3">
          <img src="/images/EFA.svg" alt="Logo EFA" class="w-8 h-8 object-contain" />
        <span class="font-extrabold text-2xl text-white tracking-wide" style="font-family:'Oswald',sans-serif;">EFA</span>
      </div>

      <div class="flex-1 flex flex-col justify-center -mt-4">
        <h2 class="text-4xl xl:text-[2.75rem] 2xl:text-5xl font-extrabold text-white leading-[1.15] mb-5">
          <span data-i18n="forgot_hero_1">Atur Ulang</span><br>
          <span class="text-white/80" data-i18n="forgot_hero_2">Password Anda</span>
        </h2>
        <p class="text-white/70 text-base xl:text-lg leading-relaxed max-w-sm" data-i18n="forgot_hero_desc">
          Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
        </p>
      </div>

      <div class="flex items-center space-x-6">
        <div class="text-center">
          <p class="text-2xl font-extrabold text-white">Aman</p>
          <p class="text-white/50 text-[11px] tracking-wide uppercase" data-i18n="forgot_stat1">Terenkripsi</p>
        </div>
        <div class="w-px h-8 bg-white/20"></div>
        <div class="text-center">
          <p class="text-2xl font-extrabold text-white">Cepat</p>
          <p class="text-white/50 text-[11px] tracking-wide uppercase" data-i18n="forgot_stat2">Otomatis</p>
        </div>
      </div>
    </div>
  </div>

  {{-- RIGHT PANEL --}}
  <div class="w-full lg:w-[48%] flex items-center justify-center relative bg-white">
    <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full opacity-40 pointer-events-none" style="background: radial-gradient(circle, #FFF0F6 0%, transparent 70%);"></div>
    <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full opacity-30 pointer-events-none" style="background: radial-gradient(circle, #FFE0EC 0%, transparent 70%);"></div>

    <div class="w-full max-w-[420px] mx-auto px-6 sm:px-8 py-10 relative z-10">
      <div class="flex items-center justify-center space-x-2.5 mb-10 lg:hidden">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-lg shadow-primary-500/30">
          <img src="/images/LogoEFA.svg" alt="Logo EFA" class="w-7 h-7 object-contain" />
        </div>
        <span class="font-extrabold text-xl text-primary-700" style="font-family:'Oswald',sans-serif;">EFA</span>
      </div>

      <a href="{{ route('login') }}" class="inline-flex items-center text-sm text-gray-400 hover:text-primary-600 transition-colors duration-200 mb-8 group">
        <svg class="w-4 h-4 mr-1.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        <span data-i18n="forgot_back">Kembali ke Login</span>
      </a>

      <div class="mb-8">
        <h1 class="text-[1.75rem] font-extrabold text-gray-900 mb-1.5" data-i18n="forgot_title">Lupa Password? 🔐</h1>
        <p class="text-gray-400 text-[15px]" data-i18n="forgot_subtitle">Masukkan email terdaftar Anda untuk menerima tautan reset password.</p>
      </div>

      @if ($errors->any())
      <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 animate-fade-in-up">
        <div class="flex items-start space-x-3">
          <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center mt-0.5">
            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
          </div>
          <div class="pt-0.5">
            @foreach ($errors->all() as $error)
              <p class="text-red-600 text-sm font-medium">{{ $error }}</p>
            @endforeach
          </div>
        </div>
      </div>
      @endif

      @if (session('status'))
      <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 animate-fade-in-up">
        <div class="flex items-center space-x-3">
          <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
          </div>
          <p class="text-green-700 text-sm font-medium">{{ session('status') }}</p>
        </div>
      </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" id="forgotForm" novalidate class="space-y-5">
        @csrf

        <div>
          <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
          <div class="relative group">
            <div class="absolute left-0 top-0 bottom-0 w-11 flex items-center justify-center text-gray-400 group-focus-within:text-primary-500 transition-colors pointer-events-none">
              <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
            </div>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              required
              autocomplete="email"
              autofocus
              maxlength="255"
              placeholder="nama@email.com"
              class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/60 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100/60 focus:bg-white transition-all duration-200 @error('email') border-red-300 bg-red-50/30 @enderror"
            />
          </div>
        </div>

        <button
          type="submit"
          id="forgotButton"
          class="w-full py-3.5 rounded-xl text-white font-bold text-sm shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 focus:outline-none focus:ring-4 focus:ring-primary-200 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2"
          style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%);"
        >
          <span data-i18n="forgot_submit">Kirim Link Reset</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const forgotTranslations = {
    en: {
      forgot_hero_1: "Reset", forgot_hero_2: "Your Password",
      forgot_hero_desc: "Don't worry! Enter your email and we'll send you a link to reset your password.",
      forgot_stat1: "Encrypted", forgot_stat2: "Automated",
      forgot_back: "Back to Login",
      forgot_title: "Forgot Password? 🔐", forgot_subtitle: "Enter your registered email to receive a password reset link.",
      forgot_submit: "Send Reset Link",
    },
    id: {
      forgot_hero_1: "Atur Ulang", forgot_hero_2: "Password Anda",
      forgot_hero_desc: "Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.",
      forgot_stat1: "Terenkripsi", forgot_stat2: "Otomatis",
      forgot_back: "Kembali ke Login",
      forgot_title: "Lupa Password? 🔐", forgot_subtitle: "Masukkan email terdaftar Anda untuk menerima tautan reset password.",
      forgot_submit: "Kirim Link Reset",
    }
  };

  (function() {
    const lang = localStorage.getItem('efa_lang') || 'id';
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (forgotTranslations[lang] && forgotTranslations[lang][key]) {
        el.textContent = forgotTranslations[lang][key];
      }
    });
  })();

  let submitting = false;
  document.getElementById('forgotForm').addEventListener('submit', (e) => {
    if (submitting) { e.preventDefault(); return; }
    submitting = true;
    const btn = document.getElementById('forgotButton');
    const lang = localStorage.getItem('efa_lang') || 'id';
    btn.disabled = true;
    btn.style.opacity = '0.7';
    btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>' + (lang === 'en' ? 'Sending...' : 'Mengirim...');
  });
</script>
@endsection
