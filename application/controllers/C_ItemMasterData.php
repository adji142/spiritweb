<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ItemMasterData extends CI_Controller {

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
		$kriteria = $this->input->post('kriteria');
		if ($id == '') {
			$SQL = "SELECT * FROM vw_stok WHERE Stok > 0";
			$rs = $this->db->query($SQL);
		}
		elseif ($kriteria <> '') {
			$SQL = "SELECT * FROM vw_stok WHERE CONCAT(ItemCode,' ',Article,' ', KodeItemLama) LIKE '%".$kriteria."%' AND Stok > 0";
			$rs = $this->db->query($SQL);	
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('ItemCode'=>$id),'itemmasterdata');
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
		$ItemCode = $this->input->post('ItemCode');
		$KodeItemLama = $this->input->post('KodeItemLama');
		$ItemName = $this->input->post('ItemName');
		$A_Warna = $this->input->post('A_Warna');
		$A_Motif = $this->input->post('A_Motif');
		$A_Size = $this->input->post('A_Size');
		$A_Sex = $this->input->post('A_Sex');
		$DefaultPrice = $this->input->post('DefaultPrice');
		$ItemGroup = $this->input->post('ItemGroup');
		$Satuan = $this->input->post('Satuan');
		$BeratStandar = $this->input->post('BeratStandar');
		$Createdby = $this->session->userdata('username');
		$Createdon = date("Y-m-d h:i:sa");
		$EcomPrice = $this->input->post('EcomPrice');
		$isActive = 1;


		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype');

		if ($formtype == 'add') {
			$param = array(
				'ItemCode' => $ItemCode,
				'KodeItemLama' => $KodeItemLama,
				'ItemName' => $ItemName,
				'A_Warna' => $A_Warna,
				'A_Motif' => $A_Motif,
				'A_Size' => $A_Size,
				'A_Sex' => $A_Sex,
				'DefaultPrice' => $DefaultPrice,
				'ItemGroup' => $ItemGroup,
				// 'KodeLokasi' => $KodeLokasi,
				'Createdby' => $Createdby,
				'Createdon' => $Createdon,
				'isActive' => $isActive,
				'BeratStandar'=>$BeratStandar,
				'EcomPrice' => $EcomPrice
			);
		}
		elseif ($formtype == 'edit') {
			$param = array(
				'KodeItemLama' => $KodeItemLama,
				'ItemName' => $ItemName,
				'A_Warna' => $A_Warna,
				'A_Motif' => $A_Motif,
				'A_Size' => $A_Size,
				'A_Sex' => $A_Sex,
				'DefaultPrice' => $DefaultPrice,
				'ItemGroup' => $ItemGroup,
				// 'KodeLokasi' => $KodeLokasi,
				'LastUpdatedby' => $Createdby,
				'LastUpdatedon' => $Createdon,
				'isActive' => $isActive,
				'BeratStandar'=>$BeratStandar,
				'EcomPrice' => $EcomPrice
			);
		}
		if ($formtype == 'add') {
			try {
				$this->db->trans_begin();
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'itemmasterdata');
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
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('ItemCode'=> $ItemCode),'itemmasterdata');
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
				$SQL = "UPDATE itemmasterdata SET isActive = 0 WHERE ItemCode = '".$ItemCode."'";
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

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),4)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 4,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$data['success'] = true;
			$data['nomor'] = $nomor;
		}
		echo json_encode($data);
	}
}
