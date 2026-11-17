<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiFotoController;
use App\Http\Controllers\ProcedimentoController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\CorController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\NetworthController;
use App\Http\Controllers\TemplateNotificacaoController;
use App\Http\Controllers\DescontoController;
use App\Http\Controllers\PagamentoController;


/*
|--------------------------------------------------------------------------
| MERCADO PAGO
|--------------------------------------------------------------------------
*/

Route::get('/pagamento/sucesso', [PagamentoController::class, 'retornoSucesso'])
    ->name('site.pagamento.sucesso');

Route::get('/pagamento/falha', [PagamentoController::class, 'retornoFalha'])
    ->name('site.pagamento.falha');

Route::get('/pagamento/pendente', [PagamentoController::class, 'retornoPendente'])
    ->name('site.pagamento.pendente');

Route::post('/webhook/mercadopago', [PagamentoController::class, 'webhook'])
    ->name('webhook.mp');

/*
|--------------------------------------------------------------------------
| SITE
|--------------------------------------------------------------------------
*/

// Tela inicial (entrada do site, sem footer). O botão dela leva para a home.
Route::view('/', 'site.inicio')
    ->name('inicio');

// Página home 
Route::get('/home', [SiteController::class, 'viewHome'])
    ->name('home');



Route::prefix('site')->group(function () {

    Route::get(
        '/sobre',
        [SiteController::class, 'viewSobre']
    )->name('site.sobre');


    Route::get(
        '/servicos',
        [SiteController::class, 'viewServicos']
    )->name('site.servicos');


    Route::get(
        '/produtos',
        [SiteController::class, 'viewProdutos']
    )->name('site.produtos');

    Route::get(
        '/produtos/{id}',
        [SiteController::class, 'viewProdutoDetalhe']
    )->name('site.produto.detalhe');


    Route::get(
        '/ia',
        [SiteController::class, 'viewIa']
    )->name('site.ia');

});


/*
|--------------------------------------------------------------------------
| IA
|--------------------------------------------------------------------------
*/

Route::prefix('ia')->group(function () {

    Route::post(
        '/gerar',
        [AiFotoController::class, 'storePrompt']
    )->name('ia.gerar');

});


/*
|--------------------------------------------------------------------------
| CLIENTE
|--------------------------------------------------------------------------
*/

