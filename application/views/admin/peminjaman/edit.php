<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('partials/head'); ?>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f6f8fb; color: #2d3748; }
        .card { border: none; border-radius: 16px; }
        .form-control { border-radius: 12px; border: 1px solid #e9ecef; font-size: 14px; padding: 10px 14px; }
        .form-control:focus { box-shadow: none; border-color: #c9184a; }
        label { font-weight: 600; font-size: 14px; color: #4a5568; }
        
        .btn-modern { background-color: #c9184a; border: none; border-radius: 50px; padding: 10px 25px; font-weight: 500; color: #ffffff; transition: 0.3s; }
        .btn-modern:hover { background-color: #a4133c; color: white; transform: translateY(-2px); }
        
        .btn-nego { background-color: #ff9f1c; border: none; border-radius: 50px; padding: 10px 25px; font-weight: 500; color: #ffffff; transition: 0.3s; }
        .btn-nego:hover { background-color: #e68a00; color: white; transform: translateY(-2px); }

        .btn-tolak { background-color: #f8d7da; border: none; border-radius: 50px; padding: 10px 25px; font-weight: 500; color: #721c24; transition: 0.3s; }
        .btn-tolak:hover { background-color: #f5c6cb; transform: translateY(-2px); }

        .info-box { background-color: #f8f9fc; border-left: 4px solid #c9184a; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .text-sm { font-size: 13px; }
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
                        <h3 class="font-weight-bold text-dark"><?= $title; ?></h3>
                        <p class="text-muted text-sm">Proses pengajuan atau ajukan perubahan.</p>
                    </div>
                    <a href="<?= base_url('admin/peminjaman'); ?>" class="btn btn-light btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                    <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius:12px;">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <?= $this->session->flashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius:12px;">
                                <i class="fas fa-check-circle mr-2"></i>
                                <?= $this->session->flashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm p-4 mb-4">
                            <form action="<?= base_url('admin/admin_peminjaman/ajukan_perubahan/'.$peminjaman->id_peminjaman); ?>" method="post">
                                <div class="info-box">
                                    <div class="row text-sm">
                                        <div class="col-md-6">
                                            <label class="mb-0 text-muted">Peminjam:</label>
                                            <p class="font-weight-bold mb-2"><?= $peminjaman->nama_peminjam; ?> (<?= $peminjaman->institusi; ?>)</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mb-0 text-muted">Alat:</label>
                                            <p class="font-weight-bold mb-2 text-primary"><?= $peminjaman->nama_alat; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Tanggal Pinjam</label>
                                        <input type="date" name="tgl_pinjam" class="form-control" value="<?= $peminjaman->tgl_pinjam; ?>" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Tanggal Kembali</label>
                                        <input type="date" name="tgl_kembali" class="form-control" value="<?= $peminjaman->tgl_kembali; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Jumlah Alat</label>
                                    <input type="number" name="jml_alat" class="form-control" value="<?= $peminjaman->jml_alat; ?>" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="text-danger">Alasan Perubahan / Penolakan</label>
                                    <textarea name="alasan_perubahan" class="form-control" rows="3" placeholder="Wajib diisi jika Nego atau Tolak"></textarea>
                                </div>

                                <div class="mt-4 d-flex flex-wrap">
                                    <button type="submit" name="submit_type" value="setuju_langsung" class="btn btn-modern mr-2 mb-2" onclick="return confirm('Setujui langsung?')">
                                        <i class="fas fa-check-circle mr-1"></i> Setuju Langsung
                                    </button>
                                    <button type="submit" name="submit_type" value="ajukan_nego" class="btn btn-nego mr-2 mb-2">
                                        <i class="fas fa-paper-plane mr-1"></i> Ajukan Nego
                                    </button>
                                    <button type="submit" name="submit_type" value="tolak" class="btn btn-tolak mb-2" onclick="return confirm('Tolak pengajuan?')">
                                        <i class="fas fa-times-circle mr-1"></i> Tolak
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('partials/footer'); ?>
    </div>
</div>
</body>
</html>