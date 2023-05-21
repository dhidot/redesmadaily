<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse mt-2">
    <div class="row">
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                @if (auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" aria-current="page"
                    href="{{ route('dashboard.index') }}">
                        <i class="bi bi-speedometer" style="width: 20px: height: 20px;"></i>
                    Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}"
                    href="{{ route('departments.index') }}">
                        <i class="bi bi-diagram-3-fill"></i>
                    Departemen / Divisi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('positions.*') ? 'active' : '' }}"
                    href="{{ route('positions.index') }}">
                        <i class="bi bi-bookmarks-fill"></i>
                    Jabatan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                    href="{{ route('employees.index') }}">
                        <i class="bi bi-people-fill"></i>
                        Karyawaan
                    </a>
                </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}"
                    href="{{ route('attendances.index') }}">
                    <i class="bi bi-clipboard-plus-fill"></i>
                    Presensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('presences.*') ? 'active' : '' }}"
                    href="{{ route('presences.index') }}">
                    <i class="bi bi-clipboard-data-fill"></i>
                    Data Kehadiran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('holidays.*') ? 'active' : '' }}"
                href="{{ route('holidays.index') }}">
                    <i class="bi bi-calendar-event-fill"></i>
                        Hari Libur
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home.*') ? 'active' : '' }}" 
                    href="{{ route('home.index') }}">
                    <i class="bi bi-speedometer2"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home.edit-password') ? 'active' : '' }}" 
                    href="{{ route('home.edit-password') }}">
                    <i class="bi bi-pencil-square"></i>
                    Change Password
                </a>
            </li>
            @endif
            </ul>
        </div>
    </div>
    <div class="row text-center mh-100 align-items-center">
    </div>
    <div class="row text-center  mh-100 align-items-bottom">
        <form action="{{ route('auth.logout') }}" method="POST">
        @method('DELETE')
        @csrf
        <button class="w-full mt-5 bg-transparent border-0 fw-bold text-danger px-3">Keluar <i class="bi bi-box-arrow-right"></i></button>
    </form>
    </div>
</div>
</nav>