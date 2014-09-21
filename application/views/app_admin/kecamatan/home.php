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
			url:'<?php echo base_url(); ?>app_admin_kecamatan/hapus_multiple',
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
		  <a class="brand" href="#">Data Kecamatan</a>
		  <div class="nav-collapse">
			<ul class="nav">
			  <li><a href="<?php echo base_url(); ?>app_admin_kecamatan/tambah" class="small-box"><i class="icon-plus-sign icon-white"></i> Tambah Data Kecamatan</a></li>
			</ul>
		  </div>
		<div class="span5 pull-right">
		<?php echo form_open("app_admin_kecamatan/cari",'class="navbar-form pull-right"'); ?>
		  <input type="text" class="span3" placeholder="Masukkan kata kunci..." name="cari">
		  <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Cari Data</button>
		<?php echo form_close(); ?>
		</div>
		</div>
	  </div><!-- /navbar-inner -->
	</div><!-- /navbar -->
  
	  <section>
	<?php echo form_open("app_admin_kecamatan/set",'name="frm_filter"'); ?>
	<p class="span3">
		Kabupaten :
		<select data-placeholder="Pilih Kabupaten..." class="chzn-select" style="width:180px;" tabindex="2" name="id_kabupaten" id="id_kabupaten">
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
		<script>
			$(".chzn-select").chosen().change(function(){ 
				document.forms["frm_filter"].submit();
			});
		</script>
	<?php echo form_close(); ?>
	<div style="clear:both; width:100%;"></div>
  <table class="table table-hover table-condensed">
    <thead>
      <tr>
        <th></th>
        <th>No.</th>
        <th>Nama Kecamatan</th>
        <th>Nama Kabupaten</th>
		<th>Aksi</th>
      </tr>
    </thead>
    <tbody>
	<?php
		$no=$tot+1;
		$no2=1;
		foreach($data_get->result_array() as $dp)
		{
	?>
      <tr>
        <td>
		<input type="checkbox" name="chk[]" id="chk-<?php echo $no2; ?>" class="chk" value="<?php echo $dp['id_kecamatan']; ?>" />
		</td>
        <td><?php echo $no; ?></td>
        <td><?php echo $dp['nama_kecamatan']; ?></td>
        <td><?php echo $dp['nama_kabupaten']; ?></td>
		<td>
	        <div class="btn-group">
	          <a class="btn btn-small small-box" href="<?php echo base_url(); ?>app_admin_kecamatan/detail/<?php echo $dp['id_kecamatan']; ?>"><i class="icon-ok-circle"></i> Lihat Detail</a>
	          <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="<?php echo base_url(); ?>app_admin_kecamatan/edit/<?php echo $dp['id_kecamatan']; ?>" class="small-box"><i class="icon-pencil"></i> Edit Data</a></li>
	            <li><a href="<?php echo base_url(); ?>app_admin_kecamatan/hapus/<?php echo $dp['id_kecamatan']; ?>" onClick="return confirm('Anda yakin..???');"><i class="icon-trash"></i> Hapus Data</a></li>
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
	<div class="pagination pagination-centered">
		<ul>
		<?php
			echo $paginator;
		?>
		</ul>
	</div>
	
  

</section>
  </div>


