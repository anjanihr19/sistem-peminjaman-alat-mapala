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
        .btn-modern { background-color: #c9184a; border: none; border-radius: 50px; padding: 10px 22px; font-weight: 500; color: #ffffff; }
        .btn-modern:hover { background-color: #a4133c; color: #ffffff; }
        .badge-used { background-color: #f0f0f0; color: #6c757d; padding: 6px 14px; border-radius: 50px; font-size: 12px; }
        .badge-unused { background-color: #e6f4ea; color: #198754; padding: 6px 14px; border-radius: 50px; font-size: 12px; }
        .kode-text { font-family: monospace; font-size: 15px; font-weight: 600; letter-spacing: 2px; color: #c9184a; }
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
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h3 class="mb-1"><?= $title; ?></h3>
                    <small class="text-muted">Kelola kode undangan untuk pendaftaran user</small>
                </div>
                <a href="<?= base_url('admin/peminjam/generate_kode'); ?>"
                    class="btn btn-modern"
                    onclick="return confirm('Generate kode undangan baru?')">
                    <i class="fas fa-plus mr-1"></i> Generate Kode Baru
                </a>
            </div>

            <div class="card shadow-sm p-4">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Undangan</th>
                                <th>Status</th>
                                <th>Digunakan Oleh</th>
                                <th>Dibuat</th>
                                <th>Digunakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($kode_undangan)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada kode undangan.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($kode_undangan as $k): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><span class="kode-text"><?= $k->kode; ?></span></td>
                                    <td>
                                        <?php if($k->is_used): ?>
                                            <span class="badge-used">Sudah Digunakan</span>
                                        <?php else: ?>
                                            <span class="badge-unused">Belum Digunakan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($k->is_used && $k->username): ?>
                                            <span class="badge badge-light text-dark">
                                                <i class="fas fa-user mr-1"></i> <?= $k->username; ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y H:i', strtotime($k->created_at)); ?></td>
                                    <td>
                                        <?= $k->used_at
                                            ? date('d M Y H:i', strtotime($k->used_at))
                                            : '<span class="text-muted">-</span>'; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
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