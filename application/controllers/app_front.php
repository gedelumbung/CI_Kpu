<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_front extends CI_Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Controller untuk manajemen data pemilih
	 **/
	 
	public function index()
	{
		$id_ses_kab = $this->session->userdata("id_kabupaten_session");
		$id_ses_kec = $this->session->userdata("id_kecamatan_session");
		$id_ses_kel  = $this->session->userdata("id_kelurahan_session");
		$id_nik  = $this->session->userdata("id_nik");
		$id_nama  = $this->session->userdata("id_nama");
		
		$page=$this->uri->segment(3);
		$limit=$this->config->item('limit_data');
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
		
		$d['tot'] = $offset;
		$tot_hal = $this->db->query("select * from tbl_data_pemilih a where a.id_kabupaten='".$id_ses_kab."' 
		and a.id_kecamatan='".$id_ses_kec."' and a.id_kelurahan_desa='".$id_ses_kel."' and a.nik_ktp like '%".$id_nik."%' and a.nama_lengkap like '%".$id_nama."%'");
		
		$config['base_url'] = base_url() . 'app_front/index/';
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
		and a.id_kecamatan='".$id_ses_kec."' and a.id_kelurahan_desa='".$id_ses_kel."' and a.nik_ktp like '%".$id_nik."%' and a.nama_lengkap like '%".$id_nama."%' LIMIT ".$offset.",".$limit."");
		
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
		
		$this->load->view("app_front/global/header",$d);
		$this->load->view("app_front/data_pemilih/home");
		$this->load->view("app_front/global/footer");
	}
	 
	public function detail()
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
		
		$this->load->view("app_front/data_pemilih/detail",$d);
	}

	public function cari()
	{
		if($this->input->post("cari")=="")
		{
			$kata = $this->session->userdata('kata_cari');
		}
		else
		{
			$sess_data['kata_cari'] = $this->input->post("cari");
			$this->session->set_userdata($sess_data);
			$kata = $this->session->userdata('kata_cari');
		}
		
		$set_sess['id_kabupaten_session'] = $this->session->userdata("id_kabupaten_session");
		$set_sess['id_kecamatan_session'] = $this->session->userdata("id_kecamatan_session");
		$set_sess['id_kelurahan_session'] = $this->session->userdata("id_kelurahan_session");
		$set_sess['id_nik'] = $this->session->userdata("id_nik");
		$set_sess['id_nama'] = $this->session->userdata("id_nama");
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
		$config['base_url'] = base_url() . 'app_front/cari/';
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
		
		$this->load->view("app_front/global/header",$d);
		$this->load->view("app_front/data_pemilih/home");
		$this->load->view("app_front/global/footer");
	}

	public function set()
	{
		$set_sess['id_kabupaten_session'] = $this->input->post("id_kabupaten");
		$set_sess['id_kecamatan_session'] = $this->input->post("id_kecamatan");
		$set_sess['id_kelurahan_session'] = $this->input->post("id_kelurahan_desa");
		$set_sess['id_nik'] = $this->input->post("nik");
		$set_sess['id_nama'] = $this->input->post("nama_pemilih");
		$this->session->set_userdata($set_sess);
		header('location:'.base_url().'app_front');
	}
}

/* End of file app_front.php */
/* Location: ./application/controllers/app_front.php */