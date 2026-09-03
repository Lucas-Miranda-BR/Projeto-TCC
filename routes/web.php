<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiFotoController;
use App\Http\Controllers\ProcedimentoController;

/*
|--------------------------------------------------------------------------
| SITE
|--------------------------------------------------------------------------
*/

Route::get('/', [SiteController::class, 'home'])
    ->name('home');

Route::prefix('site')->group(function () {

    Route::get('/sobre', [SiteController::class, 'sobre'])
        ->name('site.sobre');

    Route::get('/servicos', [SiteController::class, 'servicos'])
        ->name('site.servicos');

    Route::get('/produtos', [SiteController::class, 'produtos'])
        ->name('site.produtos');

    Route::get('/ia', [SiteController::class, 'ia'])
        ->name('site.ia');
});

/*
|--------------------------------------------------------------------------
| IA
|--------------------------------------------------------------------------
*/

Route::prefix('ia')->group(function () {

    Route::post('/gerar', [AiFotoController::class, 'storePrompt'])
        ->name('ia.gerar');
});

/*
|--------------------------------------------------------------------------
| CLIENTE
|--------------------------------------------------------------------------
*/

Route::prefix('cliente')->group(function () {

    Route::get('/cadastro', [ClienteController::class, 'createCliente'])
        ->name('cliente.cadastro');

    Route::post('/create', [ClienteController::class, 'storeCliente'])
        ->name('cliente.create');

    Route::get('/login', [ClienteController::class, 'loginCliente'])
        ->name('cliente.login');

    Route::post('/auth', [ClienteController::class, 'authCliente'])
        ->name('cliente.auth');

    Route::get('/logout', [ClienteController::class, 'logoutCliente'])
        ->name('cliente.logout');

    Route::get('/perfil', [ClienteController::class, 'perfil'])
        ->name('cliente.perfil');
});

/*
|--------------------------------------------------------------------------
| AGENDAMENTO
|--------------------------------------------------------------------------
*/

Route::prefix('agendamento')->group(function () {

    Route::get('/agendar', [AgendamentoController::class, 'createAgendamento'])
        ->name('agendamento.agendar');

    Route::post('/create', [AgendamentoController::class, 'storeAgendamento'])
        ->name('agendamento.create');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/clientes', [AdminController::class, 'clientes'])
        ->name('admin.clientes');

    Route::get('/agendamentos', [AdminController::class, 'agendamentos'])
        ->name('admin.agendamentos');

    Route::get('/calendario', [AdminController::class, 'calendario'])
        ->name('admin.calendario');

    Route::get('/dashboard/produtos', [AdminController::class, 'produtos'])
        ->name('admin.produtos');
});