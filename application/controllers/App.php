<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends My_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library("Aauth");
	}

	public function index()
	{
		$data['scripts'] = array('dashboard');
        $data['active']   = 'dashboard';
        $data['title']   = 'Dashboard';
		$data['content'] = 'apps/dashboard';
        $this->page_construct('app', $data);
	}

}