<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Tools extends CI_Controller {
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
		if ($id == '') {
			$rs = $this->ModelsExecuteMaster->FindData(array('IsActive'=>1),'tbanner');
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('KodePromo'=>$id,'IsActive'=>1),'tbanner');
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

	public function PublishEmail()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$email = $this->input->post('email');
		$subject = $this->input->post('subject');
		$body = $this->ModelsExecuteMaster->DefaultBody();
		$body .= $this->input->post('body');

		try {
			$rs = $this->ModelsExecuteMaster->SendSpesificEmail($email,$subject,$body);
			if ($rs) {
				$data['success'] = true;
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = $e->getMessage();
		}

		echo json_encode($data);
	}
}