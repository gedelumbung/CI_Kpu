<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item("nama_perusahaan"); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/docs.css" rel="stylesheet">
	
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/bootstrap/js/application.js"></script>
  </head>

  <body>
	    <div class="container">
			<div class="well" style="width:600px; margin:10px auto;">
				<h3 style="text-align:center;"><?php echo $this->config->item("nama_perusahaan"); ?></h3>
				<?php if(validation_errors()) { ?>
				<div class="alert alert-block">
				  <button type="button" class="close" data-dismiss="alert">×</button>
					<h4>Terjadi Kesalahan!</h4>
					<?php echo validation_errors(); ?>
				</div>
				<?php } ?>
				<?php if($this->session->flashdata('result_login')) { ?>
				<div class="alert alert-block">
				  <button type="button" class="close" data-dismiss="alert">×</button>
					<h4>Terjadi Kesalahan!</h4>
					<?php echo $this->session->flashdata('result_login'); ?>
				</div>
				<?php } ?>
				<?php echo form_open('app_admin/login','class="form-horizontal"'); ?>
					<div class="control-group">
						<label class="control-label" for="golongan">Username</label>
						<div class="controls">
							<input type="text" class="span3" name="username" value="<?php echo set_value('username'); ?>" placeholder="Masukkan Username" autocomplete="off">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="golongan">Password</label>
						<div class="controls">
							<input type="password" class="span3" name="password" placeholder="Masukkan Password" autocomplete="off">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="golongan">Captcha</label>
						<div class="controls">
							<p><?php echo $gbr_captcha; ?></p>
							<input type="text" class="span3" name="captcha" placeholder="Masukkan Captcha" autocomplete="off">
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<input type="submit" class="btn btn-primary" value="Log In">
							<input type="reset" class="btn" value="Hapus">
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		<footer class="well" style="width:600px; margin:10px auto; text-align:center;">
        <p><?php echo $this->config->item("lisensi_app"); ?></p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
