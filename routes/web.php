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
        Route::get('vendors/{vendor}/access-logs', [VendorController::class, 'accessLogs'])->name('vendors.access-logs');

        // Establishment Documents Routes (Moved Before Resource Route)
        Route::prefix('establishments/documents')->name('establishments.documents.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'index'])->name('index');
            Route::get('/pending', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'pending'])->name('pending');
            Route::get('/approved', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'approved'])->name('approved');
            Route::get('/rejected', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'rejected'])->name('rejected');
            Route::get('/{onboarding}', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'show'])->name('show');
            Route::get('/{onboarding}/view', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'viewDocument'])->name('view');
            Route::post('/{onboarding}/approve', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'approve'])->name('approve');
            Route::post('/{onboarding}/reject', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'reject'])->name('reject');
        });

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
        Route::get('dashboard', [\App\Http\Controllers\Vendor\DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [VendorAuthController::class, 'profile'])->name('profile');
        Route::put('profile', [VendorAuthController::class, 'updateProfile'])->name('profile.update');

        // Establishment Management Routes
        Route::resource('establishments', EstablishmentController::class);

        // Establishment Documents Routes
        Route::prefix('establishments/documents')->name('establishments.documents')->group(function () {
            Route::get('/', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'index'])->name('');
            Route::get('/pending', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'pending'])->name('.pending');
            Route::get('/approved', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'approved'])->name('.approved');
            Route::get('/rejected', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'rejected'])->name('.rejected');
            Route::get('/{onboarding}', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'show'])->name('.show');
            Route::get('/{onboarding}/view', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'viewDocument'])->name('.view');
        });
    });
});

// Rotas de teste temporárias
Route::prefix('test')->name('test.')->group(function () {
    Route::get('/email', [\App\Http\Controllers\TestController::class, 'testEmail'])->name('email');
    Route::get('/email-template', [\App\Http\Controllers\TestController::class, 'testEmailTemplate'])->name('email-template');
});

// Rotas de onboarding para estabelecimentos
Route::prefix('establishment')->name('establishment.')->group(function () {
    Route::get('/onboarding/{token}', [\App\Http\Controllers\EstablishmentOnboardingController::class, 'show'])->name('onboarding');
    Route::post('/onboarding/{token}', [\App\Http\Controllers\EstablishmentOnboardingController::class, 'process'])->name('onboarding.process');
    Route::get('/onboarding/{token}/success', [\App\Http\Controllers\EstablishmentOnboardingController::class, 'success'])->name('onboarding.success');
});

// Fallback route - captura todas as rotas não definidas
Route::fallback(function () {
    return redirect()->route('site.index');
});
