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
		$this->load->helper('date_helper');
		$this->load->model('admin_model','mm');
		$data_deposit = $this->mm->get_inform_deposit();
		$temp_data = [];	
		foreach($data_deposit as $row)
		{
			$temp_data = [
				'id' => $row['id'],
				'userName' => $row['username'],
				'bankName' => $row['bank_name'],
				'bankNumber' => $row['account_number'],
				'amount' => number_format($row['amount'],2),
				'date' => fullDate($row['tranfersDate']),
				'time' => $row['tranferTime']
			];
			$new_data[] = $temp_data;
		}
		echo "<pre>";
		echo print_r($new_data);
		echo "</pre>";
		echo json_encode($data_deposit);
	}

	public function get_inform_withdraw_ajax()
	{
		$this->load->model('admin_model','mm');
		$data_withdraw = $this->mm->get_inform_withdraw();
		$temp_data = [];
		foreach($data_withdraw as $row)
		{
			$temp_data = [
				'id' => $row['id'],
				'username' => $row['username'],
				'name' => $row['name'],
				'number' => $row['number'],
				'amount' => number_format($row['amount'],2)
			];
			$new_data[] = $temp_data;
		}
		echo "<pre>";
		echo print_r($new_data);
		echo "</pre>";
		echo json_encode($data_withdraw);
	}
	function update_status_deposit()
	{
		$this->load->model('admin_model','mm');

		$id = $this->input->post('id');
		$statusId = $this->input->post('status');
		$description = $this->input->post('description');
		$cash = $this->input->post('money');
		if($statusId == 2)//อนุมัติ
		{
			$current_cash = $this->mm->get_current_user_money($id);
			$update_cash = $cuerrent_cash + $cash;
			$this->mm->update_cash($update_cash);
			$this->mm->update_status_inform_deposit($statusId,$description);
		}
		elseif($statusId == 3)//ไม่อนุมัติ
		{
			$this->mm->update_status_inform_deposit($statusId,$description);
		}
		else // อื่นๆ
		{
			echo "function update_status_deposit error";
		}
	}
}
