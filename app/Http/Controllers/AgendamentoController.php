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
use App\Models\NotificacaoModel;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    public function createAgendamento(Request $request)
    {
        $imagemGeradaId = $request->query('imagem_gerada_id');
        $procedimentoSelecionado = null;

        if ($imagemGeradaId) {
            $promptIa = PromptIaModel::find($imagemGeradaId);
            if ($promptIa) {
                $procedimentoSelecionado = $promptIa->procedimento_id;
            }
        }

        $procedimentos = ProcedimentoModel::with('tipos')->get();

        if(!Auth::check()){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para realizar esse agendamento.']);
        }
    
        $cliente = Auth::user();
        
        if(!$cliente){
            return redirect()->route('cliente.cadastro')
            ->withErrors(['Por favor realize um cadastro ou entre em uma conta para realizar esse agendamento.']);
        }
        
        $clienteId = ClienteModel::find($cliente->cliente_id);

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

        $cliente = Auth::user();

        $dataFormatada = Carbon::parse($validated['data'])->format('d/m/Y');

        NotificacaoModel::create([
            'cliente_id' => $cliente->cliente_id,
            'titulo' => 'Agendamento Confirmado! 🎉',
            'conteudo' => "Seu agendamento foi marcado com sucesso. Por favor, compareça ao salão no dia ". $dataFormatada . " às " . $validated['hora'] . " Agradecemos a preferência!",
            'data_recebida' => now(),
            'visualizada' => false
        ]);

        return redirect()->back()->with('success', 'Agendamento concluído com sucesso!');
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