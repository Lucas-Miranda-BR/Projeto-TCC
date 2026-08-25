<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    
    public function run(): void
    {

        Tipo::create(['nome' => 'Manicure', 'colorivel' => true]);
        Tipo::create(['nome' => 'Pedicure', 'colorivel' => true]);
        Tipo::create(['nome' => 'Corte', 'colorivel' => true]);
        Tipo::create(['nome' => 'Maquiagem', 'colorivel' => true]);
        Tipo::create(['nome' => 'Depilação']);

    }
}
