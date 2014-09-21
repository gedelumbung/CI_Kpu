
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
		<section>
		  <table class="table table-hover table-condensed">
		    <thead>
		      <tr>
		        <th>No.</th>
		        <th>NIK/KTP</th>
		        <th>Nama Lengkap</th>
		        <th>Tempat Lahir</th>
				<th>Tanggal Lahir</th>
				<th>Umur</th>
				<th>Status Perkawinan</th>
				<th>Jenis Kelamin</th>
				<th>Alamat</th>
				<th>Keterangan</th>
		      </tr>
		    </thead>
		    <tbody>
		<?php echo $counter; ?>
		<?php
			$no=1;
			foreach($data_tersimpan->result_array() as $dp)
			{
			?>
		      <tr>
		        <td><?php echo $no; ?></td>
		        <td><?php echo $dp['nik_ktp']; ?></td>
		        <td><?php echo $dp['nama_lengkap']; ?></td>
		        <td><?php echo $dp['tempat_lahir']; ?></td>
		        <td><?php echo $dp['tanggal_lahir']; ?></td>
		        <td><?php echo $dp['umur']; ?></td>
		        <td><?php echo $dp['stts_perkawinan']; ?></td>
		        <td><?php if($dp['jk_l']==NULL) { echo $dp['jk_p']; } else { echo $dp['jk_l']; } ?></td>
		        <td><?php echo $dp['alamat']; ?></td>
		        <td><?php echo $dp['keterangan']; ?></td>
		      </tr>
			 <?php
			 		$no++;
			 	}
			 ?>
		    </tbody>
		  </table>
		</section>
	</div>   
  </body>
</html>
