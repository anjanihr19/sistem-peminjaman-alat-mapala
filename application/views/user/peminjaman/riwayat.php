<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('partials/head'); ?>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f6f8fb; color: #2d3748; }
        h3 { font-weight: 600; letter-spacing: 0.3px; }
        .card { border: none; border-radius: 16px; }
        .table th { font-weight: 600; font-size: 12px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.6px; }
        .table td { vertical-align: middle; font-size: 14px; }
        .badge-menunggu { background-color: #fff3cd; color: #856404; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-disetujui { background-color: #e6f4ea; color: #198754; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-ditolak { background-color: #ffe5e5; color: #c9184a; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-dipinjam { background-color: #eef2ff; color: #4f46e5; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-dikembalikan { background-color: #f0f0f0; color: #6c757d; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-konfirmasi { background-color: #fff0d6; color: #d97706; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .btn-batal { background-color: #ffe5e5; color: #c9184a; border: none; border-radius: 50px; padding: 6px 14px; font-size: 13px; font-weight: 500; text-decoration: none; display: inline-block; }
        .btn-batal:hover { background-color: #f8d7da; color: #c9184a; text-decoration: none; }
        .btn-setuju { background-color: #e6f4ea; color: #198754; border: none; border-radius: 50px; padding: 6px 14px; font-size: 13px; font-weight: 500; text-decoration: none; display: inline-block; cursor: pointer; }
        .btn-setuju:hover { background-color: #d1e7dd; color: #198754; }
        .btn-tolak { background-color: #ffe5e5; color: #c9184a; border: none; border-radius: 50px; padding: 6px 14px; font-size: 13px; font-weight: 500; text-decoration: none; display: inline-block; cursor: pointer; }
        .btn-tolak:hover { background-color: #f8d7da; color: #c9184a; }
        .pagination-modern { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 25px; }
        .page-num { padding: 8px 14px; border-radius: 10px; text-decoration: none; background: #f1f3f7; color: #2d3748; font-weight: 500; transition: 0.2s; }
        .page-num:hover { background: #e2e6ef; text-decoration: none; }
        .page-num.active { padding: 4px 10px; border-radius: 8px; font-size: 13px; min-width: 30px; text-align: center; }
        .btn-modern { background-color: #c9184a; border: none; border-radius: 50px; padding: 4px 10px; font-size: 14px; font-weight: 500; color: #ffffff; }
        .btn-modern:hover { background-color: #a4133c; color: #ffffff; }
        .alasan-box { background-color: #fff3cd; border-radius: 8px; padding: 8px 12px; font-size: 12px; color: #856404; margin-top: 6px; }
    </style>
</head>
<body id="page-top">
<div id="wrapper">

    <?php $this->load->view('partials/sidebar_user'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php $this->load->view('partials/topbar'); ?>

        <div class="container-fluid">

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1"><?= $title; ?></h3>
                    <small class="text-muted">Daftar pengajuan peminjaman alat Anda</small>
                </div>
            </div>

            <form method="get" action="<?= base_url('user/peminjaman/riwayat'); ?>" class="mb-3">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control"
                        placeholder="Cari nama alat, kode, atau status..."
                        value="<?= isset($keyword) ? $keyword : '' ?>">
                    <div class="input-group-append">
                        <button class="btn btn-modern" type="submit">Cari</button>
                    </div>
                </div>
            </form>

            <div class="card shadow-sm p-4">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>Kode</th>
                                <th>Jumlah</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Estimasi Kembali</th>
                                <th>Realisasi Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($peminjaman)): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        Belum ada riwayat peminjaman.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = $start + 1; foreach($peminjaman as $p): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td style="font-weight:500">
                                        <?= $p->nama_alat; ?>
                                        <?php if($p->status == 'Menunggu Konfirmasi User' && !empty($p->alasan_perubahan)): ?>
                                            <div class="alasan-box">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                <strong>Alasan perubahan admin:</strong><br>
                                                <?= $p->alasan_perubahan; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $p->kode_alat; ?></td>
                                    <td><?= $p->jml_alat; ?> Unit</td>
                                    <td><?= date('d M Y', strtotime($p->tgl_pinjam)); ?></td>
                                    <td><?= date('d M Y', strtotime($p->tgl_kembali)); ?></td>
                                    <td>
                                        <?= $p->tgl_realisasi_kembali
                                            ? date('d M Y', strtotime($p->tgl_realisasi_kembali))
                                            : '<span class="text-muted">-</span>'; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badge = [
                                            'Menunggu'                  => 'badge-menunggu',
                                            'Menunggu Konfirmasi User'  => 'badge-konfirmasi',
                                            'Disetujui'                 => 'badge-disetujui',
                                            'Ditolak'                   => 'badge-ditolak',
                                            'Dipinjam'                  => 'badge-dipinjam',
                                            'Dikembalikan'              => 'badge-dikembalikan',
                                        ];
                                        $class = isset($badge[$p->status]) ? $badge[$p->status] : 'badge-menunggu';
                                        ?>
                                        <span class="<?= $class; ?>"><?= $p->status; ?></span>
                                    </td>
                                    <td>
                                        <?php if($p->status == 'Menunggu Konfirmasi User'): ?>
                                            <!-- Tombol konfirmasi perubahan dari admin -->
                                            <form method="POST" action="<?= base_url('user/peminjaman/konfirmasi/'.$p->id_peminjaman); ?>" style="display:inline;">
                                                <input type="hidden" name="aksi" value="setuju">
                                                <button type="submit" class="btn-setuju"
                                                    onclick="return confirm('Setuju dengan perubahan yang diajukan admin?')">
                                                    Setuju
                                                </button>
                                            </form>
                                            <form method="POST" action="<?= base_url('user/peminjaman/konfirmasi/'.$p->id_peminjaman); ?>" style="display:inline;">
                                                <input type="hidden" name="aksi" value="batalkan">
                                                <button type="submit" class="btn-tolak mt-1"
                                                    onclick="return confirm('Batalkan peminjaman ini?')">
                                                    Batalkan
                                                </button>
                                            </form>

                                        <?php elseif(in_array($p->status, ['Menunggu', 'Disetujui'])): ?>
                                            <a href="<?= base_url('user/peminjaman/batal/'.$p->id_peminjaman); ?>"
                                                class="btn-batal"
                                                onclick="return confirm('Yakin ingin membatalkan peminjaman <?= $p->nama_alat; ?>?')">
                                                Batalkan
                                            </a>

                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?= $pagination; ?>
                </div>
            </div>

        </div>
    </div>
    <?php $this->load->view('partials/footer'); ?>
    </div>
</div>
<script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('sb-admin') ?>/js/sb-admin-2.min.js"></script>
</body>
</html>