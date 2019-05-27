<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lotto extends MX_Controller {

	private $data = [];

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
        echo modules::run('modules/lotto/choose_criteria');
    }

    public function choose_criteria()
    {
        $this->load->model('lotto_model');

        $this->data['title'] = 'แทงหวย';
		$this->data['content'] = 'choose_criteria';
        $this->data['criteria'] = $this->lotto_model->get_criteria();
        
        $this->load->view('template', $this->data);
    }
}

?>