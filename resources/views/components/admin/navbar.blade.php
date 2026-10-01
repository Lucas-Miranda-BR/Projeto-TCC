<header class="admin-navbar">

  


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

        <a
            href="{{ route('cliente.logout') }}"
            class="client-logout"
            title="Sair"
        >

            <i class="bi bi-box-arrow-right"></i>

        </a>

    </div>


    

</header>