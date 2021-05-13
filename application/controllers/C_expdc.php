<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_expdc extends CI_Controller {

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

		$KodeExpdc = $this->input->post('KodeExpdc');

		if ($KodeExpdc == '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('isActive'=>1),'texpdc');
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('KodeExpdc'=>$KodeExpdc),'texpdc');
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
	public function ReadDetail()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$KodeExpedisi = $this->input->post('KodeExpdc');
		$RowID = $this->input->post('RowID');

		$rs;

		if ($RowID != '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('RowID'=>$RowID),'texpedisidetail');
			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
		}
		
		if ($KodeExpedisi != '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('KodeExpedisi'=>$KodeExpedisi),'texpedisidetail');
			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
		}

		echo json_encode($data);
	}

	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array());
		
		$KodeExpdc = $this->input->post('KodeExpdc');
		$NamaExpdc = $this->input->post('NamaExpdc');
		$AlamatKantor = $this->input->post('AlamatKantor');
		$NoTlp = $this->input->post('NoTlp');
		$Email = $this->input->post('Email');
		$isActive = 1;


		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeExpdc' => $KodeExpdc,
			'NamaExpdc' => $NamaExpdc,
			'AlamatKantor' => $AlamatKantor,
			'NoTlp' => $NoTlp,
			'Email' => $Email,
			'isActive' => $isActive,
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'texpdc');
				if ($call_x) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$data['message'] = "Gagal Input Role";
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('KodeExpdc'=> $KodeExpdc),'texpdc');
				if ($rs) {
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'delete') {
			try {
				$SQL = "UPDATE texpdc SET isActive = 0 WHERE KodeExpdc = '".$KodeExpdc."'";
				$rs = $this->db->query($SQL);
				if ($rs) {
					$data['success'] = true;
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

	public function CRUDDetail()
	{
		$data = array('success' => false ,'message'=>array());
		
		$RowID = $this->input->post('RowID');
		$KodeExpedisi = $this->input->post('KodeExpedisi');
		$NamaService = $this->input->post('NamaService');


		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype_detail');

		$param = array(
			'RowID' => $RowID,
			'KodeExpedisi' => $KodeExpedisi,
			'NamaService' => $NamaService
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'texpedisidetail');
				if ($call_x) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$data['message'] = "Gagal Input Role";
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('RowID'=> $RowID),'texpedisidetail');
				if ($rs) {
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'delete') {
			try {
				$SQL = "UPDATE texpedisidetail SET isActive = 0 WHERE RowID = '".$RowID."'";
				$rs = $this->db->query($SQL);
				if ($rs) {
					$data['success'] = true;
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
}
