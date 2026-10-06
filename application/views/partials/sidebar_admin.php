<ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">
    
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('sb-admin/img/MAYAPALA.png') ?>" alt="Logo" style="width: 35px; border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-3">MAYAPALATools</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard Admin</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <li class="nav-item <?= ($this->uri->segment(1) == 'peminjam') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/peminjam') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Peminjam</span>
        </a>
    </li>

    <li class="nav-item <?= ($this->uri->segment(1) == 'alat') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/alat') ?>">
            <i class="fas fa-fw fa-tools"></i>
            <span>Data Alat</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Transaksi
    </div>

    <li class="nav-item <?= ($this->uri->segment(2) == 'peminjaman') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('admin/peminjaman') ?>">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Peminjaman</span>
            <span class="badge badge-danger badge-counter">!</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar Sistem</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>