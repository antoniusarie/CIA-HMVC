    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            <?php echo ucfirst($this->session->userdata('username')); ?>
        </div>
        <!-- Default to the left -->
        <b>Version</b> 1.1.0 - <?php echo anchor(site_url(), '<b>Company Name</b>') . ' - Copyright &copy;' . date("Y"); ?>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->