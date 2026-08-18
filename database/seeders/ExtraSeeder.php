<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Extra;

class ExtraSeeder extends Seeder
{
    
    public function run(): void
    {

        Extra::create(['nome' => '', 'disponivel' => false]);
        
    }
}
