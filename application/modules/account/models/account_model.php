<?php

class Account_model extends CI_Model
{
    public function get_banking_list()
    {
        $banking = $this->db->get('banking');
        return $banking->result_object();
    }

    public function insert_account($data)
    {
        $this->db->insert('account', $data);
        
        return $this->db->insert_id();
    }

    public function insert_account_banking($data)
    {
        $this->db->insert('bank_account', $data);
        
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function update_account($data, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('account', $data);
    }

    public function check_login($username, $password)
    {
        $account = $this->db
            ->where('username', $username)
            ->or_where('email', $username)
            ->where('password', $password)
            ->get('account');

        $account = $this->db->query(
            'SELECT * FROM account WHERE (username = ? OR email = ?) AND password = ?',
            [$username, $username, $password]
        );
        
        if ($account->num_rows() > 0)
        {
            return $account->row();
        }
    }

    public function get_account_data_by_id($id)
    {
        $account = $this->db->where('id', $id)->get('account');
        return $account->num_rows() == 1 ? $account->row() : false;
    }
}

?>