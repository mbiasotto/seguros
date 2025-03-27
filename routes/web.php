<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorAuthController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\Admin\AdminEstablishmentController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\QrCodePdfController;
use App\Http\Controllers\QrCodeRedirectController;

// QR Code Redirect Route
Route::get('/qr-code/{id}', [QrCodeRedirectController::class, 'redirect'])->name('qr-code.redirect');

// Site Routes
Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('site.index');
Route::get('/parceiro', [\App\Http\Controllers\SiteController::class, 'parceiro'])->name('site.parceiro');
Route::get('/vendedor', [\App\Http\Controllers\SiteController::class, 'vendedor'])->name('site.vendedor');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Rota raiz para /admin - redireciona para dashboard se autenticado, ou para login se não
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });

    // Rotas de autenticação para admin
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    });
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Vendor Management Routes
        Route::resource('vendors', VendorController::class);

        // Establishment Management Routes
        Route::resource('establishments', AdminEstablishmentController::class);

        // QR Code Management Routes
        Route::resource('qr-codes', QrCodeController::class);
        Route::get('qr-codes/{qrCode}/download', [QrCodeController::class, 'download'])->name('qr-codes.download');
        Route::get('/qr-codes-pdf', [QrCodePdfController::class, 'generatePdf'])->name('qr-codes.pdf');
    });
});

// Vendor Routes
Route::prefix('vendor')->name('vendor.')->group(function () {
    // Rota raiz para /vendor - redireciona para dashboard se autenticado, ou para login se não
    Route::get('/', function () {
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }
        return redirect()->route('vendor.login');
    });

    // Guest Vendor Routes
    Route::middleware('guest:vendor')->group(function () {
        Route::get('login', [VendorAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [VendorAuthController::class, 'login'])->name('login.submit');
    });

    Route::post('logout', [VendorAuthController::class, 'logout'])->name('logout');

    // Protected Vendor Routes
    Route::middleware(['auth:vendor'])->group(function () {
        Route::get('dashboard', function () {
            return redirect()->route('vendor.profile');
        })->name('dashboard');

        Route::get('profile', [VendorAuthController::class, 'profile'])->name('profile');
        Route::put('profile', [VendorAuthController::class, 'updateProfile'])->name('profile.update');

        // Establishment Management Routes
        Route::resource('establishments', EstablishmentController::class);
    });
});

// Fallback route - captura todas as rotas não definidas
Route::fallback(function () {
    return redirect()->route('site.index');
});
