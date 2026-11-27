@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/admin/agendamento.css') }}">
@endpush

@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="agendamentos-content">

            <div class="agendamentos-header">
                <span class="breadcrumb-admin">
                    Painel >
                    <strong>Agendamentos</strong>
                </span>

                <h1>Agendamentos</h1>

                <p>Gerencie os horários e atendimentos dos clientes.</p>
            </div>

            @if(session('success'))
                <div class="produto-alert produto-alert-success" style="margin-bottom: 20px;">
                    <i class="bi bi-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="agendamentos-acoes">
                <a href="{{ route('admin.procedimentos.index') }}" class="btn-procedimentos">
                    Gerenciar Procedimentos
                </a>
            </div>

            <section class="lista-agendamentos">

                <h2>Agendamentos</h2>

                @isset($agendamentos)

                    @if($agendamentos->count() > 0)

                        <table>
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Procedimento</th>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($agendamentos as $agendamento)
                                    <tr>
                                        <td>{{ $agendamento->clientes->nome ?? 'Cliente' }}</td>
                                        
                                        <td>{{ $agendamento->procedimentos->nome ?? 'Serviço' }}</td>
                                        
                                        <td>{{ date('d/m/Y', strtotime($agendamento->data)) }}</td>
                                        
                                        <td>{{ $agendamento->hora }}</td>
                                        
                                        <td>
                                            @if ($agendamento->status == 1)
                                                <span class="status-concluido">Concluído</span>
                                            @elseif ($agendamento->status == 2)
                                                <span class="status-falta">Atrasado</span>
                                            @elseif ($agendamento->status == 3)
                                                <span class="status-cancelado">Cancelado (Atraso)</span>
                                            @else
                                                <span class="status-pendente">Não Concluído</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($agendamento->status == 0 || $agendamento->status == 2)
                                                <div class="acoes-agendamento">
                                                    
                                                    <form action="{{ route('admin.agendamentos.concluir', $agendamento->agendamento_id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn-concluir-agendamento" title="Concluir Agendamento">
                                                            <i class="bi bi-check-lg"></i> Concluir
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('admin.agendamentos.edit', $agendamento->agendamento_id) }}" class="btn-editar-agendamento" title="Reagendar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>

                                                    <form action="{{ route('admin.agendamentos.cancelar', $agendamento->agendamento_id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn-cancelar-agendamento" title="Cancelar Agendamento" onclick="return confirm('Deseja realmente cancelar este agendamento? O cliente será notificado.')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            @elseif ($agendamento->status == 1)
                                                <button disabled class="btn-agendamento-finalizado">
                                                    Finalizado
                                                </button>
                                            @else
                                                <button disabled class="btn-agendamento-finalizado">
                                                    Cancelado (Atraso)
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @else
                        <p>Nenhum agendamento encontrado.</p>
                    @endif

                @else
                    <p>Nenhum agendamento encontrado.</p>
                @endisset

            </section>

        </main>

    </div>

</div>

@endsection