<?php $user = $this->ion_auth->user()->row(); ?>
<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <?php if (!empty($user->img_name)) : ?>
                <img src="<?php echo base_url() . 'assets/upload/img/' . $user->img_name; ?>" class="img-circle elevation-2" alt="User Image">
            <?php else : ?>
                <img src="<?php echo base_url() . 'assets/dist/img/logoStikom.png'; ?>" class="img-circle elevation-2" alt="User Image">
            <?php endif ?>
        </div>
        <div class="info">
            <a href="<?php echo base_url('profile') ?>" class="d-block"><?php echo $user->username ?></a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-flat nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

            <?php // Menu dinamis tiga layer
            $menu = $this->db->get_where('menu', array('parent' => 0, 'active' => 1));

            // layer ke satu
            foreach ($menu->result() as $m) {
                $submenu = $this->db->get_where('menu', array('parent' => $m->id, 'active' => 1));
                // cek ada sub menu
                if ($submenu->num_rows() > 0) {
                    // tampilkan submenu
                    $active = $this->uri->segment(1) == $m->name ? 'active' : '';
                    echo "\t\t\t" . '<li class="nav-item has-treeview">' . "\n";
                    echo "\t\t\t\t" . '<a href="' . base_url($m->url) . '" class="nav-link ' . $active . '">' . "\n";
                    echo "\t\t\t\t\t" . '<i class="nav-icon  ' . $m->icon . '"></i><p>' . ucfirst($m->name) . '</p><i class="right fas fa-angle-left"></i>' . "\n";
                    echo "\t\t\t\t" . '</a>' . "\n";
                    echo "\t\t\t\t" . '<ul class="nav nav-treeview">' . "\n";

                    // layer ke dua
                    foreach ($submenu->result() as $s) {
                        $sub = $this->db->get_where('menu', array('parent' => $s->id, 'active' => 1));
                        // cek ada sub-submenu
                        if ($sub->num_rows() > 0) {
                            // tampilkan sub-submenu
                            $active = $this->uri->segment(1) == $s->name ? 'active' : '';
                            echo "\t\t\t\t\t" . '<li class="nav-item has-treeview">' . "\n";
                            echo "\t\t\t\t\t\t" . '<a href="' . base_url($s->url) . '" class="nav-link ' . $active . '">' . "\n";
                            echo "\t\t\t\t\t\t\t" . '<i class="nav-icon ' . $s->icon . '"></i><p>' . ucfirst($s->name) . '</p><i class="right fas fa-angle-left"></i>' . "\n";
                            echo "\t\t\t\t\t\t" . '</a>' . "\n";
                            echo "\t\t\t\t\t\t" . '<ul class="nav nav-treeview">' . "\n";

                            // layer ke tiga
                            foreach ($sub->result() as $c) {
                                $active = $this->uri->segment(1) == $c->name ? 'active' : '';
                                echo "\t\t\t\t\t\t\t" . '<li class="nav-item">' . "\n";
                                echo "\t\t\t\t\t\t\t\t" . '<a href="' . base_url($c->url) . '" class="nav-link ' . $active . '">' . "\n";
                                echo "\t\t\t\t\t\t\t\t\t" . '<i class="nav-icon ' . $c->icon . '"></i><p>' . ucfirst($c->name) . '</p>' . "\n";
                                echo "\t\t\t\t\t\t\t\t" . '</a>' . "\n";
                                echo "\t\t\t\t\t\t\t" . '</li>' . "\n";
                            }

                            echo "\t\t\t\t\t\t" . '</ul>' . "\n";
                            echo "\t\t\t\t\t" . '</li>' . "\n";
                        } else {
                            $active = $this->uri->segment(1) == $s->name ? 'active' : '';
                            echo "\t\t\t\t\t" . '<li class="nav-item">' . "\n";
                            echo "\t\t\t\t\t\t" . '<a href="' . base_url($s->url) . '" class="nav-link ' . $active . '">' . "\n";
                            echo "\t\t\t\t\t\t\t" . '<i class="nav-icon ' . $s->icon . '"></i><p>' . ucfirst($s->name) . '</p>' . "\n";
                            echo "\t\t\t\t\t\t" . '</a>' . "\n";
                            echo "\t\t\t\t\t" . '</li>' . "\n";
                        }
                    }

                    echo "\t\t\t\t" . '</ul>' . "\n";
                    echo "\t\t\t" . '</li>' . "\n";
                } else {
                    $active = $this->uri->segment(1) == $m->name ? 'active' : '';
                    echo '<li class="nav-item">' . "\n";
                    echo "\t\t\t\t" . '<a href="' . base_url($m->url) . '" class="nav-link ' . $active . '">' . "\n";
                    echo "\t\t\t\t\t" . '<i class="nav-icon ' . $m->icon . '"></i><p>' . ucfirst($m->name) . '</p>' . "\n";
                    echo "\t\t\t\t" . '</a>' . "\n";
                    echo "\t\t\t" . '</li>' . "\n";
                }
            }
            ?>

            <?php if ($this->ion_auth->is_admin()) : ?>
                <li class="nav-item has-treeview <?php echo $this->uri->segment(1) == 'menu' || $this->uri->segment(1) == 'users' || $this->uri->segment(1) == 'groups' || $this->uri->segment(1) == 'crud' ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Control Panel</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('menu') ?>" class="nav-link <?php echo $this->uri->segment(1) == 'menu' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('users') ?>" class="nav-link <?php echo $this->uri->segment(1) == 'users' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('groups') ?>" class="nav-link <?php echo $this->uri->segment(1) == 'groups' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Group</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('crud') ?>" class="nav-link <?php echo $this->uri->segment(1) == 'crud' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-code"></i>
                                <p>CRUD</p>
                                <!-- <p>CRUD<span class="right badge badge-danger">New</span></p> -->
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif ?>

            <li class="nav-item">
                <a href="<?php echo base_url("profile") ?>" class="nav-link <?php echo $this->uri->segment(1) == 'profile' ? 'active' : '' ?>">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>Profile</p>
                </a>
            </li>
            <li class="nav-header">EXIT</li>
            <li class="nav-item">
                <a href="<?php echo base_url('logout'); ?>" class="nav-link">
                    <i class="nav-icon fa fa-sign-out"></i>
                    <p>Sign Out</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>