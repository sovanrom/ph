<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fleet extends MY_Fleet_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['scripts'] = array('dashboard');
		$data['title']   = 'Dashboard';
		$data['content'] = 'fleet/dashboard';
        $this->page_fleet_construct('fleet', $data);
	}

}