
	
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
		  <a class="brand" href="#">Manajemen User</a>
		  <div class="nav-collapse">
			<ul class="nav">
			  <li><a href="<?php echo base_url(); ?>app_admin_manage_user/tambah" class="small-box"><i class="icon-plus-sign icon-white"></i> Tambah User</a></li>
			</ul>
		  </div>
		</div>
	  </div><!-- /navbar-inner -->
	</div><!-- /navbar -->
  
	  <section>
  <table class="table table-hover table-condensed">
    <thead>
      <tr>
        <th>No.</th>
        <th>Username</th>
        <th>Nama Lengkap</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
	<?php
		$no=$tot+1;
		foreach($status_pegawai->result_array() as $dp)
		{
	?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $dp['username']; ?></td>
        <td><?php echo $dp['nama_pengguna']; ?></td>
		<td>
	        <div class="btn-group">
	          <a class="btn small-box" href="<?php echo base_url(); ?>app_admin_manage_user/detail/<?php echo $dp['id_user_login']; ?>"><i class="icon-ok-circle"></i> Lihat Detail</a>
	          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="<?php echo base_url(); ?>app_admin_manage_user/edit/<?php echo $dp['id_user_login']; ?>" class="small-box"><i class="icon-pencil"></i> Edit Data</a></li>
	            <li><a href="<?php echo base_url(); ?>app_admin_manage_user/hapus/<?php echo $dp['id_user_login']; ?>" onClick="return confirm('Anda yakin..???');"><i class="icon-trash"></i> Hapus Data</a></li>
	          </ul>
	        </div><!-- /btn-group -->
		</td>
      </tr>
	 <?php
	 		$no++;
	 	}
	 ?>
    </tbody>
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

