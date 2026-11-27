@extends('layouts.app')

@section('content')

@php
    $valorColorivel = (int) old(
        'is_colorivel',
        $tipo->is_colorivel ?? 0
    );
@endphp

<div class="admin-tipos">

    <h1>Editar Tipo</h1>

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

    @if ($errors->any())
        <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                required
            >
                <option value="0" {{ $valorColorivel === 0 ? 'selected' : '' }}>
                    Não
                </option>
                <option value="1" {{ $valorColorivel === 1 ? 'selected' : '' }}>
                    Sim
                </option>
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