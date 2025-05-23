<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$lang_id = $this->session->userdata('language') ?? 1;
		$lang_map = [
			1 => 'spanish',
			2 => 'english'
		];
		$language = isset($lang_map[$lang_id]) ? $lang_map[$lang_id] : 'spanish';

		$this->lang->load('general', $language);
	}


	public function index()
	{
		//Si pasa mas de 5 minutos la sesión se cerrará
		// $tiempo = time() - $_SESSION["login_tmp"];
		// if (isset($_SESSION["usuario"]) && $tiempo < 300) {
		// 	$this->session->set_userdata("login_tmp", time());
		// 	$data['empleados'] = $this->Site_model->getEmpleados();
		// } else {
		// 	$this->session->sess_destroy();
		// 	redirect(base_url("DashBoard/login"));
		// }

		$this->loadViews("home");
	}

	public function login()
	{
		//form validation
		$this->form_validation->set_rules('userEmail', $this->lang->line('email'), 'required|valid_email');
		$this->form_validation->set_rules('userPassword', $this->lang->line('password'), 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews("login");
		} else {
			$data['email'] = $this->input->post('userEmail');
			$data['password'] = $this->input->post('userPassword');
			$login = $this->User_model->loginUser($data);
			if ($login) {
				$array = array(
					'language' => $login->lenguage
				);
				$this->loadViews("home");
			} else {
				$data['error'] = true;
				$this->loadViews("login", $data);
				return;
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url("DashBoard/login"));
	}

	public function eliminarEmpleado()
	{
		if (isset($_POST["idEmpleado"])) {
			$this->Site_model->deleteEmpleado($_POST["idEmpleado"]);
		}
	}

	public function actualizarEmpleado()
	{
		//verificamos si se ha pasado el tiempo
		$tiempo = time() - $_SESSION["login_tmp"];
		if (!isset($_SESSION['usuario']) || $tiempo >= 300) {
			$this->session->sess_destroy();
			echo json_encode(['status' => 'error', 'message' => "Sesión Expirada"]);
			return;
		}

		if ($_POST) {
			$this->Site_model->updateEmpleado($_POST["idEmpleadoUpdate"]);
			echo json_encode(['status' => 'success', 'message' => "Actualizado"]);
			redirect(base_url("DashBoard"));
		} else {
			echo json_encode(['status' => 'error', 'message' => "Sin id"]);
		}
	}


	public function loadViews($view, $data = null)
	{
		//si la vista es login se redirige a la home
		if ($this->session->userdata('is_logged_in') && $view == "login") {
			redirect(base_url() . "DashBoard", "location");
		}

		//si es una vista cualquiera se carga
		$this->load->view('templates/header');
		$this->load->view($view, $data);
		$this->load->view('templates/footer');
		//si no tenemos iniciada sessión
	}
}
