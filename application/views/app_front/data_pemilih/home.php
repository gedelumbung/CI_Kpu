
	
    <div class="container">
	<div class="well">
	  <div class="row">
		<div class="span">
		  <h3><?php echo $this->config->item("nama_perusahaan"); ?></h3>
		  <p><?php echo $this->config->item("alamat_perusahaan"); ?></p>
		</div>
	  </div>
	</div>
	

  <div class="well">
	<div class="navbar navbar-inverse">
	  <div class="navbar-inner">
		<div class="container">
		  <a class="brand" href="#">Data Pemilih Tetap</a>
		<div class="span5 pull-right">
		<?php echo form_open("app_front/cari",'class="navbar-form pull-right"'); ?>
		  <input type="text" class="span3" placeholder="Masukkan kata kunci..." name="cari">
		  <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Cari Data</button>
		<?php echo form_close(); ?>
		</div>
		</div>
	  </div><!-- /navbar-inner -->
	</div><!-- /navbar -->

  
	  <section>
	<?php echo form_open("app_front/set",'name="frm_filter"'); ?>
	<p class="span2">
		Kabupaten :
		<select data-placeholder="Pilih Kabupaten..." class="chzn-select" style="width:90%;" tabindex="2" name="id_kabupaten" id="id_kabupaten">
		<option value=""></option>
		<?php
			foreach($data_kabupaten->result_array() as $d)
			{
				if($this->session->userdata("id_kabupaten_session")==$d['id_kabupaten'])
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
	</p>
	<p class="span2">
		Kecamatan :
		<select data-placeholder="Pilih Kecamatan..." class="chzn-select" style="width:90%;" tabindex="2" name="id_kecamatan" id="id_kecamatan">
		<option value=""></option>
		<?php
			foreach($data_kecamatan->result_array() as $d)
			{
				if($this->session->userdata("id_kecamatan_session")==$d['id_kecamatan'])
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
	</p>
	<p class="span2">
		Kelurahan :
		<select data-placeholder="Pilih Kelurahan/Desa..." class="chzn-select" style="width:90%;" tabindex="2" name="id_kelurahan_desa" id="id_kelurahan_desa">
		<option value=""></option>
		<?php
			foreach($data_kelurahan->result_array() as $d)
			{
				if($this->session->userdata("id_kelurahan_session")==$d['id_kelurahan_desa'])
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
	</p>
	<p class="span2">
		NIK/KTP :
		<input type="text" name="nik" value="<?php echo $this->session->userdata("id_nik"); ?>" style="width:90%;">
	</p>
	<p class="span2">
		Nama Pemilih :
		<input type="text" name="nama_pemilih" value="<?php echo $this->session->userdata("id_nama"); ?>" style="width:90%;">
	</p>
	<p class="span1">
		<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Cari</button>
	</p>
		<script>
			$(".chzn-select").chosen().change(function(){ 
				document.forms["frm_filter"].submit();
			});
		</script>
	<?php echo form_close(); ?>
	<div style="clear:both; width:100%;"></div>
 		<section>
		  <table class="table table-hover table-condensed">
		    <thead>
		      <tr>
		        <th>No.</th>
		        <th>NIK/KTP</th>
		        <th>Nama Lengkap</th>
		        <th>Tempat Lahir</th>
				<th>Tanggal Lahir</th>
				<th>Aksi</th>
		      </tr>
		    </thead>
		    <tbody>
		<?php
			$no=1+$tot;
			foreach($data_get->result_array() as $dp)
			{
			?>
		      <tr>
		        <td><?php echo $no; ?></td>
		        <td><?php echo $dp['nik_ktp']; ?></td>
		        <td><?php echo $dp['nama_lengkap']; ?></td>
		        <td><?php echo $dp['tempat_lahir']; ?></td>
		        <td><?php echo $dp['tanggal_lahir']; ?></td>
				<td>
			        <div class="btn-group">
			          <a class="btn small-box" href="<?php echo base_url(); ?>app_front/detail/<?php echo $dp['id_data_pemilih']; ?>"><i class="icon-ok-circle"></i> Detail</a>
			        </div><!-- /btn-group -->
				</td>
		      </tr>
			 <?php
			 		$no++;
			 	}
			 ?>
		    </tbody>
		  </table>
		</section>
	<div class="pagination pagination-centered">
		<ul>
		<?php
			echo $paginator;
		?>
		</ul>
	</div>
	
  

</section>
  </div>


