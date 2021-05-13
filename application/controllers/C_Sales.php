<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Sales extends CI_Controller {

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

		$KodeSales = $this->input->post('KodeSales');

		if ($KodeSales == '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('isActive' => 1),'tsales');
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('KodeSales'=>$KodeSales),'tsales');
		}

		if ($rs->num_rows()>0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['message'] = 'No Record Found';
		}
		echo json_encode($data);
	}
	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array());
		$KodeSales = $this->input->post('KodeSales');
		$NamaSales = $this->input->post('NamaSales');
		$Alamat = $this->input->post('Alamat');
		$Email = $this->input->post('Email');
		$NoTlp = $this->input->post('NoTlp');
		$LevelingPrice = $this->input->post('LevelingPrice');
		$isActive = 1;

		// if ($LevelingPrice == "On") {
		// 	$LevelingPrice = 1;
		// }
		// else{
		// 	$LevelingPrice = 0;
		// }
		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeSales' => $KodeSales,
			'NamaSales' => $NamaSales,
			'Alamat' => $Alamat,
			'Email' => $Email,
			'NoTlp' => $NoTlp,
			'isActive' => $isActive,
			'LevelingPrice' => $LevelingPrice
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'tsales');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('KodeSales'=> $KodeSales),'tsales');
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
				$SQL = "UPDATE tsales SET isActive = 0 WHERE KodeSales = '".$KodeSales."'";
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

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),3)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 3,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$data['success'] = true;
			$data['nomor'] = $nomor;
		}
		echo json_encode($data);
	}
}
