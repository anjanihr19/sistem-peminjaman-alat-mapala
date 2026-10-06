<style>
    .card-stat {
        border: none;
        border-radius: 16px;
        transition: 0.2s;
    }
    .card-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        line-height: 1;
    }
    .stat-label {
        font-size: 13px;
        color: #6c757d;
        margin-top: 4px;
    }
    .profile-card {
        border: none;
        border-radius: 16px;
        background: linear-gradient(135deg, #c9184a 0%, #a4133c 100%);
        color: white;
    }
    .profile-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        flex-shrink: 0;
    }
    .badge-menunggu     { background-color: #fff3cd; color: #856404; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-disetujui    { background-color: #e6f4ea; color: #198754; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-ditolak      { background-color: #ffe5e5; color: #c9184a; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-dipinjam     { background-color: #eef2ff; color: #4f46e5; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-dikembalikan { background-color: #f0f0f0; color: #6c757d; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .table td { vertical-align: middle; font-size: 14px; }
    .table th { font-size: 12px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
    .btn-modern { background-color: #c9184a; border: none; border-radius: 50px; padding: 8px 20px; font-weight: 500; color: #fff; font-size: 13px; }
    .btn-modern:hover { background-color: #a4133c; color: #fff; }
</style>

<!-- Greeting -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-1" style="font-weight:600;">
            Halo, <?= $user['nama']; ?> 👋
        </h4>
        <small class="text-muted">Selamat datang di MAYAPALATools</small>
    </div>
    <a href="<?= base_url('user/alat') ?>" class="btn btn-modern mt-2 mt-sm-0">
        <i class="fas fa-plus mr-1"></i> Pinjam Alat
    </a>
</div>

<!-- Profil User -->
<div class="card profile-card shadow-sm p-4 mb-4">
    <div class="d-flex align-items-center">
        <div class="profile-avatar mr-3">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <div style="font-size:18px; font-weight:600;"><?= $user['nama']; ?></div>
            <div style="font-size:13px; opacity:0.85;">
                <i class="fas fa-building mr-1"></i><?= $user['institusi']; ?>
                &nbsp;|&nbsp;
                <i class="fas fa-phone mr-1"></i><?= $user['no_hp']; ?>
                &nbsp;|&nbsp;
                <i class="fas fa-map-marker-alt mr-1"></i><?= $user['alamat']; ?>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-stat shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3" style="background-color:#eef2ff;">
                    <i class="fas fa-clipboard-list" style="color:#4f46e5;"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $total_peminjaman; ?></div>
                    <div class="stat-label">Total Peminjaman</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-stat shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3" style="background-color:#ffe5e5;">
                    <i class="fas fa-clock" style="color:#c9184a;"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $menunggu; ?></div>
                    <div class="stat-label">Menunggu Konfirmasi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-stat shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3" style="background-color:#fff3cd;">
                    <i class="fas fa-tools" style="color:#856404;"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $sedang_dipinjam; ?></div>
                    <div class="stat-label">Sedang Dipinjam</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-stat shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3" style="background-color:#e6f4ea;">
                    <i class="fas fa-check-circle" style="color:#198754;"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $alat_tersedia; ?></div>
                    <div class="stat-label">Alat Tersedia</div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Lokasi Pengambilan Alat -->
<div class="card shadow-sm" style="border:none; border-radius:16px;">
    <div class="card-body p-4">
        <h6 style="font-weight:600; margin-bottom:16px;">
            <i class="fas fa-map-marker-alt mr-2" style="color:#c9184a;"></i>
            Lokasi Pengambilan Alat
        </h6>

        <div class="d-flex align-items-start mb-3">
            <div style="width:40px; height:40px; border-radius:12px; background-color:#ffe5e5; 
                        display:flex; align-items:center; justify-content:center; 
                        flex-shrink:0; margin-right:16px;">
                <i class="fas fa-building" style="color:#c9184a;"></i>
            </div>
            <div>
                <div style="font-weight:600; font-size:15px;">Sekretariat MAYAPALA</div>
                <div class="text-muted" style="font-size:13px; margin-top:2px;">
                    Masuk pintu selatan AMIKOM, di belakang wall climbing
                </div>
            </div>
        </div>

        <div class="d-flex align-items-start mb-3">
            <div style="width:40px; height:40px; border-radius:12px; background-color:#eef2ff; 
                        display:flex; align-items:center; justify-content:center; 
                        flex-shrink:0; margin-right:16px;">
                <i class="fas fa-map-pin" style="color:#4f46e5;"></i>
            </div>
            <div>
                <div style="font-weight:600; font-size:15px;">Alamat</div>
                <div class="text-muted" style="font-size:13px; margin-top:2px;">
                    Jl. Ring Road Utara, Ngringin, Condongcatur,<br>
                    Kec. Depok, Kab. Sleman, DIY
                </div>
            </div>
        </div>
        <div class="d-flex align-items-start mb-3">
            <div style="width:40px; height:40px; border-radius:12px; background-color:#e6f4ea; 
                        display:flex; align-items:center; justify-content:center; 
                        flex-shrink:0; margin-right:16px;">
                <i class="fab fa-whatsapp" style="color:#198754;"></i>
            </div>
            <div>
                <div style="font-weight:600; font-size:15px;">Hubungi Kerumahtanggaan</div>
                <div class="text-muted" style="font-size:13px; margin-top:2px;">
                    <a href="https://wa.me/6289694836173" target="_blank" 
                    style="color:#198754; text-decoration:none; font-weight:500;">
                        <i class="fab fa-whatsapp mr-1"></i>089694836173
                    </a>
                    <span class="ml-2" style="font-size:12px;">(Klik untuk chat)</span>
                </div>
            </div>
        </div>
   

        <hr style="border-color:#f0f0f0;">

        <div class="d-flex align-items-center p-3" 
             style="background-color:#f6f8fb; border-radius:12px;">
            <i class="fas fa-info-circle mr-2" style="color:#c9184a;"></i>
            <small class="text-muted">
                Pastikan peminjaman Anda sudah berstatus 
                <strong style="color:#198754;">Disetujui</strong> 
                sebelum datang mengambil alat.
            </small>
        </div>
    </div>
</div>
