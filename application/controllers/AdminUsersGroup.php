<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminUsersGroup extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
	}


	public function index()
	{
		$this->newUsers();
	}

	public function newUsers()
	{
		$data['newUsers'] = $this->Admin_model->getRequestUser();
		//Marcar como visto antes de entrar
		$this->Admin_model->seenUsersPetitions();

		$this->loadViews('adminUsers/newUsers', $data);
	}

	public function acceptDeclineUsers()
	{

		$user_id = $this->input->post('idUser');
		$acceptDecline = $this->input->post('acceptDecline');

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
		if ($plan === true || count($this->Admin_model->getUsersAcceptedByGroup()) + 1 <= $plan) {
			//Si se actualiza bien devolvemos json
			if ($this->Admin_model->acceptDeclineUsers($user_id, $acceptDecline)) {
				echo json_encode(['success' => true]);
			} else {
				echo json_encode(['success' => false]);
			}
		} else {
			$this->session->set_flashdata('globalModal', $this->lang->line('errorInsertUser'));
			echo json_encode([
				'success' => false,
				'redirect' => site_url('Dashboard/paymentsPlans')
			]);
		}
	}

	//actual users
	public function groupUsers()
	{
		$data['usersGroup'] = $this->Admin_model->getUsersAcceptedByGroup();
		$this->loadViews('adminUsers/actualUsers', $data);
	}

	//Eliminar usuarios del grupo
	public function deleteUsersFromGroup()
	{
		$user_id = $this->input->post('idUser');

		//Si se elimina bien devolvemos json
		if ($this->Admin_model->deleteUserFromGroupById($user_id)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}

	//Actualizar rol de usuario
	public function updateUserRol()
	{
		$user_id = $this->input->post('idUser');
		$newRol = $this->input->post('newRol');

		//Si se actualiza el rol bien devolvemos json
		if ($this->Admin_model->updateUserRolFromGroup($user_id, $newRol)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}


}
