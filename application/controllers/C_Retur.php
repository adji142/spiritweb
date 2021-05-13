<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Retur extends CI_Controller {

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

		$SQL = "SELECT *, CASE WHEN JenisTransaksi = 1 THEN 'Tukar Barang' ELSE CASE WHEN JenisTransaksi = 2 THEN 'Kembali Uang' ELSE '' END END JenisTransaksi FROM returheader where TglTransaksi BETWEEN '".$TglAwal."' AND '".$TglAkhir."' ORDER BY TglTransaksi DESC";

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

		$SQL = "SELECT A.*,B.ItemName ItemLama,B.Article ArticleLama,B.ItemName ItemBaru,B.Article ArticleBaru FROM returdetail A 
				LEFT JOIN vw_stok  B on A.KodeItemLama = B.ItemCode
				LEFT JOIN vw_stok  C on A.KodeItemBaru = C.ItemCode
				where A.NoTransaksi = '".$HeaderID."'";

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

		$call = $this->db->query("select '' ItemCode,'' ItemName,0 Qty,0 Onhand,0 Price");

		$data['data'] = array();

		echo json_encode($data);
	}
	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array());

		$errorCount = 0;
		// Header
		$NoTransaksi = "";

		$TglTransaksi = date("Y-m-d");
		$BaseRef = $this->input->post('BaseRef');
		$JenisTransaksi = $this->input->post('JenisTransaksi');
		$Keterangan = $this->input->post('Keterangan');
		$Createdby = $this->session->userdata('username');
		$CreatedOn = date("Y-m-d h:i:sa");

		// Detail

		$array_detail = $this->input->post('array_detail');


		// NoTransaksi
		$Kolom = 'NoTransaksi';
		$Table = 'returheader';
		$Prefix = "RT".substr(date("Y"), 2,4).date("m");

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),4)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 8,"0",STR_PAD_LEFT);
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
				'NoTransaksi' 	=> $NoTransaksi,
				'TglTransaksi' 	=> $TglTransaksi,
				'JenisTransaksi'=> $JenisTransaksi,
				'Keterangan' 	=> $Keterangan,
				'Createdby' 	=> $Createdby,
				'CreatedOn' 	=> $CreatedOn,
				'BaseRef'		=> $BaseRef
			);
			$appendHeader = $this->ModelsExecuteMaster->ExecInsert($header,'returheader');
			if ($appendHeader) {
				// do looop
				$detail = json_decode($array_detail);
				$TotalRetur = 0;
				for ($i=0; $i < count($detail) ; $i++) {
					// print_r($detail[$i]->ItemCode);
					$TotalRetur += $detail[$i]->QtyRetur * $detail[$i]->Price;
					$paramdetail = array(
						'NoTransaksi' 	=> $NoTransaksi,
						'KodeItemLama' 	=> $detail[$i]->KodeItemLama,
						'KodeItemBaru' 	=> $detail[$i]->KodeItemBaru,
						'QtyRetur' 		=> $detail[$i]->QtyRetur,
						'Price' 		=> $detail[$i]->Price 
					);
					$appendDetail = $this->ModelsExecuteMaster->ExecInsert($paramdetail,'returdetail');
					// var_dump($appendDetail);
					if (!$appendDetail) {
						// $data['success'] = true;
						$errorCount +=1;
					}
				}
			}
			else{
				$errorCount += 1;
			}
			// var_dump($errorCount);
			if ($errorCount == 0) {
				if ($JenisTransaksi == 2) {
					$Nocashflow = '';

					$Kolom = 'NoTransaksi';
					$Table = 'cashflow';
					$Prefix = substr(date("Y"), 2,4).date("m")."2";

					$SQL = "SELECT RIGHT(MAX(".$Kolom."),4)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

					// var_dump($SQL);
					$rs = $this->db->query($SQL);

					$temp = $rs->row()->Total + 1;

					$nomor = $Prefix.str_pad($temp, 7,"0",STR_PAD_LEFT);
					if ($nomor != '') {
						$Nocashflow = $nomor;
					}
					else{
						$data['message'] = "Nomor Transaksi Gagal generate";
						goto catchjump;
					}

					$param = array(
						'NoTransaksi' => $Nocashflow,
						'TglTransaksi' => $TglTransaksi,
						'BaseRef' => $BaseRef,
						'Comment' => 'Pengembalian Uang', 
						'Debet' => 0,
						'Credit' => $TotalRetur,
						'ExternalNote' => 'Basedon Return '.$NoTransaksi,
						'Source' => 2
					);
					$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'cashflow');

					if ($call_x) {
						$data['success'] = true;
						$this->db->trans_commit();
					}
				}
				elseif ($JenisTransaksi == 1) {
					$data['success'] = true;
					$this->db->trans_commit();
				}
				else{
					$data['message'] = "Jenis Transaksi Tidak valid";
				}
			}
			else{
				$this->db->trans_rollback();
				goto catchjump;
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
