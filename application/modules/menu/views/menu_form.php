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
                    <form class="form-horizontal" action="<?php echo $action; ?>" method="<?php echo $method; ?>">
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <?php
                                    $array_name = array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "name",
                                        "id" => "name",
                                        "placeholder" => "Name",
                                        "value" => $name
                                    );
                                    echo form_input($array_name); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">URL</label>
                                <div class="col-sm-10">
                                    <?php
                                    $array_url = array(
                                        "type" => "text",
                                        "class" => "form-control",
                                        "name" => "url",
                                        "id" => "url",
                                        "placeholder" => "Url",
                                        "value" => $url
                                    );
                                    echo form_input($array_url); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Icon</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <?php
                                        $array_icon = array(
                                            "type" => "text",
                                            "class" => "form-control iconpicker",
                                            "data-input-search" => "true",
                                            "data-placement" => "bottomRight",
                                            "data-component" => ".input-group-append, .input-group-prepend",
                                            "name" => "icon",
                                            "id" => "icon",
                                            "placeholder" => "Icon",
                                            "style" => "cursor:pointer",
                                            "value" => $icon
                                        );
                                        echo form_input($array_icon); ?>
                                        <div class="input-group-append">
                                            <span class="input-group-text" style="cursor: pointer"><i class="fas fa-archive"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Active</label>
                                <div class="col-sm-10">
                                    <?php
                                    $options = array(
                                        "1" => "ACTIVE",
                                        "0" => "INACTIVE"
                                    );
                                    echo form_dropdown('active', $options, $active, 'name="active" id="active" class="form-control select2"'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Is Admin</label>
                                <div class="col-sm-10">
                                    <?php
                                    $options = array(
                                        "1" => "YES",
                                        "0" => "NO"
                                    );
                                    echo form_dropdown('is_admin', $options, $is_admin, 'name="is_admin" id="is_admin" class="form-control select2"'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Parent</label>
                                <div class="col-sm-10">
                                    <select name="parent" class="form-control select2">
                                        <option value="0">YES</option>
                                        <?php $menu = $this->db->get('menu');
                                        foreach ($menu->result() as $m) : ?>
                                            <?php
                                            echo "<option value='$m->id' ";
                                            echo $m->id == $parent ? 'selected' : '';
                                            echo ">" .  strtoupper($m->name) . "</option>";
                                            ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />

                        </div>
                        <!-- /.card body -->

                        <div class="card-footer">
                            <button type="submit" name="<?php echo $button ?>" class="btn btn-primary"><i class="fa fa-check mr-1"></i> Submit</button>
                            <a href="<?php echo site_url("menu") ?>" type="button" class="btn btn-default float-right"><i class="fa fa-chevron-left mr-1"></i> Back</a>
                        </div>
                        <!-- /.card-footer -->
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