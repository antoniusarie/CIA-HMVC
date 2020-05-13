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
          <form class="form-horizontal">
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
                <label class="col-sm-3 col-form-label"><?php echo lang('edit_group_name_label'); ?></label>
                <div class="col-sm-8">
                  <?php foreach ($groups as $group) : ?>
                    <label class="checkcard-inline">
                      <?php
                      $gID = $group['id'];
                      $checked = null;
                      $item = null;
                      foreach ($currentGroups as $grp) {
                        if ($gID == $grp->id) {
                          $checked = ' checked="checked"';
                          break;
                        }
                      }
                      ?>
                      <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>" <?php echo $checked; ?> disabled>
                      <b><?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?></b>
                    </label>
                  <?php endforeach ?>
                </div>
              </div>

            </div><!-- /.card-body -->
          </form>

          <div class="card-footer">
            <a href="<?php echo base_url('users'); ?>" type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</a>
              <h6 class="float-right">Powered by <i><b>Ion Auth</b></i></h6>
          </div>

        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->