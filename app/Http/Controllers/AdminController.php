<?php

namespace App\Http\Controllers;

use App\Models\Cliente;

class AdminController extends Controller
{
    public function dashboard()
    {
        $dashboard = [
            'faturamentoHoje' => 3840,
            'lucroHoje' => 3840,
            'atendimentosHoje' => 3,
            'estoque' => 12,
            'agendamentosConfirmar' => 2,
            'produtosSemana' => 37,
            'creditosIA' => 2140,
            'porcentagemIA' => 75,
        ];

        $agendamentos = [
            [
                'hora' => '9:00',
                'cliente' => 'Alexandre',
                'servico' => 'Corte',
                'status' => 'Confirmado',
                'valor' => 320,
            ],
            [
                'hora' => '9:00',
                'cliente' => 'Alexandre',
                'servico' => 'Corte',
                'status' => 'Realizado',
                'valor' => 320,
            ],
            [
                'hora' => '9:00',
                'cliente' => 'Alexandre',
                'servico' => 'Corte',
                'status' => 'Pendente',
                'valor' => 320,
            ],
        ];

        return view('admin.dashboard', compact(
            'dashboard',
            'agendamentos'
        ));
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