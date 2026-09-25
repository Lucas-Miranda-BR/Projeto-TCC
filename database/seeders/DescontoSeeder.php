<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DescontoModel;

class DescontoSeeder extends Seeder
{
    public function run(): void
    {
        DescontoModel::create([
            'nome' => 'Desconto de Aniversário',
            'valor' => 10.00,
            'quando_terminar' => null
        ]);
    }
}