<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_POS extends CI_Controller {

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

		$SQL = "SELECT 
				a.NoTransaksi,a.TglTransaksi,c.NamaSales as Sales,a.Createdby,
				CASE WHEN a.TransactionType = 1 THEN 'Shopee' ELSE 
					CASE WHEN a.TransactionType = 2 THEN 'Direct Sales' ELSE 
						CASE WHEN a.TransactionType = 3 THEN 'DropShip' ELSE 
							CASE WHEN a.TransactionType = 4 THEN 'Reseller' ELSE '' END
						END
					END
				END TransactionType,
				a.RefNumberTrx,
				d.PaymentTerm,
				a.RefNumberPayment,
				a.PayNow,
				b.NamaCustomer,
				a.T_GrandTotal,
				e.QtyJual,
				f.QtyRetur
			FROM penjualanheader a
			LEFT JOIN tcustomer b on a.KodeCustomer = b.KodeCustomer
			LEFT JOIN tsales c on a.KodeSales = c.KodeSales
			LEFT JOIN tpayment d on a.PaymentTerm = d.id
			LEFT JOIN(
				SELECT z.NoTransaksi,SUM(z.Qty) QtyJual FROM penjualandetail z
				GROUP BY z.NoTransaksi
			)e on e.NoTransaksi = a.NoTransaksi
			LEFT JOIN (
				SELECT y.BaseRef,SUM(x.QtyRetur) QtyRetur, SUM(x.QtyRetur * x.Price) LineTotal FROM returdetail x
				LEFT JOIN returheader y on x.NoTransaksi = y.NoTransaksi
				WHERE y.JenisTransaksi = 2
				GROUP BY y.BaseRef
			)f on f.BaseRef = a.NoTransaksi
			WHERE a.TglTransaksi BETWEEN '".$TglAwal."' AND '".$TglAkhir."'
			AND COALESCE(e.QtyJual,0) - COALESCE(f.QtyRetur,0) > 0
			";

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

		$SQL = "
			SELECT A.KodeItem,B.Article,A.Qty,A.Harga, A.Disc Pot,
			((COALESCE(A.Qty,0) - COALESCE(f.QtyRetur,0)) * COALESCE(A.Harga,0)) - A.Disc AS LineTotal,
			COALESCE(f.QtyRetur,0) QtyRetur
			FROM penjualandetail A 
			LEFT JOIN vw_stok  B on A.KodeItem = B.ItemCode
			LEFT JOIN (
				SELECT y.BaseRef,x.KodeItemLama,SUM(x.QtyRetur) QtyRetur, SUM(x.QtyRetur * x.Price) LineTotal FROM returdetail x
				LEFT JOIN returheader y on x.NoTransaksi = y.NoTransaksi
				WHERE y.JenisTransaksi = 2
				GROUP BY y.BaseRef,x.KodeItemLama
			)f on f.BaseRef = A.NoTransaksi AND f.KodeItemLama = A.KodeItem
			WHERE A.NoTransaksi = '".$HeaderID."'
		";

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
	public function ReadTagihan()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$NoTransaksi = $this->input->post('NoTransaksi');

		$SQL = "
			SELECT
				a.NoTransaksi,
				a.TglTransaksi,
				c.NamaCustomer,
				a.RefNumberTrx,
				ROUND(a.T_GrandTotal) T_GrandTotal
			FROM penjualanheader a
			LEFT JOIN tcustomer c on a.KodeCustomer = c.KodeCustomer
			WHERE a.NoTransaksi = '".$NoTransaksi."'
		";

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
		$NoCashflow = "";

		$Createdby = $this->session->userdata('username');
		$Createdon = date("Y-m-d h:i:sa");

		// Detail
		$array_header = $this->input->post('array_header');
		$array_detail = $this->input->post('array_detail');


		// NoTransaksi
		$Kolom = 'NoTransaksi';
		$Table = 'penjualanheader';
		$Prefix = 'PJ'.substr(date("Y"), 2,4).date("m");

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
		

		// NoCashFlow
		$Kolom = 'NoTransaksi';
		$Table = 'cashflow';
		$Prefix = 'CF'.substr(date("Y"), 2,4).date("m");

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),4)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 6,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$NoCashflow = $nomor;
		}
		else{
			$data['message'] = "Nomor Transaksi Gagal generate";
			goto jump;
		}

		$isPayNow = 0;

		try {
			$this->db->trans_begin();
			$header = json_decode($array_header);
			$paramheader = array();
			$paramdetail = array();
			if (count($header) > 0) {
				// var_dump($header[0]->RefNumberPayment);
				$paramheader = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $header[0]->TglTransaksi,
					'TglPencatatan' => $Createdon,
					'KodeSales' => $header[0]->KodeSales,
					'TransactionType' => $header[0]->TransactionType,
					'RefNumberTrx' => $header[0]->RefNumberTrx,
					'KodeCustomer' => $header[0]->KodeCustomerPOS,
					'PaymentTerm' => $header[0]->PaymentTerm,
					'RefNumberPayment' => $header[0]->RefNumberPayment,
					'Createdby' => $Createdby,
					'Createdon' => $Createdon,
					'provinsi_dest' => $header[0]->provinsi_dest,
					'Kota_dest' => $header[0]->Kota_dest,
					'Kelurahan_dest' => $header[0]->Kelurahan_dest,
					'Kecamatan_dest' => $header[0]->Kecamatan_dest,
					'KodePos_dest' => $header[0]->KodePOS_dest,
					'Alamat_dest' => $header[0]->Alamat_dest,
					'Nama_dest' => $header[0]->Nama_dest,
					'Notlp_dest' => $header[0]->Notlp_dest,
					'provinsi_ori' => $header[0]->provinsi_ori,
					'Kota_ori' => $header[0]->Kota_ori,
					'Kelurahan_ori' => $header[0]->Kelurahan_ori,
					'Kecamatan_ori' => $header[0]->Kecamatan_ori,
					'KodePOS_ori' => $header[0]->KodePOS_ori,
					'Alamat_ori' => $header[0]->Alamat_ori,
					'Nama_ori' => $header[0]->Nama_ori,
					'Notlp_Ori' => $header[0]->Notlp_Ori,
					'Expedisi' => $header[0]->Expedisi,
					'PayNow' => $header[0]->PayNow,
					'T_SubTotal' => $header[0]->T_SubTotal,
					'T_Diskon' => $header[0]->T_DiskTotal,
					'T_GrandTotal' => $header[0]->T_GrandTotal,
					'T_Bayar' => $header[0]->T_Bayar,
					'T_Kembali' => $header[0]->T_Kembali,
					'T_Ongkir' => $header[0]->T_Ongkir,
					'Servicexpdc' => $header[0]->Servicexpdc,
					'NoResi' => $header[0]->NoResi
				);
				$PayNow = $header[0]->PayNow;
				$appendHeader = $this->ModelsExecuteMaster->ExecInsert($paramheader,'penjualanheader');

				$lineTotal = 0;

				if ($appendHeader) {
					// do looop
					$detail = json_decode($array_detail);
					for ($i=0; $i < count($detail) ; $i++) { 
						// print_r($detail[$i]->ItemCode);
						$paramdetail = array(
							'NoTransaksi' => $NoTransaksi ,
							'BaseRef' => $detail[$i]->BaseRef,
							'KodeItem' => $detail[$i]->ItemCode,
							'Qty' => $detail[$i]->Qty,
							'Satuan' => $detail[$i]->Satuan,
							'Harga' => $detail[$i]->Price,
							'Disc' => $detail[$i]->Diskon,
							'Createdby' => $Createdby,
							'Createdon' => $Createdon
						);
						$appendDetail = $this->ModelsExecuteMaster->ExecInsert($paramdetail,'penjualandetail');
						if ($appendDetail) {
							$data['success'] = true;
							$lineTotal += ($detail[$i]->Qty * $detail[$i]->Price) - $detail[$i]->Diskon;
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

				// append payment

				if ($PayNow == 1) {
					$paramcashflow = array(
						'NoTransaksi' => $NoCashflow,
						'BaseRef' => $NoTransaksi,
						'Comment' => 'Base on '.$NoTransaksi.'',
						'Debet' => $lineTotal + $header[0]->T_Ongkir,
						'Credit' => 0,
						'ExternalNote' => '',
						'Source' => 1,
						'TglTransaksi' => $header[0]->TglTransaksi
					);
					$appendCashflow = $this->ModelsExecuteMaster->ExecInsert($paramcashflow,'cashflow');
					if ($appendCashflow) {
						$data['success'] = true;
					}
					else{
						$errorCount += 1;
					}
				}

			}

			if ($errorCount == 0) {
				$paramlog = array(
					'NoTransaksi' => $NoTransaksi,
					'Sumitedat' => $Createdon,
					'Printed' => 0 
				);
				$appendLog = $this->ModelsExecuteMaster->ExecInsert($paramlog,'printinglog');
				if ($appendLog) {
					$data['success'] = true;
					$this->db->trans_commit();
				}
				else{
					goto catchjump;
				}
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

	public function GetLookup()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$KodeSales = $this->input->post('KodeSales');

		$SQL = "SELECT DISTINCT a.NoTransaksi,a.TglTransaksi,a.KodeSales,d.NamaSales FROM bookheader a
			LEFT JOIN bookdetail b on a.NoTransaksi = b.NoTransaksi
			LEFT JOIN(
				SELECT x.BaseRef,SUM(x.Qty) Qty FROM penjualandetail x
				GROUP BY x.BaseRef
			) c on b.NoTransaksi = c.BaseRef
			LEFT JOIN tsales d on a.KodeSales = d.KodeSales
			WHERE a.StatusTransaksi = 'O' AND COALESCE(b.Qty,0) - COALESCE(c.Qty,0) > 0 AND a.KodeSales = '".$KodeSales."'";

		$rs = $this->db->query($SQL);
		if ($rs->num_rows() > 0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$undone = $this->db->error();
			$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : No Record Found ";
		}
		echo json_encode($data);
	}
	public function Bayar()
	{
		$data = array('success' => false ,'message'=>array());

		$errorCount = 0;

		$NoTransaksiPay = $this->input->post('NoTransaksiPay');
		$TglTransaksiPay = $this->input->post('TglTransaksiPay');
		$NamaCustomerPay = $this->input->post('NamaCustomerPay');
		$TotalTagihanPay = $this->input->post('TotalTagihanPay');
		$PaymentTermPay = $this->input->post('PaymentTermPay');
		$NoRefPay = $this->input->post('NoRefPay');
		$BayarPay = $this->input->post('BayarPay');
		$KembalianPay = $this->input->post('KembalianPay');

		$NoCashflow = '';
		// NoCashFlow
		$Kolom = 'NoTransaksi';
		$Table = 'cashflow';
		$Prefix = 'CF'.substr(date("Y"), 2,4).date("m");

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),4)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 6,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$NoCashflow = $nomor;
		}
		else{
			$data['message'] = "Nomor Transaksi Gagal generate";
		}

		$paramcashflow = array(
			'NoTransaksi' => $NoCashflow,
			'BaseRef' => $NoTransaksiPay,
			'Comment' => 'Pembayaran '.$NoTransaksiPay.'',
			'Debet' => str_replace(',', '', $BayarPay),
			'Credit' => 0,
			'ExternalNote' => '',
			'Source' => 1,
			'TglTransaksi' => date("Y-m-d")
		);
		try {
			$this->db->trans_begin();
			$appendCashflow = $this->ModelsExecuteMaster->ExecInsert($paramcashflow,'cashflow');
			if ($appendCashflow) {
				$paramUpdate = array(
					'PaymentTerm'		=> $PaymentTermPay,
					'RefNumberPayment'	=> $NoRefPay,
					'PayNow'			=> 1,
					'T_Bayar' 			=> str_replace(',', '', $BayarPay),
					'T_Kembali' 		=> str_replace('.', '', $KembalianPay)
				);
				$updatePenjualan = $this->ModelsExecuteMaster->ExecUpdate($paramUpdate,array('NoTransaksi'=>$NoTransaksiPay),'penjualanheader');
				if ($updatePenjualan) {
					$data['success'] = true;
					$this->db->trans_commit();
				}
				else{
					goto catchjump;	
				}
			}
			else{
				goto catchjump;
			}
		}
		catch (Exception $e) {
			catchjump:
			$undone = $this->db->error();
			$data['success'] = false;
			$data['message'] = "Sistem Gagal Melakukan Pemrossan Data: ".$undone['message'];
			$this->db->trans_rollback();
		}
		echo json_encode($data);
	}

}
