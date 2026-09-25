<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClienteModel;
use App\Models\NotificacaoModel;
use App\Models\TemplateNotificacaoModel;
use App\Models\DescontoModel;
use Carbon\Carbon;

class NotificarAniversarios extends Command
{
    protected $signature = 'notificacoes:aniversario';
    protected $description = 'Envia notificações e cupons de aniversário para os clientes do dia';

    public function handle()
    {
        $hoje = Carbon::today();
        
        $mesAtual = $hoje->month;
        $diaAtual = $hoje->day;

        $aniversariantes = ClienteModel::whereMonth('data_nascimento', $mesAtual)
                                       ->whereDay('data_nascimento', $diaAtual)
                                       ->get();

        if ($aniversariantes->isEmpty()) {
            return;
        }

        $template = TemplateNotificacaoModel::where('tipo', 'promocao_aniversario')->first();

        if (!$template) {
            return;
        }

        $regraDesconto = DescontoModel::where('nome', 'like', '%Aniversário%')->first();
        
        $descontoFormatado = $regraDesconto ? number_format($regraDesconto->valor, 0) . '%' : '0%';

        foreach ($aniversariantes as $cliente) {
            
            $textoFinal = str_replace(
                ['{nome}', '{desconto}'], 
                [$cliente->nome, $descontoFormatado], 
                $template->conteudo
            );

            NotificacaoModel::create([
                'cliente_id' => $cliente->cliente_id ?? $cliente->id,
                'titulo' => $template->titulo,
                'conteudo' => $textoFinal,
                'data_recebida' => now(),
                'visualizada' => false
            ]);
        }
        
        $this->info("Notificações enviadas com sucesso para " . $aniversariantes->count() . " aniversariante(s).");
    }
}