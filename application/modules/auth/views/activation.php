<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo @$judul . " | " . @$deskripsi ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Refresh each 30 seconds -->
    <meta http-equiv="refresh" content="30">

    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() . "assets/dist/img/favicon.png" ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url() . "assets/dist/img/favicon.png" ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo base_url() . "assets/dist/css/custom.css" ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() . "assets/plugins/fontawesome-free/css/all.min.css" ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url() . "assets/plugins/ionicons/css/ionicons.min.css" ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url() . "assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() . "assets/dist/css/adminlte.css" ?>">
</head>

<body class="hold-transition login-page" style="background-color: #bec4ca">

    <?php echo form_open(uri_string()) ?>
    <?php if ($activation == 0) : ?>
        <div class="login-box">
            <div class="login-logo">
                <b>CIA </b>HMVC
            </div>
            <!-- alert flashdata -->
            <?php echo (empty(@$message) ? flash_msg(@$this->session->flashdata('message'), @$this->session->flashdata('type')) : @$message) ?>

            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <h6 class="text-center"><b>Account Activation</b></h6>
                    <hr>
                    <div class="alert alert-secondary" role="alert">
                        <p class="text-center">
                            Paste the code below to activate !
                        </p>
                        <div class="input-group mb-3">
                            <?php echo form_input($active_code); ?>
                        </div>
                    </div>
                    <div class="social-auth-links text-center mb-2">
                        <b>Not receiving any Code ?</b><br>
                        <a href="<?php echo base_url('generate/' . $id) ?>">Get Activation Code</a>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-check mr-2"></i>Activate</button>
                        </div>
                        <div class="col">
                            <a href="<?php echo base_url('cancel') ?>" class="btn btn-block btn-danger"><i class="fas fa-times mr-2"></i>Cancel</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
    <?php elseif ($this->ion_auth->logged_in()) : ?>
        <?php redirect('home', 'refresh') ?>
    <?php else : ?>
        <div class="login-box">
            <div class="login-logo">
                <b>CIA </b>HMVC
            </div>
            <!-- alert flashdata -->
            <?php echo (empty(@$message) ? flash_msg(@$this->session->flashdata('message'), @$this->session->flashdata('type')) : @$message) ?>

            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <h6 class="text-center"><b>Account Activation</b></h6>
                    <hr>
                    <div class="alert alert-light" role="alert">
                        <p class="text-center">
                            Congratulation <b><?php echo $identity ?></b><br>
                            Your account has been <b>activated</b><br>
                            You can <b>Sign In</b> now !
                        </p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="<?php echo $authURL; ?>" class="btn btn-block btn-danger"><i class="fab fa-google mr-2"></i>Sign In</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
    <?php endif ?>
    <?php echo form_close() ?>

    <!-- jQuery -->
    <script src="<?php echo base_url() . "assets/plugins/jquery/jquery.min.js" ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url() . "assets/plugins/bootstrap/js/bootstrap.bundle.min.js" ?>"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url() . "assets/plugins/icheck/icheck.min.js" ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url() . "assets/dist/js/adminlte.min.js" ?>"></script>

    <script>
        window.onload = function() {
            effect_msg();
        };

        /* alert messages */
        function effect_msg() {
            /* alert messages 1 */
            $('#alert-message').slideDown(1500);
            $('#alert-message').delay(4000).slideUp(1500);
        }

        $(document).ready(function() {
            $("input").iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>

</body>

</html>