<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		
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
		//form validation
		$this->form_validation->set_rules('userName', $this->lang->line('userName'), 'required');
		$this->form_validation->set_rules('userEmail', $this->lang->line('email'), 'required|valid_email');
		$this->form_validation->set_rules('userPassword', $this->lang->line('password'), 'required');
		$this->form_validation->set_rules('language', $this->lang->line('language'), 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews("signIn");
		} else {
			$data['userName'] = $this->input->post('userName');
			$data['email'] = $this->input->post('userEmail');
			$data['password'] = $this->input->post('userPassword');
			$login = $this->User_model->loginUser($data);

			if ($login) {
				$array = array(
					'language' => $login->lenguage
				);
				redirect(base_url('Dashboard'));
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

	public function recoverPassword() {
		//form validation
		$this->form_validation->set_rules('userEmail', $this->lang->line('email'), 'required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews('recoverPassword');
		} else {
			
		}
	}
}
