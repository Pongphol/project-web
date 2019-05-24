<?php
class Member_model extends CI_Model
{
    public function get_banking_list()
    {
        $banking = $this->db->get('banking');
        return $banking->result_object();
    }

    /*รับข้อมูลธนาคารของ admin*/
    function get_name_banking(){
        $sql = "SELECT id,CONCAT(bank_name,' ',account_number) as name_bank,picture
        FROM `admin_banking`";
        $query = $this->db->query($sql)->result_array();
        return  $query;
    }

    /*เพิ่มข้อมูลการแจ้งฝากเงิน */
    function insert_deposit($data)
    {
       $this->db->insert('deposit_detail', $data);
    }
    /*เพิ่มข้อมูลการแจ้งถอนเงิน */
    function insert_withdraw($data)
    {
        $this->db->insert('withdraw_detail', $data);
    }
    /*อัปเดตเงินของผู้ใช้ */
    function update_monney($data)
    {
        $this->db->update('account', $data);
    }
    /*รับข้อมูลเงินของผู้ใช้ */
    function get_money_user_by_id($userId)
    {
        $sql = "SELECT money FROM account WHERE id = 1";
        $query = $this->db->query($sql)->row();
        return $query;
    }
    /*รับประวัติการแจ้งฝากถอน */
    function get_history_inform_user_by_id($userId)
    {
        $sql ="SELECT accId, amount, create_date ,tranfersDate,status,description FROM deposit_detail
                UNION ALL
                SELECT accId, amount, create_date ,NULL AS tranfersDate,status,description FROM withdraw_detail
                WHERE accId = $userId
                ORDER BY create_date DESC ";
        $query = $this->db->query($sql)->result_array();
        return  $query;
    }
}

?>