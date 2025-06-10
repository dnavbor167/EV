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

    //Obtener un acorde por el id de cancion
    public function getAToneSong($song_id)
    {
        $song = $this->getASong($song_id);
        $tone = $song['tonalidad_id'];

        $this->db->from('Tonalidades');
        $this->db->where('tonalidad_id', $tone);
        $query = $this->db->get();

        $row = $query->row_array();
        return $row ? $row['nombre'] : false;
    }

    //Insertar una canción en la base de dato (simple sin acordes y sin nada)
    public function insertSong($data)
    {
        return $this->db->insert('Canciones', $data) ? $this->db->insert_id() : false;
    }

    //Guardamos acordes de una cancion
    public function insertChords($song_id, $chords)
    {
        //Borramos si habia
        $this->db->where('cancion_id', $song_id);
        $this->db->delete('Acordes_Canciones');

        foreach ($chords as $chord) {
            $this->db->insert('Acordes_Canciones', [
                'cancion_id' => $song_id,
                'coordenada_x' => $chord['coordenada_x'],
                'coordenada_y' => $chord['coordenada_y'],
                'grado' => $chord['grado']
            ]);
        }

        echo json_encode(['status' => '200']);
    }

    //Guardamos letras de una cancion
    public function insertLetters($song_id, $letters)
    {
        //Borramos si habia
        $this->db->where('cancion_id', $song_id);
        $this->db->delete('Letras_Canciones');

        foreach ($letters as $letter) {
            $this->db->insert('Letras_Canciones', [
                'cancion_id' => $song_id,
                'coordenada_y' => $letter['coordenada_y'],
                'letra' => $letter['letra']
            ]);
        }

        echo json_encode(['status' => '200']);
    }

    //Obtenemos todos las letras y acordes de una cancion
    public function getChordsLetters($song_id)
    {
        $resultado = [];

        // Obtenemos todos los acordes
        $this->db->select('coordenada_x, coordenada_y, grado');
        $this->db->from('Acordes_Canciones');
        $this->db->where('cancion_id', $song_id);
        $this->db->order_by('coordenada_y', 'ASC');
        $this->db->order_by('coordenada_x', 'ASC');
        $acordes = $this->db->get()->result_array();

        // Obtenemos todas las letras
        $this->db->select('coordenada_y, letra');
        $this->db->from('Letras_Canciones');
        $this->db->where('cancion_id', $song_id);
        $this->db->order_by('coordenada_y', 'ASC');
        $letras = $this->db->get()->result_array();

        // Agrupamos datos por coordenada_y
        $filas = [];

        foreach ($acordes as $a) {
            $y = $a['coordenada_y'];
            if (!isset($filas[$y])) {
                $filas[$y] = ['coordenada_y' => $y, 'acordes' => [], 'letra' => ''];
            }
            $filas[$y]['acordes'][] = [
                'grado' => $a['grado'],
                'coordenada_x' => $a['coordenada_x']
            ];
        }

        foreach ($letras as $l) {
            $y = $l['coordenada_y'];
            if (!isset($filas[$y])) {
                $filas[$y] = ['coordenada_y' => $y, 'acordes' => [], 'letra' => ''];
            }
            $filas[$y]['letra'] = $l['letra'];
        }

        // Ordenamos por coordenada_y
        ksort($filas);

        // Devolvemos como array numerado
        $resultado = array_values($filas);

        return $resultado;
    }
    //Actualizar tono de cancion 
    public function updateTone($song_id, $newTone)
    {
        $this->db->where('cancion_id', $song_id);
        return $this->db->update('Canciones', ['tonalidad_id' => $newTone]);
    }
}