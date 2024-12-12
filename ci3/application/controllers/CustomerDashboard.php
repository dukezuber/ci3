<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerDashboard extends CI_Controller {

    public function index()
	{
        require_once APPPATH.'controllers/Header.php';
		$this->load->view('CustomerDashboard');
	}
}
