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

		//Si se actualiza bien devolvemos json
		if ($this->Admin_model->acceptDeclineUsers($user_id, $acceptDecline)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
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
