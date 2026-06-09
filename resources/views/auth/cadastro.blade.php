@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/cadastro.css') }}">
@endpush

@section('content')

<div class="container-cadastro">

    <div class="left">

        <h1>
            Sua Jornada de
            <span>Beleza e Poder</span>
            Começa Aqui
        </h1>

    </div>

    <div class="right">

        <form>

            <h2>Crie sua conta</h2>

            <input type="text" placeholder="Nome">

            <input type="text" placeholder="Sobrenome">

            <input type="email" placeholder="Email">

            <input type="text" placeholder="Telefone">

            <input type="password" placeholder="Senha">

            <button>
                CRIAR CONTA
            </button>

        </form>

    </div>

</div>

@endsection