<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkup_model extends MY_Model {

	protected $table = 'rooms';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');
		$this->datatables->select('rooms.id')
		->select('rooms.name')
		->select('stayings.comment')
		->select('checkups.start_date')
		->select('checkups.due_date')
		->select('types.name as type')
		->from($this->table)
		->where('stayings.status', 1)
		->where('stayings.checkup', 1)
		->join('stayings', 'stayings.room_id = rooms.id')
		->join('checkups', 'checkups.room_id = rooms.id','left')
		->join('types', 'types.id = checkups.type_id','left');

		($user != '') ? $this->datatables->where('rooms.created_by', $user) : '' ;

		$edit = "<a href='" . base_url('admin/checkup/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
		$actions = $edit;

		$this->datatables->add_column(
			"actions",
			"<div class='text-center'>
				<div class='btn-group'>$actions</div>
			</div>",
			"id"
		);
		$this->datatables->unset_column('id');
		return $this->datatables->generate();
	}
	public function getData($id='')
	{
		$this->db->select('rooms.id')
				 ->select('checkups.id as c_id')
				 ->select('checkups.start_date')
				 ->select('checkups.due_date')
				 ->select('checkups.description')
				 ->select('checkups.type_id')
				 ->select('checkups.status')
				 ->select('types.name')
				 ->from('rooms')
				 ->where('rooms.id', $id)
				 ->join('checkups', 'checkups.room_id = rooms.id', 'left')
				 ->join('types', 'types.id = checkups.type_id','left');
		return $this->db->get()->row();
	}
	public function getType()
	{
		$this->db->select('id')
				 ->select('name')
				 ->from('types')
				 ->where('status', 1)
				 ->where('description', 'checkup');
		return $this->db->get()->result();
	}
}