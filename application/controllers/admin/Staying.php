<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staying extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('staying_model', 'staying');
	}

	public function index()
	{

		$data['scripts'] = array('staying');
		$data['active'] = 'staying';
		$data['title'] = 'Manage Staying';
		$data['content'] = 'apps/staying/index';
		$data['settings'] =$this->Settings;
		$data['buildings']=$this->staying->select('buildings','building_name');
		$this->page_construct('app', $data); 	
	}

	public function get_room(){
		echo json_encode( $this->staying->get_room($this->input->post('building')));

	} 

	public function get_staying(){
		echo json_encode( $this->staying->get_staying($this->input->post('staying')));

	}

	public function all()
	{
		echo (!empty($this->input->post('room_id'))) ?  $this->staying->all($this->input->post('room_id')) :$this->staying->all() ;
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$staying = array(
				'staying_name' => $this->input->post('staying_name'),
				'gender_id' => $this->input->post('gender_id'),
				'type_id' => $this->input->post('type_id'),
				'date_in' => date('Y-m-d H:i:s',strtotime($this->input->post('date_in'))),
	            'next_paid_date'  => date('Y-m-d',strtotime("+1 month",strtotime($this->input->post('date_in')))),
				'id_card' => $this->input->post('id_card'),
				'phone' => $this->input->post('phone'),
				'job' => $this->input->post('job'),
				'car' => $this->input->post('car'),
				'moto' => $this->input->post('moto'),
				'bicycle' => $this->input->post('bicycle'),
				'number_person' => $this->input->post('number_person'),
				'room_id' => $this->input->post('room_id'),
				'booking' => $this->input->post('booking'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$room = array(
				'new_water_usage' => $this->input->post('new_water_usage'),
				'new_elect_usage' => $this->input->post('new_elect_usage'),
			);
			$this->load->model('room_model','room');
			$this->room->update($this->input->post('room_id'), $room);
			$message = ($this->staying->insert($staying)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['genders']=$this->staying->select('genders');
		$this->load->view('apps/staying/create',$data);
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$staying = array(
				'staying_name' => $this->input->post('staying_name'),
				'gender_id' => $this->input->post('gender_id'),
				'type_id' => $this->input->post('type_id'),
				'date_in' => date('Y-m-d H:i:s',strtotime($this->input->post('date_in'))),
				'id_card' => $this->input->post('id_card'),
				'phone' => $this->input->post('phone'),
				'job' => $this->input->post('job'),
				'car' => $this->input->post('car'),
				'moto' => $this->input->post('moto'),
				'bicycle' => $this->input->post('bicycle'),
				'number_person' => $this->input->post('number_person'),
				'room_id' => $this->input->post('room_id'),
				'comment' => $this->input->post('comment'),
				'booking' => $this->input->post('booking'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0,
				'checkup' => ($this->input->post('checkup') == 'on') ? 1 : 0
			);
			$room = array(
				'new_water_usage' => $this->input->post('new_water_usage'),
				'new_elect_usage' => $this->input->post('new_elect_usage'),
			);
			$this->load->model('room_model','room');
			$this->room->update($this->input->post('room_id'), $room);
			$message = ($this->staying->update($id, $staying)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->db->select('rooms.id as room_id')
				 ->select('rooms.name as room')
				 ->select('types.id as type_id')
				 ->select('types.name as type')
				 ->from('stayings')
				 ->where('stayings.id', $id)
				 ->join('rooms', 'rooms.id = stayings.room_id')
				 ->join('types', 'types.id = stayings.type_id','left');
		$data['room']=$this->db->get()->row();
		// $data['types']=$this->staying->get_types();
		$data['genders']=$this->staying->select('genders');
		$data['room_usages']=$this->staying->rooms();
		$data['staying'] = $this->staying->get_by_id($id);
		$this->load->view('apps/staying/edit', $data);
	}

	public function delete($id)
	{
		$staying = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->staying->update($id, $staying)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

}