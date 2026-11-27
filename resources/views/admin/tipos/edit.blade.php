@if (session('error'))
        <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif
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

            <label for="is_colorivel">
                Permite coloração
            </label>

            <select
                name="is_colorivel"
                id="is_colorivel"
                value="{{ old('is_colorivel') }}"
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