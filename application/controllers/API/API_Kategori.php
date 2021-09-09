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
		$kriteria = $this->input->post('kriteria');
		$maxperpage = 2;
		$rs;
		if ($token != '') {
			$SQL = "SELECT x.id,x.NamaKategori, CASE WHEN x.id = 0 THEN 0 ELSE COALESCE(y.jml,0) END jml,ImageLink FROM (SELECT 0 id,'GRATIS !!' NamaKategori, 1 ShowHomePage,'' ImageLink FROM DUAL UNION ALL ";
			$SQL .= "SELECT id,NamaKategori,ShowHomePage,COALESCE(ImageLink,'') ImageLink FROM tkategori WHERE ShowHomePage = 1 ) x ";

			$SQL .= " LEFT JOIN (
							SELECT 
								a.kategoriID,
								count(*) jml
							FROM tbuku a
							where status_publikasi = 1
							group by a.kategoriID
						) y on x.id = y.kategoriID
					WHERE x.NamaKategori like '%".$kriteria."%' " ;
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

		echo json_encode($rs->result());
	}

	public function GetAppSetting()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$Key = $this->input->post('Key');

		$rs = $this->ModelsExecuteMaster->FindData(array('AppKey'=> $Key),'appsetting');
		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}
}