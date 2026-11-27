<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendamentoModel;
use App\Models\ProcedimentoModel;
use App\Models\NotificacaoModel;
use App\Models\TemplateNotificacaoModel;
use App\Models\NetworthModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function processarFaltasComDelay($clienteId = null)
    {
        $limiteAtraso = Carbon::today()->subDay()->toDateString();

        $queryJaAtrasados = AgendamentoModel::where('status', 2)
            ->whereDate('data', '<', $limiteAtraso);

        if ($clienteId) {
            $queryJaAtrasados->where('cliente_id', $clienteId);
        }

        $queryJaAtrasados->update(['status' => 3]);

        $queryNovosAtrasos = AgendamentoModel::where('status', 0)
            ->whereDate('data', '<=', $limiteAtraso);

        if ($clienteId) {
            $queryNovosAtrasos->where('cliente_id', $clienteId);
        }

        $agendamentosAtrasados = $queryNovosAtrasos->get();

        foreach ($agendamentosAtrasados as $agendamento) {
            $agendamento->status = 2;
            $agendamento->save();

            if ($agendamento->cliente_id) {
                $procedimento = ProcedimentoModel::find($agendamento->procedimento_id);
                $nomeProcedimento = $procedimento ? $procedimento->nome : 'nosso serviço';
                $dataFormatada = Carbon::parse($agendamento->data)->format('d/m/Y');

                $template = TemplateNotificacaoModel::where('tipo', 'agendamento_atrassado')->first();

                if ($template) {
                    $textoFinal = str_replace(
                        ['{procedimento}', '{data}', '{hora}'],
                        [$nomeProcedimento, $dataFormatada, $agendamento->hora],
                        $template->conteudo
                    );

                    NotificacaoModel::create([
                        'cliente_id' => $agendamento->cliente_id,
                        'titulo' => $template->titulo,
                        'conteudo' => $textoFinal,
                        'data_recebida' => Carbon::now(),
                        'visualizada' => false
                    ]);
                }
            }
        }
    }

    public function createAgendamento(Request $request)
    {
        $cliente = Auth::user();
        
        if (!$cliente) {
            return redirect()
                ->route('cliente.login')
                ->with('erro', 'Faça login ou cadastro para agendar o seu horário.');
        }

        $this->processarFaltasComDelay($cliente->cliente_id);

        $temTaxaFalta = AgendamentoModel::where('cliente_id', $cliente->cliente_id)
            ->where('status', 2)
            ->exists();

        $procedimentos = ProcedimentoModel::all();

        if ($temTaxaFalta) {
            $procedimentos->transform(function ($proc) {
                foreach (['preco', 'valor', 'preco_final'] as $campo) {
                    if (isset($proc->$campo) && $proc->$campo !== null) {
                        $val = is_string($proc->$campo) ? str_replace(',', '.', $proc->$campo) : $proc->$campo;
                        if (is_numeric($val) && (float) $val > 0) {
                            $proc->$campo = round((float) $val * 1.10, 2);
                        }
                    }
                }
                return $proc;
            });
        }
        
        $procedimentoSelecionado = $request->query('procedimento_id');
        $imagemGeradaId = $request->query('imagem_id');
        
        return view('agendamento.agendar', compact(
            'procedimentos',
            'cliente',
            'procedimentoSelecionado',
            'imagemGeradaId',
            'temTaxaFalta'
        ));
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

        $this->processarFaltasComDelay($cliente_id);

        $temTaxaFalta = AgendamentoModel::where('cliente_id', $cliente_id)
            ->where('status', 2)
            ->exists();

        if ($temTaxaFalta) {
            AgendamentoModel::where('cliente_id', $cliente_id)
                ->where('status', 2)
                ->update(['status' => 3]);
        }

        $agendamento = AgendamentoModel::create([
            'cliente_id' => $cliente_id,
            'procedimento_id' => $request->procedimento_id,
            'data' => $request->data,
            'hora' => $request->hora,
            'status' => 0
        ]);

        if ($temTaxaFalta) {
            session()->push('agendamentos_taxa_falta', $agendamento->agendamento_id);
        }

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

                if ($temTaxaFalta) {
                    $textoFinal .= ' (Acréscimo de 10% aplicado por ausência anterior).';
                }

                NotificacaoModel::create([
                    'cliente_id' => $cliente_id,
                    'titulo' => $template->titulo,
                    'conteudo' => $textoFinal,
                    'data_recebida' => Carbon::now(),
                    'visualizada' => false
                ]);
            }
        }

        return redirect()->route('cliente.notificacoes')
                         ->with('success', 'Agendamento realizado com sucesso!');
    }

    public function concluirAgendamento($id)
    {
        $this->processarFaltasComDelay();

        $agendamento = AgendamentoModel::findOrFail($id);
        
        if ($agendamento->status != 1) {
            $idsComTaxa = session('agendamentos_taxa_falta', []);
            $aplicarTaxaFalta = in_array($agendamento->agendamento_id, $idsComTaxa);

            $agendamento->status = 1;
            $agendamento->save();

            if ($aplicarTaxaFalta) {
                $novosIds = array_values(array_diff($idsComTaxa, [$agendamento->agendamento_id]));
                session(['agendamentos_taxa_falta' => $novosIds]);
            }

            $this->registrarFaturamentoAgendamento($agendamento, $aplicarTaxaFalta);
        }

        return redirect()->back()->with('success', 'Agendamento concluído e faturamento atualizado com sucesso!');
    }

    private function registrarFaturamentoAgendamento($agendamento, $aplicarTaxaFalta = false)
    {
        $procedimento = ProcedimentoModel::find($agendamento->procedimento_id);

        if (!$procedimento) {
            return;
        }

        $precoBruto = $procedimento->desconto_ativo 
            ? $procedimento->preco_final 
            : ($procedimento->preco_final ?? $procedimento->preco ?? $procedimento->valor ?? 0);

        if (is_string($precoBruto)) {
            $precoBruto = str_replace(',', '.', $precoBruto);
        }

        $valorProcedimento = (float) $precoBruto;

        if ($valorProcedimento <= 0) {
            return;
        }

        if ($aplicarTaxaFalta) {
            $valorProcedimento = round($valorProcedimento * 1.10, 2);
        }

        $hoje = Carbon::today()->toDateString();
        $horaAtual = Carbon::now()->hour;

        $registro = NetworthModel::firstOrCreate(
            ['dia' => $hoje, 'hora' => $horaAtual],
            ['ganho' => 0, 'custo' => 0, 'networth' => 0]
        );

        $registro->ganho += $valorProcedimento;
        $registro->networth = $registro->ganho - $registro->custo;
        $registro->save();
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
                'data_recebida' => Carbon::now(),
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
                'data_recebida' => Carbon::now(),
                'visualizada' => false
            ]);
        }

        return redirect()->route('admin.agendamentos')->with('success', 'Agendamento remarcado e cliente notificado!');
    }
}