<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-color: #c9184a;">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars" style="color: white;"></i>
    </button>

    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
        <span class="text-white small font-weight-bold">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            echo date('d-M-Y'); 
            ?>
            | <i class="far fa-clock"></i> <span id="clock"></span> WIB
        </span>
    </div>

    <div class="topbar-divider d-none d-sm-block"></div>
    <marquee scrollamount="5">
        <span style="color: white; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 16px;">
            Sistem Informasi Inventaris dan Peminjaman Alat - <i><b>MAYAPALA</b></i>
        </span>
    </marquee>

    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white small font-weight-bold">
                    <?= $this->session->userdata('nama_user') ?> 
                    <span class="badge badge-light text-dark ml-1" style="font-size: 10px;">
                        <?= $this->session->userdata('role') ?>
                    </span>
                </span>
                
            </a>
            
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>
</nav>

<script>
    function updateClock() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').innerHTML = hours + ":" + minutes + ":" + seconds;
    }
    setInterval(updateClock, 1000);
    updateClock(); // Jalankan langsung
</script>