<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('room_model', 'room');
	}

	public function index()
	{
		$data['scripts'] = array('room');
		$data['active'] = 'room';
		$data['title'] = 'Manage Room';
		$data['content'] = 'apps/room/index';
		$data['buildings']=$this->room->select('buildings','building_name');
        $this->page_construct('app', $data);
	}

	public function countRoom($building_id='')
	{	
		$this->db->select('rooms')
				 ->from('buildings')
				 ->where('status',1)
				 ->where('id',$building_id);
		$container = $this->db->get()->row('rooms');
		$created = count($this->room->countRoom($building_id));
		$available = $container - $created;
		echo json_encode($available);
	}

	public function all()
	{

		echo (!empty($this->input->post('building_id'))) ?  $this->room->all($this->input->post('building_id')) :$this->room->all() ;
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$room = array(
				'name' => $this->input->post('name'),
				'building_id' => $this->input->post('building_id'),
				'floor_id' => $this->input->post('floor_id'),
				'price' => $this->input->post('price'),
				// 'new_water_usage' => $this->input->post('new_water_usage'),
				// 'new_elect_usage' => $this->input->post('new_elect_usage'),
				'begin_water' => $this->input->post('begin_water'),
				'begin_elect' => $this->input->post('begin_elect'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->room->insert($room)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/room/create');
	}

	public function bundlecreate()
	{
		if (!empty($this->input->post())) {
			$rooms= array();
			$cnt=count($this->input->post('name'));
			for ($i=0; $i < $cnt; $i++){
				if ( $this->input->post('name')[$i] !== '') {
					$room = array(
			 		'name' => $this->input->post('name')[$i],
					'building_id' => $this->input->post('building_id'),
					'floor_id' => $this->input->post('floor_id')[$i],
					'price' => $this->input->post('price')[$i],
					// 'new_water_usage' => $this->input->post('new_water_usage'),
					// 'new_elect_usage' => $this->input->post('new_elect_usage'),
					'begin_water' => $this->input->post('begin_water')[$i],
					'begin_elect' => $this->input->post('begin_elect')[$i],
					'created_at' => $this->timestamp,
					'created_by' => $this->user,
					'status' => 1
				 	);
					array_push($rooms, $room);
				}
			}
			$message = ($this->db->insert_batch('rooms',$rooms))? array('status' => 1, 'building_id'=>$this->input->post('building_id')) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['floors'] = $this->room->select('floors');
		$data['prices'] = $this->room->select('prices','price');
		$this->load->view('apps/room/bundlecreate',$data);
	}



	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$room = array(
				'name' => $this->input->post('name'),
				'building_id' => $this->input->post('building_id'),
				'floor_id' => $this->input->post('floor_id'),
				'price' => $this->input->post('price'),
				// 'new_water_usage' => $this->input->post('new_water_usage'),
				// 'new_elect_usage' => $this->input->post('new_elect_usage'),
				'begin_water' => $this->input->post('begin_water'),
				'begin_elect' => $this->input->post('begin_elect'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->room->update($id, $room)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->db->select('buildings.id as building_id')
			     ->select('buildings.building_name as building')
			     ->select('floors.id as floor_id')
			     ->select('floors.name as floor')
			     ->select('prices.id as price_id')
			     ->select('prices.price as price')
			     ->select('rooms.name')
			     ->select('rooms.begin_water')
			     ->select('rooms.begin_elect')
			     ->select('rooms.status')
			     ->select('rooms.id')
			     ->where('rooms.id', $id)
			     ->from('rooms')
			     ->join('buildings', 'buildings.id = rooms.building_id')
			     ->join('floors', 'floors.id = rooms.floor_id')
			     ->join('prices', 'prices.id = rooms.price');
		$data['room'] = $this->db->get()->row();
		$this->load->view('apps/room/edit', $data);
	}

	public function delete($id)
	{
		$room = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->room->update($id, $room)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

	public function stayingRoom()
	{
        $this->db->select('id')
            ->select('name' . ' as text')
            ->from('rooms')
            ->like('name', $this->input->post('search'), 'both')
            ->where('status', 1)
            ->where('type_id', 10)
            ->limit(15);
        $result = $this->db->get()->result();
        echo json_encode(['items' => $result]);
	}

	public function select2()
	{
		echo json_encode(['items' => $this->room->select2($this->input->post('search'))]);
	}

}