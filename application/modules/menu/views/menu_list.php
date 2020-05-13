
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">

                    <div class="card">
                        <div class="card-header">
                            <?php echo anchor('menu/create', '<i class="fa fa-plus mr-1"></i> Create', array('class' => 'btn btn-success')); ?>
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="4%">No</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">URL</th>
                                        <th class="text-center">Icon</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Parent</th>
                                        <th class="text-center">Is Admin</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $start = 0;
                                    foreach ($menu_data as $menu) : ?>
                                        <tr>
                                            <td><?php echo ++$start ?></td>
                                            <td><?php echo $menu->name ?></td>
                                            <td><?php echo $menu->url ?></td>
                                            <td><?php echo $menu->icon ?></td>
                                            <td class="text-center">
                                                <?php echo ($menu->active) ? anchor("menu/deactivate/" . $menu->id, 'Active', array('title' => 'status', 'class' => 'btn btn-success btn-sm')) : anchor("menu/activate/" . $menu->id, 'Inactive', array('title' => 'status', 'class' => 'btn btn-danger btn-sm')); ?>
                                            </td>
                                            <td><?php echo $menu->parent_name ?></td>
                                            <td class="text-center">
                                                <?php echo ($menu->is_admin) ? '<button class="btn btn-sm btn-primary">YES</button>' : '<button class="btn btn-sm btn-danger">NO</button>'; ?>
                                            </td>
                                            <td class="text-center" width="140px">
                                                <?php echo anchor(site_url('menu/read/' . $menu->id), '<i class="fa fa-eye"></i>', array('title' => 'detail', 'class' => 'btn btn-info btn-sm')) ?>
                                                <?php echo anchor(site_url('menu/update/' . $menu->id), '<i class="fa fa-pencil-square-o"></i>', array('title' => 'edit', 'class' => 'btn btn-warning btn-sm')) ?>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#menu-<?php echo $menu->id ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                            <?php echo confirm(base_url('menu/delete/' . $menu->id), "menu-" . $menu->id, "Confirmation !", "Are you sure ?", "<b>" . $menu->name . "</b> will be deleted, and can't be recover !") ?>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
