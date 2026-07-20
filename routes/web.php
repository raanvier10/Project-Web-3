<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Owner\OwnerDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/otp-verify', [AuthController::class, 'showOtpForm'])->name('otp.verify');
    Route::post('/otp-verify', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
    Route::post('/otp-resend', [AuthController::class, 'resendOtp'])->name('otp.resend');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Course Packages
    Route::get('/dashboard/packages', [DashboardController::class, 'packages'])->name('dashboard.packages');

    // Registration
    Route::get('/dashboard/register/{package}', [DashboardController::class, 'showRegistrationForm'])->name('dashboard.register');
    Route::post('/dashboard/register/{package}', [DashboardController::class, 'register'])->name('dashboard.register.submit');
    Route::delete('/dashboard/registration/{registration}/cancel', [DashboardController::class, 'cancelRegistration'])->name('dashboard.registration.cancel');

    // Payment
    Route::get('/dashboard/payment/{registration}', [DashboardController::class, 'showPayment'])->name('dashboard.payment');
    Route::post('/dashboard/payment/{registration}', [DashboardController::class, 'uploadPayment'])->name('dashboard.payment.upload');

    // Transaction History
    Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');

    // ============================
    // ADMIN DASHBOARD
    // ============================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard overview
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen Paket Kursus dipindah ke Owner

        // Verifikasi Pembayaran
        Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments');
        Route::get('/payments/{payment}/detail', [AdminDashboardController::class, 'paymentDetail'])->name('payments.detail');
        Route::post('/payments/{payment}/accept', [AdminDashboardController::class, 'acceptPayment'])->name('payments.accept');
        Route::post('/payments/{payment}/reject', [AdminDashboardController::class, 'rejectPayment'])->name('payments.reject');

        // Manajemen Peserta
        Route::get('/participants', [AdminDashboardController::class, 'participants'])->name('participants');
        Route::patch('/participants/{registration}/complete', [AdminDashboardController::class, 'completeParticipant'])->name('participants.complete');

        // Laporan & Export
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
        Route::get('/reports/export/excel', [AdminDashboardController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('/reports/export/pdf', [AdminDashboardController::class, 'exportPdf'])->name('reports.export.pdf');
    });

    // ============================
    // OWNER DASHBOARD
    // ============================
    Route::middleware('owner')->prefix('owner')->name('owner.')->group(function () {
        // Dashboard overview
        Route::get('/', [OwnerDashboardController::class, 'index'])->name('dashboard');

        // Manajemen Staff
        Route::get('/staff', [OwnerDashboardController::class, 'staff'])->name('staff');
        Route::post('/staff', [OwnerDashboardController::class, 'storeStaff'])->name('staff.store');
        Route::put('/staff/{user}', [OwnerDashboardController::class, 'updateStaff'])->name('staff.update');
        Route::delete('/staff/{user}', [OwnerDashboardController::class, 'deleteStaff'])->name('staff.delete');

        // Manajemen Paket Kursus
        Route::get('/packages', [OwnerDashboardController::class, 'packages'])->name('packages');
        Route::post('/packages', [OwnerDashboardController::class, 'storePackage'])->name('packages.store');
        Route::post('/packages/import', [OwnerDashboardController::class, 'importPackages'])->name('packages.import');
        Route::get('/packages/template', [OwnerDashboardController::class, 'downloadTemplate'])->name('packages.template');
        Route::put('/packages/{package}', [OwnerDashboardController::class, 'updatePackage'])->name('packages.update');
        Route::patch('/packages/{package}/toggle', [OwnerDashboardController::class, 'togglePackage'])->name('packages.toggle');
        Route::delete('/packages/{package}', [OwnerDashboardController::class, 'deletePackage'])->name('packages.delete');

        // Laporan Keuangan
        Route::get('/reports', [OwnerDashboardController::class, 'reports'])->name('reports');
        Route::get('/reports/export/excel', [OwnerDashboardController::class, 'exportExcel'])->name('reports.export.excel');
    });
});
