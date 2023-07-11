<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

        <div class="logo me-auto">
            <h1>Sistem Pakar</h1>
        </div>

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto {{ Request::routeIs('landingPageHome*.index') ? 'active' : '' }}"
                        href="{{ route('landingPageHome.index') }}">Home</a></li>
                <li><a class="nav-link scrollto {{ Request::routeIs('landingPageArtikel*.index') ? 'active' : '' }}"
                        href="{{ route('landingPageArtikel.index') }}">Artikel</a></li>
                <li><a class="nav-link scrollto {{ Request::routeIs('landingPage.index') ? 'active' : '' }}"
                        href="{{ route('landingPage.index') }}">Petunjuk Penggunaan</a></li>
                <li><a class="nav-link scrollto {{ Request::routeIs('diagnosa*.index') ? 'active' : '' }}"
                        href="{{ route('diagnosa.index') }}">Diagnosa</a></li>
                <li><a class="nav-link scrollto {{ Request::routeIs(['riwayat_diagnosa.indexDiagnosaLandingPage', 'diagnosa.show*']) ? 'active' : '' }}"
                        href="{{ route('riwayat_diagnosa.indexDiagnosaLandingPage') }}">Riwayat Diagnosa</a></li>
                {{-- <li><a class="nav-link scrollto" href="/login">Login</a></li> --}}
                @guest
                    @if (Route::has('login'))
                        <li>
                            <a class="nav-link scrollto {{ Request::routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @auth
                                @if (Auth::user()->role == 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                @elseif (Auth::user()->role == 'pakar')
                                    <a class="dropdown-item" href="{{ route('pakar.dashboard_pakar') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                @endif
                            @endauth
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header>
