<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

	public function index()
	{
		$data['title'] = 'Member title';
		$data['content'] = 'index';
		$data['message'] = 'Member Page';
		$this->load->view('template', $data);
	}

}
