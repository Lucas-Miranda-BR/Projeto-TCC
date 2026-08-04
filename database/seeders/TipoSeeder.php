<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    
    public function run(): void
    {

        Tipo::create([
            'nome' => 'Manicure',
            'nome' => 'Pedicure',
            'nome' => 'Limpeza de pele',
            'nome' => 'Spa dos pés',
            'nome' => 'Spa das mãos',
            'nome' => 'Sobrancelha'
        ]);
    }
}
