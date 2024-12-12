<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddUserPage extends CI_Controller {

	public function index()
	{
		$this->load->view('AddUserPage');
	}
}
