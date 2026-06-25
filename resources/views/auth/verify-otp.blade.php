@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row overflow-x-hidden">
  <!-- Left Panel: Branding -->
  <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900">
    <div class="absolute inset-0">
      <div class="absolute top-20 -left-20 w-80 h-80 bg-primary-400/20 rounded-full blur-3xl animate-float"></div>
      <div class="absolute bottom-20 -right-20 w-96 h-96 bg-primary-300/15 rounded-full blur-3xl animate-float-slow"></div>
    </div>
    <div class="relative z-10 flex flex-col justify-center items-center text-center gap-6 min-h-screen px-12 py-16 w-full">
      <div class="flex items-center space-x-3 mb-6">
        <img src="/images/EFA.svg" alt="Logo EFA" class="w-20 h-20 object-contain drop-shadow-lg" />
      </div>
      <h2 class="text-4xl font-bold text-white leading-tight">
        Langkah Terakhir!
      </h2>
      <p class="text-primary-100/80 text-lg leading-relaxed max-w-md">
        Sedikit lagi akun Anda akan aktif. Masukkan kode OTP yang telah kami kirimkan ke email Anda.
      </p>
    </div>
  </div>

  <!-- Right Panel: OTP Form -->
  <div class="w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white relative min-h-screen">
    <div class="w-full max-w-md mx-auto px-6 sm:px-8 py-10 relative z-10">
      <!-- Header -->
      <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-envelope-open-text text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Verifikasi OTP</h1>
        <p class="text-gray-500 text-sm">
            Kode 6-digit telah dikirim ke email <strong>{{ session('otp_email') }}</strong>
        </p>
      </div>

      <!-- Messages -->
      @if (session('success'))
      <div class="mb-5 p-4 rounded-2xl bg-green-50/80 border border-green-100 backdrop-blur-sm flex items-start space-x-3">
        <i class="fas fa-check-circle text-green-500 text-sm mt-1"></i>
        <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
      </div>
      @endif

      @if (session('error'))
      <div class="mb-5 p-4 rounded-2xl bg-red-50/80 border border-red-100 backdrop-blur-sm flex items-start space-x-3">
        <i class="fas fa-exclamation-circle text-red-500 text-sm mt-1"></i>
        <p class="text-red-600 text-sm font-medium">{{ session('error') }}</p>
      </div>
      @endif

      @if ($errors->any())
      <div class="mb-5 p-4 rounded-2xl bg-red-50/80 border border-red-100 backdrop-blur-sm flex items-start space-x-3">
        <i class="fas fa-exclamation-circle text-red-500 text-sm mt-1"></i>
        <div class="pt-1">
          @foreach ($errors->all() as $error)
            <p class="text-red-600 text-sm font-medium">{{ $error }}</p>
          @endforeach
        </div>
      </div>
      @endif

      <!-- OTP Form -->
      <form method="POST" action="{{ route('otp.verify.submit') }}" id="otpForm" class="space-y-6">
        @csrf
        <div>
          <div class="relative group">
            <input
              type="text"
              id="otp"
              name="otp"
              required
              autofocus
              maxlength="6"
              pattern="[0-9]*"
              inputmode="numeric"
              placeholder="000000"
              class="w-full text-center tracking-[1em] py-4 rounded-xl border-2 border-gray-200 bg-white text-gray-900 text-2xl font-bold focus:outline-none focus:border-primary-400 focus:ring-4 focus:ring-primary-100 transition-all duration-300"
            />
          </div>
        </div>

        <button
          type="submit"
          id="verifyBtn"
          class="w-full py-4 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 text-white font-bold text-sm shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 hover:from-primary-500 hover:to-primary-600 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2"
        >
          <span>Verifikasi Akun</span>
          <i class="fas fa-check-circle text-xs"></i>
        </button>
      </form>

      <!-- Resend form -->
      <div class="mt-8 text-center">
        <p class="text-sm text-gray-500 mb-2">Belum menerima email OTP?</p>
        <form method="POST" action="{{ route('otp.resend') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold text-primary-600 hover:text-primary-800 transition">
                Kirim Ulang Kode
            </button>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let submitting = false;
  document.getElementById('otpForm').addEventListener('submit', (e) => {
    if (submitting) { e.preventDefault(); return; }
    submitting = true;
    const btn = document.getElementById('verifyBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...';
  });
</script>
@endsection
