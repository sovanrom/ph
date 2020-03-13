<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkup extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Checkup_model', 'checkup');
	}

	public function index()
	{
		$data['scripts'] = array('checkup');
		$data['active'] = 'checkup';
		$data['title'] = 'checkup List';
		$data['content'] = 'apps/checkup/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->checkup->all($this->user);
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			if($this->input->post('checkup_id') == null){
				$checkup = array(
					'room_id' => $this->input->post('room_id'),
					'type_id' => $this->input->post('type_id'),
					'description' => $this->input->post('description'),
					'start_date' => date('Y-m-d H:i:s',strtotime($this->input->post('start_date'))),
					'due_date' => date('Y-m-d H:i:s',strtotime($this->input->post('due_date'))),
					'created_at' => $this->timestamp,
					'created_by' => $this->user,
					'status' => ($this->input->post('status') == 'on') ? 1 : 0
				);
				if($this->input->post('start_date') == null){
					unset($checkup['start_date']);
					unset($checkup['due_date']);
				}

					// update type_id on table rooms
				$room = array('type_id' => $this->input->post('type_id'));
				$this->db->where('id', $this->input->post('room_id'));
				$this->db->update('rooms', $room);

				$message = ($this->db->insert('checkups',$checkup)) ? array('status' => 1) : array('status' => 0);
				echo json_encode($message);
				return '';
			}
			else{
				$checkup = array(
					'room_id' => $this->input->post('room_id'),
					'type_id' => $this->input->post('type_id'),
					'description' => $this->input->post('description'),
					'start_date' => date('Y-m-d H:i:s',strtotime($this->input->post('start_date'))),
					'due_date' => date('Y-m-d H:i:s',strtotime($this->input->post('due_date'))),
					'updated_at' => $this->timestamp,
					'updated_by' => $this->user,
					'status' => ($this->input->post('status') == 'on') ? 1 : 0
				);
				if($this->input->post('start_date') == null){
					unset($checkup['start_date']);
					unset($checkup['due_date']);
				}

					// update type_id on table rooms
				$room = array('type_id' => $this->input->post('type_id'));
				$this->db->where('id', $this->input->post('room_id'));
				$this->db->update('rooms', $room);

				$this->db->where('id', $this->input->post('checkup_id'));
				$message = ($this->db->update('checkups',$checkup)) ? array('status' => 1) : array('status' => 0);
				echo json_encode($message);
				return '';
			}
		}
		$data['types'] = $this->checkup->getType();
		$data['checkup'] = $this->checkup->getData($id);
		$this->load->view('apps/checkup/edit',$data);
	}

	// public function delete($id)
	// {
	// 	$checkup = array(
	// 		'deleted_at'=>$this->timestamp,
	// 		'deleted_by'=>$this->user,
	// 		'status' => 0
	// 	);
	// 	$message = ($this->checkup->update($id, $checkup)) ? array('status' => 1) : array('status' => 0);
	// 	echo json_encode($message);
	// }

}