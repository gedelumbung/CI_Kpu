<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin_manage_user extends CI_Controller {

	/*
		***	Controller : app_admin_manage_user.php
		***	by Gede Lumbung
		***	http://gedelumbung.com
	*/

	public function index()
	{
		
		if($this->session->userdata('logged_in')!="")
		{
			$d['judul_lengkap'] = $this->config->item('nama_aplikasi_full');
			$d['judul_pendek'] = $this->config->item('nama_aplikasi_pendek');
			$d['instansi'] = $this->config->item('nama_instansi');
			$d['credit'] = $this->config->item('credit_aplikasi');
			$d['alamat'] = $this->config->item('alamat_instansi');
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$d['tot'] = $offset;
			$tot_hal = $this->db->get("tbl_user_login");
			$config['base_url'] = base_url() . 'app_admin_manage_user/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			
			$d['status_pegawai'] = $this->db->get("tbl_user_login",$limit,$offset);
			
			$this->load->view('app_admin/global/header',$d);
			$this->load->view('app_admin/user/list_user');
			$this->load->view('app_admin/global/footer');
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function edit()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$id['id_user_login'] = $this->uri->segment(3);
			$q = $this->db->get_where("tbl_user_login",$id);
			$d = array();
			foreach($q->result() as $dt)
			{
				$d['id_param'] = $dt->id_user_login;
				$d['username'] = $dt->username; 
				$d['password'] = $dt->password; 
				$d['nama_pengguna'] = $dt->nama_pengguna; 
			}
			$d['st'] = "edit";
			
			$this->load->view('app_admin/user/input',$d);
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function detail()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$id['id_user_login'] = $this->uri->segment(3);
			$q = $this->db->get_where("tbl_user_login",$id);
			$d = array();
			foreach($q->result() as $dt)
			{
				$d['id_param'] = $dt->id_user_login;
				$d['username'] = $dt->username; 
				$d['password'] = $dt->password; 
				$d['nama_pengguna'] = $dt->nama_pengguna; 
			}
			$d['st'] = "edit";
			
			$this->load->view('app_admin/user/detail',$d);
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function tambah()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$d['id_param'] = "";
			$d['username'] = ""; 
			$d['password'] = ""; 
			$d['nama_pengguna'] = ""; 
			$d['st'] = "tambah";
			$this->load->view('app_admin/user/input',$d);
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
			$id['id_user_login'] = $this->uri->segment(3);
			$this->db->delete("tbl_user_login",$id);
			header('location:'.base_url().'app_admin_manage_user');
		}
		else
		{
			header('location:'.base_url().'');
		}
	}

	public function simpan()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('nama_pengguna', 'Nama Lengkap', 'trim|required');
			$id['id_user_login'] = $this->input->post("id_param");
			
			if ($this->form_validation->run() == FALSE)
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$q = $this->db->get_where("tbl_user_login",$id);
					$d = array();
					foreach($q->result() as $dt)
					{
						$d['id_param'] = $dt->id_user_login;
						$d['username'] = $dt->username; 
						$d['password'] = $dt->password; 
						$d['nama_pengguna'] = $dt->nama_pengguna; 
					}
					$d['st'] = "edit";
					
					$this->load->view('app_admin/user/input',$d);
				}
				else if($st=="tambah")
				{
					$d['id_param'] = "";
					$d['username'] = ""; 
					$d['password'] = ""; 
					$d['nama_pengguna'] = ""; 
					$d['st'] = "tambah";
					$this->load->view('app_admin/user/input',$d);
				}
			}
			else
			{
				$st = $this->input->post('st');
				if($st=="edit")
				{
					$upd['username'] = $this->input->post("username");
					$upd['nama_pengguna'] = $this->input->post("nama_pengguna");
					if($this->input->post("password")!="")
					{
						$upd['password'] = md5($this->input->post("password").$this->config->item("key_login"));
					}
					$this->db->update("tbl_user_login",$upd,$id);
					?>
						<script>
							window.parent.location.reload(true);
						</script>
					<?php
				}
				else if($st=="tambah")
				{
					$login['username'] = $this->input->post("username");
					$cek = $this->db->get_where('tbl_user_login', $login);
					if($cek->num_rows()>0)
					{
						$d['id_param'] = "";
						$d['username'] = ""; 
						$d['password'] = ""; 
						$d['nama_pengguna'] = ""; 
						?><script>alert("Username telah ada, silahkan gunakan yang lainnya...");</script><?php
						$this->load->view('dashboard_admin/user/input',$d);
					}
					else
					{
						$in['username'] = $this->input->post("username");
						$in['nama_pengguna'] = $this->input->post("nama_pengguna");
						$in['password'] = md5($this->input->post("password").$this->config->item("key_login"));
						$this->db->insert("tbl_user_login",$in);
						?>
							<script>
								window.parent.location.reload(true);
							</script>
						<?php
					}
				}
			
			}
		}
		else
		{
			header('location:'.base_url().'');
		}
	}
}

/* End of file app_admin_manage_user.php */
/* Location: ./application/controllers/app_admin_manage_user.php */