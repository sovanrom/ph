<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['scripts'] = array('dashboard');
		$data['title']   = 'Dashboard';
		$data['content'] = 'apps/dashboard';
		$this->load->view('app', $data);
	}

}