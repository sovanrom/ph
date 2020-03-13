<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('building_model', 'building');
	}

	public function index()
	{
		$data['scripts'] = array('building');
		$data['active'] = 'building';
		$data['title'] = 'Manage Building';
		$data['content'] = 'apps/building/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->building->all($this->GP["building-edit"]);
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$building = array(
				'building_name_kh' => $this->input->post('building_name_kh'),
				'building_name' => $this->input->post('building_name'),
				'pref' => $this->input->post('pref'),
				'type_id' => $this->input->post('type_id'),
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
			$message = ($this->building->insert($building)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/building/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$building = array(
				'building_name_kh' => $this->input->post('building_name_kh'),
				'building_name' => $this->input->post('building_name'),
				'pref' => $this->input->post('pref'),
				'type_id' => $this->input->post('type_id'),
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
			$message = ($this->building->update($id, $building)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->db->select('types.id as type_id')
				 ->select('types.name as type')
				 ->from('buildings')
				 ->where('buildings.id', $id)
				 ->join('types', 'types.id = buildings.type_id');
		$data['types']=$this->db->get()->row();
		$data['building'] = $this->building->get_by_id($id);
		$this->load->view('apps/building/edit', $data);
	}
	public function select2()
	{
		echo json_encode(['items' => $this->building->select2($this->input->post('search'),'building_name')]);
	}
}