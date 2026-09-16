<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClienteModel;
use App\Models\NotificacaoModel;
use Carbon\Carbon;

class NotificarAniversarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacoes:aniversario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia notificação de desconto para clientes que fazem aniversário hoje.';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $hoje = Carbon::today();

        $clientes = ClienteModel::whereMonth('data_nascimento', $hoje->month)
            ->whereDay('data_nascimento', $hoje->day)
            ->where('is_admin', false)
            ->get();

        foreach ($clientes as $cliente) {
            NotificacaoModel::create([
                'cliente_id' => $cliente->cliente_id,
                'titulo' => 'Feliz Aniversário! 🎂',
                'conteudo' => "Olá, {$cliente->nome}! Para celebrar seu dia, liberamos um cupom especial de X% de desconto para sua próxima compra. Aproveite o seu dia!",
                'data_recebida' => now(),
                'visualizada' => false
            ]);
        }

        $this->info(count($clientes) . ' notificações de aniversário foram geradas.');
    }
}
