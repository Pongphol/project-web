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
        $result = $this->db->select(
                'created_at, 
                buy_lotto.number, 
                criteria.name, 
                buy_lotto.pay, 
                discount, 
                criteria.pay as pay_rate, 
                status'
            )
            ->from('buy_lotto')
            ->join('criteria', 'buy_lotto.criteria_id = criteria.id', 'LEFT')
            ->where('accId', $id)
            ->get();
        
        return $result->num_rows() > 0 ? $result->result() : false;
    }
}

?>