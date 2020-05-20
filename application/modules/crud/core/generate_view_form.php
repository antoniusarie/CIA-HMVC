<?php
$string = "
    <!-- Main content -->
    <div class=\"content\">
    <div class=\"container-fluid\">

    <div class=\"row\">
    <div class=\"col-lg-6\">

    <div class=\"card card-secondary\">
      <div class=\"card-header\">
        <h3 class=\"card-title\"><?php echo @\$deskripsi ?></h3>
      </div>

      <!-- Horizontal Form -->
      <form class=\"form-horizontal\" action=\"<?php echo \$action; ?>\" method=\"<?php echo \$method; ?>\">

      <div class=\"card-body\">";
foreach ($non_pk as $row) {
    if ($row["data_type"] == 'text' || $row["data_type"] == 'char' || $row["data_type"] == 'varchar') {
        $string .= "\n\t\t
        <div class=\"form-group row\">
          <label class=\"col-sm-3 col-form-label\">". label($row["column_name"]) ."</label>
            <div class=\"col-sm-8\">
            <?php
            \$array_".strtolower($row["column_name"])." = array(
              \"type\"=>\"text\",
              \"class\"=>\"form-control\",
              \"name\"=>\"". $row["column_name"]."\",
              \"id\"=>\"".$row["column_name"]."\",
              \"placeholder\"=>\"".label($row["column_name"])."\",
              \"value\"=>\$".$row["column_name"]."
              );
            echo form_input(\$array_".strtolower($row["column_name"])."); ?>
          </div>
        </div>";
    } elseif ($row["data_type"] == 'date' || $row["data_type"] == 'datetime') {
        $string .= "\n\t\t
        <div class=\"form-group row\">
          <label class=\"col-sm-3 col-form-label\">". label($row["column_name"]) ."</label>
            <div class=\"col-sm-8\">
            <?php
            \$array_".strtolower($row["column_name"])." = array(
              \"type\"=>\"date\",
              \"class\"=>\"form-control\",
              \"name\"=>\"". $row["column_name"]."\",
              \"id\"=>\"".$row["column_name"]."\",
              \"placeholder\"=>\"".label($row["column_name"])."\",
              \"value\"=>\$".$row["column_name"]."
              );
            echo form_input(\$array_".strtolower($row["column_name"])."); ?>
          </div>
        </div>";
    } else {
        $string .= "\n\t\t
        <div class=\"form-group row\">
          <label class=\"col-sm-3 col-form-label\">". label($row["column_name"]) ."</label>
            <div class=\"col-sm-8\">
            <?php
            \$array_".strtolower($row["column_name"])." = array(
              \"type\"=>\"text\",
              \"class\"=>\"form-control\",
              \"name\"=>\"". $row["column_name"]."\",
              \"id\"=>\"".$row["column_name"]."\",
              \"placeholder\"=>\"".label($row["column_name"])."\",
              \"value\"=>\$".$row["column_name"]."
              );
            echo form_input(\$array_".strtolower($row["column_name"]). "); ?>
          </div>
        </div>";
    }
}
$string .= "\n\t    <input type=\"hidden\" name=\"" . $pk . "\" value=\"<?php echo $" . $pk . "; ?>\" /> ";
$string .= "\n\t
      </div>
      <!-- /.card-body -->

      <div class=\"card-footer\">
        <button type=\"submit\" name=\"<?php echo \$button ?>\" class=\"btn btn-primary\"><i class=\"fa fa-check mr-1\"></i> Submit</button>
        <a href=\"<?php echo site_url(\"" . $c_url . "\") ?>\" type=\"button\" class=\"btn btn-default float-right\"><i class=\"fa fa-chevron-left mr-1\"></i> Back</a>
      </div>
      <!-- /.card-footer -->

      </form>

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

$modular_path = $target . $c_url ."/views/". $v_form_file;
$result_view_form = generate_crud($string, $modular_path);
