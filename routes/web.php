<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorAuthController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\Admin\AdminEstablishmentController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Vendor Management Routes
        Route::resource('vendors', VendorController::class);

        // Establishment Management Routes
        Route::resource('establishments', AdminEstablishmentController::class);
    });
});

// Vendor Routes
Route::prefix('vendor')->name('vendor.')->group(function () {
    // Guest Vendor Routes
    Route::middleware('guest:vendor')->group(function () {
        Route::get('login', [VendorAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [VendorAuthController::class, 'login'])->name('login.submit');
    });

    Route::post('logout', [VendorAuthController::class, 'logout'])->name('logout');

    // Protected Vendor Routes
    Route::middleware(['auth:vendor'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('vendor.dashboard');
        });

        Route::get('dashboard', function () {
            return redirect()->route('vendor.profile');
        })->name('dashboard');

        Route::get('profile', [VendorAuthController::class, 'profile'])->name('profile');
        Route::put('profile', [VendorAuthController::class, 'updateProfile'])->name('profile.update');

        // Establishment Management Routes
        Route::resource('establishments', EstablishmentController::class);
    });
});
