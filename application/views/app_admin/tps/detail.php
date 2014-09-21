
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
		<?php echo form_open('app_admin_tps/simpan','class="form-horizontal"'); ?>
		  <div class="control-group">
		  	<legend>Master TPS</legend>
			<label class="control-label" for="nama_hukuman">Nama TPS</label>
			<div class="controls">
			  <input type="text" class="span" name="nama_tps" id="nama_tps" value="<?php echo $nama_tps; ?>" placeholder="Nama TPS" disabled>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama Kabupaten</label>
			<div class="controls">
			  <select data-placeholder="Pilih Kabupaten..." class="chzn-select" style="width:300px;" tabindex="2" name="id_kabupaten" id="id_kabupaten" disabled>
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
				<?php
					if($st=="edit")
					{
						$id['id_kabupaten'] = $id_kabupaten;
						$data_kecamatan = $this->db->get_where("tbl_kecamatan",$id);
						?>
						<select data-placeholder="Pilih Kecamatan..." class="chzn-select2" style="width:300px;" tabindex="2" name="id_kecamatan" id="id_kecamatan" disabled>
							<option value=""></option>
							<?php
								foreach($data_kecamatan->result() as $d)
								{
									if($id_kecamatan==$d->id_kecamatan)
									{
								?>
									<option value="<?php echo $d->id_kecamatan; ?>" selected="selected"><?php echo $d->nama_kecamatan; ?></option>
								<?php
									}
									else
									{
								?>
									<option value="<?php echo $d->id_kecamatan; ?>"><?php echo $d->nama_kecamatan; ?></option>
								<?php
									}
								}
							?>
						</select>
						<script>
						$(".chzn-select2").chosen().change(function(){ 
								var id_kecamatan = $("#id_kecamatan").val(); 
								$.ajax({ 
								url: "<?php echo base_url(); ?>app_admin_tps/set_kecamatan_get_kelurahan", 
								data: "id_kecamatan="+id_kecamatan, 
								cache: false, 
								success: function(msg){ 
								$("#datatps").empty();
								$("#datatps").html(msg); 
							} 
						})
						});
					</script>
						<?php
					}
				?>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama Kelurahan/Desa</label>
			<div class="controls" id="datatps">
				<?php
					if($st=="edit")
					{
						$id2['id_kabupaten'] = $id_kabupaten;
						$id2['id_kecamatan'] = $id_kecamatan;
						$data_kelurahan = $this->db->get_where("tbl_kelurahan_desa",$id2);
						?>
						<select data-placeholder="Pilih Kelurahan..." class="chzn-select3" style="width:300px;" tabindex="2" name="id_kelurahan_desa" id="id_kelurahan_desa" disabled>
							<option value=""></option>
							<?php
								foreach($data_kelurahan->result() as $d2)
								{
									if($id_kelurahan_desa==$d2->id_kelurahan_desa)
									{
								?>
									<option value="<?php echo $d2->id_kelurahan_desa; ?>" selected="selected"><?php echo $d2->nama_kelurahan_desa; ?></option>
								<?php
									}
									else
									{
								?>
									<option value="<?php echo $d2->id_kelurahan_desa; ?>"><?php echo $d2->nama_kelurahan_desa; ?></option>
								<?php
									}
								}
							?>
						</select>
						<script type="text/javascript">$(".chzn-select3").chosen();</script>
						<?php
					}
				?>
			</div>
		  </div>
		  <input type="hidden" name="id_param" value="<?php echo $id_param; ?>">
		  <input type="hidden" name="st" value="<?php echo $st; ?>">
		  <div class="control-group">
			<div class="controls">
			  <button type="submit" class="btn btn-primary">Simpan Data</button>
			  <button type="reset" class="btn">Hapus Data</button>
			</div>
		  </div>
		<script>
			$(".chzn-select").chosen().change(function(){ 
					var id_kabupaten = $("#id_kabupaten").val(); 
					$.ajax({ 
					url: "<?php echo base_url(); ?>app_admin_tps/set_kabupaten_get_kecamatan", 
					data: "id_kabupaten="+id_kabupaten, 
					cache: false, 
					success: function(msg){ 
					$("#datatps").empty();
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
