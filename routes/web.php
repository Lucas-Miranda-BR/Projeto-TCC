<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiFotoController;
use App\Http\Controllers\ProcedimentoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;


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

    Route::get('/perfil/editar', [ClienteController::class, 'editPerfil'])
        ->name('cliente.perfil.editar');

    Route::put('/perfil', [ClienteController::class, 'updatePerfil'])
        ->name('cliente.perfil.update');

});


/*
|--------------------------------------------------------------------------
| AGENDAMENTO CLIENTE
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
| CARRINHO
|--------------------------------------------------------------------------
*/

Route::prefix('carrinho')->group(function () {

    Route::get('/', [CarrinhoController::class, 'index'])
        ->name('carrinho.index');

    Route::post('/adicionar/{id}', [CarrinhoController::class, 'adicionar'])
        ->name('carrinho.adicionar');

    Route::patch('/{id}', [CarrinhoController::class, 'atualizar'])
        ->name('carrinho.atualizar');

    Route::delete('/{id}', [CarrinhoController::class, 'remover'])
        ->name('carrinho.remover');

    Route::post('/finalizar', [CarrinhoController::class, 'finalizar'])
        ->name('carrinho.finalizar');

});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/dashboard/dados', [AdminController::class, 'dadosDashboard'])
        ->name('admin.dashboard.dados');


    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    Route::get('/clientes', [AdminController::class, 'clientes'])
        ->name('admin.clientes');


    /*
    |--------------------------------------------------------------------------
    | CALENDÁRIO
    |--------------------------------------------------------------------------
    */

    Route::get('/calendario', [AdminController::class, 'calendario'])
        ->name('admin.calendario');


    /*
    |--------------------------------------------------------------------------
    | PRODUTOS
    |--------------------------------------------------------------------------
    */

    Route::get('/produtos', [ItemController::class, 'index'])
        ->name('admin.produtos.index');

    Route::post('/produtos', [ItemController::class, 'store'])
        ->name('admin.produtos.store');

    Route::get('/produtos/{id}/editar', [ItemController::class, 'edit'])
        ->name('admin.produtos.edit');

    Route::put('/produtos/{id}', [ItemController::class, 'update'])
        ->name('admin.produtos.update');

    Route::delete('/produtos/{id}', [ItemController::class, 'destroy'])
        ->name('admin.produtos.destroy');


    /*
    |--------------------------------------------------------------------------
    | PROCEDIMENTOS
    |--------------------------------------------------------------------------
    */

    Route::get('/procedimentos', [ProcedimentoController::class, 'index'])
        ->name('admin.procedimentos.index');


    Route::prefix('procedimentos')->group(function () {

        Route::post('/store', [ProcedimentoController::class, 'store'])
            ->name('admin.procedimentos.store');

        Route::get('/{id}/edit', [ProcedimentoController::class, 'edit'])
            ->name('admin.procedimentos.edit');

        Route::put('/{id}', [ProcedimentoController::class, 'update'])
            ->name('admin.procedimentos.update');

        Route::delete('/{id}', [ProcedimentoController::class, 'destroy'])
            ->name('admin.procedimentos.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | AGENDAMENTOS
    |--------------------------------------------------------------------------
    */

    Route::prefix('agendamentos')->group(function () {

        Route::get('/', [AdminController::class, 'agendamentos'])
            ->name('admin.agendamentos');

        Route::patch('/{id}/concluir', [AgendamentoController::class, 'concluirAgendamento'])
            ->name('admin.agendamentos.concluir');

    });

    /*
    |--------------------------------------------------------------------------
    | MARCAS & CATEGORIAS
    |--------------------------------------------------------------------------
    */
    Route::post('/marcas', [MarcaController::class, 'store'])
    ->name('admin.marcas.store');
    Route::post('/categorias', [CategoriaController::class, 'store'])
    ->name('admin.categorias.store');

});