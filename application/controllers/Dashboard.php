<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
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

	public function paymentsPlans()
	{
		$this->loadViews('paymentsPlans');
	}
}
