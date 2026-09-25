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
            CorSeeder::class,
            TipoSeeder::class,
            ProcedimentoSeeder::class,
            NetworthDiaSeeder::class,
            NetworthHojeSeeder::class,
            TemplateNotificacoesSeeder::class,
            DescontoSeeder::class

        ]);
    }
}
