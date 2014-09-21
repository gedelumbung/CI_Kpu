<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin_data_pemilih extends CI_Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Controller untuk manajemen data pemilih
	 **/
	 
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'app_admin');
		}
		else
		{
			$id_ses_kab = $this->session->userdata("id_kabupaten_session");
			$id_ses_kec = $this->session->userdata("id_kecamatan_session");
			$id_ses_kel  = $this->session->userdata("id_kelurahan_session");
			$id_ses_tps  = $this->session->userdata("id_tps_session");
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->query("select * from tbl_data_pemilih a where a.id_kabupaten='".$id_ses_kab."' 
			and a.id_kecamatan='".$id_ses_kec."' and a.id_kelurahan_desa='".$id_ses_kel."' and a.id_tps='".$id_ses_tps."'");
			
			$config['base_url'] = base_url() . 'app_admin_data_pemilih/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->query("select * from tbl_data_pemilih a where a.id_kabupaten='".$id_ses_kab."' 
			and a.id_kecamatan='".$id_ses_kec."' and a.id_kelurahan_desa='".$id_ses_kel."' and a.id_tps='".$id_ses_tps."' LIMIT ".$offset.",".$limit."");
			
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$id_sel_kab['id_kabupaten'] = $id_ses_kab;
			$d['data_kecamatan'] = $this->db->get_where("tbl_kecamatan",$id_sel_kab);
			$id_sel_kab_kec['id_kabupaten'] = $id_ses_kab;
			$id_sel_kab_kec['id_kecamatan'] = $id_ses_kec;
			$d['data_kelurahan'] = $this->db->get_where("tbl_kelurahan_desa",$id_sel_kab_kec);
			$id_sel_kab_kec_kel['id_kabupaten'] = $id_ses_kab;
			$id_sel_kab_kec_kel['id_kecamatan'] = $id_ses_kec;
			$id_sel_kab_kec_kel['id_kelurahan_desa'] = $id_ses_kel;
			$d['data_tps'] = $this->db->get_where("tbl_tps",$id_sel_kab_kec_kel);
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/data_pemilih/home");
			$this->load->view("app_admin/global/footer");
		}
	}
	 
	public function tambah()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'app_admin');
		}
		else
		{
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
			$d['data_tp'] = $this->db->get("tbl_tps");
			$d['st'] = "tambah";
			$d['id_param'] = "";
			
			$this->load->view("app_admin/data_pemilih/input",$d);
		}
	}
	 
	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'app_admin');
		}
		else
		{
			$id_get['id_data_pemilih'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_data_pemilih",$id_get)->row();
			$d['id_param'] = $dt->id_data_pemilih;
			$d['id_kabupaten'] = $dt->id_kabupaten;
			$d['id_kecamatan'] = $dt->id_kecamatan;
			$d['id_kelurahan_desa'] = $dt->id_kelurahan_desa;
			$d['id_tps'] = $dt->id_tps;
			$d['nik_ktp'] = $dt->nik_ktp;
			$d['nama_lengkap'] = $dt->nama_lengkap;
			$d['tempat_lahir'] = $dt->tempat_lahir;
			$d['tanggal_lahir'] = $dt->tanggal_lahir;
			$d['umur'] = $dt->umur;
			$d['stts_perkawinan'] = $dt->stts_perkawinan;
			if($dt->jk_l=="")
			{
				$d['kelamin'] = $dt->jk_p;
			}
			else
			{
				$d['kelamin'] = $dt->jk_l;
			}
			$d['alamat'] = $dt->alamat;
			$d['keterangan'] = $dt->keterangan;

			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
			$d['data_tps'] = $this->db->get("tbl_tps");
			$d['st'] = "edit";
			
			$this->load->view("app_admin/data_pemilih/edit",$d);
		}
	}
	 
	public function detail()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'app_admin');
		}
		else
		{
			$id_get['id_data_pemilih'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_data_pemilih",$id_get)->row();
			$d['id_param'] = $dt->id_data_pemilih;
			$d['id_kabupaten'] = $dt->id_kabupaten;
			$d['id_kecamatan'] = $dt->id_kecamatan;
			$d['id_kelurahan_desa'] = $dt->id_kelurahan_desa;
			$d['id_tps'] = $dt->id_tps;
			$d['nik_ktp'] = $dt->nik_ktp;
			$d['nama_lengkap'] = $dt->nama_lengkap;
			$d['tempat_lahir'] = $dt->tempat_lahir;
			$d['tanggal_lahir'] = $dt->tanggal_lahir;
			$d['umur'] = $dt->umur;
			$d['stts_perkawinan'] = $dt->stts_perkawinan;
			if($dt->jk_l=="")
			{
				$d['kelamin'] = $dt->jk_p;
			}
			else
			{
				$d['kelamin'] = $dt->jk_l;
			}
			$d['alamat'] = $dt->alamat;
			$d['keterangan'] = $dt->keterangan;

			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
			$d['data_tps'] = $this->db->get("tbl_tps");
			$d['st'] = "edit";
			
			$this->load->view("app_admin/data_pemilih/detail",$d);
		}
	}

	public function simpan()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$this->form_validation->set_rules('id_kabupaten', 'Nama Kabupaten', 'trim|required');
			$this->form_validation->set_rules('id_kecamatan', 'Nama Kecamatan', 'trim|required');
			$this->form_validation->set_rules('id_kelurahan_desa', 'Nama Kelurahan/Desa', 'trim|required');
			$this->form_validation->set_rules('id_tps', 'Nama TPS', 'trim|required');
			$this->form_validation->set_rules('nik_ktp', 'NIK/KTP', 'trim|required');
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
			$this->form_validation->set_rules('umur', 'Umur', 'trim|required');
			$this->form_validation->set_rules('stts_perkawinan', 'Status Perkawinan', 'trim|required');
			$this->form_validation->set_rules('kelamin', 'Jenis Kelamin', 'trim|required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
			$id['id_data_pemilih'] = $this->input->post("id_param");
			
			if ($this->form_validation->run() == FALSE)
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$dt = $this->db->get_where("tbl_data_pemilih",$id)->row();
					$d['id_param'] = $dt->id_data_pemilih;
					$d['id_kabupaten'] = $dt->id_kabupaten;
					$d['id_kecamatan'] = $dt->id_kecamatan;
					$d['id_kelurahan_desa'] = $dt->id_kelurahan_desa;
					$d['id_tps'] = $dt->id_tps;
					$d['nik_ktp'] = $dt->nik_ktp;
					$d['nama_lengkap'] = $dt->nama_lengkap;
					$d['tempat_lahir'] = $dt->tempat_lahir;
					$d['tanggal_lahir'] = $dt->tanggal_lahir;
					$d['umur'] = $dt->umur;
					$d['stts_perkawinan'] = $dt->stts_perkawinan;
					if($dt->jk_l=="")
					{
						$d['kelamin'] = $dt->jk_p;
					}
					else
					{
						$d['kelamin'] = $dt->jk_l;
					}
					$d['alamat'] = $dt->alamat;
					$d['keterangan'] = $dt->keterangan;

					$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
					$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
					$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
					$d['data_tps'] = $this->db->get("tbl_tps");
					$d['st'] = "edit";
					
					$this->load->view("app_admin/data_pemilih/edit",$d);
				}
				else if($st=="tambah")
				{
					$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
					$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
					$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
					$d['data_tp'] = $this->db->get("tbl_tps");
					$d['st'] = "tambah";
					$d['id_param'] = "";
					$this->load->view("app_admin/data_pemilih/input",$d);
				}
			}
			else
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$in['id_kabupaten'] = $this->input->post("id_kabupaten");
					$in['id_kecamatan'] = $this->input->post("id_kecamatan");
					$in['id_kelurahan_desa'] = $this->input->post("id_kelurahan_desa");
					$in['id_tps'] = $this->input->post("id_tps");
					$in['nik_ktp'] = $this->input->post("nik_ktp");
					$in['nama_lengkap'] = $this->input->post("nama_lengkap");
					$in['tempat_lahir'] = $this->input->post("tempat_lahir");
					$in['tanggal_lahir'] = $this->input->post("tanggal_lahir");
					$in['umur'] = $this->input->post("umur");
					$in['stts_perkawinan'] = $this->input->post("stts_perkawinan");
					$kelamin = $this->input->post("kelamin");
					$in['jk_l'] = "";
					$in['jk_p'] = "";
					if($kelamin=="laki")
					{
						$in['jk_l'] = "Lk";
						$in['jk_p'] = "";
					}
					else if($kelamin=="wanita")
					{
						$in['jk_l'] = "";
						$in['jk_p'] = "Pr";
					}
					$in['alamat'] = $this->input->post("alamat");
					$in['keterangan'] = $this->input->post("keterangan");
					$this->db->update("tbl_data_pemilih",$in,$id);
					?>
						<script>
							window.parent.location.reload(true);
						</script>
					<?php
				}
				else if($st=="tambah")
				{
					$in['id_kabupaten'] = $this->input->post("id_kabupaten");
					$in['id_kecamatan'] = $this->input->post("id_kecamatan");
					$in['id_kelurahan_desa'] = $this->input->post("id_kelurahan_desa");
					$in['id_tps'] = $this->input->post("id_tps");
					$in['nik_ktp'] = $this->input->post("nik_ktp");
					$in['nama_lengkap'] = $this->input->post("nama_lengkap");
					$in['tempat_lahir'] = $this->input->post("tempat_lahir");
					$in['tanggal_lahir'] = $this->input->post("tanggal_lahir");
					$in['umur'] = $this->input->post("umur");
					$in['stts_perkawinan'] = $this->input->post("stts_perkawinan");
					$kelamin = $this->input->post("kelamin");
					$in['jk_l'] = "";
					$in['jk_p'] = "";
					if($kelamin=="laki")
					{
						$in['jk_l'] = "Lk";
						$in['jk_p'] = "";
					}
					else if($kelamin=="wanita")
					{
						$in['jk_l'] = "";
						$in['jk_p'] = "Pr";
					}
					$in['alamat'] = $this->input->post("alamat");
					$in['keterangan'] = $this->input->post("keterangan");
					$this->db->insert("tbl_data_pemilih",$in);
					?>
						<script>
							window.parent.location.reload(true);
						</script>
					<?php
				}
			
			}
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function cari()
	{
		if($this->session->userdata('logged_in')!="")
		{
			if($this->input->post("cari")=="")
			{
				$kata = $this->session->userdata('kata');
			}
			else
			{
				$sess_data['kata'] = $this->input->post("cari");
				$this->session->set_userdata($sess_data);
				$kata = $this->session->userdata('kata');
			}
			
			$set_sess['id_kabupaten_session'] = $this->session->userdata("id_kabupaten_session");
			$set_sess['id_kecamatan_session'] = $this->session->userdata("id_kecamatan_session");
			$set_sess['id_kelurahan_session'] = $this->session->userdata("id_kelurahan_session");
			$set_sess['id_tps_session'] = $this->session->userdata("id_tps_session");
			$this->session->unset_userdata($set_sess);
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->query("select * from tbl_data_pemilih where nama_lengkap like '%".$kata."%'");
			$config['base_url'] = base_url() . 'app_admin_data_pemilih/cari/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->query("select * from tbl_data_pemilih where nama_lengkap like '%".$kata."%' LIMIT ".$offset.",".$limit."");
			
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
			$d['data_tps'] = $this->db->get("tbl_tps");
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/data_pemilih/home");
			$this->load->view("app_admin/global/footer");
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function hapus()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$id['id_data_pemilih'] = $this->uri->segment(3);
			$this->db->delete("tbl_data_pemilih",$id);
			header('location:'.base_url().'app_admin_data_pemilih');
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function hapus_multiple()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$id = $this->input->post('kode');
			$query = $this->db->query("delete from tbl_data_pemilih where id_data_pemilih IN (".$id.")");
			if($query){
				echo 1;
			}
			else{
				echo 0;
			}
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function set()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$set_sess['id_kabupaten_session'] = $this->input->post("id_kabupaten");
			$set_sess['id_kecamatan_session'] = $this->input->post("id_kecamatan");
			$set_sess['id_kelurahan_session'] = $this->input->post("id_kelurahan_desa");
			$set_sess['id_tps_session'] = $this->input->post("id_tps");
			$this->session->set_userdata($set_sess);
			header('location:'.base_url().'app_admin_data_pemilih');
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function set_kabupaten_get_kecamatan()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$id['id_kabupaten'] = $_GET['id_kabupaten'];
			$data_kecamatan = $this->db->get_where("tbl_kecamatan",$id);
			?>
			<select data-placeholder="Pilih Kecamatan..." class="chzn-select-kecamatan" style="width:300px;" tabindex="2" name="id_kecamatan" id="id_kecamatan">
				<option value=""></option>
				<?php
					foreach($data_kecamatan->result() as $d)
					{
					?>
						<option value="<?php echo $d->id_kecamatan; ?>"><?php echo $d->nama_kecamatan; ?></option>
					<?php
					}
				?>
		  	</select>
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
			<div class="cleaner_h10"></div>
			<?php
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function set_kecamatan_get_kelurahan()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$id['id_kecamatan'] = $_GET['id_kecamatan'];
			$data_kelurahan = $this->db->get_where("tbl_kelurahan_desa",$id);
			?>
			<select data-placeholder="Pilih Kelurahan/Desa..." class="chzn-select-kelurahan" style="width:300px;" tabindex="2" name="id_kelurahan_desa" id="id_kelurahan_desa">
				<option value=""></option>
				<?php
					foreach($data_kelurahan->result() as $d)
					{
					?>
						<option value="<?php echo $d->id_kelurahan_desa; ?>"><?php echo $d->nama_kelurahan_desa; ?></option>
					<?php
					}
				?>
		  	</select>
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
			<div class="cleaner_h10"></div>
			<?php
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function set_kelurahan_get_tps()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$id['id_kelurahan_desa'] = $_GET['id_kelurahan_desa'];
			$data_tps = $this->db->get_where("tbl_tps",$id);
			?>
			<select data-placeholder="Pilih TPS..." class="chzn-select-tps" style="width:300px;" tabindex="2" name="id_tps" id="id_tps">
				<option value=""></option>
				<?php
					foreach($data_tps->result() as $d)
					{
					?>
						<option value="<?php echo $d->id_tps; ?>"><?php echo $d->nama_tps; ?></option>
					<?php
					}
				?>
		  	</select>
			<script type="text/javascript">$(".chzn-select-tps").chosen();</script>
			<div class="cleaner_h10"></div>
			<?php
		}
		else
		{
			header('location:'.base_url().'');
		}
	}
}

/* End of file app_admin_data_pemilih.php */
/* Location: ./application/controllers/app_admin_data_pemilih.php */