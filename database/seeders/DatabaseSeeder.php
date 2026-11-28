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
            
            ClienteDummySeeder::class,
            TemplateNotificacoesSeeder::class,
            DescontoSeeder::class,
            TipoSeeder::class,
            ProcedimentoSeeder::class

        ]);
    }
}