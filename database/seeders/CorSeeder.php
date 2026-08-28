<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cor;

class CorSeeder extends Seeder
{
    
    public function run(): void
    {

        Cor::create(['nome' => 'Vermelho', 'disponivel' => true]);
        Cor::create(['nome' => 'Vinho', 'disponivel' => true]);
        Cor::create(['nome' => 'Nude', 'disponivel' => true]);
        Cor::create(['nome' => 'Branco (Renda)', 'disponivel' => true]);
        Cor::create(['nome' => 'Branco Puríssimo', 'disponivel' => true]);
        Cor::create(['nome' => 'Preto', 'disponivel' => true]);
        Cor::create(['nome' => 'Rosa Pastel', 'disponivel' => true]);
        Cor::create(['nome' => 'Pink', 'disponivel' => true]);
        Cor::create(['nome' => 'Lilás', 'disponivel' => true]);
        Cor::create(['nome' => 'Azul Marinho', 'disponivel' => true]);
        Cor::create(['nome' => 'Verde Esmeralda', 'disponivel' => true]);
        Cor::create(['nome' => 'Dourado Metálico', 'disponivel' => false]);
        Cor::create(['nome' => 'Prata Metálico', 'disponivel' => false]);
        Cor::create(['nome' => 'Amarelo Neon', 'disponivel' => false]);

    }
}
