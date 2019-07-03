<?php

class Lotto_model extends CI_Model
{
    public function get_criteria($select = '*')
    {
        return $this->db->select($select)->get('criteria')->result();
    }

    public function get_criteria_user_by_id($id)
    {
        $result = $this->db->where('user_id', $id)
            ->get('criteria_user');
        return $result->num_rows() > 0 ? $result->row() : false;
    }

    public function get_criteria_by_id($id)
    {
        $result = $this->db->where('id', $id)
            ->get('criteria');
        return $result->num_rows() > 0 ? $result->row() : false;
    }

    public function get_buy_date_lotto_by_id($id)
    {
        $result = $this->db->select('CAST(created_at as date) AS buy_date')
            ->where('accId', $id)
            ->group_by('CAST(created_at AS date)')
            ->order_by('created_at', 'DESC')
            ->get('buy_lotto');
        return $result->num_rows() > 0 ? $result->result() : false;
    }

    public function get_bill_member_by_date($buy_date, $user_id)
    {
        $result = $this->db->select(
                'buy_lotto.bill_id, 
                bill_lotto.name as bill_name, 
                buy_lotto.id as buy_lotto_id, 
                bill_lotto.created_at, 
                buy_lotto.number, 
                criteria_id, 
                criteria.name as criteria_name, 
                buy_lotto.pay, 
                discount, 
                criteria.pay as pay_rate, 
                buy_lotto.status'
            )
            ->from('bill_lotto')
            ->join('buy_lotto', 'buy_lotto.bill_id = bill_lotto.id', 'INNER')
            ->join('criteria', 'criteria.id = buy_lotto.criteria_id', 'INNER')
            ->where('accId', $user_id)
            ->where('DATE(bill_lotto.created_at)', $buy_date)
            ->order_by('bill_id','ASC')
            ->get();
        
            return $result->num_rows() > 0 ? $result->result() : false;
    }

    public function get_sum_bill_by_date($buy_date, $user_id)
    {
        $result = $this->db->select(
                'buy_lotto.bill_id, 
                SUM(buy_lotto.pay - ((criteria.discount / 100) * buy_lotto.pay)) AS pay_all, 
                bill_lotto.name as bill_name'
            )
            ->from('bill_lotto')
            ->join('buy_lotto', 'buy_lotto.bill_id = bill_lotto.id', 'INNER')
            ->join('criteria', 'criteria.id = buy_lotto.criteria_id', 'INNER')
            ->where('accId', $user_id)
            ->where('DATE(bill_lotto.created_at)', $buy_date)
            ->order_by('bill_id','ASC')
            ->group_by('buy_lotto.bill_id')
            ->get();
    
        return $result->num_rows() > 0 ? $result->result() : false;
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
    /*รับข้อมูลหวยในงวดที่ถูกเลือก */
    public function get_lotto_by_dateId($id)
    {
        $sql = "SELECT number, criteria_id, pay, buy_lotto.status
                FROM bill_lotto
                LEFT JOIN buy_lotto ON bill_lotto.id = buy_lotto.bill_id
                LEFT JOIN period ON bill_lotto.period_id = period.id
                WHERE period.id = $id";
        $query = $this->db->query($sql)->result_array();
        return $query; 
    }
}

?>