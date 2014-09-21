
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
		<?php echo form_open_multipart('app_admin_data_pemilih/simpan','class="form-horizontal"'); ?>
		  <div class="control-group">
		  	<legend>Data Pemilih Tetap</legend>
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
			<select data-placeholder="Pilih Kecamatan..." class="chzn-select-kecamatan" style="width:300px;" tabindex="2" name="id_kecamatan" id="id_kecamatan" disabled>
			  	<option value=""></option>
				<?php
					foreach($data_kecamatan->result_array() as $d)
					{
						if($id_kecamatan==$d['id_kecamatan'])
						{
				?>
					<option value="<?php echo $d['id_kecamatan']; ?>" selected="selected"><?php echo $d['nama_kecamatan']; ?></option>
				<?php
						}
						else
						{
				?>
					<option value="<?php echo $d['id_kecamatan']; ?>"><?php echo $d['nama_kecamatan']; ?></option>
				<?php
						}
					}
				?>
			  </select>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama Kelurahan</label>
			<div class="controls" id="datakelurahan">
			<select data-placeholder="Pilih Kelurahan/Desa..." class="chzn-select-kelurahan" style="width:300px;" tabindex="2" name="id_kelurahan_desa" id="id_kelurahan_desa" disabled>
			  	<option value=""></option>
				<?php
					foreach($data_kelurahan->result_array() as $d)
					{
						if($id_kelurahan_desa==$d['id_kelurahan_desa'])
						{
				?>
					<option value="<?php echo $d['id_kelurahan_desa']; ?>" selected="selected"><?php echo $d['nama_kelurahan_desa']; ?></option>
				<?php
						}
						else
						{
				?>
					<option value="<?php echo $d['id_kelurahan_desa']; ?>"><?php echo $d['nama_kelurahan_desa']; ?></option>
				<?php
						}
					}
				?>
			  </select>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama TPS</label>
			<div class="controls" id="datatps">
			<select data-placeholder="Pilih TPS..." class="chzn-select-tps" style="width:300px;" tabindex="2" name="id_tps" id="id_tps" disabled>
			  	<option value=""></option>
				<?php
					foreach($data_tps->result_array() as $d)
					{
						if($id_tps==$d['id_tps'])
						{
				?>
					<option value="<?php echo $d['id_tps']; ?>" selected="selected"><?php echo $d['nama_tps']; ?></option>
				<?php
						}
						else
						{
				?>
					<option value="<?php echo $d['id_tps']; ?>"><?php echo $d['nama_tps']; ?></option>
				<?php
						}
					}
				?>
			  </select>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">NIK/KTP</label>
			<div class="controls">
				<input type="text" style="width:300px;" name="nik_ktp" value="<?php echo $nik_ktp; ?>" disabled>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Nama Lengkap</label>
			<div class="controls">
				<input type="text" style="width:300px;" name="nama_lengkap" value="<?php echo $nama_lengkap; ?>" disabled>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Tempat Lahir</label>
			<div class="controls">
				<input type="text" style="width:300px;" name="tempat_lahir" value="<?php echo $tempat_lahir; ?>" disabled>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Tanggal Lahir</label>
			<div class="controls">
				<input type="text" style="width:300px;" name="tanggal_lahir" placeholder="Tanggal-Bulan-Tahun" value="<?php echo $tanggal_lahir; ?>" disabled>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Umur</label>
			<div class="controls">
				<input type="text" style="width:300px;" name="umur" value="<?php echo $umur; ?>" disabled>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Status Perkawinan</label>
			<div class="controls">
				<input type="text" style="width:300px;" name="stts_perkawinan" value="<?php echo $stts_perkawinan; ?>" disabled>
			</div>
		  </div>
		  <div class="control-group">
		  <?php
		  	$laki = '';
		  	$wanita = '';
		  	if($kelamin=="Pr")
		  	{
			  	$laki = '';
			  	$wanita = 'checked';
		  	}
		  	else if($kelamin=="Lk")
		  	{
			  	$laki = 'checked';
			  	$wanita = '';
		  	}
		  ?>
			<label class="control-label" for="nama_hukuman">Jenis Kelamin</label>
			<div class="controls">
			<label class="radio">
				<input type="radio" name="kelamin" value="laki" <?php echo $laki; ?> disabled>Laki-Laki
			</label>
			<label class="radio">
				<input type="radio" name="kelamin" value="wanita" <?php echo $wanita; ?> disabled>Wanita
			</label>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Alamat</label>
			<div class="controls">
				<textarea style="width:350px; height:200px;" name="alamat" disabled><?php echo $alamat; ?></textarea>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="nama_hukuman">Keterangan</label>
			<div class="controls">
				<textarea style="width:350px; height:200px;" name="keterangan" disabled><?php echo $keterangan; ?></textarea>
			</div>
		  </div>
		<script>
			$(".chzn-select").chosen().change(function(){ 
					var id_kabupaten = $("#id_kabupaten").val(); 
					$.ajax({ 
					url: "<?php echo base_url(); ?>app_admin_data_pemilih/set_kabupaten_get_kecamatan", 
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
		<script>
				$(".chzn-select-kecamatan").chosen().change(function(){ 
						var id_kecamatan = $("#id_kecamatan").val(); 
						$.ajax({ 
						url: "<?php echo base_url(); ?>app_admin_data_pemilih/set_kecamatan_get_kelurahan", 
						data: "id_kecamatan="+id_kecamatan, 
						cache: false, 
						success: function(msg){ 
						$("#datatps").empty();
						$("#datakelurahan").empty();
						$("#datakelurahan").html(msg); 
					} 
				})
				});
			</script>
		<script>
				$(".chzn-select-kelurahan").chosen().change(function(){ 
						var id_kelurahan_desa = $("#id_kelurahan_desa").val(); 
						$.ajax({ 
						url: "<?php echo base_url(); ?>app_admin_data_pemilih/set_kelurahan_get_tps", 
						data: "id_kelurahan_desa="+id_kelurahan_desa, 
						cache: false, 
						success: function(msg){ 
						$("#datatps").empty();
						$("#datatps").html(msg); 
					} 
				})
				});
			</script>
			<script type="text/javascript">$(".chzn-select-tps").chosen();</script>
		<?php echo form_close(); ?>
	</div>    
	
  </body>
</html>
