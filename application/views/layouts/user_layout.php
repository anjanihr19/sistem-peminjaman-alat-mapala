<!DOCTYPE html>
<html lang="id">
<head>
    <?php $this->load->view('partials/head'); ?>
</head>
<body id="page-top">
<div id="wrapper">

    <?php $this->load->view('partials/sidebar_user'); ?>

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            <?php $this->load->view('partials/topbar'); ?>

            <div class="container-fluid">
                <?php $this->load->view($content); ?>
            </div>
        </div>

        <?php $this->load->view('partials/footer'); ?>
    </div>

</div>

<?php $this->load->view('partials/js'); ?>
</body>
</html>