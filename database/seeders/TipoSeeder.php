<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * Categorias (tabela `tipo`) exibidas no carrossel da página pública de serviços.
 * Só usa as colunas que já existem: nome e colorível. Não altera a estrutura do banco.
 * O conteúdo dos cards (descrição, foto, preço, chips) vem do ProcedimentoSeeder.
 * Pode rodar mais de uma vez: atualiza pelo nome, não duplica.
 */
class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Cabelo'          => true,   // permite coloração
            'Manicure'        => false,
            'Pedicure'        => false,
            'Massagem'        => false,
            'Limpeza de pele' => false,
            'Maquiagem'       => false,
            'Depilação'       => false,
        ];

        // a coluna aparece como `colorivel` no model e `is_colorivel` na migration
        $coluna = Schema::hasColumn('tipo', 'colorivel') ? 'colorivel' : 'is_colorivel';

        foreach ($tipos as $nome => $colorivel) {
            DB::table('tipo')->updateOrInsert(['nome' => $nome], [$coluna => $colorivel]);
        }
    }
}
