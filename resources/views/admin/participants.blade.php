@extends('layouts.admin')

@section('page-title', 'Manajemen Peserta')
@section('page-subtitle', 'Peserta dengan pembayaran valid')

@section('admin-content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(5,150,105,0.04)); border: 1px solid rgba(16,185,129,0.12);">
            <i class="fas fa-users text-emerald-500 text-xs"></i>
            <span class="text-emerald-600 text-xs font-semibold">Peserta Aktif</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Manajemen Peserta</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Daftar peserta yang sudah memiliki pembayaran valid dan registrasi aktif.</p>
    </div>
    <div class="flex items-center space-x-2 text-sm">
        <div class="px-4 py-2 rounded-xl font-bold" style="background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(5,150,105,0.04)); color: #047857; border: 1px solid rgba(16,185,129,0.12);">
            <i class="fas fa-user-check mr-1.5"></i> {{ $participants->count() }} Peserta Aktif
        </div>
    </div>
</div>

{{-- Search & Filter --}}
<div class="admin-float-card !p-4 mb-6" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
    <form method="GET" action="{{ route('admin.participants') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        {{-- Search --}}
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" class="admin-search w-full" placeholder="Cari nama, email, atau domisili..." id="search-participants">
        </div>
        {{-- Package filter --}}
        <select name="package_id" class="admin-form-select !py-2.5 sm:w-64" id="filter-package">
            <option value="">Semua Paket</option>
            @foreach($packages as $pkg)
            <option value="{{ $pkg->id }}" {{ request('package_id') == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">
            <i class="fas fa-filter mr-1.5"></i> Filter
        </button>
        @if(request()->hasAny(['search', 'package_id']))
        <a href="{{ route('admin.participants') }}" class="admin-btn admin-btn-outline admin-btn-sm">
            <i class="fas fa-times mr-1.5"></i> Reset
        </a>
        @endif
    </form>
</div>

{{-- Participants Table --}}
<div class="admin-float-card !p-0 overflow-hidden" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.1s; opacity: 0;">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>Email</th>
                    <th>Asal Instansi / Domisili</th>
                    <th>Paket Kursus</th>
                    <th>Kuota</th>
                    <th>Tgl Daftar</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $index => $reg)
                <tr style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ ($index * 0.04) + 0.15 }}s; opacity: 0;">
                    <td class="text-gray-400 font-mono text-sm">{{ $index + 1 }}</td>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, {{ $reg->coursePackage->category === 'kids' ? '#F3E8FF, #E9D5FF' : '#FFE0EC, #FFC2D9' }});">
                                <i class="fas {{ $reg->coursePackage->category === 'kids' ? 'fa-child text-purple-500' : 'fa-user text-primary-600' }} text-xs"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $reg->detail ? $reg->detail->name : $reg->user->name }}</p>
                                @if($reg->detail && $reg->detail->phone)
                                <p class="text-gray-400 text-xs"><i class="fas fa-phone text-[9px] mr-1"></i>{{ $reg->detail->phone }}</p>
                                @elseif($reg->detail && $reg->detail->parent_phone)
                                <p class="text-gray-400 text-xs"><i class="fas fa-phone text-[9px] mr-1"></i>{{ $reg->detail->parent_phone }} (Orang Tua)</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="text-gray-600 text-sm">{{ $reg->user->email }}</td>
                    <td class="text-gray-600 text-sm">{{ $reg->detail ? $reg->detail->domicile ?? '-' : '-' }}</td>
                    <td>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $reg->coursePackage->category === 'kids' ? 'text-purple-600 bg-purple-50' : 'text-primary-700 bg-primary-50' }}">
                                {{ $reg->coursePackage->category_label }}
                            </span>
                            <span class="text-sm font-semibold text-gray-700">{{ $reg->coursePackage->name }}</span>
                        </div>
                    </td>
                    <td>
                        @php
                            $pkgAmount = $reg->coursePackage->amount;
                            $pkgActive = $reg->coursePackage->active_registrations_count;
                        @endphp
                        @if($pkgAmount > 0)
                        @php
                            $remaining = max(0, $pkgAmount - $pkgActive);
                            $pctUsed = ($pkgActive / $pkgAmount) * 100;
                        @endphp
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="{{ $remaining <= 0 ? 'text-red-600 font-bold' : ($remaining <= 3 ? 'text-amber-600 font-semibold' : 'text-gray-500') }}">
                                    {{ $pkgActive }}/{{ $pkgAmount }} peserta
                                </span>
                                @if($remaining <= 0)
                                <span class="text-[9px] font-bold text-red-600 uppercase">Penuh</span>
                                @endif
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500" style="width: {{ min(100, $pctUsed) }}%; background: {{ $remaining <= 0 ? 'linear-gradient(90deg, #EF4444, #F87171)' : ($remaining <= 3 ? 'linear-gradient(90deg, #F59E0B, #FCD34D)' : 'linear-gradient(90deg, #10B981, #34D399)') }};"></div>
                            </div>
                        </div>
                        @else
                        <span class="text-xs text-gray-400">{{ $pkgActive }} peserta <span class="text-gray-300">(unlimited)</span></span>
                        @endif
                    </td>
                    <td class="text-gray-500 text-sm">{{ $reg->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <button onclick="openParticipantDetail({{ json_encode([
                            'name' => $reg->detail ? $reg->detail->name : $reg->user->name,
                            'email' => $reg->user->email,
                            'phone' => $reg->detail ? ($reg->detail->phone ?? $reg->detail->parent_phone ?? $reg->user->phone) : $reg->user->phone,
                            'age' => $reg->detail ? $reg->detail->age : null,
                            'domicile' => $reg->detail ? $reg->detail->domicile : null,
                            'job' => $reg->detail ? $reg->detail->job : null,
                            'package' => $reg->coursePackage->name,
                            'category' => $reg->coursePackage->category_label,
                            'price' => $reg->coursePackage->formatted_price,
                            'reg_number' => $reg->registration_number,
                            'reg_date' => $reg->created_at->format('d M Y, H:i'),
                            'payment_amount' => $reg->payment ? 'Rp ' . number_format($reg->payment->amount, 0, ',', '.') : '-',
                            'payment_date' => $reg->payment ? $reg->payment->created_at->format('d M Y, H:i') : '-',
                        ]) }})" class="w-9 h-9 rounded-xl flex items-center justify-center text-primary-700 hover:bg-primary-50 transition-colors mx-auto" title="Lihat Detail" id="btn-detail-{{ $reg->id }}">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-16">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                            <i class="fas fa-users text-2xl text-primary-300"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Belum ada peserta aktif</p>
                        <p class="text-gray-400 text-xs">Peserta akan muncul setelah pembayaran diverifikasi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ========================= --}}
{{-- PARTICIPANT DETAIL MODAL  --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="participantDetailModalOverlay" onclick="closeParticipantModal()"></div>
<div class="admin-modal" id="participantDetailModal" style="max-width: 520px;">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                <i class="fas fa-user text-primary-700"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Detail Peserta</h3>
        </div>
        <button onclick="closeParticipantModal()" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body">
        {{-- Personal Info --}}
        <div class="p-4 rounded-2xl mb-4" style="background: linear-gradient(135deg, rgba(232,105,159,0.04), rgba(199,78,131,0.02)); border: 1px solid rgba(232,105,159,0.08);">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3">Informasi Personal</p>
            <div class="space-y-2.5">
                <div class="flex justify-between"><span class="text-sm text-gray-400">Nama</span><span class="text-sm font-bold text-gray-800" id="pd-name"></span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-400">Email</span><span class="text-sm text-gray-600" id="pd-email"></span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-400">Telepon</span><span class="text-sm text-gray-600" id="pd-phone"></span></div>
                <div class="flex justify-between" id="pd-age-row"><span class="text-sm text-gray-400">Usia</span><span class="text-sm text-gray-600" id="pd-age"></span></div>
                <div class="flex justify-between" id="pd-domicile-row"><span class="text-sm text-gray-400">Domisili</span><span class="text-sm text-gray-600" id="pd-domicile"></span></div>
                <div class="flex justify-between" id="pd-job-row"><span class="text-sm text-gray-400">Pekerjaan</span><span class="text-sm text-gray-600" id="pd-job"></span></div>
            </div>
        </div>

        {{-- Course Info --}}
        <div class="p-4 rounded-2xl mb-4" style="background: linear-gradient(135deg, rgba(16,185,129,0.04), rgba(5,150,105,0.02)); border: 1px solid rgba(16,185,129,0.08);">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3">Informasi Kursus</p>
            <div class="space-y-2.5">
                <div class="flex justify-between"><span class="text-sm text-gray-400">Paket</span><span class="text-sm font-bold text-gray-800" id="pd-package"></span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-400">Kategori</span><span class="text-sm text-gray-600" id="pd-category"></span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-400">No. Registrasi</span><span class="text-sm font-mono text-gray-600" id="pd-reg-number"></span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-400">Tanggal Daftar</span><span class="text-sm text-gray-600" id="pd-reg-date"></span></div>
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="p-4 rounded-2xl" style="background: linear-gradient(135deg, rgba(251,191,36,0.04), rgba(245,158,11,0.02)); border: 1px solid rgba(251,191,36,0.08);">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3">Informasi Pembayaran</p>
            <div class="space-y-2.5">
                <div class="flex justify-between"><span class="text-sm text-gray-400">Harga Paket</span><span class="text-sm font-bold text-gray-800" id="pd-price"></span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-400">Jumlah Dibayar</span><span class="text-sm font-bold text-gray-800" id="pd-payment-amount"></span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-400">Tanggal Bayar</span><span class="text-sm text-gray-600" id="pd-payment-date"></span></div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Status</span>
                    <span class="admin-badge admin-badge-valid">Lunas</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openParticipantDetail(data) {
        document.getElementById('pd-name').textContent = data.name;
        document.getElementById('pd-email').textContent = data.email;
        document.getElementById('pd-phone').textContent = data.phone || '-';

        // Optional fields
        toggleRow('pd-age-row', 'pd-age', data.age, data.age ? data.age + ' tahun' : null);
        toggleRow('pd-domicile-row', 'pd-domicile', data.domicile, data.domicile);
        toggleRow('pd-job-row', 'pd-job', data.job, data.job);

        document.getElementById('pd-package').textContent = data.package;
        document.getElementById('pd-category').textContent = data.category;
        document.getElementById('pd-reg-number').textContent = data.reg_number;
        document.getElementById('pd-reg-date').textContent = data.reg_date;
        document.getElementById('pd-price').textContent = data.price;
        document.getElementById('pd-payment-amount').textContent = data.payment_amount;
        document.getElementById('pd-payment-date').textContent = data.payment_date;

        document.getElementById('participantDetailModal').classList.add('show');
        document.getElementById('participantDetailModalOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function toggleRow(rowId, valueId, value, display) {
        const row = document.getElementById(rowId);
        if (value) {
            row.classList.remove('hidden');
            document.getElementById(valueId).textContent = display;
        } else {
            row.classList.add('hidden');
        }
    }

    function closeParticipantModal() {
        document.getElementById('participantDetailModal').classList.remove('show');
        document.getElementById('participantDetailModalOverlay').classList.remove('show');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeParticipantModal();
    });
</script>
@endsection
