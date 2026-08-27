<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProcedimentoController;

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
                'atendimentos' => 21,
                'estoque' => 12,
                'agendamentosConfirmar' => 5,
                'produtosVendidos' => 37,

                'porcentagemFaturamento' => 8.4,
                'porcentagemLucro' => 6.7,
                'porcentagemProdutos' => 4.9,

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
                ],

                'servicos' => [
                    [
                        'nome' => 'Coloração',
                        'quantidade' => 94
                    ],
                    [
                        'nome' => 'Corte feminino',
                        'quantidade' => 82
                    ],
                    [
                        'nome' => 'Mechas',
                        'quantidade' => 49
                    ],
                    [
                        'nome' => 'Manicure',
                        'quantidade' => 86
                    ],
                    [
                        'nome' => 'Maquiagem',
                        'quantidade' => 35
                    ]
                ]
            ];
        }

        if ($periodo === 'mes') {

            return [
                'faturamento' => 68320,
                'lucro' => 52140,
                'atendimentos' => 87,
                'estoque' => 12,
                'agendamentosConfirmar' => 8,
                'produtosVendidos' => 142,

                'porcentagemFaturamento' => 12.3,
                'porcentagemLucro' => 9.5,
                'porcentagemProdutos' => 7.2,

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
                ],

                'servicos' => [
                    [
                        'nome' => 'Coloração',
                        'quantidade' => 88
                    ],
                    [
                        'nome' => 'Corte feminino',
                        'quantidade' => 95
                    ],
                    [
                        'nome' => 'Mechas',
                        'quantidade' => 62
                    ],
                    [
                        'nome' => 'Manicure',
                        'quantidade' => 78
                    ],
                    [
                        'nome' => 'Maquiagem',
                        'quantidade' => 44
                    ]
                ]
            ];
        }

        return [
            'faturamento' => 3840,
            'lucro' => 2840,
            'atendimentos' => 3,
            'estoque' => 12,
            'agendamentosConfirmar' => 2,
            'produtosVendidos' => 7,

            'porcentagemFaturamento' => 4.9,
            'porcentagemLucro' => 3.8,
            'porcentagemProdutos' => 2.7,

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
            ],

            'servicos' => [
                [
                    'nome' => 'Coloração',
                    'quantidade' => 94
                ],
                [
                    'nome' => 'Corte feminino',
                    'quantidade' => 82
                ],
                [
                    'nome' => 'Mechas',
                    'quantidade' => 49
                ],
                [
                    'nome' => 'Manicure',
                    'quantidade' => 86
                ],
                [
                    'nome' => 'Maquiagem',
                    'quantidade' => 35
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
            'clientes' => Cliente::all()
        ]);
    }

    public function agendamentos()
    {
        return view('admin.agendamentos');
    }

    public function calendario()
    {
        return view('admin.calendario');
    }

    public function produtos()
    {
        return view('admin.produtos');
    }
}