<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            

            TipoSeeder::class,
            CorUnhaSeeder::class,
            CorCabeloSeeder::class,
            ExtraSeeder::class,
            FormatoSeeder::class,
            CorteSeeder::class,
            ClienteDummySeeder::class

        ]);
    }
}