Route::prefix('cliente')->group(function () {

    Route::get(
        '/cadastro',
        [ClienteController::class, 'createCliente']
    )->name('cliente.cadastro');


    Route::post(
        '/create',
        [ClienteController::class, 'storeCliente']
    )->name('cliente.create');


    Route::get(
        '/login',
        [ClienteController::class, 'loginCliente']
    )->name('cliente.login');


    Route::post(
        '/auth',
        [ClienteController::class, 'authCliente']
    )->name('cliente.auth');


    Route::get(
        '/logout',
        [ClienteController::class, 'logoutCliente']
    )->name('cliente.logout');


    Route::get(
        '/perfil',
        [ClienteController::class, 'viewPerfilCliente']
    )->name('cliente.perfil');


    Route::get(
        '/perfil/editar',
        [ClienteController::class, 'editPerfil']
    )->name('cliente.perfil.editar');


    Route::put(
        '/perfil',
        [ClienteController::class, 'updatePerfil']
    )->name('cliente.perfil.update');


    /*
    |--------------------------------------------------------------------------
    | NOTIFICAÇÕES DO CLIENTE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/notificacoes',
        [NotificacaoController::class, 'index']
    )
        ->middleware('auth')
        ->name('cliente.notificacoes');


    Route::patch(
        '/notificacoes/visualizar-todas',
        [
            NotificacaoController::class,
            'marcarTodasComoVisualizadas'
        ]
    )
        ->middleware('auth')
        ->name(
            'cliente.notificacoes.visualizar-todas'
        );


    Route::patch(
        '/notificacoes/{id}/visualizar',
        [
            NotificacaoController::class,
            'marcarComoVisualizada'
        ]
    )
        ->middleware('auth')
        ->name(
            'cliente.notificacoes.visualizar'
        );

});


/*
|--------------------------------------------------------------------------
| AGENDAMENTO CLIENTE
|--------------------------------------------------------------------------
*/

Route::prefix('agendamento')->group(function () {

    Route::get(
        '/agendar',
        [
            AgendamentoController::class,
            'createAgendamento'
        ]
    )->name('agendamento.agendar');


    Route::post(
        '/create',
        [
            AgendamentoController::class,
            'storeAgendamento'
        ]
    )->name('agendamento.create');

});


/*
|--------------------------------------------------------------------------
| CARRINHO
|--------------------------------------------------------------------------
*/

Route::prefix('cliente')->group(function () {

    Route::get(
        '/carrinho',
        [CarrinhoController::class, 'index']
    )->name('cliente.carrinho');


    Route::post(
        '/adicionar/{id}',
        [
            CarrinhoController::class,
            'adicionar'
        ]
    )->name('carrinho.adicionar');


    Route::post(
        '/finalizar',
        [
            CarrinhoController::class,
            'finalizar'
        ]
    )->name('carrinho.finalizar');


    Route::match(
        ['post', 'patch'],
        '/{id}',
        [
            CarrinhoController::class,
            'atualizar'
        ]
    )->name('carrinho.atualizar');


    Route::delete(
        '/{id}',
        [
            CarrinhoController::class,
            'remover'
        ]
    )->name('carrinho.remover');

});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | INÍCIO ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/', function () {

            return redirect()
                ->route('admin.dashboard');

        })->name('admin.index');


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [
                AdminController::class,
                'viewDashboard'
            ]
        )->name('admin.dashboard');


        Route::get(
            '/dashboard/dados',
            [
                AdminController::class,
                'dadosDashboard'
            ]
        )->name(
            'admin.dashboard.dados'
        );


        /*
        |--------------------------------------------------------------------------
        | CLIENTES - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/clientes',
            [
                AdminController::class,
                'viewClientes'
            ]
        )->name('admin.clientes');


        Route::post(
            '/clientes/{id}/notificacao',
            [
                NotificacaoController::class,
                'enviarParaCliente'
            ]
        )->name('admin.clientes.notificacao.enviar');

        
        /*
        |--------------------------------------------------------------------------
        | AGENDAMENTOS - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/agendamentos',
            [
                AdminController::class,
                'viewAgendamentos'
            ]
        )->name('admin.agendamentos');

        Route::get(
            '/agendamentos/{id}/editar',
            [AgendamentoController::class, 'editAgendamento']
        )->name('admin.agendamentos.edit');

        Route::put(
            '/agendamentos/{id}',
            [AgendamentoController::class, 'ajustarAgendamento']
        )->name('admin.agendamentos.update');


        Route::patch(
            '/agendamentos/{id}/concluir',
            [
                AgendamentoController::class,
                'concluirAgendamento'
            ]
        )->name('admin.agendamentos.concluir');


        Route::patch(
            '/agendamentos/{id}/cancelar',
            [
                AgendamentoController::class,
                'cancelarAgendamento'
            ]
        )->name('admin.agendamentos.cancelar');


        /*
        |--------------------------------------------------------------------------
        | PROCEDIMENTOS - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/procedimentos',
            [
                ProcedimentoController::class,
                'indexProcedimento'
            ]
        )->name('admin.procedimentos.index');


        Route::post(
            '/procedimentos/store',
            [
                ProcedimentoController::class,
                'storeProcedimento'
            ]
        )->name('admin.procedimentos.store');


        Route::get(
            '/procedimentos/{id}/edit',
            [
                ProcedimentoController::class,
                'editProcedimento'
            ]
        )->name('admin.procedimentos.edit');


        Route::put(
            '/procedimentos/{id}',
            [
                ProcedimentoController::class,
                'updateProcedimento'
            ]
        )->name('admin.procedimentos.update');


        Route::delete(
            '/procedimentos/{id}',
            [
                ProcedimentoController::class,
                'destroyProcedimento'
            ]
        )->name('admin.procedimentos.destroy');


        /*
        |--------------------------------------------------------------------------
        | TIPOS - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/tipos',
            [
                TipoController::class,
                'indexTipo'
            ]
        )->name('admin.tipos.index');


        Route::post(
            '/tipos/store',
            [
                TipoController::class,
                'storeTipo'
            ]
        )->name('admin.tipos.store');


        Route::get(
            '/tipos/{id}/edit',
            [
                TipoController::class,
                'editTipo'
            ]
        )->name('admin.tipos.edit');


        Route::put(
            '/tipos/{id}',
            [
                TipoController::class,
                'updateTipo'
            ]
        )->name('admin.tipos.update');


        Route::delete(
            '/tipos/{id}',
            [
                TipoController::class,
                'destroyTipo'
            ]
        )->name('admin.tipos.destroy');

        /*
        |--------------------------------------------------------------------------
        | CORES - ADMIN
        |--------------------------------------------------------------------------
        */


        Route::get(
            '/cores',
            [
                CorController::class,
                'indexCor'
            ]
        )->name('admin.cores.index');


        Route::post(
            '/cores/store',
            [
                CorController::class,
                'storeCor'
            ]
        )->name('admin.cores.store');


        Route::get(
            '/cores/{id}/edit',
            [
                CorController::class,
                'editCor'
            ]
        )->name('admin.cores.edit');


        Route::put(
            '/cores/{id}',
            [
                CorController::class,
                'updateCor'
            ]
        )->name('admin.cores.update');


        Route::delete(
            '/cores/{id}',
            [
                CorController::class,
                'destroyCor'
            ]
        )->name('admin.cores.destroy');


        /*
        |--------------------------------------------------------------------------
        | PRODUTOS - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/produtos',
            [
                ItemController::class,
                'index'
            ]
        )->name('admin.produtos.index');


        Route::post(
            '/produtos',
            [
                ItemController::class,
                'store'
            ]
        )->name('admin.produtos.store');


        Route::get(
            '/produtos/{id}/editar',
            [
                ItemController::class,
                'edit'
            ]
        )->name('admin.produtos.edit');


        Route::put(
            '/produtos/{id}',
            [
                ItemController::class,
                'update'
            ]
        )->name('admin.produtos.update');


        Route::delete(
            '/produtos/{id}',
            [
                ItemController::class,
                'destroy'
            ]
        )->name('admin.produtos.destroy');


        /*
        |--------------------------------------------------------------------------
        | MARCAS - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/marcas',
            [
                MarcaController::class,
                'store'
            ]
        )->name('admin.marcas.store');

        Route::post(
            '/marcas/store',
            [
                MarcaController::class,
                'storeMarca'
            ]
        )->name('admin.marcas.store');


        Route::get(
            '/marcas/{id}/edit',
            [
                MarcaController::class,
                'editMarca'
            ]
        )->name('admin.marcas.edit');


        Route::put(
            '/marcas/{id}',
            [
                MarcaController::class,
                'updateMarca'
            ]
        )->name('admin.marcas.update');


        Route::delete(
            '/marcas/{id}',
            [
                MarcaController::class,
                'destroyMarca'
            ]
        )->name('admin.marcas.destroy');



        /*
        |--------------------------------------------------------------------------
        | CATEGORIAS - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/categorias',
            [
                CategoriaController::class,
                'store'
            ]
        )->name('admin.categorias.store');

        Route::post(
            '/categorias/store',
            [
                CategoriaController::class,
                'storeCategoria'
            ]
        )->name('admin.categorias.store');

        Route::get(
            '/categorias/{id}/edit',
            [
                CategoriaController::class,
                'editCategoria'
            ]
        )->name('admin.categorias.edit');


        Route::put(
            '/categorias/{id}',
            [
                CategoriaController::class,
                'updateCategoria'
            ]
        )->name('admin.categorias.update');


        Route::delete(
            '/categorias/{id}',
            [
                CategoriaController::class,
                'destroyCategoria'
            ]
        )->name('admin.categorias.destroy');


        /*
        |--------------------------------------------------------------------------
        | NETWORTH - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/networth/gerenciar',
            [NetworthController::class, 'gerenciar']
        )->name('admin.networth.gerenciar');

        Route::post(
            '/networth/ganho',
            [NetworthController::class, 'adicionarGanho']
        )->name('admin.networth.ganho.store');

        Route::post(
            '/networth/custo',
            [NetworthController::class, 'adicionarCusto']
        )->name('admin.networth.custo.store');

        /*
        |--------------------------------------------------------------------------
        |   NOTIFICAÇÕES - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/templates-notificacao', 
            [TemplateNotificacaoController::class, 'index']
        )->name('admin.templates.index');

        Route::get(
            '/templates-notificacao/{id}/editar', 
            [TemplateNotificacaoController::class, 'edit']
        )->name('admin.templates.edit');

        Route::put(
            '/templates-notificacao/{id}', 
            [TemplateNotificacaoController::class, 'update']
        )->name('admin.templates.update');

        Route::get(
            '/notificacoes',
            [
                NotificacaoController::class,
                'adminIndex'
            ]
        )->name('admin.notificacoes');
        
        
        Route::delete(
            '/notificacoes/{id}',
            [
                NotificacaoController::class,
                'destruir'
            ]
        )->name('admin.notificacoes.destroy');


        /*
        |--------------------------------------------------------------------------
        | DESCONTOS - ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/descontos',
            [DescontoController::class, 'index'])
        ->name('admin.descontos.index');

        Route::get(
            '/descontos/criar', 
            [DescontoController::class, 'create'])
        ->name('admin.descontos.create');

        Route::post(
            '/descontos', 
            [DescontoController::class, 'store'])
        ->name('admin.descontos.store');

        Route::get(
            '/descontos/{id}/editar', 
            [DescontoController::class, 'edit'])
        ->name('admin.descontos.edit');

        Route::put(
            '/descontos/{id}', 
            [DescontoController::class, 'update'])
        ->name('admin.descontos.update');

        Route::delete(
            '/descontos/{id}', 
            [DescontoController::class, 'destroy'])
        ->name('admin.descontos.destroy');
    });

    

