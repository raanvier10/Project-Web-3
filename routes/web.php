<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

    // Payment
    Route::get('/dashboard/payment/{registration}', [DashboardController::class, 'showPayment'])->name('dashboard.payment');
    Route::post('/dashboard/payment/{registration}', [DashboardController::class, 'uploadPayment'])->name('dashboard.payment.upload');

    // Transaction History
    Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');
});