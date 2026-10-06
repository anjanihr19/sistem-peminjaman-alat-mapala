<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AlatMYP - Registrasi</title>
    <link href="<?= base_url('sb-admin') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url('sb-admin') ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .btn-simvers { background-color: #c9184a; color: white; }
        .btn-simvers:hover { background-color: #ff4d6d; color: white; }
        .logo-container {
            width: 120px; height: 120px;
            background-color: #fff; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; border: 4px solid #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
        }
        .logo-container img { width: 85%; height: auto; }
        .form-divider {
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; color: #6c757d;
            border-bottom: 1px solid #e9ecef; padding-bottom: 6px;
            margin-bottom: 12px; margin-top: 16px;
        }
        .info-box {
            background-color: #fff3cd; border-radius: 10px;
            padding: 10px 14px; font-size: 13px;
            color: #856404; margin-bottom: 16px;
        }
    </style>
</head>
<body style="background-color: #c9184a;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center mb-4">
                                <div class="logo-container">
                                    <img src="<?= base_url('sb-admin/img/MAYAPALA.png'); ?>" alt="Logo">
                                </div>
                                <h1 class="h4 text-gray-900 font-weight-bold">.: MAYAPALATools :.</h1>
                                <span class="text-muted">Daftar Akun Peminjam Alat</span>
                            </div>

                            <?php if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $this->session->flashdata('error') ?>
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>

                            <!-- Info cara daftar -->
                            <div class="info-box">
                                <i class="fas fa-info-circle mr-1"></i>
                                Hubungi admin MAYAPALA via WhatsApp untuk mendapatkan kode undangan sebelum mendaftar.
                                <br>
                                <a href="https://wa.me/6289694836173" target="_blank" style="color:#856404; font-weight:600;">
                                    <i class="fab fa-whatsapp mr-1"></i> Hubungi Admin
                                </a>
                            </div>

                            <form class="user" method="POST" action="<?= base_url('register/proses_daftar') ?>">

                                <div class="form-divider">Data Pribadi</div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center"
                                        placeholder="Nama Lengkap" name="nama_user" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center"
                                        placeholder="Nomor Induk Anggota" name="nomor_induk" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center"
                                        placeholder="No HP" name="no_hp" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center"
                                        placeholder="Alamat" name="alamat" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center"
                                        placeholder="Institusi/UKM" name="institusi" required>
                                </div>

                                <div class="form-divider">Data Akun</div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center"
                                        placeholder="Username" name="username" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user text-center"
                                        placeholder="Password (minimal 5 karakter)" name="password"
                                        id="password" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user text-center"
                                        placeholder="Konfirmasi Password" name="password_konfirmasi"
                                        id="password_konfirmasi" required>
                                </div>

                                <div class="form-divider">Kode Undangan</div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center"
                                        placeholder="Masukkan Kode Undangan (contoh: MYP-XXXXXX)"
                                        name="kode_undangan" autocomplete="off" required
                                        style="text-transform: uppercase; letter-spacing: 2px;">
                                </div>

                                <button type="submit" class="btn btn-simvers btn-user btn-block">
                                    Daftar Sekarang
                                </button>
                            </form>

                            <hr>
                            <div class="text-center">
                                <small class="text-muted">
                                    Sudah punya akun?
                                    <a href="<?= base_url('login') ?>" style="color: #c9184a; font-weight: bold;">
                                        Login di sini
                                    </a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('sb-admin') ?>/js/sb-admin-2.min.js"></script>
    <script>
        // Auto uppercase kode undangan
        document.querySelector('input[name="kode_undangan"]').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
                // Validasi konfirmasi password
        document.querySelector('form').addEventListener('submit', function(e) {
            const pass = document.getElementById('password').value;
            const konfirm = document.getElementById('password_konfirmasi').value;
            if (pass !== konfirm) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
            }
            if (pass.length < 5) {
                e.preventDefault();
                alert('Password minimal 5 karakter!');
            }
        });
    </script>
</body>
</html>