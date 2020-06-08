<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a id="navbarCustomerDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" v-pre>
                                Kunden
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('customer.list') }}" class="dropdown-item">Liste</a>
                            </div>
                        </li>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a id="navbarAdminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" v-pre>
                                Administration
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <h6 class="dropdown-header"><strong>Benutzer</strong></h6>
                                <a href="{{ route('user.list') }}" class="dropdown-item">Benutzerliste</a>
                                <a href="{{ route('register') }}" class="dropdown-item" >Benutzer erstellen</a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header"><strong>Rollen & Rechte</strong></h6>
                                <a href="{{ route('role.list') }}" class="dropdown-item">Rollenliste</a>
                                <a href="{{ route('role.create') }}" class="dropdown-item">Rolle erstellen</a>
                                <a href="{{ route('permission.list') }}" class="dropdown-item">Rechteliste</a>
                                <a href="{{ route('permission.create') }}" class="dropdown-item">Recht erstellen</a>
                            </div>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarUserDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->isAdmin() ? "Administrator" : Auth::user()->shortName() }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUserDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('profile') }}">Mein Profil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                Abmelden
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>