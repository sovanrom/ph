<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floor extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('floor_model', 'floor');
	}

	public function index()
	{
		$data['scripts'] = array('floor');
		$data['active'] = 'floor';
		$data['title'] = 'Manage Floor';
		$data['content'] = 'apps/floor/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->floor->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$floor = array(
				'name' => $this->input->post('name'),
				'pref' => $this->input->post('pref'),
				'description' => $this->input->post('description'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->floor->insert($floor)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/floor/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$floor = array(
				'name' => $this->input->post('name'),
				'pref' => $this->input->post('pref'),
				'description' => $this->input->post('description'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->floor->update($id, $floor)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['floor'] = $this->floor->get_by_id($id);
		$this->load->view('apps/floor/edit', $data);
	}

	public function delete($id)
	{
		$floor = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->floor->update($id, $floor)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}
	public function select2()
	{
		echo json_encode(['items' => $this->floor->select2($this->input->post('search'))]);
	}
}