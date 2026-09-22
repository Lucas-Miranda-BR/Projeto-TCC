<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AgendamentoModel;
use App\Models\NotificacaoModel;
use App\Models\TemplateNotificacaoModel;
use Carbon\Carbon;

class LembrarAgendamentos extends Command
{
    protected $signature = 'notificacoes:lembrar';
    protected $description = 'Envia lembretes de agendamento (7 dias e 1 dia antes)';

    public function handle()
    {
        $daquiSeteDias = Carbon::today()->addDays(7)->format('Y-m-d');
        $amanha = Carbon::today()->addDay()->format('Y-m-d');

        $template7Dias = TemplateNotificacaoModel::where('tipo', 'agendamento_lembrete7dias')->first();
        $template1Dia = TemplateNotificacaoModel::where('tipo', 'agendamento_lembrete1dia')->first();

        if ($template7Dias) {
            $agendamentos7Dias = AgendamentoModel::whereDate('data', $daquiSeteDias)
                ->where(function($query) {
                    $query->where('isConcluido', 0)->orWhereNull('isConcluido');
                })
                ->get();
                
            foreach ($agendamentos7Dias as $agendamento) {
                $dataFormatada = Carbon::parse($agendamento->data)->format('d/m/Y');
                
                $textoFinal = str_replace(
                    ['{data}', '{hora}'], 
                    [$dataFormatada, $agendamento->hora], 
                    $template7Dias->conteudo
                );

                NotificacaoModel::create([
                    'cliente_id' => $agendamento->cliente_id,
                    'titulo' => $template7Dias->titulo,
                    'conteudo' => $textoFinal,
                    'data_recebida' => now(),
                    'visualizada' => false
                ]);
            }
        }

        if ($template1Dia) {
            $agendamentosAmanha = AgendamentoModel::whereDate('data', $amanha)
                ->where(function($query) {
                    $query->where('isConcluido', 0)->orWhereNull('isConcluido');
                })
                ->get();
                
            foreach ($agendamentosAmanha as $agendamento) {
                $dataFormatada = Carbon::parse($agendamento->data)->format('d/m/Y');
                
                $textoFinal = str_replace(
                    ['{data}', '{hora}'], 
                    [$dataFormatada, $agendamento->hora], 
                    $template1Dia->conteudo
                );

                NotificacaoModel::create([
                    'cliente_id' => $agendamento->cliente_id,
                    'titulo' => $template1Dia->titulo,
                    'conteudo' => $textoFinal,
                    'data_recebida' => now(),
                    'visualizada' => false
                ]);
            }
        }
    }
}