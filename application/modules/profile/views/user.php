<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3">

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo @$deskripsi ?></h3>
                    </div>

                    <!-- Profile Image -->
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <?php if (!empty($user->img_name)) : ?>
                                <img class="profile-user-img img-responsive img-circle mb-3" src="<?php echo base_url() . 'assets/upload/img/' . $user->img_name; ?>" alt="User profile picture">
                            <?php else : ?>
                                <img class="profile-user-img img-responsive img-circle mb-3" src="<?php echo base_url() . 'assets/dist/img/logoStikom.png' ?>" alt="User profile picture">
                            <?php endif ?>
                        </div>

                        <h3 class="profile-username text-center"><?php echo $user->username; ?></h3>

                        <p class="text-muted text-center"><b><?php echo $currentGroups->name; ?></b></p>

                        <ul class="list-group list-group-unbordered mb-2">
                            <li class="list-group-item">
                                <b>NPM</b> <a class="float-right">14187003</a>
                            </li>
                            <li class="list-group-item">
                                <b>Aktivasi</b> <a class="float-right"><?php echo date('l, d M Y', $user->created_on); ?></a>
                            </li>
                        </ul>
                    </div><!-- .card-body -->
                </div>
                <!-- /.card -->

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Photos</h3>
                    </div>

                    <div class="card-body">
                        <?php echo form_open_multipart(base_url('profile/image/' . $user->id)) ?>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <?php echo form_upload('foto') ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- .card-body -->

                    <div class="card-footer">
                        <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary float-right', 'content' => '<i class="fas fa-upload"></i> Upload')) ?>
                    </div><!-- .card-footer -->

                    <?php echo form_close() ?>

                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->

            <div class="col-lg-6">

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Update</h3>
                    </div>

                    <?php echo form_open(uri_string(), 'class="form-horizontal"') ?>
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('edit_user_fname_label', 'first_name'); ?></label>
                            <div class="col-sm-8">
                                <?php echo form_input($first_name); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('edit_user_lname_label', 'last_name'); ?></label>
                            <div class="col-sm-8">
                                <?php echo form_input($last_name); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('edit_user_username_label', 'username'); ?></label>
                            <div class="col-sm-8">
                                <?php echo form_input($username); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('edit_user_company_label', 'company'); ?></label>
                            <div class="col-sm-8">
                                <?php echo form_input($company); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('edit_user_email_label', 'email'); ?></label>
                            <div class="col-sm-8">
                                <?php echo form_input($email); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo lang('edit_user_phone_label', 'phone'); ?></label>
                            <div class="col-sm-8">
                                <?php echo form_input($phone); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-3">
                                <?php echo form_checkbox('checkbox', 1, FALSE, 'id="check-password"') ?>
                                <b class="ml-1">Update Password</b>
                                <sup id="tooltip"><i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="Check this to update your password!"></i></sup>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password:</label>
                            <div class="col-sm-8">
                                <?php echo form_input($password); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Confirm Password:</label>
                            <div class="col-sm-8">
                                <?php echo form_input($password_confirm); ?>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-check-circle"></i> Submit</button>
                    </div>

                    <?php echo form_hidden('id', $user->id); ?>
                    <?php echo form_close() ?>

                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->