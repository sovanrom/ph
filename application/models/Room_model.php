<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_model extends MY_Model {

	protected $table = 'rooms';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($building_id='')
	{
		$this->load->library('datatables');
		$this->datatables->select('rooms.id')
		->select('rooms.name')
		->select('p.price as price')
		->select('begin_elect')
		->select('begin_water')
		->select('buildings.building_name as building_name')
		->select('floors.name as floor_id')
		->select('rooms.new_water_usage')
		->select('rooms.new_elect_usage')
		->from($this->table)
		->join('prices p', 'p.id  = rooms.price')
		->join('buildings', 'buildings.id = rooms.building_id')
		->join('floors', 'floors.id = rooms.floor_id')
		->where('rooms.status', 1);
		if (!empty($building_id)) {

			$this->datatables->where('rooms.building_id', $building_id);
		}

		$edit = "<a href='" . base_url('admin/room/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
		$delete = "<a href='" . base_url('admin/room/delete/$1') . "' class='remove' title='delete'><i class='entypo-trash'></i></a>";
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
	public function countRoom($building_id='')
	{
		$this->db->select('rooms.id')
				 ->from('rooms')
				 ->where('building_id', $building_id)
				 ->where('status', 1);
		return $this->db->get()->result();
	}
}