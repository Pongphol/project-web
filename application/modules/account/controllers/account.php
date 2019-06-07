<?php

class Account extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('account_model', 'acc_model');
	}

    public function register()
	{
		require_no_login('member');

		$data['title'] = 'Register Page';
		$data['content'] = 'register';
		$data['banking_list'] = $this->acc_model->get_banking_list();

        $this->load->view('template', $data);
	}
	
	public function login()
	{
		require_no_login('member');

		$data['title'] = 'Login Page';
		$data['content'] = 'login';
		
		$this->load->view('template', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

	public function signin()
	{
		$data = ['success' => false, 'messages' => []];

		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$config = [
			[
				'field' => 'username',
				'label' => 'ชื่อเข้าใช้งาน',
				'rules' => 'required',
				'errors' => [
					'required' => 'กรุณากรอก {field} หรือ อีเมล'
				]
			],
			[
				'field' => 'password',
				'label' => 'รหัสผ่าน',
				'rules' => 'required',
				'errors' => [
					'required' => 'กรุณากรอก{field}'
				]
			]
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run())
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$account = $this->acc_model->check_login($username, $password);

			if ($account)
			{
				$params = [
					'account_id' => $account->id,
					'account_role' => $account->role
				];

				$data['account_role'] = $account->role;

				$this->session->set_userdata($params);

				$data['success'] = true;
			}
			else
			{
				$data['message'] = 'ไม่พบบัญชีนี้ในระบบ';
			}
		}
		else
		{
			foreach ($_POST as $key => $value)
			{
				$data['messages'][$key] = form_error($key);
			}
		}
		
		echo json_encode($data);
	}
    
	public function add()
	{
		$data = ['success' => false, 'messages' => []];

		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$config = [
			[
				'field' => 'username',
				'label' => 'ชื่อเข้าใช้งาน',
				'rules' => 'required',
				'errors' => [
					'required' => 'กรุณาตั้ง{field}'
				]
			],
			[
				'field' => 'password',
				'label' => 'รหัสผ่าน',
				'rules' => 'required',
				'errors' => [
					'required' => 'กรุณาตั้ง{field}'
				]
			],
			[
				'field' => 'con_password',
				'label' => 'ยืนยันรหัสผ่าน',
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'กรุณา{field}',
					'matches' => 'รหัสผ่านไม่ตรงกัน'
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
				'field' => 'birthday',
				'label' => 'วันเกิด',
				'rules' => 'required',
				'errors' => [
					'required' => 'กรุณาเลือก{field}'
				]
			],
			[
				'field' => 'phone',
				'label' => 'เบอร์โทรศัพท์',
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'กรุณากรอก{field}',
					'numeric' => '{field}ต้องเป็นตัวเลขเท่านั้น'
				]
			],
			[
				'field' => 'gender',
				'label' => 'เพศ',
				'rules' => 'required|callback_empty_check|in_list[male,female]',
				'errors' => [
					'required' => 'กรุณาเลือก{field}',
					'in_list' => ''
				]
			],
			[
				'field' => 'email',
				'label' => 'อีเมล',
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'กรุณากรอก{field}'
				]
			],
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
			],
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run())
		{
			$insert_data = [
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'birthday' => $this->input->post('birthday'),
				'gender' => $this->input->post('gender'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'money' => intval(0)
			];

			$this->db->trans_start();

			$account_id = $this->acc_model->insert_account($insert_data);

			if ($account_id != false)
			{
				$insert_data = [
					'accId' => $account_id,
					'type' => $this->input->post('bank_type'),
					'number' => $this->input->post('bank_number'),
				];

				$this->acc_model->insert_account_banking($insert_data);
				$this->insert_criteria_user($account_id);

				if ($this->db->trans_complete())
				{
					$data['success'] = true;
				}
		
			}
			else
			{
				$data['success'] = false;
			}
		}
		else
		{
			foreach ($_POST as $key => $value)
			{
				$data['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($data);
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

	public function get_criteria_member()
	{
		if (!is_admin())
		{
			return;
		}

		$this->load->model('lotto/lotto_model');

		$criteria = $this->lotto_model->get_criteria_user_by_id($this->input->get('id'));
		$user = $this->acc_model->get_account_data_by_id($this->input->get('id'));

		$result['user_id'] = ($criteria) ? $criteria->user_id : false;
		$result['user_name'] = ($user) ? $user->fname . " " . $user->lname : false;
		$result['criteria'] = ($criteria) ? unserialize(base64_decode($criteria->criteria)) : false;

		echo json_encode($result);
	}

	public function update_criteria_member()
	{
		if (!is_admin())
		{
			return;
		}

		$result['success'] = false;

		$user_id = $this->input->post('id');
		$criteria_json = json_decode($this->input->post('update_data'));
		$criteria = base64_encode(serialize($criteria_json));

		$query = $this->acc_model->update_criteria_user_by_id($criteria, $user_id);

		if ($query)
		{
			$result['success'] = true;
			$result['message'] = 'ข้อมูลถูกอัพเดทแล้ว';
		}

		echo json_encode($result);
	}

	public function get_status_member()
	{
		if (!is_admin())
		{
			return;
		}

		$user = $this->acc_model->get_account_data_by_id($this->input->get('id'));

		$result['result'] = $this->acc_model->get_status_member_by_id($this->input->get('id'));
		$result['user_name'] = ($user) ? $user->fname . " " . $user->lname : false;
		$result['status_member'] = ['disable' => 'ระงับการใช้งาน', 'enable' => 'พร้อมใช้งาน'];
		
		echo json_encode($result);
	}

	public function update_status_member()
	{
		if (!is_admin())
		{
			return;
		}
		
		$data['success'] = false;
		
		$this->acc_model->update_status_member_by_id($this->input->post('status'), $this->input->post('id'));

		if ($this->db->affected_rows() > 0)
		{
			$data['success'] = true;
			$data['message'] = 'อัพเดทสถานะผู้ใช้';
		}

		echo json_encode($data);
	}

	private function insert_criteria_user($id = null)
	{
		$this->load->model('lotto/lotto_model');

		$criteria = $this->lotto_model->get_criteria();
		$criteria_convert =  base64_encode(serialize($criteria));

		$this->acc_model->insert_criteria_user_by_id(
			[
				'user_id' => $id, 
				'criteria' => $criteria_convert
			], $id
		);
	}

}

?>