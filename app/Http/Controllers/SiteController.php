<?php

namespace App\Http\Controllers;
use App\Models\ProcedimentoModel;
use App\Models\CorModel;
use App\Models\ClienteModel;
use App\Models\ItemModel;


class SiteController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function sobre()
    {
        return view('site.sobre');
    }

    public function servicos()
    {
        return view('site.servicos');
    }

    public function ia()
    {

        $procedimentos = \App\Models\ProcedimentoModel::with('tipos')->get();
        
        $clienteSession = session('cliente');

        $cores = \App\Models\CorModel::all();

        if(!$clienteSession){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para utilizar nossos recursos de IA.']);
        }
        
        $cliente = \App\Models\ClienteModel::find($clienteSession->cliente_id);

        return view('site.ia', compact('procedimentos', 'cliente', 'cores'));
    }

    public function produtos()
{
    $produtos = ItemModel::with([
        'marcas',
        'categorias'
    ])
        ->orderBy('nome')
        ->get();

    return view(
        'site.produtos',
        compact('produtos')
    );
}
}
