<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Kategori extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
	}

	public function GetKategori()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$token = $this->input->post('token');

		$page = $this->input->post('page');
		$maxperpage = 2;

		if ($token != '') {
			$SQL = "SELECT * FROM (SELECT 0 id,'GRATIS !!' NamaKategori, 1 ShowHomePage FROM DUAL UNION ALL ";
			$SQL .= "SELECT * FROM tkategori)x ";
			// LIMIT ".$page.",".$maxperpage.";
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

		echo json_encode($data);
	}
}