@extends('layouts.app')

@section('content')
<!-- Navbar Dashboard -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-lg shadow-lg">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 md:h-20">
      <a href="/" class="flex items-center space-x-2">
        <img src="/images/LogoEFA.svg" alt="Logo EFA" class="w-12 h-12 object-contain" />
        <span class="font-display font-bold text-xl text-primary-700 font-oswal">EFA</span>
      </a>
      <div class="flex items-center space-x-4">
        <span class="text-sm text-gray-600">
          <i class="fas fa-user-circle text-primary-400 mr-1"></i>
          {{ Auth::user()->name }}
        </span>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="inline-flex items-center px-4 py-2 rounded-full border border-red-300 text-red-600 text-sm font-medium hover:bg-red-50 transition">
            <i class="fas fa-sign-out-alt mr-1.5"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>

<!-- Dashboard Content -->
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-pink-50 pt-24 pb-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Welcome -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900"><span data-i18n="dash_welcome">Selamat Datang,</span> {{ Auth::user()->name }}! 👋</h1>
      <p class="text-gray-500 mt-2" data-i18n="dash_subtitle">Dashboard EFA — English For Akhwat</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/40 p-6">
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 rounded-2xl bg-primary-100 flex items-center justify-center">
            <i class="fas fa-book-open text-xl text-primary-600"></i>
          </div>
          <div>
            <p class="text-sm text-gray-500" data-i18n="dash_active">Program Aktif</p>
            <p class="text-2xl font-bold text-gray-900">0</p>
          </div>
        </div>
      </div>
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/40 p-6">
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center">
            <i class="fas fa-check-circle text-xl text-green-600"></i>
          </div>
          <div>
            <p class="text-sm text-gray-500" data-i18n="dash_completed">Sesi Selesai</p>
            <p class="text-2xl font-bold text-gray-900">0</p>
          </div>
        </div>
      </div>
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/40 p-6">
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 rounded-2xl bg-accent-100 flex items-center justify-center">
            <i class="fas fa-certificate text-xl text-accent-600"></i>
          </div>
          <div>
            <p class="text-sm text-gray-500" data-i18n="dash_cert">Sertifikat</p>
            <p class="text-2xl font-bold text-gray-900">0</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/40 p-8">
      <div class="flex items-start space-x-4">
        <div class="w-12 h-12 rounded-2xl bg-primary-100 flex items-center justify-center flex-shrink-0">
          <i class="fas fa-info-circle text-xl text-primary-600"></i>
        </div>
        <div>
          <h3 class="text-lg font-bold text-gray-900 mb-2" data-i18n="dash_info_title">Selamat Datang di Dashboard EFA</h3>
          <p class="text-gray-500 text-sm leading-relaxed" data-i18n="dash_info_desc">
            Dashboard ini sedang dalam tahap pengembangan. Fitur-fitur seperti manajemen program, 
            jadwal kelas, materi pembelajaran, dan sertifikat akan segera tersedia.
            Terima kasih atas kesabaran Anda!
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const dashTranslations = {
    en: {
      dash_welcome: "Welcome,",
      dash_subtitle: "EFA Dashboard — English For Akhwat",
      dash_active: "Active Programs",
      dash_completed: "Completed Sessions",
      dash_cert: "Certificates",
      dash_info_title: "Welcome to EFA Dashboard",
      dash_info_desc: "This dashboard is currently under development. Features such as program management, class schedules, learning materials, and certificates will be available soon. Thank you for your patience!",
    },
    id: {
      dash_welcome: "Selamat Datang,",
      dash_subtitle: "Dashboard EFA — English For Akhwat",
      dash_active: "Program Aktif",
      dash_completed: "Sesi Selesai",
      dash_cert: "Sertifikat",
      dash_info_title: "Selamat Datang di Dashboard EFA",
      dash_info_desc: "Dashboard ini sedang dalam tahap pengembangan. Fitur-fitur seperti manajemen program, jadwal kelas, materi pembelajaran, dan sertifikat akan segera tersedia. Terima kasih atas kesabaran Anda!",
    }
  };

  (function() {
    const lang = localStorage.getItem('efa_lang') || 'id';
    document.getElementById('htmlRoot').lang = lang;
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (dashTranslations[lang] && dashTranslations[lang][key]) {
        el.textContent = dashTranslations[lang][key];
      }
    });
  })();
</script>
@endsection