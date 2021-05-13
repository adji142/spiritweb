<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Permission extends CI_Controller {

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

		$id = $this->input->post('id');

		if ($id == '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('status'=>1),'permission');
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('KodeSkala'=>$id,'status'=>1),'permission');
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
		$KodeSkala = $this->input->post('KodeSkala');
		$KodeAtribut = $this->input->post('KodeAtribut');
		$SkalaDesc = $this->input->post('SkalaDesc');
		$Skala = $this->input->post('Skala');


		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeSkala' => $KodeSkala,
			'KodeAtribut' => $KodeAtribut,
			'SkalaDesc' => $SkalaDesc,
			'Skala' => $Skala
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'permission');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('KodeSkala'=> $KodeSkala),'permission');
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
				$SQL = "DELETE FROM permission WHERE KodeSkala = '".$KodeSkala."'";
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
	public function RemovePermissionRole()
	{
		$data = array('success' => false ,'message'=>array());
		$roleid = $this->input->post('roleid');
		$remove = $this->db->query("DELETE FROM permissionrole where roleid = ".$roleid);
		$data['success'] = true;
		echo json_encode($data);
	}
	public function AddPermissionRole()
	{
		$data = array('success' => false ,'message'=>array());

		$roleid = $this->input->post('roleid');
		$permissionid = $this->input->post('permissionid');

		$param = array('roleid'=>$roleid,'permissionid'=>$permissionid);

		$this->db->trans_begin();
		try {
			$rs = $this->ModelsExecuteMaster->ExecInsert($param,'permissionrole');
			if ($rs) {
				$data['success'] = true;
				$this->db->trans_commit();
			}
			else{
				$data['message'] = "Gagal input role";
				goto jump;
			}
		} catch (Exception $e) {
			jump:
			$this->db->trans_rollback();
		}
		
		echo json_encode($data);
	}
}
