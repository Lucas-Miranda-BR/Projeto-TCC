<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgendamentoController;


Route::prefix('site')->group(function () {

    Route::get('/', [SiteController::class, 'home'])
        ->name('site.home');

    Route::get('/sobre', [SiteController::class, 'sobre'])
        ->name('site.sobre');

    Route::get('/servicos', [SiteController::class, 'servicos'])
        ->name('site.servicos');

    Route::get('/produtos', [SiteController::class, 'produtos'])
        ->name('site.produtos');
});



Route::prefix('cliente')->group(function () {


    Route::get('/login', [ClienteController::class, 'login'])
        ->name('cliente.login');

    Route::post('/login', [ClienteController::class, 'entrar'])
        ->name('cliente.entrar');


    Route::get('/cadastro', [ClienteController::class, 'cadastro'])
        ->name('cliente.cadastro');

    Route::post('/cadastro', [ClienteController::class, 'salvarCadastro'])
        ->name('cliente.salvarCadastro');


    Route::get('/logout', [ClienteController::class, 'sair'])
        ->name('cliente.logout');

    

    Route::get('/dashboard', [ClienteController::class, 'dashboard'])
        ->name('cliente.dashboard');

    Route::get('/perfil', [ClienteController::class, 'perfil'])
        ->name('cliente.perfil');

    Route::get('/agendamentos', [ClienteController::class, 'agendamentos'])
        ->name('cliente.agendamentos');

    Route::post('/agendamento/salvar', [AgendamentoController::class, 'salvar'])
        ->name('cliente.salvar');

});




Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/clientes', [AdminController::class, 'clientes'])
        ->name('admin.clientes');

    Route::get('/agendamentos', [AdminController::class, 'agendamentos'])
        ->name('admin.agendamentos');

    Route::get('/calendario', [AdminController::class, 'calendario'])
        ->name('admin.calendario');

    Route::get('/produtos', [AdminController::class, 'produtos'])
        ->name('admin.produtos');

});