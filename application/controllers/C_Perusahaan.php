<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Perusahaan extends CI_Controller {

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

		$rs = $this->ModelsExecuteMaster->FindData(array('id'=>1),'tperusahaan');

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
		
		$id = $this->input->post('id');
		$NamaPerusahaan = $this->input->post('NamaPerusahaan');
		$Alamat1 = $this->input->post('Alamat1');
		$Alamat2 = $this->input->post('Alamat2');
		$NoTlp = $this->input->post('NoTlp');
		$NPWP = $this->input->post('NPWP');
		$provinsi = $this->input->post('provinsi');
		$Kota = $this->input->post('Kota');
		$Kelurahan = $this->input->post('Kelurahan');
		$Kecamatan = $this->input->post('Kecamatan');
		$KodePos = $this->input->post('KodePos');


		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype');

		$param = array(
			'NamaPerusahaan' => $NamaPerusahaan,
			'Alamat1' => $Alamat1,
			'Alamat2' => $Alamat2,
			'NoTlp' => $NoTlp,
			'NPWP' => $NPWP,
			'provinsi' => $provinsi,
			'Kota' => $Kota,
			'Kelurahan' => $Kelurahan,
			'Kecamatan' => $Kecamatan,
			'KodePos' => $KodePos
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'tperusahaan');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tperusahaan');
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
				$SQL = "DELETE FROM tperusahaan where id = ".$id;

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
}
