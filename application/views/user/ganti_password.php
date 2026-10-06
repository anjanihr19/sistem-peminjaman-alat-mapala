<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AlatMYP - Ganti Password</title>
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
        .warning-box {
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
                                <h1 class="h4 text-gray-900 font-weight-bold">Ganti Password</h1>
                                <span class="text-muted">Anda menggunakan password sementara</span>
                            </div>

                            <?php if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $this->session->flashdata('error') ?>
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>

                            <div class="warning-box">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Akun Anda menggunakan password sementara dari admin.
                                Harap ganti password Anda sebelum melanjutkan.
                            </div>

                            <form class="user" method="POST" action="<?= base_url('user/proses_ganti_password') ?>">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user text-center"
                                        placeholder="Password Baru (minimal 5 karakter)"
                                        name="password_baru" required minlength="5">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user text-center"
                                        placeholder="Konfirmasi Password Baru"
                                        name="password_konfirmasi" required minlength="5">
                                </div>
                                <button type="submit" class="btn btn-simvers btn-user btn-block">
                                    Ganti Password
                                </button>
                            </form>
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
        document.querySelector('form').addEventListener('submit', function(e) {
            const pass = document.querySelector('input[name="password_baru"]').value;
            const konfirm = document.querySelector('input[name="password_konfirmasi"]').value;
            if (pass !== konfirm) {
                e.preventDefault();
                alert('Password baru dan konfirmasi password tidak cocok!');
            }
        });
    </script>
</body>
</html>