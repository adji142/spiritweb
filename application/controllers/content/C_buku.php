<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Buku extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
		$this->load->model('LoginMod');
	}
	public function Read()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$id 		= $this->input->post('id');
		$kategoriID = $this->input->post('kategoriID');
		$script		= $this->input->post('script');

		$SQL ='';

		$SQL .= '
				SELECT 
					a.*,
					b.NamaKategori
				FROM tbuku a
				LEFT JOIN tkategori b on a.kategoriID = b.id
			';

		if ($id != '') {
			$SQL .= ' WHERE a.id '.$id.' ';
		}

		if ($kategoriID != '') {
			$SQL .= ' and a.kategoriID '.$kategoriID.' ';
		}

		if ($script != '' ) {
			$SQL .= ' and '.$script.' ';
		}

		$rs = $this->db->query($SQL);

		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$undone = $this->db->error();
			$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
		}
		echo json_encode($data);
	}
	public function CRUD()
	{
		ini_set('memory_limit', '32M');
		ini_set('upload_max_filesize', '200M');
		ini_set('post_max_size', '300M');

		$data = array('success' => false ,'message'=>array());

		$id = $this->input->post('id');
		$KodeItem = $this->input->post('KodeItem');
		$kategoriID = $this->input->post('kategoriID');
		$judul = $this->input->post('judul');
		$description = $this->input->post('description');
		$releasedate = $this->input->post('releasedate');
		$releaseperiod = $this->input->post('releaseperiod');
		// $picture = $this->input->post('picture');
		$picture_base64 = $this->input->post('picture_base64');
		$harga = $this->input->post('harga');
		$ppn = $this->input->post('ppn');
		$otherprice = $this->input->post('otherprice');
		// $epub = $this->input->post('epub');
		$epub_base64 = $this->input->post('epub_base64');
		$avgrate = $this->input->post('avgrate');
		$status_publikasi = $this->input->post('status_publikasi');
		$createdby = $this->input->post('createdby');
		$createdon = $this->input->post('createdon');
		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype');

		$picture_ext = '';
		// picture
		try {
			unset($config); 
			$date = date("ymd");
	        $config['upload_path'] = './localData/image';
	        $config['max_size'] = '60000';
	        $config['allowed_types'] = 'jpg|png|jpeg';
	        $config['overwrite'] = TRUE;
	        $config['remove_spaces'] = TRUE;
	        $config['file_name'] = str_replace(' ', '', $KodeItem);

	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);

	        if(!$this->upload->do_upload('picture')) {
	            $data['message'] = $this->upload->display_errors();
	        }else{
	            $dataDetails = $this->upload->data();
	            $ext = implode('.',$dataDetails['file_name']);
	            $picture_ext = $ext[1];
	        }	
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}

		// Epub

		try {
			unset($config_epub); 
			$date = date("ymd");
	        $config_epub['upload_path'] = './localData/epub';
	        $config_epub['max_size'] = '60000';
	        $config_epub['allowed_types'] = 'epub';
	        $config_epub['overwrite'] = TRUE;
	        $config_epub['remove_spaces'] = TRUE;
	        $config_epub['file_name'] = str_replace(' ', '', $KodeItem);

	        $this->load->library('upload', $config_epub);
	        $this->upload->initialize($config_epub);

	        if(!$this->upload->do_upload('epub')) {
	            $data['message'] = $this->upload->display_errors();
	        }else{
	            $videoDetails = $this->upload->data();
	        }	
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}

		$param = array(
			'KodeItem' => $KodeItem,
			'kategoriID' => $kategoriID,
			'judul' => $judul,
			'description' => $description,
			'releasedate' => $releasedate,
			'releaseperiod' => $releaseperiod,
			'picture' => base_url().'localData/picture/'.str_replace(' ', '', $KodeItem).'.'.$ext,
			'picture_base64' => $picture_base64,
			'harga' => $harga,
			'ppn' => $ppn,
			'otherprice' => $otherprice,
			'epub' => base_url().'localData/epub/'.str_replace(' ', '', $KodeItem).'.epub',
			'epub_base64' => $epub_base64,
			'avgrate' => $avgrate,
			'status_publikasi' => $status_publikasi,
			'createdby' => $this->session->userdata('username'),
			'createdon' => date("Y-m-d h:i:sa")
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'tbuku');
				if ($call_x) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
					goto jump;
				}
			} catch (Exception $e) {
				jump:
				$this->db->trans_rollback();
				// $data['success'] = false;
				// $data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'edit') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tbuku');
				if ($rs) {
					$data['success'] = true;
				}
				else{
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'delete') {
			try {
				$SQL = "UPDATE ".'tbuku'." SET isActive = 0 WHERE id = '".$id."'";
				$rs = $this->db->query($SQL);
				if ($rs) {
					$data['success'] = true;
				}
				else{
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		else{
			$data['success'] = false;
			$data['message'] = "Invalid Form Type";
		}
		echo json_encode($data);
	}
	public function Getindex()
	{
		$data = array('success' => false ,'message'=>array(),'Nomor' => '');

		$Kolom = $this->input->post('Kolom');
		$Table = $this->input->post('Table');
		$Prefix = $this->input->post('Prefix');

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),5)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 5,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$data['success'] = true;
			$data['nomor'] = $nomor;
		}
		echo json_encode($data);
	}
}
