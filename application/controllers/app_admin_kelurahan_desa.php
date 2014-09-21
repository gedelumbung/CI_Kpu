<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin_kelurahan_desa extends CI_Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Controller untuk manajemen kelurahan/desa
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
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->query("select * from tbl_kelurahan_desa a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten left join tbl_kecamatan c on a.id_kecamatan=c.id_kecamatan where a.id_kabupaten='".$id_ses_kab."' and a.id_kecamatan='".$id_ses_kec."'");
			$config['base_url'] = base_url() . 'app_admin_kelurahan_desa/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->query("select * from tbl_kelurahan_desa a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten left join tbl_kecamatan c on a.id_kecamatan=c.id_kecamatan where a.id_kabupaten='".$id_ses_kab."' and a.id_kecamatan='".$id_ses_kec."' 
			LIMIT ".$offset.",".$limit."");
			
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$id_sel_kab['id_kabupaten'] = $id_ses_kab;
			$d['data_kecamatan'] = $this->db->get_where("tbl_kecamatan",$id_sel_kab);
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/kelurahan_desa/home");
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
			$d['id_param'] = "";
			$d['nama_kelurahan_desa'] = "";
			$d['id_kabupaten'] = "";
			$d['id_kecamatan'] = "";
			$d['st'] = "tambah";
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			
			$this->load->view("app_admin/kelurahan_desa/input",$d);
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
			$id_get['id_kelurahan_desa'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_kelurahan_desa",$id_get)->row();
			$d['id_param'] = $dt->id_kelurahan_desa;
			$d['nama_kelurahan_desa'] = $dt->nama_kelurahan_desa;
			$d['id_kabupaten'] = $dt->id_kabupaten;
			$d['id_kecamatan'] = $dt->id_kecamatan;
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			$d['st'] = "edit";
			
			$this->load->view("app_admin/kelurahan_desa/input",$d);
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
			$id_get['id_kelurahan_desa'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_kelurahan_desa",$id_get)->row();
			$d['id_param'] = $dt->id_kecamatan;
			$d['nama_kelurahan_desa'] = $dt->nama_kelurahan_desa;
			$d['id_kabupaten'] = $dt->id_kabupaten;
			$d['id_kecamatan'] = $dt->id_kecamatan;
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			$d['st'] = "edit";
			
			$this->load->view("app_admin/kelurahan_desa/detail",$d);
		}
	}

	public function simpan()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$this->form_validation->set_rules('id_kabupaten', 'Nama Kabupaten', 'trim|required');
			$this->form_validation->set_rules('id_kecamatan', 'Nama Kecamatan', 'trim|required');
			$this->form_validation->set_rules('nama_kelurahan_desa', 'Nama Kelurahan/Desa', 'trim|required');
			$id['id_kelurahan_desa'] = $this->input->post("id_param");
			
			if ($this->form_validation->run() == FALSE)
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$q = $this->db->get_where("tbl_kelurahan_desa",$id);
					$d = array();
					foreach($q->result() as $dt)
					{
						$d['id_param'] = $dt->id_kelurahan_desa;
						$d['nama_kelurahan_desa'] = $dt->nama_kelurahan_desa;
						$d['id_kabupaten'] = $dt->id_kabupaten;
						$d['id_kecamatan'] = $dt->id_kecamatan;
					}
					$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
					$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
					$d['st'] = $st;
					$this->load->view('app_admin/kelurahan_desa/input',$d);
				}
				else if($st=="tambah")
				{
					$d['id_param'] = "";
					$d['nama_kelurahan_desa'] = "";
					$d['id_kabupaten'] = "";
					$d['id_kecamatan'] = "";
					$d['st'] = $st;
					$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
					$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
					
					$this->load->view("app_admin/kelurahan_desa/input",$d);
				}
			}
			else
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$upd['id_kabupaten'] = $this->input->post("id_kabupaten");
					$upd['id_kecamatan'] = $this->input->post("id_kecamatan");
					$upd['nama_kelurahan_desa'] = $this->input->post("nama_kelurahan_desa");
					$this->db->update("tbl_kelurahan_desa",$upd,$id);
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
					$in['nama_kelurahan_desa'] = $this->input->post("nama_kelurahan_desa");
					$this->db->insert("tbl_kelurahan_desa",$in);
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
			$this->session->unset_userdata($set_sess);
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->query("select * from tbl_kelurahan_desa a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten left join tbl_kecamatan c on 
			a.id_kecamatan=c.id_kecamatan where nama_kelurahan_desa like '%".$kata."%'");
			$config['base_url'] = base_url() . 'app_admin_kelurahan_desa/cari/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->query("select * from tbl_kelurahan_desa a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten left join tbl_kecamatan c on 
			a.id_kecamatan=c.id_kecamatan where nama_kelurahan_desa like '%".$kata."%' LIMIT ".$offset.",".$limit."");
			
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/kelurahan_desa/home");
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
			$id['id_kelurahan_desa'] = $this->uri->segment(3);
			$this->db->delete("tbl_kelurahan_desa",$id);
			header('location:'.base_url().'app_admin_kelurahan_desa');
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
			$query = $this->db->query("delete from tbl_kelurahan_desa where id_kelurahan_desa IN (".$id.")");
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
			$this->session->set_userdata($set_sess);
			header('location:'.base_url().'app_admin_kelurahan_desa');
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
			<select data-placeholder="Pilih Kecamatan..." class="chzn-select" style="width:300px;" tabindex="2" name="id_kecamatan" id="id_kecamatan">
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
			<script type="text/javascript">$(".chzn-select").chosen();</script>
			<div class="cleaner_h10"></div>
			<?php
		}
		else
		{
			header('location:'.base_url().'');
		}
	}
}

/* End of file app_admin_kelurahan_desa.php */
/* Location: ./application/controllers/app_admin_kelurahan_desa.php */