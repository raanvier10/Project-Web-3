@extends('admin.layout')

@section('admin-content')
<div class="section-container">
  <div class="flex items-center justify-between mb-8">
    <h2 class="text-2xl font-bold">Dashboard Admin</h2>
    <div class="tab-rail">
      <div class="filter-tab active">Ringkasan</div>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="dashboard-card">
      <p class="text-sm text-gray-500">Paket Kursus</p>
      <p class="text-2xl font-extrabold mt-2">{{ $counts['packages'] ?? 0 }}</p>
    </div>
    <div class="dashboard-card">
      <p class="text-sm text-gray-500">Pendaftar Tervalidasi</p>
      <p class="text-2xl font-extrabold mt-2">{{ $counts['registrations'] ?? 0 }}</p>
    </div>
    <div class="dashboard-card">
      <p class="text-sm text-gray-500">Pembayaran Menunggu</p>
      <p class="text-2xl font-extrabold mt-2">{{ $counts['payments_pending'] ?? 0 }}</p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="dashboard-card">
      <h3 class="font-semibold mb-3">Aktivitas Terbaru</h3>
      <p class="text-sm text-gray-500">Placeholder untuk log aktivitas admin.</p>
    </div>
    <div class="dashboard-card">
      <h3 class="font-semibold mb-3">Notifikasi Pembayaran</h3>
      <p class="text-sm text-gray-500">Placeholder untuk notifikasi.</p>
    </div>
  </div>
</div>
@endsection
