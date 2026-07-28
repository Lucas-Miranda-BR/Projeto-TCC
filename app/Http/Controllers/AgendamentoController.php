<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;

class AgendamentoController extends Controller
{
    public function index()
    {
        return view('cliente.agendamentos');
    }

    public function salvar(Request $request)
    {
        Agendamento::create([

            'nome' => $request->nome,
            'servico' => $request->servico,
            'data' => $request->data,
            'hora' => $request->hora,
            'valor' => $request->valor,

        ]);

        return redirect()
            ->back()
            ->with('success','Agendamento realizado!');
    }
}