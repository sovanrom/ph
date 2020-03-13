<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usage extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usage_model', 'usage');
	}

	public function index()
	{
		$data['scripts'] = array('usage');
		$data['active'] = 'usage';
		$data['title'] = 'Manage Usage';
		$data['content'] = 'apps/usage/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->usage->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$usage = array(
				'building_id' => $this->input->post('building_id'),
				'room_id' => $this->input->post('room_id'),
				'old_water_usage' => $this->input->post('old_water_usage'),
				'old_elect_usage' => $this->input->post('old_elect_usage'),
				'elect_usage' => $this->input->post('elect_usage'),
				'water_usage' => $this->input->post('water_usage'),
				'new_water_usage' => $this->input->post('new_water_usage'),
				'new_elect_usage' => $this->input->post('new_elect_usage'),
				'date' => date('Y-m-d H:i:s',strtotime($this->input->post('date'))),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$room= array(
				'new_water_usage' => $this->input->post('new_water_usage'),
				'new_elect_usage' => $this->input->post('new_elect_usage'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user
			);
			// update usage status to 0
			$status = array('status' => 0 );
			$this->db->where('room_id', $this->input->post('room_id'));
			$this->db->update('usages', $status);
			// update rooms water_usage and elect_usage
			$this->load->model('room_model','room');
			$this->room->update( $this->input->post('room_id'), $room);
			// insert usage
			$this->usage->insert($usage);
			// update stayings's usage_id
			$usage_id=$this->db->insert_id();
			$staying = array('usage_id' =>$usage_id );
			$this->db->where('room_id', $this->input->post('room_id'));
			$message = ($this->db->update('stayings', $staying)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['rooms']=$this->usage->get_room();
		$this->load->view('apps/usage/create',$data);
	}

	public function bundlecreate()
		{
			if (!empty($this->input->post())) {
					$usage = array(
						'building_id' => $this->input->post('building_id'),
						'room_id' => $this->input->post('room_id'),
						'old_water_usage' => $this->input->post('old_water_usage'),
						'old_elect_usage' => $this->input->post('old_elect_usage'),
						'new_water_usage' => $this->input->post('new_water_usage'),
						'new_elect_usage' => $this->input->post('new_elect_usage'),
						'elect_usage' => $this->input->post('elect_usage'),
						'water_usage' => $this->input->post('water_usage'),
						'date' =>$this->input->post('date'),
						'created_at' => $this->timestamp,
						'created_by' => $this->user,
						'status' => ($this->input->post('status') == 'on') ? 1 : 0
					);
					$room= array(
						'new_water_usage' => $this->input->post('new_water_usage'),
						'new_elect_usage' => $this->input->post('new_elect_usage'),
						'updated_at' => $this->timestamp,
						'updated_by' => $this->user
					);
				$message = ($this->usage->bundleadd($usage,$room))? array('status' => 1) : array('status' => 0);
				echo json_encode($message);
				return '';
			}
			$data['rooms']=$this->usage->get_room();
			$this->load->view('apps/usage/bundlecreate',$data);
		}


	public function get_old_usage(){
		echo json_encode( $this->usage->get_old_usage($this->input->post('room_id')));
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$usage = array(
				'building_id' => $this->input->post('building_id'),
				'room_id' => $this->input->post('room_id'),
				'old_water_usage' => $this->input->post('old_water_usage'),
				'old_elect_usage' => $this->input->post('old_elect_usage'),
				'new_water_usage' => $this->input->post('new_water_usage'),
				'new_elect_usage' => $this->input->post('new_elect_usage'),
				'elect_usage' => $this->input->post('elect_usage'),
				'water_usage' => $this->input->post('water_usage'),
				'date' => date('Y-m-d H:i:s',strtotime($this->input->post('date'))),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$room= array(
				'new_water_usage' => $this->input->post('new_water_usage'),
				'new_elect_usage' => $this->input->post('new_elect_usage'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user
			);
			$this->load->model('room_model','room');
			$this->room->update( $this->input->post('room_id'), $room);
			$message = ($this->usage->update($id, $usage)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		// $data['buildings']=$this->usage->select('buildings','building_name');
		// $data['rooms']=$this->usage->get_room();
		// $data['rooms']=$this->usage->select('rooms');
		
		$this->db->select('usages.id')
			 ->select('rooms.name as room')
			 ->select('usages.room_id')
			 ->select('usages.old_water_usage')
			 ->select('usages.new_water_usage')
			 ->select('usages.water_usage')
			 ->select('usages.old_elect_usage')
			 ->select('usages.new_elect_usage')
			 ->select('usages.elect_usage')
			 ->select('usages.date')
			 ->select('usages.status')
			 ->where('usages.id', $id)
			 ->from('usages')
			 ->join('rooms', 'rooms.id = usages.room_id');
		$data['usage'] = $this->db->get()->row();
		$this->load->view('apps/usage/edit', $data);
	}

}