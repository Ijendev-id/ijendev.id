{{-- Sidebar --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'App') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Manajemen Data</div>

    {{-- Data Klien --}}
    <li class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menuClients"
           aria-expanded="{{ request()->routeIs('admin.clients.*') ? 'true' : 'false' }}"
           aria-controls="menuClients">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Data Klien</span>
        </a>
        <div id="menuClients" class="collapse {{ request()->routeIs('admin.clients.*') ? 'show' : '' }}"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.clients.index') ? 'active' : '' }}"
                   href="{{ route('admin.clients.index') }}">
                    <i class="fas fa-list-ul mr-2"></i> Daftar Klien
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.clients.create') ? 'active' : '' }}"
                   href="{{ route('admin.clients.create') }}">
                    <i class="fas fa-plus mr-2"></i> Tambah Klien
                </a>
            </div>
        </div>
    </li>

    {{-- Data Proyek --}}
    <li class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menuProjects"
           aria-expanded="{{ request()->routeIs('admin.projects.*') ? 'true' : 'false' }}"
           aria-controls="menuProjects">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Data Proyek</span>
        </a>
        <div id="menuProjects" class="collapse {{ request()->routeIs('admin.projects.*') ? 'show' : '' }}"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.projects.index') ? 'active' : '' }}"
                   href="{{ route('admin.projects.index') }}">
                    <i class="fas fa-list-ul mr-2"></i> Daftar Proyek
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.projects.create') ? 'active' : '' }}"
                   href="{{ route('admin.projects.create') }}">
                    <i class="fas fa-plus mr-2"></i> Tambah Proyek
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Toggle --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
