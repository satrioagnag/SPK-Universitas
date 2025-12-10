<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SPK - AHP TOPSIS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{route('home')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data AHP - TOPSIS
            </div>

            <!-- Nav Item - Kriteria -->
    <li class="nav-item {{ request()->routeIs('criteria.*') || request()->routeIs('ahp.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKriteria"
            aria-expanded="{{ request()->routeIs('criteria.*') || request()->routeIs('ahp.*') ? 'true' : 'false' }}" 
            aria-controls="collapseKriteria">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Kriteria</span>
        </a>
        <div id="collapseKriteria" class="collapse {{ request()->routeIs('criteria.*') || request()->routeIs('ahp.*') ? 'show' : '' }}" 
             aria-labelledby="headingKriteria" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kelola Kriteria:</h6>
                <a class="collapse-item {{ request()->routeIs('criteria.index') ? 'active' : '' }}" 
                   href="{{ route('criteria.index') }}">
                    <i class="fas fa-list fa-sm"></i> Data Kriteria
                </a>
                <a class="collapse-item {{ request()->routeIs('ahp.*') ? 'active' : '' }}" 
                   href="{{ route('ahp.index') }}">
                    <i class="fas fa-balance-scale fa-sm"></i> Perbandingan AHP
                </a>
            </div>
        </div>
    </li>

            <!-- Nav Item - Alternatif -->
    <li class="nav-item {{ request()->routeIs('alternatives.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAlternatif"
            aria-expanded="{{ request()->routeIs('alternatives.*') ? 'true' : 'false' }}" 
            aria-controls="collapseAlternatif">
            <i class="fas fa-fw fa-university"></i>
            <span>Alternatif</span>
        </a>
        <div id="collapseAlternatif" class="collapse {{ request()->routeIs('alternatives.*') ? 'show' : '' }}" 
             aria-labelledby="headingAlternatif" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kelola Alternatif:</h6>
                <a class="collapse-item {{ request()->routeIs('alternatives.index') || request()->routeIs('alternatives.create') || request()->routeIs('alternatives.edit') ? 'active' : '' }}" 
                   href="{{ route('alternatives.index') }}">
                    <i class="fas fa-list fa-sm"></i> Data Alternatif
                </a>
                <a class="collapse-item {{ request()->routeIs('alternatives.scores.*') ? 'active' : '' }}" 
                   href="{{ route('alternatives.index') }}">
                    <i class="fas fa-star fa-sm"></i> Penilaian
                </a>
            </div>
        </div>
    </li>

            <!-- Nav Item - TOPSIS -->
    <li class="nav-item {{ request()->routeIs('topsis.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('topsis.index') }}">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Perhitungan TOPSIS</span>
        </a>
    </li>

    <!-- Nav Item - Hasil Akhir -->
    <li class="nav-item {{ request()->routeIs('topsis.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('topsis.index') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Hasil Perangkingan</span>
        </a>
    </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <p class="text-center mb-2"><strong>SPK - AHP TOPSIS </strong> is created with passion, knowledge, technology, and love ♡ from our Team.</p>
            </div>

        </ul>
        <!-- End of Sidebar -->