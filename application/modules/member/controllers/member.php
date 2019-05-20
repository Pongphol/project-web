<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

	public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->load->model('account/account_model', 'acc_model');

		$data['title'] = 'Member title';
		$data['content'] = 'index';
		$data['user'] = $this->acc_model->get_account_data($this->session->userdata('user_id'));

		$this->load->view('template', $data);
	}

}
