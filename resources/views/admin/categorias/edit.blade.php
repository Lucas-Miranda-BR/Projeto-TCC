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

<div class="admin-categorias">

    <h1>Editar Categoria</h1>

    <form
        action="{{ route(
            'admin.categorias.update',
            $categoria->getKey()
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
                    $categoria->nome
                ) }}"
                required
            >

        </div>

        <button type="submit">
            Salvar Alterações
        </button>

    </form>


    <a href="{{ route('admin.produtos.index') }}">
        Voltar
    </a>

</div>

@endsection