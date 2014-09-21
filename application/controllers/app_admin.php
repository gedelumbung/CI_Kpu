<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin extends CI_Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Controller untuk manajemen routing
	 **/
	 
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			$frm['gbr_captcha'] = $this->gbr_captcha();
			$this->load->view("app_admin/login/index",$frm);
		}
		else
		{
			header('location:'.base_url().'app_admin_home');
		}
	}
	 
	public function login()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');
	
			if ($this->form_validation->run() == FALSE)
			{
				$frm['gbr_captcha'] = $this->gbr_captcha();
				$this->load->view("app_admin/login/index",$frm);
			}
			else
			{
				$u = $this->input->post('username');
				$p = $this->input->post('password');
				$this->app_model->getLoginData($u,$p);
			}
		}
		else
		{
			header('location:'.base_url().'app_admin_home');
		}
	}
	
	private function gbr_captcha()
	{
		$vals = array(
		'img_path' => './captcha/',
		'img_url' => base_url().'captcha/',
		'font_path' => './system/fonts/impact.ttf',
		'img_width' => '150',
		'img_height' => 40
		);
		$cap = create_captcha($vals);
		$datamasuk = array(
			'captcha_time' => $cap['time'],
			'word' => $cap['word']
			);
		$expiration = time()-3600;
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
		$query = $this->db->insert_string('captcha', $datamasuk);
		$this->db->query($query);
		return $cap['image'];
	}
	
	public function change_password()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$d['judul_lengkap'] = $this->config->item('nama_aplikasi_full');
			$d['judul_pendek'] = $this->config->item('nama_aplikasi_pendek');
			$d['instansi'] = $this->config->item('nama_instansi');
			$d['credit'] = $this->config->item('credit_aplikasi');
			$d['alamat'] = $this->config->item('alamat_instansi');
			
			$this->load->view('app_admin/global/header',$d);
			$this->load->view('app_admin/user/bg_change_password');
			$this->load->view('app_admin/global/footer');
		}
		else
		{
			header('location:'.base_url().'');
		}
	}
	
	public function save_pass()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$this->form_validation->set_rules('pass_lama', 'Password Lama', 'trim|required');
			$this->form_validation->set_rules('pass_baru', 'Password Baru', 'trim|required');
			$this->form_validation->set_rules('ulangi_pass_baru', 'Ulangi Password Baru', 'trim|required');
			
			$id['username'] = $this->input->post("usernname");
			$pass_lama = $this->input->post("pass_lama");
			$pass_baru = $this->input->post("pass_baru");
			$ulangi_pass_baru = $this->input->post("ulangi_pass_baru");
			
			$set['tab_a'] = "active";
			$set['tab_b'] = "";
			$this->session->set_userdata($set);
			
			if ($this->form_validation->run() == FALSE)
			{
				$d['judul_lengkap'] = $this->config->item('nama_aplikasi_full');
				$d['judul_pendek'] = $this->config->item('nama_aplikasi_pendek');
				$d['instansi'] = $this->config->item('nama_instansi');
				$d['credit'] = $this->config->item('credit_aplikasi');
				$d['alamat'] = $this->config->item('alamat_instansi');
				
				$this->load->view('app_admin/global/header',$d);
				$this->load->view('app_admin/user/bg_change_password');
				$this->load->view('app_admin/global/footer');
			}
			else
			{
				$login['username'] = $id['username'];
				$login['password'] = md5($pass_lama.$this->config->item("key_login"));
				$cek = $this->db->get_where('tbl_user_login', $login);
				if($cek->num_rows()>0)
				{
					if($pass_baru==$ulangi_pass_baru)
					{
						$upd['password'] = md5($pass_baru.$this->config->item("key_login"));
						$this->db->update("tbl_user_login",$upd,$id);
						$this->session->set_flashdata('pass', 'Berhasil mengubah password...');
						header('location:'.base_url().'app_admin/change_password');
					}
					else
					{
						$this->session->set_flashdata('pass', 'Password Baru tidak sama...');
						header('location:'.base_url().'app_admin/change_password');
					}
				}
				else
				{
					$this->session->set_flashdata('pass', 'Password Lama salah...');
					header('location:'.base_url().'app_admin/change_password');
				}
			}
		}
		else
		{
			header('location:'.base_url().'');
		}
	}
	
	public function save_name()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$this->form_validation->set_rules('nama_lengkap', 'Nama Pengguna', 'trim|required');
			
			$id['username'] = $this->input->post("usernname");
			$nama = $this->input->post("nama_lengkap");
			
			$set['tab_a'] = "";
			$set['tab_b'] = "active";
			$this->session->set_userdata($set);
			
			if ($this->form_validation->run() == FALSE)
			{
				$d['judul_lengkap'] = $this->config->item('nama_aplikasi_full');
				$d['judul_pendek'] = $this->config->item('nama_aplikasi_pendek');
				$d['instansi'] = $this->config->item('nama_instansi');
				$d['credit'] = $this->config->item('credit_aplikasi');
				$d['alamat'] = $this->config->item('alamat_instansi');
				
				$this->load->view('app_admin/global/header',$d);
				$this->load->view('app_admin/user/bg_change_password');
				$this->load->view('app_admin/global/footer');
			}
			else
			{
				$upd['nama_pengguna'] = $nama;
				$this->db->update("tbl_user_login",$upd,$id);
				$this->session->set_flashdata('pass', 'Berhasil mengubah nama pengguna...');
				$set_new['nama_pengguna'] = $upd['nama_pengguna'];
				$this->session->set_userdata($set_new);
				header('location:'.base_url().'app_admin/change_password');
			}
		}
		else
		{
			header('location:'.base_url().'');
		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		header('location:'.base_url().'');
	}
}

/* End of file app_front.php */
/* Location: ./application/controllers/app_front.php */