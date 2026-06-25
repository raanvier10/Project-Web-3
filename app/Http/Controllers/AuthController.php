<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show the register form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle login attempt with rate limiting and security measures.
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255', 'ends_with:@gmail.com'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.ends_with'   => 'Email harus menggunakan domain @gmail.com.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        // Rate limiting: 5 attempts per minute per IP+email combo
        $throttleKey = Str::transliterate(
            Str::lower($request->input('email')) . '|' . $request->ip()
        );

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        // Attempt authentication
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 60);

            // Generic error message to prevent user enumeration
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        // Clear rate limiter on successful login
        RateLimiter::clear($throttleKey);

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Check if user is verified
        if (Auth::user()->email_verified_at === null) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda belum diverifikasi. Silakan verifikasi melalui kode OTP yang dikirim saat pendaftaran, atau daftar ulang untuk mendapatkan kode baru.'
            ]);
        }

        // Redirect based on role
        if (Auth::user()->isOwner()) {
            return redirect()->intended('/owner');
        }
        if (Auth::user()->isAdmin() || Auth::user()->isStaff()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/dashboard');
    }

    /**
     * Handle user registration with validation.
     */
    public function register(Request $request)
    {
        // First check if user exists and is unverified
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->email_verified_at === null) {
            // Validate without unique email
            $request->validate([
                'name'     => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'email'    => ['required', 'string', 'email', 'max:255', 'ends_with:@gmail.com'],
                'password' => [
                    'required', 
                    'string', 
                    'min:8', 
                    'confirmed', 
                    Password::min(8)->mixedCase()->symbols()
                ],
                'terms'    => ['required', 'accepted'],
            ], [
                'name.required'       => 'Nama lengkap wajib diisi.',
                'email.required'      => 'Email wajib diisi.',
                'password.required'   => 'Password wajib diisi.',
                'terms.required'      => 'Anda harus menyetujui syarat & ketentuan.',
            ]);

            // Update user details and generate new OTP
            $otpCode = sprintf('%06d', mt_rand(100000, 999999));
            $existingUser->update([
                'name'     => $request->name,
                'password' => Hash::make($request->password),
                'otp_code' => $otpCode,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            Mail::to($existingUser->email)->send(new OtpMail($otpCode));
            session(['otp_email' => $existingUser->email]);

            return redirect()->route('otp.verify')->with('success', 'Kode OTP baru telah dikirim ke email Anda. Silakan verifikasi untuk melanjutkan.');
        }

        // Validate input with strong password rules and unique email
        $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'ends_with:@gmail.com'],
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed', 
                Password::min(8)->mixedCase()->symbols()
            ],
            'terms'    => ['required', 'accepted'],
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'name.max'            => 'Nama maksimal 255 karakter.',
            'name.regex'          => 'Nama hanya boleh berisi huruf dan spasi (tanpa angka/karakter khusus).',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah terdaftar.',
            'email.ends_with'     => 'Email harus menggunakan domain @gmail.com.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 8 karakter.',
            'password.mixed'      => 'Password harus mengandung huruf besar dan huruf kecil.',
            'password.symbols'    => 'Password harus mengandung karakter simbol.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'terms.required'      => 'Anda harus menyetujui syarat & ketentuan.',
            'terms.accepted'      => 'Anda harus menyetujui syarat & ketentuan.',
        ]);

        // Rate limiting for registration: 3 attempts per minute per IP
        $throttleKey = 'register|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan registrasi. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        $otpCode = sprintf('%06d', mt_rand(100000, 999999));

        // Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP via Email
        Mail::to($user->email)->send(new OtpMail($otpCode));

        // Clear rate limiter
        RateLimiter::clear($throttleKey);

        // Save email to session for OTP page
        session(['otp_email' => $user->email]);

        return redirect()->route('otp.verify')->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.');
    }

    /**
     * Log the user out securely.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate entire session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the OTP verification form.
     */
    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    /**
     * Verify the OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.numeric' => 'Kode OTP harus berupa angka.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
        ]);

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi Anda telah habis. Silakan login kembali.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        if ((string) $user->otp_code !== trim((string) $request->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if ($user->otp_expires_at < now()) {
            return back()->withErrors(['otp' => 'Kode OTP telah kadaluarsa. Silakan minta kode baru.']);
        }

        // Mark as verified
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Clear session
        session()->forget('otp_email');

        return redirect()->route('login')->with('status', 'Verifikasi berhasil! Silakan login untuk melanjutkan.');
    }

    /**
     * Resend the OTP code.
     */
    public function resendOtp(Request $request)
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi Anda telah habis. Silakan login kembali.']);
        }

        // Throttle resend OTP: 1 per minute
        $throttleKey = 'resend_otp|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Harap tunggu {$seconds} detik sebelum meminta kode baru.");
        }
        RateLimiter::hit($throttleKey, 60);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login');
        }

        $otpCode = sprintf('%06d', mt_rand(100000, 999999));
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        Mail::to($user->email)->send(new OtpMail($otpCode));

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    /**
     * Show the forgot password form.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send reset link to the user's email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|ends_with:@gmail.com'
        ], [
            'email.ends_with' => 'Email harus menggunakan domain @gmail.com.',
        ]);

        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        if ($status === 'passwords.throttled') {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the reset password form.
     */
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|ends_with:@gmail.com',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->symbols()],
        ], [
            'email.ends_with' => 'Email harus menggunakan domain @gmail.com.',
            'password.mixed'  => 'Password harus mengandung huruf besar dan huruf kecil.',
            'password.symbols' => 'Password harus mengandung karakter simbol.',
        ]);

        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        if ($status === \Illuminate\Support\Facades\Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}