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
		$publikasi 		= $this->input->post('publikasi');
		$gratis 		= $this->input->post('gratis');
		$page 			= $this->input->post('page');
		$kriteria 		= $this->input->post('kriteria');

		$maxperpage 	= 4;

		$SQL = "";
		if ($token != '') {

			$SQL .= "SELECT x.*, CASE WHEN x.kategoriID = 0 THEN 'Gratis' ELSE y.NamaKategori END NamaKategori FROM ( SELECT 
						id,KodeItem,0 kategoriID,judul,description,releasedate,
						releaseperiod,picture,harga,ppn,otherprice,epub,
						avgrate,status_publikasi
					FROM tbuku WHERE harga = 0 UNION ALL ";

			$SQL .= "SELECT 
						id,KodeItem,kategoriID,judul,description,releasedate,
						releaseperiod,picture,harga,ppn,otherprice,epub,
						avgrate,status_publikasi
					FROM tbuku)x 
					LEFT JOIN tkategori y on x.kategoriID = y.id
					WHERE 1 = 1 ";

			if ($publikasi == "1" ) {
				$SQL .= " AND status_publikasi = ".$publikasi." ";
			}
			if ($KodeKategori != '') {
				$SQL .= " AND kategoriID = ".$KodeKategori." ";
			}

			if ($kodeBuku != '') {
				$SQL .= " AND KodeItem = '".$kodeBuku."' ";
			}

			if ($script != '') {
				$SQL .= " AND ".$script." ";
			}

			if ($gratis == "1") {
				$SQL .= " AND harga = 0 ";
			}

			if ($kriteria != "") {
				$SQL .= " AND CONCAT(x.judul,' ', y.NamaKategori) LIKE '%".$kriteria."%'";
			}

			if ($ordering == '') {
				$SQL .= " ORDER BY releasedate DESC ";
			}
			else{
				$SQL .= " ORDER BY ".$ordering;
			}


			$SQL .= "LIMIT ".$page * $maxperpage.",".$maxperpage.";";
			// var_dump($SQL);
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

		echo json_encode($rs->result());
	}
}