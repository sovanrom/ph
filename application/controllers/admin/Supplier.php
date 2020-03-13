<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('supplier_model', 'supplier');
	}

	public function index()
	{
		$data['scripts'] = array('supplier');
		$data['active'] = 'supplier';
		$data['title'] = 'Manage Supplier';
		$data['content'] = 'apps/supplier/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->supplier->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$supplier = array(
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
			$message = ($this->supplier->insert($supplier)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['honorifics']=$this->supplier->select('honorifics');
		$this->load->view('apps/supplier/create',$data);
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$supplier = array(
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
			$message = ($this->supplier->update($id, $supplier)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['honorifics']=$this->supplier->select('honorifics');
		$data['supplier'] = $this->supplier->get_by_id($id);
		$this->load->view('apps/supplier/edit', $data);
	}
}