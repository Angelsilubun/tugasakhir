<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs(['dashboard', 'admin.dashboard', 'pakar.dashboard_pakar']) ? '' : 'collapsed' }}"
                href="@if (Auth::user()->role == 'admin') {{ route('admin.dashboard') }}
                @elseif (Auth::user()->role == 'pakar')
                {{ route('pakar.dashboard_pakar') }}
                @else
                {{ route('dashboard') }} @endif">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('riwayat_diagnosa*') ? '' : 'collapsed' }}"
                href="{{ route('riwayat_diagnosa.index') }}">
                <i class="bi bi-clipboard2-data"></i>
                <span>Riwayat Diagnosa</span>
            </a>
        </li>

        @if (Auth::user()->role == 'admin')
            <li class="nav-item ">
                <a class="nav-link {{ Request::routeIs(['datapasien*.index', 'datauser*.index', 'dataadmin*.index']) ? '' : 'collapsed' }}"
                    data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav"
                    class="@if (Request::routeIs(['datapasien*.index', 'datauser*.index', 'dataadmin*.index']) ? '' : 'collapsed') nav-content collapse @else nav-content @endif"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('datapasien.index') }}"
                            class="nav-link {{ Request::routeIs(['datapasien.index']) ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Data Pasien</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('datauser.index') }}"
                            class="nav-link {{ Request::routeIs(['datauser*.index']) ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Data Pakar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dataadmin.index') }}"
                            class="nav-link {{ Request::routeIs(['dataadmin*.index']) ? 'active' : 'collapsed' }}">
                            <i class="bi bi-circle"></i><span>Data Admin</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->role == 'pakar')
            <li class="nav-item collapsed">
                <a class="nav-link {{ Request::routeIs('landingPagePostPenyakit*') ? '' : 'collapsed' }}"
                    href="{{ route('landingPagePostPenyakit.index') }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Data Artikel Materi Penyakit</span>
                </a>
            </li>

            <li class="nav-item collapsed">
                <a class="nav-link {{ Request::routeIs('datapenyakit*') ? '' : 'collapsed' }}"
                    href="{{ route('datapenyakit.index') }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Data Penyakit</span>
                </a>
            </li><!-- End Data Penyakit Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('datagejala*') ? '' : 'collapsed' }}"
                    href="{{ route('datagejala.index') }}">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Data Gejala</span>
                </a>
            </li><!-- End Data Gejala Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('basisrule*') ? '' : 'collapsed' }}"
                    href="{{ route('basisrule.index') }}">
                    <i class="bi bi-server"></i>
                    <span>Basis Rules</span>
                </a>
            </li><!-- End Basis Rules Nav -->
        @endif

        @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('petunjuk_penggunaan*') ? '' : 'collapsed' }}" href="{{ route('petunjuk_penggunaan.index') }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Data petunjuk</span>
                </a>
            </li><!-- End Basis Rules Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('profile*') ? '' : 'collapsed' }}" href="{{ route('profile.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Nav -->
        @endif

    </ul>

</aside>
