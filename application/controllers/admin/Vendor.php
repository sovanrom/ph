<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vendor_model', 'vendor');
	}

	public function index()
	{
		$data['scripts'] = array('vendor');
		$data['active'] = 'vendor';
		$data['title'] = 'Manage vendor';
		$data['content'] = 'apps/vendor/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->vendor->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$vendor = array(
				'company_name' => $this->input->post('company_name'),
				'title' => $this->input->post('title'),
				'last_name' => $this->input->post('last_name'),
				'first_name' => $this->input->post('first_name'),
				'phone1' => $this->input->post('phone1'),
				'phone2' => $this->input->post('phone2'),
				'email' => $this->input->post('email'),
				'website' => $this->input->post('website'),
				'address' => $this->input->post('address'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->vendor->insert($vendor)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['honorifics']=$this->vendor->select('honorifics');
		$this->load->view('apps/vendor/create',$data);
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$vendor = array(
				'company_name' => $this->input->post('company_name'),
				'title' => $this->input->post('title'),
				'last_name' => $this->input->post('last_name'),
				'first_name' => $this->input->post('first_name'),
				'phone1' => $this->input->post('phone1'),
				'phone2' => $this->input->post('phone2'),
				'email' => $this->input->post('email'),
				'website' => $this->input->post('website'),
				'address' => $this->input->post('address'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->vendor->update($id, $vendor)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['honorifics']=$this->vendor->select('honorifics');
		$data['vendor'] = $this->vendor->get_by_id($id);
		$this->load->view('apps/vendor/edit', $data);
	}
}