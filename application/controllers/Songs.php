<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Songs extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Songs_model');
	}


	public function index()
	{
		$data['songs'] = $this->Songs_model->getSongsFromAGroup($this->session->userdata('actual_group'));
		$this->loadViews('songs/songsList', $data);
	}

	public function createSong()
	{
		$grupoActual = $this->session->userdata('actual_group');
		$grupo = $this->session->userdata('groups')[$grupoActual];

		//Obtenemos el plan
		switch ($grupo['plan_id']) {
			case 1:
				$plan = 3;
				break;
			case 2:
				$plan = 20;
				break;
			case 3:
				$plan = 50;
				break;
			case 4:
				$plan = true;
				break;
		}

		//Miramos si su plan le permite añadir más usuarios
		if ($plan === true || $this->Songs_model->getNumberSongsMonthly($grupoActual) + 1 <= $plan) {

			$config['upload_path'] = './uploads/songs_img/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			//$config['max_size'] = 2048;

			if (!empty($_FILES['photo']['name'])) {
				$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

				//Comprobamos el nombre hasta que no exista y entonces lo introducimos en la base de datos
				do {
					$uniqueName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
				} while ($this->Songs_model->imageSongExist($uniqueName));

				$config['file_name'] = $uniqueName;
			}

			$this->load->library('upload', $config);

			//Form validation
			$this->form_validation->set_rules('nameSong', $this->lang->line('nameSong'), 'required');
			$this->form_validation->set_rules('tones_id', $this->lang->line('tone'), 'required');

			if ($this->input->method() == 'post') {
				if ($this->form_validation->run() == FALSE && $this->input->post('tones_id') == "") {
					$data['tonalidades'] = $this->Songs_model->getTones();
					$data['error_tone'] = $this->lang->line('errorSelectTone');
					$this->loadViews('songs/createSong', $data);
				} else {
					$songData['grupo_id'] = $this->session->userdata('actual_group');
					$songData['titulo'] = $this->input->post('nameSong');
					$songData['autor'] = $this->input->post('nameArtist') == "" ? NULL : $this->input->post('nameArtist');
					$songData['tonalidad_id'] = $this->input->post('tones_id');

					$photoFileName = 'fotoCancionPorDefecto';

					if (!empty($_FILES['photo']['name'])) {
						if (!$this->upload->do_upload('photo')) {
							$data['upload_error'] = $this->upload->display_errors();
							$this->loadViews("songs/createSong", $data);
							return;
						} else {
							$uploadData = $this->upload->data();
							$photoFileName = $uploadData['file_name'];
						}
					}

					$songData['photo'] = $photoFileName;

					$insertSongId = $this->Songs_model->insertSong($songData);

					if ($insertSongId) {
						redirect('Songs/song/' . $insertSongId);
					} else {
						show_error('Error to insert the song.');
					}
				}
			} else {
				$data['tonalidades'] = $this->Songs_model->getTones();
				$this->loadViews('songs/createSong', $data);
			}
		} else {
			$this->session->set_flashdata('globalModal', $this->lang->line('errorInsertSong'));
			redirect('Dashboard/paymentsPlans');
		}

	}

	public function deleteSong()
	{
		$song_id = $this->input->post('song_id');

		if ($this->Songs_model->deleteSong($song_id)) {
			echo json_encode([
				'success' => true
			]);
		} else {
			echo json_encode([
				'error' => true
			]);
		}
	}

	public function song($cancion_id = false)
	{
		if ($this->input->is_ajax_request()) {
			$songId = $this->input->post('song_id');
			$data['song'] = $this->Songs_model->getASong($songId);
			$tone = $data['song']['tonalidad_id'];
			$data['tono'] = $this->Songs_model->getATone($tone);
			$html = $this->load->view('songs/song', $data, TRUE);
			echo json_encode([
				'success' => true,
				'html' => $html
			]);
		} else {
			$data['song'] = $this->Songs_model->getASong($cancion_id);
			$tone = $data['song']['tonalidad_id'];
			$data['tono'] = $this->Songs_model->getATone($tone);
			$this->loadViews('songs/song', $data);
		}
	}
}
