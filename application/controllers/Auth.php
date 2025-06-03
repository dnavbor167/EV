<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		//borramos usuarios de pending users que no han sido accedidos
		$this->User_model->deleteExpiredPendingUser();

		$usuario_id = $this->session->userdata('user_id');
		$session_token = $this->session->userdata('session_token');
		if ($usuario_id && $session_token) {
			$token_db = $this->User_model->get_user_token($usuario_id);
			if ($token_db !== $session_token) {
				$this->session->sess_destroy();
				redirect('login');
			}
		}
	}

	public function index()
	{
		$this->login();
	}

	public function deleteUser()
	{
		$user_id = $this->session->userdata('user_id');
		if ($this->User_model->deleteUser($user_id)) {
			redirect('Dashboard');
		} else {
			show_error($this->lang->line('deleteError'));
		}
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
				if (!empty($login['session_token'])) {
					$this->session->set_flashdata('globalModal', $this->lang->line('activeSession'));
					redirect('auth/login');	
				}

				$token = uniqid('sess_', true);
				$this->User_model->save_token_user($login['usuario_id'], $token);

				$array = array(
					'user_id' => $login['usuario_id'],
					'user_name' => $login['nombre'],
					'email' => $login['email'],
					'language' => $login['language'],
					'img_user' => $login['img'],
					'is_logged_in' => true,
					'is_in_any_group' => $this->User_model->userBelongGroup($login['usuario_id']),
					'actual_group' => $login['actual_group'],
					'session_token' => $token
				);

				if ($array['is_in_any_group']) {
					$groups_ids = array_column($array['is_in_any_group'], 'grupo_id');
					$array['groups'] = $this->User_model->getGroups($groups_ids);
				}

				$this->session->set_userdata($array);
				redirect(base_url('Dashboard'));
			} else {
				$data['error'] = true;
				$this->loadViews("login", $data);
				return;
			}
		}
	}

	public function signIn()
	{
		//load libraries
		$this->load->library('email');

		$config['upload_path'] = './uploads/user_img/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		//$config['max_size'] = 2048;

		if (!empty($_FILES['photo']['name'])) {
			$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

			//Comprobamos el nombre hasta que no exista y entonces lo introducimos en la base de datos
			do {
				$uniqueName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
			} while ($this->User_model->imageUserExists($uniqueName));

			$config['file_name'] = $uniqueName;
		}

		$this->load->library('upload', $config);

		//form validation
		$this->form_validation->set_rules('userNameSignIn', $this->lang->line('userName'), 'required');
		$this->form_validation->set_rules('userEmail', $this->lang->line('email'), 'required|valid_email');
		$this->form_validation->set_rules('userPassword', $this->lang->line('password'), 'required');
		$this->form_validation->set_rules('language', $this->lang->line('language'), 'required');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews("signIn");
		} else {
			$passwordEncrypt = password_hash($this->input->post('userPassword'), PASSWORD_DEFAULT);

			$userData = [
				'nombre' => $this->input->post('userNameSignIn'),
				'email' => $this->input->post('userEmail'),
				'password' => $passwordEncrypt,
				'language' => $this->input->post('language'),
				'deleted' => 0
			];

			$userData['promotions'] = $this->input->post('promotions') == 1 ? 1 : 0;

			if ($this->User_model->userExists($userData['email'], 0)) {
				$data['errorUserCreate'] = $this->lang->line('errorUserCreate');
				$this->loadViews("signIn", $data);
				return;
			}

			if ($this->User_model->pendingUserExists($userData['email'])) {
				$data['errorUserCreate'] = $this->lang->line('pendingUserExists');
				$this->loadViews("signIn", $data);
				return;
			}

			//Hacer mientras encuentre token por si está repetido
			do {
				$token = bin2hex(random_bytes(16));
			} while ($this->User_model->getPendingUserByToken($token));

			$userData['token'] = $token;

			$photoFileName = 'default_img';

			if (!empty($_FILES['photo']['name'])) {
				if (!$this->upload->do_upload('photo')) {
					$data['upload_error'] = $this->upload->display_errors();
					$this->loadViews("signIn", $data);
					return;
				} else {
					$uploadData = $this->upload->data();
					$photoFileName = $uploadData['file_name'];
				}
			}

			$userData['img'] = $photoFileName;

			if (!$this->User_model->insertPendingUser($userData)) {
				$data['errorInsert'] = "Error guardando usuario pendiente.";
				$this->loadViews("signIn", $data);
				return;
			}

			// Enviar email de confirmación
			$this->email->from('daniel2004navas@gmail.com', 'Eternals Vibes');
			$this->email->to($userData['email']);
			$this->email->subject($this->lang->line('confirmRegister'));
			$link = base_url("Auth/verify_email?token=$token");
			$messageText = $this->lang->line('messageLinkEmail');
			$message = str_replace(['{NOMBRE}', '{LINK}'], [$userData['nombre'], $link], $messageText);
			$this->email->message($message);

			if (!$this->email->send()) {
				$data['errorInsert'] = "No se pudo enviar el email de confirmación.";
				$this->loadViews("signIn", $data);
				return;
			}

			// Mostrar mensaje para revisar el correo
			$this->session->set_flashdata('successSignIn', $this->lang->line('singInEmailSend'));
			redirect('Auth/login');
		}
	}

	public function verify_email()
	{
		$token = $this->input->get('token');

		if (!$token) {
			show_error('Token inválido');
		}

		$pendingUser = $this->User_model->getPendingUserByToken($token);

		if (!$pendingUser) {
			show_error('Token inválido o expirado');
		}

		//Expiración de token/enlace
		$tokenTime = strtotime($pendingUser['created_at']);
		$now = time();

		if (($now - $tokenTime) > 300) { // 300 segundos = 5 minutos
			$this->User_model->deletePendingUser($pendingUser['token']);
			show_error("El enlace ha expirado. Por favor regístrate de nuevo.");
			return;
		}

		// Crear usuario definitivo
		$userData = [
			'nombre' => $pendingUser['nombre'],
			'email' => $pendingUser['email'],
			'password' => $pendingUser['password'],
			'language' => $pendingUser['language'],
			'img' => $pendingUser['img'],
			'deleted' => $pendingUser['deleted'],
			'promotions' => $pendingUser['promotions']
		];


		if ($this->User_model->insertUser($userData)) {
			// Borrar usuario pendiente
			$this->User_model->deletePendingUser($token);

			// Mostrar mensaje de éxito o redirigir al login
			redirect('Auth/login');
		} else {
			show_error('Error al activar usuario, intenta de nuevo.');
		}
	}


	public function logOut()
	{
		$usuario_id = $this->session->userdata('user_id');
		if ($usuario_id) {
			$this->User_model->save_token_user($usuario_id, null);
		}

		$this->session->sess_destroy();
		redirect('Auth/login');
	}

	public function configuration()
	{
		$this->form_validation->set_rules('nameUserUpdate', $this->lang->line('userName'), 'required');
		// $this->form_validation->set_rules('selectAGroup', $this->lang->line('selectAGroup'), 'required');
		$this->form_validation->set_rules('language', $this->lang->line('language'), 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['imgUser'] = $this->session->userdata('img_user') == 'default_img' ? base_url('assets/img/img/default_img.webp') : base_url('uploads/user_img/') . $this->session->userdata('img_user');

			$this->loadViews('user', $data);
		} else {
			$data['nombre'] = $this->input->post('nameUserUpdate');
			$data['actual_group'] = $this->input->post('selectAGroup');
			$data['language'] = $this->input->post('language');
			$password = $this->input->post('userPassword');
			if ($password) {
				$data['password'] = password_hash($password, PASSWORD_DEFAULT);
			}

			$remove_image = $this->input->post('remove_image') == 1;
			$new_image_uploaded = !empty($_FILES['imagenUpdate']['name']);
			$current_image = $this->session->userdata('img_user');

			if ($remove_image) {
				$data['img'] = 'default_img';

				if ($current_image && file_exists('./uploads/user_img/' . $current_image)) {
					unlink('./uploads/user_img/' . $current_image);
				}
			} else if ($new_image_uploaded) {
				$config['upload_path'] = './uploads/user_img/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				//$config['max_size'] = 2048;

				$ext = pathinfo($_FILES['imagenUpdate']['name'], PATHINFO_EXTENSION);

				//Comprobamos el nombre hasta que no exista y entonces lo introducimos en la base de datos
				do {
					$uniqueName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
				} while ($this->User_model->imageUserExists($uniqueName));

				$config['file_name'] = $uniqueName;


				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('imagenUpdate')) {
					$photoFileName = $current_image;
				} else {
					$uploadData = $this->upload->data();
					$photoFileName = $uploadData['file_name'];

					if ($current_image && file_exists('./uploads/user_img/' . $current_image)) {
						unlink('./uploads/user_img/' . $current_image);
					}
				}

				$data['img'] = $photoFileName;
			} else {
				$data['img'] = $current_image;
			}
			if ($this->User_model->updateUser($this->session->userdata('user_id'), $data)) {
				$array = [
					'actual_group' => $data['actual_group'],
					'user_name' => $data['nombre'],
					'language' => $data['language'],
					'img_user' => $data['img']
				];
				$this->session->set_userdata($array);

				redirect(current_url());
			}
		}
	}

	public function recoverPassword()
	{
		//load libraries
		$this->load->library('email');

		//form validation
		$this->form_validation->set_rules('userEmail', $this->lang->line('email'), 'required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews('recoverPassword');
		} else {
			$email = $this->input->post('userEmail', TRUE);
			$user = $this->User_model->getUserByEmail($email);

			if ($user) {
				$token = bin2hex(random_bytes(32));
				$this->User_model->save_reset_token($user['usuario_id'], $token); // Guarda token y expiración

				$reset_link = site_url("auth/reset_password/$token");
				// Enviar email de confirmación
				$this->email->from('daniel2004navas@gmail.com', 'Eternals Vibes');
				$this->email->to($user['email']);
				$this->email->subject($this->lang->line('changePassword'));
				$messageText = $this->lang->line('messageLinkRecoverPass');
				$message = str_replace(['{NOMBRE}', '{LINK}'], [$user['nombre'], $reset_link], $messageText);
				$this->email->message($message);

				if (!$this->email->send()) {
					$data['errorInsert'] = "No se pudo enviar el email.";
					$this->loadViews("logIn", $data);
					return;
				}
			}

			$this->session->set_flashdata('globalModal', $this->lang->line('messageRecoverPass'));
			redirect('auth/login');
		}
	}

	public function reset_password($token)
	{
		if (!$token) {
			show_error();
		}

		$token_data = $this->User_model->get_valid_token($token);

		if (!$token_data) {
			show_error($this->lang->line('invalid_or_expired_token'));
		}

		$this->form_validation->set_rules('newPassword', $this->lang->line('password'), 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['token'] = $token;
			$this->loadViews('resetPassword', $data);
		} else {
			$new_password = $this->input->post('newPassword');
			$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

			// Actualiza la contraseña
			$this->User_model->update_password($token_data['usuario_id'], $hashed_password);
			$this->User_model->mark_token_used($token_data['id']);

			$this->session->set_flashdata('globalModal', $this->lang->line('password_updated_successfully'));
			redirect('auth/login');
		}
	}
}
