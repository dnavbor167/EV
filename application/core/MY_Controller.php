<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$lang_id = $this->session->userdata('language') ?? 2;
		$lang_map = [
			1 => 'spanish',
			2 => 'english'
		];
		$language = isset($lang_map[$lang_id]) ? $lang_map[$lang_id] : 'spanish';

		$this->lang->load('general', $language);

		// if ($this->session->userdata('is_logged_in') && !$this->session->userdata('grupos')) {
		// 	redirect();
		// }

		//Si el usuario actual ha sido borrado se elimina la session y se redirge al home
		if ($this->User_model->userExists($this->session->userdata('email'), 1)) {
			$this->session->sess_destroy();
			redirect('Dashboard');
		}
	}

	protected function loadViews($view, $data = null)
	{
		$data['is_home'] = current_url() == site_url('DashBoard') ? '#' : site_url('Dashboard');
		$data['is_logged'] = $this->session->userdata('is_logged_in') ? '#' : site_url('Auth/login');

		//si la vista es login se redirige a la home
		if ($this->session->userdata('is_logged_in') && $view == "login") {
			redirect(base_url() . "DashBoard", "location");
		}

		if (!file_exists(APPPATH . 'views/' . $view . '.php')) {
			show_404();
		}

		if ($this->input->is_ajax_request()) {
			$this->load->view($view, $data);
		} else {
			//si es una vista cualquiera se carga
			$this->load->view('templates/header', $data);
			$this->load->view($view, $data);
			$this->load->view('templates/footer', $data);
		}
	}
}
