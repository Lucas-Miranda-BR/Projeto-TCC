<aside class="admin-sidebar">

    <div class="sidebar-header">

        <h2>
            Sempre Diva
        </h2>

        <span>
            Painel de Administração
        </span>

    </div>


    <nav class="sidebar-menu">

        {{-- OPERAÇÃO --}}

        <p class="menu-title">
            Operação
        </p>


        <a
            href="{{ route('admin.dashboard') }}"
            class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >

            <i class="bi bi-grid"></i>

            <span>
                Dashboard
            </span>

        </a>


        <a
            href="{{ route('admin.agendamentos') }}"
            class="menu-item {{ request()->routeIs('admin.agendamentos') ? 'active' : '' }}"
        >

            <i class="bi bi-calendar3"></i>

            <span>
                Agendamentos
            </span>

        </a>


        <a
            href="{{ route('admin.clientes') }}"
            class="menu-item {{ request()->routeIs('admin.clientes') ? 'active' : '' }}"
        >

            <i class="bi bi-people"></i>

            <span>
                Clientes
            </span>

        </a>



        {{-- COMERCIAL --}}

        <p class="menu-title">
            Comercial
        </p>


        <a
            href="{{ route('admin.produtos') }}"
            class="menu-item {{ request()->routeIs('admin.produtos') ? 'active' : '' }}"
        >

            <i class="bi bi-box-seam"></i>

            <span>
                Produtos e Estoque
            </span>

        </a>


        <a
            href="{{ route('admin.procedimentos.index') }}"class="menu-item {{ request()->routeIs('admin.procedimentos.*') ? 'active' : '' }}"
>

             <i class="bi bi-scissors"></i>

                 <span>
                      Serviços
                </span>

        </a>

        <a
            href="#"
            class="menu-item"
        >

            <i class="bi bi-star"></i>

            <span>
                Avaliações
            </span>

        </a>



        {{-- SISTEMA --}}

        <p class="menu-title">
            Sistema
        </p>


        <a
            href="#"
            class="menu-item"
        >

            <i class="bi bi-bell"></i>

            <span>
                Notificações
            </span>

        </a>


        <a
            href="#"
            class="menu-item"
        >

            <i class="bi bi-shield-check"></i>

            <span>
                Segurança
            </span>

        </a>


        <a
            href="#"
            class="menu-item"
        >

            <i class="bi bi-gear"></i>

            <span>
                Configurações
            </span>

        </a>

    </nav>


    {{-- CRÉDITOS DA IA --}}

    <div class="sidebar-ai">

        <span>
            Créditos de IA
        </span>

        <strong>
            2.140 restantes
        </strong>

        <div class="ai-progress">

            <div
                class="ai-progress-bar"
                style="width: 75%"
            >
            </div>

        </div>

        <small>
            75% consumido este mês
        </small>

    </div>

</aside>