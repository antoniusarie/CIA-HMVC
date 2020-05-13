<?php
$string = "";
$string .= "
    <!-- Main content -->
    <div class=\"content\">
        <div class=\"container-fluid\">

        <div class=\"row\">
        <div class=\"col\">

        <div class=\"card\">
            <div class=\"card-header\">
                <?php echo anchor('" . $c_url . "/create', '<i class=\"fa fa-plus mr-1\"></i> Create', array('class' => 'btn btn-success')); ?>
            </div>

            <div class='card-body'>

            <table class=\"table table-bordered table-striped\" id=\"mytable\">
            <thead>
                <tr>
                    <th width=\"4%\">No</th>";
foreach ($non_pk as $row) {
$string .= "\n\t\t\t\t\t<th class=\"text-center\">" . label($row['column_name']) . "</th>";
}
$string .= "\n\t\t\t\t  <th class=\"text-center\">Action</th>
                </tr>
            </thead>";
$string .= "\n\t\t\t<tbody>
            <?php
            \$start = 0;
            foreach ($" . $c_url . "_data as \$$c_url) :?>
                <tr>";

$string .= "\n\t\t\t\t  <td><?php echo ++\$start ?></td>";

foreach ($non_pk as $row) {
    $string .= "\n\t\t\t\t  <td><?php echo $" .$c_url."->". $row['column_name'] . " ?></td>";
}
$string .= "\n\t\t\t\t  <td style=\"text-align:center\" width=\"140px\">"
        . "\n\t\t\t\t   <?php echo anchor(site_url('".$c_url."/read/'.$".$c_url."->".$pk."),'<i class=\"fa fa-eye\"></i>',array('title'=>'detail','class'=>'btn btn-info btn-sm')) ?>"
        . "\n\t\t\t\t   <?php echo anchor(site_url('".$c_url."/update/'.$".$c_url."->".$pk."),'<i class=\"fa fa-pencil-square-o\"></i>',array('title'=>'edit','class'=>'btn btn-warning btn-sm')) ?>"
        . "\n\t\t\t\t   <button type=\"button\" class=\"btn btn-sm btn-danger\" data-toggle=\"modal\" data-target=\"#" .$c_url. "-<?php echo $".$c_url."->".$pk." ?>\"><i class=\"fas fa-trash\"></i></button>"
        . "\n\t\t\t\t   </td>"
        . "\n\t\t\t\t   <?php echo confirm(base_url('" .$c_url. "/delete/' . $".$c_url."->".$pk. "), \"" .$c_url. "-\" . $" .$c_url. "->" .$pk. ", \"Confirmation !\", \"Are you sure ?\", \"<b>ID#\" . $" .$c_url. "->" .$pk. " . \"</b> will be deleted, and can't be recover !\") ?>"

        . "\n\t\t\t    </tr>
            <?php endforeach ?>
        \t</tbody>
        </table>

        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /.content -->";

$modular_path = $target . $c_url ."/views/". $v_list_file;
$result_view_list = generate_crud($string, $modular_path);
?>