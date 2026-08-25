<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorUnha;

class CorUnhaSeeder extends Seeder
{
    
    public function run(): void
    {

        CorUnha::create(['nome' => 'Vermelho', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Vinho', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Nude', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Branco (Renda)', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Branco Puríssimo', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Preto', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Rosa Pastel', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Pink', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Lilás', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Azul Marinho', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Verde Esmeralda', 'disponivel' => true]);
        CorUnha::create(['nome' => 'Dourado Metálico', 'disponivel' => false]);
        CorUnha::create(['nome' => 'Prata Metálico', 'disponivel' => false]);
        CorUnha::create(['nome' => 'Amarelo Neon', 'disponivel' => false]);

    }
}
