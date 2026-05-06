@extends('layouts.app')

@section('content')
<div class="min-h-screen flex bg-gray-50">
  {{-- Sidebar --}}
  <aside class="hidden md:flex md:flex-col w-72 bg-white border-r border-gray-100 p-6 space-y-6">
    <div class="flex items-center space-x-3">
      <img src="/images/LogoEFA.svg" alt="EFA" class="w-8 h-8" />
      <span class="font-extrabold text-lg text-primary-700">EFA Admin</span>
    </div>
    <nav class="flex-1">
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-50' : '' }}"><i class="fa fa-tachometer-alt w-4"></i><span>Dashboard</span></a></li>
        <li><a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 {{ request()->routeIs('admin.packages.*') ? 'bg-gray-50' : '' }}"><i class="fa fa-box w-4"></i><span>Manajemen Paket</span></a></li>
        <li><a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 {{ request()->routeIs('admin.payments.*') ? 'bg-gray-50' : '' }}"><i class="fa fa-receipt w-4"></i><span>Verifikasi Pembayaran</span></a></li>
        <li><a href="{{ route('admin.registrations.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 {{ request()->routeIs('admin.registrations.*') ? 'bg-gray-50' : '' }}"><i class="fa fa-users w-4"></i><span>Manajemen Peserta</span></a></li>
        <li><a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-50' : '' }}"><i class="fa fa-file-alt w-4"></i><span>Laporan / Cetak</span></a></li>
      </ul>
    </nav>
    <div>
      <a href="{{ route('logout') }}" class="btn-secondary w-full text-center py-2.5">Keluar</a>
    </div>
  </aside>

  {{-- Main --}}
  <main class="flex-1 p-6 lg:p-10">
    @yield('admin-content')
  </main>
</div>
@endsection

@section('scripts')
@vite('resources/js/admin.js')
@yield('admin-scripts')
@endsection
