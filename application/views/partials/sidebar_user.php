<ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user/dashboard') ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('sb-admin/img/MAYAPALA.png') ?>" alt="Logo" style="width: 35px; border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-3">MAYAPALATOOLS</div>
    </a>

    <hr class="sidebar-divider">

    <li class="nav-item <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/dashboard') ?>">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item <?= ($this->uri->segment(2) == 'alat') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/alat') ?>">
            <i class="fas fa-tools"></i>
            <span>Inventaris Alat</span>
        </a>
    </li>

    <li class="nav-item <?= ($this->uri->segment(2) == 'peminjaman') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/peminjaman/riwayat') ?>">
            <i class="fas fa-clipboard-list"></i>
            <span>Riwayat Peminjaman</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout') ?>">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </li>

</ul>