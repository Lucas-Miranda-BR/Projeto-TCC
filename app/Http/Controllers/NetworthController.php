<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NetworthModel;
use Carbon\Carbon;

class NetworthController extends Controller
{
    public function gerenciar()
    {
        $hoje = Carbon::today()->toDateString();
        
        $registrosHoje = NetworthModel::where('dia',$hoje)->get();

        $registroHoje = (object) [
            'ganho' => $registrosHoje->sum('ganho'),
            'custo' => $registrosHoje->sum('custo'),
            'networth' => $registrosHoje->sum('networth')
        ];

        return view('admin.networth.gerenciar', compact('registroHoje', 'hoje'));
    }

    public function adicionarGanho(Request $request)
    {
        $request->validate(['valor_ganho' => 'required|numeric|min:0.01']);

        $agora = Carbon::now('America/Sao_Paulo');
        $hoje =$agora->toDateString();
        $horaAtual =$agora->hour;

        $registro = NetworthModel::firstOrCreate(
            ['dia' => $hoje, 'hora' =>$horaAtual],
            ['ganho' => 0, 'custo' => 0, 'networth' => 0]
        );

        $registro->ganho +=$request->valor_ganho;
        $registro->networth = $registro->ganho -$registro->custo;
        $registro->save();

        return redirect()->back()->with('success', 'Ganho registrado na hora atual com sucesso!');
    }

    public function adicionarCusto(Request $request)
    {
        $request->validate(['valor_custo' => 'required|numeric|min:0.01']);

        $agora = Carbon::now('America/Sao_Paulo');
        $hoje =$agora->toDateString();
        $horaAtual =$agora->hour;

        $registro = NetworthModel::firstOrCreate(
            ['dia' => $hoje, 'hora' =>$horaAtual],
            ['ganho' => 0, 'custo' => 0, 'networth' => 0]
        );

        $registro->custo +=$request->valor_custo;
        $registro->networth = $registro->ganho -$registro->custo;
        $registro->save();

        return redirect()->back()->with('success', 'Custo registrado na hora atual com sucesso!');
    }
}