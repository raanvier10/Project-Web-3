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
        /* ============================== */
        /* CUSTOM DASHBOARD STYLES        */
        /* ============================== */

        /* Animated mesh gradient background */
        .dash-bg {
            background:
                radial-gradient(ellipse 80% 50% at 20% 80%, rgba(255,133,187,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 60% at 80% 20%, rgba(199,78,131,0.06) 0%, transparent 50%),
                radial-gradient(ellipse 50% 50% at 50% 50%, rgba(250,232,255,0.1) 0%, transparent 60%),
                linear-gradient(160deg, #fafbff 0%, #fdf2f8 30%, #faf5ff 60%, #f8fafc 100%);
            min-height: 100vh;
        }

        /* Sidebar glass morphism */
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

        /* Sidebar nav link — premium hover */
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
            text-decoration: none;
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

        /* Nav icon ring on active */
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

        /* Header glass bar */
        .header-glass {
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        /* Floating card with depth */
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

        /* Glow stat card */
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

        /* Animated gradient border on focus */
        .gradient-border {
            position: relative;
        }
        .gradient-border::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 22px;
            background: linear-gradient(135deg, #FF85BB, #C74E83, #FF85BB);
            background-size: 200% 200%;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .gradient-border:focus-within::after {
            opacity: 1;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Page enter animation */
        @keyframes pageEnter {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Pulse dot */
        .pulse-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            animation: pulseDot 2s ease-in-out infinite;
        }
        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="dash-bg flex min-h-screen">
        {{-- ========================= --}}
        {{-- SIDEBAR                   --}}
        {{-- ========================= --}}
        <aside id="dashSidebar" class="sidebar-glass fixed inset-y-0 left-0 w-64 z-50 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full">
            {{-- Logo --}}
            <div class="relative z-10 px-6 py-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-extrabold text-lg leading-tight tracking-tight">EFA</h1>
                        <p class="text-white/50 text-[10px] font-semibold uppercase tracking-widest">Dashboard</p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="relative z-10 mx-5 mb-3 h-px" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);"></div>

            {{-- Navigation --}}
            <nav class="relative z-10 flex-1 px-4 space-y-1 overflow-y-auto">
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-2">Menu</p>

                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.*') ? 'active' : '' }}" id="nav-dashboard">
                    <div class="nav-icon-wrap"><i class="fas fa-th-large text-sm"></i></div>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('dashboard.packages') }}" class="nav-item {{ request()->routeIs('dashboard.packages') ? 'active' : '' }}" id="nav-packages">
                    <div class="nav-icon-wrap"><i class="fas fa-box-open text-sm"></i></div>
                    <span>Daftar Paket</span>
                </a>

                <a href="{{ route('dashboard.transactions') }}" class="nav-item {{ request()->routeIs('dashboard.transactions') || request()->routeIs('dashboard.payment') ? 'active' : '' }}" id="nav-transactions">
                    <div class="nav-icon-wrap"><i class="fas fa-receipt text-sm"></i></div>
                    <span>Transaksi Saya</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="relative z-10 p-4">
                <div class="rounded-2xl p-4" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));">
                            <i class="fas fa-user text-white/80 text-sm"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-white font-bold text-sm truncate">{{ auth()->user()->name }}</p>
                            <p class="text-white/40 text-[10px] truncate">Peserta</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full py-2 rounded-xl text-white/60 hover:text-white text-xs font-semibold transition-all duration-200 hover:bg-white/10">
                            <i class="fas fa-sign-out-alt mr-1.5"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Mobile sidebar overlay --}}
        <div id="sidebarOverlay" class="sidebar-overlay hidden lg:hidden" onclick="toggleDashSidebar()"></div>

        {{-- ========================= --}}
        {{-- MAIN CONTENT              --}}
        {{-- ========================= --}}
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
            {{-- Header --}}
            <header class="header-glass sticky top-0 z-30 px-4 sm:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        {{-- Mobile menu toggle --}}
                        <button onclick="toggleDashSidebar()" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors" id="btn-toggle-sidebar">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-gray-400 text-xs">English For Akhwat (EFA)</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        {{-- Quick User --}}
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                            <i class="fas fa-user text-primary-700 text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="fixed top-6 right-6 z-[10000] px-6 py-4 rounded-2xl text-white font-semibold text-sm shadow-xl" style="background: linear-gradient(135deg, #10B981, #34D399); animation: slideInToast 0.4s ease forwards;" id="successToast">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="fixed top-6 right-6 z-[10000] px-6 py-4 rounded-2xl text-white font-semibold text-sm shadow-xl" style="background: linear-gradient(135deg, #EF4444, #F87171); animation: slideInToast 0.4s ease forwards;" id="errorToast">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 px-4 sm:px-8 py-6">
                @yield('dashboard-content')
            </main>

            {{-- Footer --}}
            <footer class="px-4 sm:px-8 py-4 text-center">
                <p class="text-gray-300 text-xs">&copy; {{ date('Y') }} English For Akhwat (EFA). All rights reserved.</p>
            </footer>
        </div>
    </div>

    {{-- Sidebar Toggle Script --}}
    <script>
        function toggleDashSidebar() {
            const sidebar = document.getElementById('dashSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Auto-dismiss toast notifications
        document.querySelectorAll('[id$="Toast"]').forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                toast.style.transition = 'all 0.4s ease';
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        });
    </script>

    <style>
        @keyframes slideInToast {
            from { opacity: 0; transform: translateX(100%); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>

    @yield('scripts')
</body>
</html>
