<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\AgendamentoModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function viewDashboard()
    {
        return view('admin.dashboard');
    }


    public function dadosDashboard()
    {
        $hoje = Carbon::today();


        $pedidosHoje = DB::table('pedido')
            ->whereDate('pedido_data', $hoje)
            ->get();


        $faturamentoProdutos =
            (float) $pedidosHoje->sum('valor_total');


        $servicosConcluidos = DB::table('agendamento as a')
            ->join(
                'procedimento as p',
                'p.procedimento_id',
                '=',
                'a.procedimento_id'
            )
            ->where(
                'a.isConcluido',
                1
            )
            ->select(
                'a.agendamento_id',
                'a.data',
                'a.hora',
                'a.procedimento_id',
                'p.nome',
                'p.preco'
            )
            ->get();


        $faturamentoServicos =
            (float) $servicosConcluidos->sum('preco');


        $faturamentoTotal =
            $faturamentoProdutos +
            $faturamentoServicos;


        $labels = [];

        $dadosProdutos = [];

        $dadosServicos = [];


        for ($hora = 8; $hora <= 18; $hora++) {

            $labels[] =
                str_pad(
                    $hora,
                    2,
                    '0',
                    STR_PAD_LEFT
                ) . 'h';


            $totalProdutosHora =
                $pedidosHoje
                    ->filter(
                        function ($pedido) use ($hora) {

                            if (
                                empty(
                                    $pedido->pedido_data
                                )
                            ) {
                                return false;
                            }


                            return Carbon::parse(
                                $pedido->pedido_data
                            )->hour === $hora;

                        }
                    )
                    ->sum(
                        'valor_total'
                    );


            $totalServicosHora =
                $servicosConcluidos
                    ->filter(
                        function ($agendamento) use ($hora) {

                            if (
                                empty(
                                    $agendamento->hora
                                )
                            ) {
                                return false;
                            }


                            return Carbon::parse(
                                $agendamento->hora
                            )->hour === $hora;

                        }
                    )
                    ->sum(
                        'preco'
                    );


            $dadosProdutos[] =
                (float) $totalProdutosHora;


            $dadosServicos[] =
                (float) $totalServicosHora;
        }


        return response()->json([

            'labels' =>
                $labels,

            'produtos' =>
                $dadosProdutos,

            'servicos' =>
                $dadosServicos,

            'faturamento_produtos' =>
                $faturamentoProdutos,

            'faturamento_servicos' =>
                $faturamentoServicos,

            'faturamento_total' =>
                $faturamentoTotal,

            'pedidos_realizados' =>
                $pedidosHoje->count(),

            'servicos_concluidos' =>
                $servicosConcluidos->count()

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
                    'isConcluido',
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


    public function viewCalendario()
    {
        return view(
            'admin.calendario'
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