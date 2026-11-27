@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/tipos.css') }}">
@endpush

@section('content')

<div class="admin-layout">

    @include('components.admin.sidebar')

    <div class="admin-main">

        @include('components.admin.navbar')

        <main class="tipos-content">

            <div class="tipos-header">
                <span class="breadcrumb-admin">
                    Painel > Tipos >
                    <strong>Editar</strong>
                </span>

                <h1>Editar tipo</h1>

                <p>Altere o nome ou a permissão de coloração deste tipo.</p>
            </div>

            @if (session('error'))
                <div class="alert-errors">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="tipo-edit-card">

                <h2>Dados do tipo</h2>

                <form action="{{ route('admin.tipos.update', $tipo->getKey()) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="tipo-campo">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome', $tipo->nome) }}" required>
                    </div>

                    <div class="tipo-campo">
                        <label for="colorivel">Permite coloração</label>
                        <select name="colorivel" id="colorivel" required>
                            <option value="0" {{ old('colorivel', $tipo->colorivel) == 0 ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ old('colorivel', $tipo->colorivel) == 1 ? 'selected' : '' }}>Sim</option>
                        </select>
                    </div>

                    <div class="tipo-edit-acoes">
                        <button type="submit" class="btn-salvar">Salvar alterações</button>
                        <a href="{{ route('admin.tipos.index') }}" class="btn-voltar-tipos">Voltar</a>
                    </div>

                </form>

            </section>

        </main>

    </div>

</div>

@endsection
