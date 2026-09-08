<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendamentoModel;
use App\Models\TipoModel;
use App\Models\ClienteModel;
use App\Models\ProcedimentoModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function createAgendamento(Request $request)
    {
        $imagemGeradaId = $request->query('imagem_gerada_id');
        $procedimentoSelecionado = null;

        if ($imagemGeradaId) {
            $promptIa = \App\Models\PromptIaModel::find($imagemGeradaId);
            if ($promptIa) {
                $procedimentoSelecionado = $promptIa->procedimento_id;
            }
        }

        $procedimentos = \App\Models\ProcedimentoModel::with('tipos')->get();

        if(!Auth::check()){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para realizar esse agendamento.']);
        }
    
        $cliente = Auth::user();
        
        if(!$cliente){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para realizar esse agendamento.']);
        }
        
        $clienteId = \App\Models\ClienteModel::find($cliente->cliente_id);

        $agendamentos = AgendamentoModel::with('servicos')->get();


        return view('agendamento.agendar', compact('procedimentos', 'clienteId', 'agendamentos', 'imagemGeradaId', 'procedimentoSelecionado'));
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

        AgendamentoModel::create($validated);

        return redirect()->route('site.sobre');
    }

    public function concluirAgendamento($id){

        $agendamento = AgendamentoModel::find($id);
        if ($agendamento) {
            $agendamento->isConcluido = 1;
            $agendamento->save();
        }

        return redirect()->back();
    }
}