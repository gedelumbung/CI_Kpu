<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin_kecamatan extends CI_Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Controller untuk manajemen kabupaten
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
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->query("select * from tbl_kecamatan a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten where a.id_kabupaten='".$id_ses_kab."'");
			$config['base_url'] = base_url() . 'app_admin_kecamatan/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->query("select * from tbl_kecamatan a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten where a.id_kabupaten='".$id_ses_kab."' 
			LIMIT ".$offset.",".$limit."");
			
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/kecamatan/home");
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
			$d['nama_kecamatan'] = "";
			$d['id_kabupaten'] = "";
			$d['st'] = "tambah";
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			
			$this->load->view("app_admin/kecamatan/input",$d);
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
			$id_get['id_kecamatan'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_kecamatan",$id_get)->row();
			$d['id_param'] = $dt->id_kecamatan;
			$d['nama_kecamatan'] = $dt->nama_kecamatan;
			$d['id_kabupaten'] = $dt->id_kabupaten;
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['st'] = "edit";
			
			$this->load->view("app_admin/kecamatan/input",$d);
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
			$id_get['id_kecamatan'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_kecamatan",$id_get)->row();
			$d['id_param'] = $dt->id_kecamatan;
			$d['nama_kecamatan'] = $dt->nama_kecamatan;
			$d['id_kabupaten'] = $dt->id_kabupaten;
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['st'] = "edit";
			
			$this->load->view("app_admin/kecamatan/detail",$d);
		}
	}

	public function simpan()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$this->form_validation->set_rules('id_kabupaten', 'Nama Kabupaten', 'trim|required');
			$this->form_validation->set_rules('nama_kecamatan', 'Nama Kecamatan', 'trim|required');
			$id['id_kecamatan'] = $this->input->post("id_param");
			
			if ($this->form_validation->run() == FALSE)
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$q = $this->db->get_where("tbl_kecamatan",$id);
					$d = array();
					foreach($q->result() as $dt)
					{
						$d['id_param'] = $dt->id_kecamatan;
						$d['nama_kecamatan'] = $dt->nama_kecamatan;
						$d['id_kabupaten'] = $dt->id_kabupaten;
					}
					$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
					$d['st'] = $st;
					$this->load->view('app_admin/kecamatan/input',$d);
				}
				else if($st=="tambah")
				{
					$d['id_param'] = "";
					$d['nama_kecamatan'] = "";
					$d['id_kabupaten'] = "";
					$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
					$d['st'] = $st;
					$this->load->view('app_admin/kecamatan/input',$d);
				}
			}
			else
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$upd['id_kabupaten'] = $this->input->post("id_kabupaten");
					$upd['nama_kecamatan'] = $this->input->post("nama_kecamatan");
					$this->db->update("tbl_kecamatan",$upd,$id);
					?>
						<script>
							window.parent.location.reload(true);
						</script>
					<?php
				}
				else if($st=="tambah")
				{
					$in['id_kabupaten'] = $this->input->post("id_kabupaten");
					$in['nama_kecamatan'] = $this->input->post("nama_kecamatan");
					$this->db->insert("tbl_kecamatan",$in);
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
			$this->session->unset_userdata($set_sess);
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->query("select * from tbl_kecamatan a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten where nama_kecamatan like '%".$kata."%'");
			$config['base_url'] = base_url() . 'app_admin_kecamatan/cari/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->query("select * from tbl_kecamatan a left join tbl_kabupaten b on a.id_kabupaten=b.id_kabupaten where 
			nama_kecamatan like '%".$kata."%' LIMIT ".$offset.",".$limit."");
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/kecamatan/home");
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
			$id['id_kecamatan'] = $this->uri->segment(3);
			$this->db->delete("tbl_kecamatan",$id);
			header('location:'.base_url().'app_admin_kecamatan');
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
			$query = $this->db->query("delete from tbl_kecamatan where id_kecamatan IN (".$id.")");
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
			$this->session->set_userdata($set_sess);
			header('location:'.base_url().'app_admin_kecamatan');
		}
		else
		{
			header('location:'.base_url().'');
		}
	}
}

/* End of file app_admin_kecamatan.php */
/* Location: ./application/controllers/app_admin_kecamatan.php */