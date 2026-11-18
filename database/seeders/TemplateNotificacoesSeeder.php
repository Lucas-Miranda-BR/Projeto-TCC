<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TemplateNotificacaoModel;

class TemplateNotificacoesSeeder extends Seeder
{
    public function run(): void
    {
        TemplateNotificacaoModel::create([
            'tipo' => 'agendamento_lembrete7dias',
            'titulo' => 'Lembrete de Agendamento 🗓️',
            'conteudo' => 'Seu agendamento está chegando! Faltam 7 dias para o seu atendimento no dia {data} às {hora}.'
        ]);

        TemplateNotificacaoModel::create([
            'tipo' => 'agendamento_lembrete1dia',
            'titulo' => 'Seu agendamento é amanhã! ⏰',
            'conteudo' => 'Não se esqueça: você tem um horário marcado conosco amanhã, dia {data} às {hora}. Te esperamos!'
        ]);
        
        TemplateNotificacaoModel::create([
            'tipo' => 'promocao_aniversario',
            'titulo' => 'Feliz Aniversário! 🎉',
            'conteudo' => 'Parabéns {nome}! Preparamos um desconto especial de {desconto} de aniversário para você.'
        ]);

        TemplateNotificacaoModel::create([
            'tipo' => 'agendamento_confirmado',
            'titulo' => 'Agendamento Confirmado! ✅',
            'conteudo' => 'Olá! Seu agendamento para o procedimento {procedimento} no dia {data} às {hora} foi confirmado com sucesso. Te esperamos!'
        ]);

        TemplateNotificacaoModel::create([
            'tipo' => 'agendamento_cancelado',
            'titulo' => 'Agendamento Cancelado ❌',
            'conteudo' => 'Olá. Informamos que o seu agendamento para {procedimento} no dia {data} às {hora} foi cancelado. Se precisar, você pode reagendar pelo sistema.'
        ]);

        TemplateNotificacaoModel::create([
            'tipo' => 'agendamento_reagendado',
            'titulo' => 'Horário Reagendado 📅',
            'conteudo' => 'Seu agendamento para {procedimento} foi alterado. O seu novo horário é dia {nova_data} às {nova_hora} (anteriormente era dia {data_antiga}).'
        ]);

        TemplateNotificacaoModel::create([
            'tipo' => 'agendamento_atrassado',
            'titulo' => 'Ausência no Agendamento ⏰',
            'conteudo' => 'Você não compareceu ao seu agendamento para {procedimento} no dia {data} às {hora}. Cancelamos esse horário; por favor, realize um novo agendamento. Será aplicada uma taxa de 10% no seu próximo serviço devido ao não comparecimento.'
        ]);

        TemplateNotificacaoModel::create([
            'tipo' => 'compra_confirmada',
            'titulo' => 'Compra Confirmada! 🛍️',
            'conteudo' => 'Olá! Sua compra referente ao pedido #{pedido} no valor de R$ {valor} foi confirmada com sucesso, vá até o local para retirar. Agradecemos a preferência!'
        ]);
    }
}