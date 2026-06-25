@extends('admin.layout')

@section('admin-content')
<div class="section-container">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold">Manajemen Peserta</h2>
    <div class="tab-rail">
      <div class="filter-tab active">Tervalidasi</div>
    </div>
  </div>

  <div class="dashboard-card overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-gray-500">
          <th class="py-3 pr-4">#</th>
          <th class="py-3 pr-4">Nama</th>
          <th class="py-3 pr-4">Email</th>
          <th class="py-3 pr-4">Domisili</th>
          <th class="py-3 pr-4">Paket</th>
          <th class="py-3 pr-4">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($registrations as $r)
        <tr class="border-t">
          <td class="py-3 pr-4">{{ $loop->iteration }}</td>
          <td class="py-3 pr-4">{{ $r->name }}</td>
          <td class="py-3 pr-4">{{ $r->email }}</td>
          <td class="py-3 pr-4">{{ $r->detail ? $r->detail->domicile ?? '-' : '-' }}</td>
          <td class="py-3 pr-4">{{ $r->course_package->title ?? '-' }}</td>
          <td class="py-3 pr-4">
            <div class="flex items-center gap-2">
              <button class="btn-secondary text-xs" data-modal-open="registrationDetailModal" data-registration='@json($r)'>Detail</button>
            </div>
          </td>
        </tr>
        @endforeach
        @if(count($registrations)===0)
        <tr><td colspan="6" class="py-6 text-center text-gray-500">Tidak ada peserta tervalidasi.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

@include('admin.partials.registration_detail_modal')
@endsection
