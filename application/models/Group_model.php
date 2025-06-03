<?php
class Group_model extends CI_Model
{

    //relacion entre grupo y usuario
    public function insert_usuario_grupos($data)
    {
        return $this->db->insert('Usuarios_Grupos', $data);
    }

    //Insertar grupo
    public function inserGroup($data)
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