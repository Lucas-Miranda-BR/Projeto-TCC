<?php

namespace App\Http\Controllers;
use App\Models\ProcedimentoModel;
use App\Models\CorModel;
use App\Models\ClienteModel;


class SiteController extends Controller
{
    public function viewHome()
    {
        return view('home');
    }

    public function viewSobre()
    {
        return view('site.sobre');
    }

    public function viewServicos()
    {
        return view('site.servicos');
    }

    public function viewIa()
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

    public function viewProdutos()
    {
        return view('site.produtos');
    }
}
