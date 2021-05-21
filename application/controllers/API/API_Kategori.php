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
		$maxperpage = 5;

		if ($token != '') {
			$SQL = "SELECT * FROM tkategori LIMIT ".$page.",".$maxperpage.";";

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