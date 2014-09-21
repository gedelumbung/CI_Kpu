<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_Model extends CI_Model {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Model untuk menangani semua query database aplikasi
	 **/
	 
	//query login
	public function getLoginData($usr,$psw)
	{
		$u = mysql_real_escape_string($usr);
		$p = md5(mysql_real_escape_string($psw.$this->config->item("key_login")));
		$q_cek_login = $this->db->get_where('tbl_user_login', array('username' => $u, 'password' => $p));
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
				foreach($q_cek_login->result() as $qad)
				{
					$sess_data['logged_in'] = 'yesGetMeLogin';
					$sess_data['username'] = $qad->username;
					$sess_data['nama_pengguna'] = $qad->nama_pengguna;
					$this->session->set_userdata($sess_data);
				}
				header('location:'.base_url().'app_admin_home');
			}
		}
		else
		{
			$this->session->set_flashdata('result_login', 'Username atau Password yang anda masukkan salah.');
			header('location:'.base_url().'app_admin');
		}
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */