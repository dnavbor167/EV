<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	protected $not_login = [
		'auth/login',
		'auth/signin',
		'auth/verify_email',
		'auth/logout',
		'auth/recoverpassword',
		'dashboard/paymentsplans',
		'dashboard/infoweb',
		'dashboard/index'
	];

	protected $creating_group = [
		'groups/creategroup'
	];

	protected $group_exceptions = [
		'auth/login',
		'auth/signin',
		'auth/verify_email',
		'auth/logout',
		'auth/configuration',
		'auth/recoverpassword',
		'auth/reset_password',
		'groups/index',
		'dashboard/paymentsplans',
		'dashboard/infoweb',
		'groups/creategroup',
		'groups/joingroup',
		'groups/paymentsplans'
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

			//Controlar que si el token que tiene es el mismo que en el de la base de datos constantemente
			$usuario_id = $this->session->userdata('user_id');
			$session_token = $this->session->userdata('session_token');
			if ($usuario_id && $session_token) {
				$token_db = $this->User_model->get_user_token($usuario_id);
				if ($token_db !== $session_token) {
					$this->session->sess_destroy();
					redirect('auth/login');
				}
			}

			//Mirar inactividad
			$this->check_inactivity();

			//Si el usuario actual ha sido borrado se elimina la session y se redirge al home
			if ($this->User_model->userExists($this->session->userdata('email'), 1)) {
				$this->session->sess_destroy();
				redirect('Dashboard');
			}

			//Mirar si en algún grupo ha sido aceptado
			$actualUserBelongGroup = $this->User_model->userBelongGroup($this->session->userdata('user_id'));
			$actualUserBelongLen = count($actualUserBelongGroup);
			$groupsInSession = $this->session->userdata('is_in_any_group') ?? [];

			if ($actualUserBelongLen > count($this->session->userdata('is_in_any_group'))) {
				$gruposAnterioresIDs = array_column($groupsInSession, 'grupo_id');
				$gruposActualesIDs = array_column($actualUserBelongGroup, 'grupo_id');

				//Nuevo grupo
				$gruposNuevosIDs = array_diff($gruposActualesIDs, $gruposAnterioresIDs);

				if (!empty($gruposNuevosIDs)) {
					$ultimoGrupoAceptadoID = end($gruposNuevosIDs);
					$ultimoGrupoAceptado = $this->User_model->getGroupById($ultimoGrupoAceptadoID);

					// Actualizar sesión
					$data = [
						'is_in_any_group' => $actualUserBelongGroup,
						'groups' => $this->User_model->getGroups($gruposActualesIDs)
					];

					$this->session->set_userdata($data);
					$message = str_replace('{NOMBRE}', $ultimoGrupoAceptado['nombre'], $this->lang->line('joinSubmitedSuccess'));
					$this->session->set_flashdata('globalModal', $message);
					
					redirect('Dashboard');
				}
			}

			if ($actualUserBelongLen < count($groupsInSession)) {
				$gruposAnterioresIDs = array_column($groupsInSession, 'grupo_id');
				$gruposActualesIDs = array_column($actualUserBelongGroup, 'grupo_id');
			
				// Grupos eliminados
				$gruposEliminadosIDs = array_diff($gruposAnterioresIDs, $gruposActualesIDs);
			
				if (!empty($gruposEliminadosIDs)) {
					// Actualizar sesión
					$data = [
						'is_in_any_group' => $actualUserBelongGroup,
						'groups' => $this->User_model->getGroups($gruposActualesIDs)
					];
					$this->session->set_userdata($data);
					$this->session->set_flashdata('globalModal', $this->lang->line('removedFromGroup'));
					
					// Si fue eliminado del grupo actual, forzar cambio
					if (in_array($this->session->userdata('actual_group'), $gruposEliminadosIDs)) {
						$this->session->unset_userdata('actual_group');
						redirect('Groups');
					}
				}
			}

			//Marcamos si hay alguna petición nueva de usuario
			$this->load->model('Admin_model');
			$this->load->vars([
				'countNewPetitionsUsers' => $this->Admin_model->getUserPetitions()
			]);

			//actualizamos la session de rol por si se ha cambiado
			$rol = $this->User_model->actualRol($this->session->userdata('user_id'), $this->session->userdata('actual_group'));
			$this->session->set_userdata('rol', $rol);

			//Si ha sido actualizado el rol y está en algun apartado del rol que se valla
			if ($rol != 'admin' && (current_url() == site_url('AdminUsersGroup/groupUsers') || current_url() == site_url('AdminUsersGroup'))) {
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

		} else {
			//Si no está logueado redirigir siempre a Dashboard
			if (!in_array(strtolower($this->router->class . '/' . $this->router->method), $this->not_login)) {
				redirect('Dashboard');
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

	//chequear inactividad
	private function check_inactivity()
	{
		$timeout = 900;
		$last_activity = $this->session->userdata('last_activity');
		$current_controller = strtolower($this->router->class);

		if ($current_controller === 'songs') {
			return;
		}

		if ($last_activity && (time() - $last_activity > $timeout)) {
			$this->session->sess_destroy();
			redirect('Auth/login');
		} else {
			$this->session->set_userdata('last_activity', time());
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
