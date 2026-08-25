<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorCabelo;

class CorCabeloSeeder extends Seeder
{
    
    public function run(): void
    {

        CorCabelo::create(['nome' => 'Preto', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Castanho Escuro', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Castanho Médio', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Castanho Claro', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Loiro Escuro', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Loiro Claro', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Loiro Platinado', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Ruivo', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Acaju', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Marsala', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Grisalho', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Branco', 'disponivel' => true]);
        CorCabelo::create(['nome' => 'Rosa Fantasia', 'disponivel' => false]);
        CorCabelo::create(['nome' => 'Azul Fantasia', 'disponivel' => false]);

    }
}
