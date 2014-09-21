<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_admin_upload_data extends CI_Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 * @keterangan : Controller untuk manajemen tps
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
			$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
			$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
			$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
			$d['data_tp'] = $this->db->get("tbl_tps");
            $this->load->view("app_admin/upload_data/input",$d);
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
			$id['id_tps'] = $this->input->post("id_param");
			
			if ($this->form_validation->run() == FALSE)
			{
				$d['data_kabupaten'] = $this->db->get("tbl_kabupaten");
				$d['data_kecamatan'] = $this->db->get("tbl_kecamatan");
				$d['data_kelurahan'] = $this->db->get("tbl_kelurahan_desa");
				$d['data_tp'] = $this->db->get("tbl_tps");
			
				$this->load->view("app_admin/upload_data/input",$d);
			}
			else
			{
				$config['upload_path'] = './temp_upload/';
		        $config['allowed_types'] = 'xls';
		 
		        $this->load->library('upload', $config);
		 
		        if ( ! $this->upload->do_upload())
		        {
		            $data = array('error' => $this->upload->display_errors());
		 
		        }
		        else
		        {
		            $data = array('error' => false);
		            $upload_data = $this->upload->data();
		 
		            $this->load->library('excel_reader');
		            $this->excel_reader->setOutputEncoding('CP1251');
		 
		            $file =  $upload_data['full_path'];
		            $this->excel_reader->read($file);
		            error_reporting(E_ALL ^ E_NOTICE);

		            $data = $this->excel_reader->sheets[0] ;
		            $dataexcel = Array();
		            for ($i = 1; $i <= $data['numRows']; $i++) 
		            {
                        if($data['cells'][$i][1] == '') break;
                        $dataexcel[$i-1]['id_kabupaten'] = $this->input->post("id_kabupaten");
                        $dataexcel[$i-1]['id_kecamatan'] = $this->input->post("id_kecamatan");
                        $dataexcel[$i-1]['id_kelurahan_desa'] = $this->input->post("id_kelurahan_desa");
                        $dataexcel[$i-1]['id_tps'] = $this->input->post("id_tps");
                        $dataexcel[$i-1]['nik_ktp'] = $data['cells'][$i][2];
                        $dataexcel[$i-1]['nama_lengkap'] = $data['cells'][$i][3];
                        $dataexcel[$i-1]['tempat_lahir'] = $data['cells'][$i][4];
                        $dataexcel[$i-1]['tanggal_lahir'] = $data['cells'][$i][5];
                        $dataexcel[$i-1]['umur'] = $data['cells'][$i][6];
                        $dataexcel[$i-1]['stts_perkawinan'] = $data['cells'][$i][7];
                        $dataexcel[$i-1]['jk_l'] = $data['cells'][$i][8];
                        $dataexcel[$i-1]['jk_p'] = $data['cells'][$i][9];
                        $dataexcel[$i-1]['alamat'] = $data['cells'][$i][10];
                        $dataexcel[$i-1]['keterangan'] = $data['cells'][$i][11];
		            }
		 
		            delete_files($upload_data['file_path']);

		            for($i=0;$i<count($dataexcel);$i++)
		            {
			            $data = array(
			                'id_kabupaten'=>$dataexcel[$i]['id_kabupaten'],
			                'id_kecamatan'=>$dataexcel[$i]['id_kecamatan'],
			                'id_kelurahan_desa'=>$dataexcel[$i]['id_kelurahan_desa'],
			                'id_tps'=>$dataexcel[$i]['id_tps'],
			                'nik_ktp'=>$dataexcel[$i]['nik_ktp'],
			                'nama_lengkap'=>$dataexcel[$i]['nama_lengkap'],
			                'tempat_lahir'=>$dataexcel[$i]['tempat_lahir'],
			                'tanggal_lahir'=>$dataexcel[$i]['tanggal_lahir'],
			                'umur'=>$dataexcel[$i]['umur'],
			                'stts_perkawinan'=>$dataexcel[$i]['stts_perkawinan'],
			                'jk_l'=>$dataexcel[$i]['jk_l'],
			                'jk_p'=>$dataexcel[$i]['jk_p'],
			                'alamat'=>$dataexcel[$i]['alamat'],
			                'keterangan'=>$dataexcel[$i]['keterangan']
			            );
			            $this->db->insert('tbl_data_pemilih', $data);
			        }

                    $id_get['id_kabupaten'] = $this->input->post("id_kabupaten");
                    $id_get['id_kecamatan'] = $this->input->post("id_kecamatan");
                    $id_get['id_kelurahan_desa'] = $this->input->post("id_kelurahan_desa");
                    $id_get['id_tps'] = $this->input->post("id_tps");
                    $dt_param['data_tersimpan'] = $this->db->get_where("tbl_data_pemilih",$id_get);
                    $dt_param['counter'] = $i." data berhasil diekseskusi...";
                    $this->load->view("app_admin/upload_data/hasil",$dt_param);
		        }
			
			}
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
						url: "<?php echo base_url(); ?>app_admin_upload_data/set_kecamatan_get_kelurahan", 
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
						url: "<?php echo base_url(); ?>app_admin_upload_data/set_kelurahan_get_tps", 
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

/* End of file app_admin_upload_data.php */
/* Location: ./application/controllers/app_admin_upload_data.php */