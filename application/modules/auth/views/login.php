<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo @$judul . " | " . @$deskripsi ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

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
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo base_url() ?>"><b>CIA </b>HMVC</a>
        </div>

        <!-- alert flashdata -->
        <?php echo (empty(@$message) ? flash_msg(@$this->session->flashdata('message'), @$this->session->flashdata('type')) : @$message) ?>

        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><b>Sign in to start your session</b></p>

                <?php echo form_open(uri_string()) ?>
                <div class="input-group mb-3">
                    <?php echo form_input($identity); ?>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <?php echo form_input($password); ?>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="icheck-primary">
                            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt mr-2"></i> Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?php echo form_close() ?>

                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <!-- <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a> -->
                    <a href="<?php echo $authURL; ?>" class="btn btn-block btn-danger">
                        <i class="fab fa-google mr-2"></i> Sign in with Google
                    </a>
                </div>
                <!-- /.social-auth-links -->

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

    <!-- jQuery -->
    <script src="<?php echo base_url() . "assets/plugins/jquery/jquery.min.js" ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url() . "assets/plugins/bootstrap/js/bootstrap.bundle.min.js" ?>"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url() . "assets/icheck/icheck.min.js" ?>"></script>
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