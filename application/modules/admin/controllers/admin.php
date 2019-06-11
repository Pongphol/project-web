<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

	private $data = false;

	public function __construct()
    {
		parent::__construct();
		require_login('login');
		admin_only();

		// หลังจากมีการล็อคอินแล้วเป็นแอดมิน
		$this->load->model('account/account_model', 'acc_model');
		$this->data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
	}

	public function index()
	{
		redirect('admin/approval_inform');
	}

	public function manage_member()
	{
		$this->load->model('account/account_model');

		$this->data['title'] = 'จัดการสมาชิก';
		$this->data['content'] = 'manage_member';
		$this->data['members'] = $this->account_model->get_all_member();

		$this->load->view('template', $this->data);
	}

	public function get_all_member()
	{
		$this->load->model('account/account_model');
		$members = $this->account_model->get_all_member();
		$data = [];
		
		foreach ($members as $member)
		{
			$sub_array = [];
			$sub_array[] = "{$member->id}";
			$sub_array[] = '<a href="' . base_url('uploads/idcard/') . $member->idcard . '"><img src="' . base_url('uploads/idcard/') . $member->idcard . '" class="img-thumnail" width="70" height="70" /></a>';
			$sub_array[] = "{$member->fname} {$member->lname}";
			$sub_array[] = '
				<button type="button" id="btn_show_change_criteria_user" onclick="getCriteriaMember(' . $member->id . ')" data-toggle="modal" class="btn btn-primary">เปลี่ยนเกณฑ์ตารางหวย</button>
				<button type="button" id="btn_show_status_member" onclick="getStatusMember(' . $member->id . ')" data-toggle="modal" class="btn btn-primary">เปลี่ยนสถานะผู้ใช้</button>
			';
			$data[] = $sub_array;
		}

		$output = [
			'draw' => intval($this->input->post('draw')),
			'recordsTotal' => $this->account_model->get_all_data(),
			'recordsFiltered' => $this->account_model->get_filtered_data(),
			'data' => $data
		];

		echo json_encode($output);
	}

	public function change_price_lotto()
	{
		$this->load->model('admin_model');
		$this->load->model('lotto/lotto_model');

		$this->data['title'] = 'กำหนดราคาหวย';
		$this->data['content'] = 'change_price_lotto';
		$this->data['criteria'] = $this->lotto_model->get_criteria();

		$this->load->view('template', $this->data);
	}

	/*แสดงหน้าจออนุมัติแจ้งฝากถอน */
	public function approval_inform()
	{
		$this->data['title'] = 'อนุมัติแจ้งฝากถอน';
		$this->data['content'] = 'approval_inform';
		
		$this->load->view('template', $this->data);
	}
	/*แสดงหน้าจอประวัติการแจ้งฝากถอน */
	public function history_inform()
	{
		$this->data['title'] = 'ประวัติการแจ้งฝากถอน';
		$this->data['content'] = 'history_inform';
		
		$this->load->view('template', $this->data);
	}

	/*รับค่าการแจ้งเติมเงินมาแสดงในตารางอนุมัติการแจ้งเติมเงิน */
	public function get_inform_deposit_ajax()
	{
		$this->load->helper('date_helper');
		$this->load->model('admin_model','mm');
		$data_deposit = $this->mm->get_inform_deposit();
		$table = "";	
		$num = 1;
		foreach($data_deposit as $row)
		{
			$table .= "<tr id='deposit".$num++."'>";
			$table .= "<td><input type='checkbox' class='dep' name='inform' value='".$row['id']."'></td>";
			$table .= "<td>".$row['username']."</td>";
			$table .= "<td>".$row['bank_name']."</td>";
			$table .= "<td>".$row['account_number']."</td>";
			$table .= "<td>".number_format($row['amount'],2)." บาท</td>";
			$table .= "<td>".fullDate($row['tranfersDate'])."</td>";
			$table .= "<td>".$row['tranferTime']." น.</td>";
			$table .= "<td><button type='button' onclick='push_modal_unconfirm_deposit(".$row['id'].")' class='btn btn-danger'>ไม่อนุมัติ</button></td>";
			$table .= "</tr>";
		}
		echo json_encode($table);
	}
	/*รับค่าการแจ้งถอนเงินมาแสดงในตารางอนุมัติการแจ้งถอนเงิน */
	public function get_inform_withdraw_ajax()
	{
		$this->load->model('admin_model','mm');
		$data_withdraw = $this->mm->get_inform_withdraw();
		$table = "";	
		foreach($data_withdraw as $row)
		{
			$table .= "<tr>";
			$table .= "<td><input type='checkbox' class='wit' name='inform' value='".$row['id']."'></td>";
			$table .= "<td>".$row['username']."</td>";
			$table .= "<td>".$row['name']."</td>";
			$table .= "<td>".$row['number']."</td>";
			$table .= "<td>".number_format($row['amount'],2)." บาท</td>";
			$table .= "<td><button type='button' onclick='push_modal_unconfirm_withdraw(".$row['id'].")' class='btn btn-danger'>ไม่อนุมัติ</button></td>";
			$table .= "</tr>";
		}
		echo json_encode($table);
	}
	/*อัพเดตสถานะอนุมัติการแจ้งเติมเงิน */
	public function update_status_confirm_deposit()
	{
		$this->load->model('admin_model','mm');
		$id = $this->input->post('id');
		$deposit_money = $this->mm->get_money_deposit($id);
		foreach($deposit_money as $row)
		{
			$this->mm->update_status_deposit($row['id'],2);
			$current_cash = $this->mm->get_current_user_money($row['id']);
			$update_cash = $current_cash['money'] + $row['amount'];
			$this->mm->update_cash($current_cash['id'],$update_cash);
		}
	}
	/*รับข้อมูลที่ไม่อนุมัตการเติมเงิน */
	public function get_data_unconfirm_deposit()
	{
		$this->load->model('admin_model','mm');
		$this->load->helper('date_helper');
		$id = $this->input->post('id');
		$unconfirm_data = $this->mm->get_data_unconfirm_deposit($id);

		$table = "";
		$table .= "<tr>";
		$table .= "<td>ชื่อผู้ใช้</td>";
		$table .= "<td>".$unconfirm_data['username']."</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td>ธนาคาร</td>";
		$table .= "<td>".$unconfirm_data['bank']."</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td>จำนวนเงินโอน</td>";
		$table .= "<td>".number_format($unconfirm_data['amount'],2)." บาท</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td>วันที่</td>";
		$table .= "<td>".fullDate($unconfirm_data['tranfersDate'])."</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td>เวลา</td>";
		$table .= "<td>".$unconfirm_data['tranferTime']." น.</td>";
		$table .= "</tr>";

		if($unconfirm_data['detail'] == null)
		{
			$unconfirm_data['detail'] = "-";
		}
		$table .= "<tr>";
		$table .= "<td>รายละเอียด</td>";
		$table .= "<td rowspan='5'>".$unconfirm_data['detail']."</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td colspan='2'><div class='form-group'>";
		$table .= "<input type='text' class='form-control' placeholder='ระบุหมายเหตุการไม่อนุมัติ' id='detail_unconfirm_deposit'>";
		$table .= "<div id='validate_detail_unconfirm_dep'></div>";
		$table .= "</div></td>";
		$table .= "</tr>";
		echo json_encode($table);
	}
	/*รับข้อมูลที่ไม่อนุมัติการถอนเงิน */
	public function get_data_unconfirm_withdraw()
	{
		$this->load->model('admin_model','mm');
		$this->load->helper('date_helper');
		$id = $this->input->post('id');

		$unconfirm_data = $this->mm->get_data_unconfirm_withdraw($id);
		$table = "";
		$table .= "<tr>";
		$table .= "<td>ชื่อผู้ใช้</td>";
		$table .= "<td>".$unconfirm_data['username']."</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td>ธนาคาร</td>";
		$table .= "<td>".$unconfirm_data['bank']."</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td>จำนวนเงินโอน</td>";
		$table .= "<td>".number_format($unconfirm_data['amount'],2)." บาท</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td colspan='2'><div class='form-group'>";
		$table .= "<input type='text' class='form-control' placeholder='ระบุหมายเหตุการไม่อนุมัติ' id='detail_unconfirm_withdraw'>";
		$table .= "<div id='validate_detail_unconfirm_wit'></div>";
		$table .= "</div></td>";
		$table .= "</tr>";
		echo json_encode($table);
	}
	/*อัพเดตสถานะไม่อนุมัติการแจ้งเติมเงิน */
	public function update_status_unconfirm_deposit()
	{
		$this->load->model('admin_model','mm');
		$id = $this->input->post('id');
		$description = $this->input->post('detail');
		$this->mm->update_status_deposit($id,3,$description);
	}
	/*อัพเดตสถานะการแจ้งถอนเงิน */
	public function update_status_confirm_withdraw()
	{
		$this->load->model('admin_model','mm');
		$id = $this->input->post('id');
		foreach($id as $row)
		{
			$this->mm->update_status_withdraw($row,2);
		}
	}
	/*อัพเดตสถานะไม่อนุมัติการแจ้งถอนเงิน*/
	public function update_status_unconfirm_withdraw()
	{
		$this->load->model('admin_model','mm');
		$id = $this->input->post('id');
		$description = $this->input->post('detail');
		$this->mm->update_status_withdraw($id,3,$description);
	}
	
	/*รับข้อมูลประวัติการแจ้งฝากถอน*/
	public function get_history_inform()
	{
		$this->load->model('admin_model','mm');
		$data = $this->mm->get_history_inform();
		$temp_data = [];
		foreach($data as $row)
		{
			if($row['tranfersDate'] == NULL)
			{
				if($row['status'] == 2)
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'user' => $row['username'],
						'amount' => number_format($row['amount'],2)." บาท",
						'create_date' => dateTimeThai3($row['create_date']),
						'updated_at' => dateTimeThai3($row['updated_at']),
						'status' => "ทำรายการสำเร็จ",
						'detail' => $row['description']
					];
				}
				elseif($row['status'] == 3)
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'user' => $row['username'],
						'amount' => number_format($row['amount'],2)." บาท",
						'create_date' => dateTimeThai3($row['create_date']),
						'updated_at' => dateTimeThai3($row['updated_at']),
						'status' => "การทำรายการถูกปฏิเสธ",
						'detail' => $row['description']
					];
				}
				else
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'user' => $row['username'],
						'amount' => number_format($row['amount'],2)." บาท",
						'create_date' => dateTimeThai3($row['create_date']),
						'updated_at' => dateTimeThai3($row['updated_at']),
						'status' => "กำลังดำเนินการ",
						'detail' => $row['description']
					];
				}
			}
			else
			{
				if($row['status'] == 2)
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'user' => $row['username'],
						'amount' => number_format($row['amount'],2)." บาท",
						'create_date' => dateTimeThai3($row['create_date']),
						'updated_at' => dateTimeThai3($row['updated_at']),
						'status' => "ทำรายการสำเร็จ",
						'detail' => $row['description']
					];
				}
				elseif($row['status'] == 3)
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'user' => $row['username'],
						'amount' => number_format($row['amount'],2)." บาท",
						'create_date' => dateTimeThai3($row['create_date']),
						'updated_at' => dateTimeThai3($row['updated_at']),
						'status' => "การทำรายการถูกปฏิเสธ",
						'detail' => $row['description']
					];
				}
				else
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'user' => $row['username'],
						'amount' => number_format($row['amount'],2)." บาท",
						'create_date' => dateTimeThai3($row['create_date']),
						'updated_at' => dateTimeThai3($row['updated_at']),
						'status' => "กำลังดำเนินการ",
						'detail' => $row['description']
					];
				}
			}
			$newdata[] = $temp_data;
		}

		$table = "";
		foreach ($newdata as $row) 
		{
			$table .= "<tr>";
			if( $row['inform'] == "เติมเงิน")
			{
				$table .= "<td class='text-success'>".$row['inform']."</td>";
			}
			else
			{
				$table .= "<td>".$row['inform']."</td>";
			}
			$table .= "<td>".$row['user']."</td>";
			$table .= "<td>".$row['amount']."</td>";
			$table .= "<td>".$row['create_date']."</td>";
			$table .= "<td>".$row['updated_at']."</td>";
			if( $row['status'] == "ทำรายการสำเร็จ" )
			{
				$table .= "<td class='text-success'>".$row['status']."</td>";
			}
			elseif( $row['status'] == "กำลังดำเนินการ" ) 
			{
				$table .= "<td class='text-secondary'>".$row['status']."</td>";
			}
			elseif(  $row['status'] == "การทำรายการถูกปฏิเสธ" )
			{
				$table .= "<td class='text-danger'>".$row['status']."</td>";
			}
			$table .= "<td>".$row['detail']."</td>";
			$table .= "</tr>";
		}
		echo json_encode($table);
	}

	public function update_criteria()
	{
		$this->load->model('admin_model');
		$this->load->model('lotto/lotto_model');

		$data['success'] = false;
		
		$this->lotto_model->update_criteria(
			[
				'discount' => $this->input->post('update_data')[1],
				'pay' => $this->input->post('update_data')[2]
			], $this->input->post('update_data')[0]
		);

		if ($this->db->affected_rows() > 0)
		{
			$data['success'] = true;
		}

		echo json_encode($data);
	}

	public function get_lottery_result()
	{
		$this->load->helper('lotto_helper');
		$this->load->model('lotto/lotto_model');

		$date_lotto = $this->lotto_model->check_lotto_by_date(date('Y-m-d'));

		if ($date_lotto === false)
		{
			// ดึง api ผลหวยแล้วเก็บลงใน database
			$lotto_data = get_lotto_array();
			$this->lotto_model->insert_lotto($lotto_data);
			redirect('');
		}
	}

}
