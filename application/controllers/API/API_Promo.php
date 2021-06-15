<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Promo extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
	}

	public function getPromo()
	{
		
	}
}