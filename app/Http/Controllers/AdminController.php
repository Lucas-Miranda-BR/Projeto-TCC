<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\AgendamentoModel;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

class AdminController extends Controller
{
    public function dashboard()
    {
        $dashboard = $this->montarDashboard('hoje');

        return view('admin.dashboard', compact('dashboard'));
    }

    public function dadosDashboard(Request $request)
    {
        $periodo = $request->get('periodo', 'hoje');

        $periodosPermitidos = [
            'hoje',
            'semana',
            'mes'
        ];

        if (!in_array($periodo, $periodosPermitidos)) {
            $periodo = 'hoje';
        }

        $dashboard = $this->montarDashboard($periodo);

        return response()->json($dashboard);
    }

    private function montarDashboard($periodo)
    {
        if ($periodo === 'semana') {

            return [
                'faturamento' => 18450,
                'lucro' => 14200,

                'porcentagemFaturamento' => 8.4,
                'porcentagemLucro' => 6.7,

                'grafico' => [
                    'labels' => [
                        'Seg',
                        'Ter',
                        'Qua',
                        'Qui',
                        'Sex',
                        'Sáb',
                        'Dom'
                    ],

                    'valores' => [
                        1400,
                        2200,
                        1900,
                        3400,
                        2800,
                        4200,
                        2550
                    ]
                ]
            ];
        }

        if ($periodo === 'mes') {

            return [
                'faturamento' => 68320,
                'lucro' => 52140,

                'porcentagemFaturamento' => 12.3,
                'porcentagemLucro' => 9.5,

                'grafico' => [
                    'labels' => [
                        'Semana 1',
                        'Semana 2',
                        'Semana 3',
                        'Semana 4'
                    ],

                    'valores' => [
                        14200,
                        16800,
                        18100,
                        19220
                    ]
                ]
            ];
        }

        return [
            'faturamento' => 3840,
            'lucro' => 2840,

            'porcentagemFaturamento' => 4.9,
            'porcentagemLucro' => 3.8,

            'grafico' => [
                'labels' => [
                    '08h',
                    '10h',
                    '12h',
                    '14h',
                    '16h',
                    '18h'
                ],

                'valores' => [
                    320,
                    550,
                    820,
                    1350,
                    2480,
                    3840
                ]
            ]
        ];
    }

    public function clientes()
    {
        return view('admin.clientes');
    }

    public function indexCliente()
    {
        return view('cliente.read', [
            'clientes' => ClienteModel::all()
        ]);
    }

    public function agendamentos()
    {
        $agendamentos = AgendamentoModel::with(['clientes', 'procedimentos', 'imagens_geradas'])
        ->orderBy('isConcluido', 'asc')
        ->orderBy('data', 'asc')
        ->orderBy('hora', 'asc')
        ->get();
        return view('admin.agendamentos.index', ['agendamentos'=>$agendamentos]);
    }

    public function calendario()
    {
        return view('admin.calendario');
    }

    public function produtos()
    {
        return view('admin.produtos');
    }

    public function procedimentos()
    {
        return view('admin.procedimentos.index');
    }
}