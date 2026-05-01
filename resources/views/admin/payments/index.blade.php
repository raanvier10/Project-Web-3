@extends('admin.layout')

@section('admin-content')
<div class="section-container">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold">Verifikasi Pembayaran</h2>
    <div class="tab-rail">
      <div class="filter-tab active">Menunggu Verifikasi</div>
    </div>
  </div>

  <div class="dashboard-card overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left text-gray-500">
          <th class="py-3 pr-4">#</th>
          <th class="py-3 pr-4">Invoice</th>
          <th class="py-3 pr-4">Nama</th>
          <th class="py-3 pr-4">Paket</th>
          <th class="py-3 pr-4">Jumlah</th>
          <th class="py-3 pr-4">Status</th>
          <th class="py-3 pr-4">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($payments as $p)
        <tr class="border-t">
          <td class="py-3 pr-4">{{ $loop->iteration }}</td>
          <td class="py-3 pr-4">{{ $p->invoice_no }}</td>
          <td class="py-3 pr-4">{{ $p->registration->name ?? $p->payer_name }}</td>
          <td class="py-3 pr-4">{{ $p->registration->course_package->title ?? '-' }}</td>
          <td class="py-3 pr-4">Rp {{ number_format($p->amount,0,',','.') }}</td>
          <td class="py-3 pr-4"><span class="status-badge status-verifying">Menunggu Verifikasi</span></td>
          <td class="py-3 pr-4">
            <div class="flex items-center gap-2">
              <button class="btn-secondary text-xs" data-modal-open="paymentDetailModal" data-payment='@json($p)'>Detail</button>
              <button class="btn-primary text-xs" data-action="accept-payment" data-url="{{ route('admin.payments.accept', $p->id) }}">Accept</button>
              <button class="btn-secondary text-xs" data-action="reject-payment" data-url="{{ route('admin.payments.reject', $p->id) }}">Reject</button>
            </div>
          </td>
        </tr>
        @endforeach
        @if(count($payments)===0)
        <tr><td colspan="7" class="py-6 text-center text-gray-500">Tidak ada pembayaran menunggu.</td></tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

@include('admin.partials.payment_detail_modal')

@endsection
