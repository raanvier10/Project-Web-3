<!-- Hero Section -->
<section id="hero" class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-primary-50 via-white to-pink-50">
  <!-- Decorative blobs -->
  <div class="absolute top-20 -left-32 w-96 h-96 bg-primary-200/30 blob animate-float"></div>
  <div class="absolute bottom-10 -right-32 w-80 h-80 bg-primary-300/30 blob animate-float-slow"></div>
  <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-primary-200/20 blob animate-float" style="animation-delay:-3s"></div>

  <div class="section-container relative z-10 py-32">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <!-- Text -->
      <div class="reveal">
        <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-primary-100 text-primary-700 text-sm font-medium mb-6">
          <i class="fas fa-graduation-cap"></i>
          <span data-i18n="hero_badge">Kursus Bahasa Inggris Khusus Akhwat</span>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
          <span class="text-gray-900" data-i18n="hero_title1">Pelopor Kursus</span><br>
          <span class="gradient-text font-display" data-i18n="hero_title2">Bahasa Inggris</span><br>
          <span class="text-gray-900" data-i18n="hero_title3">Keluarga Muslim</span>
        </h1>
        <p class="text-gray-500 text-lg mb-8 max-w-lg" data-i18n="hero_desc">
          English for Akhwat adalah kursus bahasa Inggris khusus Muslimah dengan suasana belajar yang nyaman, aman, dan suportif. Belajar lebih mudah, terarah, dan aplikatif dalam kehidupan sehari-hari.
        </p>
        <div class="flex flex-wrap gap-4">
          <a href="#packages" class="btn-primary"><span data-i18n="hero_cta1">Lihat Paket</span> <i class="fas fa-arrow-right ml-2"></i></a>
          <a href="#placement" class="btn-secondary"><span data-i18n="hero_cta2">Placement Test</span></a>
        </div>
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
          <div><p class="text-2xl md:text-3xl font-bold gradient-text">300+</p><p class="text-gray-400 text-sm" data-i18n="hero_stat1">Alumni</p></div>
          <div><p class="text-2xl md:text-3xl font-bold gradient-text">4.9</p><p class="text-gray-400 text-sm" data-i18n="hero_stat2">Rating</p></div>
          <div><p class="text-2xl md:text-3xl font-bold gradient-text">15</p><p class="text-gray-400 text-sm" data-i18n="hero_stat3">Program</p></div>
        </div>
      </div>
      <!-- Image -->
      <div class="reveal relative flex justify-center">
        <div class="relative">
          <div class="absolute inset-0 bg-gradient-to-br from-primary-400 to-primary-300 rounded-3xl transform rotate-3 scale-105 opacity-20"></div>
          <img src="{{ asset('images/hero.png') }}" alt="EFA Learning" class="relative rounded-3xl shadow-2xl w-full max-w-lg">
        </div>
      </div>
    </div>
  </div>
</section>
