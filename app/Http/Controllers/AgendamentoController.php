<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendamentoModel;
use App\Models\ProcedimentoModel;
use App\Models\NotificacaoModel;
use App\Models\TemplateNotificacaoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function createAgendamento()
    {
        $procedimentos = ProcedimentoModel::all();
        
        $cliente = Auth::user();
        
        return view('agendamento.agendar', compact('procedimentos', 'cliente'));
    }

    public function storeAgendamento(Request $request)
    {
        $request->validate([
            'data' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'hora' => [
                'required'
            ],
            'procedimento_id' => [
                'required',
                'exists:procedimento,procedimento_id'
            ]
        ]);

        $cliente_id = Auth::id() ?? $request->cliente_id;

        $agendamento = AgendamentoModel::create([
            'cliente_id' => $cliente_id,
            'procedimento_id' => $request->procedimento_id,
            'data' => $request->data,
            'hora' => $request->hora,
            'isConcluido' => 0
        ]);

        $procedimento = ProcedimentoModel::find($request->procedimento_id);
        $nomeProcedimento = $procedimento ? $procedimento->nome : 'nosso serviço';

        if ($cliente_id) {
            $template = TemplateNotificacaoModel::where('tipo', 'agendamento_confirmado')->first();

            if ($template) {
                $dataFormatada = Carbon::parse($agendamento->data)->format('d/m/Y');
                
                $textoFinal = str_replace(
                    ['{procedimento}', '{data}', '{hora}'], 
                    [$nomeProcedimento, $dataFormatada, $agendamento->hora], 
                    $template->conteudo
                );

                NotificacaoModel::create([
                    'cliente_id' => $cliente_id,
                    'titulo' => $template->titulo,
                    'conteudo' => $textoFinal,
                    'data_recebida' => now(),
                    'visualizada' => false
                ]);
            }
        }

        return redirect()->route('cliente.notificacoes')
                         ->with('success', 'Agendamento realizado com sucesso!');
    }

    public function concluirAgendamento($id)
    {
        $agendamento = AgendamentoModel::findOrFail($id);
        
        $agendamento->isConcluido = 1;
        $agendamento->save();

        return redirect()->back()->with('success', 'Agendamento concluído com sucesso!');
    }

    public function cancelarAgendamento($id)
    {
        $agendamento = AgendamentoModel::findOrFail($id);
        $clienteId = $agendamento->cliente_id;
        
        $procedimento = ProcedimentoModel::find($agendamento->procedimento_id);
        $nomeProcedimento = $procedimento ? $procedimento->nome : 'nosso serviço';
        
        $template = TemplateNotificacaoModel::where('tipo', 'agendamento_cancelado')->first();

        if ($template && $clienteId) {
            $dataFormatada = Carbon::parse($agendamento->data)->format('d/m/Y');
            
            $textoFinal = str_replace(
                ['{procedimento}', '{data}', '{hora}'], 
                [$nomeProcedimento, $dataFormatada, $agendamento->hora], 
                $template->conteudo
            );

            NotificacaoModel::create([
                'cliente_id' => $clienteId,
                'titulo' => $template->titulo,
                'conteudo' => $textoFinal,
                'data_recebida' => now(),
                'visualizada' => false
            ]);
        }

        $agendamento->delete(); 

        return redirect()->back()->with('success', 'Agendamento cancelado e cliente notificado.');
    }

    public function editAgendamento($id)
    {
        $agendamento = AgendamentoModel::with(['clientes', 'procedimentos'])->findOrFail($id);
        
        return view('admin.agendamentos.edit', compact('agendamento'));
    }

    public function ajustarAgendamento(Request $request, $id)
    {
        $request->validate([
            'data' => 'required|date',
            'hora' => 'required'
        ]);

        $agendamento = AgendamentoModel::findOrFail($id);
        $clienteId = $agendamento->cliente_id;

        $dataAntigaFormatada = Carbon::parse($agendamento->data)->format('d/m/Y');
        
        $agendamento->data = $request->data;
        $agendamento->hora = $request->hora;
        $agendamento->save();

        $novaDataFormatada = Carbon::parse($agendamento->data)->format('d/m/Y');
        $novaHora = $agendamento->hora;

        $procedimento = ProcedimentoModel::find($agendamento->procedimento_id);
        $nomeProcedimento = $procedimento ? $procedimento->nome : 'nosso serviço';

        $template = TemplateNotificacaoModel::where('tipo', 'agendamento_reagendado')->first();

        if ($template && $clienteId) {
            
            $textoFinal = str_replace(
                ['{procedimento}', '{data_antiga}', '{nova_data}', '{nova_hora}'], 
                [$nomeProcedimento, $dataAntigaFormatada, $novaDataFormatada, $novaHora], 
                $template->conteudo
            );

            NotificacaoModel::create([
                'cliente_id' => $clienteId,
                'titulo' => $template->titulo,
                'conteudo' => $textoFinal,
                'data_recebida' => now(),
                'visualizada' => false
            ]);
        }

        return redirect()->route('admin.agendamentos')->with('success', 'Agendamento remarcado e cliente notificado!');
    }
}