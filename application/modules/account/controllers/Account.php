<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MX_Controller {

	public function sign_up()
	{
        $data['title'] = "Sign up";
        $data['content'] = "sign_up";
        
        $this->load->view('template',$data);
    }
}