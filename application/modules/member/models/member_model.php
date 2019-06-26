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
    /*รับข้อมูลธนาคารของ ผู้ใช้โดยใช้ไอดีของผู้ใช้ */
    function get_name_banking_by_userId($id)
    {
        $sql = "SELECT bank_account.id,banking.picture,CONCAT(banking.name,' ',bank_account.number) as name_bank
                FROM `bank_account`
                LEFT JOIN banking ON bank_account.type = banking.id
                WHERE accId = $id";
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
    function update_monney_by_id($data,$id)
    {
        $this->db->where("id",$id)->update('account', $data);
    }
    /*รับข้อมูลเงินของผู้ใช้ */
    function get_money_user_by_id($userId)
    {
        $sql = "SELECT money FROM account WHERE id = $userId";
        $query = $this->db->query($sql)->row();
        return $query;
    }
    /*รับประวัติการแจ้งฝากถอน */
    function get_history_inform_user_by_id($userId)
    {
        $sql ="SELECT accId, amount, create_date ,tranfersDate,status,description FROM deposit_detail
                WHERE accId = $userId
                UNION ALL
                SELECT accId, amount, create_date ,NULL AS tranfersDate,status,description FROM withdraw_detail
                WHERE accId = $userId
                ORDER BY create_date DESC ";
        $query = $this->db->query($sql)->result_array();
        return  $query;
    }
    /*
        เพิ่มข้อมูลเลขหวย
        โดยต้องทำการเพิ่ม bill lotto ก่อน
    */
    function insert_buy_lotto($data)
    {
        $this->db->insert('buy_lotto', $data);
    }
    /*เพิ่มข้อมูลบิลการซื้อหวย*/
    function insert_bill_lotto($data)
    {
        $this->db->insert('bill_lotto', $data);
    }
    /*เพิ่มข้อมูลบิลการซื้อหวย*/
    function get_last_row_bill()
    {
        $sql = "SELECT id 
                FROM date_data 
                ORDER BY id DESC 
                LIMIT 1";
        $query = $this->db->query($sql)->row();
        return  $query;
    }
}

?>