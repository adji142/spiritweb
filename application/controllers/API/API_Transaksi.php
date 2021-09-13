<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Transaksi extends CI_Controller {

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


	public function cekBooksTransaction(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$userid = $this->input->post('userid');
		$kodeitem = $this->input->post('kodeitem');

		$SQL = "SELECT * FROM transaksi where UserID = '".$userid."'
				AND KodeItem = '".$kodeitem."' AND StatusTransaksi = 1
				";

		try {
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
		} catch (Exception $e) {
			$data['success'] = true;
			$data['message'] = $e->getMessage();
		}
		echo json_encode($data);
	}

	public function addTransaction(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$NoTransaksi = "";
		$TglTransaksi = date("Y-m-d h:i:sa");
		$TglPencatatan = date("Y-m-d h:i:sa");
		$KodeItem = $this->input->post('KodeItem');
		$Qty = $this->input->post('Qty');
		$Harga = $this->input->post('Harga');
		$StatusTransaksi = 1;
		$UserID = $this->input->post('UserID');


		// Generate No Transaksi
		$Kolom = 'NoTransaksi';
		$Table = 'transaksi';
		$Prefix = strval(date("Y")).strval(date("m"));

		$SQL = "SELECT RIGHT(MAX(".$Kolom."),6)  AS Total FROM " . $Table . " WHERE LEFT(" . $Kolom . ", LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$NoTransaksi = $Prefix.str_pad($temp, 3,"0",STR_PAD_LEFT);

		// Generate No Transaksi
		$SQL = "SELECT * FROM transaksi where UserID = '".$UserID."'
				AND KodeItem = '".$KodeItem."' AND StatusTransaksi = 1
				";

		$rs = $this->db->query($SQL);
		if ($rs->num_rows() > 0) {
			$data['success'] = false;
			$data['message'] = "Buku ini sudah pernah dibeli";
		}
		else{
			if ($NoTransaksi != "") {
				$param = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi,
					'TglPencatatan' => $TglPencatatan,
					'KodeItem' => $KodeItem,
					'Qty' => $Qty,
					'Harga' => $Harga,
					'StatusTransaksi' => $StatusTransaksi,
					'UserID' => $UserID
				);

				try {
					$insert = $this->ModelsExecuteMaster->ExecInsert($param,'transaksi');
					if ($insert) {
						$data['success'] = true;
					}
					else{
						$data['success'] = false;
						$undone = $this->db->error();
						$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
					}
				} catch (Exception $e) {
					$data['success'] = true;
					$data['message'] = $e->getMessage();
				}
			}
		}
		echo json_encode($data);
	}
	public function getUserBooks(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$userid = $this->input->post('userid');

		$SQL = "";

		$SQL .= "SELECT 
					b.KodeItem,b.judul,a.TglTransaksi, b.picture,
					a.NoTransaksi,c.NamaKategori,b.releaseperiod,
					b.kategoriID,b.description,b.releasedate,
					b.harga,b.ppn,b.otherprice,b.epub,
					b.avgrate,b.status_publikasi
				FROM transaksi a
				LEFT JOIN tbuku b on a.KodeItem = b.KodeItem
				LEFT JOIN tkategori c on b.kategoriID = c.id
				WHERE a.UserID = '".$userid."'
				AND a.StatusTransaksi = 1
				";
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
		echo json_encode($data);
	}
	public function deleteBooks(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$NoTransaksi= $this->input->post('NoTransaksi');

		try {
			$rs = $this->ModelsExecuteMaster->ExecUpdate(array('StatusTransaksi'=>'99'), array('NoTransaksi'=>$NoTransaksi),'transaksi');
			if ($rs) {
				$data['success'] = true;
			}
			else{
				$data['success'] = false;
				$undone = $this->db->error();
				$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $e->getMessage();
		}
		echo json_encode($data);
	}
}