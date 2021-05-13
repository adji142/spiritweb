<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CashFlow extends CI_Controller {

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

		$TglAwal = $this->input->post('TglAwal');
		$TglAkhir = $this->input->post('TglAkhir');

		$SQL = "SELECT a.*, SUM(Debet - Credit) SaldoAkhir FROM vw_cashflowbasic a WHERE TglTransaksi BETWEEN '".$TglAwal."' AND '".$TglAkhir."' GROUP BY a.NoPenjualan ORDER BY a.NoPenjualan, a.TglTransaksi;";

		$rs = $this->db->query($SQL);

		if ($rs->num_rows()>0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['message'] = 'No Record Found';
		}
		echo json_encode($data);
	}
	public function ReadHeader()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$TglAwal = $this->input->post('TglAwal');
		$TglAkhir = $this->input->post('TglAkhir');

		$SQL = "SELECT 
					NoTransaksi,TglTransaksi,BaseRef,`Comment`,ExternalNote,Source,SUM(Debet - Credit) Saldo
				FROM cashflow WHERE TglTransaksi BETWEEN '".$TglAwal."' AND '".$TglAkhir."' GROUP BY BaseRef ORDER BY BaseRef, TglTransaksi ";
		$rs = $this->db->query($SQL);

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
		$NoTransaksi = $this->input->post('NoTransaksi');

		$rs = $this->ModelsExecuteMaster->FindData(array('BaseRef'=>$NoTransaksi),'cashflow');

		if ($rs->num_rows()>0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['message'] = 'No Record Found';
		}
		echo json_encode($data);
	}
	public function pencairan()
	{
		$data = array('success' => false ,'message'=>array());
		$NoTransaksi = '';
		$NoPenjualan = $this->input->post('NoPenjualan');
		$NoCashFlow = $this->input->post('NoCashFlow');
		$TotalPenjualan = $this->input->post('TotalPenjualan');
		$TglPenjualan = $this->input->post('TglPenjualan');
		$NoRefPenjualan = $this->input->post('NoRefPenjualan');
		$NamaEcommerce = $this->input->post('NamaEcommerce');
		$NominalCair = $this->input->post('NominalCair');
		$Selisih = $this->input->post('Selisih');
		$Keterangan = $this->input->post('Keterangan');

		$Kolom = 'NoTransaksi';
		$Table = 'pencairanecomerce';
		$Prefix = substr(date("Y"), 2,4).date("m")."PD";

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
		$ecomDesc = "";

		switch ($NamaEcommerce) {
			case '1':
				$ecomDesc = "Shopee";
				break;
			case '2':
				$ecomDesc = "Tokopedia";
				break;
			case '3':
				$ecomDesc = "Bukalapak";
				break;
			case '4':
				$ecomDesc = "Lazada";
				break;
			case '5':
				$ecomDesc = "bli bli";
				break;
		}
		$param = array(
			'NoTransaksi' => $NoTransaksi,
			'TglTransaksi' => date("Y-m-d"),
			'BaseRef' => $NoCashFlow,
			'NominalCair' => str_replace(',','',$NominalCair), 
			'NamaEcommerce' => $ecomDesc,
			'NoRef' => $NoRefPenjualan,
			'Keterangan' => $Keterangan,
			'Createdby' => $this->session->userdata('username'),
			'Createon' => date("Y-m-d h:i:sa")
		);
		$this->db->trans_begin();
		try {
			$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'pencairanecomerce');
			if ($call_x) {
				$paramupdatecashflow = array(
					'Credit' 		=> str_replace(',','',$Selisih),
					'ExternalNote'	=> 'Selisih pencairan'
				);
				$rs = $this->ModelsExecuteMaster->ExecUpdate($paramupdatecashflow,array('NoTransaksi'=>$NoCashFlow),'cashflow');
				if ($rs) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$this->db->trans_rollback();
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
					goto jump;
				}
			}
			else{
				$this->db->trans_rollback();
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
		echo json_encode($data);
	}
	public function Adjustment()
	{
		$data = array('success' => false ,'message'=>array());
		$NoTransaksi = '';
		$TglTransaksi = $this->input->post('TglTransaksi');
		$BaseRef = $this->input->post('BaseRef');
		$Comment = $this->input->post('ExternalNote');;
		$Debet = $this->input->post('Debet');
		$Credit = $this->input->post('Credit');
		$ExternalNote = '';
		$Source = 3;
		$JenisPencatatan = $this->input->post('JenisPencatatan');

		$Kolom = 'NoTransaksi';
		$Table = 'cashflow';
		$Prefix = substr(date("Y"), 2,4).date("m")."2";

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),4)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 7,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$NoTransaksi = $nomor;
		}
		else{
			$data['message'] = "Nomor Transaksi Gagal generate";
			goto jump;
		}


		switch ($JenisPencatatan) {
			case '1':
				$ExternalNote = "Koreksi Ongkir";
				break;
			case '2':
				$ExternalNote = "Koreksi Penjualan";
				break;
		}
		$param = array(
			'NoTransaksi' => $NoTransaksi,
			'TglTransaksi' => $TglTransaksi,
			'BaseRef' => $BaseRef,
			'Comment' => $Comment, 
			'Debet' => $Debet,
			'Credit' => $Credit,
			'ExternalNote' => $ExternalNote,
			'Source' => $Source
		);
		$this->db->trans_begin();
		try {
			$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'cashflow');
			if ($call_x) {
				$Penjualan = $this->ModelsExecuteMaster->FindData(array('NoTransaksi'=>$BaseRef),'penjualanheader')->row();
				$paramupdate = array();
				switch ($JenisPencatatan) {
					case '1':
						$paramupdate = array(
							'T_Ongkir'	=> floatval($Penjualan->T_Ongkir) //+ (floatval($Debet) - floatval($Credit))
						);
						break;
					case '2':
						$paramupdate = array(
							'T_GrandTotal'	=> floatval($Penjualan->T_GrandTotal) //+ (floatval($Debet) - floatval($Credit))
						);
						break;
				}
				$rs = $this->ModelsExecuteMaster->ExecUpdate($paramupdate,array('NoTransaksi'=>$BaseRef),'penjualanheader');
				if ($rs) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$this->db->trans_rollback();
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
					goto jump;
				}
			}
			else{
				$this->db->trans_rollback();
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
