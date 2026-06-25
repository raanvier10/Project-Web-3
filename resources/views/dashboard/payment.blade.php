@extends('layouts.dashboard')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('page-title', 'Pembayaran')

@section('dashboard-content')
{{-- Breadcrumb --}}
<div class="flex items-center space-x-2.5 text-sm mb-7">
    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-primary-600 transition-colors flex items-center space-x-1.5">
        <i class="fas fa-th-large text-xs"></i>
        <span>Dashboard</span>
    </a>
    <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
    <span class="text-gray-700 font-semibold">Pembayaran</span>
</div>

<div class="max-w-4xl mx-auto">
    {{-- Progress Steps — Premium --}}
    <div class="float-card mb-6 !p-5">
        <div class="flex items-center justify-between relative px-4">
            {{-- Line background --}}
            <div class="absolute top-[22px] left-[60px] right-[60px] h-[3px] rounded-full bg-gray-100"></div>
            {{-- Line progress --}}
            @php
                $progressWidth = match(true) {
                    $registration->display_status === 'Lunas' => '100%',
                    $registration->payment !== null => '50%',
                    default => '0%',
                };
            @endphp
            <div class="absolute top-[22px] left-[60px] h-[3px] rounded-full transition-all duration-700 ease-out" style="width: {{ $progressWidth }}; max-width: calc(100% - 120px); background: linear-gradient(90deg, #E8699F, #FF85BB);"></div>

            {{-- Step 1 --}}
            <div class="relative z-10 flex flex-col items-center w-28">
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg ring-4 ring-white" style="background: linear-gradient(135deg, #E8699F, #FF85BB);">
                    <i class="fas fa-check"></i>
                </div>
                <p class="text-xs font-bold text-gray-700 mt-2.5">Pendaftaran</p>
                <p class="text-[10px] text-gray-400">Selesai</p>
            </div>

            {{-- Step 2 --}}
            <div class="relative z-10 flex flex-col items-center w-28">
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-bold shadow-lg ring-4 ring-white transition-all duration-500
                    {{ $registration->payment ? 'text-white' : 'bg-white border-2 border-primary-300 text-primary-600' }}"
                    @if($registration->payment) style="background: linear-gradient(135deg, #E8699F, #FF85BB);" @endif>
                    @if($registration->payment) <i class="fas fa-check"></i>
                    @else <span class="text-base">2</span> @endif
                </div>
                <p class="text-xs font-bold {{ $registration->payment ? 'text-gray-700' : 'text-primary-600' }} mt-2.5">Pembayaran</p>
                <p class="text-[10px] text-gray-400">{{ $registration->payment ? 'Selesai' : 'Saat ini' }}</p>
            </div>

            {{-- Step 3 --}}
            <div class="relative z-10 flex flex-col items-center w-28">
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-bold ring-4 ring-white transition-all duration-500
                    {{ $registration->display_status === 'Lunas' ? 'text-white shadow-lg' : 'bg-gray-100 text-gray-400' }}"
                    @if($registration->display_status === 'Lunas') style="background: linear-gradient(135deg, #10B981, #34D399);" @endif>
                    @if($registration->display_status === 'Lunas') <i class="fas fa-check"></i>
                    @else <span class="text-base">3</span> @endif
                </div>
                <p class="text-xs font-bold {{ $registration->display_status === 'Lunas' ? 'text-gray-700' : 'text-gray-400' }} mt-2.5">Verifikasi</p>
                <p class="text-[10px] text-gray-400">{{ $registration->display_status === 'Lunas' ? 'Selesai' : 'Menunggu' }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-stretch">
        {{-- Invoice --}}
        <div class="space-y-4">
            <div class="float-card h-full">
                <div class="flex items-center space-x-2 mb-5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                        <i class="fas fa-file-invoice text-xs text-primary-600"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Invoice</h3>
                </div>

                <div class="space-y-3.5 mb-5">
                    <div class="flex justify-between items-start">
                        <span class="text-sm text-gray-400">ID Transaksi</span>
                        <span class="text-sm font-mono font-bold text-gray-800 bg-gray-50 px-2.5 py-1 rounded-lg">{{ $registration->registration_number }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-sm text-gray-400">Paket</span>
                        <span class="text-sm font-semibold text-gray-800 text-right max-w-[55%]">{{ $registration->coursePackage->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Kategori</span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $registration->coursePackage->category === 'kids' ? 'text-purple-700' : 'text-primary-700' }}" style="background: {{ $registration->coursePackage->category === 'kids' ? 'linear-gradient(135deg, #F3E8FF, #E9D5FF)' : 'linear-gradient(135deg, #FFE0EC, #FFC2D9)' }};">
                            {{ $registration->coursePackage->category_label }}
                        </span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-sm text-gray-400">Tanggal</span>
                        <span class="text-sm text-gray-600">{{ $registration->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Status</span>
                        <span class="status-badge {{ $registration->status_badge_class }}">
                            {{ $registration->display_status }}
                        </span>
                    </div>
                </div>

                <div class="pt-4" style="border-top: 2px dashed rgba(0,0,0,0.06);">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-600">Total Bayar</span>
                        <span class="text-2xl font-extrabold" style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $registration->coursePackage->formatted_price }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Payment Instructions --}}
        <div class="space-y-4">
            <div class="float-card h-full flex flex-col">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                        <i class="fas fa-info text-xs text-blue-600"></i>
                    </div>
                    <h4 class="text-sm font-bold text-gray-900">Instruksi Pembayaran</h4>
                </div>

                {{-- Rekening Display --}}
                <div class="rounded-2xl p-4 mb-4 space-y-3" style="background: linear-gradient(135deg, rgba(255,240,246,0.6), rgba(255,224,236,0.3)); border: 1px solid rgba(199,78,131,0.12);">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest text-center">Transfer ke Rekening</p>

                    {{-- BSI --}}
                    <div class="flex items-center justify-between rounded-xl px-4 py-3" style="background: rgba(255,255,255,0.85); border: 1px solid rgba(16,185,129,0.18);">
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold text-emerald-700 flex-shrink-0" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                                <i class="fas fa-university text-emerald-600 text-[10px]"></i> BSI
                            </div>
                            <div>
                                <p class="font-mono font-extrabold tracking-[0.05em] leading-tight"
                                    id="rek-bsi"
                                    style="font-size: 1.45rem; background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    7285028277
                                </p>
                                <p class="text-[11px] text-gray-500 font-semibold">a.n. Siska Maya Fitri</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <button type="button" onclick="copyRekeningById('rek-bsi','tip-bsi')"
                                class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 focus:outline-none transition-all duration-200" title="Salin BSI">
                                <i class="far fa-copy"></i>
                            </button>
                            <span id="tip-bsi" class="hidden text-[10px] font-bold text-emerald-600">✓ Salin</span>
                        </div>
                    </div>

                    {{-- BCA --}}
                    <div class="flex items-center justify-between rounded-xl px-4 py-3" style="background: rgba(255,255,255,0.85); border: 1px solid rgba(59,130,246,0.18);">
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold text-blue-700 flex-shrink-0" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                                <i class="fas fa-university text-blue-600 text-[10px]"></i> BCA
                            </div>
                            <div>
                                <p class="font-mono font-extrabold tracking-[0.05em] leading-tight"
                                    id="rek-bca"
                                    style="font-size: 1.45rem; background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    0344077645
                                </p>
                                <p class="text-[11px] text-gray-500 font-semibold">a.n. Siska Maya Fitri</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <button type="button" onclick="copyRekeningById('rek-bca','tip-bca')"
                                class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 focus:outline-none transition-all duration-200" title="Salin BCA">
                                <i class="far fa-copy"></i>
                            </button>
                            <span id="tip-bca" class="hidden text-[10px] font-bold text-blue-600">✓ Salin</span>
                        </div>
                    </div>
                </div>

                {{-- Langkah-langkah --}}
                <div class="space-y-3 text-sm text-gray-500">
                    @php $steps = [
                        'Transfer sesuai nominal <strong class="text-gray-700">Total Bayar</strong> pada invoice.',
                        'Screenshot atau foto bukti transfer Anda.',
                        'Upload bukti transfer pada form di bawah.',
                        'Tunggu verifikasi admin <strong class="text-gray-700">(maks 1x24 jam)</strong>.',
                    ]; @endphp
                    @foreach($steps as $i => $text)
                    <div class="flex items-start space-x-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9);">
                            <span class="text-[10px] font-bold text-primary-700">{{ $i + 1 }}</span>
                        </div>
                        <p class="leading-relaxed mt-0.5">{!! $text !!}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Upload Payment Proof --}}
        <div class="lg:col-span-2">
            <div class="float-card">
                <div class="flex items-center space-x-2 mb-5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                        <i class="fas fa-cloud-upload-alt text-xs text-emerald-600"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Upload Bukti Pembayaran</h3>
                </div>

                @if($registration->payment && $registration->payment->payment_status !== 'rejected')
                    {{-- Already uploaded --}}
                    <div class="text-center py-10">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0); box-shadow: 0 8px 32px rgba(16,185,129,0.15);">
                            <i class="fas fa-check-circle text-3xl text-emerald-500"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-1">Bukti Pembayaran Diunggah</h4>
                        <span class="status-badge {{ $registration->status_badge_class }} mb-4 inline-flex">{{ $registration->display_status }}</span>

                        @if($registration->payment->proof_of_payment_path && Storage::disk('public')->exists($registration->payment->proof_of_payment_path))
                        <div class="my-5 inline-block rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-100">
                            <img src="{{ asset('storage/' . $registration->payment->proof_of_payment_path) }}" alt="Bukti Pembayaran" class="max-w-xs max-h-64 object-contain" />
                        </div>
                        @elseif($registration->payment->proof_of_payment_path)
                        <div class="my-5 p-4 rounded-2xl" style="background: linear-gradient(135deg, rgba(251,191,36,0.06), rgba(245,158,11,0.03)); border: 1px solid rgba(251,191,36,0.12);">
                            <p class="text-amber-600 text-sm"><i class="fas fa-exclamation-triangle mr-1.5"></i>File bukti pembayaran tidak ditemukan di server.</p>
                        </div>
                        @endif

                        <p class="text-gray-400 text-xs">
                            <i class="fas fa-clock mr-1"></i>
                            Diunggah: {{ $registration->payment->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                @else
                    {{-- Show rejection reason if payment was rejected --}}
                    @if($registration->payment && $registration->payment->payment_status === 'rejected')
                    <div class="mb-6 p-4 rounded-2xl flex items-start space-x-3" style="background: linear-gradient(135deg, rgba(239,68,68,0.06), rgba(252,165,165,0.03)); border: 1px solid rgba(239,68,68,0.15);">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #FEE2E2, #FECACA);">
                            <i class="fas fa-times-circle text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-red-700 mb-1">Pembayaran Ditolak</p>
                            @if($registration->payment->admin_notes)
                            <p class="text-sm text-red-600">Alasan: {{ $registration->payment->admin_notes }}</p>
                            @else
                            <p class="text-sm text-red-500">Silakan upload ulang bukti pembayaran yang valid.</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('dashboard.payment.upload', $registration->id) }}" enctype="multipart/form-data" id="paymentForm">
                        @csrf

                        {{-- Premium Upload Area & Preview --}}
                        <div class="mb-6">
                            <div class="relative w-full rounded-2xl overflow-hidden transition-all duration-300 group" id="uploadWrapper" style="border: 2px dashed rgba(199,78,131,0.3); background: linear-gradient(135deg, rgba(255,240,246,0.6), rgba(255,224,236,0.3));">
                                <input type="file" id="proof_of_payment" name="proof_of_payment" accept="image/jpeg,image/jpg,image/png,image/webp" required
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" title="Klik untuk pilih file" />
                                
                                {{-- State: Empty --}}
                                <div id="dropContent" class="flex flex-col items-center justify-center py-12 px-6 transition-all duration-300 relative z-10 group-hover:bg-white/40">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-1" style="background: linear-gradient(135deg, #FFE0EC, #FFC2D9); box-shadow: 0 8px 24px rgba(255,133,187,0.25);">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-primary-600"></i>
                                    </div>
                                    <p class="text-gray-800 font-extrabold text-sm mb-1.5">Klik atau seret gambar ke sini</p>
                                    <p class="text-gray-500 text-[11px] font-semibold bg-white/60 px-3 py-1 rounded-full border border-gray-100">Format: JPG, PNG, WEBP (Maks 2MB)</p>
                                </div>

                                {{-- State: Preview --}}
                                <div id="previewContainer" class="hidden w-full relative h-[280px]">
                                    {{-- Background blur --}}
                                    <div class="absolute inset-0 z-0 overflow-hidden bg-gray-900">
                                        <img id="previewImageBg" src="" class="w-full h-full object-cover opacity-40 blur-lg scale-110" alt="">
                                    </div>

                                    {{-- Image Content --}}
                                    <div class="relative z-10 w-full h-full flex flex-col items-center justify-center p-4">
                                        <div class="relative max-h-[190px] mb-3 transform transition-all duration-500 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-white/20 rounded-xl blur-md translate-y-2"></div>
                                            <img id="previewImageMain" src="" alt="Preview" class="relative z-10 max-h-[190px] rounded-xl object-contain border-2 border-white/80 shadow-2xl" />
                                        </div>
                                        
                                        {{-- File Info Badge --}}
                                        <div class="inline-flex items-center gap-2 bg-white/95 backdrop-blur-sm shadow-xl px-4 py-2 rounded-full border border-white">
                                            <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-check text-[10px] text-emerald-600"></i>
                                            </div>
                                            <span id="fileName" class="text-xs font-bold text-gray-800 truncate max-w-[120px] sm:max-w-[200px]"></span>
                                            <div class="h-4 w-px bg-gray-200 mx-1"></div>
                                            <span class="text-[10px] font-extrabold text-primary-600 uppercase tracking-wider bg-primary-50 px-2 py-0.5 rounded-md flex-shrink-0 group-hover:bg-primary-100 transition-colors">Ganti</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" id="submitPayment"
                            class="w-full py-4 rounded-xl text-white font-bold text-sm transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center relative overflow-hidden group"
                            style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);">
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Bukti Pembayaran
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </button>
                    </form>
                @endif

                @if(!$registration->payment || $registration->payment->payment_status === 'rejected')
                <div class="mt-5 text-center">
                    <form id="cancelForm" action="{{ route('dashboard.registration.cancel', $registration->id) }}" method="POST" class="block">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmCancel()" class="w-full py-3.5 rounded-xl text-gray-500 font-bold text-sm bg-gray-50 border border-gray-200 transition-all duration-300 hover:bg-red-50 hover:text-red-600 hover:border-red-200 flex items-center justify-center group">
                            <i class="fas fa-times-circle mr-2 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                            Batalkan Pendaftaran & Kembali
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyRekeningById(elId, tooltipId) {
        const el = document.getElementById(elId);
        if (!el) return;
        const rek = el.innerText.replace(/\s/g, '');
        const tip = document.getElementById(tooltipId);
        const show = () => {
            if (tip) { tip.classList.remove('hidden'); setTimeout(() => tip.classList.add('hidden'), 2000); }
        };
        navigator.clipboard.writeText(rek).then(show).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = rek; document.body.appendChild(ta); ta.select();
            document.execCommand('copy'); document.body.removeChild(ta); show();
        });
    }

    function confirmCancel() {
        showUniversalModal({
            title: 'Batalkan Pesanan?',
            description: 'Apakah kamu yakin untuk membatalkan pendaftaran? Riwayat pembayaran ini akan dihapus.',
            confirmText: 'Ya, Batalkan',
            onConfirm: () => { document.getElementById('cancelForm').submit(); }
        });
    }

    const fileInput = document.getElementById('proof_of_payment');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    fileInput.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const res = ev.target.result;
                    document.getElementById('previewImageBg').src = res;
                    document.getElementById('previewImageMain').src = res;
                    document.getElementById('dropContent').classList.add('hidden');
                    document.getElementById('previewContainer').classList.remove('hidden');
                    const wrapper = document.getElementById('uploadWrapper');
                    if(wrapper) {
                        wrapper.style.border = '1px solid rgba(0,0,0,0.05)';
                        wrapper.style.boxShadow = '0 10px 30px -10px rgba(0,0,0,0.15)';
                    }
                    document.getElementById('fileName').textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        let submitting = false;
        paymentForm.addEventListener('submit', function(e) {
            if (submitting) { e.preventDefault(); return; }
            submitting = true;
            const btn = document.getElementById('submitPayment');
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengunggah...';
        });
    }
</script>
@endsection