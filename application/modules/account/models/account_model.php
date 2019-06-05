<?php

class Account_model extends CI_Model
{
    public function get_banking_list()
    {
        $banking = $this->db->get('banking');
        return $banking->result_object();
    }

    private function make_query()
    {
        $this->db->from('account');
        $this->db->where('role', 'user');

        if ($this->input->post('search')['value'])
        {
            $this->db->group_start();
            $this->db->like('fname', $this->input->post('search')['value']);
            $this->db->or_like('lname', $this->input->post('search')['value']);
            $this->db->group_end();
        }

        if ($this->input->post('length') != -1)
        {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        }
    }

    public function get_all_member()
    {
        $this->make_query();
        $query = $this->db->get();
        
        return $query->num_rows() > 0 ? $query->result() : [];
    }

    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->make_query();

        return $this->db->count_all_results();
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

    public function get_current_password($id)
    {
        $query = $this->db
            ->select('password')
            ->where('id', $id)
            ->get('account');
        return $query->num_rows() == 1 ? $query->row() : false;
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

    
    /* เพิ่มบัญชีธนาคาร */
    public function insert_bank_account_by_id($data, $id)
    {
        $bank_account = $this->db->select('accId')
            ->where('accId', $id)
            ->get('bank_account')
            ->num_rows();
            
        if ($bank_account < 3)
        {
            $this->db->insert('bank_account', $data);
        }   
    }

    public function delete_bank_account_by_id($id)
    {
        $this->db->where('id', $id)
            ->delete('bank_account');
    }

    public function get_account_data_by_id($id)
    {
        $account = $this->db->where('id', $id)->get('account');
        return $account->num_rows() == 1 ? $account->row() : false;
    }

    public function get_bank_data_by_id($id)
    {
        $account = $this->db->select('bank_account.id, banking.name, banking.picture, bank_account.number')
            ->from('bank_account')
            ->where('bank_account.accId', $id)
            ->join('banking', 'bank_account.type = banking.id')
            ->order_by('bank_account.id', 'ASC')
            ->get();

        return $account->num_rows() > 0 ? $account->result() : false;
    }
}

?>