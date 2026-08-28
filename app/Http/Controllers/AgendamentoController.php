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
        // $imagemGeradaId = $request->query('imagem_gerada_id');
        // $procedimentoSelecionado = null;

        // if ($imagemGeradaId) {
        //     $promptIa = \App\Models\PromptIa::find($imagemGeradaId);
        //     if ($promptIa) {
        //         $procedimentoSelecionado = $promptIa->procedimento_id;
        //     }
        // }

        // DESATIVADO - TESTE IA - API

        $procedimentos = \App\Models\Procedimento::with('tipos')->get();

        $clienteSession = session('cliente');
        
        if(!$clienteSession){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para realizar esse agendamento.']);
        }
        
        $cliente = \App\Models\Cliente::find($clienteSession->cliente_id);

        $agendamentos = Agendamento::with('servicos')->get();


        return view('agendamento.agendar', compact('procedimentos', 'cliente', 'agendamentos', 'imagemGeradaId', 'procedimentoSelecionado'));
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
            ],
            'procedimento_id' => [
                'required',
                'exists:procedimento,procedimento_id'
            ],
            'imagem_gerada_id' => [
                'nullable'
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