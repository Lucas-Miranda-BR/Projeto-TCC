<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;

Route::prefix('site')->group(function(){

    Route::get('/home', [SiteController::class,'home'])
        ->name('site.home');

    Route::get('/sobre', [SiteController::class,'sobre'])
        ->name('site.sobre');

    Route::get('/servicos', [SiteController::class,'servicos'])
        ->name('site.servicos');

    Route::get('/produtos', [SiteController::class,'produtos'])
        ->name('site.produtos');    
});

Route::prefix('cliente')->group(function(){

    Route::get('/cadastro', [ClienteController::class,'createCliente'])
        ->name('cliente.cadastro');

    Route::post('/create', [ClienteController::class,'storeCliente'])
        ->name('cliente.create');

        Route::get('/login', [ClienteController::class,'loginCliente'])
        ->name('cliente.login');

        Route::get('/auth', [ClienteController::class,'authCliente'])
        ->name('cliente.auth');

    Route::get('/perfil', [ClienteController::class,'perfil'])
        ->name('cliente.perfil');

    Route::get('/agendamentos', [ClienteController::class,'agendamentos'])
        ->name('cliente.agendamentos');

    Route::post('/agendamento/salvar',[AgendamentoController::class,'salvar']
    )->name('cliente.salvar');

});

Route::prefix('admin')->group(function(){

    Route::get('/dashboard', [AdminController::class,'dashboard'])
        ->name('admin.dashboard');

    Route::get('/clientes', [AdminController::class,'clientes'])
        ->name('admin.clientes');

    Route::get('/agendamentos', [AdminController::class,'agendamentos'])
        ->name('admin.agendamentos');

    Route::get('/calendario', [AdminController::class,'calendario'])
        ->name('admin.calendario');

    Route::get('/dashboard/produtos', [AdminController::class,'produtos'])
        ->name('admin.produtos');
});