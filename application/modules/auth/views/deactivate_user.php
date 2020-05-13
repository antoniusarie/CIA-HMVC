<!-- Main content -->
<section class='content'>

  <div class='row'>
  <div class='col-sm-12 col-md-6'>
  <div class='box box-default'>
  <div class='box-header with-border'>
    <div class="row">
      <div class="col-sm-4">
        <h4><i class="fa fa-users"></i><b> <?php echo @$judul . $user->username; ?> </b></h4>
      </div>
      <div class="col-sm-8 text-right">
        <h6 class="text-right">Powered by <i><b>Ion Auth</b></i></h6>
      </div>
    </div>
  </div><!-- /.box-header -->

	<?php echo form_open("auth/deactivate/".$user->id, 'class="form-horizontal"');?>
	<div class="box-body">

  	<div class="form-group">
    <label class="col-sm-3 control-label">Deactivate User ?</label>
    	<div class="col-sm-8">
    		<label class="radio radio-inline"><input type="radio" name="confirm" value="yes" checked="checked" />Yes</label>
    		<label class="radio radio-inline"><input type="radio" name="confirm" value="no" />No</label>
    	</div>
    </div>

	<?php echo form_hidden($csrf); ?>
	<?php echo form_hidden(array('id'=>$user->id)); ?>

  </div><!-- /.box-body -->
  <div class="box-footer">
    <div class="row">
      <div class="col-sm-12 col-md-4">
        <button type="submit" name="deactivate_submit_btn" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
      </div>
      <div class="col-sm-12 col-md-8 text-right">
        <a href="<?php echo base_url('users'); ?>" type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</a>
      </div>
    </div>
  </div>

  <?php echo form_close();?>

  </div><!-- /.box -->
  </div><!-- /.col -->
  </div><!-- /.row -->

</section>

<script type="text/javascript">
  $(document).ready(function () {

    /* alert messages 2 */
      <?php if($message != '') { ?>
        $('#alert-message').slideDown(1500);
        $('#alert-message').delay(2500).slideUp(1500);
      <?php } ?>

    });
</script>