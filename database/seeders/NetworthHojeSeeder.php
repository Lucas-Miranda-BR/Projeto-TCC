<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NetworthModel;
use Carbon\Carbon;

class NetworthHojeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hoje = Carbon::today()->toDateString();

        for ($hora = 8; $hora <= 12; $hora++) {
            
            $ganho = rand(20, 150) + (rand(0, 99) / 100);
            $custo = rand(5, 50) + (rand(0, 99) / 100);
            
            $networth = $ganho - $custo;

            NetworthModel::create([
                'ganho' => round($ganho, 2),
                'custo' => round($custo, 2),
                'networth' => round($networth, 2),
                'dia' => $hoje,
                'hora' => $hora,
            ]);
        }
    }
}