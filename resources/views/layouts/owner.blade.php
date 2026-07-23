<!DOCTYPE html>
<html lang="id" id="htmlRoot">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Owner Dashboard - English For Akhwat (EFA)</title>
    <meta name="description" content="Owner Dashboard EFA - Pantau operasional dan kelola staff.">
    <link rel="icon" href="/images/LogoEFA.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tom Select (Searchable Dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])

    <style>
        /* ============================== */
        /* OWNER DASHBOARD INLINE STYLES  */
        /* Pink theme - matching peserta  */
        /* ============================== */

        /* Animated mesh gradient background */
        .admin-bg {
            background:
                radial-gradient(ellipse 80% 50% at 20% 80%, rgba(255,133,187,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 60% at 80% 20%, rgba(199,78,131,0.06) 0%, transparent 50%),
                radial-gradient(ellipse 50% 50% at 50% 50%, rgba(250,232,255,0.1) 0%, transparent 60%),
                linear-gradient(160deg, #fafbff 0%, #fdf2f8 30%, #faf5ff 60%, #f8fafc 100%);
            min-height: 100vh;
        }

        /* Sidebar - Pink themed */
        .admin-sidebar {
            background: linear-gradient(180deg, rgba(199,78,131,0.97) 0%, rgba(232,105,159,0.95) 50%, rgba(255,133,187,0.93) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .admin-sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(255,255,255,0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .admin-sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image: radial-gradient(circle, #fff 1px, transparent 1px);
            background-size: 20px 20px;
            pointer-events: none;
        }

        /* Sidebar nav link */
        .admin-nav-item {
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
        .admin-nav-item::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.1));
            border-radius: 14px;
            transition: width 0.3s ease;
        }
        .admin-nav-item:hover {
            color: #fff;
            transform: translateX(4px);
        }
        .admin-nav-item:hover::before { width: 100%; }

        .admin-nav-item.active {
            color: #fff;
            font-weight: 700;
            background: rgba(255,255,255,0.18);
            box-shadow: 0 4px 24px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.15);
        }
        .admin-nav-item.active::before { width: 0; }

        .admin-nav-item.active .admin-icon-wrap {
            background: rgba(255,255,255,0.25);
            box-shadow: 0 0 12px rgba(255,255,255,0.15);
        }

        .admin-icon-wrap {
            width: 32px; height: 32px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.1);
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        /* Header glass bar */
        .admin-header {
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        /* Float card - admin version */
        .admin-float-card {
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
        .admin-float-card:hover {
            box-shadow:
                0 4px 12px rgba(0,0,0,0.06),
                0 16px 48px rgba(199,78,131,0.12),
                0 4px 16px rgba(0,0,0,0.04);
            transform: translateY(-2px);
        }

        /* Page enter animation */
        @keyframes pageEnter {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Pulse dot */
        .admin-pulse-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            animation: adminPulse 2s ease-in-out infinite;
        }
        @keyframes adminPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .toggle-switch.active {
            background: linear-gradient(135deg, #E8699F, #FF85BB);
            box-shadow: 0 2px 8px rgba(199,78,131,0.3);
        }
        .toggle-switch.inactive {
            background: #D1D5DB;
        }
        .toggle-switch .toggle-knob {
            position: absolute;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
            transition: all 0.3s cubic-bezier(0.68,-0.55,0.27,1.55);
        }
        .toggle-switch.active .toggle-knob { left: 22px; }
        .toggle-switch.inactive .toggle-knob { left: 2px; }

        /* Admin data table */
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .admin-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9CA3AF;
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .admin-table tbody tr {
            transition: all 0.2s ease;
        }
        .admin-table tbody tr:hover {
            background: rgba(199,78,131,0.03);
        }
        .admin-table tbody td {
            padding: 14px 16px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            vertical-align: middle;
        }

        /* Modal */
        .admin-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .admin-modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .admin-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 24px 80px rgba(0,0,0,0.15);
            z-index: 9999;
            width: 90%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            opacity: 0;
            visibility: hidden;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .admin-modal.show {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1);
        }
        .admin-modal-header {
            padding: 24px 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-modal-body {
            padding: 20px 24px 24px;
        }

        /* Notification toast */
        .admin-toast {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 10000;
            padding: 16px 24px;
            border-radius: 16px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            animation: slideInToast 0.4s ease forwards;
        }
        .admin-toast.success { background: linear-gradient(135deg, #10B981, #34D399); }
        .admin-toast.error   { background: linear-gradient(135deg, #EF4444, #F87171); }

        @keyframes slideInToast {
            from { opacity: 0; transform: translateX(100%); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="admin-bg flex min-h-screen">
        {{-- ========================= --}}
        {{-- SIDEBAR                   --}}
        {{-- ========================= --}}
        <aside id="ownerSidebar" class="admin-sidebar fixed inset-y-0 left-0 w-64 z-50 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full">
            {{-- Logo --}}
            <div class="relative z-10 px-6 py-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                        <img src="/images/LogoEFA.svg" alt="Logo EFA" class="h-6 w-6 object-contain" />
                    </div>
                    <div>
                        <h1 class="text-white font-extrabold text-lg leading-tight tracking-tight">EFA Owner</h1>
                        <p class="text-white/50 text-[10px] font-semibold uppercase tracking-widest">Owner Panel</p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="relative z-10 mx-5 mb-3 h-px" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);"></div>

            {{-- Navigation --}}
            <nav class="relative z-10 flex-1 px-4 space-y-1 overflow-y-auto">
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-2">Menu Utama</p>

                <a href="{{ route('owner.dashboard') }}" class="admin-nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}" id="nav-owner-dashboard">
                    <div class="admin-icon-wrap"><i class="fas fa-th-large text-sm"></i></div>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('owner.packages') }}" class="admin-nav-item {{ request()->routeIs('owner.packages') ? 'active' : '' }}" id="nav-owner-packages">
                    <div class="admin-icon-wrap"><i class="fas fa-box-open text-sm"></i></div>
                    <span>Paket Kursus</span>
                </a>

                <a href="{{ route('owner.staff') }}" class="admin-nav-item {{ request()->routeIs('owner.staff') ? 'active' : '' }}" id="nav-owner-staff">
                    <div class="admin-icon-wrap"><i class="fas fa-user-gear text-sm"></i></div>
                    <span>Admin & Staff</span>
                </a>

                <a href="{{ route('owner.reports') }}" class="admin-nav-item {{ request()->routeIs('owner.reports') ? 'active' : '' }}" id="nav-owner-reports">
                    <div class="admin-icon-wrap"><i class="fas fa-chart-line text-sm"></i></div>
                    <span>Laporan Keuangan</span>
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
                            <p class="text-white/40 text-[10px] truncate">Owner</p>
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
        <div id="sidebarOverlay" class="sidebar-overlay hidden lg:hidden" onclick="toggleOwnerSidebar()"></div>

        {{-- ========================= --}}
        {{-- MAIN CONTENT              --}}
        {{-- ========================= --}}
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
            {{-- Header --}}
            <header class="admin-header sticky top-0 z-30 px-4 sm:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        {{-- Mobile menu toggle --}}
                        <button onclick="toggleOwnerSidebar()" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors" id="btn-toggle-sidebar">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-gray-400 text-xs">@yield('page-subtitle', 'Owner Panel EFA')</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                            <i class="fas fa-user text-primary-700 text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="admin-toast success" id="successToast">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="admin-toast error" id="errorToast">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
            @endif
            @if($errors->any())
            <div class="admin-toast error" id="validationToast">
                <ul class="list-none p-0 m-0">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 px-4 sm:px-8 py-6">
                @yield('owner-content')
            </main>

            {{-- Footer --}}
            <footer class="px-4 sm:px-8 py-4 text-center">
                <p class="text-gray-300 text-xs">&copy; {{ date('Y') }} English For Akhwat (EFA). Owner Panel.</p>
            </footer>
        </div>
    </div>

    {{-- Sidebar Toggle Script --}}
    <script>
        function toggleOwnerSidebar() {
            const sidebar = document.getElementById('ownerSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Auto-dismiss toast notifications
        document.querySelectorAll('.admin-toast').forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        });

        // Initialize Search Dropdown (Tom Select)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.searchdropdown, .admin-form-select').forEach((el) => {
                const noSort = el.hasAttribute('data-no-sort');
                new TomSelect(el, {
                    create: false,
                    dropdownParent: 'body',
                    sortField: noSort ? null : { field: "text", direction: "asc" },
                    placeholder: el.getAttribute('data-placeholder') || 'Pilih opsi...',
                    plugins: ['clear_button']
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
