<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Test extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
		$this->load->model('LoginMod');
		require_once(APPPATH.'libraries/midtrans/Midtrans.php');
	}

	public function Test()
	{
		// $this->db->query("insert into testCron values(now())");
		define( 'API_ACCESS_KEY', 'AAAAWRnKigc:APA91bF2DUbxrbIws3clI_lGq40MMbc0x9hjYZjf6xyTGukNVb8BrgIWYTMnz6NB2-ZdGYpVSo2UuKjz3YaVcN777aIU-dGNdTdEYKRtRwYMF0s8gJu5oPLg8zoivTAPQf_pZASw0w4A' );

		\Midtrans\Config::$isProduction = $this->ModelsExecuteMaster->midTransProduction();
		\Midtrans\Config::$serverKey = $this->ModelsExecuteMaster->midTransServerKey();
		$notif = new \Midtrans\Notification();
		// $this->db->query("insert into testCron values('".$notif->order_id."')");

		// echo "hayy saya dapat : ".$order_id;
		$order_id = $notif->order_id;
		// $order_id = '2021081204799914';
		$SQL = "
			SELECT b.token,a.Mid_TransactionStatus FROM topuppayment a 
			INNER JOIN users b on a.UserID = b.username
			WHERE a.NoTransaksi = '".$order_id."'
		";
		
		$rs = $this->db->query($SQL);
		if ($rs) {
			// var_dump($rs->row());
			$registrationIds = array($rs->row()->token);

			// prep the bundle
			if ($rs->row()->Mid_TransactionStatus != 'settlement') {
				$msg = array
				(
				    'message'   => 'Permintaan Pembayaran anda sudah kami terima', //
				    'title'     => 'SpiritBooks#Proses Pembayaran',
				    'subtitle'  => 'This is a subtitle. subtitle',
				    'tickerText'    => 'Ticker text here...Ticker text here...Ticker text here',
				    'vibrate'   => 1,
				    'sound'     => 1,
				    'largeIcon' => 'large_icon',
				    'smallIcon' => 'small_icon'
				);
			}
			else{
				$msg = array
				(
				    'message'   => 'Pembayran anda berhasil terkonfirmasi', // 
				    'title'     => 'SpiritBooks#Pembayaran Berhasil',
				    'subtitle'  => 'This is a subtitle. subtitle',
				    'tickerText'    => 'Ticker text here...Ticker text here...Ticker text here',
				    'vibrate'   => 1,
				    'sound'     => 1,
				    'largeIcon' => 'large_icon',
				    'smallIcon' => 'small_icon'
				);
			}
			$fields = array
			(
			    'registration_ids'  => $registrationIds,
			    'data'          => $msg
			);
			  
			$headers = array
			(
			    'Authorization: key=' . API_ACCESS_KEY,
			    'Content-Type: application/json'
			);
			  
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch );
			curl_close( $ch );
			echo $result;	
		}
	}


	public function TestNotif()
	{
		$notification = array("condition"=>"'SpiritBooksNotification' in topics","notification"=>array());
		$notification['notification'] = array(
			"title" => "temanmesra.zyz",
			"body" => "Bohay"
		);
		// echo json_encode($data);
		$this->ModelsExecuteMaster->PushNotification($data);
	}
}