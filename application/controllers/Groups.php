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

	public function createGroup()
	{
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
				$nombre = $this->input->post('userNameGroup');
				$email = $this->input->post('groupEmail');
				$password = password_hash($this->input->post('userPassword'), PASSWORD_DEFAULT);
				$promotions = $this->input->post('groupPromotions');
				$tempFile = $_FILES['groupPhoto']['tmp_name'];
				$originalName = $_FILES['groupPhoto']['name'];

				$this->session->set_userdata([
					'registro_grupo' => [
						'nombre' => $nombre,
						'email' => $email,
						'password' => $password,
						'termsConditions' => $promotions,
						'foto_temp' => $tempFile,
						'foto_nombre_original' => $originalName
					]
				]);

				$this->loadViews('paymentsPlans');
			}
		} else {
			$this->loadViews('group/createGroup');
		}
	}

	public function paymentsPlans($plan)
	{
		if (!$plan) {
			show_error($this->lang->line('notPlanSelected'));
		}

		$registro = $this->session->userdata('registro_grupo');
		$registro['metodo_pago'] = $plan;

		$this->session->set_userdata('registro_grupo', $registro);

		if ($plan == 'free') {
			$registro = $this->session->userdata('registro_grupo');
			$this->session->unset_userdata('registro_grupo'); //Liberamos la session por seguridad

			//insertamos grupo y obtenemos el id del grupo
			$grupo_id = $this->Group_model->inserGroup($registro);

			//hacemos relacion entre grupo y usuario y lo ponemos como admin por crearlo
			$data = [
				'usuario_id' => $this->session->userdata('user_id'),
				'grupo_id' => $grupo_id,
				'rol' => 'admin'
			];
			
			if ($this->Group_model->insert_usuario_grupos($data)) {
				//actualizamos el actual group al usuario
				$this->User_model->updateUser($data['usuario_id'], ['actual_group' => $grupo_id]);
				//reseteamos sessions
				$this->session->set_userdata('is_in_any_group', $this->User_model->userBelongGroup($data['usuario_id']));
				$this->session->set_userdata('actual_group', $grupo_id);

				$groups_ids = array_column($this->session->userdata['is_in_any_group'], 'grupo_id');
				$this->session->set_userdata('groups', $this->User_model->getGroups($groups_ids));

				echo json_encode([
					'success' => true,
					'url' => base_url('Dashboard')
				]);
			}
		} else {
			\Stripe\Stripe::setApiKey('sk_test_TU_CLAVE'); // Sustituye por tu clave real

			$precio = 0;
			switch ($plan) {
				case 'pro':
					$precio = 1000; // 10 EUR en céntimos
					break;
				case 'premium':
					$precio = 2000; // 20 EUR en céntimos
					break;
				default:
					show_error('Plan no válido');
			}

			$session = \Stripe\Checkout\Session::create([
				'payment_method_types' => ['card'],
				'mode' => 'payment',
				'line_items' => [
					[
						'price_data' => [
							'currency' => 'eur',
							'product_data' => ['name' => 'Plan ' . ucfirst($plan)],
							'unit_amount' => $precio,
						],
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
}
