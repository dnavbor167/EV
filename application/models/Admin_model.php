<?php
class Admin_model extends CI_Model
{
    //Obtener los usuarios que han solicitado unirse tanto los pendientes como rechazado
    public function getRequestUser()
    {
        $group_id = $this->session->userdata('actual_group');

        $this->db->select('u.usuario_id, u.nombre, u.email, ug.estado');
        $this->db->from('Usuarios_Grupos ug');
        $this->db->join('Usuarios u', 'u.usuario_id = ug.usuario_id');
        $this->db->where('ug.grupo_id', $group_id);
        $this->db->where_in('ug.estado', ['pendiente', 'rechazado']);

        $query = $this->db->get();
        return $query->result_array();
    }
}