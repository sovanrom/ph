<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RoomPayment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('building_model', 'building');
	}

	public function index()
	{
		$data['scripts'] = array('rentpayment');
		$data['active'] = 'roompayment';
		$data['title'] = 'Room Payment';
        $data['content'] = 'apps/room_payment/index';
        $this->page_construct('app', $data);
	}


}