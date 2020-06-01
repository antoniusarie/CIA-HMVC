<!-- alert flashdata -->
<?php // echo (empty(@$message) ? flash_msg(@$this->session->flashdata('message'), @$this->session->flashdata('type')) : @$message) ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?php echo @$judul; ?></h1>
                <!-- <small><?php // echo @$deskripsi;
                            ?></small> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php
                    for ($i = 0; $i < count($this->session->flashdata('segment')); $i++) {
                        if ($i == 0) { ?>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home mr-2"></i>Home</a></li>
                        <?php } elseif ($i == (count($this->session->flashdata('segment')) - 1)) { ?>
                            <li class="breadcrumb-item ml-2">
                                <?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?>
                            </li>
                            <li class="ml-2"> / </li>
                            <li class="breadcrumb-item ml-2">
                                <a href="<?php site_url($this->session->flashdata('segment')[$i]); ?>">#<?php echo ucwords(str_replace("_", " ", $this->session->flashdata('segment')[$i])) ?></a>
                            </li>
                        <?php } else { ?>
                            <li class="ml-2"> / </li>
                        <?php }
                        if ($i == 0 && $i == (count($this->session->flashdata('segment')) - 1)) { ?>
                            <li class="breadcrumb-item active"><a href="<?php site_url($this->session->flashdata('segment')); ?>"><?php echo @$judul; ?></a></li>
                    <?php
                        }
                    }
                    ?>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->