<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    
    public function run(): void
    {

        Tipo::create(['nome' => 'Manicure']);
        Tipo::create(['nome' => 'Pedicure']);
        Tipo::create(['nome' => 'Corte']);
        Tipo::create(['nome' => 'Maquiagem']);
        Tipo::create(['nome' => 'Depilação']);

    }
}
