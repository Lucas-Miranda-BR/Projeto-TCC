@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/admin/cores.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="cores-content">

            <div class="cores-header">

                <span class="breadcrumb-admin">
                    Painel >
                    <strong>Cores</strong>
                </span>

                <h1>
                    Gerenciar cores
                </h1>

                <p>
                    Cadastre, edite ou remova as cores registradas.
                </p>

            </div>


            @if(session('success'))

                <div class="alert-success">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))
                <div class="alert-errors">
                    {{ session('error') }}
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


            <section class="novo-cor">

                <h2>
                    Nova cor
                </h2>


                <form
                    action="{{ route('admin.cores.store') }}"
                    method="POST"
                >

                    @csrf


                    <div class="form-group">

                        <label for="nome">
                            Nome da cor
                        </label>

                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            value="{{ old('nome') }}"
                            placeholder="Ex: Rosa"
                            required
                        >

                        <label for="estoque">
                            Estoque Inicial
                        </label>

                        <input
                            type="number"
                            name="estoque"
                            id="estoque"
                            value="{{ old('estoque') }}"
                            placeholder="Ex: 1"
                            required
                        >
                    </input>

                    </div>

                    <button
                        type="submit"
                        class="btn-salvar"
                    >

                        Cadastrar cor

                    </button>

                </form>

            </section>


            <section class="lista-cores">

                <div class="lista-header">

                    <h2>
                        Cores Cadastradas
                    </h2>

                    <span>
                        {{ $cores->count() }}
                        Cor(es)
                    </span>

                </div>


                @if($cores->count() > 0)

                    <div class="table-responsive">

                        <table>

                            <thead>

                                <tr>
                                    <th>Nome</th>
                                    <th>Estoque</th>
                                    <th>Status</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($cores as $cor)

                                    <tr>

                                        <td>
                                            {{ $cor->nome}}
                                        </td>

                                        <td>
                                            {{ $cor->estoque}}
                                        </td>

                                        @if ($cor->estoque >= 1)     
                                        <td>
                                            Disponível
                                        </td>

                                        @else
                                        <td>
                                            Indisponível
                                        </td>
                                        @endif

                                        <td>

                                            <div class="acoes">

                                                <a
                                                    href="{{ route(
                                                        'admin.cores.edit',
                                                        $cor->getKey()
                                                    ) }}"
                                                    class="btn-editar"
                                                >

                                                    Editar

                                                </a>


                                                <form
                                                    action="{{ route(
                                                        'admin.cores.destroy',
                                                        $cor->getKey()
                                                    ) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn-excluir"
                                                        onclick="return confirm('Deseja realmente excluir esta cor?')"
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

                    <div class="nenhum-cor">

                        <p>
                            Nenhum cor cadastrado ainda.
                        </p>

                    </div>

                @endif

            </section>

        </main>

    </div>

</div>

@endsection

@push('scripts')
@endpush