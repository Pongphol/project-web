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
	public function inform_deposit_show()
	{
		$data['title'] = 'แจ้งฝาก';
		$data['content'] = 'inform_deposit_withdraw';

		$this->load->model('admin_banking_model','abm');
		$data['bank_admin'] =  $this->abm->get_name_banking();
		print_r($this->abm->get_name_banking());
		$this->load->view('template', $data);
	}

}
