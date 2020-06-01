<!DOCTYPE html>
<html>
<head>
    <title><?php echo @$judul . ' | ' . @$deskripsi ?></title>

    <!-- meta --><?php echo @$meta ?>

    <!-- css --><?php echo @$css ?>

    <!-- js --><?php echo @$js ?>

    </head>
    <body class="hold-transition sidebar-mini accent-gray text-sm">

    <div class="wrapper">
        <!-- navbar --><?php echo @$nav ?>

        <!-- main sidebar --><?php echo @$header ?>

        <!-- sidebar --><?php echo @$sidebar ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- content header --><?php echo @$content_header ?>

            <!-- main page content --><?php echo @$contents ?>

        </div><!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <!-- <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div> -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- footer --><?php echo @$footer ?>

    </div> <!-- wrapper -->

    <!-- js plugins --><?php echo @$plugins ?>

    </body>
</html>