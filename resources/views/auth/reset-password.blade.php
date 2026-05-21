@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row overflow-x-hidden">
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
          <span data-i18n="reset_hero_1">Buat Password</span><br>
          <span class="text-white/80" data-i18n="reset_hero_2">Baru Anda</span>
        </h2>
        <p class="text-white/70 text-base xl:text-lg leading-relaxed max-w-sm" data-i18n="reset_hero_desc">
          Pastikan password baru Anda kuat dan mudah diingat.
        </p>
      </div>
      
      <div class="flex items-center space-x-6">
        <div class="text-center">
          <p class="text-2xl font-extrabold text-white">Kuat</p>
          <p class="text-white/50 text-[11px] tracking-wide uppercase" data-i18n="reset_stat1">Aman</p>
        </div>
      </div>
    </div>
  </div>

  {{-- RIGHT PANEL --}}
  <div class="w-full lg:w-[48%] flex items-center justify-center relative bg-white min-h-screen overflow-hidden">
    <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full opacity-40 pointer-events-none" style="background: radial-gradient(circle, #FFF0F6 0%, transparent 70%);"></div>
    <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full opacity-30 pointer-events-none" style="background: radial-gradient(circle, #FFE0EC 0%, transparent 70%);"></div>

    <div class="w-full max-w-[420px] mx-auto px-6 sm:px-8 py-10 relative z-10">
      <div class="flex items-center justify-center space-x-2.5 mb-10 lg:hidden">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-lg shadow-primary-500/30">
          <img src="/images/LogoEFA.svg" alt="Logo EFA" class="w-7 h-7 object-contain" />
        </div>
        <span class="font-extrabold text-xl text-primary-700" style="font-family:'Oswald',sans-serif;">EFA</span>
      </div>

      <div class="mb-8">
        <h1 class="text-[1.75rem] font-extrabold text-gray-900 mb-1.5" data-i18n="reset_title">Reset Password 🔒</h1>
        <p class="text-gray-400 text-[15px]" data-i18n="reset_subtitle">Masukkan email Anda dan password baru yang ingin Anda gunakan.</p>
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

      <form method="POST" action="{{ route('password.update') }}" id="resetForm" novalidate class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

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
              value="{{ old('email', $email ?? '') }}"
              required
              autocomplete="email"
              class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/60 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100/60 focus:bg-white transition-all duration-200 @error('email') border-red-300 bg-red-50/30 @enderror"
            />
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
          <div class="relative group">
            <div class="absolute left-0 top-0 bottom-0 w-11 flex items-center justify-center text-gray-400 group-focus-within:text-primary-500 transition-colors pointer-events-none">
              <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            </div>
            <input
              type="password"
              id="password"
              name="password"
              required
              minlength="8"
              class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-200 bg-gray-50/60 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100/60 focus:bg-white transition-all duration-200 @error('password') border-red-300 bg-red-50/30 @enderror"
            />
            <button
              type="button"
              id="togglePassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition-colors p-1"
            >
              <svg id="eyeIconShow" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              <svg id="eyeIconHide" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
            </button>
          </div>
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
          <div class="relative group">
            <div class="absolute left-0 top-0 bottom-0 w-11 flex items-center justify-center text-gray-400 group-focus-within:text-primary-500 transition-colors pointer-events-none">
              <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            </div>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required
              minlength="8"
              class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-200 bg-gray-50/60 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100/60 focus:bg-white transition-all duration-200"
            />
            <button
              type="button"
              id="togglePasswordConfirm"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition-colors p-1"
            >
              <svg id="eyeIconShowConfirm" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              <svg id="eyeIconHideConfirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
            </button>
          </div>
        </div>

        <button
          type="submit"
          id="resetButton"
          class="w-full py-3.5 rounded-xl text-white font-bold text-sm shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 focus:outline-none focus:ring-4 focus:ring-primary-200 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2"
          style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%);"
        >
          <span data-i18n="reset_submit">Reset Password</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const resetTranslations = {
    en: {
      reset_hero_1: "Create Your", reset_hero_2: "New Password",
      reset_hero_desc: "Make sure your new password is strong and easy to remember.",
      reset_stat1: "Secure",
      reset_title: "Reset Password 🔒", reset_subtitle: "Enter your email and the new password you want to use.",
      reset_submit: "Reset Password",
    },
    id: {
      reset_hero_1: "Buat Password", reset_hero_2: "Baru Anda",
      reset_hero_desc: "Pastikan password baru Anda kuat dan mudah diingat.",
      reset_stat1: "Aman",
      reset_title: "Reset Password 🔒", reset_subtitle: "Masukkan email Anda dan password baru yang ingin Anda gunakan.",
      reset_submit: "Reset Password",
    }
  };

  (function() {
    const lang = localStorage.getItem('efa_lang') || 'id';
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (resetTranslations[lang] && resetTranslations[lang][key]) {
        el.textContent = resetTranslations[lang][key];
      }
    });
  })();

  // Toggle password visibility
  function setupToggle(btnId, inputId, showId, hideId) {
    document.getElementById(btnId).addEventListener('click', () => {
      const pw = document.getElementById(inputId);
      const show = document.getElementById(showId);
      const hide = document.getElementById(hideId);
      const isHidden = pw.type === 'password';
      pw.type = isHidden ? 'text' : 'password';
      show.classList.toggle('hidden', isHidden);
      hide.classList.toggle('hidden', !isHidden);
    });
  }

  setupToggle('togglePassword', 'password', 'eyeIconShow', 'eyeIconHide');
  setupToggle('togglePasswordConfirm', 'password_confirmation', 'eyeIconShowConfirm', 'eyeIconHideConfirm');

  let submitting = false;
  document.getElementById('resetForm').addEventListener('submit', (e) => {
    if (submitting) { e.preventDefault(); return; }
    submitting = true;
    const btn = document.getElementById('resetButton');
    const lang = localStorage.getItem('efa_lang') || 'id';
    btn.disabled = true;
    btn.style.opacity = '0.7';
    btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>' + (lang === 'en' ? 'Processing...' : 'Memproses...');
  });
</script>
@endsection
