<!-- Navbar -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 md:h-20">
      <a href="#" class="flex items-center space-x-5">
        <img src="/images/LogoEFA.svg" alt="Logo EFA" class="w-12 h-12 object-contain" />
        <span class="font-display font-bold text-xl -primary-100 text-primary-700 font-oswal">EFA</span> 
      </a>
      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
        <a href="#packages" class="nav-link text-gray-600 hover:text-primary-600 transition" data-i18n="nav_packages">Paket Kursus</a>
        <a href="#placement" class="nav-link text-gray-600 hover:text-primary-600 transition" data-i18n="nav_placement">Placement Test</a>
        <a href="#facilities" class="nav-link text-gray-600 hover:text-primary-600 transition" data-i18n="nav_facilities">Fasilitas</a>
        <a href="#testimonials" class="nav-link text-gray-600 hover:text-primary-600 transition" data-i18n="nav_testimonials">Testimoni</a>
        <a href="#community" class="nav-link text-gray-600 hover:text-primary-600 transition" data-i18n="nav_community">Komunitas</a>
        <a href="#contact" class="nav-link text-gray-600 hover:text-primary-600 transition" data-i18n="nav_contact">Kontak</a>
        <!-- Lang Toggle -->
        <button id="langToggle" onclick="toggleLang()" class="flex items-center space-x-1 px-3 py-1.5 rounded-full border border-primary-300 text-primary-600 hover:bg-primary-50 transition text-xs font-semibold">
          <i class="fas fa-globe"></i>
          <span id="langLabel">EN</span>
        </button>
        <!-- Auth Button -->
        @auth
          <a href="{{ route('dashboard') }}" class="flex items-center space-x-1.5 px-4 py-2 rounded-full bg-gradient-to-r from-primary-600 to-primary-700 text-white text-xs font-semibold shadow-md shadow-primary-500/20 hover:shadow-lg hover:from-primary-500 hover:to-primary-600 transition-all duration-300">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
          </a>
        @else
          <a href="{{ route('login') }}" class="flex items-center space-x-1.5 px-4 py-2 rounded-full bg-gradient-to-r from-primary-600 to-primary-700 text-white text-xs font-semibold shadow-md shadow-primary-500/20 hover:shadow-lg hover:from-primary-500 hover:to-primary-600 transition-all duration-300" data-i18n="nav_login">
            <i class="fas fa-sign-in-alt"></i>
            <span>Masuk</span>
          </a>
        @endauth
      </div>
      <!-- Mobile Menu Button -->
      <button id="menuBtn" onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-bars text-xl text-gray-700"></i>
      </button>
    </div>
  </div>
</nav>

<!-- Sidebar Mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300" onclick="toggleSidebar()"></div>
<aside id="sidebar" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 overflow-y-auto">
  <div class="p-6">
    <div class="flex items-center justify-between mb-8">
      <div class="flex items-center space-x-2">
        <img src="/images/LogoEFA.svg" alt="Logo EFA" class="w-12 h-12 object-contain" />
        <span class="font-display font-bold text-xl -primary-100 text-primary-700 font-oswal">EFA</span> 
      </div>
      <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-times text-gray-500"></i>
      </button>
    </div>
    <nav class="space-y-2">
      <a href="#packages" onclick="toggleSidebar()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition" data-i18n="nav_packages">
        <i class="fas fa-box-open w-5"></i><span>Paket Kursus</span>
      </a>
      <a href="#placement" onclick="toggleSidebar()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition" data-i18n="nav_placement">
        <i class="fas fa-clipboard-check w-5"></i><span>Placement Test</span>
      </a>
      <a href="#facilities" onclick="toggleSidebar()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition" data-i18n="nav_facilities">
        <i class="fas fa-building w-5"></i><span>Fasilitas</span>
      </a>
      <a href="#testimonials" onclick="toggleSidebar()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition" data-i18n="nav_testimonials">
        <i class="fas fa-star w-5"></i><span>Testimoni</span>
      </a>
      <a href="#community" onclick="toggleSidebar()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition" data-i18n="nav_community">
        <i class="fas fa-users w-5"></i><span>Komunitas</span>
      </a>
      <a href="#contact" onclick="toggleSidebar()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition" data-i18n="nav_contact">
        <i class="fas fa-envelope w-5"></i><span>Kontak</span>
      </a>
    </nav>
    <div class="mt-8 pt-6 border-t space-y-3">
      <button onclick="toggleLang();toggleSidebar()" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl border border-primary-300 text-primary-600 hover:bg-primary-50 transition font-semibold text-sm">
        <i class="fas fa-globe"></i>
        <span data-i18n="lang_switch">Switch to English</span>
      </button>
      @auth
        <a href="{{ route('dashboard') }}" onclick="toggleSidebar()" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all">
          <i class="fas fa-th-large"></i>
          <span>Dashboard</span>
        </a>
      @else
        <a href="{{ route('login') }}" onclick="toggleSidebar()" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all" data-i18n="nav_login">
          <i class="fas fa-sign-in-alt"></i>
          <span>Masuk</span>
        </a>
      @endauth
    </div>
  </div>
</aside>
