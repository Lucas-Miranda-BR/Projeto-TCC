@extends('layouts.app')

@section('content')

<div class="admin-tipos">

    <h1>Editar Tipo</h1>


    <form
        action="{{ route(
            'admin.tipos.update',
            $tipo->getKey()
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
                    $tipo->nome
                ) }}"
                required
            >

        </div>


        <div>

            <label for="colorivel">
                Permite coloração
            </label>

            <select
                name="colorivel"
                id="colorivel"
                value="{{ old('colorivel') }}"
                placeholder="Ex: Corte"
                required
            >
                <option value="0">Não</option>
                <option value="1">Sim</option>
            </select>

        </div>

        <button type="submit">
            Salvar Alterações
        </button>

    </form>


    <a href="{{ route('admin.tipos.index') }}">
        Voltar
    </a>

</div>

@endsection