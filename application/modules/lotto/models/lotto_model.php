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
}

?>