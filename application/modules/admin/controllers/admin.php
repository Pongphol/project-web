<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {
	public function approval_inform()
	{
		$data['title'] = 'อนุมัติแจ้งฝากถอน';
		$data['content'] = 'approval_inform';
		$this->load->view('template', $data);
	}
	function get_inform_deposit_ajax()
	{
		$this->load->model('admin_model','mm');
		$data_deposit = $this->mm->get_inform_deposit();
		echo json_encode($data_deposit);
	}
	function get_inform_withdraw_ajax()
	{
		$this->load->model('admin_model','mm');
		$data_withdraw = $this->mm->get_inform_withdraw();
		echo json_encode($data_withdraw);
	}
}
