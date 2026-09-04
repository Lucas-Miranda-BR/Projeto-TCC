@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/admin/dashboard.css') }}"
>

<link
    rel="stylesheet"
    href="{{ asset('css/admin/produtos.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="produtos-content">

            <div class="produtos-header">

                <span class="breadcrumb-admin">
                    Painel >
                    Produtos >
                    <strong>Editar</strong>
                </span>

                <h1>
                    Editar Produto
                </h1>

                <p>
                    Atualize as informações do produto.
                </p>

            </div>


            @if($errors->any())

                <div class="produto-alert produto-alert-error">

                    @foreach($errors->all() as $erro)

                        <p>
                            {{ $erro }}
                        </p>

                    @endforeach

                </div>

            @endif


            <section class="produto-edit-card">

                <div class="produto-edit-foto">

                    @if($produto->foto)

                        <img
                            src="{{ asset('storage/' . $produto->foto) }}"
                            alt="{{ $produto->nome }}"
                        >

                    @endif

                </div>


                <form
                    action="{{ route(
                        'admin.produtos.update',
                        $produto->item_id
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')


                    <div class="form-group">

                        <label>
                            Nome
                        </label>

                        <input
                            type="text"
                            name="nome"
                            value="{{ old(
                                'nome',
                                $produto->nome
                            ) }}"
                            required
                        >

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label>
                                Marca
                            </label>

                            <select name="marca_id">

                                <option value="">
                                    Sem marca
                                </option>

                                @foreach($marcas as $marca)

                                    <option
                                        value="{{ $marca->marca_id }}"
                                        {{
                                            old(
                                                'marca_id',
                                                $produto->marca_id
                                            ) == $marca->marca_id
                                                ? 'selected'
                                                : ''
                                        }}
                                    >
                                        {{ $marca->nome }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">

                            <label>
                                Categoria
                            </label>

                            <select name="categoria_id">

                                <option value="">
                                    Sem categoria
                                </option>

                                @foreach($categorias as $categoria)

                                    <option
                                        value="{{ $categoria->categoria_id }}"
                                        {{
                                            old(
                                                'categoria_id',
                                                $produto->categoria_id
                                            ) == $categoria->categoria_id
                                                ? 'selected'
                                                : ''
                                        }}
                                    >
                                        {{ $categoria->nome }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label>
                                Preço
                            </label>

                            <input
                                type="number"
                                name="preco"
                                min="0"
                                step="0.01"
                                value="{{ old(
                                    'preco',
                                    $produto->preco
                                ) }}"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Estoque
                            </label>

                            <input
                                type="number"
                                name="estoque"
                                min="0"
                                value="{{ old(
                                    'estoque',
                                    $produto->estoque
                                ) }}"
                                required
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label>
                            Trocar foto
                        </label>

                        <input
                            type="file"
                            name="foto"
                            accept="image/jpeg,image/png,image/webp"
                        >

                    </div>


                    <div class="produto-edit-actions">

                        <a
                            href="{{ route('admin.produtos.index') }}"
                            class="btn-produto-cancelar"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="btn-produto-principal"
                        >
                            Salvar Alterações
                        </button>

                    </div>

                </form>

            </section>

        </main>

    </div>

</div>

@endsection