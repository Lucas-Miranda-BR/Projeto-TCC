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

                    Gerenciar Serviços

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
                                        Serviço
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

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($agendamentos as $agendamento)

                                    <tr>

                                        <td>

                                            {{ $agendamento->cliente_id }}

                                        </td>

                                        <td>

                                            {{ $agendamento->procedimento_id }}

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

                                        <td>

                                            {{ $agendamento->status ?? 'Pendente' }}

                                        </td>

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
