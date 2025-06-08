<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Groups extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Group_model');
	}


	public function index()
	{
		$this->loadViews('joinCreateGroup');
	}

	public function joinGroup()
	{
		//form falidation
		$this->form_validation->set_rules('grupo_id', $this->lang->line('joinGroup'), 'required');

		if ($this->input->method() === 'post') {

			if ($this->form_validation->run() == FALSE) {
				$data['errorJoinSelect'] = $this->lang->line('errorJoinSelect');
			} else {
				$data = [
					'usuario_id' => $this->session->userdata('user_id'),
					'grupo_id' => $this->input->post('grupo_id')
				];

				$redirect = count($this->session->userdata('is_in_any_group')) <= 0 ? 'Groups' : 'Dashboard';

				if ($this->Group_model->insert_usuario_grupos($data)) {
					$this->session->set_flashdata('globalModal', $this->lang->line('joinSubmited'));
					redirect($redirect);
					return;
				} else {
					$this->session->set_flashdata('globalModal', $this->lang->line('joinSubmitedError'));
					redirect($redirect);
				}
			}
		}
		//Obtener todos los grupos
		$allGroups = $this->Group_model->getGroupsNotRequired();

		$groups = [];
		foreach ($allGroups as $group) {
			$groups[] = [
				'id' => $group['grupo_id'],
				'name' => $group['nombre']
			];
		}

		$data['groups'] = $groups;
		$this->loadViews('group/joinGroup', $data);
	}

	public function createGroup()
	{

		$this->load->library('email');

		$config['upload_path'] = './uploads/group_img/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		//$config['max_size'] = 2048;

		if (!empty($_FILES['groupPhoto']['name'])) {
			// Leer el contenido temporal de la imagen
			$tmpFilePath = $_FILES['groupPhoto']['tmp_name'];
			$imageData = file_get_contents($tmpFilePath);

			// Guardarlo en la sesión (puede ser base64 o raw data)
			$this->session->set_userdata('registro_grupo_img_data', $imageData);

			// También guarda la extensión o nombre original para luego
			$this->session->set_userdata('registro_grupo_img_ext', pathinfo($_FILES['groupPhoto']['name'], PATHINFO_EXTENSION));
		}

		$this->load->library('upload', $config);

		$this->form_validation->set_rules('userNameGroup', $this->lang->line('userName'), 'required');
		$this->form_validation->set_rules('groupEmail', $this->lang->line('userName'), 'required|valid_email');
		$this->form_validation->set_rules('userPassword', $this->lang->line('password'), 'required');
		$this->form_validation->set_rules('groupPromotions', $this->lang->line('groupPromotions'), 'required');

		//miramos que haya un envio post
		if ($this->input->method() == 'post') {
			//Comprobamos de que el nombre que ha introducido sea único
			$nameExists = $this->Group_model->areThereGroup($this->input->post('userNameGroup'));
			//Comprobamos si el email existe
			$emailExists = $this->Group_model->areThereEmail($this->input->post('groupEmail'));

			if ($this->form_validation->run() == FALSE || empty($_FILES['groupPhoto']['name']) || $nameExists || $emailExists) {
				if (empty($_FILES['groupPhoto']['name'])) {
					$data['photo_error'] = $this->lang->line('errorGroupPhoto');
				}

				if ($nameExists && $this->form_validation->run() != FALSE) {
					$data['name_error'] = $this->lang->line('userNameRepeated');
				}

				if ($emailExists && $this->form_validation->run() != FALSE) {
					$data['email_error'] = $this->lang->line('emailRepeated');
				}

				$this->loadViews('group/createGroup', isset($data) ? $data : []);
			} else {

				//Load library
				$this->load->library('email');

				//Email Verify
				$nombre = $this->input->post('userNameGroup');
				$email = $this->input->post('groupEmail');
				$password = password_hash($this->input->post('userPassword'), PASSWORD_DEFAULT);
				$promotions = $this->input->post('groupPromotions');

				$registro_grupo = [
					'nombre' => $nombre,
					'email' => $email,
					'password' => $password,
					'termsConditions' => $promotions,
					'deleted' => 0
				];

				if ($this->User_model->pendingUserExists($registro_grupo['email'])) {
					$data['errorUserCreate'] = $this->lang->line('pendingUserExists');
					$this->loadViews("joinCreateGroup", $data);
					return;
				}

				do {
					$token = bin2hex(random_bytes(16));
				} while ($this->User_model->getPendingUserByToken($token));

				$registro_grupo['token'] = $token;

				if (!$this->User_model->insertPendingUser($registro_grupo)) {
					$data['errorInsert'] = $this->lang->line('errorInsPendGroup');
					$this->loadViews("group/joinCreateGroup", $data);
					return;
				}

				$this->session->set_userdata('registro_grupo', $registro_grupo);

				// Enviar email de confirmación
				$this->email->from('daniel2004navas@gmail.com', 'Eternals Vibes');
				$this->email->to($registro_grupo['email']);
				$this->email->subject($this->lang->line('confirmRegister'));
				$link = base_url("Auth/verify_email?group=1&token=$token");
				$messageText = $this->lang->line('messageLinkEmail');
				$message = str_replace(['{NOMBRE}', '{LINK}'], [$registro_grupo['nombre'], $link], $messageText);
				$this->email->message($message);

				if (!$this->email->send()) {
					$data['errorInsert'] = $this->lang->line('errorEmail');
					$this->session->unset_userdata('registro_grupo');
					$this->loadViews("group/joinCreateGroup", $data);
					return;
				}

				$this->session->set_flashdata('successSignIn', $this->lang->line('singInEmailSend'));
				redirect("Groups");
			}
		} else {
			$this->loadViews('group/createGroup');
		}
	}

	public function paymentsPlans()
	{
		switch ($this->input->post('plan')) {
			case 'free':
				$plan = 1;
				break;
			case 'pro':
				$plan = 2;
				break;
			case 'premium':
				$plan = 3;
				break;
			default:
				$plan = 1;
				break;
		}

		$registro = $this->session->userdata('registro_grupo');
		$registro['plan_id'] = $plan;

		if (isset($registro['token'])) {
			unset($registro['token']);
		}

		$this->session->set_userdata('registro_grupo', $registro);

		if ($plan == 1) {
			$this->insertGroup($plan);
		} else {
			\Stripe\Stripe::setApiKey('sk_test_TU_CLAVE'); // Sustituye por tu clave real

			$prices = [
				2 => 'prod_SReItLTC8MBJkL',
				3 => 'prod_SReJvxRqG7ktuh',
			];

			$precio = 0;
			switch ($plan) {
				case 2:
					$precio = 1000; // 10 EUR en céntimos
					break;
				case 3:
					$precio = 2000; // 20 EUR en céntimos
					break;
				default:
					show_error('Plan no válido');
			}

			$session = \Stripe\Checkout\Session::create([
				'payment_method_types' => ['card'],
				'mode' => 'subscription',
				'line_items' => [
					[
						'price' => [$prices[$plan]],
						'quantity' => 1,
					]
				],
				'success_url' => base_url('grupo/registro_exitoso'),
				'cancel_url' => base_url('grupo/createGroup'),
			]);

			// Enviar la URL como JSON para manejarla con JS
			echo json_encode([
				'success' => true,
				'url' => $session->url
			]);
		}
	}

	//Salirse del grupo
	public function exitActualGroup()
	{
		$user_id = $this->session->userdata('user_id');
		$group_id = $this->session->userdata('actual_group');
		if ($this->Group_model->getAdminsGroups() <= 1 && $this->User_model->actualRol($user_id, $group_id) == 'admin') {
			$this->session->set_flashdata('globalModal', $this->lang->line('imposibleExitGroup'));
			redirect('Dashboard');
		} else {
			$this->Group_model->exitActualGroup();
			redirect('Auth/configuration');
		}
	}

	private function insertGroup($plan)
	{
		$registro = $this->session->userdata('registro_grupo');

		$uniqueName = $this->saveGroupImageFromSession();
		if ($uniqueName) {
			$registro['img'] = $uniqueName;
		} else {
			$registro['img'] = null;
		}

		//Si el plan es free ponemos que no tiene fecha de expiración
		if ($plan == 1) {
			$registro['suscripcion_expira_en'] = NULL;
		}

		//insertamos grupo y obtenemos el id del grupo
		$grupo_id = $this->Group_model->insertGroup($registro);
		$this->User_model->deletePendingUser($this->session->userdata('registro_grupo')['token']);

		//hacemos relacion entre grupo y usuario y lo ponemos como admin por crearlo
		$data = [
			'usuario_id' => $this->session->userdata('user_id'),
			'grupo_id' => $grupo_id,
			'rol' => 'admin',
			'estado' => 'activo',
			'fecha_ingreso' => Date('Y-m-d')
		];

		if ($this->Group_model->insert_usuario_grupos($data)) {
			//actualizamos el actual group al usuario
			$this->User_model->updateUser($data['usuario_id'], ['actual_group' => $grupo_id]);
			//reseteamos sessions
			$this->session->set_userdata('is_in_any_group', $this->User_model->userBelongGroup($data['usuario_id']));
			$this->session->set_userdata('actual_group', $grupo_id);

			$groups_ids = array_column($this->session->userdata['is_in_any_group'], 'grupo_id');
			$this->session->set_userdata('groups', $this->User_model->getGroups($groups_ids));

			//Actualizamos la session para grupos
			$this->session->set_userdata('is_in_any_group', $this->User_model->userBelongGroup($this->session->userdata('user_id')));
			$groups_ids = array_column($this->session->userdata('is_in_any_group'), 'grupo_id');
			$this->session->set_userdata('groups', $this->User_model->getGroups($groups_ids));

			$this->session->unset_userdata('registro_grupo');

			echo json_encode([
				'success' => true,
				'url' => base_url('Dashboard')
			]);
		}
	}

	private function saveGroupImageFromSession()
	{
		$imageData = $this->session->userdata('registro_grupo_img_data');
		$ext = $this->session->userdata('registro_grupo_img_ext');
		if (!$imageData || !$ext)
			return false;

		// Generar nombre único
		do {
			$uniqueName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
		} while ($this->Group_model->imageGroupExists($uniqueName));

		$uploadPath = './uploads/group_img/' . $uniqueName;

		// Guardar el archivo en disco
		if (file_put_contents($uploadPath, $imageData) !== false) {
			// Eliminar la imagen temporal de sesión
			$this->session->unset_userdata('registro_grupo_img_data');
			$this->session->unset_userdata('registro_grupo_img_ext');
			return $uniqueName;
		}
		return false;
	}
}
