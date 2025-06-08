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
		$this->loadViews('songs/songsList');
	}

	public function createSong() {
		$data['tonalidades'] = $this->Songs_model->getTones();
		$this->loadViews('songs/createSong', $data);
	}
}
