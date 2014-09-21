<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin_kabupaten extends CI_Controller {

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
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->get("tbl_kabupaten");
			$config['base_url'] = base_url() . 'app_admin_kabupaten/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->get("tbl_kabupaten",$limit,$offset);
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/kabupaten/home");
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
			$d['nama_kabupaten'] = "";
			$d['st'] = "tambah";
			
			$this->load->view("app_admin/kabupaten/input",$d);
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
			$id_get['id_kabupaten'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_kabupaten",$id_get)->row();
			$d['id_param'] = $dt->id_kabupaten;
			$d['nama_kabupaten'] = $dt->nama_kabupaten;
			$d['st'] = "edit";
			
			$this->load->view("app_admin/kabupaten/input",$d);
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
			$id_get['id_kabupaten'] = $this->uri->segment(3);
			$dt = $this->db->get_where("tbl_kabupaten",$id_get)->row();
			$d['id_param'] = $dt->id_kabupaten;
			$d['nama_kabupaten'] = $dt->nama_kabupaten;
			$d['st'] = "edit";
			
			$this->load->view("app_admin/kabupaten/detail",$d);
		}
	}

	public function simpan()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$this->form_validation->set_rules('nama_kabupaten', 'Nama Kabupaten', 'trim|required');
			$id['id_kabupaten'] = $this->input->post("id_param");
			
			if ($this->form_validation->run() == FALSE)
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$q = $this->db->get_where("tbl_kabupaten",$id);
					$d = array();
					foreach($q->result() as $dt)
					{
						$d['id_param'] = $dt->id_kabupaten;
						$d['nama_kabupaten'] = $dt->nama_kabupaten;
					}
					$d['st'] = $st;
					$this->load->view('app_admin/kabupaten/input',$d);
				}
				else if($st=="tambah")
				{
					$d['id_param'] = "";
					$d['nama_kabupaten'] = "";
					$d['st'] = $st;
					$this->load->view('app_admin/kabupaten/input',$d);
				}
			}
			else
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$upd['nama_kabupaten'] = $this->input->post("nama_kabupaten");
					$this->db->update("tbl_kabupaten",$upd,$id);
					?>
						<script>
							window.parent.location.reload(true);
						</script>
					<?php
				}
				else if($st=="tambah")
				{
					$in['nama_kabupaten'] = $this->input->post("nama_kabupaten");
					$this->db->insert("tbl_kabupaten",$in);
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
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->query("select * from tbl_kabupaten where nama_kabupaten like '%".$kata."%'");
			$config['base_url'] = base_url() . 'app_admin_kabupaten/cari/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['data_get'] = $this->db->query("select * from tbl_kabupaten where nama_kabupaten like '%".$kata."%' LIMIT ".$offset.",".$limit."");
			
			$this->load->view("app_admin/global/header",$d);
			$this->load->view("app_admin/kabupaten/home");
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
			$id['id_kabupaten'] = $this->uri->segment(3);
			$this->db->delete("tbl_kabupaten",$id);
			header('location:'.base_url().'app_admin_kabupaten');
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
			$query = $this->db->query("delete from tbl_kabupaten where id_kabupaten IN (".$id.")");
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
}

/* End of file app_admin_kabupaten.php */
/* Location: ./application/controllers/app_admin_kabupaten.php */