<?php

class lotto_model extends CI_Model
{
    public function insert_lotto($data)
    {
        $this->db->insert('lotto', $data);
    }

    public function select_lotto_latest()
    {
        $result = $this->db->order_by('id', 'ASC')
            ->limit(1)
            ->get('lotto');

        return ($result->num_rows() > 0) ? $result->row() : false;
    }
}

?>