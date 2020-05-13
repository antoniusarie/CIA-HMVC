<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6">

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-code mr-1"></i> <?php echo @$deskripsi ?></h3>
                    </div>

                    <!-- Horizontal Form -->
                    <?php echo form_open(uri_string(), 'id="crud" class="form-horizontal"'); ?>

                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Table Name</label>
                            <div class="col-sm-8">
                                <select id="tables_name" name="table_name" class="form-control select2">
                                    <option value="">Please Select</option>
                                    <?php foreach ($table_name as $table_list) : ?>
                                        <option value="<?php echo $table_list ?>"><?php echo $table_list ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Controllers Name</label>
                            <div class="col-sm-8">
                                <?php echo form_input($controller); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Models Name</label>
                            <div class="col-sm-8">
                                <?php echo form_input($model); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Views Title</label>
                            <div class="col-sm-8">
                                <?php echo form_input($view_title); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Views Subtitle</label>
                            <div class="col-sm-8">
                                <?php echo form_input($view_subtitle); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-3">
                                <?php echo form_checkbox($is_admin, FALSE) ?>
                                <b style="margin-left: 6px">Is Admin</b>
                                <sup id="tooltip"><i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="If checked, only admin group can access menu and view page"></i></sup>
                            </div>
                        </div>

                    </div><!-- /.card-body -->

                    <div class="card-footer">
                        <a href="<?php echo base_url(uri_string()); ?>" type="button" name="refresh" id="refresh" class="btn btn-default"><i class="fa fa-refresh"></i> Refresh</a>
                        <button type="button" name="generate" id="generate" data-toggle="modal" data-target="#generate-crud" class="btn btn-primary float-right"><i class="fa fa-code"></i> Generate</button>
                    </div>
                    <?php echo confirm_submit("generate-crud", "Confirmation !", "CRUD Generator", "Selected module and menu will be auto-generated !") ?>
                    <?php echo form_close() ?>
                    <!-- /form -->

                </div><!-- /.card -->
            </div><!-- /.col -->

            <div class="col-lg-6">

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-bolt mr-1"></i> Results</h3>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <!-- flashdata crud results -->
                        <?php if ($this->session->flashdata('crud')) : ?>
                            <?php foreach ($this->session->flashdata('crud') as $crud) : ?>
                                <?php echo $crud ?><br>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div><!-- /.card-body -->

                    <div class="card-footer">
                        <div class="col text-right">
                            <h6>Powered by <i><b>Harviacode</b></i></h6>
                        </div>
                    </div><!-- /.card-footer -->

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script type="text/javascript">
    function capitalize(s) {
        return s && s[0].toUpperCase() + s.slice(1);
    }
    $("#generate").prop('disabled', true);
    $("#tables_name").on("change", function() {
        var table_name = $("#tables_name").val();
        if (table_name != '') {
            $("#generate").prop('disabled', false);
            $("#controllers").val(capitalize(table_name));
            $("#models").val(capitalize(table_name) + "_model");
            $("#views").val(capitalize(table_name));
        } else {
            $("#controllers, #models, #views").val('');
            $("#generate").prop('disabled', true);
        }
    });
</script>