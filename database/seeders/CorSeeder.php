<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorModel;

class CorSeeder extends Seeder
{
    
    public function run(): void
    {

        CorModel::create(['nome' => 'Vermelho', 'estoque' => 25, 'disponivel' => true]);
        CorModel::create(['nome' => 'Vinho', 'estoque' => 31, 'disponivel' => true]);
        CorModel::create(['nome' => 'Nude', 'estoque' => 11, 'disponivel' => true]);
        CorModel::create(['nome' => 'Branco (Renda)', 'estoque' => 9, 'disponivel' => true]);
        CorModel::create(['nome' => 'Branco Puríssimo', 'estoque' => 7, 'disponivel' => true]);
        CorModel::create(['nome' => 'Preto', 'estoque' => 3, 'disponivel' => true]);
        CorModel::create(['nome' => 'Rosa Pastel', 'estoque' => 75, 'disponivel' => true]);
        CorModel::create(['nome' => 'Pink', 'estoque' => 2, 'disponivel' => true]);
        CorModel::create(['nome' => 'Lilás', 'estoque' => 1, 'disponivel' => false]);
        CorModel::create(['nome' => 'Azul Marinho', 'estoque' => 0, 'disponivel' => false]);
        CorModel::create(['nome' => 'Verde Esmeralda', 'estoque' => 1, 'disponivel' => false]);
        CorModel::create(['nome' => 'Dourado Metálico', 'estoque' => 2, 'disponivel' => true]);
        CorModel::create(['nome' => 'Prata Metálico', 'estoque' => 0, 'disponivel' => false]);
        CorModel::create(['nome' => 'Amarelo Neon', 'estoque' => 1, 'disponivel' => false]);

    }
}
