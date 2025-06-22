<?php

use App\Http\Controllers\Admin\AdminUsuarioController;
use App\Http\Controllers\Admin\AdminEstabelecimentoController;
use App\Http\Controllers\Admin\AdminCategoriaController;
use App\Http\Controllers\Admin\AdminClienteController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ContratoController as AdminContratoController;
use App\Http\Controllers\Admin\ConfiguracaoController;
use App\Http\Controllers\Usuario\UsuarioAuthController;
use App\Http\Controllers\Usuario\UsuarioDashboardController;
use App\Http\Controllers\Usuario\RecargaController;
use App\Http\Controllers\Estabelecimento\EstabelecimentoAuthController;
use App\Http\Controllers\Estabelecimento\EstabelecimentoDashboardController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rotas do Site movidas para cima para ter prioridade
Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::get('/cadastro', [SiteController::class, 'cadastro'])->name('site.cadastro');
Route::post('/cadastro', [SiteController::class, 'cadastroStore'])->name('site.cadastro.store');
Route::get('/cadastro/sucesso', [SiteController::class, 'cadastroSucesso'])->name('site.cadastro.sucesso');

// Páginas institucionais
Route::get('/termos-de-uso', [SiteController::class, 'termosDeUso'])->name('site.termos');
Route::get('/politica-de-privacidade', [SiteController::class, 'politicaPrivacidade'])->name('site.privacidade');
Route::get('/contato', [SiteController::class, 'contato'])->name('site.contato');
Route::post('/contato', [SiteController::class, 'contatoStore'])->name('site.contato.store');
Route::get('/rede-credenciada', [SiteController::class, 'redeCredenciada'])->name('site.rede');
Route::get('/central-de-ajuda', [SiteController::class, 'centralAjuda'])->name('site.ajuda');
Route::get('/suporte', [SiteController::class, 'suporte'])->name('site.suporte');

// Rota removida - dashboard não existe

// Rota raiz /usuario - redirecionamento inteligente
Route::get('/usuario', function () {
    if (Auth::guard('usuario')->check()) {
        return redirect()->route('usuario.dashboard');
    }
    return redirect()->route('usuario.login');
});

// Rota raiz /estabelecimento - redirecionamento inteligente
Route::get('/estabelecimento', function () {
    if (Auth::guard('estabelecimento')->check()) {
        return redirect()->route('estabelecimento.dashboard');
    }
    return redirect()->route('estabelecimento.login');
});

// Rotas Usuario
Route::prefix('usuario')->name('usuario.')->group(function () {
    // Auth routes
    Route::middleware('guest:usuario')->group(function () {
        Route::get('login', [UsuarioAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [UsuarioAuthController::class, 'login'])->middleware('throttle:5,1');
    });

    // Protected routes
    Route::middleware(['auth:usuario', 'usuario.ativo'])->group(function () {
        Route::get('dashboard', [UsuarioDashboardController::class, 'index'])->name('dashboard');
        Route::resource('recargas', RecargaController::class)->only(['index', 'create', 'store']);
        Route::post('logout', [UsuarioAuthController::class, 'logout'])->name('logout');
    });
});

// Rotas Estabelecimento
Route::prefix('estabelecimento')->name('estabelecimento.')->group(function () {
    // Auth routes
    Route::middleware('guest:estabelecimento')->group(function () {
        Route::get('login', [EstabelecimentoAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [EstabelecimentoAuthController::class, 'login'])->middleware('throttle:5,1');
    });

    // Protected routes
    Route::middleware(['auth:estabelecimento', 'estabelecimento.ativo'])->group(function () {
        Route::get('dashboard', [EstabelecimentoDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [EstabelecimentoAuthController::class, 'logout'])->name('logout');
    });
});

// Rotas Admin Auth (fora do middleware auth)
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes - usando guest:web para especificar o guard correto
    Route::middleware('guest:web')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');
    });

    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Rotas Admin (com middleware auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    // Usuários Admin - CRUD completo (novo padrão)
    Route::resource('users', AdminUserController::class);

    // Categorias - CRUD completo (novo padrão)
    Route::resource('categories', AdminCategoriaController::class)->parameters([
        'categories' => 'categoria'
    ]);

    // Estabelecimentos - CRUD completo (novo padrão)
    Route::resource('establishments', AdminEstabelecimentoController::class);

    // Clientes - CRUD completo
    Route::resource('clientes', AdminClienteController::class);

    // Contratos - CRUD completo + ações específicas
    Route::resource('contratos', AdminContratoController::class);
    Route::get('usuarios/{usuario}/definir-limite', [AdminContratoController::class, 'definirLimite'])->name('usuarios.definir-limite');
    Route::post('usuarios/{usuario}/salvar-limite', [AdminContratoController::class, 'salvarLimite'])->name('usuarios.salvar-limite');
    Route::post('contratos/{contrato}/ativar', [AdminContratoController::class, 'ativar'])->name('contratos.ativar');
    Route::post('contratos/{contrato}/cancelar', [AdminContratoController::class, 'cancelar'])->name('contratos.cancelar');
    Route::get('contratos/revisao-score', [AdminContratoController::class, 'revisaoScore'])->name('contratos.revisao-score');

    // Configurações do Sistema
    Route::get('configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
    Route::post('configuracoes', [ConfiguracaoController::class, 'store'])->name('configuracoes.store');
    Route::put('configuracoes/{configuracao}', [ConfiguracaoController::class, 'update'])->name('configuracoes.update');
});

require __DIR__.'/auth.php';
