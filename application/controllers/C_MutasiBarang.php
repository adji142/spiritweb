<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MutasiBarang extends CI_Controller {

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
	public function ReadHeader()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$TglAwal = $this->input->post('TglAwal');
		$TglAkhir = $this->input->post('TglAkhir');
		$Mutasi = $this->input->post('Mutasi');

		$SQL = "SELECT * FROM headermutasi where TglTransaksi BETWEEN '".$TglAwal."' AND '".$TglAkhir."' AND Mutasi =".$Mutasi;

		$rs = $this->db->query($SQL);
		if ($rs->num_rows() > 0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$undone = $this->db->error();
			$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
		}
		echo json_encode($data);
	}
	public function ReadDetail()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$HeaderID = $this->input->post('HeaderID');

		$SQL = "SELECT A.*,B.ItemName,B.Article FROM detailmutasi A 
				LEFT JOIN vw_stok  B on A.KodeItem = B.ItemCode
				where A.NoTransaksi = '".$HeaderID."' ORDER BY A.LineNum";

		$rs = $this->db->query($SQL);

		if ($rs->num_rows() > 0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$undone = $this->db->error();
			$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
		}
		echo json_encode($data);
	}
	public function getDummy()
	{
		$data = array('success' => true ,'message'=>array(),'data' =>array(),'masteralat'=>array());

		$call = $this->db->query("select '' ItemCode,'' ItemName,0 Qty,0 Onhand,0 Hpp");

		$data['data'] = array();

		echo json_encode($data);
	}
	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array());

		$errorCount = 0;
		// Header
		$NoTransaksi = "";
		$TglTransaksi = $this->input->post('TglTransaksi');
		$TglPencatatan = date("Y-m-d h:i:sa");
		$Mutasi = $this->input->post('Mutasi');
		$Keterangan = $this->input->post('Keterangan');
		$Createdby = $this->session->userdata('username');
		$CreatedOn = date("Y-m-d h:i:sa");

		// Detail

		$array_detail = $this->input->post('array_detail');


		// NoTransaksi
		$Kolom = 'NoTransaksi';
		$Table = 'headermutasi';
		$Prefix = '';
		if ($Mutasi == 1) {
			// IN
			$Prefix = 'MTIN';
		}
		elseif ($Mutasi == 2) {
			// OUT
			$Prefix = 'MTOT';
		}
		else{
			// Manual
			$Prefix = 'MTMN';
		}

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),4)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 6,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$NoTransaksi = $nomor;
		}
		else{
			$data['message'] = "Nomor Transaksi Gagal generate";
			goto jump;
		}
		
		try {
			$this->db->trans_begin();
			$header = array(
				'NoTransaksi' => $NoTransaksi,
				'TglTransaksi' => $TglTransaksi,
				'TglPencatatan' => $TglPencatatan,
				'Mutasi' => $Mutasi,
				'Keterangan' => $Keterangan,
				'Createdby' => $Createdby,
				'CreatedOn' => $CreatedOn
			);
			$appendHeader = $this->ModelsExecuteMaster->ExecInsert($header,'headermutasi');
			if ($appendHeader) {
				// do looop
				$detail = json_decode($array_detail);
				for ($i=0; $i < count($detail) ; $i++) { 
					// print_r($detail[$i]->ItemCode);
					$paramdetail = array(
						'NoTransaksi' => $NoTransaksi,
						'LineNum' 	=> $i,
						'KodeItem' 	=> $detail[$i]->ItemCode,
						'Qty' 		=> $detail[$i]->Qty,
						'Price' 	=> $detail[$i]->Hpp,
						'LineTotal' => $detail[$i]->Qty * $detail[$i]->Hpp,
						'CreatedBy' => $Createdby,
						'CreatedOn' => $CreatedOn
					);
					$appendDetail = $this->ModelsExecuteMaster->ExecInsert($paramdetail,'detailmutasi');
					if ($appendDetail) {
						$SQL = "SELECT SUM(Qty * Price) / SUM(Qty) Hpp
								FROM detailmutasi WHERE LEFT(NoTransaksi,4) = 'MTIN' AND KodeItem = '".$detail[$i]->ItemCode."'";
						$rsHpp = $this->db->query($SQL);
						// var_dump($SQL);
						if ($rsHpp->row()->Hpp > 0) {
							$update = $this->ModelsExecuteMaster->ExecUpdate(array('Hpp'=>$rsHpp->row()->Hpp),array('ItemCode'=>$detail[$i]->ItemCode),'itemmasterdata');
							if ($update) {
								$data['success'] = true;
							}
							else{
								$errorCount +=1;
								goto catchjump;
							}
						}
					}
					else{
						$errorCount +=1;
						goto catchjump;
					}
				}
			}
			else{
				$errorCount += 1;
			}
			if ($errorCount == 0) {
				$this->db->trans_commit();
			}
			else{
				$this->db->trans_rollback();
			}
		} catch (Exception $e) {
			catchjump:
			$undone = $this->db->error();
			$data['success'] = false;
			$data['message'] = "Sistem Gagal Melakukan Pemrossan Data: ".$undone['message'];
			$this->db->trans_rollback();
		}

		jump:
		echo json_encode($data);
	}
}
