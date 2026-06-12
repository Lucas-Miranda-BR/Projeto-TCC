@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/agendamento.css') }}">
@endpush

@section('content')

@include('components.navbar')

<div class="agendamento-container">

    <h1>Agende seu horário</h1>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('cliente.salvar') }}" method="POST">

        @csrf

        <div class="topo">

            <div class="servico">

                <img src="{{ asset('public/css/images/trabalho.png') }}" alt="Corte">

                <div>

                    <h3>Corte Feminino</h3>

                    <p>R$ 150,00</p>

                </div>

            </div>

            <div class="resumo">

                <h3>Resumo do Agendamento</h3>

                <p><strong>Serviço:</strong> Corte Feminino</p>
                <p><strong>Valor:</strong> R$150,00</p>

                <input type="hidden" name="servico" value="Corte Feminino">
                <input type="hidden" name="valor" value="150">

            </div>

        </div>

        <div class="dados-cliente">

            <h2>Dados do Cliente</h2>

            <input
                type="text"
                name="nome"
                placeholder="Digite seu nome"
                required
            >

        </div>

        <div class="agenda">

            <div class="calendario">

                <h3>Escolha a Data</h3>

                <input
                    type="date"
                    name="data"
                    required
                >

            </div>

            <div class="horarios">

                <h3>Escolha o Horário</h3>

                <div class="botoes-horario">

                    <label>
                        <input type="radio" name="hora" value="09:00" required>
                        <span>09:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" value="10:00">
                        <span>10:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" value="11:00">
                        <span>11:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" value="14:00">
                        <span>14:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" value="15:00">
                        <span>15:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" value="16:00">
                        <span>16:00</span>
                    </label>

                </div>

            </div>

        </div>

        <button type="submit" class="confirmar">
            Confirmar Agendamento
        </button>

    </form>

    @isset($agendamentos)

    <div class="lista-agendamentos">

        <h2>Agendamentos Realizados</h2>

        <table>

            <thead>

                <tr>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Hora</th>
                </tr>

            </thead>

            <tbody>

                @foreach($agendamentos as $agendamento)

                <tr>

                    <td>{{ $agendamento->nome }}</td>

                    <td>{{ $agendamento->servico }}</td>

                    <td>{{ date('d/m/Y', strtotime($agendamento->data)) }}</td>

                    <td>{{ $agendamento->hora }}</td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    @endisset

</div>

@include('components.footer')

@endsection