@extends('layouts.app')

@section('content')

<div class="admin-procedimentos">

    <h1>Editar Serviço</h1>


    <form
        action="{{ route(
            'admin.procedimentos.update',
            $procedimento->getKey()
        ) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        <div>

            <label for="nome">
                Nome
            </label>

            <input
                type="text"
                name="nome"
                id="nome"
                value="{{ old(
                    'nome',
                    $procedimento->nome
                ) }}"
                required
            >

        </div>


        <div>

            <label for="descricao">
                Descrição
            </label>

            <textarea
                name="descricao"
                id="descricao"
                required
            >{{ old(
                'descricao',
                $procedimento->descricao
            ) }}</textarea>

        </div>


        <div>

            <label for="preco">
                Preço
            </label>

            <input
                type="number"
                name="preco"
                id="preco"
                step="0.01"
                min="0"
                value="{{ old(
                    'preco',
                    $procedimento->preco
                ) }}"
                required
            >

        </div>


        <button type="submit">
            Salvar Alterações
        </button>

    </form>


    <a href="{{ route('admin.procedimentos.index') }}">
        Voltar
    </a>

</div>

@endsection