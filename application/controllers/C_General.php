<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_General extends CI_Controller {

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
	public function ChangeStatus()
	{
		$data = array('success' => false ,'message'=>array());

		$NoTransaksi = $this->input->post('NoTransaksi');
		$TableName = $this->input->post('TableName');
		$Value = $this->input->post('Value');

		$Createdby = $this->session->userdata('username');
		$CreatedOn = date("Y-m-d h:i:sa");

		try {
			$this->db->trans_begin();
			$rs = $this->ModelsExecuteMaster->ExecUpdate(array('StatusTransaksi'=>$Value,'LastUpdatedby'=>$Createdby,'LastUpdatedon'=>$CreatedOn),array('NoTransaksi'=> $NoTransaksi),$TableName);
			if ($rs) {
				$this->db->trans_commit();
				$data['success'] = true;
			}
			else{
				goto catchjump;
			}
		} catch (Exception $e) {
			catchjump:
			$undone = $this->db->error();
			$data['success'] = false;
			$data['message'] = "Sistem Gagal Melakukan Pemrossan Data: ".$undone['message'];
			$this->db->trans_rollback();
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
	public function getDummy()
	{
		$data = array('success' => true ,'message'=>array(),'data' =>array(),'masteralat'=>array());

		$call = $this->db->query("select '' ItemCode,'' KodeItemLama,'' ItemName,0 Qty,'' Satuan,0 Price, 0 Diskon,0 Total");

		$data['data'] = array();

		echo json_encode($data);
	}
	public function GetLevelingHarga()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());
		$Qty = $this->input->post('Qty');

		$SQL = "SELECT * FROM tbmk WHERE ".$Qty." BETWEEN QtyStart AND QtyEnd;";
		$rs = $this->db->query($SQL);

		if ($rs->num_rows() > 0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		echo json_encode($data);
	}

	function cekongkir()
	{
		$data = array('success' => false ,'message'=>array(),'origin_det'=>array(),'dest_det'=>array(),'data'=>array());

		$Kota_origin = $this->input->post('Kota_origin');
		$Kota_Destination = $this->input->post('Kota_Destination');
		$xpdc = $this->input->post('xpdc');
		$berat = $this->input->post('berat');

		$user_id = $this->session->userdata('userid');

		$ro_kotaOri = $this->ModelsExecuteMaster->FindData(array('id'=>$Kota_origin),'ro_regencies')->row()->id_RO;
		$ro_kotaDest = $this->ModelsExecuteMaster->FindData(array('id'=>$Kota_Destination),'ro_regencies')->row()->id_RO;

		if ($berat == 0 ) {
			$berat = 1;
		}
		// var_dump(ROUND($berat);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=".$ro_kotaOri."&destination=".$ro_kotaDest."&weight=".$berat."&courier=".$xpdc,
		  CURLOPT_HTTPHEADER => array(
		    "content-type: application/x-www-form-urlencoded",
		    "key: 66f09fcb700162bd339a522699dd8215"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		// var_dump($response);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			$result = json_decode($response, true);
			// var_dump($result);
		  if ($result['rajaongkir']['status']['code'] == 200){
		  	$data['success'] = true;
		  	$data['data'] = $result['rajaongkir']['results'];
		  	$data['origin_det'] = $result['rajaongkir']['origin_details'];
		  	$data['dest_det'] = $result['rajaongkir']['destination_details'];
		  }
		  else{
		  	$data['message'] = $result['rajaongkir']['status']['description'];
		  }
		}
		echo json_encode($data);
	}
	public function GetBerat()
	{
		$data = array('success' => false ,'message'=>array(),'Berat'=>0);

		$KodeItem = $this->input->post('KodeItem');

		$SQL = "SELECT COALESCE(BeratStandar,0) BeratStandar FROM itemmasterdata WHERE ItemCode = '".$KodeItem."' ";

		$rs = $this->db->query($SQL);
		if ($rs->num_rows() > 0) {
			$data['success'] = true;
			$data['Berat'] = $rs->row()->BeratStandar;
		}
		echo json_encode($data);
	}
	public function Reprint()
	{
		$data = array('success' => false ,'message'=>array());

		$NoTransaksi = $this->input->post('NoTransaksi');

		try {
			$this->db->trans_begin();
			$rs = $this->ModelsExecuteMaster->ExecUpdate(array('Printed'=>0),array('NoTransaksi'=> $NoTransaksi),'penjualanheader');
			if ($rs) {
				$this->db->trans_commit();
				$data['success'] = true;
			}
			else{
				goto catchjump;
			}
		} catch (Exception $e) {
			catchjump:
			$undone = $this->db->error();
			$data['success'] = false;
			$data['message'] = "Sistem Gagal Melakukan Pemrossan Data: ".$undone['message'];
			$this->db->trans_rollback();
		}
		echo json_encode($data);
	}
	public function GetPrintingDocument()
	{
		$data = array();

		$SQL = "SELECT 
				a.NoTransaksi,
				a.TglTransaksi,
				a.Createdby,
				a.T_Bayar,
				a.T_Kembali,
				b.Qty,
				b.Harga,
				c.Article,
				(SELECT NamaPerusahaan FROM tperusahaan LIMIT 1) NamaPerusahaan,
				(SELECT Alamat1 FROM tperusahaan LIMIT 1) Alamat1,
				(SELECT NoTlp FROM tperusahaan LIMIT 1) NoTlp
		FROM penjualanheader a
		LEFT JOIN penjualandetail b on a.NoTransaksi = b.NoTransaksi
		LEFT JOIN vw_stok c on b.KodeItem = c.ItemCode
		WHERE a.Printed = 0 ORDER BY a.TglTransaksi";

		try {
			$rs = $this->db->query($SQL);
			if ($rs->num_rows() > 0) {
				$x = $this->ModelsExecuteMaster->ExecUpdate(array('Printed'=>1),array('NoTransaksi'=> $rs->row()->NoTransaksi),'penjualanheader');
				$data = $rs->result();
			}
		} catch (Exception $e) {
			catchjump:
		}
		echo json_encode($data);
	}

	// Import Excel

	public function importFile(){
		$errorcount = 0;
		$path = './Data';
		// var_dump(APPPATH. "third_party\\PHPExcel.php");
		require_once APPPATH . "third_party/PhpExcel/Classes/PHPExcel.php";

		$config['upload_path'] = $path;
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['remove_spaces'] = TRUE;
		// var_dump($config);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		if (!$this->upload->do_upload('uploadFile')) {
			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());
		}

		if(empty($error)){
			if (!empty($data['upload_data']['file_name'])) {
				$import_xls_file = $data['upload_data']['file_name'];
			}
			else{
				$import_xls_file = 0;
			}
			$inputFileName = $path .'/'. $import_xls_file;
			// var_dump($inputFileName);
			try {
				$this->db->trans_begin();
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$flag = true;
				$i=0;
				$indexitem =0;
				$indexdetail = 0 ;
				$inserdata = [];
				$itemmasterdata = [];
				$mutasiheader = [];
				$mutasidetail = [];

				$SQL = "SELECT RIGHT(MAX(NoTransaksi),4)  AS Total FROM headermutasi WHERE LEFT(NoTransaksi, LENGTH('MTIN')) = 'MTIN'";

				// var_dump($SQL);
				$rs = $this->db->query($SQL);

				$temp = $rs->row()->Total + 1;

				$nomor_mutasi = 'MTIN'.str_pad($temp, 6,"0",STR_PAD_LEFT);

				$mutasiheader['NoTransaksi'] = $nomor_mutasi;
				$mutasiheader['TglTransaksi'] = date("Y-m-d");
				$mutasiheader['TglPencatatan'] = date("Y-m-d h:i:sa");
				$mutasiheader['Mutasi'] = 1;
				$mutasiheader['Keterangan'] = 'Import Excel';
				$mutasiheader['Createdby'] = $this->session->userdata('username');
				$mutasiheader['CreatedOn'] = date("Y-m-d h:i:sa");
				// var_dump($mutasiheader);
				foreach ($allDataInSheet as $value) {
					if($flag){
						$flag =false;
						continue;
					}

					$cekitemexist = $this->ModelsExecuteMaster->FindData(array('KodeItemLama'=>$value['A']),'itemmasterdata');
					// var_dump($cekitemexist->num_rows());
					if ($cekitemexist->num_rows() == 0) {
						$Prefix = '101.';

						$SQL = "SELECT RIGHT(MAX(ItemCode),4)  AS Total FROM itemmasterdata WHERE LEFT(ItemCode, LENGTH('".$Prefix."')) = '".$Prefix."'";

						$rs = $this->db->query($SQL);

						$temp = $rs->row()->Total + 1;

						$nomor = $Prefix.str_pad($temp, 4,"0",STR_PAD_LEFT);
						// var_dump($nomor);
						$itemmasterdata['ItemCode'] = $nomor;
						$itemmasterdata['KodeItemLama'] = $value['A'];
						$itemmasterdata['ItemName'] = $value['D'];
						$itemmasterdata['A_Warna'] = $value['C'];
						$itemmasterdata['A_Motif'] = $value['B'];
						$itemmasterdata['A_Size'] = '3006';
						$itemmasterdata['A_Sex'] = '4003';
						$itemmasterdata['DefaultPrice'] = $value['F'];
						$itemmasterdata['EcomPrice'] = $value['G'];
						$itemmasterdata['ItemGroup'] = 1;
						$itemmasterdata['Satuan'] = 'pcs';
						$itemmasterdata['Createdby'] = $this->session->userdata('username');
						$itemmasterdata['Createdon'] = date("Y-m-d h:i:sa");
						$itemmasterdata['isActive'] = 1;
						$itemmasterdata['BeratStandar'] = 0.75;
						$itemmasterdata['Hpp'] = 0;

						$indexitem++;

						$insertitem = $this->ModelsExecuteMaster->ExecInsert($itemmasterdata,'itemmasterdata');
						if (!$insertitem) {
							$errorcount++;
							goto jump;
						}
					}

					if ($value['E'] * $value['H'] > 0) {
						$cekitemexist = $this->ModelsExecuteMaster->FindData(array('KodeItemLama'=>$value['A']),'itemmasterdata');

						$mutasidetail[$indexdetail]['NoTransaksi'] = $nomor_mutasi;
						$mutasidetail[$indexdetail]['LineNum'] = $indexdetail;
						$mutasidetail[$indexdetail]['KodeItem'] = $cekitemexist->row()->ItemCode;
						$mutasidetail[$indexdetail]['Qty'] = $value['E'];
						$mutasidetail[$indexdetail]['Price'] = $value['H'];
						$mutasidetail[$indexdetail]['LineTotal'] = $value['E'] * $value['H'];
						$mutasidetail[$indexdetail]['CreatedBy'] = $this->session->userdata('username');
						$mutasidetail[$indexdetail]['CreatedOn'] = date("Y-m-d h:i:sa");

						$indexdetail++;
					}

					// $inserdata[$i]['KodeItem'] = $value['A'];
					// $inserdata[$i]['KodeArticleMotif'] = $value['B'];
					// $inserdata[$i]['KodeArticleWarna'] = $value['C'];
					// $inserdata[$i]['NamaItem'] = $value['D'];
					// $inserdata[$i]['Qty'] = $value['E'];
					// $inserdata[$i]['HargaReguler'] = $value['F'];
					// $inserdata[$i]['HargaEcomerce'] = $value['G'];
					// $inserdata[$i]['HPP'] = $value['H'];
					$i++;
				}
				$insertheader = $this->ModelsExecuteMaster->ExecInsert($mutasiheader,'headermutasi');
				if ($insertheader) {
					$insertdetail = $this->ModelsExecuteMaster->ExecInsertBatch($mutasidetail,'detailmutasi');
					if (!$insertdetail) {
						$errorcount += 1;
						goto jump;
					}
				}
				else{
					$errorcount += 1;
					goto jump;
				}
				// var_dump($itemmasterdata);
				// var_dump($mutasiheader);
				// var_dump($mutasidetail);
				jump:
				if ($errorcount>0) {
					$undone = $this->db->error();
					echo "Sistem Gagal Melakukan Pemrossan Data: ".$undone['message'];
					$this->db->trans_rollback();
				}
				else{
					// echo '<script>alert("Done");</script>';
					$this->db->trans_commit();
					redirect('http://opos.dawnstore.id/itemmasterdata');
				}
			} catch (Exception $e) {
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
				. '": ' .$e->getMessage());
			}
		}
		else{
			echo $error['error'];
		}
	}

}
