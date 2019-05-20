<?php
class Member_model extends CI_Model
{
    public function get_banking_list()
    {
        $banking = $this->db->get('banking');
        return $banking->result_object();
    }
}

?>