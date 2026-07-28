<header class="navbar">

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <nav>

        <a href="{{ route('site.home') }}">Início</a>

        <a href="{{ route('site.sobre') }}">Sobre Mim</a>

        <a href="{{ route('site.servicos') }}">Serviços</a>

        <a href="#">Produtos</a>

        <a href="#">IA</a>

        <a href="#">Notificações</a>

        <a href="{{ route('cliente.login') }}" class="btn-login">
            Login
        </a>

    </nav>

</header>