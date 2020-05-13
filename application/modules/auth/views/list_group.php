<!-- Main content -->
<div class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col">

        <div class="card">

          <div class="card-header">
            <h3 class="card-title">
              <?php echo anchor('group/create', '<i class="fa fa-users mr-1"></i> Create Group', 'class="btn btn-success"'); ?>
            </h3>
          </div>

          <div class='card-body'>

            <table class="table table-bordered table-striped" id="mytable">
              <thead>
                <tr>
                  <th class="text-center" width="4%">No</th>
                  <th class="text-center"><?php echo lang('edit_group_name_label', 'group_name'); ?></th>
                  <th class="text-center"><?php echo lang('edit_group_desc_label', 'description'); ?></th>
                  <th class="text-center"><?php echo lang('index_action_th'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($groups as $group) : ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($group->description, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-center" width="140px">
                      <?php echo anchor("group/read/" . $group->id, '<i class="fa fa-eye"></i>', array('title' => 'read', 'class' => 'btn btn-info btn-sm')) ?>
                      <?php echo anchor("group/edit/" . $group->id, '<i class="fa fa-pencil-square-o"></i>', array('title' => 'update', 'class' => 'btn btn-warning btn-sm')) ?>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#group-<?php echo $group->id ?>"><i class="fas fa-trash"></i></button>
                    </td>
                    <?php echo confirm(base_url('group/delete' . $group->id), "group-" . $group->id, "Confirmation !", "Are you sure ?", "<b>" . $group->name . "</b> will be deleted, and can't be recover !") ?>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>

          </div><!-- /.card-body -->

          <div class="card-footer">
            <div class="col text-right">
              <h6 class="float-right">Powered by <i><b>Ion Auth</b></i></h6>
            </div>
          </div><!-- /.card-footer-->

        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->