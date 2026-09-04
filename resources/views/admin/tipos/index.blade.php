@extends('layouts.app')

@push('css')

<link
    rel="stylesheet"
    href="{{ asset('css/admin/tipos.css') }}"
>

@endpush


@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="tipos-content">

            <div class="tipos-header">

                <span class="breadcrumb-admin">
                    Painel >
                    <strong>tipos</strong>
                </span>

                <h1>
                    Gerenciar tipos
                </h1>

                <p>
                    Cadastre, edite ou remova os tipos disponíveis.
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


            <section class="novo-tipo">

                <h2>
                    Novo tipo
                </h2>


                <form
                    action="{{ route('admin.tipos.store') }}"
                    method="POST"
                >

                    @csrf


                    <div class="form-group">

                        <label for="nome">
                            Nome do tipo
                        </label>

                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            value="{{ old('nome') }}"
                            placeholder="Ex: Corte"
                            required
                        >

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

                    <button
                        type="submit"
                        class="btn-salvar"
                    >

                        Cadastrar tipo

                    </button>

                </form>

            </section>


            <section class="lista-tipos">

                <div class="lista-header">

                    <h2>
                        Tipos Cadastrados
                    </h2>

                    <span>
                        {{ $tipos->count() }}
                        tipo(s)
                    </span>

                </div>


                @if($tipos->count() > 0)

                    <div class="table-responsive">

                        <table>

                            <thead>

                                <tr>
                                    <th>Tipo</th>
                                    <th>Colorivel</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($tipos as $tipo)

                                    <tr>

                                        <td>
                                            {{ $tipo->nome}}
                                        </td>

                                        @if ($tipo->colorivel == 1)     
                                        <td>
                                            Sim
                                        </td>

                                        @else
                                        <td>
                                            Não
                                        </td>
                                        @endif

                                        <td>

                                            <div class="acoes">

                                                <a
                                                    href="{{ route(
                                                        'admin.tipos.edit',
                                                        $tipo->getKey()
                                                    ) }}"
                                                    class="btn-editar"
                                                >

                                                    Editar

                                                </a>


                                                <form
                                                    action="{{ route(
                                                        'admin.tipos.destroy',
                                                        $tipo->getKey()
                                                    ) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn-excluir"
                                                        onclick="return confirm('Deseja realmente excluir este tipo?')"
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

                    <div class="nenhum-tipo">

                        <p>
                            Nenhum tipo cadastrado ainda.
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