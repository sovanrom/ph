<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library("Aauth");
	}

	public function index()
	{
		$resp = array();

		if (!empty($this->input->post())) {
			$resp['submitted_data'] = $this->input->post();
			$login_status = 'invalid';
			$login_status = $this->aauth->login($this->input->post('username'), $this->input->post('password')) ? 'success' : 'invalid';
			$resp['login_status'] = $login_status;
			if ($login_status == 'success') {
				$resp['redirect_url'] = base_url() . 'app';
			}
			echo json_encode($resp);
			return '';
		}
		$this->load->view('apps/user/login');
	}
}