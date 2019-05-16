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
	/*แสดงหน้าจอฝากถอน */
	public function inform_deposit_show()
	{
		$data['title'] = 'แจ้งฝาก';
		$data['content'] = 'inform_deposit_withdraw';

		$this->load->model('admin_banking_model','abm');
		$data['bank_admin'] =  $this->abm->get_name_banking();
		$this->load->view('template', $data);
	}
	/*แสดงหน้าจอสมัครสมาชิก*/
	public function register()
	{
		$this->load->model('member_model', 'mb_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

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
					'required' => 'กรุณากรอก{field}'
				]
			],
			[
				'field' => 'gender',
				'label' => 'เพศ',
				'rules' => 'required|in_list[male,female]',
				'errors' => [
					'required' => 'กรุณาเลือก{field}'
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
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == false)
        {
			$data['title'] = 'Register Page';
			$data['content'] = 'register';
			$data['banking_list'] = $this->mb_model->get_banking_list();

			$this->load->view('template', $data);
		}
		else
		{
			$data = [
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'birthday' => $this->input->post('birthday'),
				'gender' => $this->input->post('gender'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
			];
			$this->mb_model->add_member($data);
		}

		
	}

}
