<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Payment extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		require_once(APPPATH.'libraries/midtrans/Midtrans.php');
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
	}
	public function getMetodePembayaran(){
		$data = array('success' => false ,'message'=>array(),'data' => array(), 'token'=>'');

		$token = $this->input->post('token');
		if ($token != "") {
			$SQL = "";
			$SQL .= "SELECT * FROM tpaymentmethod WHERE Active = 1";
			// var_dump($SQL);
			$rs = $this->db->query($SQL);

			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
		}
		else{
			$data['message'] = "Invalid Token";
		}
		echo json_encode($data);
	}
	public function MakePayment()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array(), 'token'=>'','NoTransaksi'=>'');

		$amt = $this->input->post('amt');
		$Adminfee = $this->input->post('Adminfee');
		$first_name = $this->input->post('first_name');
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$Periode = strval(date("Y")).strval(date("m"));
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = $this->ModelsExecuteMaster->midTransServerKey();
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;
		
		$order_id = $Periode.strval(rand());
		$params = array(
		    'transaction_details' => array(
		        'order_id' => $order_id,
		        'gross_amount' => $amt + $Adminfee,
		    ),
		    'customer_details' => array(
		        'first_name' => $first_name,
		        'email' => $email
		    ),
		);
		if ($token!= "") {
			try {
				$snapToken = \Midtrans\Snap::getSnapToken($params);
				
				$param = array(
					'NoTransaksi' => $order_id,
					'TglTransaksi' => date("Y/m/d hh:mm:ss"),
					'TokenMidtrans' => $snapToken,
					'userid' 		=> $first_name,
					'GrossAmt'		=> $amt,
					'Adminfee'		=> $Adminfee
				);

				$this->ModelsExecuteMaster->ExecInsert($param,'thistoryrequest');

				$data['token'] = $snapToken;
				$data['NoTransaksi'] = $order_id;
				$data['success'] = true;
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
				$data['success'] = false;
			}
		}
		else{
			$data['message'] = "InvalidToken";
			$data['success'] = false;
		}

		// var_dump($snapToken);
		echo json_encode($data);
	}
	public function CheckTransaction()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array(), 'token'=>'');

		$NoTransaksi = $this->input->post('NoTransaksi');
		// var_dump($NoTransaksi);
		\Midtrans\Config::$serverKey = $this->ModelsExecuteMaster->midTransServerKey();
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;
		try {
			$status = \Midtrans\Transaction::status($NoTransaksi);
			$data['data'] = $status;
			$data['success'] = true;
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = $e->getMessage();
		}
		echo json_encode($data);
	}
	public function GetNotif(){
		// var_dump($order_id);
		// $data = parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$order_id = $this->input->get('order_id');
		$status_code = $this->input->get('status_code');
		$transaction_status = $this->input->get('transaction_status');
		$data['order_id'] 				= $order_id;
		$data['status_code'] 			= $status_code;
		$data['transaction_status'] 	= $transaction_status;
		// var_dump($data);
		$this->load->view('V_API/paymentfinish',$data);
	}

	public function RecordPayment(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$NoTransaksi = $this->input->post('NoTransaksi');
		$TglTransaksi = $this->input->post('TglTransaksi');
		$TglPencatatan = $this->input->post('TglPencatatan');
		$MetodePembayaran = $this->input->post('MetodePembayaran');
		$GrossAmt = $this->input->post('GrossAmt');
		$AdminFee = $this->input->post('AdminFee');
		$Mid_PaymentType = $this->input->post('Mid_PaymentType');
		$Mid_TransactionID = $this->input->post('Mid_TransactionID');
		$Mid_MechantID = $this->input->post('Mid_MechantID');
		$Mid_Bank = $this->input->post('Mid_Bank');
		$Mid_VANumber = $this->input->post('Mid_VANumber');
		$Mid_SignatureKey = $this->input->post('Mid_SignatureKey');
		$Mid_TransactionStatus = $this->input->post('Mid_TransactionStatus');
		$Mid_FraudStatus = $this->input->post('Mid_FraudStatus');

		$param = array(
			'NoTransaksi' => $NoTransaksi,
			'TglTransaksi' => $TglTransaksi,
			'TglPencatatan' => $TglPencatatan,
			'MetodePembayaran' => $MetodePembayaran,
			'GrossAmt' => $GrossAmt,
			'AdminFee' => $AdminFee,
			'Mid_PaymentType' => $Mid_PaymentType,
			'Mid_TransactionID' => $Mid_TransactionID,
			'Mid_MechantID' => $Mid_MechantID,
			'Mid_Bank' => $Mid_Bank,
			'Mid_VANumber' => $Mid_VANumber,
			'Mid_SignatureKey' => $Mid_SignatureKey,
			'Mid_TransactionStatus' => $Mid_TransactionStatus,
			'Mid_FraudStatus' => $Mid_FraudStatus,
		);

		try {
			$exist = $this->ModelsExecuteMaster->FindData(array('NoTransaksi'=>$NoTransaksi),'topuppayment');
			if ($exist->num_rows() > 0) {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('NoTransaksi'=>$NoTransaksi),'topuppayment');
			}
			else{
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'topuppayment');
			}
			if ($rs) {
				$data['success'] = true;
			}	
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$data['success'] = false;
		}
		echo json_encode($data);
	}
	public function getPaymentHistory(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$userid = $this->input->post('userid');

		$SQL  = "SELECT a.*, b.userid FROM topuppayment a
				INNER JOIN thistoryrequest b on a.NoTransaksi = b.NoTransaksi 
				where a.read = 0 ";
		if ($userid != "") {
			$SQL .= " AND b.userid = '".$userid."' ";
		}

		$rs = $this->db->query($SQL);

		if ($rs) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['success'] = false;
		}
		echo json_encode($data);
	}

	public function cekPaymentStatus(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		\Midtrans\Config::$serverKey = $this->ModelsExecuteMaster->midTransServerKey();
		\Midtrans\Config::$isProduction = false;
		\Midtrans\Config::$isSanitized = true;
		\Midtrans\Config::$is3ds = true;

		$userid = $this->input->post('userid');

		$SQL = "SELECT a.NoTransaksi, a.userid, b.Mid_TransactionStatus FROM thistoryrequest a
				LEFT JOIN topuppayment b on a.NoTransaksi = b.NoTransaksi
				WHERE (COALESCE(b.Mid_TransactionStatus,'') != 'settlement' OR COALESCE(b.Mid_TransactionStatus,'') = '') AND a.userid = '".$userid."'";

		$rs = $this->db->query($SQL);

		if ($rs) {
			$datatable = $rs->result();
			foreach ($datatable as $key) {
				try {
					// Get Transaction Status in Midtrans
					$status = \Midtrans\Transaction::status($key->NoTransaksi);

					// var_dump($status);
					if ($status) {
						// var_dump($status);
						$FindData = $this->ModelsExecuteMaster->FindData(array('NoTransaksi'=>$key->NoTransaksi),'topuppayment');

						if ($FindData->num_rows() >0) {
							$param = array(
								'TglPencatatan' => date("Y-m-d h:i:sa"),
								'Mid_TransactionStatus' => $status->transaction_status
							);
							$updateStatus = $this->ModelsExecuteMaster->ExecUpdate($param,array('NoTransaksi'=>$key->NoTransaksi),'topuppayment');
							if ($updateStatus) {
								$data['success'] = true;
							}
						}
						else{
							if ($status->payment_type == "bank_transfer") {
								$param = array(
									'NoTransaksi' => $key->NoTransaksi,
									'TglTransaksi' => $status->transaction_time,
									'TglPencatatan' => date("Y-m-d h:i:sa"),
									'MetodePembayaran' => $status->payment_type,
									'GrossAmt' => $status->gross_amount,
									'AdminFee' => 0,
									'Mid_PaymentType' => $status->payment_type,
									'Mid_TransactionID' => $status->transaction_id,
									'Mid_MechantID' => $status->merchant_id,
									'Mid_Bank' => $status->va_numbers[0]->bank,
									'Mid_VANumber' => $status->va_numbers[0]->va_number,
									'Mid_SignatureKey' => $status->signature_key,
									'Mid_TransactionStatus' => $status->transaction_status,
									'Mid_FraudStatus' => $status->fraud_status,
								);
							}
							elseif ($status->payment_type == "gopay") {
								$param = array(
									'NoTransaksi' => $key->NoTransaksi,
									'TglTransaksi' => $status->transaction_time,
									'TglPencatatan' => date("Y-m-d h:i:sa"),
									'MetodePembayaran' => $status->payment_type,
									'GrossAmt' => $status->gross_amount,
									'AdminFee' => 0,
									'Mid_PaymentType' => $status->payment_type,
									'Mid_TransactionID' => $status->transaction_id,
									'Mid_MechantID' => $status->merchant_id,
									'Mid_Bank' => '',
									'Mid_VANumber' => '',
									'Mid_SignatureKey' => $status->signature_key,
									'Mid_TransactionStatus' => $status->transaction_status,
									'Mid_FraudStatus' => $status->fraud_status,
								);
							}
							$rs = $this->ModelsExecuteMaster->ExecInsert($param,'topuppayment');
							if ($rs) {
								$data['success'] = true;
							}
						}
					}
				} catch (Exception $e) {
					$data['success'] = true;
					$data['message'] = $e->getMessage();
				}
				
				// $param = array(
				// 	'TglPencatatan' => date("Y-m-d h:i:sa"),
				// 	''
				// );
			}
		}

		echo json_encode($data);
	}

	public function getTransactionHistory(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$userid = $this->input->post('userid');
		$tglawal = $this->input->post('tglawal');
		$tglakhir = $this->input->post('tglakhir');

		$SQL = "SELECT * FROM (
				SELECT 
					'0' Transaksi, a.NoTransaksi,B.TglTransaksi, COALESCE(B.GrossAmt,0) - COALESCE(a.Adminfee,0) Nominal,
					B.MetodePembayaran, a.userid, B.Mid_TransactionStatus,'Top Up Spirit Pay' Keterangan,
					COALESCE(B.Mid_Bank,'') Bank, COALESCE(B.Mid_VANumber,'') VA_Numb,COALESCE(B.Mid_PaymentType,'') Mid_PaymentType
				FROM thistoryrequest a
				INNER JOIN topuppayment B ON a.NoTransaksi = B.NoTransaksi
				WHERE DATE(B.TglTransaksi) BETWEEN '$tglawal' AND '$tglakhir' AND userid = '$userid'

				UNION ALL
				-- 1: Berhasil, 2 : Pending, 3: Gagal, 4:Return
				SELECT 
					a.StatusTransaksi, a.NoTransaksi, a.TglTransaksi, COALESCE(a.Qty ,0) * COALESCE(a.harga,0),
					CONCAT('Pembelian Buku ', b.judul) 'Keterangan', a.userid,
					CASE WHEN a.StatusTransaksi = 1 THEN 'Berhasil' ELSE 
						CASE WHEN a.StatusTransaksi = 2 THEN 'Pending' ELSE 
							CASE WHEN a.StatusTransaksi = 3 THEN 'Gagagl' ELSE 
								CASE WHEN a.StatusTransaksi = 4 THEN 'Return' ELSE 'Undefind Transaction' END
							END 
						END 
					END TransStatus,
					'Pembelian Buku ',
					'' Bank, '' VA_Numb,'' Mid_PaymentType
				FROM transaksi a
				LEFT JOIN tbuku b on a.KodeItem = b.KodeItem
				WHERE DATE(TglTransaksi) BETWEEN '$tglawal' AND '$tglakhir' AND userid = '$userid'
			)trx
			ORDER BY TglTransaksi DESC 
		";

		try{
			$rs = $this->db->query($SQL);
			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			else{
				$data['success'] = false;
				$undone = $this->db->error();
				$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
			}
		}catch (Exception $e) {
			$data['success'] = true;
			$data['message'] = $e->getMessage();
		}

		echo json_encode($data);
	}
	public function chargeGopay(){
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$amt = $this->input->post('amt');
		$Adminfee = $this->input->post('Adminfee');
		$first_name = $this->input->post('first_name');
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$Periode = strval(date("Y")).strval(date("m"));
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = $this->ModelsExecuteMaster->midTransServerKey();
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;
		
		$order_id = $Periode.strval(rand());
		$params = array(
		    'transaction_details' => array(
		        'order_id' => $order_id,
		        'gross_amount' => $amt + $Adminfee,
		    ),
		    'payment_type' => 'gopay',
		    'customer_details' => array(
		        'first_name' => $first_name,
		        'email' => $email
		    ),
		);
		 
		$response = \Midtrans\CoreApi::charge($params);

		$NoTransaksi = $response->order_id;
		$TglTransaksi = $response->transaction_time;
		$TglPencatatan = date("Y/m/d hh:mm:ss");
		$MetodePembayaran = $response->payment_type;
		$GrossAmt = $response->gross_amount;
		$AdminFee = $Adminfee;
		$Mid_PaymentType = $response->payment_type;
		$Mid_TransactionID = $response->transaction_id;
		$Mid_MechantID = $response->merchant_id;
		$Mid_Bank = "";
		$Mid_VANumber = "";
		$Mid_SignatureKey = "";
		$Mid_TransactionStatus = $response->transaction_status;
		$Mid_FraudStatus = $response->fraud_status;

		$param = array(
			'NoTransaksi' => $NoTransaksi,
			'TglTransaksi' => $TglTransaksi,
			'TglPencatatan' => $TglPencatatan,
			'MetodePembayaran' => $MetodePembayaran,
			'GrossAmt' => $GrossAmt,
			'AdminFee' => $AdminFee,
			'Mid_PaymentType' => $Mid_PaymentType,
			'Mid_TransactionID' => $Mid_TransactionID,
			'Mid_MechantID' => $Mid_MechantID,
			'Mid_Bank' => $Mid_Bank,
			'Mid_VANumber' => $Mid_VANumber,
			'Mid_SignatureKey' => $Mid_SignatureKey,
			'Mid_TransactionStatus' => $Mid_TransactionStatus,
			'Mid_FraudStatus' => $Mid_FraudStatus,
		);

		try {
			$exist = $this->ModelsExecuteMaster->FindData(array('NoTransaksi'=>$NoTransaksi),'topuppayment');
			if ($exist->num_rows() > 0) {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('NoTransaksi'=>$NoTransaksi),'topuppayment');
			}
			else{
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'topuppayment');
			}
			if ($rs) {
				$data['success'] = true;
			}	
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$data['success'] = false;
		}
		$data['data'] = $response;
		echo json_encode($data);
	}

	public function testCharge(){
		\Midtrans\Config::$serverKey = $this->ModelsExecuteMaster->midTransServerKey();
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;
		
		// $order_id = $Periode.strval(rand());
		$params = array(
		    'transaction_details' => array(
		        'order_id' => rand(),
		        'gross_amount' => 10000,
		    ),
		    'payment_type' => 'gopay',
		    'customer_details' => array(
		        'first_name' => 'tampan',
		        'email' => 'tampan@tampan.com'
		    ),
		);
		 
		$response = \Midtrans\CoreApi::charge($params);
		var_dump($response);
	}
	public function konfirmasiPayment(){
		$data = array('success' => false ,'message'=>array(),'imageurl'=>array());
		$NoTransaksi = $this->input->post('NoTransaksi');
		$image = $this->input->post('baseimage');
		$imagename = $this->input->post('imagename');

		// var_dump($image.' ; '.$imagename);
		$temp = base64_decode($image);
		$link = 'localData/confirmation/'.$imagename;
		try {
			file_put_contents($link, $temp);	
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}

		$fulllink = base_url().$link;

		$rs = $this->ModelsExecuteMaster->ExecUpdate(array('Attachment'=>$fulllink),array('NoTransaksi'=> $NoTransaksi),'topuppayment');
		if ($rs) {
			$data['success'] = true;
			$data['imageurl'] = $fulllink;
		}
		else{
			$data['message'] = 'Gagal Update Password';
		}
		echo json_encode($data);
	}
}