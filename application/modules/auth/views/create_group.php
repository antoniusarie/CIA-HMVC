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
              <label class="col-sm-3 col-form-label"><?php echo lang('create_group_name_label', 'group_name'); ?></label>
              <div class="col-sm-8">
                <?php echo form_input($group_name); ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label"><?php echo lang('create_group_desc_label', 'description'); ?></label>
              <div class="col-sm-8">
                <?php echo form_input($description); ?>
              </div>
            </div>

          </div><!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" name="create_group_submit_btn" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
            <a href="<?php echo base_url('groups'); ?>" type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</a>
            <h6 class="float-right">Powered by <i><b>Ion Auth</b></i></h6>
          </div>

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
