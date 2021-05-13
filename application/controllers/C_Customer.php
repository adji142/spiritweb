<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Customer extends CI_Controller {

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

		$KodeCustomer = $this->input->post('KodeCustomer');

		if ($KodeCustomer == '') {
			$SQL= "SELECT KodeCustomer,NamaCustomer,
				CASE WHEN CustGroup = 1 THEN 'Ecommerce' ELSE 
					CASE WHEN CustGroup = 2 THEN 'Direct Sales' ELSE
						CASE WHEN CustGroup = 3 THEN 'Dropship' ELSE
							CASE WHEN CustGroup = 3 THEN 'Reseller' ELSE
								''
							END
						END
					END
				END GroupCustomer,
				AlamatCustomer,KodePos,Email,NoTlp,NoWA
				FROM tcustomer WHERE isActive = 1 ";
				$rs = $this->db->query($SQL);
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('KodeCustomer'=>$KodeCustomer,'isActive'=>1),'tcustomer');
		}

		if ($rs->num_rows()>0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['message'] = 'No Record Found';
		}
		echo json_encode($data);
	}
	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array());
		
		$KodeCustomer = $this->input->post('KodeCustomer');
		$NamaCustomer = $this->input->post('NamaCustomer');
		$AlamatCustomer = $this->input->post('AlamatCustomer');
		$provinsi = $this->input->post('provinsi');
		$Kota = $this->input->post('Kota');
		$Kelurahan = $this->input->post('Kelurahan');
		$Kecamatan = $this->input->post('Kecamatan');
		$KodePos = $this->input->post('KodePos');
		$Email = $this->input->post('Email');
		$NoTlp = $this->input->post('NoTlp');
		$NoWA = $this->input->post('NoWA');
		$CustGroup = $this->input->post('CustGroup');
		$isActive = 1;
		$CreatedBy = $this->session->userdata('username');
		$CreatedOn = date("Y-m-d h:i:sa");

		// $exploder = explode("|",$ItemGroup[0]);
		$formtype = $this->input->post('formtype');

		if ($formtype == 'add') {
			$param = array(
				'KodeCustomer' => $KodeCustomer,
				'NamaCustomer' => $NamaCustomer,
				'AlamatCustomer' => $AlamatCustomer,
				'provinsi' => $provinsi,
				'Kota' => $Kota,
				'Kelurahan' => $Kelurahan,
				'Kecamatan' => $Kecamatan,
				'KodePos' => $KodePos,
				'Email' => $Email,
				'NoTlp' => $NoTlp,
				'NoWA' => $NoWA,
				'CustGroup' => $CustGroup,
				'isActive' => $isActive,
				'CreatedBy' => $CreatedBy,
				'CreatedOn' => $CreatedOn
			);
		}
		elseif ($formtype == 'edit') {
			$param = array(
				'NamaCustomer' => $NamaCustomer,
				'AlamatCustomer' => $AlamatCustomer,
				'provinsi' => $provinsi,
				'Kota' => $Kota,
				'Kelurahan' => $Kelurahan,
				'Kecamatan' => $Kecamatan,
				'KodePos' => $KodePos,
				'Email' => $Email,
				'NoTlp' => $NoTlp,
				'NoWA' => $NoWA,
				'CustGroup' => $CustGroup,
				'isActive' => $isActive,
				'LastUpdatedBy' => $CreatedBy,
				'LastUpdatedOn' => $CreatedOn
			);
		}
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'tcustomer');
				if ($call_x) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
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
		}
		elseif ($formtype == 'edit') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('KodeCustomer'=> $KodeCustomer),'tcustomer');
				if ($rs) {
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
		}
		elseif ($formtype == 'delete') {
			try {
				$SQL = "UPDATE tcustomer SET isActive = 0 where KodeCustomer = '".$KodeCustomer."'";

				$rs = $this->db->query($SQL);
				if ($rs) {
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
		}
		else{
			$data['success'] = false;
			$data['message'] = "Invalid Form Type";
		}
		echo json_encode($data);
	}
	function GetInfoAddr()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());

		$tipe = $this->input->post('link');
		$idaddr = $this->input->post('idaddr');

		if ($tipe == 'prov') {
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "key: 66f09fcb700162bd339a522699dd8215"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
				$result = json_decode($response, true);
			  	if ($result['rajaongkir']['status']['code'] == 200){
			  		$data['success'] = true;
			  		$data['data'] = $result['rajaongkir']['results'];
			  	}
			}
		}
		if ($tipe == 'kota_RO') {
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "key: 66f09fcb700162bd339a522699dd8215"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  $result = json_decode($response, true);
			  	if ($result['rajaongkir']['status']['code'] == 200){
			  		$data['success'] = true;
			  		$data['data'] = $result['rajaongkir']['results'];
			  	}
			}
		}

		if ($tipe == 'kota') {
			$kota = $this->ModelsExecuteMaster->FindData(array('province_id'=>$idaddr),'ro_regencies');
			$data['success'] = true;
			$data['data'] = $kota->result();
		}
		if ($tipe == 'kec') {
			$kota = $this->ModelsExecuteMaster->FindData(array('regency_id'=>$idaddr),'ro_districts');
			$data['success'] = true;
			$data['data'] = $kota->result();
		}
		if ($tipe == 'kel') {
			$kota = $this->ModelsExecuteMaster->FindData(array('district_id'=>$idaddr),'ro_villages');
			$data['success'] = true;
			$data['data'] = $kota->result();
		}
		echo json_encode($data);
	}

	public function Getindex()
	{
		$data = array('success' => false ,'message'=>array(),'Nomor' => '');

		$Prefix = 'CL';

		$SQL = "SELECT RIGHT(MAX(KodeCustomer),4)  AS Total FROM tcustomer WHERE LEFT(KodeCustomer, LENGTH('".$Prefix."')) = '".$Prefix."'";

		// var_dump($SQL);
		$rs = $this->db->query($SQL);

		$temp = $rs->row()->Total + 1;

		$nomor = $Prefix.str_pad($temp, 4,"0",STR_PAD_LEFT);
		if ($nomor != '') {
			$data['success'] = true;
			$data['Nomor'] = $nomor;
		}
		echo json_encode($data);
	}
}
