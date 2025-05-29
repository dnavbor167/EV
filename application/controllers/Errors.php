<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Errors extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->show_404();
	}

    public function show_404() {
        $this->output->set_status_header('404');
        $data['home_url'] = site_url('Dashboard');
        $this->load->view('errors/html/error_404', $data);
    }

}
