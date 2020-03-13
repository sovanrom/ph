<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apartment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Apartment_model', 'apartment');
	}

	public function index()
	{
		$data['scripts'] = array('apartment');
		$data['active'] = 'apartment';
		$data['title'] = 'Apartment List';
		$data['content'] = 'apps/apartment/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->apartment->all($this->user);
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$apartment = array(
				'name' => $this->input->post('name'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->apartment->insert($apartment)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/apartment/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$apartment = array(
				'name' => $this->input->post('name'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->apartment->update($id, $apartment)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['apartment'] = $this->apartment->get_by_id($id);
		$this->load->view('apps/apartment/edit', $data);
	}

	public function delete($id)
	{
		$apartment = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->apartment->update($id, $apartment)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

}