<!DOCTYPE html>
<html lang="id" id="htmlRoot">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - English For Akhwat (EFA)</title>
    <meta name="description" content="Dashboard EFA - Kelola program kursus bahasa Inggris Anda.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .dash-bg {
            background:
                radial-gradient(ellipse 80% 50% at 20% 80%, rgba(255,133,187,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 60% at 80% 20%, rgba(199,78,131,0.06) 0%, transparent 50%),
                radial-gradient(ellipse 50% 50% at 50% 50%, rgba(250,232,255,0.1) 0%, transparent 60%),
                linear-gradient(160deg, #fafbff 0%, #fdf2f8 30%, #faf5ff 60%, #f8fafc 100%);
            min-height: 100vh;
        }

        .sidebar-glass {
            background: linear-gradient(180deg, rgba(199,78,131,0.97) 0%, rgba(232,105,159,0.95) 50%, rgba(255,133,187,0.93) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .sidebar-glass::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(255,255,255,0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .sidebar-glass::after {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image: radial-gradient(circle, #fff 1px, transparent 1px);
            background-size: 20px 20px;
            pointer-events: none;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            border-radius: 14px;
            color: rgba(255,255,255,0.65);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            overflow: hidden;
        }
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.1));
            border-radius: 14px;
            transition: width 0.3s ease;
        }
        .nav-item:hover {
            color: #fff;
            transform: translateX(4px);
        }
        .nav-item:hover::before { width: 100%; }

        .nav-item.active {
            color: #fff;
            font-weight: 700;
            background: rgba(255,255,255,0.18);
            box-shadow: 0 4px 24px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.15);
        }
        .nav-item.active::before { width: 0; }

        .nav-item.active .nav-icon-wrap {
            background: rgba(255,255,255,0.25);
            box-shadow: 0 0 12px rgba(255,255,255,0.15);
        }

        .nav-icon-wrap {
            width: 32px; height: 32px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.1);
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .header-glass {
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        .float-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow:
                0 1px 3px rgba(0,0,0,0.04),
                0 8px 32px rgba(199,78,131,0.06),
                0 2px 8px rgba(0,0,0,0.02);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .float-card:hover {
            box-shadow:
                0 4px 12px rgba(0,0,0,0.06),
                0 16px 48px rgba(199,78,131,0.12),
                0 4px 16px rgba(0,0,0,0.04);
            transform: translateY(-2px);
        }

        .glow-stat {
            position: relative;
            overflow: hidden;
        }
        .glow-stat::before {
            content: '';
            position: absolute;
            top: -50%; right: -50%;
            width: 100%; height: 100%;
            border-radius: 50%;
            transition: opacity 0.4s ease;
            opacity: 0;
        }
        .glow-stat:hover::before {
            opacity: 1;
        }

        .pulse-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            animation: pulseDot 2s ease-in-out infinite;
        }
        @keyframes pulseDot {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 currentColor; }
            50% { opacity: 0.8; box-shadow: 0 0 0 6px transparent; }
        }

        @keyframes pageEnter {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-enter {
            animation: pageEnter 0.6s cubic-bezier(0.4,0,0.2,1) forwards;
        }
    </style>
</head>
<body class="overflow-x-hidden font-sans antialiased text-gray-800">
{{-- Universal Modal --}}
<div id="universalModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" id="modalBackdrop"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100">
            <div class="bg-white px-6 pt-8 pb-6 sm:px-8 sm:pb-8">
                <div class="flex flex-col items-center text-center">
                    
                    <div id="modalIconContainer" class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-2xl bg-red-50 text-red-500 mb-5">
                        <i id="modalIcon" class="fas fa-exclamation-triangle text-2xl"></i>
                    </div>
                    
                    <div class="mt-3">
                        <h3 class="text-xl font-extrabold text-gray-900" id="modalTitle">Konfirmasi</h3>
                        <div class="mt-3">
                            <p class="text-sm text-gray-500 leading-relaxed" id="modalDescription"></p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="button" id="modalConfirmBtn" class="w-full inline-flex justify-center items-center px-6 py-3.5 rounded-xl text-white text-sm font-bold focus:outline-none transition-all shadow-lg"></button>
                    <button type="button" id="modalCancelBtn" class="w-full inline-flex justify-center items-center px-6 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-600 text-sm font-bold hover:bg-gray-50 focus:outline-none transition-all">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.showUniversalModal = function(options) {
        const modal = document.getElementById('universalModal');
        const title = document.getElementById('modalTitle');
        const desc = document.getElementById('modalDescription');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const backdrop = document.getElementById('modalBackdrop');
        const icon = document.getElementById('modalIcon');
        const iconContainer = document.getElementById('modalIconContainer');

        title.innerText = options.title || 'Konfirmasi';
        desc.innerText = options.description || '';
        confirmBtn.innerText = options.confirmText || 'Ya, Lanjutkan';
        
        // Icon handling
        icon.className = `fas ${options.icon || 'fa-exclamation-triangle'} text-2xl`;
        
        // MODIFIKASI JAVASCRIPT: Menghapus 'sm:mx-0' di sini juga agar saat fungsi dipanggil, class center-nya tidak tertimpa/hilang
        iconContainer.className = `mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-2xl mb-5 ${options.iconClass || 'bg-red-50 text-red-500'}`;
        
        // Button class handling
        confirmBtn.className = `w-full inline-flex justify-center items-center px-6 py-3.5 rounded-xl text-white text-sm font-bold focus:outline-none transition-all shadow-lg ${options.confirmClass || 'bg-red-500 hover:bg-red-600 shadow-red-200'}`;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        const closeModal = () => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        };

        confirmBtn.onclick = () => {
            if (options.onConfirm) options.onConfirm();
            closeModal();
        };

        cancelBtn.onclick = closeModal;
        backdrop.onclick = closeModal;
    };
