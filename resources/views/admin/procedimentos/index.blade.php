@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/admin/procedimentos.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="procedimentos-content">

            <div class="procedimentos-header">

                <span class="breadcrumb-admin">
                    Painel >
                    <strong>Procedimentos</strong>
                </span>

                <h1>
                    Gerenciar Serviços
                </h1>

                <p>
                    Cadastre, edite ou remova os serviços disponíveis.
                </p>

            </div>


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


            <section class="novo-procedimento">

                <h2>
                    Novo Serviço
                </h2>


                <form
                    action="{{ route('admin.procedimentos.store') }}"
                    method="POST"
                >

                    @csrf


                    <div class="form-group">

                        <label for="tipo_id">
                            Tipo
                        </label>

                        <select name="tipo_id" id="tipo_id" required>
                            <option value="" selected disabled>Selecione o tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->tipo_id }}" data-colorivel="{{ $tipo->colorivel ? '1' : '0' }}" {{ old('tipo_id') == $tipo->tipo_id ? 'selected' : '' }}>
                                    {{ $tipo->nome }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group">

                        <label for="nome">
                            Nome do Serviço
                        </label>

                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            value="{{ old('nome') }}"
                            placeholder="Ex: Corte feminino"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="descricao">
                            Descrição
                        </label>

                        <textarea
                            name="descricao"
                            id="descricao"
                            placeholder="Descreva o serviço"
                            required
                        >{{ old('descricao') }}</textarea>

                    </div>


                    <div class="form-group">

                        <label for="preco">
                            Preço
                        </label>

                        <input
                            type="number"
                            name="preco"
                            id="preco"
                            step="0.01"
                            min="0"
                            value="{{ old('preco') }}"
                            placeholder="0,00"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn-salvar"
                    >

                        Cadastrar Serviço

                    </button>

                </form>

            </section>


            <section class="lista-procedimentos">

                <div class="lista-header">

                    <h2>
                        Serviços Cadastrados
                    </h2>

                    <span>
                        {{ $procedimentos->count() }}
                        serviço(s)
                    </span>

                </div>


                @if($procedimentos->count() > 0)

                    <div class="table-responsive">

                        <table>

                            <thead>

                                <tr>
                                    <th>Tipo</th>
                                    <th>Cor</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($procedimentos as $procedimento)

                                    <tr>

                                        <td>
                                            {{ $procedimento->tipo ? $procedimento->tipo->nome : '-' }}
                                        </td>

                                        <td>
                                            {{ $procedimento->cor ? $procedimento->cor->nome : 'incolorivel' }}
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $procedimento->nome }}
                                            </strong>
                                        </td>


                                        <td>
                                            {{ $procedimento->descricao }}
                                        </td>


                                        <td>
                                            R$
                                            {{ number_format(
                                                $procedimento->preco,
                                                2,
                                                ',',
                                                '.'
                                            ) }}
                                        </td>


                                        <td>

                                            <div class="acoes">

                                                <a
                                                    href="{{ route(
                                                        'admin.procedimentos.edit',
                                                        $procedimento->getKey()
                                                    ) }}"
                                                    class="btn-editar"
                                                >

                                                    Editar

                                                </a>


                                                <form
                                                    action="{{ route(
                                                        'admin.procedimentos.destroy',
                                                        $procedimento->getKey()
                                                    ) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn-excluir"
                                                        onclick="return confirm('Deseja realmente excluir este serviço?')"
                                                    >

                                                        Excluir

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="nenhum-procedimento">

                        <p>
                            Nenhum serviço cadastrado ainda.
                        </p>

                    </div>

                @endif

            </section>

        </main>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/procedimentos.js') }}"></script>
@endpush