<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AlatMYP - Login</title>
    
    <link href="<?= base_url('sb-admin') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url('sb-admin') ?>/css/sb-admin-2.min.css" rel="stylesheet">
    
    <style>
        .btn-AlatMYP {
            background-color: #c9184a;
            color: white;
        }
        .btn-AlatMYP:hover {
            background-color: #ff4d6d;
            color: white;
        }
        /* Style untuk logo bulat */
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
                                <span class="text-muted">Peminjaman Alat MAYAPALA</span>
                            </div>

                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $this->session->flashdata('success') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php elseif ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $this->session->flashdata('error') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>

                            <form class="user" method="POST" action="<?= base_url('login/proses_login') ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user text-center" id="username" placeholder="Masukkan Username" autocomplete="off" required name="username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user text-center" id="password" placeholder="Masukkan Password" required name="password">
                                </div>
                                
                                

                                <button type="submit" class="btn btn-AlatMYP btn-user btn-block" name="login">
                                    Login
                                </button>
                            </form>
                            
                            <hr>
                            <div class="text-center">
                                <small class="text-muted">Belum punya akun? <a href="<?= base_url('register') ?>" style="color: #c9184a; font-weight: bold;">Daftar sekarang</a></small>
                            </div>
                            <div class="text-center mt-2">
                                    <a href="<?= base_url('admin/login') ?>" class="small text-muted italic">
                                    <i class="fas fa-user-shield"></i> Login sebagai Admin
                                </a>
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