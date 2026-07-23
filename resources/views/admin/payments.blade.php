@extends('layouts.admin')

@section('page-title', 'Verifikasi Pembayaran')
@section('page-subtitle', 'Review dan validasi pembayaran peserta')

@section('admin-content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full mb-3" style="background: linear-gradient(135deg, rgba(251,191,36,0.08), rgba(245,158,11,0.04)); border: 1px solid rgba(251,191,36,0.12);">
            <i class="fas fa-credit-card text-amber-500 text-xs"></i>
            <span class="text-amber-600 text-xs font-semibold">Pembayaran</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Verifikasi Pembayaran</h1>
        <p class="text-gray-400 mt-1.5 text-sm">Review bukti pembayaran dan validasi transaksi peserta.</p>
    </div>
</div>

{{-- Status Filter Tabs --}}
<div class="mb-6 overflow-x-auto pb-2 -mx-1">
    <div class="inline-flex items-center space-x-1.5 p-1.5 rounded-2xl" style="background: rgba(255,255,255,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(0,0,0,0.04);">
        <a href="{{ route('admin.payments', ['status' => 'pending']) }}" class="admin-filter-tab {{ $status === 'pending' ? 'active' : '' }}" id="filter-pending">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 mr-1.5 inline-block"></span> Pending
        </a>
        <a href="{{ route('admin.payments', ['status' => 'valid']) }}" class="admin-filter-tab {{ $status === 'valid' ? 'active' : '' }}" id="filter-valid">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 inline-block"></span> Valid
        </a>
        <a href="{{ route('admin.payments', ['status' => 'rejected']) }}" class="admin-filter-tab {{ $status === 'rejected' ? 'active' : '' }}" id="filter-rejected">
            <span class="w-1.5 h-1.5 rounded-full bg-red-400 mr-1.5 inline-block"></span> Ditolak
        </a>
        <a href="{{ route('admin.payments', ['status' => 'all']) }}" class="admin-filter-tab {{ $status === 'all' ? 'active' : '' }}" id="filter-all">
            Semua
        </a>
    </div>
</div>

{{-- Payments List --}}
<div class="space-y-4">
    @forelse($payments as $index => $payment)
    <div class="admin-float-card !p-5 cursor-pointer hover:!shadow-xl" onclick="openPaymentDetail({{ $payment->id }})" style="animation: pageEnter 0.5s ease forwards; animation-delay: {{ $index * 0.06 }}s; opacity: 0;" id="payment-row-{{ $payment->id }}">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            {{-- Left: User Info --}}
            <div class="flex items-start space-x-4 flex-1 min-w-0">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9); box-shadow: 0 4px 12px rgba(199,78,131,0.1);">
                    <i class="fas fa-user text-primary-600 text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-gray-900">{{ $payment->registration->user->name }}</h3>
                    <p class="text-gray-400 text-xs mt-0.5">
                        <i class="fas fa-envelope mr-1"></i> {{ $payment->registration->user->email }}
                    </p>
                    <div class="flex items-center flex-wrap gap-2 mt-1.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider text-primary-700 bg-primary-50">
                            {{ $payment->registration->coursePackage->category_label }}
                        </span>
                        <span class="text-xs text-gray-300 font-mono">{{ $payment->registration->registration_number }}</span>
                    </div>
                </div>
            </div>

            {{-- Center: Package + Date --}}
            <div class="flex-shrink-0 lg:text-center">
                <p class="text-sm font-bold text-gray-800">{{ $payment->registration->coursePackage->name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">
                    <i class="fas fa-calendar mr-1"></i> {{ $payment->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            {{-- Right: Amount + Status + Actions --}}
            <div class="flex items-center gap-3 lg:flex-col lg:items-end lg:gap-2 flex-shrink-0">
                <p class="text-lg font-extrabold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                <span class="admin-badge {{ $payment->payment_status === 'valid' ? 'admin-badge-valid' : ($payment->payment_status === 'rejected' ? 'admin-badge-rejected' : 'admin-badge-pending') }}">
                    {{ $payment->payment_status === 'valid' ? 'Valid' : ($payment->payment_status === 'rejected' ? 'Ditolak' : 'Pending') }}
                </span>
            </div>
        </div>

        {{-- Rejection notes --}}
        @if($payment->payment_status === 'rejected' && $payment->admin_notes)
        <div class="mt-4 p-3.5 rounded-xl flex items-start space-x-2.5" style="background: linear-gradient(135deg, rgba(239,68,68,0.04), rgba(252,165,165,0.02)); border: 1px solid rgba(239,68,68,0.1);">
            <i class="fas fa-exclamation-triangle text-red-400 text-sm mt-0.5"></i>
            <p class="text-xs text-red-600">
                <strong>Alasan Penolakan:</strong> {{ $payment->admin_notes }}
            </p>
        </div>
        @endif
    </div>
    @empty
    <div class="admin-float-card text-center py-20">
        <div class="relative w-28 h-28 mx-auto mb-6">
            <div class="absolute inset-0 rounded-full animate-pulse-glow" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);"></div>
            <div class="relative w-28 h-28 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #FFF0F6, #FFE0EC);">
                <i class="fas fa-check-double text-4xl text-primary-300"></i>
            </div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Pembayaran</h3>
        <p class="text-gray-400 text-sm max-w-sm mx-auto">
            @if($status === 'pending')
                Semua pembayaran sudah diverifikasi. Tidak ada pembayaran pending saat ini.
            @else
                Tidak ada data pembayaran dengan status ini.
            @endif
        </p>
    </div>
    @endforelse
</div>

{{-- ========================= --}}
{{-- PAYMENT DETAIL MODAL      --}}
{{-- ========================= --}}
<div class="admin-modal-overlay" id="paymentDetailModalOverlay" onclick="closePaymentModal()"></div>
<div class="admin-modal" id="paymentDetailModal" style="max-width: 640px;">
    <div class="admin-modal-header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #FEF3C7, #FDE68A);">
                <i class="fas fa-file-invoice text-amber-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Detail Pembayaran</h3>
        </div>
        <button onclick="closePaymentModal()" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
            <i class="fas fa-times text-gray-400"></i>
        </button>
    </div>
    <div class="admin-modal-body" id="paymentDetailContent">
        {{-- Loading state --}}
        <div class="text-center py-10" id="paymentDetailLoading">
            <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 animate-spin" style="border: 3px solid #FFE0EC; border-top-color: #C74E83;"></div>
            <p class="text-gray-400 text-sm">Memuat data...</p>
        </div>

        {{-- Detail content (populated by JS) --}}
        <div id="paymentDetailData" class="hidden">
            {{-- User Info --}}
            <div class="p-4 rounded-2xl mb-4" style="background: linear-gradient(135deg, rgba(232,105,159,0.04), rgba(199,78,131,0.02)); border: 1px solid rgba(232,105,159,0.08);">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Data Peserta</p>
                <div class="space-y-2">
                    <div class="flex justify-between"><span class="text-sm text-gray-400">Nama</span><span class="text-sm font-bold text-gray-800" id="detail-user-name"></span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-400">Email</span><span class="text-sm text-gray-600" id="detail-user-email"></span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-400">Telepon</span><span class="text-sm text-gray-600" id="detail-user-phone"></span></div>
                </div>
            </div>

            {{-- Participant detail info --}}
            <div class="p-4 rounded-2xl mb-4 hidden" id="detail-participant-section" style="background: linear-gradient(135deg, rgba(236,72,153,0.04), rgba(219,39,119,0.02)); border: 1px solid rgba(236,72,153,0.08);">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Detail Peserta</p>
                <div class="space-y-2">
                    <div class="flex justify-between"><span class="text-sm text-gray-400">Nama Peserta</span><span class="text-sm font-bold text-gray-800" id="detail-participant-name"></span></div>
                    <div class="flex justify-between" id="detail-age-row"><span class="text-sm text-gray-400">Usia</span><span class="text-sm text-gray-600" id="detail-participant-age"></span></div>
                    <div class="flex justify-between" id="detail-domicile-row"><span class="text-sm text-gray-400">Domisili</span><span class="text-sm text-gray-600" id="detail-participant-domicile"></span></div>
                    <div class="flex justify-between" id="detail-job-row"><span class="text-sm text-gray-400">Pekerjaan</span><span class="text-sm text-gray-600" id="detail-participant-job"></span></div>
                </div>
            </div>

            {{-- Package Info --}}
            <div class="p-4 rounded-2xl mb-4" style="background: linear-gradient(135deg, rgba(16,185,129,0.04), rgba(5,150,105,0.02)); border: 1px solid rgba(16,185,129,0.08);">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">Paket Kursus</p>
                <div class="space-y-2">
                    <div class="flex justify-between"><span class="text-sm text-gray-400">Paket</span><span class="text-sm font-bold text-gray-800" id="detail-package-name"></span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-400">Kategori</span><span class="text-sm text-gray-600" id="detail-package-category"></span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-400">No. Registrasi</span><span class="text-sm font-mono text-gray-600" id="detail-reg-number"></span></div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Jumlah</span>
                        <span class="text-lg font-extrabold" style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;" id="detail-amount"></span>
                    </div>
                </div>
            </div>

            {{-- Proof of Payment --}}
            <div class="mb-4" id="detail-proof-section">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3">Bukti Pembayaran</p>
                <div class="rounded-2xl overflow-hidden border border-gray-100 inline-block" id="detail-proof-container">
                    <a href="" target="_blank" id="detail-proof-link" title="Klik untuk melihat ukuran penuh">
                        <img src="" alt="Bukti Pembayaran" class="max-w-full max-h-64 object-contain cursor-pointer hover:opacity-80 transition-opacity" id="detail-proof-image">
                    </a>
                </div>
                <div class="flex items-center space-x-2 mt-3" id="detail-proof-actions">
                    <a href="" target="_blank" id="detail-proof-view-btn" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-blue-700 transition-all duration-200 hover:shadow-md" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                        <i class="fas fa-external-link-alt mr-2 text-xs"></i>Lihat Penuh
                    </a>
                    <a href="" download id="detail-proof-download-btn" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-emerald-700 transition-all duration-200 hover:shadow-md" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                        <i class="fas fa-download mr-2 text-xs"></i>Download
                    </a>
                </div>
            </div>

            {{-- Action Buttons (only for pending) --}}
            <div class="border-t border-gray-100 pt-5 mt-5" id="detail-actions">
                <div class="flex space-x-3">
                    <form method="POST" id="acceptForm" class="flex-1">
                        @csrf
                        <button type="submit" class="admin-btn admin-btn-success w-full">
                            <i class="fas fa-check mr-2"></i> Accept
                        </button>
                    </form>
                    <button type="button" onclick="showRejectForm()" class="admin-btn admin-btn-danger flex-1" id="btn-show-reject">
                        <i class="fas fa-times mr-2"></i> Reject
                    </button>
                </div>

                {{-- Reject Form (hidden by default) --}}
                <div class="mt-4 hidden" id="rejectFormWrapper">
                    <form method="POST" id="rejectForm">
                        @csrf
                        <label class="admin-form-label"><i class="fas fa-comment-dots mr-2 text-red-400 text-xs"></i> Alasan Penolakan</label>
                        <textarea name="admin_notes" class="admin-form-textarea !min-h-[80px] !border-red-200 focus:!border-red-400 focus:!ring-red-100" placeholder="Contoh: Bukti transfer tidak jelas, nominal tidak sesuai..." required></textarea>
                        <button type="submit" class="admin-btn admin-btn-danger w-full mt-3">
                            <i class="fas fa-times-circle mr-2"></i> Konfirmasi Penolakan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentPaymentId = null;

    function openPaymentDetail(id) {
        currentPaymentId = id;
        // Show modal
        document.getElementById('paymentDetailModal').classList.add('show');
        document.getElementById('paymentDetailModalOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';

        // Show loading, hide data
        document.getElementById('paymentDetailLoading').classList.remove('hidden');
        document.getElementById('paymentDetailData').classList.add('hidden');
        document.getElementById('rejectFormWrapper').classList.add('hidden');

        // Fetch detail
        fetch('/admin/payments/' + id + '/detail', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(r => r.json())
        .then(data => {
            // Populate user
            document.getElementById('detail-user-name').textContent = data.user.name;
            document.getElementById('detail-user-email').textContent = data.user.email;
            document.getElementById('detail-user-phone').textContent = data.user.phone || '-';

            // Populate participant detail
            if (data.detail) {
                document.getElementById('detail-participant-section').classList.remove('hidden');
                document.getElementById('detail-participant-name').textContent = data.detail.name;
                setDetailRow('detail-age-row', 'detail-participant-age', data.detail.age, data.detail.age ? data.detail.age + ' tahun' : null);
                setDetailRow('detail-domicile-row', 'detail-participant-domicile', data.detail.domicile, data.detail.domicile);
                setDetailRow('detail-job-row', 'detail-participant-job', data.detail.job, data.detail.job);
            } else {
                document.getElementById('detail-participant-section').classList.add('hidden');
            }

            // Populate package
            document.getElementById('detail-package-name').textContent = data.package.name;
            document.getElementById('detail-package-category').textContent = data.package.category === 'kids' ? 'Kids' : (data.package.category === 'teens' ? 'Teens' : 'Dewasa');
            document.getElementById('detail-reg-number').textContent = data.registration.registration_number;
            document.getElementById('detail-amount').textContent = 'Rp ' + data.amount;

            // Proof of payment
            if (data.proof_of_payment_path) {
                document.getElementById('detail-proof-section').classList.remove('hidden');
                document.getElementById('detail-proof-image').src = data.proof_of_payment_path;
                document.getElementById('detail-proof-link').href = data.proof_of_payment_path;
                document.getElementById('detail-proof-view-btn').href = data.proof_of_payment_path;
                document.getElementById('detail-proof-download-btn').href = data.proof_of_payment_path;
                document.getElementById('detail-proof-actions').classList.remove('hidden');
            } else {
                document.getElementById('detail-proof-section').classList.add('hidden');
            }

            // Actions (only for pending)
            const actionsEl = document.getElementById('detail-actions');
            if (data.payment_status === 'pending') {
                actionsEl.classList.remove('hidden');
                document.getElementById('acceptForm').action = '/admin/payments/' + id + '/accept';
                document.getElementById('rejectForm').action = '/admin/payments/' + id + '/reject';
            } else {
                actionsEl.classList.add('hidden');
            }

            // Show data, hide loading
            document.getElementById('paymentDetailLoading').classList.add('hidden');
            document.getElementById('paymentDetailData').classList.remove('hidden');
        })
        .catch(err => {
            console.error('Error fetching payment detail:', err);
            document.getElementById('paymentDetailLoading').innerHTML =
                '<div class="text-center py-10"><i class="fas fa-exclamation-circle text-red-400 text-2xl mb-3"></i><p class="text-red-500 text-sm">Gagal memuat data</p></div>';
        });
    }

    function setDetailRow(rowId, valueId, value, displayValue) {
        if (value) {
            document.getElementById(rowId).classList.remove('hidden');
            document.getElementById(valueId).textContent = displayValue;
        } else {
            document.getElementById(rowId).classList.add('hidden');
        }
    }

    function closePaymentModal() {
        document.getElementById('paymentDetailModal').classList.remove('show');
        document.getElementById('paymentDetailModalOverlay').classList.remove('show');
        document.body.style.overflow = '';
    }

    function showRejectForm() {
        document.getElementById('rejectFormWrapper').classList.toggle('hidden');
    }

    // Close with Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closePaymentModal();
    });
</script>
@endsection
