@extends('admin.layout')

@section('admin-content')
<div class="section-container">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold">Laporan / Cetak</h2>
  </div>

  <div class="dashboard-card">
    <form id="reportFilters" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
      @csrf
      <div>
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" name="from" class="form-input-premium">
      </div>
      <div>
        <label class="form-label">Tanggal Akhir</label>
        <input type="date" name="to" class="form-input-premium">
      </div>
      <div>
        <label class="form-label">Paket Kursus</label>
        <select name="package_id" class="form-input-premium">
          <option value="">Semua Paket</option>
          @foreach($packages as $p)
            <option value="{{ $p->id }}">{{ $p->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="md:col-span-3 flex items-center gap-3 justify-end mt-2">
        <button type="button" class="btn-secondary" id="btnExportPdf">Export PDF</button>
        <button type="button" class="btn-secondary" id="btnExportExcel">Export Excel</button>
        <button type="button" class="btn-primary" id="btnPrint">Cetak Laporan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('admin-scripts')
<script>
  // small helper handlers will be used by admin.js; leave placeholders
</script>
@endsection
