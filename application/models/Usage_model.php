<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usage_model extends MY_Model {

	protected $table = 'usages';

	public function __construct()
	{
		parent::__construct();
	}

	public function all()
	{
		$this->load->library('datatables');
		$this->datatables->select('usages.id as id')
		// ->select('buildings.building_name as building_id')
		->select('rooms.name as room_id')
		->select('usages.new_water_usage')
		->select('usages.water_usage')
		->select('usages.old_water_usage')
		->select('usages.old_elect_usage')
		->select('usages.new_elect_usage')
		->select('usages.elect_usage')
		->select('DATE_FORMAT(date,"%m-%d-%Y") AS date')
		->from($this->table)
		// ->join('buildings', 'buildings.id = usages.building_id')
		->join('rooms', 'rooms.id = usages.room_id')
		->where('usages.status', 1);


		$edit = "<a href='" . base_url('admin/usage/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
		$actions = $edit;

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
	public function get_old_usage($room='')
	{ 
		$this->db->select('new_elect_usage');
        $this->db->select('new_water_usage');
        $this->db->from('rooms');
        $this->db->where('status',1);
        $this->db->where('id',$room);
        return $this->db->get()->row();
	}
	public function get_room()
	{
		$this->db->select('rooms.id');
		$this->db->select('name');
		$this->db->from('rooms');
		$this->db->where('stayings.status', 1);
		$this->db->join('stayings', 'stayings.room_id = rooms.id');
		 return $this->db->get()->result();
	}
	public function bundleadd($usage,$room)
		{
			$cnt=count($usage['room_id']);
			for ($i=0; $i <$cnt ; $i++) { 
				$usages= array(
					'building_id' =>$usage['building_id'][$i],
					'room_id' => $usage['room_id'][$i],
					'old_water_usage' => $usage['old_water_usage'][$i],
					'old_elect_usage' => $usage['old_elect_usage'][$i],
					'new_water_usage' => $usage['new_water_usage'][$i],
					'new_elect_usage' => $usage['new_elect_usage'][$i],
					'elect_usage' => $usage['elect_usage'][$i],
					'water_usage' => $usage['water_usage'][$i],
					'date' =>date('Y-m-d H:i:s',strtotime( $usage['date'][$i])),
					'created_at' => $usage['created_at'],
					'created_by' => $usage['created_by'],
					'status' => $usage['status']
				);
				$rooms=array(
					'new_water_usage' => $room['new_water_usage'][$i],
					'new_elect_usage' => $room['new_elect_usage'][$i],
					'updated_at' => $room['updated_at'],
					'updated_by' =>$room['updated_by']
				);
				$status = array('status' => 0 );
				$this->db->where('room_id', $usages['room_id']);
				$this->db->update('usages', $status);

				$this->db->where('id', $usages['room_id']);
				$this->db->update('rooms', $rooms);

				$this->db->insert('usages', $usages);

				$usage_id=$this->db->insert_id();
				$staying = array('usage_id' =>$usage_id );
				$this->db->where('room_id', $usage['room_id'][$i]);
				$this->db->update('stayings', $staying);
			}
			return true;
		}
}