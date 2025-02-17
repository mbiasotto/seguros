<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorAuthController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Vendor Authentication Routes
Route::get('/vendor/login', [VendorAuthController::class, 'showLoginForm'])->name('vendor.login');
Route::post('/vendor/login', [VendorAuthController::class, 'login']);
Route::post('/vendor/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');

// Vendor Profile Routes
Route::get('/vendor/profile', [VendorAuthController::class, 'profile'])->name('vendor.profile');
Route::put('/vendor/profile', [VendorAuthController::class, 'updateProfile'])->name('vendor.profile.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('vendors.index');
    })->name('dashboard');

    // Vendor Management Routes
    Route::resource('vendors', VendorController::class);
});
