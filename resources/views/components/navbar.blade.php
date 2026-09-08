<header class="navbar">

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <nav>

        <a href="{{ route('home') }}">Início</a>

        <a href="{{ route('site.sobre') }}">Sobre Mim</a>

        <a href="{{ route('site.servicos') }}">Serviços</a>

        <a href="{{ route('site.ia') }}">IA</a>

        <a href="{{ route('site.produtos') }}">Produtos</a>

        @auth
            <a href="#">Notificações</a>
        @endauth

        @auth
            <a href="{{ route('cliente.logout') }}" class="btn-login">
                Logout
            </a>
        @else
            <a href="{{ route('cliente.login') }}" class="btn-login">
                Login
            </a>
        @endauth
    </nav>

</header>