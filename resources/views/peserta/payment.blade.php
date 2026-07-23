@extends('layouts.dashboard')

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
    {{-- Progress Steps --}}
    <div class="float-card mb-6 !p-5">
        <div class="flex items-center justify-between relative px-4">
            <div class="absolute top-[22px] left-[60px] right-[60px] h-[3px] rounded-full bg-gray-100"></div>
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
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-bold shadow-lg ring-4 ring-white transition-all duration-500 {{ $registration->payment ? 'text-white' : 'bg-white border-2 border-primary-300 text-primary-600' }}"
                    @if($registration->payment) style="background: linear-gradient(135deg, #E8699F, #FF85BB);" @endif>
                    @if($registration->payment) <i class="fas fa-check"></i>
                    @else <span class="text-base">2</span> @endif
                </div>
                <p class="text-xs font-bold {{ $registration->payment ? 'text-gray-700' : 'text-primary-600' }} mt-2.5">Pembayaran</p>
                <p class="text-[10px] text-gray-400">{{ $registration->payment ? 'Selesai' : 'Saat ini' }}</p>
            </div>

            {{-- Step 3 --}}
            <div class="relative z-10 flex flex-col items-center w-28">
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-bold ring-4 ring-white transition-all duration-500 {{ $registration->display_status === 'Lunas' ? 'text-white shadow-lg' : 'bg-gray-100 text-gray-400' }}"
                    @if($registration->display_status === 'Lunas') style="background: linear-gradient(135deg, #10B981, #34D399);" @endif>
                    @if($registration->display_status === 'Lunas') <i class="fas fa-check"></i>
                    @else <span class="text-base">3</span> @endif
                </div>
                <p class="text-xs font-bold {{ $registration->display_status === 'Lunas' ? 'text-gray-700' : 'text-gray-400' }} mt-2.5">Verifikasi</p>
                <p class="text-[10px] text-gray-400">{{ $registration->display_status === 'Lunas' ? 'Selesai' : 'Menunggu' }}</p>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- Main Layout: Invoice kiri | Instruksi kanan | Upload di bawah --}}
    {{-- ============================================ --}}
    <div class="space-y-6 mb-6">

        {{-- Invoice Card (Full Width, Premium) --}}
        <div class="float-card overflow-hidden !p-0" style="animation: pageEnter 0.5s ease forwards; opacity: 0;">
            {{-- Invoice Header --}}
            <div class="px-8 py-6 flex items-center justify-between" style="background: linear-gradient(135deg, #C74E83 0%, #E8699F 50%, #FF85BB 100%);">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px);">
                        <i class="fas fa-file-invoice text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-white tracking-tight">INVOICE</h3>
                        <p class="text-white/60 text-sm font-medium">English For Akhwat</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-white/50 text-xs font-bold uppercase tracking-widest mb-1">No. Transaksi</p>
                    <span class="font-mono font-extrabold text-white text-lg bg-white/15 px-4 py-1.5 rounded-xl">{{ $registration->registration_number }}</span>
                </div>
            </div>

            {{-- Invoice Body --}}
            <div class="px-8 py-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                    <div class="sm:col-span-2 space-y-4">
                        <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <span class="text-sm text-gray-400 font-medium">Nama Peserta</span>
                            <span class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <span class="text-sm text-gray-400 font-medium">Paket Kursus</span>
                            <span class="text-sm font-bold text-gray-800 text-right max-w-[60%]">{{ $registration->coursePackage->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <span class="text-sm text-gray-400 font-medium">Kategori</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase {{ $registration->coursePackage->category === 'kids' ? 'text-purple-700' : ($registration->coursePackage->category === 'teens' ? 'text-blue-700' : 'text-primary-700') }}" style="background: {{ $registration->coursePackage->category === 'kids' ? 'linear-gradient(135deg, #F3E8FF, #E9D5FF)' : ($registration->coursePackage->category === 'teens' ? 'linear-gradient(135deg, #DBEAFE, #BFDBFE)' : 'linear-gradient(135deg, #FFE0EC, #FFC2D9)') }};">
                                {{ $registration->coursePackage->category_label }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <span class="text-sm text-gray-400 font-medium">Jumlah Pertemuan</span>
                            <span class="text-sm font-bold text-gray-800">{{ $registration->coursePackage->amount }}x Pertemuan</span>
                        </div>
                        <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <span class="text-sm text-gray-400 font-medium">Tanggal Daftar</span>
                            <span class="text-sm font-bold text-gray-800">{{ $registration->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm text-gray-400 font-medium">Status</span>
                            <span class="status-badge {{ $registration->status_badge_class }}">{{ $registration->display_status }}</span>
                        </div>
                    </div>

                    {{-- Rekening + Nominal Box --}}
                    <div class="flex flex-col items-center justify-center rounded-2xl p-6 text-center space-y-3 relative overflow-hidden" style="background: linear-gradient(135deg, rgba(199,78,131,0.04), rgba(255,133,187,0.06)); border: 2px dashed rgba(199,78,131,0.2);">

                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Transfer ke Rekening</p>

                        {{-- BSI --}}
                        <div class="w-full rounded-xl p-3" style="background: rgba(255,255,255,0.7); border: 1px solid rgba(199,78,131,0.12);">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg font-bold text-xs text-emerald-700 mb-2" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                                <i class="fas fa-university text-emerald-600"></i> BSI
                            </div>
                            <div class="flex items-center justify-center gap-2">
                                <span class="font-mono font-extrabold tracking-[0.08em]" id="rek-bsi"
                                    style="font-size: 1.55rem; line-height: 1; background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    7285028277
                                </span>
                                <button type="button" onclick="copyRekeningById('rek-bsi', 'tooltip-inv-bsi')"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200" title="Salin BSI">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 font-semibold mt-1">a.n. Siska Maya Fitri</p>
                            <div id="tooltip-inv-bsi" class="hidden mt-1 py-1 rounded-lg text-xs font-bold text-emerald-700" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);"><i class="fas fa-check mr-1"></i>Tersalin!</div>
                        </div>

                        {{-- BCA --}}
                        <div class="w-full rounded-xl p-3" style="background: rgba(255,255,255,0.7); border: 1px solid rgba(199,78,131,0.12);">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg font-bold text-xs text-blue-700 mb-2" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                                <i class="fas fa-university text-blue-600"></i> BCA
                            </div>
                            <div class="flex items-center justify-center gap-2">
                                <span class="font-mono font-extrabold tracking-[0.08em]" id="rek-bca"
                                    style="font-size: 1.55rem; line-height: 1; background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    0344077645
                                </span>
                                <button type="button" onclick="copyRekeningById('rek-bca', 'tooltip-inv-bca')"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="Salin BCA">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 font-semibold mt-1">a.n. Siska Maya Fitri</p>
                            <div id="tooltip-inv-bca" class="hidden mt-1 py-1 rounded-lg text-xs font-bold text-blue-700" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);"><i class="fas fa-check mr-1"></i>Tersalin!</div>
                        </div>

                        <div class="w-full h-px" style="background: rgba(199,78,131,0.1);"></div>

                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Tagihan</p>
                            <span class="text-3xl font-extrabold"
                                style="background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                {{ $registration->coursePackage->formatted_price }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Instruksi Pembayaran --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="float-card" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.1s; opacity: 0;">
                <div class="flex items-center space-x-2 mb-5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                        <i class="fas fa-info text-xs text-blue-600"></i>
                    </div>
                    <h4 class="text-base font-bold text-gray-900">Instruksi Pembayaran</h4>
                </div>

                {{-- Rekening Center --}}
                <div class="rounded-2xl p-5 mb-5 relative overflow-hidden space-y-3" style="background: linear-gradient(135deg, rgba(255,240,246,0.6), rgba(255,224,236,0.3)); border: 1px solid rgba(199,78,131,0.1);">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest text-center">Transfer ke Rekening</p>

                    {{-- BSI Row --}}
                    <div class="flex items-center justify-between rounded-xl px-4 py-3" style="background: rgba(255,255,255,0.75); border: 1px solid rgba(16,185,129,0.15);">
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold text-emerald-700 flex-shrink-0" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                                <i class="fas fa-university text-emerald-600 text-[10px]"></i> BSI
                            </div>
                            <div>
                                <p class="font-mono font-extrabold tracking-[0.06em] leading-tight"
                                    id="instr-rek-bsi"
                                    style="font-size: 1.3rem; background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    7285028277
                                </p>
                                <p class="text-[11px] text-gray-500 font-semibold">a.n. Siska Maya Fitri</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <button type="button" onclick="copyRekeningById('instr-rek-bsi', 'tooltip-instr-bsi')"
                                class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 focus:outline-none transition-all duration-200" title="Salin BSI">
                                <i class="far fa-copy"></i>
                            </button>
                            <span id="tooltip-instr-bsi" class="hidden text-[10px] font-bold text-emerald-600">✓ Salin</span>
                        </div>
                    </div>

                    {{-- BCA Row --}}
                    <div class="flex items-center justify-between rounded-xl px-4 py-3" style="background: rgba(255,255,255,0.75); border: 1px solid rgba(59,130,246,0.15);">
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold text-blue-700 flex-shrink-0" style="background: linear-gradient(135deg, #DBEAFE, #BFDBFE);">
                                <i class="fas fa-university text-blue-600 text-[10px]"></i> BCA
                            </div>
                            <div>
                                <p class="font-mono font-extrabold tracking-[0.06em] leading-tight"
                                    id="instr-rek-bca"
                                    style="font-size: 1.3rem; background: linear-gradient(135deg, #C74E83, #FF85BB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    0344077645
                                </p>
                                <p class="text-[11px] text-gray-500 font-semibold">a.n. Siska Maya Fitri</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <button type="button" onclick="copyRekeningById('instr-rek-bca', 'tooltip-instr-bca')"
                                class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 focus:outline-none transition-all duration-200" title="Salin BCA">
                                <i class="far fa-copy"></i>
                            </button>
                            <span id="tooltip-instr-bca" class="hidden text-[10px] font-bold text-blue-600">✓ Salin</span>
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

        {{-- Upload Bukti Pembayaran --}}
        <div class="lg:col-span-12">
            <div class="float-card" style="animation: pageEnter 0.5s ease forwards; animation-delay: 0.2s; opacity: 0;">
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

                @if($registration->payment->proof_of_payment_path)
                <div class="my-5 inline-block rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-100">
                    <img src="{{ asset('storage/' . $registration->payment->proof_of_payment_path) }}" alt="Bukti Pembayaran" class="max-w-xs max-h-64 object-contain" />
                </div>
                @endif

                <p class="text-gray-400 text-xs mt-4">
                    <i class="fas fa-clock mr-1"></i>
                    Diunggah: {{ $registration->payment->updated_at->format('d M Y, H:i') }}
                </p>
            </div>
        @else
            {{-- Rejection note --}}
            @if($registration->payment && $registration->payment->payment_status === 'rejected')
            <div class="mb-5 p-4 rounded-xl flex items-start space-x-3" style="background: linear-gradient(135deg, rgba(239,68,68,0.04), rgba(252,165,165,0.02)); border: 1px solid rgba(239,68,68,0.12);">
                <i class="fas fa-exclamation-triangle text-red-400 text-sm mt-0.5"></i>
                <div>
                    <p class="text-sm font-bold text-red-600 mb-0.5">Pembayaran Ditolak</p>
                    @if($registration->payment->admin_notes)
                    <p class="text-xs text-red-500">{{ $registration->payment->admin_notes }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-1">Silakan upload ulang bukti pembayaran yang benar.</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('dashboard.payment.upload', $registration->id) }}" enctype="multipart/form-data" id="paymentForm">
                @csrf

                <div class="gap-6">
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
                    <div class="mt-4">
                        <button type="submit" id="submitPayment"
                            class="w-full py-4 rounded-xl text-white font-bold text-sm transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center relative overflow-hidden group"
                            style="background: linear-gradient(135deg, #E8699F 0%, #FF85BB 50%, #C74E83 100%); box-shadow: 0 4px 20px rgba(199,78,131,0.25);">
                            <span class="relative z-10 flex items-center" id="btn-text">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Bukti Pembayaran
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </button>
                    </div>
                </div>
            </form>
        @endif

        <div class="mt-auto text-center border-t border-gray-100 pt-5 self-center w-full">
            <a href="{{ route('dashboard.transactions') }}" class="text-sm text-gray-400 hover:text-primary-600 transition-colors inline-flex items-center space-x-1.5 font-medium">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Riwayat Transaksi</span>
            </a>
        </div>
            </div>
        </div>

        </div> {{-- End Inner Grid --}}
    </div> {{-- End Main Space --}}
</div>
@endsection

@section('scripts')
<script>
    // Copy rekening by element id
    function copyRekeningById(elId, tooltipId) {
        const el = document.getElementById(elId);
        if (!el) return;
        const rek = el.innerText.replace(/\s/g, '');
        const tooltip = document.getElementById(tooltipId);
        const show = () => {
            if (tooltip) {
                tooltip.classList.remove('hidden');
                setTimeout(() => tooltip.classList.add('hidden'), 2000);
            }
        };
        navigator.clipboard.writeText(rek).then(show).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = rek;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            show();
        });
    }

    // File preview
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

    // Submit loading
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        let isSubmitting = false;
        paymentForm.addEventListener('submit', function(e) {
            if (isSubmitting) { e.preventDefault(); return; }
            isSubmitting = true;
            const btn = document.getElementById('submitPayment');
            const txt = document.getElementById('btn-text');
            txt.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Sedang Mengunggah...';
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            btn.style.transform = 'translateY(0)';
        });
    }
</script>
@endsection
