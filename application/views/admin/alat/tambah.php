<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('partials/head'); ?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f6f8fb;
        color: #2d3748;
        font-weight: 400;
    }

    h3 {
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .card {
        border: none;
        border-radius: 16px;
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid #e9ecef;
        font-size: 14px;
        padding: 10px 14px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #c9184a;
    }

    label {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 6px;
    }

    .btn-modern {
        background-color: #c9184a;
        border: none;
        border-radius: 50px;
        padding: 10px 22px;
        font-weight: 500;
        color: #ffffff;
    }

    .btn-modern:hover {
        background-color: #a4133c;
        color: #ffffff;
    }

    .btn-secondary-custom {
        border-radius: 50px;
        padding: 10px 22px;
        font-weight: 500;
    }

    .alert {
        border-radius: 12px;
    }
</style>

</head>

<body id="page-top">
<div id="wrapper">

<?php $this->load->view('partials/sidebar_admin'); ?>

<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<?php $this->load->view('partials/topbar'); ?>

<div class="container-fluid">

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
         </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="mb-1"><?= $title; ?></h3>
            <small class="text-muted">Tambahkan data alat baru</small>
        </div>
    </div>

    <div class="card shadow-sm p-4">

        <form action="<?= base_url('admin/alat/simpan'); ?>" method="post">

            <div class="form-group">
                <label>Kode Alat</label>
                <input type="text" name="kode_alat" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Merk</label>
                <input type="text" name="merk" class="form-control">
            </div>

            <div class="form-group">
                <label>Warna</label>
                <input type="text" name="warna" class="form-control">
            </div>

            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kondisi</label>
                <select name="kondisi" class="form-control">
                    <option value="Baik">Baik</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-modern">
                    Simpan
                </button>
                <a href="<?= base_url('admin/alat'); ?>" class="btn btn-secondary btn-secondary-custom ml-2">
                    Kembali
                </a>
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