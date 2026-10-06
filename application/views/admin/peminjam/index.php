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
        <?php $this->load->view('partials/sidebar_admin'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php $this->load->view('partials/topbar'); ?>

                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="mb-1"><?= $title; ?></h3>
                            <small class="text-muted">Kelola data peminjam & akses akun</small>
                        </div>
                        <a href="<?= base_url('admin/peminjam/kode_undangan'); ?>" class="btn btn-modern shadow-sm">
                            <i class="fas fa-ticket-alt mr-1"></i> Kode Undangan
                        </a>
                    </div>

                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <form method="get" action="<?= base_url('admin/peminjam'); ?>" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control"
                                placeholder="Cari nama peminjam, alat, institusi, atau status..."
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
                                        <th>Status User</th>
                                        <th>Nama Peminjam</th>
                                        <th>Alamat</th>
                                        <th>No HP</th>
                                        <th>Institusi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = $start + 1;
                                    foreach ($peminjam as $p) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                              
                                                <?php if($p->status_akun == 'aktif'): ?>
                                                    <small class="text-success"><i class="fas fa-check-circle"></i> Aktif</small>
                                                <?php else: ?>
                                                    <small class="text-danger"><i class="fas fa-times-circle"></i> Non-Aktif</small>
                                                <?php endif; ?>
                                            </td>
                                            <td style="font-weight:500;"><?= $p->nama_peminjam; ?></td>
                                            <td style="font-weight:500;"><?= $p->alamat; ?></td>
                                            <td style="font-weight:500;"><?= $p->no_hp; ?></td>
                                            <td><span class="badge-soft"><?= $p->institusi; ?></span></td>
                                            <td class="text-right">
                                               <div class="btn-group">
        
                                                <?php if($p->status_akun == 'non-aktif'): ?>
                                                    <a href="<?= base_url('admin/peminjam/aktivasi/'.$p->id_users) ?>" 
                                                    class="btn btn-sm btn-success" 
                                                    title="Aktifkan Akun"
                                                    onclick="return confirm('Aktifkan akun ini?')">
                                                        <i class="fas fa-user-check"></i> 
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('admin/peminjam/nonaktif/'.$p->id_users) ?>" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Matikan Akun"
                                                    onclick="return confirm('Nonaktifkan akun ini?')">
                                                        <i class="fas fa-user-slash"></i> 
                                                    </a>
                                                <?php endif; ?>

                                                    <a href="<?= base_url('admin/peminjam/reset_password/' . $p->id_users); ?>" 
                                                       class="btn btn-action btn-edit mr-1" 
                                                       onclick="return confirm('Reset password user ini? Sistem akan membuat password sementara.')" 
                                                       title="Reset Password">
                                                        <i class="fas fa-key"></i>
                                                    </a>

                                                    <a href="<?= base_url('admin/peminjam/edit/' . $p->id_peminjam); ?>" 
                                                       class="btn btn-action btn-edit mr-1" title="Edit Profil">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="<?= base_url('admin/peminjam/hapus/' . $p->id_peminjam); ?>" 
                                                       class="btn btn-action btn-delete" 
                                                       onclick="return confirm('Hapus permanen data peminjam ini?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                            <div class="pagination-modern">
                                <?= $pagination; ?>
                            </div>
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