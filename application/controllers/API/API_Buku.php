<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Buku extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
	}

	public function GetBuku()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$token = $this->input->post('token');

		$kodeBuku 		= $this->input->post('kodeBuku');
		$KodeKategori 	= $this->input->post('KodeKategori');
		$script 		= $this->input->post('script');
		$ordering 		= $this->input->post('ordering');

		$SQL = "";
		if ($token != '') {
			$SQL .= "SELECT 
						id,KodeItem,kategoriID,judul,description,releasedate,
						releaseperiod,picture,harga,ppn,otherprice,epub,
						avgrate,status_publikasi
					FROM tbuku WHERE status_publikasi = 1 ";
			if ($kodeBuku != '') {
				$SQL .= " AND kategoriID = ".$KodeKategori." ";
			}

			if ($kodeBuku != '') {
				$SQL .= " AND KodeItem = '".$kodeBuku."' ";
			}

			if ($script != '') {
				$SQL .= " AND ".$script." ";
			}

			if ($ordering == '') {
				$SQL .= " ORDER BY releasedate DESC ";
			}
			else{
				$SQL .= " ORDER BY ".$ordering;
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

		}
		else{
			$data['message'] = 'Invalid Token';
		}

		echo json_encode($data);
	}
}