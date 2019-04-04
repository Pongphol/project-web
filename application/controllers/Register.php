<?php
class Register extends CI_Controller {

        public function index()
        {
            $data['text'] = "test";
            $this->load->view('v_register',$data);
        }
}