<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Department_model', 'department');
	}

	public function index()
	{
		$data['scripts'] = array('department');
		$data['active'] = 'department';
		$data['title'] = 'Departments';
		$data['scripts'] = array('department');
		$data['content'] = 'apps/department/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->department->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$department = array(
				'name' => $this->input->post('name'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->department->insert($department)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/department/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$department = array(
				'name' => $this->input->post('name'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->department->update($id, $department)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['department'] = $this->department->get_by_id($id);
		$this->load->view('apps/department/edit', $data);
	}

	public function delete($id)
	{
		$department = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->department->update($id, $department)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}
	public function select2()
	{
		echo json_encode(['items' => $this->department->select2($this->input->post('search'))]);
	}
}