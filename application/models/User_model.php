<?php
class User_model extends CI_Model
{

    //update user
    public function updateUser($user_id, $data)
    {
        $this->db->where('usuario_id', $user_id);
        return $this->db->update('Usuarios', $data);
    }

    //Delete user
    public function deleteUser($user_id)
    {
        $this->db->where('usuario_id', $user_id);
        return $this->db->update('Usuarios', ['deleted' => 1]);
    }

    //Comprobar si usuario existe
    public function userExists($email, $deleted)
    {
        $this->db->from('Usuarios');
        $this->db->where('email', $email);
        $this->db->where('deleted', $deleted);

        return $this->db->count_all_results() > 0;
    }

    public function imageUserExists($img)
    {
        $this->db->from('Usuarios');
        $this->db->where('img', $img);

        return $this->db->count_all_results() > 0;
    }

    public function loginUser($data)
    {
        $this->db->select("*");
        $this->db->from("Usuarios");
        $this->db->where("email", $data["email"]);
        $this->db->where("deleted", 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $user = $query->row_array();

            if (password_verify($data['password'], $user['password'])) {
                return $user;
            } else {
                return NULL;
            }
        }
        //Si no encuentra usuarios, retornará null
        return NULL;
    }

    public function insertUser($data)
    {
        if ($this->userExists($data['email'], 1)) {
            $this->db->where('email', $data['email']);
            return $this->db->update('Usuarios', $data);
        } else {
            return $this->db->insert('Usuarios', $data);
        }
    }

    // Insertar usuario pendiente
    public function insertPendingUser($data)
    {
        return $this->db->insert('pending_users', $data);
    }

    // Verificar si email pendiente existe
    public function pendingUserExists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('pending_users');
        return $query->num_rows() > 0;
    }

    // Obtener usuario pendiente por token
    public function getPendingUserByToken($token)
    {
        $this->db->where('token', $token);
        $query = $this->db->get('pending_users');
        return $query->row_array();
    }

    // Borrar usuario pendiente por token
    public function deletePendingUser($token)
    {
        $this->db->where('token', $token);
        return $this->db->delete('pending_users');
    }

    //Borrar usuarios fecha expirada
    public function deleteExpiredPendingUser()
    {
        $this->db->where('created_at <', date('Y-m-d H:i:s', strtotime('-5 minutes')));
        return $this->db->delete('pending_users');
    }

    public function userBelongGroup($id_user)
    {
        $this->db->where('usuario_id', $id_user);
        $query = $this->db->get('Usuarios_Grupos');

        return $query->result_array();
    }

    //Obtener los grupos dado un usuario
    public function getGroups($array_id)
    {
        $this->db->where_in('grupo_id', $array_id);
        $query = $this->db->get('Grupos');
        $result = $query->result_array();

        $groups_by_id = [];
        foreach ($result as $group) {
            $groups_by_id[$group['grupo_id']] = [
                'grupo_id' => $group['grupo_id'],
                'name' => $group['nombre'],
                'email' => $group['email'],
                'photo' => $group['foto']
            ];
        }

        return $groups_by_id;
    }












    public function obtenerTonalidades()
    {
        $this->db->select('*');
        $this->db->from('Tonalidades');

        return $this->db->get()->result();
    }
}