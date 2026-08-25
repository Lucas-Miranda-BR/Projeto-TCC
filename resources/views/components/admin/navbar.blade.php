<header class="admin-navbar">

    <div class="admin-search">

        <i class="bi bi-search"></i>

        <input
            type="text"
            placeholder="Buscar cliente, serviço, produto..."
        >

    </div>


    <nav class="admin-top-menu">

        <a href="{{ route('home') }}">
            Início
        </a>

        <a href="{{ route('site.sobre') }}">
            Sobre mim
        </a>

        <a href="{{ route('site.produtos') }}">
            Produtos
        </a>

        <a href="{{ route('site.ia') }}">

            IA

            <i class="bi bi-image"></i>

        </a>


        <a href="#" class="notifications-link">

            Notificações

            <span class="notification-wrapper">

                <i class="bi bi-bell-fill"></i>

                <span class="notification-count">
                    9
                </span>

            </span>

        </a>

    </nav>


    <div class="admin-profile">

        <img
            src="{{ asset('images/logo.png') }}"
            alt="Sandra Nerys"
            class="admin-avatar"
        >


        <div class="admin-profile-info">

            <strong>
                Sandra Nerys
            </strong>

            <span>
                Admin
            </span>

        </div>

    </div>


    <a href="#" class="admin-settings">

        <i class="bi bi-gear-fill"></i>

    </a>

</header>