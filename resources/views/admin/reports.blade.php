@extends('layouts.admin')

@section('page-title', 'Laporan & Export')
@section('page-subtitle', 'Filter, lihat, dan export laporan data')

@section('admin-content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
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
        <p class="text-2xl font-extrabold tabular-nums" style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
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

{{-- Print Styles --}}
<style>
    @media print {
        .admin-sidebar, .admin-header, .admin-toast,
        [id="sidebarOverlay"], footer,
        form, .admin-btn, a.admin-btn,
        [id="btn-export-excel"], [id="btn-print"] {
            display: none !important;
        }
        .admin-bg {
            background: #fff !important;
        }
        .lg\:ml-64 {
            margin-left: 0 !important;
        }
        .admin-float-card {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
            backdrop-filter: none !important;
        }
        body {
            font-size: 11px;
        }
        .admin-table thead th {
            background: #f3f4f6;
        }
    }
</style>
@endsection
