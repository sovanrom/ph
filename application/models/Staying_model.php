<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staying_model extends MY_Model {

	protected $table = 'stayings';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($room_id='')
	{
		$this->load->library('datatables');
		$this->datatables->select('stayings.id')
		->select('staying_name')
		->select('date_in')
		->select('usages.date as paid_date')
		->select('phone')
		->select('next_paid_date')
		->select('types.name as type_id')
		->select('usages.id as usages_id')
		->select('prices.price as price')
		->from($this->table)
		->where('stayings.status', 1)
		->join('usages', 'usages.room_id = stayings.room_id')
		->join('types', 'types.id = stayings.type_id','left')
		->join('rooms', 'rooms.id = stayings.room_id')
		->join('prices', 'prices.id = rooms.id');
		if (!empty($room_id)) {
			$this->datatables->where('stayings.room_id', $room_id);
		}
		$edit = "<a href='" . base_url('admin/staying/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
		// $delete = "<a href='" . base_url('admin/staying/delete/$1') . "' class='remove' title='delete'><i class='entypo-trash'></i></a>";
		$actions = $edit ;

		$this->datatables->add_column(
			"actions",
			"<div class='text-center'>
				<div class='btn-group'>
					".$actions."
				</div>
			</div>",
			"id"
		);
		$this->datatables->unset_column('id');
		return $this->datatables->generate();
	}

	function get_room($building=''){
		$this->db->select('id')
        	->select('name')
        	->from('rooms')
        	->where('status',1)
        	->where('building_id',$building);
        return $this->db->get()->result();
	}
	function get_staying($room=''){
		$this->db->select('stayings.id')
			->select('stayings.room_id')
			->select('types.name as type_id')
			->select('stayings.staying_name')
			->select('stayings.date_in')
			->select('stayings.phone')
			->select('stayings.number_person')
			->select('prices.price')
			->select('stayings.paid_date')
			->select('stayings.next_paid_date')
			// error with last record of usage
			->select('usages. water_usage')
			->select('usages. elect_usage')
			//
	        ->from('stayings')
	        ->where('stayings.status',1)
	        ->where('stayings.room_id',$room)
	        ->join('rooms', 'rooms.id = stayings.room_id')
	        ->join('prices', 'prices.id = rooms.price')
	        ->join('usages', 'usages.room_id = rooms.id','left')
	        ->join('types', 'types.id = stayings.type_id','left');
        return $this->db->get()->result();
	}
	function rooms(){
		$this->db->select('id','new_elect_usage','new_water_usage')
			->select('new_elect_usage')
			->select('new_water_usage')
	        ->from('rooms')
	        ->where('status',1);
        return $this->db->get()->result();
	}
}