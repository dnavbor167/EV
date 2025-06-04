<?php
class User_model extends CI_Model
{
    //Obtener rol actual dado un grupo
    public function actualRol($user, $actual_group) {
        $this->db->select('rol');
        $this->db->from('Usuarios_Grupos');
        $this->db->where('usuario_id', $user);
        $this->db->where('grupo_id', $actual_group);
        $query = $this->db->get();

        $result = $query->row_array();

        return $result ? $result['rol'] : null;
    }

    //Actualizar última actividad
    public function update_last_activity($user_id)
    {
        $this->db->where('usuario_id', $user_id);
        $this->db->update('Usuarios', ['last_activity' => time()]);
    }

    //Limpiamos la ultima actividad
    public function clear_user_token($user_id)
    {
        $this->db->where('usuario_id', $user_id);
        $this->db->update('Usuarios', ['session_token' => null]);
    }

    //get user by email
    public function getUserByEmail($email)
    {
        $this->db->from('Usuarios');
        $this->db->where('email', $email);

        return $this->db->get()->row_array();
    }

    //Save token recover passwotd
    public function save_reset_token($usuario_id, $plain_token)
    {
        $data = [
            'usuario_id' => $usuario_id,
            'token_hash' => password_hash($plain_token, PASSWORD_DEFAULT),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'used' => 0
        ];
        $this->db->insert('reset_password_tokens', $data);
    }

    //validar token recover password
    public function get_valid_token($token)
    {
        $query = $this->db->where('used', 0)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->get('reset_password_tokens');

        foreach ($query->result_array() as $row) {
            if (password_verify($token, $row['token_hash'])) {
                return $row; // contiene usuario_id
            }
        }
        return null;
    }

    // Marcar token como usado recover password
    public function mark_token_used($id)
    {
        $this->db->where('id', $id)
            ->update('reset_password_tokens', ['used' => 1]);
    }

    // Actualizar contraseña del usuario recover password
    public function update_password($usuario_id, $hashed_password)
    {
        return $this->db->where('usuario_id', $usuario_id)
            ->update('Usuarios', ['password' => $hashed_password]);
    }

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

    //Save token each login
    public function save_token_user($user_id, $token)
    {
        $this->db->where('usuario_id', $user_id);
        $this->db->update('Usuarios', ['session_token' => $token]);
    }

    //Obtain token by user
    public function get_user_token($user_id)
    {
        $this->db->select('session_token');
        $this->db->from('Usuarios');
        $this->db->where('usuario_id', $user_id);
        $query = $this->db->get();

        $row = $query->row_array();

        return $row ? $row['session_token'] : null;
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
        $this->db->where('estado', 'activo');
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
                'img' => $group['img']
            ];
        }

        return $groups_by_id;
    }

    public function getGroupById($group_id) {
        $this->db->select('nombre, email, img');
        $this->db->where('grupo_id', $group_id);
        $query = $this->db->get('Grupos');
        
        return $query->row_array();
    }












    public function obtenerTonalidades()
    {
        $this->db->select('*');
        $this->db->from('Tonalidades');

        return $this->db->get()->result();
    }
}