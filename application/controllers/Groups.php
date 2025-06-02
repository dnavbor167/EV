<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Groups extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->loadViews('joinCreateGroup');
	}

	public function createGroup() {
		$this->loadViews('group/createGroup');
	}
}
