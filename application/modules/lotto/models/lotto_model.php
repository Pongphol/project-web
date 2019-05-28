<?php

class Lotto_model extends CI_Model
{
    public function get_criteria()
    {
        return $this->db->get('criteria')->result();
    }

    public function update_criteria($data, $id)
    {
        $this->db->where('id', $id)
            ->update('criteria', $data);
    }

    public function get_buy_lotto_by_id($id)
    {
        $result = $this->db->where('accId', $id)
            ->get('buy_lotto');
        
        return $result->num_rows() > 0 ? $result->result() : false;
    }
}

?>