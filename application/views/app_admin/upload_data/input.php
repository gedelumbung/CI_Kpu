
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/docs.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/chosen.css" rel="stylesheet">
	<style>
		body{
			margin:20px;
			}
	</style>
	
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/bootstrap/js/application.js"></script>
    <script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/chosen.jquery.js"></script>
  </head>

  <body>
	<div class="well">
	<?php if(validation_errors()) { ?>
	<div class="alert alert-block">
	  <button type="button" class="close" data-dismiss="alert">×</button>
	  	<h4>Terjadi Kesalahan!</h4>
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
		<?php echo form_open_multipart('app_admin_upload_data/simpan','class="form-horizontal"'); ?>
		  <div class="control-group">
		  	<legend>Upload Data</legend>
			<label class="control-label" for="nama_hukuman">Nama Kabupaten</label>
			<div class="controls">
			  <select data-placeholder="Pilih Kabupaten..." class="chzn-select" style="width:300px;" tabindex="2" name="id_kabupaten" id="id_kabupaten">
			  	<option value=""></option>
				<?php
					foreach($data_kabupaten->result_array() as $d)
					{
						if($id_kabupaten==$d['id_kabupaten'])
						{
				?>
					<option value="<?php echo $d['id_kabupaten']; ?>" selected="selected"><?php echo $d['nama_kabupaten']; ?></option>
				<?php
						}
						else
						{
				?>
					<option value="<?php echo $d['id_kabupaten']; ?>"><?php echo $d['nama_kabupaten']; ?></option>
				<?php
						}
					}
				?>
			  </select>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama Kecamatan</label>
			<div class="controls" id="datakecamatan">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama Kelurahan</label>
			<div class="controls" id="datakelurahan">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama TPS</label>
			<div class="controls" id="datatps">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Pilih File</label>
			<div class="controls">
				<input type="file" name="userfile">
			</div>
		  </div>
		  <div class="control-group">
			<div class="controls">
			  <button type="submit" class="btn btn-primary">Upload Data</button>
			</div>
		  </div>
		<script>
			$(".chzn-select").chosen().change(function(){ 
					var id_kabupaten = $("#id_kabupaten").val(); 
					$.ajax({ 
					url: "<?php echo base_url(); ?>app_admin_upload_data/set_kabupaten_get_kecamatan", 
					data: "id_kabupaten="+id_kabupaten, 
					cache: false, 
					success: function(msg){ 
					$("#datatps").empty();
					$("#datakelurahan").empty();
					$("#datakecamatan").empty();
					$("#datakecamatan").html(msg); 
				} 
			})
			});
		</script>
		<?php echo form_close(); ?>
	</div>    
	
  </body>
</html>
