<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cidade;

class CidadeSeeder extends Seeder
{
    
    public function run(): void
    {

        Cidade::create(['nome' => 'Tatuí']);
        
    }
}
