<?php
class Group_model extends CI_Model
{
    //Obtener cuantos administradores hay por grupo
    public function getAdminsGroups() {
        $actualGroup = $this->session->userdata('actual_group');

        $this->db->from('Usuarios_Grupos');
        $this->db->where('grupo_id', $actualGroup);
        $this->db->where('rol', 'admin');

        return $this->db->count_all_results();
    }

    //Salirse del grupo actual
    public function exitActualGroup()
    {
        $user = $this->session->userdata('user_id');
        $actualGroup = $this->session->userdata('actual_group');

        if (!$user || !$actualGroup) {
            return false; // No hay datos para eliminar
        }

        $this->db->where('usuario_id', $user);
        $this->db->where('grupo_id', $actualGroup);
        $deleted = $this->db->delete('Usuarios_Grupos');

        if ($deleted) {
            $groups = $this->session->userdata('groups');

            foreach($groups as $key => $group) {
                if (isset($group['grupo_id']) && $group['grupo_id'] == $actualGroup) {
                    unset($groups[$key]);
                    break;
                }
            }

            $this->session->set_userdata('groups', $groups);

            if (!empty($groups)) {
                $newGroupSelected = reset($groups);
                $newGroupId = $newGroupSelected['grupo_id'];
                var_dump($groups);exit;

                $this->session->set_userdata('actual_group', $newGroupId);
            } else {
                $this->session->unset_userdata('actual_group');
                $this->User_model->updateUser($user, ['actual_group' => NULL]);
            }
        }

        return $deleted;
    }

    //Obtener todos los grupos
    public function getAllGroups()
    {
        $this->db->select('*');
        $this->db->from('Grupos');
        $query = $this->db->get();

        return $query->result_array();

    }

    //Mirar si existe la imagen para no tener duplicados en la base de datos de nombres
    public function imageGroupExists($img)
    {
        $this->db->from('Grupos');
        $this->db->where('img', $img);

        return $this->db->count_all_results() > 0;
    }

    //relacion entre grupo y usuario
    public function insert_usuario_grupos($data)
    {
        return $this->db->insert('Usuarios_Grupos', $data);
    }

    //Insertar grupo
    public function insertGroup($data)
    {
        $this->db->insert('Grupos', $data);
        return $this->db->insert_id();
    }

    //obtener si hay grupos por nombre
    public function areThereGroup($groupName)
    {
        $normalizedName = strtolower(str_replace(' ', '', $groupName));


        // Traemos todos los nombres de grupos de la DB
        $this->db->select('nombre');
        $query = $this->db->get('Grupos');

        foreach ($query->result_array() as $row) {
            $groupNameNormalized = strtolower(str_replace(' ', '', $row['nombre']));

            if ($groupNameNormalized === $normalizedName) {
                return true;
            }
        }

        return false;
    }

    //obtener si existe el email del grupo 
    public function areThereEmail($groupEmail)
    {
        $this->db->from('Grupos');
        $this->db->where('email', $groupEmail);

        return $this->db->count_all_results() > 0;
    }
}