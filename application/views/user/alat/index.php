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

    .table thead {
        background-color: #ffffff;
        border-bottom: 1px solid #e9ecef;
    }

    .table th {
        font-weight: 600;
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .badge-soft {
        background-color: #eef2ff;
        color: #4f46e5;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 500;
    }

    .badge-stock-low {
        background-color: #ffe5e5;
        color: #c9184a;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 500;
    }

    .badge-stock-ok {
        background-color: #e6f4ea;
        color: #198754;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 500;
    }
        .btn-export {
        background-color: #e6f4ea;
        color: #198754;
        padding: 10px 12px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: 0.2s;
    }

    .btn-export:hover {
        background-color: #d1e7dd;
        color: #146c43;
        text-decoration: none;
    }
    .btn-modern {
        background-color: #c9184a;
        border: none;
        border-radius: 50px;
        padding: 4px 10px;
        font-size: 14px;
        font-weight: 500;
        color: #ffffff;
    }

    .btn-modern:hover {
        background-color: #a4133c;
        color: #ffffff;
    }

    .btn-action {
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
    }

    .btn-edit {
        background-color: #f8f9fa;
        color: #2d3748;
        border: 1px solid #dee2e6;
    }

    .btn-edit:hover {
        background-color: #e9ecef;
    }

    .btn-delete {
        background-color: #ffe5e5;
        color: #c9184a;
        border: none;
    }

    .btn-delete:hover {
        background-color: #f8d7da;
    }
 
    .pagination-modern {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 25px;
    }

    .page-num {
        padding: 8px 14px;
        border-radius: 10px;
        text-decoration: none;
        background: #f1f3f7;
        color: #2d3748;
        font-weight: 500;
        transition: 0.2s;
    }

    .page-num:hover {
        background: #e2e6ef;
        text-decoration: none;
    }

    .page-num.active {
        padding: 4px 10px;   
        border-radius: 8px;  
        font-size: 13px;     
        min-width: 30px;
        text-align: center;
    }

    .page-nav {
        padding: 8px 14px;
        border-radius: 10px;
        text-decoration: none;
        color: #c9184a;
        font-weight: 400;
        transition: 0.2s;
    }

    .page-nav:hover {
        background: #ffe5e5;
        text-decoration: none;
    }
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
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('success'); ?>
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h3 class="mb-1"><?= $title; ?></h3>
        <small class="text-muted">Daftar Alat MAYAPALA yang tersedia</small>
    </div>
</div>


<form method="get" action="<?= base_url('user/alat'); ?>" class="mb-3">
    <div class="input-group">
        <input type="text" name="keyword" class="form-control"
            placeholder="Cari alat..."
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
                    <th>Kode</th>
                    <th>Nama Alat</th>
                    <th>Merk</th>
                    <th>Warna</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
            </thead>
<tbody>
<?php $no = $start + 1; foreach ($alat as $a) : ?>
<tr>
    <td><?= $no++; ?></td>

    <td>
        <span class="badge-soft"><?= $a->kode_alat; ?></span>
    </td>

    <td style="font-weight: 500;"><?= $a->nama_alat; ?></td>
    <td style="font-weight: 500;"><?= $a->merk; ?></td>
    <td style="font-weight: 500;"><?= $a->warna; ?></td>

    <td>
        <?php if($a->jumlah <= 3): ?>
            <span class="badge-stock-low">
                <?= $a->jumlah; ?> Unit
            </span>
        <?php else: ?>
            <span class="badge-stock-ok">
                <?= $a->jumlah; ?> Unit
            </span>
        <?php endif; ?>
    </td>

    <td>
        <span class="badge-soft"><?= $a->kondisi; ?></span>
    </td>

    <td class="text-muted"><?= $a->keterangan; ?></td>

    <td class="text-right">
        <?php if($a->jumlah > 0): ?>
            <a href="<?= base_url('user/peminjaman/tambah/'.$a->id_alat); ?>" 
               class="btn btn-modern">
               Pinjam
            </a>
        <?php else: ?>
            <span class="badge-stock-low">Stok Habis</span>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?= $pagination; ?>

</div>
</div>

</div> <!-- container-fluid -->
</div> <!-- content -->

<?php $this->load->view('partials/footer'); ?>

</div> <!-- content-wrapper -->
</div> <!-- wrapper -->

<script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('sb-admin') ?>/js/sb-admin-2.min.js"></script>

</body>
</html>