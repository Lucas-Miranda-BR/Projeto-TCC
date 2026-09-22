<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NetworthModel;
use Carbon\Carbon;

class NetworthDiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataInicial = Carbon::today()->subDays(30);

        for ($i = 0; $i <= 30; $i++) {
            
            $diaAtual = $dataInicial->copy()->addDays($i);
            
            $ganho = rand(150, 800) + (rand(0, 99) / 100);
            $custo = rand(50, 300) + (rand(0, 99) / 100);
            
            $networth = $ganho - $custo;

            NetworthModel::create([
                'ganho' => round($ganho, 2),
                'custo' => round($custo, 2),
                'networth' => round($networth, 2),
                'dia' => $diaAtual->toDateString(),
                'hora' => 18,
            ]);
        }
    }
}