<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('building_model', 'building');
	}

	public function index()
	{
		$data['scripts'] = array('reservation');
		$data['active'] = 'reservation';
		$data['title'] = 'Reservation';
		$data['content'] = 'apps/reservation/index';
        $this->page_construct('app', $data);
	}

}