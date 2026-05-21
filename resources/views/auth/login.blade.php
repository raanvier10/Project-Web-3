@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row overflow-x-hidden">
  {{-- ============================================ --}}
  {{-- LEFT PANEL – Branding & Decorative            --}}
  {{-- ============================================ --}}
  <div class="hidden lg:flex lg:w-[52%] relative overflow-hidden" style="background: linear-gradient(135deg, #C74E83 0%, #E8699F 30%, #FF85BB 60%, #FFA3C7 100%);">
    {{-- Decorative floating orbs --}}
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full animate-float" style="background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);"></div>
      <div class="absolute bottom-10 -right-32 w-[480px] h-[480px] rounded-full animate-float-slow" style="background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
      <div class="absolute top-1/3 left-1/4 w-64 h-64 rounded-full animate-float" style="animation-delay:-3s; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);"></div>
      {{-- Subtle dot pattern --}}
      <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 flex flex-col justify-center gap-12 w-full h-full min-h-screen px-12 xl:px-16 2xl:px-20 py-16">
      {{-- Top: Logo --}}
      <div class="flex items-center space-x-3">
          <img src="/images/EFA.svg" alt="Logo EFA" class="w-8 h-8 object-contain" />
        <span class="font-extrabold text-2xl text-white tracking-wide" style="font-family:'Oswald',sans-serif;">EFA</span>
      </div>

      {{-- Center: Hero text --}}
      <div class="flex flex-col justify-center">
        <h2 class="text-4xl xl:text-[2.75rem] 2xl:text-5xl font-extrabold text-white leading-[1.15] mb-5">
          <span data-i18n="login_hero_1">Mulai Perjalanan</span><br>
          <span class="text-white/80" data-i18n="login_hero_2">Bahasa Inggrismu</span>
        </h2>
        <p class="text-white/70 text-base xl:text-lg leading-relaxed max-w-sm mb-10" data-i18n="login_hero_desc">
          Bergabung dengan ratusan akhwat yang telah meningkatkan kemampuan bahasa Inggris mereka bersama EFA.
        </p>

        {{-- Testimonial glass card --}}
        <div class="max-w-sm rounded-2xl p-5 border border-white/15 shadow-2xl" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);">
          <div class="flex items-center space-x-0.5 mb-3">
            @for($i = 0; $i < 5; $i++)
            <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
          </div>
          <p class="text-white/90 text-sm leading-relaxed italic mb-4" data-i18n="login_testi">
            "Hampir 1 tahun belajar di English For Akhwat, saya mulai lagi dari dasar karena sudah lama tidak menggunakan bahasa Inggris dan banyak kosakata yang lupa. Materi disampaikan full English sehingga membantu saya terbiasa memahami. Penjelasannya juga mudah dipahami. Saya berharap bisa lebih percaya diri saat berbicara bahasa Inggris."
          </p>
          <div class="flex items-center space-x-3">
              <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-primary-700" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">DW</div>
            <div>
              <p class="text-white font-semibold text-sm">Dian Wahyudi</p>
              <p class="text-white/50 text-xs" data-i18n="login_testi_role">Pekanbaru</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Bottom: Stats --}}
      <div class="flex items-center space-x-6">
        <div class="text-center">
          <p class="text-2xl font-extrabold text-white">300+</p>
          <p class="text-white/50 text-[11px] tracking-wide uppercase" data-i18n="login_stat1">Alumni</p>
        </div>
        <div class="w-px h-8 bg-white/20"></div>
        <div class="text-center">
          <p class="text-2xl font-extrabold text-white">4.9</p>
          <p class="text-white/50 text-[11px] tracking-wide uppercase">Rating</p>
        </div>
        <div class="w-px h-8 bg-white/20"></div>
        <div class="text-center">
          <p class="text-2xl font-extrabold text-white">15</p>
          <p class="text-white/50 text-[11px] tracking-wide uppercase" data-i18n="login_stat3">Program</p>
        </div>
      </div>
    </div>
  </div>

  {{-- ============================================ --}}
  {{-- RIGHT PANEL – Login Form                      --}}
  {{-- ============================================ --}}
  <div class="w-full lg:w-[48%] flex items-center justify-center relative bg-white min-h-screen overflow-hidden">
    {{-- Subtle decorative blobs (mobile + desktop) --}}
    <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full opacity-40 pointer-events-none" style="background: radial-gradient(circle, #FFF0F6 0%, transparent 70%);"></div>
    <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full opacity-30 pointer-events-none" style="background: radial-gradient(circle, #FFE0EC 0%, transparent 70%);"></div>

    <div class="w-full max-w-[420px] mx-auto px-6 sm:px-8 py-10 relative z-10">
      {{-- Mobile Logo --}}
      <div class="flex items-center justify-center space-x-2.5 mb-10 lg:hidden">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-lg shadow-primary-500/30">
          <img src="/images/LogoEFA.svg" alt="Logo EFA" class="w-7 h-7 object-contain" />
        </div>
        <span class="font-extrabold text-xl text-primary-700" style="font-family:'Oswald',sans-serif;">EFA</span>
      </div>

      {{-- Back link --}}
      <a href="/" class="inline-flex items-center text-sm text-gray-400 hover:text-primary-600 transition-colors duration-200 mb-8 group">
        <svg class="w-4 h-4 mr-1.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        <span data-i18n="auth_back">Kembali ke Beranda</span>
      </a>

      {{-- Header --}}
      <div class="mb-8">
        <h1 class="text-[1.75rem] font-extrabold text-gray-900 mb-1.5" data-i18n="login_title">Selamat Datang! 👋</h1>
        <p class="text-gray-400 text-[15px]" data-i18n="login_subtitle">Masuk ke akun EFA Anda untuk melanjutkan</p>
      </div>

      {{-- Error Messages --}}
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

      {{-- Login Form --}}
      <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate class="space-y-5">
        @csrf

        {{-- Email --}}
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

        {{-- Password --}}
        <div>
          <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
          <div class="relative group">
            <div class="absolute left-0 top-0 bottom-0 w-11 flex items-center justify-center text-gray-400 group-focus-within:text-primary-500 transition-colors pointer-events-none">
              <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            </div>
            <input
              type="password"
              id="password"
              name="password"
              required
              autocomplete="current-password"
              minlength="8"
              placeholder="Minimal 8 karakter"
              class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-gray-200 bg-gray-50/60 text-gray-900 placeholder-gray-400 text-sm focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100/60 focus:bg-white transition-all duration-200 @error('password') border-red-300 bg-red-50/30 @enderror"
            />
            <button
              type="button"
              id="togglePassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 transition-colors p-1"
              aria-label="Toggle password visibility"
            >
              <svg id="eyeIconShow" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              <svg id="eyeIconHide" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
            </button>
          </div>
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between pt-1">
          <label class="flex items-center cursor-pointer group select-none">
            <input
              type="checkbox"
              name="remember"
              id="remember"
              class="w-[18px] h-[18px] rounded border-gray-300 text-primary-600 focus:ring-primary-400 focus:ring-offset-0 transition cursor-pointer"
              {{ old('remember') ? 'checked' : '' }}
            />
            <span class="ml-2.5 text-sm text-gray-500 group-hover:text-gray-700 transition-colors" data-i18n="login_remember">Ingat saya</span>
          </label>
          <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 transition-colors" data-i18n="login_forgot">Lupa password?</a>
        </div>

        {{-- Submit --}}
        <button
          type="submit"
          id="loginButton"
          class="w-full py-3.5 rounded-xl text-white font-bold text-sm shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 focus:outline-none focus:ring-4 focus:ring-primary-200 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2"
          style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%);"
        >
          <span data-i18n="login_submit">Masuk ke Akun</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </button>
      </form>

      {{-- Divider --}}
      <div class="relative my-7">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
        <div class="relative flex justify-center"><span class="bg-white px-4 text-xs text-gray-400 uppercase tracking-widest" data-i18n="auth_or">atau</span></div>
      </div>

      {{-- Register link --}}
      <a href="{{ route('register') }}" class="w-full py-3.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-sm hover:border-primary-300 hover:bg-primary-50/60 hover:text-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-100 transition-all duration-200 flex items-center justify-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
        <span data-i18n="login_register_link">Buat Akun Baru</span>
      </a>

      {{-- Security badge --}}
      <div class="mt-8 text-center">
        <p class="text-xs text-gray-400 flex items-center justify-center space-x-1.5">
          <svg class="w-3.5 h-3.5 text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/></svg>
          <span data-i18n="auth_security">Dilindungi enkripsi & autentikasi aman</span>
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
      login_hero_1: "Start Your", login_hero_2: "English Journey",
      login_hero_desc: "Join hundreds of akhwat who have improved their English skills with EFA.",
        login_testi: "\"It's been almost 1 year studying at English For Akhwat. I started from the basics again because I hadn't used English in a long time and forgot a lot of vocabulary. The material is delivered fully in English so it helps me get used to understanding it. The explanations are also easy to grasp. I hope to be more confident when speaking English.\"",
      login_testi_role: "Pekanbaru",
      login_stat1: "Alumni", login_stat3: "Programs",
      auth_back: "Back to Home",
      login_title: "Welcome! 👋", login_subtitle: "Sign in to your EFA account to continue",
      login_remember: "Remember me",
      login_submit: "Sign In",
      login_forgot: "Forgot password?",
      auth_or: "or",
      login_register_link: "Create New Account",
      auth_security: "Protected by encryption & secure authentication",
    },
    id: {
      login_hero_1: "Mulai Perjalanan", login_hero_2: "Bahasa Inggrismu",
      login_hero_desc: "Bergabung dengan ratusan akhwat yang telah meningkatkan kemampuan bahasa Inggris mereka bersama EFA.",
        login_testi: "\"Hampir 1 tahun belajar di English For Akhwat, saya mulai lagi dari dasar karena sudah lama tidak menggunakan bahasa Inggris dan banyak kosakata yang lupa. Materi disampaikan full English sehingga membantu saya terbiasa memahami. Penjelasannya juga mudah dipahami. Saya berharap bisa lebih percaya diri saat berbicara bahasa Inggris.\"",
      login_testi_role: "Pekanbaru",
      login_stat1: "Alumni", login_stat3: "Program",
      auth_back: "Kembali ke Beranda",
      login_title: "Selamat Datang! 👋", login_subtitle: "Masuk ke akun EFA Anda untuk melanjutkan",
      login_remember: "Ingat saya",
      login_submit: "Masuk ke Akun",
      login_forgot: "Lupa password?",
      auth_or: "atau",
      login_register_link: "Buat Akun Baru",
      auth_security: "Dilindungi enkripsi & autentikasi aman",
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
    if (lang === 'en') {
      document.getElementById('password').placeholder = 'Minimum 8 characters';
    }
  })();

  // Toggle password visibility
  document.getElementById('togglePassword').addEventListener('click', () => {
    const pw = document.getElementById('password');
    const show = document.getElementById('eyeIconShow');
    const hide = document.getElementById('eyeIconHide');
    const isHidden = pw.type === 'password';
    pw.type = isHidden ? 'text' : 'password';
    show.classList.toggle('hidden', isHidden);
    hide.classList.toggle('hidden', !isHidden);
  });

  // Prevent double submit
  let submitting = false;
  document.getElementById('loginForm').addEventListener('submit', (e) => {
    if (submitting) { e.preventDefault(); return; }
    submitting = true;
    const btn = document.getElementById('loginButton');
    const lang = localStorage.getItem('efa_lang') || 'id';
    btn.disabled = true;
    btn.style.opacity = '0.7';
    btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>' + (lang === 'en' ? 'Processing...' : 'Memproses...');
  });
</script>
@endsection