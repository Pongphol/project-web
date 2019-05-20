<?php

class Admin_model extends CI_Model
{
    /*รับข้อมูลการแจ้งฝากเงิน */
    function get_inform_deposit()
    {
        $sql = "SELECT account.username,banking.name,bank_account.number,tranfersDate,tranferTime
                FROM deposit_detail 
                LEFT JOIN account ON deposit_detail.accId = account.id
                LEFT JOIN bank_account ON deposit_detail.accId = bank_account.accId
                LEFT JOIN banking ON bankId = banking.id
                WHERE status = 1
                ORDER BY deposit_detail.create_date ASC";
        $query = $this->db->query($sql)->result_array();
        return  $query;
    }
    /*รับข้อมูลการแจ้งถอนเงิน */
    function get_inform_withdraw()
    {
        $sql = "SELECT account.username,banking.name,bank_account.number,withdraw_detail.amount
                FROM withdraw_detail
                LEFT JOIN bank_account ON withdraw_detail.accId = bank_account.accId
                LEFT JOIN banking ON withdraw_detail.bankId = banking.id
                LEFT JOIN account ON withdraw_detail.accId = account.id
                WHERE withdraw_detail.status = 1
                ORDER BY withdraw_detail.create_date ASC";
        $query = $this->db->get('withdraw_detail')->result_array();
        return $query;
    }
    function update_status_inform_deposit()
    {

    }
    function update_status_inform_withdraw()
    {

    }
    function update_money()
    {

    }

}
?>