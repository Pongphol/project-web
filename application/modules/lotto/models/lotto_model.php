<?php

class Lotto_model extends CI_Model
{
    public function get_criteria($select = '*')
    {
        return $this->db->select($select)->get('criteria')->result();
    }

    public function get_criteria_by_id($id)
    {
        $result = $this->db->where('id', $id)
            ->get('criteria');
        return $result->num_rows() == 1 ? $result->row() : false;
    }

    public function update_criteria($data, $id)
    {
        $this->db->where('id', $id)
            ->update('criteria', $data);
    }

    public function update_status_lotto_by_id($status, $id)
    {
        $this->db->where('id', $id)
            ->update('buy_lotto', ['status' => $status, 'updated_at' => date("Y-m-d H:i:s")]);
    }

    public function get_buy_lotto_by_id($id)
    {
        $result = $this->db->select(
                'buy_lotto.id as buy_lotto_id, 
                created_at, 
                buy_lotto.number, 
                criteria_id, 
                criteria.name as criteria_name, 
                buy_lotto.pay, 
                discount, 
                criteria.pay as pay_rate, 
                status'
            )
            ->from('buy_lotto')
            ->join('criteria', 'buy_lotto.criteria_id = criteria.id', 'LEFT')
            ->where('accId', $id)
            ->order_by('created_at','DESC')
            ->get();
        
        return $result->num_rows() > 0 ? $result->result() : false;
    }

    public function insert_lotto($data)
    {
        $result = $this->db->where('date', $data['date'])
            ->limit(1)
            ->get('lotto');
        return $result->num_rows() == 0 ? $this->db->insert('lotto', $data) : false;
    }

    public function select_lotto_by_date($date)
    {
        $result = $this->db->where('date', $date)
            ->limit(1)
            ->get('lotto');
        return $result->num_rows() > 0 ? $result->row() : false;
    }

    public function check_lotto_by_date($date)
    {
        $result = $this->db->where('date', $date)
            ->limit(1)
            ->get('lotto');
        return $result->num_rows() > 0 ? true : false;
    }

    public function select_lotto_latest()
    {
        $result = $this->db->get('lotto');

        return ($result->num_rows() > 0) ? $result->last_row() : false;
    }
}

?>