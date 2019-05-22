<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

	public function __construct()
    {
		parent::__construct();
		require_login('login');
		admin_only();
		$this->load->model('account/account_model', 'acc_model');
	}
	
	public function manage_members()
	{
		$data['title'] = 'จัดการสมาชิก';
		$data['content'] = 'manage_members';
		$data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));

		$this->load->view('template', $data);
	}

	public function approval_inform()
	{
		$data['title'] = 'อนุมัติแจ้งฝากถอน';
		$data['content'] = 'approval_inform';
		$this->load->view('template', $data);
	}

	public function get_inform_deposit_ajax()
	{
		$this->load->model('admin_model','mm');
		$data_deposit = $this->mm->get_inform_deposit();
		echo json_encode($data_deposit);
	}

	public function get_inform_withdraw_ajax()
	{
		$this->load->model('admin_model','mm');
		$data_withdraw = $this->mm->get_inform_withdraw();
		echo json_encode($data_withdraw);
	}
}
