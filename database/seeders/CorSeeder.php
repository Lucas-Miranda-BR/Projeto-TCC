<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorModel;

class CorSeeder extends Seeder
{
    
    public function run(): void
    {

        CorModel::create(['nome' => 'Vermelho', 25, 'disponivel' => true]);
        CorModel::create(['nome' => 'Vinho', 31, 'disponivel' => true]);
        CorModel::create(['nome' => 'Nude', 11, 'disponivel' => true]);
        CorModel::create(['nome' => 'Branco (Renda)', 9, 'disponivel' => true]);
        CorModel::create(['nome' => 'Branco Puríssimo', 7, 'disponivel' => true]);
        CorModel::create(['nome' => 'Preto', 3, 'disponivel' => true]);
        CorModel::create(['nome' => 'Rosa Pastel', 75, 'disponivel' => true]);
        CorModel::create(['nome' => 'Pink', 2, 'disponivel' => true]);
        CorModel::create(['nome' => 'Lilás', 1, 'disponivel' => false]);
        CorModel::create(['nome' => 'Azul Marinho', 0, 'disponivel' => false]);
        CorModel::create(['nome' => 'Verde Esmeralda', 1, 'disponivel' => false]);
        CorModel::create(['nome' => 'Dourado Metálico', 2, 'disponivel' => true]);
        CorModel::create(['nome' => 'Prata Metálico', 0, 'disponivel' => false]);
        CorModel::create(['nome' => 'Amarelo Neon', 1, 'disponivel' => false]);

    }
}
