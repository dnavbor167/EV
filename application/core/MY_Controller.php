<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	protected $creating_group = [
		'groups/creategroup'
	];

	protected $group_exceptions = [
		'auth/login',
		'auth/signIn',
		'auth/verify_email',
		'auth/logout',
		'auth/configuration',
		'auth/recoverpassword',
		'auth/reset_password',
		'groups/index',
		'dashboard/paymentsplans',
		'dashboard/infoweb',
		'groups/creategroup'
	];

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

		//Si está logueado ejecutamos la siguiente lógica
		if ($this->session->userdata('is_logged_in')) {
			//Si el usuario actual ha sido borrado se elimina la session y se redirge al home
			if ($this->User_model->userExists($this->session->userdata('email'), 1)) {
				$this->session->sess_destroy();
				redirect('Dashboard');
			}

			//Verificar que la ruta actual no está en group_exceptions
			$ruta_actual = strtolower($this->router->class . '/' . $this->router->method);

			if (in_array($ruta_actual, $this->group_exceptions) || in_array($ruta_actual, $this->creating_group)) {
				return;
			}

			if ($this->session->userdata('registro_grupo')) {
				$this->session->set_flashdata('globalModal', $this->lang->line('createGroupAgain'));
				$this->session->unset_userdata('registro_grupo');
			}

			//Si no tiene grupo asignado redireccionamos
			$groups = $this->session->userdata('groups');
			if (empty($groups)) {
				$this->_handle_redirect('Groups');
			}

		}

	}

	protected function _handle_redirect($url)
	{
		if ($this->input->is_ajax_request()) {
			echo json_encode([
				'status' => 'redirect',
				'url' => site_url('url')
			]);
			exit;
		} else {
			redirect($url);
		}
	}

	protected function loadViews($view, $data = null)
	{
		$data['is_home'] = current_url() == site_url('DashBoard') ? '#' : site_url('Dashboard');
		$data['is_logged'] = $this->session->userdata('is_logged_in') ? '#' : site_url('Auth/login');

		//si la vista es login se redirige a la home
		if ($this->session->userdata('is_logged_in') && $view == "login") {
			redirect(site_url('Dashboard'));
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
