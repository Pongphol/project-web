<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {

	public function index()
	{
		$this->load->model('account/account_model', 'acc_model');
		$this->load->model('lotto_model');

		$data['title'] = 'หน้าหลัก';
		$data['content'] = 'index';
		$data['account'] = $this->acc_model->get_account_data_by_id($this->session->userdata('account_id'));

		$lotto = $this->lotto_model->select_lotto_latest();

		if (!$lotto)
		{
			$this->add_lotto_latest();
		}

		$this->load->view('template', $data);
	}

	protected function get_lotto($type = 'latest')
	{
		$ch =  curl_init('https://thai-lotto-api.herokuapp.com/' . $type);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

		$result = curl_exec($ch);

		return json_decode($result, true);
	}

	private function add_lotto_latest()
	{
		$this->load->model('lotto_model');

		$response = $this->get_lotto('latest')['response'];

		$data = [
			'date' => stringDateThaiToDate($response['date']),
			'prize_first' => serialize($response['prizes'][0]['number']),
			'number_back_three' => serialize($response['runningNumbers'][1]['number']),
			'number_back_two' => serialize($response['runningNumbers'][2]['number'])
		];
		
		$this->lotto_model->insert_lotto($data);
	}

	public function get_lotto_latest()
	{
		$this->load->model('lotto_model');

		$data = $this->lotto_model->select_lotto_latest();

		$data = ($data) ? unserial($data) : [];
		$table = "";
		$table .= "<tr><td colspan='4' class='text-center font-weight-bold'>ผลการออกรางวัลสลากกินแบ่งรัฐบาลงวดประจำวันที่ " . dateThai($data['date']) . "</td></tr>";

		$table .= "<tr>";
		$table .= "<td>รางวัลที่ 1</td>";
		$table .= "<td colspan='2'>รางวัลเลขท้าย 3 ตัว</td>";
		$table .= "<td>รางวัลเลขท้าย 2 ตัว</td>";
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= "<td>" . implode('', $data['prize_first']) . "</td>";
		$table .= "<td>" . implode('</td><td>', $data['number_back_three']) . "</td>";
		$table .= "<td>" . implode('</td><td>', $data['number_back_two']) . "</td>";
		$table .= "</tr>";

		echo json_encode($table);
	}
}
