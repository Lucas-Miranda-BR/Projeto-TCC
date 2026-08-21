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

    <form action="{{ route('agendamento.create') }}" method="POST">

        <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $cliente->cliente_id }}">


        @csrf

        <div class="topo">

            <div class="servico">
                <label for="servico_id">Selecione o Serviço</label>
                
                <select name="tipo_id" id="tipo_id" required>
                    <option value="" disabled {{ empty($tipo_selecionado) ? 'selected' : '' }}>
                        Escolha um serviço...
                    </option>
                                    
                    @foreach($tipos as $tipo)
                        <option 
                            value="{{ $tipo->tipo_id }}" 
                            {{ (isset($tipo_selecionado) && $tipo_selecionado == $tipo->tipo_id) ? 'selected' : '' }}
                            >
                            {{ $tipo->nome }}
                        </option>
                    @endforeach
                                    
                </select>
            </div>

            <div class="resumo">

                <h3>Resumo do Agendamento</h3>

                <p><strong>Serviço: Selecione um serviço</strong></p>
                <p><strong>Valor:</strong> R$0,00</p>

            </div>

        </div>

        <div class="agenda">

            <div class="calendario">

                <h3>Escolha a Data</h3>

                <input
                    type="date"
                    name="data"
                    id="data"
                    required
                >

            </div>

            <div class="horarios">

                <h3>Escolha o Horário</h3>

                <div class="botoes-horario">

                    <label>
                        <input type="radio" name="hora" id='hora' value="09:00" required>
                        <span>09:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="10:00">
                        <span>10:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="11:00">
                        <span>11:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="14:00">
                        <span>14:00</span>
                    </label>

                    <label>
                        <input type="radio" name="hora" id='hora' value="15:00">
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

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

                    <td>{{ $agendamento->cliente_id }}</td>

                    <td>{{ $agendamento->servico_id }}</td>

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