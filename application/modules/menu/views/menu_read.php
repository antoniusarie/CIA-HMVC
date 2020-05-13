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
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-8">
                  <?php
                  $array_name = array(
                    "type" => "text",
                    "class" => "form-control",
                    "name" => "name",
                    "id" => "name",
                    "placeholder" => "Name",
                    "readonly" => "readonly",
                    "value" => $name
                  );
                  echo form_input($array_name); ?>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Url</label>
                <div class="col-sm-8">
                  <?php
                  $array_url = array(
                    "type" => "text",
                    "class" => "form-control",
                    "name" => "url",
                    "id" => "url",
                    "placeholder" => "Url",
                    "readonly" => "readonly",
                    "value" => $url
                  );
                  echo form_input($array_url); ?>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Icon</label>
                <div class="col-sm-8">
                  <?php
                  $array_icon = array(
                    "type" => "text",
                    "class" => "form-control",
                    "name" => "icon",
                    "id" => "icon",
                    "placeholder" => "Icon",
                    "readonly" => "readonly",
                    "value" => $icon
                  );
                  echo form_input($array_icon); ?>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-8">
                  <?php
                  $array_active = array(
                    "type" => "text",
                    "class" => "form-control",
                    "name" => "active",
                    "id" => "active",
                    "placeholder" => "Active",
                    "readonly" => "readonly",
                    "value" => ($active == 1 ? 'Active' : 'Inactive')
                  );
                  echo form_input($array_active); ?>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Is Admin</label>
                <div class="col-sm-8">
                  <?php
                  $array_is_admin = array(
                    "type" => "text",
                    "class" => "form-control",
                    "name" => "is_admin",
                    "id" => "is_admin",
                    "placeholder" => "Is Admin",
                    "readonly" => "readonly",
                    "value" => ($is_admin == 1 ? 'YES' : 'NO')
                  );
                  echo form_input($array_is_admin); ?>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Parent</label>
                <div class="col-sm-8">
                  <?php
                  $array_parent = array(
                    "type" => "text",
                    "class" => "form-control",
                    "name" => "parent",
                    "id" => "parent",
                    "placeholder" => "Parent",
                    "readonly" => "readonly",
                    "value" => $parent_name
                  );
                  echo form_input($array_parent); ?>
                </div>
              </div>

            </div><!-- /.box-body -->

            <div class="card-footer">
              <a href="<?php echo base_url('menu'); ?>" type="button" class="btn btn-default"><i class="fa fa-chevron-left mr-1"></i> Back</a>
            </div>

          </form>

        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->