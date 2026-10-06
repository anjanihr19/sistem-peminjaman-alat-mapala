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
        background-color: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        flex-shrink: 0;
    }
    .card-form {
        border: none;
        border-radius: 16px;
    }
    .form-control {
        border-radius: 12px;
        border: 1px solid #e9ecef;
        font-size: 14px;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #4e73df;
    }
    .btn-save {
        background-color: #4e73df;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 500;
        color: #fff;
        font-size: 13px;
    }
    .btn-save:hover { background-color: #2e59d9; color: #fff; }
    .badge-menunggu     { background-color: #fff3cd; color: #856404; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-disetujui    { background-color: #e6f4ea; color: #198754; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-ditolak      { background-color: #ffe5e5; color: #c9184a; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-dipinjam     { background-color: #eef2ff; color: #4f46e5; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .badge-dikembalikan { background-color: #f0f0f0; color: #6c757d; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
    .table td { vertical-align: middle; font-size: 14px; }
    .table th { font-size: 12px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.6px; font-weight: 600; }
    .badge-stok-low { background-color: #ffe5e5; color: #c9184a; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 500; }
</style>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<!-- Greeting -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-1" style="font-weight:600;">
            Halo, <?= $user['nama']; ?> 👋
        </h4>
        <small class="text-muted">Selamat datang di Panel Admin MAYAPALATools</small>
    </div>
    <a href="<?= base_url('admin/peminjaman') ?>" class="btn mt-2 mt-sm-0"
       style="background-color:#c9184a; border:none; border-radius:50px; padding:8px 20px; font-weight:500; color:#fff; font-size:13px;">
        <i class="fas fa-clipboard-list mr-1"></i> Kelola Peminjaman
    </a>
</div>

<!-- Profil Admin -->
<div class="card profile-card shadow-sm p-4 mb-4">
    <div class="d-flex align-items-center">
        <div class="profile-avatar mr-3">
            <i class="fas fa-user-shield"></i>
        </div>
        <div>
            <div style="font-size:18px; font-weight:600;"><?= $user['nama']; ?></div>
            <div style="font-size:13px; opacity:0.85;">
                <i class="fas fa-user mr-1"></i><?= $user['username']; ?>
                &nbsp;|&nbsp;
                <span style="background-color:rgba(255,255,255,0.15); padding:2px 10px; border-radius:50px; font-size:12px;">
                    <?= $user['role']; ?>
                </span>
                &nbsp;|&nbsp;
                <i class="fas fa-clock mr-1"></i>Login: <?= date('d M Y, H:i'); ?> WIB
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-stat shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3" style="background-color:#fff3cd;">
                    <i class="fas fa-hourglass-half" style="color:#856404;"></i>
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
                <div class="stat-icon mr-3" style="background-color:#eef2ff;">
                    <i class="fas fa-tools" style="color:#4f46e5;"></i>
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
                    <i class="fas fa-boxes" style="color:#198754;"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $total_alat; ?></div>
                    <div class="stat-label">Total Alat</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card card-stat shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon mr-3" style="background-color:#ffe5e5;">
                    <i class="fas fa-exclamation-triangle" style="color:#c9184a;"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $stok_menipis; ?></div>
                    <div class="stat-label">Stok Menipis</div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <!-- Peminjaman Terbaru -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm" style="border:none; border-radius:16px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 style="font-weight:600; margin:0;">Peminjaman Terbaru</h6>
                    <a href="<?= base_url('admin/peminjaman') ?>" class="small" style="color:#c9184a;">
                        Lihat semua →
                    </a>
                </div>
                <?php if(empty($peminjaman_terbaru)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p class="mb-0">Belum ada data peminjaman.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Alat</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($peminjaman_terbaru as $p): ?>
                                <tr>
                                    <td style="font-weight:500"><?= $p->nama_peminjam; ?></td>
                                    <td>
                                        <?= $p->nama_alat; ?><br>
                                        <small class="text-muted"><?= $p->kode_alat; ?></small>
                                    </td>
                                    <td><?= date('d M Y', strtotime($p->tgl_pinjam)); ?></td>
                                    <td>
                                        <?php
                                        $badge = [
                                            'Menunggu'     => 'badge-menunggu',
                                            'Disetujui'    => 'badge-disetujui',
                                            'Ditolak'      => 'badge-ditolak',
                                            'Dipinjam'     => 'badge-dipinjam',
                                            'Dikembalikan' => 'badge-dikembalikan',
                                        ];
                                        $class = isset($badge[$p->status]) ? $badge[$p->status] : 'badge-menunggu';
                                        ?>
                                        <span class="<?= $class ?>"><?= $p->status; ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Alat Stok Menipis + Edit Akun -->
    <div class="col-lg-5 mb-4">

        <!-- Stok Menipis -->
        <div class="card shadow-sm mb-4" style="border:none; border-radius:16px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 style="font-weight:600; margin:0;">
                        <i class="fas fa-exclamation-triangle mr-1" style="color:#c9184a;"></i>
                        Alat Stok Menipis
                    </h6>
                    <a href="<?= base_url('admin/alat') ?>" class="small" style="color:#c9184a;">
                        Kelola →
                    </a>
                </div>
                <?php if(empty($alat_menipis)): ?>
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x mb-2" style="color:#198754;"></i>
                        <p class="mb-0 small">Semua stok alat aman.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($alat_menipis as $a): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2"
                         style="background-color:#f6f8fb; border-radius:10px;">
                        <div>
                            <div style="font-weight:500; font-size:14px;"><?= $a->nama_alat; ?></div>
                            <small class="text-muted"><?= $a->kode_alat; ?></small>
                        </div>
                        <span class="badge-stok-low"><?= $a->jumlah; ?> Unit</span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Edit Akun -->
        <div class="card card-form shadow-sm" style="border:none; border-radius:16px;">
            <div class="card-body p-4">
                <h6 style="font-weight:600; margin-bottom:16px;">
                    <i class="fas fa-user-cog mr-1" style="color:#4e73df;"></i>
                    Edit Akun
                </h6>
                <form method="POST" action="<?= base_url('admin/dashboard/update_akun') ?>">
                    <div class="form-group">
                        <label style="font-size:13px; font-weight:500;">Username Baru</label>
                        <input type="text" name="username" class="form-control"
                               value="<?= $user['username'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label style="font-size:13px; font-weight:500;">Password Baru</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                    <button type="submit" class="btn-save" style="background-color:#c9184a; border:none; border-radius:50px; padding:8px 20px; font-weight:500; color:#fff; font-size:13px;">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>