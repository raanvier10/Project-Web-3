@extends('layouts.admin')

@section('page-title', 'Laporan & Export')
@section('page-subtitle', 'Filter, lihat, dan export laporan data')

@section('admin-content')

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4 no-print">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(59,130,246,0.08), rgba(37,99,235,0.04)); border: 1px solid rgba(59,130,246,0.12);">
            <i class="fas fa-chart-bar text-blue-500 text-xs"></i>
            <span class="text-blue-600 text-xs font-semibold">Laporan</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Laporan & Export</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Lihat laporan registrasi dan pembayaran dengan filter tanggal dan paket.</p>
    </div>
</div>

{{-- Filter Section --}}
<div class="admin-float-card !p-5 mb-6" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
    <div class="flex items-center space-x-2 mb-4">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
            <i class="fas fa-filter text-xs text-blue-600"></i>
        </div>
        <h3 class="text-base font-bold text-gray-900">Filter Laporan</h3>
    </div>
    <form method="GET" action="{{ route('admin.reports') }}" id="reportFilterForm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Date From --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-calendar mr-2 text-blue-400 text-xs"></i> Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-form-input" id="filter-date-from">
            </div>
            {{-- Date To --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-calendar mr-2 text-blue-400 text-xs"></i> Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-form-input" id="filter-date-to">
            </div>
            {{-- Package --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-box-open mr-2 text-blue-400 text-xs"></i> Paket Kursus</label>
                <select name="package_id" class="admin-form-select" id="filter-report-package">
                    <option value="">Semua Paket</option>
                    @foreach($packages as $pkg)
                    <option value="{{ $pkg->id }}" {{ request('package_id') == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Status --}}
            <div>
                <label class="admin-form-label"><i class="fas fa-info-circle mr-2 text-blue-400 text-xs"></i> Status</label>
                <select name="status" class="admin-form-select" id="filter-report-status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif / Lunas</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 mt-5">
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="fas fa-search mr-2"></i> Terapkan Filter
            </button>
            @if(request()->hasAny(['date_from', 'date_to', 'package_id', 'status']))
            <a href="{{ route('admin.reports') }}" class="admin-btn admin-btn-outline">
                <i class="fas fa-times mr-2"></i> Reset Filter
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Summary Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.1s; opacity: 0;">
    <div class="admin-float-card !p-5 text-center">
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-1">Total Data</p>
        <p class="text-3xl font-extrabold text-gray-900 tabular-nums">{{ $registrations->count() }}</p>
        <p class="text-xs text-gray-400">registrasi</p>
    </div>
    <div class="admin-float-card !p-5 text-center">
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-1">Pembayaran Valid</p>
        <p class="text-3xl font-extrabold text-emerald-600 tabular-nums">{{ $validCount }}</p>
        <p class="text-xs text-gray-400">peserta lunas</p>
    </div>
    <div class="admin-float-card !p-5 text-center">
        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-1">Total Pemasukan</p>
        <p class="text-2xl font-extrabold tabular-nums print-income" style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Rp {{ number_format($totalAmount, 0, ',', '.') }}
        </p>
        <p class="text-xs text-gray-400">dari semua pembayaran</p>
    </div>
</div>

{{-- Export Actions --}}
<div class="admin-float-card !p-4 mb-6 flex flex-wrap items-center justify-between gap-4" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.15s; opacity: 0;">
    <div class="flex items-center space-x-2">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
            <i class="fas fa-download text-xs text-emerald-600"></i>
        </div>
        <h3 class="text-sm font-bold text-gray-900">Export Data</h3>
    </div>
    <div class="flex flex-wrap gap-2">
        {{-- Export Excel/CSV --}}
        <a href="{{ route('admin.reports.export.excel', request()->query()) }}" class="admin-btn admin-btn-sm" style="background: linear-gradient(135deg, #059669, #10B981); color: #fff; box-shadow: 0 4px 12px rgba(5,150,105,0.2);" id="btn-export-excel">
            <i class="fas fa-file-excel mr-1.5"></i> Export Excel
        </a>
        {{-- Print --}}
        <button onclick="window.print()" class="admin-btn admin-btn-outline admin-btn-sm" id="btn-print">
            <i class="fas fa-print mr-1.5"></i> Cetak
        </button>
    </div>
</div>

{{-- Report Table --}}
<div class="admin-float-card !p-0 overflow-hidden" id="reportTable" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.2s; opacity: 0;">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Registrasi</th>
                    <th>Peserta</th>
                    <th>Email</th>
                    <th>Paket</th>
                    <th>Kategori</th>
                    <th>Jumlah Bayar</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $index => $reg)
                <tr style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ ($index * 0.03) + 0.25 }}s; opacity: 0;">
                    <td class="text-gray-400 font-mono text-sm">{{ $index + 1 }}</td>
                    <td class="font-mono text-sm text-gray-500">{{ $reg->registration_number }}</td>
                    <td>
                        <p class="font-bold text-gray-900 text-sm">{{ $reg->detail ? $reg->detail->name : $reg->user->name }}</p>
                        @if($reg->detail && $reg->detail->domicile)
                        <p class="text-gray-400 text-xs">{{ $reg->detail->domicile }}</p>
                        @endif
                    </td>
                    <td class="text-gray-600 text-sm">{{ $reg->user->email }}</td>
                    <td class="font-semibold text-gray-700 text-sm">{{ $reg->coursePackage->name }}</td>
                    <td>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $reg->coursePackage->category === 'kids' ? 'text-purple-600 bg-purple-50' : 'text-primary-700 bg-primary-50' }}">
                            {{ $reg->coursePackage->category_label }}
                        </span>
                    </td>
                    <td class="font-bold text-gray-900 text-sm">
                        @if($reg->payment)
                            Rp {{ number_format($reg->payment->amount, 0, ',', '.') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td>
                        @if($reg->payment)
                            <span class="admin-badge {{ $reg->payment->payment_status === 'valid' ? 'admin-badge-valid' : ($reg->payment->payment_status === 'rejected' ? 'admin-badge-rejected' : 'admin-badge-pending') }}">
                                {{ $reg->payment->payment_status === 'valid' ? 'Valid' : ($reg->payment->payment_status === 'rejected' ? 'Ditolak' : 'Pending') }}
                            </span>
                        @else
                            <span class="admin-badge admin-badge-inactive">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="text-gray-500 text-sm whitespace-nowrap">{{ $reg->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-16">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                            <i class="fas fa-chart-bar text-2xl text-blue-300"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tidak ada data</p>
                        <p class="text-gray-400 text-xs">Coba ubah filter untuk melihat data lainnya.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Layout Khusus Cetak (Hanya tampil saat diprint) --}}
@php
    $dateFrom = request()->filled('date_from') ? \Carbon\Carbon::parse(request()->date_from)->format('d/m/Y') : '';
    $dateTo = request()->filled('date_to') ? \Carbon\Carbon::parse(request()->date_to)->format('d/m/Y') : '';
    $tanggalText = ($dateFrom || $dateTo) ? ($dateFrom ?: 'Awal') . ' s/d ' . ($dateTo ?: 'Sekarang') : 'Semua Waktu';
    
    $paketText = 'Semua Paket';
    if (request()->filled('package_id')) {
        $pkg = \App\Models\CoursePackage::find(request()->package_id);
        if ($pkg) $paketText = $pkg->name;
    }
    
    $statusText = 'Semua Status';
    if (request()->filled('status')) {
        $statusMap = [
            'pending' => 'Menunggu Pembayaran',
            'active' => 'Aktif / Lunas',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak'
        ];
        $statusText = $statusMap[request()->status] ?? ucfirst(request()->status);
    }
@endphp
<div class="print-only" style="display: none;">
    <h2 class="print-title">LAPORAN PENDAFTARAN KURSUS EFA</h2>
    
    <table class="print-info-table">
        <tr>
            <td style="width: 100px;">Tanggal</td>
            <td style="width: 10px;">:</td>
            <td>{{ $tanggalText }}</td>
        </tr>
        <tr>
            <td>Paket Kursus</td>
            <td>:</td>
            <td>{{ $paketText }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $statusText }}</td>
        </tr>
    </table>

    <table class="print-data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Tanggal Daftar</th>
                <th width="12%">No. Registrasi</th>
                <th width="15%">Nama Peserta</th>
                <th width="15%">Email</th>
                <th width="10%">Telepon</th>
                <th width="10%">Asal/Domisili</th>
                <th width="10%">Paket Kursus</th>
                <th width="6%">Kategori</th>
                <th width="7%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $i => $reg)
            <tr>
                <td style="text-align: center;">{{ $i + 1 }}</td>
                <td>{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $reg->registration_number }}</td>
                <td>{{ $reg->detail ? $reg->detail->name : $reg->user->name }}</td>
                <td>{{ $reg->user->email }}</td>
                <td>{{ $reg->detail ? ($reg->detail->phone ?? $reg->detail->parent_phone) : $reg->user->phone }}</td>
                <td>{{ $reg->detail ? $reg->detail->domicile : '-' }}</td>
                <td>{{ $reg->coursePackage->name }}</td>
                <td>{{ $reg->coursePackage->category === 'kids' ? 'Kids' : 'Dewasa' }}</td>
                <td>{{ $reg->payment ? 'Rp ' . number_format($reg->payment->amount, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="9" style="text-align: right; font-weight: bold;">Total Pendapatan Filter Saat Ini:</td>
                <td style="font-weight: bold;">Rp {{ number_format($registrations->filter(fn($reg) => $reg->payment && $reg->payment->payment_status === 'valid')->sum(fn($reg) => $reg->payment->amount), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        @page {
            size: portrait;
            margin: 1cm;
        }
        .admin-sidebar, .admin-header, .admin-toast,
        [id="sidebarOverlay"], footer,
        form, .admin-btn, a.admin-btn,
        .admin-float-card, .no-print {
            display: none !important;
        }
        .admin-bg {
            background: #fff !important;
        }
        .lg\:ml-64 {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .print-only {
            display: block !important;
        }
        .print-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .print-info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 12px;
        }
        .print-info-table td {
            padding: 2px 0;
            border: none;
        }
        .print-data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .print-data-table th, .print-data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        .print-data-table th {
            text-align: center;
            font-weight: bold;
        }
    }
</style>
@endsection
