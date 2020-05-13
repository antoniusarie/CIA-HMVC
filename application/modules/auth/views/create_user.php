<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6">

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo @$deskripsi ?></h3>
                    </div>

                    <!-- Horizontal Form -->
                    <?php echo form_open(uri_string(), 'class="form-horizontal"'); ?>
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('create_user_fname_label'); ?></label>
                            <div class="col-sm-8">
                                <?php
                                $data_fn = array('id' => 'first_name', 'name' => 'first_name', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'First Name');
                                echo form_input($data_fn);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('create_user_lname_label'); ?></label>
                            <div class="col-sm-8">
                                <?php
                                $data_ln = array('id' => 'last_name', 'name' => 'last_name', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Last Name');
                                echo form_input($data_ln);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">User Name:</label>
                            <div class="col-sm-8">
                                <?php
                                $data_username = array('id' => 'username', 'name' => 'username', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'User Name');
                                echo form_input($data_username);
                                ?>
                            </div>
                        </div>

                        <?php if ($identity_column !== 'email') : ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><?php echo lang('create_user_identity_label'); ?></label>
                                <div class="col-sm-8">
                                    <?php echo form_input($identity, 'class="form-control"'); ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('create_user_email_label'); ?></label>
                            <div class="col-sm-8">
                                <?php
                                $data_email = array('id' => 'email', 'name' => 'email', 'class' => 'form-control', 'type' => 'email', 'placeholder' => 'Email');
                                echo form_input($data_email);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('create_user_company_label'); ?></label>
                            <div class="col-sm-8">
                                <?php
                                $data_company = array('id' => 'company', 'name' => 'company', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Company');
                                echo form_input($data_company);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('create_user_phone_label'); ?></label>
                            <div class="col-sm-8">
                                <?php
                                $data_phone = array('id' => 'phone', 'name' => 'phone', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'Phone');
                                echo form_input($data_phone);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('create_user_password_label'); ?></label>
                            <div class="col-sm-8">
                                <?php
                                $data_pass = array('id' => 'password', 'name' => 'password', 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Password');
                                echo form_input($data_pass);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('create_user_password_confirm_label'); ?></label>
                            <div class="col-sm-8">
                                <?php
                                $data_pass_conf = array('id' => 'password_confirm', 'name' => 'password_confirm', 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Confirm Password');
                                echo form_input($data_pass_conf);
                                ?>
                            </div>
                        </div>

                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" name="create_user_submit_btn" class="btn btn-primary" id="create"><i class="fa fa-check"></i> Submit</button>
                        <a href="<?php echo base_url('users'); ?>" type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</a>
                        <h6 class="float-right">Powered by <i><b>Ion Auth</b></i></h6>
                    </div><!-- /.card-footer-->

                    <?php echo form_close(); ?>

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Dummy  -->
<!-- <script type="text/javascript">
    $("#first_name").val("arie");
    $("#last_name").val("andynar");
    $("#username").val("arie");
    $("#email").val("arie@andynar.id");
    $("#password").val("password");
    $("#password_confirm").val("password");
</script> -->