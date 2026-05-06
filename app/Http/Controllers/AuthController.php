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
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
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
        // Validate input with strong password rules
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms'    => ['required', 'accepted'],
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'name.max'            => 'Nama maksimal 255 karakter.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah terdaftar.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 8 karakter.',
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

        // Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto login after registration
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Clear rate limiter
        RateLimiter::clear($throttleKey);

        return redirect('/dashboard');
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
}