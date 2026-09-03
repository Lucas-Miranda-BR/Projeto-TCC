@extends('layouts.app')

@push('css')
<link
    rel="stylesheet"
    href="{{ asset('css/agendamento.css') }}"
>
@endpush


@section('content')

@include('components.navbar')


<div class="agendamento-container">

    <h1>
        Agende seu horário
    </h1>


    @if(session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert-errors">

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('agendamento.create') }}"
        method="POST"
    >

        @csrf


        <input
            type="hidden"
            name="imagem_gerada_id"
            value="{{ $imagemGeradaId ?? '' }}"
        >


        <div class="topo">


            <div class="servico">

                <label for="procedimento_id">
                    Selecione o Serviço
                </label>


                <select
                    name="procedimento_id"
                    id="procedimento_id"
                    required
                >

                    <option value="">
                        Escolha um serviço...
                    </option>


                    @foreach($procedimentos as $procedimento)

                        <option
                            value="{{ $procedimento->procedimento_id }}"

                            data-nome="{{ $procedimento->nome }}"

                            data-descricao="{{ $procedimento->descricao }}"

                            data-preco="{{ $procedimento->preco }}"

                            data-tipo="{{ $procedimento->tipo->nome ?? 'Sem categoria' }}"

                            data-imagem="{{ $procedimento->imagem ? asset('storage/' . $procedimento->imagem) : '' }}"

                            {{
                                old(
                                    'procedimento_id',
                                    $procedimentoSelecionado ?? ''
                                ) == $procedimento->procedimento_id
                                    ? 'selected'
                                    : ''
                            }}
                        >

                            {{ $procedimento->nome }}

                            @if($procedimento->tipo)

                                - {{ $procedimento->tipo->nome }}

                            @endif

                        </option>

                    @endforeach

                </select>


                <p id="exibe-tipo">

                    <strong>
                        Categoria:
                    </strong>

                    <span>
                        Selecione um serviço
                    </span>

                </p>


                <div
                    id="servico-imagem-container"
                    style="display: none;"
                >

                    <img
                        id="servico-imagem"
                        src=""
                        alt="Imagem do serviço"
                    >

                </div>

            </div>



            <div class="resumo">

                <h3>
                    Resumo do Agendamento
                </h3>


                <p id="resumo-nome">

                    <strong>
                        Serviço:
                    </strong>

                    <span>
                        Selecione um serviço
                    </span>

                </p>


                <p id="resumo-descricao">

                    <strong>
                        Descrição:
                    </strong>

                    <span>
                        -
                    </span>

                </p>


                <p id="resumo-data">

                    <strong>
                        Data:
                    </strong>

                    <span>
                        -
                    </span>

                </p>


                <p id="resumo-hora">

                    <strong>
                        Horário:
                    </strong>

                    <span>
                        -
                    </span>

                </p>


                <p id="resumo-preco">

                    <strong>
                        Valor:
                    </strong>

                    <span>
                        R$ 0,00
                    </span>

                </p>

            </div>

        </div>



        <div class="agenda">


            <div class="calendario">

                <h3>
                    Escolha a Data
                </h3>


                <input
                    type="date"
                    name="data"
                    id="data"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('data') }}"
                    required
                >

            </div>



            <div class="horarios">

                <h3>
                    Escolha o Horário
                </h3>


                <div class="botoes-horario">


                    <label>

                        <input
                            type="radio"
                            name="hora"
                            value="09:00"
                            {{ old('hora') == '09:00' ? 'checked' : '' }}
                            required
                        >

                        <span>
                            09:00
                        </span>

                    </label>


                    <label>

                        <input
                            type="radio"
                            name="hora"
                            value="10:00"
                            {{ old('hora') == '10:00' ? 'checked' : '' }}
                        >

                        <span>
                            10:00
                        </span>

                    </label>


                    <label>

                        <input
                            type="radio"
                            name="hora"
                            value="11:00"
                            {{ old('hora') == '11:00' ? 'checked' : '' }}
                        >

                        <span>
                            11:00
                        </span>

                    </label>


                    <label>

                        <input
                            type="radio"
                            name="hora"
                            value="14:00"
                            {{ old('hora') == '14:00' ? 'checked' : '' }}
                        >

                        <span>
                            14:00
                        </span>

                    </label>


                    <label>

                        <input
                            type="radio"
                            name="hora"
                            value="15:00"
                            {{ old('hora') == '15:00' ? 'checked' : '' }}
                        >

                        <span>
                            15:00
                        </span>

                    </label>


                    <label>

                        <input
                            type="radio"
                            name="hora"
                            value="16:00"
                            {{ old('hora') == '16:00' ? 'checked' : '' }}
                        >

                        <span>
                            16:00
                        </span>

                    </label>


                </div>

            </div>

        </div>



        <button
            type="submit"
            class="confirmar"
        >

            Confirmar Agendamento

        </button>

    </form>



    @if(isset($agendamentos) && $agendamentos->count() > 0)


        <div class="lista-agendamentos">


            <h2>
                Meus Agendamentos
            </h2>


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

                    </tr>

                </thead>


                <tbody>


                    @foreach($agendamentos as $agendamento)


                        <tr>


                            <td>

                                {{ $cliente->nome }}

                                {{ $cliente->sobrenome ?? '' }}

                            </td>


                            <td>

                                {{
                                    $agendamento->procedimento->nome
                                    ?? 'Serviço não encontrado'
                                }}

                            </td>


                            <td>

                                @if($agendamento->data)

                                    {{ $agendamento->data->format('d/m/Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            <td>

                                {{ substr($agendamento->hora, 0, 5) }}

                            </td>


                        </tr>


                    @endforeach


                </tbody>


            </table>


        </div>


    @else


        <div class="lista-agendamentos">

            <h2>
                Meus Agendamentos
            </h2>

            <p>
                Você ainda não possui nenhum agendamento.
            </p>

        </div>


    @endif


</div>


@include('components.footer')


@endsection



@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const procedimentoSelect =
        document.getElementById('procedimento_id');

    const dataInput =
        document.getElementById('data');

    const horarios =
        document.querySelectorAll(
            'input[name="hora"]'
        );

    const resumoNome =
        document.querySelector(
            '#resumo-nome span'
        );

    const resumoDescricao =
        document.querySelector(
            '#resumo-descricao span'
        );

    const resumoPreco =
        document.querySelector(
            '#resumo-preco span'
        );

    const resumoData =
        document.querySelector(
            '#resumo-data span'
        );

    const resumoHora =
        document.querySelector(
            '#resumo-hora span'
        );

    const exibeTipo =
        document.querySelector(
            '#exibe-tipo span'
        );

    const imagemContainer =
        document.getElementById(
            'servico-imagem-container'
        );

    const imagemServico =
        document.getElementById(
            'servico-imagem'
        );


    function atualizarServico() {

        const option =
            procedimentoSelect.options[
                procedimentoSelect.selectedIndex
            ];


        if (
            !option ||
            !option.value
        ) {

            resumoNome.textContent =
                'Selecione um serviço';

            resumoDescricao.textContent =
                '-';

            resumoPreco.textContent =
                'R$ 0,00';

            exibeTipo.textContent =
                'Selecione um serviço';

            imagemContainer.style.display =
                'none';

            imagemServico.src = '';

            return;
        }


        const nome =
            option.dataset.nome || '';

        const descricao =
            option.dataset.descricao || '-';

        const preco =
            parseFloat(
                option.dataset.preco || 0
            );

        const tipo =
            option.dataset.tipo || 'Sem categoria';

        const imagem =
            option.dataset.imagem || '';


        resumoNome.textContent =
            nome;

        resumoDescricao.textContent =
            descricao;

        exibeTipo.textContent =
            tipo;


        resumoPreco.textContent =
            preco.toLocaleString(
                'pt-BR',
                {
                    style: 'currency',
                    currency: 'BRL'
                }
            );


        if (imagem) {

            imagemServico.src =
                imagem;

            imagemContainer.style.display =
                'block';

        } else {

            imagemServico.src =
                '';

            imagemContainer.style.display =
                'none';

        }

    }


    function atualizarData() {

        if (!dataInput.value) {

            resumoData.textContent =
                '-';

            return;

        }


        const partes =
            dataInput.value.split('-');


        resumoData.textContent =
            partes[2]
            + '/'
            + partes[1]
            + '/'
            + partes[0];

    }


    function atualizarHorario() {

        const selecionado =
            document.querySelector(
                'input[name="hora"]:checked'
            );


        if (!selecionado) {

            resumoHora.textContent =
                '-';

            return;

        }


        resumoHora.textContent =
            selecionado.value;

    }


    procedimentoSelect.addEventListener(
        'change',
        atualizarServico
    );


    dataInput.addEventListener(
        'change',
        atualizarData
    );


    horarios.forEach(function (horario) {

        horario.addEventListener(
            'change',
            atualizarHorario
        );

    });


    atualizarServico();

    atualizarData();

    atualizarHorario();

});

</script>

@endpush