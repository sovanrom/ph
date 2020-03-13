<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Type_model', 'type');
	}

	public function index()
	{
		$data['scripts'] = array('type');
		$data['active'] = 'type';
		$data['title'] = 'Types';
		$data['content'] = 'apps/type/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->type->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$type = array(
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->type->insert($type)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/type/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$type = array(
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->type->update($id, $type)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['type'] = $this->type->get_by_id($id);
		$this->load->view('apps/type/edit', $data);
	}

	public function delete($id)
	{
		$type = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->type->update($id, $type)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

	public function stayingType()
	{
        $this->db->select('id')
            ->select('name' . ' as text')
            ->from('types')
            ->like('name', $this->input->post('search'), 'both')
            ->where('status', 1)
            ->where('description', 'room')
            ->limit(15);
        $result = $this->db->get()->result();
        echo json_encode(['items' => $result]);
	}

	public function select2()
	{
		echo json_encode(['items' => $this->type->select2($this->input->post('search'))]);
	}
}