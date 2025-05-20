<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Vendor\VendorAuthController;
// use App\Http\Controllers\EstablishmentController; // Comentado pois o de Vendor foi criado
use App\Http\Controllers\Vendor\EstablishmentController as VendorEstablishmentController;
use App\Http\Controllers\Admin\EstablishmentController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\QrCodePdfController;
use App\Http\Controllers\QrCodeRedirectController;
use App\Http\Controllers\QrCodeStatisticsController;
use App\Http\Controllers\ProfileController;

// ======================================================================
// Rotas de Autenticação Diretas (fora dos grupos de prefixo)
// ======================================================================

// Rotas de login diretas - devem estar antes de outras rotas
Route::get('/admin/login', function () {
    // Only check admin auth for admin login
    if (Auth::guard('web')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return app()->make(LoginController::class)->showLoginForm();
});

Route::get('/vendor/login', function () {
    // Only check vendor auth for vendor login
    if (Auth::guard('vendor')->check()) {
        return redirect()->route('vendor.dashboard');
    }
    return app()->make(VendorAuthController::class)->showLoginForm();
});

// Direct logout routes to avoid CSRF issues
Route::match(['get', 'post'], '/admin/logout', [LoginController::class, 'logout']);
Route::match(['get', 'post'], '/vendor/logout', [VendorAuthController::class, 'logout']);

// QR Code Redirect Route
Route::get('/qr-code/{id}', [QrCodeRedirectController::class, 'redirect'])->name('qr-code.redirect');
Route::get('/code/{id}', [QrCodeRedirectController::class, 'redirect'])->name('code.redirect');

// Site Routes
Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('site.index');
Route::get('/parceiro', [\App\Http\Controllers\SiteController::class, 'parceiro'])->name('site.parceiro');
Route::get('/vendedor', [\App\Http\Controllers\SiteController::class, 'vendedor'])->name('site.vendedor');

// Rotas da API Fake para testes - sem middleware de autenticação e sempre retornando JSON
Route::prefix('api/fake')->name('api.fake.')->group(function () {
    Route::match(['get', 'post'], '/verificar-cliente', [\App\Http\Controllers\Api\FakeApiController::class, 'verificarCliente'])->name('verificar-cliente');
    Route::match(['get', 'post'], '/cadastrar-cliente', [\App\Http\Controllers\Api\FakeApiController::class, 'cadastrarCliente'])->name('cadastrar-cliente');
    Route::match(['get', 'post'], '/listar-clientes', [\App\Http\Controllers\Api\FakeApiController::class, 'listarClientes'])->name('listar-clientes');
});

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
    Route::get('login', function() {
        // Only check admin auth for admin login
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return app()->make(LoginController::class)->showLoginForm();
    })->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Password Reset Routes
    Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

    // Protected Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // User Management Routes
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('users/{user}/access-logs', [\App\Http\Controllers\Admin\UserController::class, 'accessLogs'])->name('users.access-logs');

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
            Route::delete('/{onboarding}', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'destroy'])->name('destroy');
        });

        // Establishment Management Routes
        Route::resource('establishments', EstablishmentController::class);

        // Rotas para Upload de Documento do Estabelecimento (Admin)
        Route::get('establishments/{establishment}/documents/upload', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'showUploadForm'])
            ->name('establishments.documents.upload.show');
        Route::post('establishments/{establishment}/documents/upload', [\App\Http\Controllers\Admin\DocumentApprovalController::class, 'handleUpload'])
            ->name('establishments.documents.upload.store');

        // Category Management Routes
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        // QR Code Management Routes
        Route::resource('qr-codes', QrCodeController::class)->except([
            // adicione métodos que não precisam das rotas resource aqui se necessário
        ]);
        Route::get('qr-codes/{qrCode}/download', [QrCodeController::class, 'download'])->name('qr-codes.download');
        Route::get('/qr-codes-pdf', [QrCodePdfController::class, 'generatePdf'])->name('qr-codes.pdf');

        // QR Code Statistics Routes
        Route::prefix('qr-codes/statistics')->name('qr-codes.statistics.')->group(function () {
            Route::get('/', [\App\Http\Controllers\QrCodeStatisticsController::class, 'index'])->name('index');
            Route::get('/{id}', [\App\Http\Controllers\QrCodeStatisticsController::class, 'show'])->name('show');
        });

        // Rota para gerar QR Codes em lote
        Route::get('/gerar-qrs/{startId}/{endId}', [QrCodeController::class, 'generateBatch'])
            ->where(['startId' => '[0-9]+', 'endId' => '[0-9]+'])
            ->name('qr-codes.generate-batch');
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
    Route::get('login', function() {
        // Only check vendor auth for vendor login
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }
        return app()->make(VendorAuthController::class)->showLoginForm();
    })->name('login');
    Route::post('login', [VendorAuthController::class, 'login'])->name('login.submit');

    Route::match(['get', 'post'], 'logout', [VendorAuthController::class, 'logout'])->name('logout');

    // Password Reset Routes
    Route::get('password/reset', [\App\Http\Controllers\Vendor\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Vendor\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Vendor\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Vendor\ResetPasswordController::class, 'reset'])->name('password.update');

    // Protected Vendor Routes
    Route::middleware(['auth:vendor'])->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Vendor\DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [VendorAuthController::class, 'profile'])->name('profile');
        Route::put('profile', [VendorAuthController::class, 'updateProfile'])->name('profile.update');

        // Establishment Management Routes for Vendor
        Route::resource('establishments', VendorEstablishmentController::class);

        // Establishment Documents Routes
        Route::prefix('establishments/documents')->name('establishments.documents')->group(function () {
            Route::get('/', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'index'])->name('');
            Route::get('/pending', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'pending'])->name('.pending');
            Route::get('/approved', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'approved'])->name('.approved');
            Route::get('/rejected', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'rejected'])->name('.rejected');
            Route::get('/{onboarding}', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'show'])->name('.show');
            Route::get('/{onboarding}/view', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'viewDocument'])->name('.view');
        });

        // Rotas para Upload de Documento do Estabelecimento (Vendor)
        Route::get('establishments/{establishment}/documents/upload', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'showUploadForm'])
            ->name('establishments.documents.upload.show');
        Route::post('establishments/{establishment}/documents/upload', [\App\Http\Controllers\Vendor\EstablishmentDocumentController::class, 'handleUpload'])
            ->name('establishments.documents.upload.store');
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
    // Check if user is logged in as admin
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }

    // Check if user is logged in as vendor
    if (Auth::guard('vendor')->check()) {
        return redirect()->route('vendor.dashboard');
    }

    // If not authenticated, redirect to site index
    return redirect()->route('site.index');
});
