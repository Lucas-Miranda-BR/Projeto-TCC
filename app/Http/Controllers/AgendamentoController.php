<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Tipo;
use App\Models\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AgendamentoController extends Controller
{
    public function createAgendamento()
    {
        $tipos = \App\Models\Tipo::All();

        $cliente = Cliente::findOrFail(1);

        $agendamentos = Agendamento::with('servico')->get();

        return view('agendamento.agendar', compact('tipos', 'cliente', 'agendamentos'));
    }

    public function storeAgendamento(Request $dados)
    {
        $validator = Validator::make($dados->all(), [
            'hora' => [
                'required',
                'date_format:H:i'
            ],

            'data' => [
                'required',
                'date'
            ]
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('agendamento.agendar')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        Agendamento::create($validated);

        return redirect()->route('site.sobre');
    }
}