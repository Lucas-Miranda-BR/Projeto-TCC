<?php

namespace App\Http\Controllers;

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

        $procedimentos = \App\Models\Procedimento::with('tipos')->get();
        
        $clienteSession = session('cliente');

        $cores = \App\Models\Cor::all();

        if(!$clienteSession){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para utilizar nossos recursos de IA.']);
        }
        
        $cliente = \App\Models\Cliente::find($clienteSession->cliente_id);

        return view('site.ia', compact('procedimentos', 'cliente', 'cores'));
    }

    public function produtos()
    {
        return view('site.produtos');
    }
}
