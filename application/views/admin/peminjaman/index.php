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
        
        /* Badge Desain Asli */
        .badge-menunggu  { background-color: #fff3cd; color: #856404; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-nego      { background-color: #e0f2fe; color: #0369a1; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-disetujui { background-color: #e6f4ea; color: #198754; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-ditolak   { background-color: #ffe5e5; color: #c9184a; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-dipinjam  { background-color: #eef2ff; color: #4f46e5; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        .badge-dikembalikan { background-color: #f0f0f0; color: #6c757d; padding: 6px 14px; border-radius: 50px; font-weight: 500; font-size: 12px; }
        
        .btn-modern { background-color: #c9184a; border: none; border-radius: 50px; padding: 8px 20px; font-size: 14px; font-weight: 500; color: #ffffff; }
        .btn-modern:hover { background-color: #a4133c; color: #ffffff; }
        .btn-update { border-radius: 50px; font-size: 12px; padding: 5px 15px; font-weight: 500; }
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
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle mr-1"></i> <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1"><?= $title; ?></h3>
                    <small class="text-muted">Kelola pengajuan peminjaman alat</small>
                </div>
				<div>
					<a href="<?= base_url('admin/peminjaman/export'); ?>" class="btn btn-success">
						<i class="fas fa-file-excel"></i> Export Excel
					</a>
			
				</div>
            </div>

            <form method="get" action="<?= base_url('admin/peminjaman'); ?>" class="mb-3">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control"
                        placeholder="Cari data peminjaman"
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
                                <th>Peminjam</th>
                                <th>Nama Alat</th>
                                <th>Jumlah</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($peminjaman)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada data peminjaman.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = $start + 1; foreach($peminjaman as $p): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <strong><?= $p->nama_peminjam; ?></strong><br>
                                        <small class="text-muted"><?= $p->institusi; ?></small>
                                    </td>
                                    <td><?= $p->nama_alat; ?></td>
                                    <td><?= $p->jml_alat; ?> Unit</td>
                                    <td><?= date('d/m/Y', strtotime($p->tgl_pinjam)); ?></td>
                                    <td><?= date('d/m/Y', strtotime($p->tgl_kembali)); ?></td>
                                    <td>
                                        <?php
                                            $status_class = 'badge-menunggu';
                                            if($p->status == 'Disetujui') $status_class = 'badge-disetujui';
                                            if($p->status == 'Dipinjam') $status_class = 'badge-dipinjam';
                                            if($p->status == 'Dikembalikan') $status_class = 'badge-dikembalikan';
                                            if($p->status == 'Ditolak' || $p->status == 'Dibatalkan') $status_class = 'badge-ditolak';
                                            if($p->status == 'Menunggu Konfirmasi User') $status_class = 'badge-nego';
                                        ?>
                                        <span class="<?= $status_class; ?>"><?= $p->status; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if($p->status == 'Menunggu'): ?>
                                            <a href="<?= base_url('admin/admin_peminjaman/edit/'.$p->id_peminjaman); ?>"
                                               class="btn btn-outline-primary btn-update">
                                                <i class="fas fa-edit"></i> Proses
                                            </a>
                                        <?php elseif($p->status == 'Disetujui'): ?>
                                            <button type="button" class="btn btn-primary btn-update text-white" 
                                                    onclick="openModalStatus('<?= $p->id_peminjaman ?>', 'Dipinjam', '<?= $p->tgl_pinjam ?>')">
                                                Set Dipinjam
                                            </button>
                                        <?php elseif($p->status == 'Dipinjam'): ?>
                                            <button type="button" class="btn btn-success btn-update" 
                                                    onclick="openModalStatus('<?= $p->id_peminjaman ?>', 'Dikembalikan', '<?= date('Y-m-d') ?>')">
                                                Set Kembali
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted text-xs">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <div class="mt-3">
                        <?= $pagination; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php $this->load->view('partials/footer'); ?>
    </div>
</div>

<div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalTitle">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formUpdateStatus" method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="status" id="inputStatus">
                    <div class="form-group">
                        <label id="labelTanggal" class="font-weight-bold">Tanggal Kejadian</label>
                        <input type="date" name="tanggal" id="inputTanggal" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light btn-sm px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4" style="background-color: #c9184a; border:none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('sb-admin') ?>/js/sb-admin-2.min.js"></script>

<script>
function openModalStatus(id, status, defaultDate) {
    const baseUrl = '<?= base_url('admin/admin_peminjaman/update_status_modal/') ?>';
    $('#formUpdateStatus').attr('action', baseUrl + id);
    $('#inputStatus').val(status);
    $('#inputTanggal').val(defaultDate);
    
    if(status === 'Dipinjam') {
        $('#modalTitle').text('Konfirmasi Penyerahan Alat');
        $('#labelTanggal').text('Tanggal Pinjam (Aktual)');
    } else {
        $('#modalTitle').text('Konfirmasi Pengembalian Alat');
        $('#labelTanggal').text('Tanggal Kembali (Aktual)');
    }
    $('#modalStatus').modal('show');
}
</script>
</body>
</html>
