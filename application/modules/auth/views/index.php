<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo anchor('user/create', '<i class="fa fa-user-plus mr-1"></i> Create User', 'class="btn btn-success"'); ?>
                        </h3>
                    </div>

                    <div class='card-body'>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="4%">No</th>
                                    <th class="text-center"><?php echo lang('index_username_th'); ?></th>
                                    <th class="text-center"><?php echo lang('index_fname_th'); ?></th>
                                    <th class="text-center"><?php echo lang('index_lname_th'); ?></th>
                                    <th class="text-center"><?php echo lang('index_email_th'); ?></th>
                                    <th class="text-center"><?php echo lang('index_groups_th'); ?></th>
                                    <th class="text-center"><?php echo lang('index_status_th'); ?></th>
                                    <th class="text-center">Activation</th>
                                    <th class="text-center"><?php echo lang('index_action_th'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-center">
                                            <?php foreach ($user->groups as $group) : ?>
                                                <?php echo '<button class="btn btn-sm btn-primary">' . $group->name . '</button>'; ?>
                                            <?php endforeach ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo ($user->active) ? anchor("deactivate/" . $user->id, 'Active', array('title' => 'status', 'class' => 'btn btn-success btn-sm')) : anchor("activate/" . $user->id, 'Deactivate', array('title' => 'status', 'class' => 'btn btn-danger btn-sm')); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo ($user->activation) ? '<button class="btn btn-sm btn-primary">Completed</button>' : '<button class="btn btn-sm btn-warning">Pending</button>'; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo anchor("user/read/" . $user->id, '<i class="fa fa-eye"></i>', array('title' => 'read', 'class' => 'btn btn-info btn-sm')) ?>
                                            <?php echo anchor("user/edit/" . $user->id, '<i class="fa fa-pencil-square-o"></i>', array('title' => 'update', 'class' => 'btn btn-warning btn-sm')) ?>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#user-<?php echo $user->id ?>"><i class="fas fa-trash"></i></button>
                                        </td>
                                        <?php echo confirm(base_url('user/delete/' . $user->id), "user-" . $user->id, "Confirmation !", "Are you sure ?", "<b>" . $user->first_name . " " . $user->last_name . "</b> will be deleted, and can't be recover !") ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div><!-- /.card-body -->

                    <div class="card-footer">
                        <div class="col text-right">
                            <h6>Powered by <i><b>Ion Auth</b></i></h6>
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