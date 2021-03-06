<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

	private $data = false;

	public function __construct()
	{
		parent::__construct();
		require_login('login');
		
		// หลังจากมีการล็อคอินแล้ว
		$this->load->model('account/account_model', 'acc_model');
		$this->data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
	}

	public function index()
	{
		$this->data['title'] = 'Member title';
		$this->data['content'] = 'index';
		
		$this->load->view('template', $this->data);
	}
	/* หน้าจอลงหวย */
	public function buy_lotto()
	{
		$this->load->model('lotto/lotto_model');
        $criteria = $this->lotto_model->get_criteria_user_by_id(get_account_id());
		$this->data['title'] = 'ลงหวย';
		$this->data['content'] = 'buy_lotto';
		$this->data['criteria'] = ($criteria) ? unserialize(base64_decode($criteria->criteria)) : false;
		$this->load->view('template', $this->data);
	}

	/* แสดงข้อมูลของผู้ใช้ */
	public function profile()
	{
		$user_id = $this->session->userdata('account_id');

		$this->data['title'] = 'Profile';
		$this->data['content'] = 'profile';
		$banking = $this->acc_model->get_bank_data_by_id($user_id);
		
		if ($this->data['account'])
		{
			$this->data['account_profile']['ชื่อเข้าใช้งาน'] = $this->data['account']->username;
			$this->data['account_profile']['รหัสผ่าน'] = "
				<input type='password' disabled class='form-control' value='{$this->data['account']->password}'>
				<a href=" . base_url('change_password') . " class='text-info'>เปลี่ยนรหัสผ่าน</a>
			";
			$this->data['account_profile']['อีเมล'] = $this->data['account']->email;
			$this->data['account_profile']['ชื่อ'] = $this->data['account']->fname;
			$this->data['account_profile']['นามสกุล'] = $this->data['account']->lname;
			$this->data['account_profile']['เพศ'] = $this->data['account']->gender == 'male' ? 'ชาย' : 'หญิง';
			$this->data['account_profile']['วันเกิด'] = fullDateTH2($this->data['account']->birthday);
			$this->data['account_profile']['เบอร์โทรศัพท์'] = $this->data['account']->phone;
			$this->data['account_profile']['บัญชีธนาคาร'] = $banking;
			$this->data['account_profile']['บัญชีถูกสร้าง'] = dateTimeThai($this->data['account']->created_at);
			$this->data['account_profile']['บัญชีถูกอัพเดท'] = dateTimeThai($this->data['account']->updated_at);
		}
		
		$this->load->view('template', $this->data);
	}

	/* แสดงหน้าแก้ไขข้อมูล */
	public function edit_profile()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$config = [
			[
				'field' => 'email',
				'label' => 'อีเมล',
				'rules' => 'required|valid_email|is_unique[account.email]',
				'errors' => [
					'required' => 'กรุณากรอก{field}',
					'valid_email' => 'ต้องเป็นอีเมลเท่านั้น',
					'is_unique' => '{field}นี้ถูกใช้งานแล้ว'
				]
			],
			[
				'field' => 'fname',
				'label' => 'ชื่อ',
				'rules' => 'required',
				'errors' => [
					'required' => 'กรุณากรอก{field}'
				]
			],
			[
				'field' => 'lname',
				'label' => 'นามสกุล',
				'rules' => 'required',
				'errors' => [
					'required' => 'กรุณากรอก{field}'
				]
			],
			[
				'field' => 'phone',
				'label' => 'เบอร์โทร',
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'กรุณากรอก{field}',
					'numeric' => '{field}ต้องเป็นตัวเลขเท่านั้น'
				]
			],
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run())
		{
			$id = $this->session->userdata('account_id');

			$update_data = [
				'email' => $this->input->post('email'),
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'phone' => $this->input->post('phone'),
				'phone' => $this->input->post('phone'),
				'updated_at' => date("Y-m-d H:i:s")
			];

			$this->acc_model->update_account($update_data, $id);

			if ($this->db->affected_rows() == '1')
			{
				$this->session->set_flashdata('success', 'อัพเดทข้อมูลเรียบร้อย');
			}

			redirect('profile');
		}
		else
		{
			$this->data['title'] = 'Edit Profile';
			$this->data['content'] = 'edit_profile';
			$this->data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			
			$this->load->view('template', $this->data);
		}

	}

	/* แสดงหน้าเปลี่ยนรหัสผ่าน */
	public function change_password()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$config = [
			[
				'field' => 'current_password',
				'label' => 'รหัสผ่านปัจจุบัน',
				'rules' => 'required|alpha_numeric|callback_current_password_check',
				'errors' => [
					'required' => 'กรุณากรอก{field}',
					'alpha_numeric' => '{field}ต้องเป็นอังกฤษหรือตัวเลขเท่านั้น'
				]
			],
			[
				'field' => 'password',
				'label' => 'รหัสผ่านใหม่',
				'rules' => 'required|alpha_numeric',
				'errors' => [
					'required' => 'กรุณากรอก{field}',
					'alpha_numeric' => '{field}ต้องเป็นอังกฤษหรือตัวเลขเท่านั้น'
				]
			],
			[
				'field' => 'con_password',
				'label' => 'ยืนยันรหัสผ่าน',
				'rules' => 'required|alpha_numeric|matches[password]',
				'errors' => [
					'required' => 'กรุณากรอก{field}',
					'alpha_numeric' => '{field}ต้องเป็นอังกฤษหรือตัวเลขเท่านั้น',
					'matches' => 'รหัสผ่านไม่ตรงกัน'
				]
			]
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run())
		{
			$id = $this->session->userdata('account_id');

			$update_data = [
				'password' => $this->input->post('password'),
				'updated_at' => date("Y-m-d H:i:s")
			];

			$this->acc_model->update_account($update_data, $id);

			if ($this->db->affected_rows() == '1')
			{
				$this->session->set_flashdata('success', 'เปลี่ยนรหัสผ่านเรียบร้อย');
			}

			redirect('profile');
		}
		else
		{
			$this->data['title'] = 'Change Password';
			$this->data['content'] = 'change_password';
			$this->data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			
			$this->load->view('template', $this->data);
		}
	}

	public function add_bank_account()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$config = [
			[
				'field' => 'bank_type',
				'label' => 'ธนาคาร',
				'rules' => 'required|callback_empty_check',
				'errors' => [
					'required' => 'กรุณาเลือก{field}'
				]
			],
			[
				'field' => 'bank_number',
				'label' => 'หมายเลขบัญชี',
				'rules' => 'required|alpha_dash',
				'errors' => [
					'required' => 'กรุณากรอก{field}',
					'alpha_dash' => '{field}ไม่ถูกต้อง'
				]
			]
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run())
		{
			$id = $this->session->userdata('account_id');

			$insert_data = [
				'accId' => $id,
				'type' => $this->input->post('bank_type'),
				'number' => $this->input->post('bank_number')
			];

			$this->acc_model->insert_bank_account_by_id($insert_data, $id);

			if ($this->db->affected_rows() == '1')
			{
				$this->session->set_flashdata('success', 'เพิ่มบัญชีธนาคารเรียบร้อย');
			}
			else
			{
				$this->session->set_flashdata('danger', 'ไม่สามารถเพิ่มบัญชีได้');
			}

			redirect('profile');
		}
		else
		{
			$this->data['title'] = 'เพิ่มบัญชีธนาคาร';
			$this->data['content'] = 'add_bank_account';
			$this->data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			$this->data['banking_list'] = $this->acc_model->get_banking_list();
			
			$this->load->view('template', $this->data);
		}
	}

	public function delete_bank_account()
	{
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$config = [
			[
				'field' => 'bank_type',
				'label' => 'ธนาคาร',
				'rules' => 'required|callback_empty_check',
				'errors' => [
					'required' => 'กรุณาเลือก{field}'
				]
			]
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run())
		{
			$this->acc_model->delete_bank_account_by_id($this->input->post('bank_type'));

			if ($this->db->affected_rows() > 0)
			{
				$this->session->set_flashdata('success', 'ลบบัญชีธนาคารเรียบร้อย');
			}
			else
			{
				$this->session->set_flashdata('danger', 'ไม่สามารถลบบัญชีได้');
			}

			redirect('profile');
		}
		else
		{
			$this->data['title'] = 'ลบบัญชีธนาคาร';
			$this->data['content'] = 'delete_bank_account';
			$this->data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			$this->data['banking_list'] = $this->acc_model->get_bank_data_by_id($this->session->userdata('account_id'));
			
			$this->load->view('template', $this->data);
		}
	}

	/*แสดงหน้าจอฝากถอน */
	public function inform_deposit_withdraw_show()
	{
		$this->load->model('member_model','mm');

		$this->data['title'] = 'แจ้งฝาก';
		$this->data['content'] = 'inform_deposit_withdraw';
		$this->data['bank_admin'] =  $this->mm->get_name_banking();
		/*To do
			รับ session เพื่อ get ธนาคารของผู้ใช้ */
		$userId = $this->session->userdata('account_id');
		$this->data['bank_user'] = $this->mm->get_name_banking_by_userId($userId);

		$this->load->view('template', $this->data);
	}
	/*บันทึกการแจ้งฝากเงิน */
	function insert_inform_deposit_ajax()
	{
		$this->load->helper('date_helper');
		$this->load->model('member_model','mm');

		$data = [
			'accId' => $this->session->userdata('account_id'),
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
		$id_user = $this->session->userdata('account_id');
		$withdraw_money = $this->input->post('withdraw_money');
		$user_money = $this->mm->get_money_user_by_id($id_user)->money;

		/*เช็คว่ามีการขอถอนเงินมากกว่าจำนวนที่ผู้ใช้มีหรือไม่ */
		if($withdraw_money <= $user_money)
		{
			$data = [
				'accId' => $this->session->userdata('account_id'),
				'amount' => $this->input->post('withdraw_money'),
				'bankId' => $this->input->post('user_bank'),
				'status' => 1, //สถานะรอดำเนินการ
			];
			$this->mm->insert_withdraw($data);

			$update['money'] = $user_money - $withdraw_money;
			$id = $this->session->userdata('account_id');
			$this->mm->update_monney_by_id($update,$id);
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
		$user_id = $this->session->userdata('account_id');
		$data = $this->mm->get_history_inform_user_by_id($user_id); 
		$temp_data = [];
		foreach($data as $row)
		{
			if($row['tranfersDate'] == NULL)
			{
				if($row['status'] == 2)
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateTimeThai3($row['create_date']),
						'status' => "ทำรายการสำเร็จ",
						'detail' => $row['description']
					];
				}
				elseif($row['status'] == 3)
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateTimeThai3($row['create_date']),
						'status' => "การทำรายการถูกปฏิเสธ",
						'detail' => $row['description']
					];
				}
				else
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateTimeThai3($row['create_date']),
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
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateTimeThai3($row['create_date']),
						'status' => "ทำรายการสำเร็จ",
						'detail' => $row['description']
					];
				}
				elseif($row['status'] == 3)
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateTimeThai3($row['create_date']),
						'status' => "การทำรายการถูกปฏิเสธ",
						'detail' => $row['description']
					];
				}
				else
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateTimeThai3($row['create_date']),
						'status' => "กำลังดำเนินการ",
						'detail' => $row['description']
					];
				}
			}
			$newdata[] = $temp_data;
		}
		$table = "";
		foreach($newdata as $row)
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
			$table .= "<td>".$row['amount']."</td>";
			$table .= "<td>".$row['date_time']."</td>";
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

	public function empty_check($str)
	{
		if ($str == '' || empty($str))
		{
			$this->form_validation->set_message('empty_check', 'กรุณาเลือก{field}');
			return false;
		}
		
		return true;
	}

	public function current_password_check($current_password)
	{
		$id = $this->session->userdata('account_id');
		$current_password_from_db = $this->acc_model->get_current_password($id);

		if ($current_password_from_db->password != $current_password)
		{
			$this->form_validation->set_message('current_password_check', '{field}ไม่ถูก');
			return false;
		}

		return true;
	}

	public function get_criteria_ajax()
	{
		$this->load->model('lotto/lotto_model','lm');
		$data = $this->lm->get_criteria();
		echo json_encode($data);
	}

	public function buy_lotto_ajax()
	{
		$this->load->model('member_model','mm');

		/* Insert number lotto  bill */
		$id = $this->session->userdata('account_id');
		$number2 = $this->input->post('number2');
		$number3 = $this->input->post('number3');
		$total_cash = $this->input->post('total_cash');
		$user_money = $this->mm->get_money_user_by_id($id)->money;
		$data = [];

		/* Check date period */

		$last_period = $this->mm->get_last_period_date();
		$current_date = date("Y-m-d H:i:s");
		if($last_period->start_date <= $current_date && $current_date <= $last_period->end_date)
		{
			/* bill lotto */
			$name_bill = $this->input->post('name_bill');
			$data = [
				'name' => $name_bill,
				'status' => 1,
				'period_id' => $last_period->id
			];
			$this->mm->insert_bill_lotto($data);

			/* Get id last bill lotto */
			$id_last_row = $this->mm->get_last_row_bill();

			if($user_money >= $total_cash) // ตรวจสอบว่าเงินของผู้ใช้เพียงพอต่อการซื้อหวยหรือไม่
			{
				$update['money'] = ($user_money - $total_cash);
				$this->mm->update_monney_by_id($update,$id);

				//เลข 2 ตัว
				foreach($number2 as $row)
				{
					if($row['number'] != "")
					{
						if($row['numberTop']  != "")
						{
							$data = [
								'accId' => $this->session->userdata('account_id'),
								'bill_id' => $id_last_row->id,
								'number' => $row['number'],
								'criteria_id' => 5,
								'pay' => $row['numberTop']
							];
							$this->mm->insert_buy_lotto($data);
						}
						if($row['numberTod']  != "")
						{
							$data = [
								'accId' => $this->session->userdata('account_id'),
								'bill_id' => $id_last_row->id,
								'number' => $row['number'],
								'criteria_id' => 4,
								'pay' => $row['numberTod']
							];
							$this->mm->insert_buy_lotto($data);
						}
						if($row['numberBut']  != "")
						{
							$data = [
								'accId' => $this->session->userdata('account_id'),
								'bill_id' => $id_last_row->id,
								'number' => $row['number'],
								'criteria_id' => 6,
								'pay' => $row['numberBut']
							];
							$this->mm->insert_buy_lotto($data);
						}
					}
				}
				// เลข 3 ตัว
				foreach($number3 as $row)
				{
					if($row['number'] != "")
					{
						if($row['numberTop']  != "")
						{
							$data = [
								'accId' => $this->session->userdata('account_id'),
								'bill_id' => $id_last_row->id,
								'number' => $row['number'],
								'criteria_id' => 1,
								'pay' => $row['numberTop']
							];
							$this->mm->insert_buy_lotto($data);
						}
						if($row['numberTod']  != "")
						{
							$data = [
								'accId' => $this->session->userdata('account_id'),
								'bill_id' => $id_last_row->id,
								'number' => $row['number'],
								'criteria_id' => 2,
								'pay' => $row['numberTod']
							];
							$this->mm->insert_buy_lotto($data);
						}
						if($row['numberBut']  != "")
						{
							$data = [
								'accId' => $this->session->userdata('account_id'),
								'bill_id' => $id_last_row->id,
								'number' => $row['number'],
								'criteria_id' => 3,
								'pay' => $row['numberBut']
							];
							$this->mm->insert_buy_lotto($data);
						}
					}
				}
				
				echo json_encode(['status' => 'success']);
			}
			else
			{
				echo json_encode(['status' => 'error']);
			}
		}
		else
		{
			echo json_encode(['status' => 'error_date']);
		}

	}

	public function history_lotto()
	{
		$this->load->model('lotto/lotto_model');

		$this->data['title'] = 'ประวัติการแทง';
		$this->data['content'] = 'history_lotto';
		$this->data['buy_date_lotto'] = $this->lotto_model->get_buy_date_lotto_by_id(get_account_id());

		$this->load->view('template', $this->data);
	}

	public function show_lottery_result()
	{
		$this->data['title'] = 'ประวัติแทงหวย';
		$this->data['content'] = 'show_lottery_result';

		$this->load->view('template', $this->data);
	}

	private function get_lottery_by_period($period)
	{
		//$date = date('Y-m-d',strtotime($date));
		// To do
		$lotto = $this->lotto_model->select_lotto_by_period($period);

		$lotto = ($lotto) ? unserial($lotto) : [];

		return $lotto;
	}

	public function get_lottery_result()
	{
		$this->load->helper('lotto_helper');
		$this->load->model('lotto/lotto_model');

		//รับข้อมูลหวยจากคนที่ใช้งานอยู่
		$list_buy_lotto = $this->lotto_model->get_buy_lotto_by_id(get_account_id());

		foreach($list_buy_lotto as $row)
		{
			//Todo
			$result = $this->get_lottery_by_period($row->period_id);

			if (!empty($result))
			{
				if ($row->criteria_id == '1') // 3 ตัวบน
				{
					$status = lotto_answer($row->number, $result['prize_first'][0], -3);
				}
				elseif ($row->criteria_id == '2') // 3 ตัวโต๊ด
				{
					$status = lotto_answer($row->number, $result['prize_first'][0], -3, true);
				}
				elseif ($row->criteria_id == '3') // 3 ตัวล่าง
				{
					$status = lotto_answer($row->number, $result['number_back_three']);
				}
				elseif ($row->criteria_id == '4') // 2 ตัวโต๊ด
				{
					$status = lotto_answer($row->number, $result['prize_first'][0], -2, true);
				}
				elseif ($row->criteria_id == '5') // 2 ตัวบน
				{
					$status = lotto_answer($row->number, $result['prize_first'][0], -2);
				}
				elseif ($row->criteria_id == '6') // 2 ตัวล่าง
				{
					$status = lotto_answer($row->number, $result['number_back_two'][0]);
				}
				
				if($status  == 'win' && $row->status == 'wait'){
					$this->load->model('member_model','mm'); 
					$user_money = $this->mm->get_money_user_by_id(get_account_id())->money;
					$update['money'] = ($user_money + ($row->pay * $row->pay_rate));
					$this->mm->update_monney_by_id($update,get_account_id());
				}
				
				$this->lotto_model->update_status_lotto_by_id($status, $row->buy_lotto_id);
			}

		}
		/*
		$list_buy_lotto = $this->lotto_model->get_buy_lotto_by_id(get_account_id());
		
		$table = "";

		foreach($list_buy_lotto as $row)
		{
			$status = [
				'wait' => '<label class="text-secondary">รอ</label>',
				'win' => '<label class="text-success">ทายถูก</label>',
				'lose' => '<label class="text-danger">ทายผิด</label>'
			];

			$discount = (($row->discount / 100) * $row->pay);

			$table .= "
				<tr>
					<td>" . dateThai($row->created_at) . "</td>
					<td class='text-info'>{$row->number}</td>
					<td>{$row->criteria_name}</td>
					<td class='text-info'>{$row->pay}</td>
					<td class='text-danger'>-" . $discount . "</td>
					<td class='text-info'>" . ($row->pay - $discount) . "</td>
					<td class='text-success'>" . ($row->pay * $row->pay_rate) . "</td>
					<td>" . $status[$row->status] . "</td>
					<td>" . ($row->status == 'win' ? "<label class='text-success'>" . ($row->pay * $row->pay_rate) . "</label>" : '0') . "</td>
				</tr>
			";
		}
		
		echo json_encode($table);*/
	}

	public function get_bill()
	{
		$this->load->model('lotto/lotto_model');

		$buy_date = $this->input->post('buy_date');
		$list_history_buy_lotto = $this->lotto_model->get_bill_member_by_date($buy_date, get_account_id());
		$sum_bills = $this->lotto_model->get_sum_bill_by_date($buy_date, get_account_id());
		$bill = 0;

		$table = "";

		if (is_array($list_history_buy_lotto))
		{
			foreach($list_history_buy_lotto as $key => $row)
			{
				$status = [
					'wait' => '<label class="text-secondary">รอ</label>',
					'win' => '<label class="text-success">ทายถูก</label>',
					'lose' => '<label class="text-danger">ทายผิด</label>'
				];

				$discount = (($row->discount / 100) * $row->pay);
				$randomKey = generateRandomString(5);

				if ($key == 0)
				{
					$last_bill_id = $row->bill_id;
					
					$table .= '
					<li>
						<div class="lotto_list_head" onclick="showDetail(\'' . $randomKey . '\')"><i class="fa fa-search"></i>
							ชื่อบิล 
							<span class="name">' . $row->bill_name . '</span> | 
							<span class="pay">รวม ' . $sum_bills[$bill]->pay_all . ' บาท</span>
							<span class="time">
								<span class="status-text"> </span>' . dateTimeThai($row->created_at) .'
							</span>
						</div>
						<div id="' . $randomKey . '" class="table-responsive" style="display: none;">
							<table width="100%" class="table table-hover table-bordered showtable history">
								<thead>
									<tr>
										<th>เลข</th>
										<th>รูปแบบ</th>
										<th>จ่ายเต็ม</th>
										<th>ส่วนลด</th>
										<th>จ่ายจริง</th>
										<th>รางวัล</th>
										<th>สถานะ</th>
										<th>ผล</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-info">' . $row->number . '</td>
										<td>' . $row->criteria_name . '</td>
										<td class="text-info">' . $row->pay . '</td>
										<td class="text-danger">-' . $discount . '</td>
										<td class="text-info">' . ($row->pay - $discount) . '</td>
										<td class="text-success">' . ($row->pay * $row->pay_rate) . '</td>
										<td>' . $status[$row->status] . '</td>
										<td>' . ($row->status == 'win' ? '<label class="text-success">' . ($row->pay * $row->pay_rate) . '</label>' : '0') . '</td>
									</tr>
					';
					$bill++;
				}
				elseif($row->bill_id == $last_bill_id)
				{
					$last_bill_id = $row->bill_id;
					$table .= '
							<tr>
								<td class="text-info">' . $row->number . '</td>
								<td>' . $row->criteria_name . '</td>
								<td class="text-info">' . $row->pay . '</td>
								<td class="text-danger">-' . $discount . '</td>
								<td class="text-info">' . ($row->pay - $discount) . '</td>
								<td class="text-success">' . ($row->pay * $row->pay_rate) . '</td>
								<td>' . $status[$row->status] . '</td>
								<td>' . ($row->status == 'win' ? '<label class="text-success">' . ($row->pay * $row->pay_rate) . '</label>' : '0') . '</td>
							</tr>
					';
				}
				else
				{
					$last_bill_id = $row->bill_id;
					$table .= '		</tbody>
								</table>
							</div>
						</li>
					<li>
						<div class="lotto_list_head" onclick="showDetail(\'' . $randomKey . '\')"><i class="fa fa-search"></i>
							ชื่อบิล 
							<span class="name">' . $row->bill_name . '</span> | 
							<span class="pay">รวม ' . $sum_bills[$bill]->pay_all .' บาท</span>
							<span class="time">
								<span class="status-text"> </span>' . dateTimeThai($row->created_at) .'
							</span>
						</div>
						<div id="' . $randomKey . '" class="table-responsive" style="display: none;">
							<table width="100%" class="table table-hover table-bordered showtable history">
								<thead>
									<tr>
										<th>เลข</th>
										<th>รูปแบบ</th>
										<th>จ่ายเต็ม</th>
										<th>ส่วนลด</th>
										<th>จ่ายจริง</th>
										<th>รางวัล</th>
										<th>สถานะ</th>
										<th>ผล</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-info">' . $row->number . '</td>
										<td>' . $row->criteria_name . '</td>
										<td class="text-info">' . $row->pay . '</td>
										<td class="text-danger">-' . $discount . '</td>
										<td class="text-info">' . ($row->pay - $discount) . '</td>
										<td class="text-success">' . ($row->pay * $row->pay_rate) . '</td>
										<td>' . $status[$row->status] . '</td>
										<td>' . ($row->status == 'win' ? '<label class="text-success">' . ($row->pay * $row->pay_rate) . '</label>' : '0') . '</td>
									</tr>
					';
					$bill++;
				}

			}
		}

		echo json_encode($table);
	}
}