</script>

<div class="dash-bg flex min-h-screen">

    {{-- ========================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================= --}}
    <aside id="pesertaSidebar" class="sidebar-glass fixed inset-y-0 left-0 w-[250px] z-50 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full shadow-2xl shadow-pink-900/10 overflow-y-auto">
        <div class="relative z-10 px-6 pt-7 pb-5 border-b border-white/10">
            <div class="flex items-center gap-3.5">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/18 backdrop-blur-sm shadow-lg shadow-black/5 ring-1 ring-white/20">
                    <img src="/images/EFA.svg" alt="Logo EFA" class="h-8 w-8 object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-white font-bold text-lg\'>E</span>'" />
                </div>
                <div class="min-w-0">
                    <span class="block font-extrabold text-[24px] leading-none text-white tracking-wide" style="font-family:'Oswald',sans-serif;">EFA</span>
                    <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.24em] text-white/45">Dashboard Peserta</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 mx-5 mt-5 mb-6 rounded-2xl p-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.12);">
            <div class="flex items-center gap-3.5">
                <div class="flex h-12 w-12 items-center justify-center rounded-full text-sm font-bold ring-2 ring-white/20" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9); color: #C74E83;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-white/45">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <nav class="relative z-10 flex-1 px-5 space-y-2">
            <p class="px-4 mb-3 text-[10px] font-bold uppercase tracking-[0.24em] text-white/35">Menu Utama</p>

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.*') ? 'active' : '' }}" id="nav-overview">
                <div class="nav-icon-wrap"><i class="fas fa-th-large text-[13px]"></i></div>
                <span>Overview</span>
            </a>

            <a href="{{ route('dashboard.packages') }}" class="nav-item {{ request()->routeIs('dashboard.packages') ? 'active' : '' }}" id="nav-packages">
                <div class="nav-icon-wrap"><i class="fas fa-book-open text-[13px]"></i></div>
                <span>Paket Kursus</span>
            </a>

            <a href="{{ route('dashboard.transactions') }}" class="nav-item {{ request()->routeIs('dashboard.transactions') ? 'active' : '' }}" id="nav-transactions">
                <div class="nav-icon-wrap"><i class="fas fa-receipt text-[13px]"></i></div>
                <span>Riwayat Transaksi</span>
            </a>

            <div class="!mt-8 rounded-2xl border border-white/10 bg-white/5 p-3">
                <p class="px-1 mb-3 text-[10px] font-bold uppercase tracking-[0.24em] text-white/35">Akun</p>
                <a href="/" class="nav-item" id="nav-home">
                    <div class="nav-icon-wrap"><i class="fas fa-home text-[13px]"></i></div>
                    <span>Kembali ke Beranda</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item w-full text-left" id="nav-logout">
                        <div class="nav-icon-wrap" style="background: rgba(239,68,68,0.15);"><i class="fas fa-sign-out-alt text-[13px] text-red-200"></i></div>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </nav>

        <div class="relative z-10 px-7 py-5 border-t border-white/10">
            <p class="text-center text-[10px] tracking-wide text-white/28">© {{ date('Y') }} English For Akhwat</p>
        </div>
    </aside>

    {{-- Mobile sidebar overlay --}}
    <div id="pesertaOverlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 hidden lg:hidden" onclick="togglePesertaSidebar()"></div>

    {{-- ========================= --}}
    {{-- MAIN CONTENT              --}}
    <div class="flex-1 flex flex-col min-h-screen lg:ml-[250px]" id="mainContent">

        <header class="sticky top-0 z-30 header-glass">
            <div class="flex items-center justify-between px-6 sm:px-8 lg:px-10 h-[76px]">
                <div class="flex items-center gap-4">
                    {{-- Hamburger toggle (mobile only) --}}
                    <button onclick="togglePesertaSidebar()" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors" id="btn-toggle-peserta-sidebar">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    <h2 class="text-base font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                </div>

                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-gray-500 transition-colors hover:bg-white/70 hover:text-gray-700">
                    <i class="fas fa-home text-gray-400"></i>
                    <span class="hidden sm:inline">Beranda</span>
                </a>
            </div>
        </header>

        @if(session('success'))
        <div class="mx-6 sm:mx-8 lg:mx-10 mt-5" id="flash-success">
            <div class="p-4 rounded-2xl flex items-center space-x-3 flash-animate" style="background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(52,211,153,0.04)); border: 1px solid rgba(16,185,129,0.15);">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <p class="text-green-700 text-sm font-medium flex-1">{{ session('success') }}</p>
                <button onclick="this.closest('#flash-success').remove()" class="text-green-400 hover:text-green-600 transition-colors p-1">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mx-6 sm:mx-8 lg:mx-10 mt-5">
            <div class="p-4 rounded-2xl flash-animate" style="background: linear-gradient(135deg, rgba(239,68,68,0.06), rgba(252,165,165,0.04)); border: 1px solid rgba(239,68,68,0.12);">
                <div class="flex items-start space-x-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #FEE2E2, #FECACA);">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div>
                        @foreach($errors->all() as $error)
                        <p class="text-red-600 text-sm font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <main class="relative z-10 p-6 sm:p-8 lg:p-10 page-enter flex-1 w-full">
            @yield('dashboard-content')
        </main>
    </div>

</div>

<script>
    function togglePesertaSidebar() {
        const sidebar = document.getElementById('pesertaSidebar');
        const overlay = document.getElementById('pesertaOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // Pastikan margin kiri konten selalu benar di desktop
    function applyMainMargin() {
        const main = document.getElementById('mainContent');
        if (!main) return;
        if (window.innerWidth >= 1024) {
            main.style.marginLeft = '250px';
        } else {
            main.style.marginLeft = '';
        }
    }
    applyMainMargin();
    window.addEventListener('resize', applyMainMargin);

    setTimeout(() => {
        const flash = document.getElementById('flash-success');
        if (flash) {
            flash.style.transition = 'all 0.5s cubic-bezier(0.4,0,0.2,1)';
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-10px)';
            setTimeout(() => flash.remove(), 500);
        }
    }, 5000);
</script>

@yield('scripts')
</body>
</html>
