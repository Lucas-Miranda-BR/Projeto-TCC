<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorModel;

class CorSeeder extends Seeder
{
    
    public function run(): void
    {

        CorModel::create(['nome' => 'Vermelho', 'estoque' => 25, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Vinho', 'estoque' => 31, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Nude', 'estoque' => 11, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Branco (Renda)', 'estoque' => 9, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Branco Puríssimo', 'estoque' => 7, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Preto', 'estoque' => 3, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Rosa Pastel', 'estoque' => 75, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Pink', 'estoque' => 2, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Lilás', 'estoque' => 1, 'is_disponivel' => false]);
        CorModel::create(['nome' => 'Azul Marinho', 'estoque' => 0, 'is_disponivel' => false]);
        CorModel::create(['nome' => 'Verde Esmeralda', 'estoque' => 1, 'is_disponivel' => false]);
        CorModel::create(['nome' => 'Dourado Metálico', 'estoque' => 2, 'is_disponivel' => true]);
        CorModel::create(['nome' => 'Prata Metálico', 'estoque' => 0, 'is_disponivel' => false]);
        CorModel::create(['nome' => 'Amarelo Neon', 'estoque' => 1, 'is_disponivel' => false]);

    }
}
