<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiFotoController;
use App\Http\Controllers\ProcedimentoController;
use App\Http\Controllers\ProdutoController;

/*
|--------------------------------------------------------------------------
| SITE
|--------------------------------------------------------------------------
*/

Route::get('/', [SiteController::class, 'viewHome'])
    ->name('home');

Route::prefix('site')->group(function () {

    Route::get('/sobre', [SiteController::class, 'viewSobre'])
        ->name('site.sobre');

    Route::get('/servicos', [SiteController::class, 'viewServicos'])
        ->name('site.servicos');

    Route::get('/produtos', [SiteController::class, 'viewProdutos'])
        ->name('site.produtos');

    Route::get('/ia', [SiteController::class, 'viewIa'])
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

    Route::get('/logout', [ClienteController::class, 'logoutCliente'])
        ->name('cliente.logout');

    Route::post('/auth', [ClienteController::class, 'authCliente'])
        ->name('cliente.auth');

    Route::get('/logout', [ClienteController::class, 'logoutCliente'])
        ->name('cliente.logout');

    Route::get('/perfil', [ClienteController::class, 'viewPerfilCliente'])
        ->name('cliente.perfil');
});



Route::prefix('agendamento')->group(function () {

    Route::get('/agendar', [AgendamentoController::class, 'createAgendamento'])
        ->name('agendamento.agendar');
        
    Route::post('/create', [AgendamentoController::class, 'storeAgendamento'])
        ->name('agendamento.create');

});

Route::prefix('produto')->group(function () {

    Route::post('/create', [ProdutoController::class, 'storeProduto'])
        ->name('produto.create');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'viewDashboard'])
        ->name('admin.dashboard');

    Route::get('/clientes', [AdminController::class, 'viewClientes'])
        ->name('admin.clientes');

    Route::get('/calendario', [AdminController::class, 'viewCalendario'])
        ->name('admin.calendario');

    Route::get('/produtos', [AdminController::class, 'viewProdutos'])
        ->name('admin.produtos');

    // ---------------------------------------------------
    // PROCEDIMENTOS (SERVIÇOS)
    // ---------------------------------------------------
    
    // Rota que exibe tudo dentro do Dashboard
    Route::get('/procedimentos', [ProcedimentoController::class, 'indexProcedimento'])
        ->name('admin.procedimentos.index');

    // Rotas exclusivas para gerenciar as ações
    Route::prefix('procedimentos')->group(function () {
        
        Route::post('/store', [ProcedimentoController::class, 'storeProcedimento'])
            ->name('admin.procedimentos.store');

        Route::get('/{id}/edit', [ProcedimentoController::class, 'editProcedimento'])
            ->name('admin.procedimentos.edit');

        Route::put('/{id}', [ProcedimentoController::class, 'updateProcedimento'])
            ->name('admin.procedimentos.update');

        Route::delete('/{id}', [ProcedimentoController::class, 'destroyProcedimento'])
            ->name('admin.procedimentos.destroy');

    });

    Route::prefix('agendamentos')->group(function(){
        
    Route::get('/', [AdminController::class, 'viewAgendamentos'])
    ->name('admin.agendamentos');

    Route::patch('/{id}/concluir', [AgendamentoController::class, 'concluirAgendamento'])
            ->name('admin.agendamentos.concluir');
    });

    Route::get('/tipos', [TipoController::class, 'indexTipo'])
    ->name('admin.tipos.index');

    Route::prefix('tipos')->group(function () {
        
        Route::post('/store', [TipoController::class, 'storeTipo'])
            ->name('admin.tipos.store');

        Route::get('/{id}/edit', [TipoController::class, 'editTipo'])
            ->name('admin.tipos.edit');

        Route::put('/{id}', [TipoController::class, 'updateTipo'])
            ->name('admin.tipos.update');

        Route::delete('/{id}', [TipoController::class, 'destroyTipo'])
            ->name('admin.tipos.destroy');

    });

});