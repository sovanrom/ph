<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_building extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('manage_building_model', 'manage_building');
	}

	public function index()
	{
		$data['scripts'] = array('manage_building');
		$data['active'] = 'manage_building';
		$data['title'] = 'Manage Building';
		$data['content'] = 'apps/manage_building/index';
		$this->load->view('app', $data);
	}

	public function all()
	{
		echo $this->manage_building->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$manage_building = array(
				'building_name' => $this->input->post('building_name'),
				'rooms' => $this->input->post('rooms'),
				'contact_person' => $this->input->post('contact_person'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'description' => $this->input->post('description'),
				'address' => $this->input->post('address'),
				'address1' => $this->input->post('address1'),
				'address2' => $this->input->post('address2'),
				'address3' => $this->input->post('address3'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->manage_building->insert($manage_building)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/manage_building/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$manage_building = array(
				'building_name' => $this->input->post('building_name'),
				'rooms' => $this->input->post('rooms'),
				'contact_person' => $this->input->post('contact_person'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'description' => $this->input->post('description'),
				'address' => $this->input->post('address'),
				'address1' => $this->input->post('address1'),
				'address2' => $this->input->post('address2'),
				'address3' => $this->input->post('address3'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->manage_building->update($id, $manage_building)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['manage_building'] = $this->manage_building->get_by_id($id);
		$this->load->view('apps/manage_building/edit', $data);
	}

	public function delete($id)
	{
		$manage_building = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->manage_building->update($id, $manage_building)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

}