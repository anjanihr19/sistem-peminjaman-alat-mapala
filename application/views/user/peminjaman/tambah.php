<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('partials/head'); ?>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f6f8fb; color: #2d3748; }
        .card { border: none; border-radius: 16px; }
        .form-control { border-radius: 12px; border: 1px solid #e9ecef; font-size: 14px; padding: 10px 14px; }
        .form-control:focus { box-shadow: none; border-color: #c9184a; }
        label { font-weight: 500; font-size: 14px; margin-bottom: 6px; }
        .btn-modern { background-color: #c9184a; border: none; border-radius: 50px; padding: 10px 22px; font-weight: 500; color: #fff; }
        .btn-modern:hover { background-color: #a4133c; color: #fff; }
        .info-alat { background-color: #eef2ff; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; }
    </style>
</head>
<body id="page-top">
<div id="wrapper">

    <?php $this->load->view('partials/sidebar_user'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php $this->load->view('partials/topbar'); ?>

        <div class="container-fluid">

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1"><?= $title; ?></h3>
                    <small class="text-muted">Isi form peminjaman alat</small>
                </div>
            </div>

            <div class="card shadow-sm p-4">

                <!-- Info Alat -->
                <div class="info-alat">
                    <strong><?= $alat->nama_alat; ?></strong>
                    <span class="text-muted ml-2"><?= $alat->kode_alat; ?></span>
                    <div class="mt-2 small">
                        <span class="text-muted">Stok total: </span>
                        <strong><?= $alat->jumlah; ?> Unit</strong>
                        <span class="text-muted ml-3">
                            ⚠️ Stok tersedia bisa berbeda tergantung tanggal yang dipilih
                        </span>
                    </div>
                </div>

                <form action="<?= base_url('user/peminjaman/simpan'); ?>" method="post">
                    <input type="hidden" name="id_alat" value="<?= $alat->id_alat; ?>">

                    <div class="form-group">
                        <label>Jumlah Pinjam</label>
                        <input type="number" name="jml_alat" class="form-control" 
                               min="1" max="<?= $alat->jumlah; ?>" required>
                        <small class="text-muted">Maksimal <?= $alat->jumlah; ?> unit</small>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tgl_pinjam" class="form-control" 
                               min="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali" class="form-control" 
                               min="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-modern">Ajukan Peminjaman</button>
                        <a href="<?= base_url('user/alat'); ?>" class="btn btn-secondary ml-2" style="border-radius:50px; padding:10px 22px;">Kembali</a>
                    </div>
                </form>
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