{{-- Sidebar --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laptop-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'App') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('dashboard') || request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- Proyek Saya --}}
    <li class="nav-item {{ request()->routeIs('user.projects.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.projects.index') }}">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Proyek Saya</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Toggle --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
