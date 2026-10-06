<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AlatMYP - Login Admin</title>
    
    <link href="<?= base_url('sb-admin') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url('sb-admin') ?>/css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        /* Warna biru gelap/hitam agar beda dengan User (Opsional) */
        .bg-admin {
            background-color: #1a1c20;
        }
        .btn-admin {
            background-color: #4e73df;
            color: white;
        }
        .btn-admin:hover {
            background-color: #2e59d9;
            color: white;
        }
        .logo-container {
            width: 120px;
            height: 120px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
        }
        .logo-container img {
            width: 85%;
            height: auto;
        }
    </style>
</head>

<body class="bg-admin">

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
                                
                                <h1 class="h4 text-gray-900 font-weight-bold">ADMIN LOGIN</h1>
                                <span class="text-muted small">MAYAPALA Tools Management</span>
                            </div>

                            <?php if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <small><?= $this->session->flashdata('error') ?></small>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>

                            <form class="user" method="POST" action="<?= base_url('admin/login/proses_login') ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center" id="username" placeholder="Username Admin" autocomplete="off" required name="username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user text-center" id="password" placeholder="Password" required name="password">
                                </div>
                                
                                <button type="submit" class="btn btn-admin btn-user btn-block">
                                    Masuk ke Panel Kontrol
                                </button>
                            </form>
                            
                            <hr>
                            <div class="text-center">
                                <a href="<?= base_url('login') ?>" class="small text-muted">Bukan Admin? Kembali ke Login User</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('sb-admin') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url('sb-admin') ?>/js/sb-admin-2.min.js"></script>
</body>

</html>