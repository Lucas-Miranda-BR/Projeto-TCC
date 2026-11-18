<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\AgendamentoModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\NetworthModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewDashboard()
    {
        return view('admin.dashboard');
    }


    public function dadosDashboard(Request $request)
    {
        $periodo = $request->query('periodo', 'semana');

        $labels = [];
        $networths = [];
        $totalPeriodo = 0.0;

        $hojeStr = Carbon::today()->toDateString();

        // Dia

        if ($periodo === 'dia') {
            
            $horaAtual = Carbon::now()->hour;
            $registrosHora = NetworthModel::where('dia', $hojeStr)
                ->get()
                ->keyBy('hora');

                $totalPeriodo = (float) $registrosHora->sum('networth');

            for ($hora = 8; $hora <= 18; $hora++) {
                $labels[] = str_pad($hora, 2, '0', STR_PAD_LEFT) . 'h';
                
                if ($hora <= $horaAtual) {
                    if ($registrosHora->has($hora)) {
                        $networths[] = (float) $registrosHora[$hora]->networth;
                    } else {
                        $networths[] = 0;
                    }
                } else {
                    $networths[] = null;
                }
            }

        } else {
            
            // Mês

            $dias = ($periodo === 'mes') ? 30 : 7;
            $dataInicio = Carbon::today()->subDays($dias - 1);

            $registrosDiarios = NetworthModel::selectRaw('dia, SUM(networth) as total_dia')
                ->where('dia', '>=', $dataInicio->toDateString())
                ->where('dia', '<=', $hojeStr)
                ->groupBy('dia')
                ->get()
                ->keyBy('dia');

            for ($i = 0; $i < $dias; $i++) {
                $dataAtual = clone $dataInicio;
                $dataAtual->addDays($i);
                $dataStr = $dataAtual->toDateString();

                $labels[] = $dataAtual->format('d/m');

                if ($registrosDiarios->has($dataStr)) {
                    $valorDia = (float) $registrosDiarios[$dataStr]->total_dia;
                    $networths[] = $valorDia;
                    $totalPeriodo += $valorDia;
                } else {
                    $networths[] = 0;
                }
            }
        }

        return response()->json([
            'labels' => $labels,
            'networths' => $networths,
            'networth_total' => $totalPeriodo,
            'periodo_selecionado' => $periodo
        ]);
    }

    public function viewClientes()
    {
        $clientes = ClienteModel::orderBy(
            'nome'
        )
            ->orderBy(
                'sobrenome'
            )
            ->get();


        return view(
            'admin.clientes',
            compact(
                'clientes'
            )
        );
    }


    public function indexCliente()
    {
        return view(
            'cliente.read',
            [
                'clientes' =>
                    ClienteModel::all()
            ]
        );
    }


    public function viewAgendamentos()
    {
        $agendamentos =
            AgendamentoModel::with([
                'clientes',
                'procedimentos',
                'imagens_geradas'
            ])
                ->orderBy(
                    'status',
                    'asc'
                )
                ->orderBy(
                    'data',
                    'asc'
                )
                ->orderBy(
                    'hora',
                    'asc'
                )
                ->get();


        return view(
            'admin.agendamentos.index',
            [
                'agendamentos' =>
                    $agendamentos
            ]
        );
    }

    public function viewProdutos()
    {
        return view(
            'admin.produtos.index'
        );
    }

    public function viewProcedimentos()
    {
        return view(
            'admin.procedimentos.index'
        );
    }

}