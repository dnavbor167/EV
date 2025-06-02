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
		// var_dump($this->session->userdata());exit;
		$this->loadViews("home");
	}

	public function paymentsPlans()
	{
		$this->loadViews('paymentsPlans');
	}

	public function infoWeb() {
		$this->loadViews('infoWeb');
	}
}
