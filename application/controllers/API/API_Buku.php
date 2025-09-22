<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Buku extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
	}

	public function GetBuku()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$token = $this->input->post('token');

		$kodeBuku 		= $this->input->post('kodeBuku');
		$KodeKategori 	= $this->input->post('KodeKategori');
		$script 		= $this->input->post('script');
		$ordering 		= $this->input->post('ordering');
		$publikasi 		= $this->input->post('publikasi');
		$gratis 		= $this->input->post('gratis');
		$page 			= $this->input->post('page');
		$kriteria 		= $this->input->post('kriteria');

		$maxperpage 	= 4;

		$SQL = "";
		if ($token != '') {

			$SQL .= "SELECT x.*, CASE WHEN x.kategoriID = 0 THEN 'Gratis' ELSE y.NamaKategori END NamaKategori,
				CASE WHEN x.kategoriID NOT IN (SELECT AppValue1 FROM appsetting WHERE AppKey = 'Buku') THEN 
	CONCAT(CASE WHEN x.kategoriID = 0 THEN 'Gratis' ELSE y.NamaKategori END, ' EDISI ', (SELECT fnGetMonthName(MONTH(releasedate))), ' ', YEAR(releasedate))
	ELSE judul END ItemName
				FROM ( SELECT 
						id,KodeItem,0 kategoriID,judul,description,releasedate,
						releaseperiod,picture,harga,ppn,otherprice,epub,
						avgrate,status_publikasi
					FROM tbuku WHERE harga = 0 UNION ALL ";

			$SQL .= "SELECT 
						id,KodeItem,kategoriID,judul,description,releasedate,
						releaseperiod,picture,harga,ppn,otherprice,epub,
						avgrate,status_publikasi
					FROM tbuku)x 
					LEFT JOIN tkategori y on x.kategoriID = y.id
					WHERE 1 = 1 ";

			if ($publikasi != "" ) {
				$SQL .= " AND status_publikasi = ".$publikasi." ";
			}
			if ($KodeKategori != '') {
				$SQL .= " AND kategoriID = ".$KodeKategori." ";
			}

			if ($kodeBuku != '') {
				$SQL .= " AND KodeItem = '".$kodeBuku."' ";
			}

			if ($script != '') {
				$SQL .= " AND ".$script." ";
			}

			if ($gratis == "1") {
				$SQL .= " AND harga = 0 ";
			}

			if ($kriteria != "") {
				$SQL .= " AND CONCAT(x.judul,' ', y.NamaKategori) LIKE '%".$kriteria."%'";
			}

			if ($ordering == '') {
				$SQL .= " ORDER BY releasedate DESC ";
			}
			else{
				$SQL .= " ORDER BY ".$ordering;
			}

			if ($kriteria != "2") {
				$SQL .= "LIMIT ".$page * $maxperpage.",".$maxperpage.";";
			}
			// var_dump($SQL);
			$rs = $this->db->query($SQL);
			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			else{
				$undone = $this->db->error();
				$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
			}

		}
		else{
			$data['message'] = 'Invalid Token';
		}

		echo json_encode($rs->result());
	}
	public function publish(){
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$notification = array("condition"=>"'SpiritBooksNotification' in topics","notification"=>array());
		$KodeItem= $this->input->post('KodeItem');

		try {
			$rs = $this->ModelsExecuteMaster->ExecUpdate(array('status_publikasi'=>1), array('KodeItem'=>$KodeItem),'tbuku');
			if ($rs) {
				// Notification block
				$notification['notification'] = array(
					"title" => "SpiritBooks#Update Buku",
					"body" => "Ada buku baru untuk kamu"
				);
				$this->ModelsExecuteMaster->PushNotification($notification);
				// Notification block
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
		echo json_encode($data);
	}
	public function TopSeller()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$SQL = 'CALL getTopSeller()';

		try {
			$rs = $this->db->query($SQL);
			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			else{
				$undone = $this->db->error();
				$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = "Gagal memproses data ". $e->getMessage();
		}

		echo json_encode($data);
	}

	public function NewRelease()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$SQL = 'CALL getNewRelease()';

		try {
			$rs = $this->db->query($SQL);
			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			else{
				$undone = $this->db->error();
				$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = "Gagal memproses data ". $e->getMessage();
		}

		echo json_encode($data);
	}
	public function SetLastLocation()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$userid = $this->input->post('userid');
		$kodebuku = $this->input->post('kodebuku');
		$lastlocation = $this->input->post('lastlocation');

		$param = array(
			'userid' => $userid,
			'kodebuku' => $kodebuku,
			'lastlocation' => $lastlocation,
		);

		try {
			$lastRecord = $this->ModelsExecuteMaster->FindData(array('userid'=>$userid,'kodebuku'=>$kodebuku),'lastlocation');
			if ($lastRecord->num_rows() > 0) {
				$SQL = "UPDATE ".'lastlocation'." SET lastlocation = '".$lastlocation."' WHERE userid = '".$userid."' AND kodebuku = '".$kodebuku."'" ;
				$rs = $this->db->query($SQL);
				if ($rs) {
					$data['success'] = true;
				}
				else{
					$data['success'] = false;
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
				}
			}
			else{
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'lastlocation');
				if ($call_x) {
					$data['success'] = true;
				}
				else{
					$undone = $this->db->error();
					$data['message'] = "Sistem Gagal Melakukan Pemrosesan Data : ".$undone['message'];
				}
			}
		} catch (Exception $e) {
			$data['success'] = false;
			$data['message'] = "Gagal memproses data ". $e->getMessage();
		}
		echo json_encode($data);
	}

	public function getLastLocation()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$userid = $this->input->post('userid');
		$kodebuku = $this->input->post('kodebuku');

		$lastRecord = $this->ModelsExecuteMaster->FindData(array('userid'=>$userid,'kodebuku'=>$kodebuku),'lastlocation');
		if ($lastRecord->num_rows() > 0) {
			$data['success'] = true;
			$data['data'] = $lastRecord->result();
		}
		echo json_encode($data);
	}

	public function getAllBooks(){
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$token = $this->input->post('token');

		$kodeBuku 		= $this->input->post('kodeBuku');
		$KodeKategori 	= $this->input->post('KodeKategori');
		$script 		= $this->input->post('script');
		$ordering 		= $this->input->post('ordering');
		$publikasi 		= $this->input->post('publikasi');
		$gratis 		= $this->input->post('gratis');
		$page 			= $this->input->post('page');
		$kriteria 		= $this->input->post('kriteria');

		$maxperpage 	= 4;

		$SQL = "";

		if($token != ''){
			$SQL .= "
				SELECT 
					a.kategoriID,
					CASE WHEN a.kategoriID = 0 THEN 'Gratis' ELSE b.NamaKategori END NamaKategori,
					a.harga,
					a.ppn,
					a.otherprice,
					a.picture,
					a.judul,
					a.KodeItem,
					CASE WHEN a.kategoriID NOT IN (SELECT AppValue1 FROM appsetting WHERE AppKey = 'Buku') THEN 
					CONCAT(CASE WHEN a.kategoriID = 0 THEN 'Gratis' ELSE b.NamaKategori END, ' EDISI ', (SELECT fnGetMonthName(MONTH(releasedate))), ' ', YEAR(releasedate))
					ELSE judul END ItemName,
					a.releaseperiod,
					a.description
				FROM tbuku a
				LEFT JOIN tkategori b on a.kategoriID = b.id
				WHERE 1 = 1
			";


			if ($publikasi != "" ) {
				$SQL .= " AND a.status_publikasi = ".$publikasi." ";
			}
			if ($KodeKategori != '') {
				$SQL .= " AND a.kategoriID = ".$KodeKategori." ";
			}

			if ($kodeBuku != '') {
				$SQL .= " AND a.KodeItem = '".$kodeBuku."' ";
			}

			if ($script != '') {
				$SQL .= " AND ".$script." ";
			}

			if ($gratis == "1") {
				$SQL .= " AND a.harga = 0 ";
			}

			if ($kriteria != "") {
				$SQL .= " AND CONCAT(a.judul,' ', b.NamaKategori) LIKE '%".$kriteria."%'";
			}

			if ($ordering == '') {
				$SQL .= " ORDER BY a.releasedate DESC ";
			}
			else{
				$SQL .= " ORDER BY ".$ordering;
			}

			$rs = $this->db->query($SQL);
			if ($rs) {
				$rows = $rs->result();
				$grouped = [];

				foreach ($rows as $row) {
					$kategoriID   = $row->kategoriID;
					$NamaKategori = $row->NamaKategori;

					// Jika kategori belum ada, buat dulu
					if (!isset($grouped[$kategoriID])) {
						$grouped[$kategoriID] = [
							"kategoriID"   => $kategoriID,
							"NamaKategori" => $NamaKategori,
							"data"         => []
						];
					}

					// Masukkan detail buku ke dalam "data"
					$grouped[$kategoriID]["data"][] = [
						"harga"        => $row->harga,
						"ppn"          => $row->ppn,
						"otherprice"   => $row->otherprice,
						"picture"      => $row->picture,
						"judul"        => $row->judul,
						"KodeItem"     => $row->KodeItem,
						"ItemName"     => $row->ItemName,
						"releaseperiod"=> $row->releaseperiod,
						"description"  => $row->description
					];
				}

				// Reset index array agar rapi [0,1,2,...]
				$data['success'] = true;
				$data['data']    = array_values($grouped);

			} else {
				$undone = $this->db->error();
				$data['message'] = 'Gagal Melakukan Pemrosesan data : ' . $undone['message'];
			}
		}
		echo json_encode($data);
	}
}