<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class ModelsExecuteMaster extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	function ExecUpdate($data,$where,$table)
	{
        $this->db->where($where);
        return $this->db->update($table,$data);
	}
	function ExecInsert($data,$table)
	{
		return $this->db->insert($table,$data);
	}
	function ExecInsertBatch($data,$table)
	{
		return $this->db->insert_batch($table,$data);
	}
	function FindData($where,$table){
		$this->db->where($where);
		return $this->db->get($table);
	}
	function FindDataWithLike($where,$table){
		$this->db->like($where,'both');
		return $this->db->get($table);
	}
	function GetData($table)
	{
		return $this->db->get($table);
	}
	function GetMax($table,$field)
	{
		// 1 : alredy, 0 : first input
		$this->db->select_max($field);
		return $this->db->get($table);
	}
	function DeleteData($where,$table)
	{
		return $this->db->delete($table,$where);
	}
	function GetSaldoStock($kodestock){
		$data = '
				SELECT a.kodestok,SUM(COALESCE(msd.qty,0)) - SUM(COALESCE(pp.qty,0)) - SUM(COALESCE(pj.qty,0)) saldo FROM masterstok a
				LEFT JOIN mutasistokdetail msd on a.id = msd.stokid
				LEFT JOIN post_product pp on a.id = pp.stockid
				LEFT JOIN penjualan pj on pp.id = pj.productid AND pj.statustransaksi = 1
				WHERE msd.canceleddate is null AND a.id = '.$kodestock.'
				GROUP BY a.kodestok
			';
		return $this->db->query($data);
	}
	function ClearImage()
	{
		$data = '
				DELETE FROM imagetable
				where used = 0
			';
		return $this->db->query($data);
	}
	public function CallSP($namasp,$param1)
	{
		$data = 'CALL '.$namasp.'('.$param1.')';
		return $this->db->query($data);
	}
	public function midTransServerKey()
	{
		return "SB-Mid-server-1ZKaHFofItuDXKUri3so2Is1";
	}
	public function SendSpesificEmail($reciept,$subject,$body)
	{
		$this->load->library('email');
		$data = array('success' => false ,'message'=>array());
		// Get Setting
		$this->db->where(array('id'=>1));
		$rs = $this->db->get('temailsetting');
		// End Get Setting
		$config = array(
		    'protocol' 		=> $rs->row()->protocol, // 'mail', 'sendmail', or 'smtp'
		    'smtp_host' 	=> $rs->row()->smtp_host, 
		    'smtp_port' 	=> $rs->row()->smtp_port,
		    'smtp_user' 	=> $rs->row()->smtp_user,
		    'smtp_pass' 	=> $rs->row()->smtp_pass,
		    'smtp_crypto' 	=> $rs->row()->smtp_crypto, //can be 'ssl' or 'tls' for example
		    'mailtype' 		=> $rs->row()->mailtype, //plaintext 'text' mails or 'html'
		    'smtp_timeout' 	=> $rs->row()->smtp_timeout, //in seconds
		    'charset' 		=> $rs->row()->charset,
		    'wordwrap' 		=> $rs->row()->wordwrap
		);
        $this->email->initialize($config);

        $from = $rs->row()->smtp_user;
        $to = $reciept;
        $subject = '[No-Replay]'.$subject.'[No-Replay]';
        $message = $body;

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if($this->email->send()){
        	$data['success'] = true;
        }
        else{
        	$data['success'] = false;
        	$data['message']=show_error($this->email->print_debugger());
        }
        return $data;
	}
	public function PushEmail($NotificationType,$BaseRef,$ReceipedEmail)
	{
		$param = array(
			'id' =>0,
			'reqTime' =>date("Y-m-d h:i:sa"),
			'NotificationType' => $NotificationType,
			'BaseRef' =>$BaseRef,
			'ReceipedEmail' =>$ReceipedEmail,
			'CreatedOn' =>date("Y-m-d h:i:sa"),
			'Status' =>0
		);
		return $this->db->insert('tpushemail',$param);
	}
}