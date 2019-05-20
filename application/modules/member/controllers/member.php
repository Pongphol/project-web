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

	/*แสดงหน้าจอฝากถอน */
	public function inform_deposit_withdraw_show()
	{
		$this->load->model('member_model','mm');

		$data['title'] = 'แจ้งฝาก';
		$data['content'] = 'inform_deposit_withdraw';
		$data['bank_admin'] =  $this->mm->get_name_banking();
		/*To do
			รับ session เพื่อ get ธนาคารของผู้ใช้ */

		$this->load->view('template', $data);
	}
	/*บันทึกการแจ้งฝากเงิน */
	function insert_inform_deposit_ajax()
	{
		$this->load->helper('date_helper');
		$this->load->model('member_model','mm');

		$data = [
			'accId' => $this->input->post('id_user'),
			'amount' => $this->input->post('refill_money'),
			'bankId' => $this->input->post('admin_bank'),
			'tranfersDate' => splitDateFormTH($this->input->post('date')),
			'tranferTime' => $this->input->post('time'),
			'detail' => $this->input->post('description'),
			'status' => 1 //สถานะรอดำเนินการ
		];
		$this->mm->insert_deposit($data);
		echo "success";
	}
	/*บันทึกการแจ้งถอนเงิน */
	function insert_inform_withdraw_ajax()
	{
		$this->load->model('member_model','mm');
		$id_user = $this->input->post('id_user');
		$withdraw_money = $this->input->post('withdraw_money');
		$user_money = $this->mm->get_money_user_by_id($id_user)->money;

		/*เช็คว่ามีการขอถอนเงินมากกว่าจำนวนที่ผู้ใช้มีหรือไม่ */
		if($withdraw_money <= $user_money)
		{
			$data = [
				'accId' => $this->input->post('id_user'),
				'amount' => $this->input->post('withdraw_money'),
				'bankId' => $this->input->post('user_bank'),
				'status' => 1, //สถานะรอดำเนินการ
			];
			$this->mm->insert_withdraw($data);

			$update['money'] = $user_money - $withdraw_money;
			$this->mm->update_monney($update);
			echo "success";
		}
		else
		{
			echo "error";
		}
	}
	function get_history_inform_ajax()
	{
		$this->load->model('member_model','mm');
		$user_id = $this->input->post('id_user');
		$data = $this->mm->get_history_inform_user_by_id($user_id); //fix รหัสผู้ใช้
		$temp_data = [];
		foreach($data as $row)
		{
			if($row['tranfersDate'] == NULL)
			{
				if($row['status'] == 2)
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'amount' => number_format($row['amount'],2),
						'status' => "ทำรายการสำเร็จ"
					];
				}
				else
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'amount' => number_format($row['amount'],2),
						'status' => "กำลังดำเนินการ"
					];
				}
			}
			else
			{
				if($row['status'] == 2)
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'amount' => number_format($row['amount'],2),
						'status' => "ทำรายการสำเร็จ"
					];
				}
				else
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'amount' => number_format($row['amount'],2),
						'status' => "กำลังดำเนินการ"
					];
				}
			}
			$newdata[] = $temp_data;
		}
		echo json_encode($newdata);
	}

}
