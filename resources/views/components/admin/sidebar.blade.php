<link
    rel="stylesheet"
    href="{{ asset('css/admin/dashboard.css') }}"
>
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
    href="{{ route('admin.produtos.index') }}"
    class="menu-item {{ request()->routeIs('admin.produtos.*') ? 'active' : '' }}"
>

    <i class="bi bi-bag"></i>

    <span>
        Produtos
    </span>

</a>


        <a
            href="{{ route('admin.procedimentos.index') }}"
            class="menu-item {{ request()->routeIs('admin.procedimentos.index') ? 'active' : '' }}"
        >

            <i class="bi bi-scissors"></i>

            <span>
                Procedimentos
            </span>

        </a>
</aside>