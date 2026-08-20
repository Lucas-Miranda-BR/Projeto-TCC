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
    public function createAgendamento(Request $request)
    {
        $tipos = \App\Models\Tipo::All();

        $cliente_id = session('cliente_id');

        $cliente = \App\Models\Cliente::find($cliente_id);

        if(!$cliente){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para realizar esse agendamento.']);
        }

        $agendamentos = Agendamento::with('servicos')->get();

        $tipo_selecionado = $request->query('tipo_selecionado');

        return view('agendamento.agendar', compact('tipos', 'cliente', 'agendamentos', 'tipo_selecionado'));
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
            ],

            'cliente_id' => [
                'required'
            ]
        ],
        [
            'hora.required' => 'Selecione uma hora disponível.',
            'hora.date_format' => 'Formato de hora incorreto.',

            'data.required' => 'Selecione uma data disponível.',
            'data.date' => 'Formato de data incorreto.',
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