<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AgendamentoModel;
use App\Models\NotificacaoModel;
use Carbon\Carbon;

class LembrarAgendamentos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacoes:lembrete-agendamento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia lembretes de agendamentos 7 dias e 1 dia antes da data marcada.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dias7 = Carbon::today()->addDays(7)->format('Y-m-d');
        $dias1 = Carbon::today()->addDay()->format('Y-m-d');

        // Lembrete - 7 dias

        $agendamentosEm7Dias = Agendamento::whereDate('data', $dias7)
            ->where(function($q) {
                $q->where('isConcluido', 0)->orWhereNull('isConcluido');
            })
            ->get();

        foreach($agendamentosEm7Dias as $agendamento){
            NotificacaoModel::create([
                'cliente_id' => $agendamento->cliente_id,
                'titulo' => 'Lembrete de Agendamento 🗓️',
                'conteudo' => "Seu agendamento está chegando! Faltam 7 dias para o seu atendimento no dia " . Carbon::parse($agendamento->data)->format('d/m/Y') . " às {$agendamento->hora}.",
                'data_recebida' => now(),
                'visualizada' => false
            ]);
        }

        // Lembrete - 1 dia

        $agendamentosEm1Dias = Agendamento::whereDate('data', $dias1)
        ->where(function($q) {
            $q->where('isConcluido', 0)->orWhereNull('isConcluido');
        })
        ->get();

        foreach($agendamentosEm1Dias as $agendamento){
            NotificacaoModel::create([
                'cliente_id' => $agendamento->cliente_id,
                'titulo' => 'Seu agendamento é amanhã! ⏰',
                'conteudo' => "Não se esqueça: você tem um horário marcado conosco amanhã, dia " . Carbon::parse($agendamento->data)->format('d/m/Y') . " às {$agendamento->hora}. Te esperamos!",
                'data_recebida' => now(),
                'visualizada' => false
            ]);
        }

        $this->info('Lembretes de agendamentos (7 dias e 1 dia) gerados com sucesso.');
    }
}
