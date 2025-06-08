<?php
class Songs_model extends CI_Model
{
    //Obtener todas las tonalidades
    public function getTones() {
        $this->db->from('Tonalidades');
        $this->db->order_by('tonalidad_id', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }
}