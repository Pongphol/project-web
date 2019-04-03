<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

	public function index()
	{
		$this->load->view('index');
	}

}
