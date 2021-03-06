<?php
class Admin_model extends CI_Model
{
    /*รับข้อมูลการแจ้งฝากเงิน */
    public function get_inform_deposit()
    {
        $sql = "SELECT deposit_detail.id,account.username,admin_banking.bank_name,admin_banking.account_number,amount,tranfersDate,tranferTime
                FROM deposit_detail 
                LEFT JOIN account ON deposit_detail.accId = account.id
                LEFT JOIN admin_banking ON deposit_detail.bankId = admin_banking.id
                WHERE deposit_detail.status = 1
                ORDER BY deposit_detail.create_date ASC";
        $query = $this->db->query($sql)->result_array();
        return  $query;
    }
    /*รับข้อมูลการแจ้งถอนเงิน */
    public function get_inform_withdraw()
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
    /*รับข้อมูลเงินที่แจ้งเติมเงิน */
    public function get_money_deposit($id)
    {
        $sql="SELECT id,accId,amount
        	    FROM deposit_detail
        		WHERE id IN "."(";
						$num = 0;
						$length = count($id);
						if ($length > 1){
    					foreach($id as $value){
        				if($num != $length - 1){
        					$sql .= $value . ',';
        				}else{
          				$sql .= $value;
        				}
								$num++;
    					}
						}else{
    				$sql .= $id[0];
						}
         $sql.= ")";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    /*เปลี่ยนแปลงสถานะการแจ้งเติมเงิน*/
    public function update_status_deposit($id,$status,$des=null)
    {
        $sql = "UPDATE deposit_detail
                SET status = $status,
                 description = '$des',
				 updated_at = NOW()
                WHERE id = $id";
        $this->db->query($sql);
    }
    /*เปลี่ยนแปลงสถานะการแจ้งถอนเงิน*/
    public function update_status_withdraw($id,$status,$des=null)
    {
        $sql = "UPDATE withdraw_detail
                 SET status = $status,
                    description = '$des',
					updated_at = NOW()
                    WHERE id = $id";
        $this->db->query($sql);
    }
    /*เปลี่ยนแปลงเงินในบัญชีผู้ใช้งาน*/
    public function update_cash($id,$cash)
    {   
        $sql = "UPDATE account 
                SET account.money = $cash
                WHERE id = $id";
         $this->db->query($sql);
    }
    /*รับข้อมูลเงินของผู้ใช้*/
    public function get_current_user_money($id)
    {
        $sql = "SELECT account.id,account.money
                FROM deposit_detail
                LEFT JOIN account ON deposit_detail.accId = account.id
                WHERE deposit_detail.id = $id";
        $query = $this->db->query($sql)->row_array();
        return $query;    
    }
    /*รับข้อมูลผู้ใช้ที่ไม่อนุมัติการเติมเงิน*/
    public function get_data_unconfirm_deposit($id)
    {
        $sql = "SELECT deposit_detail.id,account.username,CONCAT(admin_banking.bank_name,' ',admin_banking.account_number) as bank,amount,tranfersDate,tranferTime,detail
                FROM `deposit_detail`
                LEFT JOIN account ON deposit_detail.accId = account.id
                LEFT JOIN admin_banking ON deposit_detail.bankId = admin_banking.id
                WHERE deposit_detail.id = $id";
         $query = $this->db->query($sql)->row_array();
         return $query;        
    }
    /*รับข้อมูลผู้ใช้ที่ไม่อนุมัติการถอนเงิน*/
    public function get_data_unconfirm_withdraw($id)
    {
        $sql = "SELECT account.username,CONCAT(banking.name,' ',bank_account.number) as bank,withdraw_detail.amount
                FROM `withdraw_detail`
                LEFT JOIN account ON withdraw_detail.accId = account.id
                LEFT JOIN bank_account ON withdraw_detail.bankId = bank_account.id
                LEFT JOIN banking ON bank_account.type = banking.id
                WHERE withdraw_detail.id = $id";
         $query = $this->db->query($sql)->row_array();
         return $query;  
    }
    /*รับข้อมูลประวัติการแจ้ง*/
    public function get_history_inform()
    {
        $sql = "SELECT accId, account.username, amount, create_date , deposit_detail.updated_at, tranfersDate, deposit_detail.status, deposit_detail.description 
                FROM deposit_detail
                LEFT JOIN account ON deposit_detail.accId = account.id
                UNION ALL
                SELECT accId, account.username, amount, create_date, withdraw_detail.updated_at ,NULL AS tranfersDate, withdraw_detail.status, withdraw_detail.description 
                FROM withdraw_detail
                LEFT JOIN account ON withdraw_detail.accId = account.id
                ORDER BY create_date DESC";
        $query = $this->db->query($sql)->result_array();
        return $query; 
    }
    /*ปรับเปลี่ยนวันที่ลงหวย*/
    public function set_period($start_date, $end_date)
    {
        if (strtotime($start_date) !== false && strtotime($end_date) !== false)
        {
            $this->db->insert('period', [
                'start_date' => $start_date,
                 'end_date' => $end_date,
                ]
            );
            $period = $this->db->limit(1)->order_by('id','desc')->get('period');
            $last_row = $period->row();

            $this->db->insert('lotto',[
                'period_id' => $last_row->id
            ]);
            return true;
        }
        
        return false;
    }
    /*รับค่างวดล่าสุด*/
    function get_period()
    {
        $sql = "SELECT * 
                FROM period 
                ORDER BY id DESC" ;
         $query = $this->db->query($sql)->result_array();
         return $query; 
    }
}
?>