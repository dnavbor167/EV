<?php
class Admin_model extends CI_Model
{
    //Obtener los usuarios que han solicitado unirse tanto los pendientes como rechazado
    public function getRequestUser()
    {
        $group_id = $this->session->userdata('actual_group');

        $this->db->select('u.usuario_id, u.img, u.nombre, u.email, ug.estado');
        $this->db->from('Usuarios_Grupos ug');
        $this->db->join('Usuarios u', 'u.usuario_id = ug.usuario_id');
        $this->db->where('ug.grupo_id', $group_id);
        $this->db->where_in('ug.estado', ['pendiente', 'rechazado']);

        $query = $this->db->get();
        return $query->result_array();
    }

    //Marcar como visto cada vez que se entre en el controlador correspondiente
    public function seenUsersPetitions()
    {
        $group_id = $this->session->userdata('actual_group');

        $this->db->where('grupo_id', $group_id);
        $this->db->where('visto', 0);
        return $this->db->update('Usuarios_Grupos', ['visto' => 1]);
    }


    //Obtener todos los usuarios que no han sido vistos (Para mostrar cuantas nuevas peticiones hay)
    public function getUserPetitions()
    {
        $group_id = $this->session->userdata('actual_group');

        $this->db->from('Usuarios_Grupos');
        $this->db->where('grupo_id', $group_id);
        $this->db->where('visto', 0);
        $this->db->where_not_in('estado ', ['activo', 'rechazado']);

        return $this->db->count_all_results();
    }

    //Aceptar o Rechazar a usuarios
    public function acceptDeclineUsers($user, $acceptDecline)
    {
        $this->db->where('grupo_id', $this->session->userdata('actual_group'));
        $this->db->where('usuario_id', $user);
        return $this->db->update('Usuarios_Grupos', ['estado' => $acceptDecline]);
    }

    //Obtener los usuarios aceptados del grupo menos el actual
    public function getUsersAcceptedByGroup()
    {
        $group_id = $this->session->userdata('actual_group');
        $actual_user = $this->session->userdata('user_id');

        $this->db->select('u.usuario_id, u.img, u.nombre, u.email, ug.rol');
        $this->db->from('Usuarios_Grupos ug');
        $this->db->join('Usuarios u', 'u.usuario_id = ug.usuario_id');
        $this->db->where('ug.grupo_id', $group_id);
        $this->db->where('ug.usuario_id !=', $actual_user);
        $this->db->where_in('ug.estado', ['activo']);

        $query = $this->db->get();
        return $query->result_array();
    }

    //Eliminar usuarios de un grupo dado su id
    public function deleteUserFromGroupById($user_id)
    {
        $group_id = $this->session->userdata('actual_group');
        $this->db->where('grupo_id', $group_id);
        $this->db->where('usuario_id', $user_id);
        return $this->db->delete('Usuarios_Grupos');
    }

    //Actualizar rol de usuario
    public function updateUserRolFromGroup($user_id, $rol) {
        $group_id = $this->session->userdata('actual_group');
        $this->db->where('grupo_id', $group_id);
        $this->db->where('usuario_id', $user_id);
        return $this->db->update('Usuarios_Grupos', ['rol' => $rol]);
    }
}