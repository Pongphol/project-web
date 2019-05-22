<?php

class Admin_model extends CI_Model
{
    /*รับข้อมูลการแจ้งฝากเงิน */
    function get_inform_deposit()
    {
        $sql = "SELECT deposit_detail.id,account.username,admin_banking.bank_name,admin_banking.account_number,amount,tranfersDate,tranferTime
                FROM deposit_detail 
                LEFT JOIN account ON deposit_detail.accId = account.id
                LEFT JOIN admin_banking ON deposit_detail.bankId = admin_banking.id
                WHERE status = 1
                ORDER BY deposit_detail.create_date ASC";
        $query = $this->db->query($sql)->result_array();
        return  $query;
    }
    /*รับข้อมูลการแจ้งถอนเงิน */
    function get_inform_withdraw()
    {
        $sql = "SELECT withdraw_detail.id,account.username,banking.name,bank_account.number,withdraw_detail.amount
                FROM withdraw_detail
                LEFT JOIN bank_account ON withdraw_detail.accId = bank_account.accId
                LEFT JOIN banking ON withdraw_detail.bankId = banking.id
                LEFT JOIN account ON withdraw_detail.accId = account.id
                WHERE withdraw_detail.status = 1
                ORDER BY withdraw_detail.create_date ASC";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    function update_status_inform_deposit()
    {
        
    }
    function update_status_inform_withdraw()
    {

    }
    function update_cash()
    {

    }
    function get_current_user_money($id)
    {
        $sql = "SELECT account.money
                FROM deposit_detail
                LEFT JOIN account ON deposit_detail.accId = account.id
                WHERE deposit_detail.id = $id";
        $query = $this->db->query($sql)->row_array();
        return $query;    
    }
}
?>