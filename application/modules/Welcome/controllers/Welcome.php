<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {

	public function index()
	{
		$this->load->model('account/account_model', 'acc_model');
		$this->load->model('lotto/lotto_model');

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

	private function add_lotto_latest()
	{
		$this->load->helper('lotto_helper');
		$this->load->model('lotto/lotto_model');

		$data = get_lotto_array();
		
		$this->lotto_model->insert_lotto($data);
	}

	public function get_lotto_latest()
	{
		$this->load->model('lotto/lotto_model');

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
		$table .= "<td class='number'>" . implode('', $data['prize_first']) . "</td>";
		$table .= "<td class='number'>" . implode('</td><td class="number">', $data['number_back_three']) . "</td>";
		$table .= "<td class='number'>" . implode('</td><td class="number">', $data['number_back_two']) . "</td>";
		$table .= "</tr>";

		echo json_encode($table);
	}
}
