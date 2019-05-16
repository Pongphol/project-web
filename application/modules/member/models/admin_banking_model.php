<?php
    class admin_banking_model extends CI_Model {
        public function construct()
    {
        parent::construct();
    }
        /*รับข้อมูลธนาคารของ admin*/
        function get_name_banking(){
            $sql = "SELECT id,CONCAT(bank_name,' ',account_number) as name_bank,picture
                    FROM `admin_banking`";
            $query = $this->db->query($sql)->result_array();
            return  $query;
        }
    }
?>