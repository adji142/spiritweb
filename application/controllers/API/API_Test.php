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
		// define( 'API_ACCESS_KEY', 'AAAAWRnKigc:APA91bF2DUbxrbIws3clI_lGq40MMbc0x9hjYZjf6xyTGukNVb8BrgIWYTMnz6NB2-ZdGYpVSo2UuKjz3YaVcN777aIU-dGNdTdEYKRtRwYMF0s8gJu5oPLg8zoivTAPQf_pZASw0w4A' );

		\Midtrans\Config::$isProduction = false;
		\Midtrans\Config::$serverKey = $this->ModelsExecuteMaster->midTransServerKey();
		$notif = new \Midtrans\Notification();
		$this->db->query("insert into testCron values('".$notif->order_id;."')");
		echo "hayy saya dapat : ".$order_id;
		// $registrationIds = array();

		// // prep the bundle
		// $msg = array
		// (
		//     'message'   => 'here is a message. message',
		//     'title'     => 'This is a title. title',
		//     'subtitle'  => 'This is a subtitle. subtitle',
		//     'tickerText'    => 'Ticker text here...Ticker text here...Ticker text here',
		//     'vibrate'   => 1,
		//     'sound'     => 1,
		//     'largeIcon' => 'large_icon',
		//     'smallIcon' => 'small_icon'
		// );
		// $fields = array
		// (
		//     'registration_ids'  => $registrationIds,
		//     'data'          => $msg
		// );
		  
		// $headers = array
		// (
		//     'Authorization: key=' . API_ACCESS_KEY,
		//     'Content-Type: application/json'
		// );
		  
		// $ch = curl_init();
		// curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		// curl_setopt( $ch,CURLOPT_POST, true );
		// curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		// curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		// curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		// curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		// $result = curl_exec($ch );
		// curl_close( $ch );
		// echo $result;
	}

}