<script>
$(function(){
	$("a.hapus").click(function(){
	if(confirm("Anda yakin akan menghapus?"))
	{
		id_array=new Array()
		i=0;
		$("input.chk:checked").each(function(){
			id_array[i]=$(this).val();
			i++;
		})

		$.ajax({
			url:'<?php echo base_url(); ?>app_admin_data_pemilih/hapus_multiple',
			data:"kode="+id_array,
			type:"POST",
			success:function(respon)
			{
				if(respon==1)
				{
					$("input.chk:checked").each(function(){
						$(this).parent().parent().remove('.chk').animate({ opacity: "hide" }, "slow");
					})
				}
			}
		})
	}
		return false;
	})
})
</script>
	
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
		  <div class="nav-collapse">
			<ul class="nav">
			  <li><a href="<?php echo base_url(); ?>app_admin_data_pemilih/tambah" class="small-box"><i class="icon-plus-sign icon-white"></i> Tambah Data Pemilih Tetap</a></li>
			</ul>
		  </div>
		<div class="span5 pull-right">
		<?php echo form_open("app_admin_data_pemilih/cari",'class="navbar-form pull-right"'); ?>
		  <input type="text" class="span3" placeholder="Masukkan kata kunci..." name="cari">
		  <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Cari Data</button>
		<?php echo form_close(); ?>
		</div>
		</div>
	  </div><!-- /navbar-inner -->
	</div><!-- /navbar -->
  
	  <section>
	<?php echo form_open("app_admin_data_pemilih/set",'name="frm_filter"'); ?>
	<p class="span2">
		Kabupaten :
		<select data-placeholder="Pilih Kabupaten..." class="chzn-select" style="width:93%;" tabindex="2" name="id_kabupaten" id="id_kabupaten">
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
		<select data-placeholder="Pilih Kecamatan..." class="chzn-select" style="width:93%;" tabindex="2" name="id_kecamatan" id="id_kecamatan">
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
		<select data-placeholder="Pilih Kelurahan/Desa..." class="chzn-select" style="width:93%;" tabindex="2" name="id_kelurahan_desa" id="id_kelurahan_desa">
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
		Daftar TPS :
		<select data-placeholder="Pilih TPS..." class="chzn-select " style="width:93%;" tabindex="2" name="id_tps" id="id_tps">
		<option value=""></option>
		<?php
			foreach($data_tps->result_array() as $d)
			{
				if($this->session->userdata("id_tps_session")==$d['id_tps'])
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
		        <th></th>
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
	 		$no2=1;
			foreach($data_get->result_array() as $dp)
			{
			?>
		      <tr>
		        <td>
				<input type="checkbox" name="chk[]" id="chk-<?php echo $no2; ?>" class="chk" value="<?php echo $dp['id_data_pemilih']; ?>" />
				</td>
		        <td><?php echo $no; ?></td>
		        <td><?php echo $dp['nik_ktp']; ?></td>
		        <td><?php echo $dp['nama_lengkap']; ?></td>
		        <td><?php echo $dp['tempat_lahir']; ?></td>
		        <td><?php echo $dp['tanggal_lahir']; ?></td>
				<td>
			        <div class="btn-group">
			          <a class="btn small-box" href="<?php echo base_url(); ?>app_admin_data_pemilih/detail/<?php echo $dp['id_data_pemilih']; ?>"><i class="icon-ok-circle"></i> Detail</a>
			          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
			          <ul class="dropdown-menu">
			            <li><a href="<?php echo base_url(); ?>app_admin_data_pemilih/edit/<?php echo $dp['id_data_pemilih']; ?>" class="small-box"><i class="icon-pencil"></i> Edit Data</a></li>
			            <li><a href="<?php echo base_url(); ?>app_admin_data_pemilih/hapus/<?php echo $dp['id_data_pemilih']; ?>" onClick="return confirm('Anda yakin..???');"><i class="icon-trash"></i> Hapus Data</a></li>
			          </ul>
			        </div><!-- /btn-group -->
				</td>
		      </tr>
			 <?php
			 		$no++;
	 				$no2++;
			 	}
			 ?>
		    </tbody>
		    <tr><td colspan="7" align="right">
		    <div class="span2">
			<label for="pilih" class="radio"><input type=radio id=pilih name="pilih" onClick='for (i=1;i<<?php echo $no2; ?>;i++){document.getElementById("chk-"+i).checked=true;}'> Check All</label>
			</div>

		    <div class="span2">
			<label for="nopilih" class="radio"><input type=radio id=nopilih name="pilih" onClick='for (i=1;i<<?php echo $no2; ?>;i++){document.getElementById("chk-"+i).checked=false;}'> Uncheck All</label>
			</div>

			<div class="span2">
			<a href="#" class="btn btn-primary hapus"><div class="btn-delete">Hapus Data</div></a>
			</div>

			</td></tr>
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


