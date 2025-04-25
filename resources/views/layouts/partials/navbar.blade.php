<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logo-rsudlangsa.png') }}" alt="RSUD Langsa Logo">
            <span>RSUD Langsa Single Sign On</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if ((auth()->user()->role->name ?? '') == 'admin')
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('client*') ? 'active' : '' }}"
                            href="{{ route('client.index') }}">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user*') ? 'active' : '' }}"
                            href="{{ route('user.index') }}">Users</a>
                    </li>
                </ul>
            @endif

            <a href="{{ route('logout') }}" class="btn-logout ms-auto text-decoration-none">
                <i class="bi bi-power"></i> Logout
            </a>
        </div>
    </div>
</nav>
