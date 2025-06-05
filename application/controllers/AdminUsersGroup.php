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

	public function newUsers() {
		$data['newUsers'] = $this->Admin_model->getRequestUser();

		$this->loadViews('adminUsers/newUsers', $data);
	}

	
}
