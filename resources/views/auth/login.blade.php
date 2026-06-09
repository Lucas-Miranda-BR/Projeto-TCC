@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')

<div class="container-login">

    <div class="left">

        <h1>
            Sua Jornada de
            <span>Beleza e Poder</span>
            Começa Aqui
        </h1>

        <p>
            Acesse sua conta para agendar serviços.
        </p>

    </div>

    <div class="right">

        <form>

            <h2>Faça seu login</h2>

            <input type="email" placeholder="Email">

            <input type="password" placeholder="Senha">

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</div>

@endsection