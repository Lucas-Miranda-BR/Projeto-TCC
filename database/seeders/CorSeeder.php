<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorModel;

class CorSeeder extends Seeder
{
    
    public function run(): void
    {

        CorModel::create(['nome' => 'Vermelho', 'estoque' => 25]);
        CorModel::create(['nome' => 'Vinho', 'estoque' => 31]);
        CorModel::create(['nome' => 'Nude', 'estoque' => 11]);
        CorModel::create(['nome' => 'Branco (Renda)', 'estoque' => 9]);
        CorModel::create(['nome' => 'Branco Puríssimo', 'estoque' => 7]);
        CorModel::create(['nome' => 'Preto', 'estoque' => 3]);
        CorModel::create(['nome' => 'Rosa Pastel', 'estoque' => 75]);
        CorModel::create(['nome' => 'Pink', 'estoque' => 2]);
        CorModel::create(['nome' => 'Lilás', 'estoque' => 1]);
        CorModel::create(['nome' => 'Azul Marinho', 'estoque' => 0]);
        CorModel::create(['nome' => 'Verde Esmeralda', 'estoque' => 1]);
        CorModel::create(['nome' => 'Dourado Metálico', 'estoque' => 2]);
        CorModel::create(['nome' => 'Prata Metálico', 'estoque' => 0]);
        CorModel::create(['nome' => 'Amarelo Neon', 'estoque' => 1]);

    }
}
