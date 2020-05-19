<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo @$judul . " | " . @$deskripsi ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Refresh each 3 minutes -->
    <meta http-equiv="refresh" content="180">

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
    <?php if ($active == 0 || !$this->ion_auth->logged_in()) : ?>
        <div class="login-box">
            <div class="login-logo">
                <b>CIA </b>HMVC
            </div>
            <!-- alert flashdata -->
            <?php if (empty(@$message)) echo flash_msg(@$this->session->flashdata('message'), @$this->session->flashdata('type'));
            else echo @$message ?>

            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <h6 class="text-center"><b>Account Registration</b></h6>
                    <hr>
                    <?php echo form_open(uri_string()) ?>
                    <div class="input-group mb-3">
                        <div class="col text-center">
                            <img src="<?php echo $images ?>" width="140">
                        </div>
                    </div>
                    <div class="alert alert-light" role="alert">
                        <p class="text-center">
                            Hi, <b><?php echo ucfirst($first_name['first_name']) . " " . ucfirst($last_name['last_name']) ?></b><br>
                            Your account isn't registered yet.<br>
                            Please register your account now!
                        </p>
                    </div>
                    <div class="input-group">
                        <?php
                        echo form_hidden($first_name);
                        echo form_hidden($last_name);
                        echo form_hidden($identity);
                        ?>
                    </div>
                    <div class="input-group mb-3">
                        <?php echo form_input($password); ?>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <?php echo form_input($password_confirm); ?>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <!-- <div class="col-8">
                        <div class="icheck-primary">
                            <?php echo form_checkbox('terms', 'agree', FALSE, 'id="agreeTerms"'); ?>
                            <label for="agreeTerms">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div> -->
                        <!-- /.col -->
                        <div class="col">
                            <button type="submit" class="btn btn-info btn-block"><i class="fas fa-user-plus mr-2"></i>Register</button>
                        </div>
                        <div class="col">
                            <a href="<?php echo base_url('cancel') ?>" class="btn btn-block btn-default"><i class="fas fa-chevron-left mr-2"></i>Cancel</a>
                        </div>
                        <!-- /.col -->
                    </div>
                    <?php echo form_close() ?>

                    <!-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p> -->
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
    <?php else : ?>
        <?php redirect('home', 'refresh') ?>
    <?php endif ?>

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
            $('#alert-message').delay(2500).slideUp(1500);
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