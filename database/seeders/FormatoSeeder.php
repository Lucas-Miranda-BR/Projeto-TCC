<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Formato;


class FormatoSeeder extends Seeder
{

    public function run(): void
    {

        Formato::create(['nome' => '']);
        
    }
}
