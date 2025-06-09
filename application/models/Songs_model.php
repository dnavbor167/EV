<?php
class Songs_model extends CI_Model
{
    //Obtener todas las tonalidades
    public function getTones()
    {
        $this->db->from('Tonalidades');
        $this->db->order_by('tonalidad_id', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    //Mirar si una imagen existe en la base de datos para no repetir el nombre
    public function imageSongExist($photo)
    {
        $this->db->from('Canciones');
        $this->db->where('photo', $photo);

        return $this->db->count_all_results() > 0;
    }

    //Obtener todas las canciones de un grupo
    public function getSongsFromAGroup($group_id)
    {
        $this->db->select('Canciones.*, Tonalidades.nombre');
        $this->db->from('Canciones');
        $this->db->join('Tonalidades', 'Tonalidades.tonalidad_id = Canciones.tonalidad_id', 'inner');
        $this->db->where('grupo_id', $group_id);
        $query = $this->db->get();

        return $query->result_array();
    }

    //Canciones mensuales
    public function getNumberSongsMonthly($group_id)
    {
        $this->db->where('grupo_id', $group_id);
        $this->db->where('MONTH(fecha_creacion)', date('m'));
        $this->db->where('YEAR(fecha_creacion)', date('Y'));

        return $this->db->count_all_results('Canciones');
    }

    //Eliminar una canción dado id de canción
    public function deleteSong($song_id)
    {
        return $this->db->delete('Canciones', ['cancion_id' => $song_id]);
    }

    //Obtener una canción dado un id de canción
    public function getASong($song_id)
    {
        $this->db->from('Canciones');
        $this->db->where('cancion_id', $song_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    //Obtener un acorde por el id
    public function getATone($tone_id)
    {
        $this->db->from('Tonalidades');
        $this->db->where('tonalidad_id', $tone_id);
        $query = $this->db->get();

        $row = $query->row_array();
        return $row ? $row['nombre'] : false;
    }

    //Insertar una canción en la base de dato (simple sin acordes y sin nada)
    public function insertSong($data)
    {
        return $this->db->insert('Canciones', $data) ? $this->db->insert_id() : false;
    }
}