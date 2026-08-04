<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorUnha;

class CorUnhaSeeder extends Seeder
{
    
    public function run(): void
    {

        CorUnha::create(['nome' => '', 'disponivel' => false]);

    }
}
