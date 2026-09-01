<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoModel;

class TipoSeeder extends Seeder
{
    
    public function run(): void
    {

        TipoModel::create(['nome' => 'Manicure', 'colorivel' => true]);
        TipoModel::create(['nome' => 'Pedicure', 'colorivel' => true]);
        TipoModel::create(['nome' => 'Corte', 'colorivel' => true]);
        TipoModel::create(['nome' => 'Maquiagem', 'colorivel' => true]);
        TipoModel::create(['nome' => 'Depilação']);

    }
}
