<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

	public function __construct()
    {
		parent::__construct();
		require_login('login');
		$this->load->model('account/account_model', 'acc_model');
    }

	public function index()
	{
		$data['title'] = 'Member title';
		$data['content'] = 'index';
		$data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
		
		$this->load->view('template', $data);
	}

	/* แสดงข้อมูลของผู้ใช้ */
	public function profile()
	{
		$user_id = $this->session->userdata('account_id');

		$data['title'] = 'Profile';
		$data['content'] = 'profile';
		$data['account'] = $this->acc_model->get_account_data_by_id($user_id);
		$banking = $this->acc_model->get_bank_data_by_id($user_id);
		
		if ($data['account'])
		{
			$data['account_profile']['ชื่อเข้าใช้งาน'] = $data['account']->username;
			$data['account_profile']['รหัสผ่าน'] = "
				<input type='password' disabled class='form-control' value='{$data['account']->password}'>
				<a href=" . base_url('change_password') . " class='text-info'>เปลี่ยนรหัสผ่าน</a>
			";
			$data['account_profile']['อีเมล'] = $data['account']->email;
			$data['account_profile']['ชื่อ'] = $data['account']->fname;
			$data['account_profile']['นามสกุล'] = $data['account']->lname;
			$data['account_profile']['เพศ'] = $data['account']->gender == 'male' ? 'ชาย' : 'หญิง';
			$data['account_profile']['วันเกิด'] = fullDateTH2($data['account']->birthday);
			$data['account_profile']['เบอร์โทรศัพท์'] = $data['account']->phone;
			$data['account_profile']['บัญชีธนาคาร'] = $banking;
			$data['account_profile']['บัญชีถูกสร้าง'] = dateThai($data['account']->created_at);
			$data['account_profile']['บัญชีถูกอัพเดท'] = dateThai($data['account']->updated_at);
		}
		
		$this->load->view('template', $data);
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
				'rules' => 'required|valid_email',
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
			$data['title'] = 'Edit Profile';
			$data['content'] = 'edit_profile';
			$data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			
			$this->load->view('template', $data);
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
				'field' => 'password',
				'label' => 'รหัสผ่าน',
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
			$data['title'] = 'Change Password';
			$data['content'] = 'change_password';
			$data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			
			$this->load->view('template', $data);
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
			$data['title'] = 'เพิ่มบัญชีธนาคาร';
			$data['content'] = 'add_bank_account';
			$data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			$data['banking_list'] = $this->acc_model->get_banking_list();
			
			$this->load->view('template', $data);
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
			$id = $this->session->userdata('account_id');

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
			$data['title'] = 'ลบบัญชีธนาคาร';
			$data['content'] = 'delete_bank_account';
			$data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));
			$data['banking_list'] = $this->acc_model->get_bank_data_by_id($this->session->userdata('account_id'));
			
			$this->load->view('template', $data);
		}
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
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateThai3($row['create_date']),
						'status' => "ทำรายการสำเร็จ",
						'detail' => $row['description']
					];
				}
				elseif($row['status'] == 3)
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateThai3($row['create_date']),
						'status' => "การทำรายการถูกปฏิเสธ",
						'detail' => $row['description']
					];
				}
				else
				{
					$temp_data = [
						'inform' => "ถอนเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateThai3($row['create_date']),
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
						'date_time' => dateThai3($row['create_date']),
						'status' => "ทำรายการสำเร็จ",
						'detail' => $row['description']
					];
				}
				elseif($row['status'] == 3)
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateThai3($row['create_date']),
						'status' => "การทำรายการถูกปฏิเสธ",
						'detail' => $row['description']
					];
				}
				else
				{
					$temp_data = [
						'inform' => "เติมเงิน",
						'amount' => number_format($row['amount'],2)." บาท",
						'date_time' => dateThai3($row['create_date']),
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
		else
		{
			return true;
		}
	}

}
