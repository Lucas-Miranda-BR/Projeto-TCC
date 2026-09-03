@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="/css/agendamento.css">
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

                <h1>
                    Agendamentos
                </h1>

                <p>
                    Gerencie os horários e atendimentos dos clientes.
                </p>

            </div>


            <div class="agendamentos-acoes">

                <a
                    href="{{ route('admin.procedimentos.index') }}"
                    class="btn-procedimentos"
                >

                    Gerenciar Procedimentos

                </a>

            </div>


            <section class="lista-agendamentos">

                <h2>
                    Agendamentos
                </h2>


                @isset($agendamentos)

                    @if($agendamentos->count() > 0)

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        Cliente
                                    </th>

                                    <th>
                                        Procedimento
                                    </th>

                                    <th>
                                        Data
                                    </th>

                                    <th>
                                        Hora
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Ações
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($agendamentos as $agendamento)

                                    <tr>

                                        <td>

                                            {{ $agendamento->clientes->nome}}

                                        </td>

                                        <td>

                                            {{ $agendamento->procedimentos->nome}}

                                        </td>

                                        <td>

                                            {{ date(
                                                'd/m/Y',
                                                strtotime($agendamento->data)
                                            ) }}

                                        </td>

                                        <td>

                                            {{ $agendamento->hora }}

                                        </td>
                                        @if ($agendamento->isConcluido == 1)
                                        <td>
                                            Concluido
                                        </td>

                                        @else
                                        <td>
                                            Pendente
                                        </td>
                                        @endif

                                        @if ($agendamento->isConcluido == 0)
                                            <td>
                                                <form action="{{ route('admin.agendamentos.concluir', $agendamento->agendamento_id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" >
                                                        ✓ Concluir
                                                    </button>
                                                </form>
                                            </td>

                                        @else
                                            <td>
                                                <button disabled>
                                                    Finalizado
                                                </button>
                                            </td>
                                        @endif
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        <p>
                            Nenhum agendamento encontrado.
                        </p>

                    @endif

                @else

                    <p>
                        Nenhum agendamento encontrado.
                    </p>

                @endisset

            </section>

        </main>

    </div>

</div>

@endsection
