<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_building_model extends MY_Model {

	protected $table = 'manage_buildings';

	public function __construct()
	{
		parent::__construct();
	}

	public function all()
	{
		$this->load->library('datatables');
		$this->datatables->select('id')
		->select('building_name')
		->select('rooms')
		->select('contact_person')
		->select('phone')
		->select('email')
		->select('description')
		->select('address')
		->select('address1')
		->select('address2')
		->select('address3')
		->from($this->table)
		->where('status', 1);

		$edit = "<a href='" . base_url('manage_building/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
		$delete = "<a href='" . base_url('manage_building/delete/$1') . "' class='remove' title='delete'><i class='entypo-trash'></i></a>";
		$actions = $edit . $delete;

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

}