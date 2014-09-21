<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin_home extends CI_Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Controller untuk halaman dashboard admin
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
}

/* End of file app_admin_home.php */
/* Location: ./application/controllers/app_admin_home.php */