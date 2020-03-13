<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building_model extends MY_Model {

	protected $table = 'buildings';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($isEdit=0)
	{
		$this->load->library('datatables');
		$this->datatables->select('buildings.id')
		->select('building_name_kh')
		->select('building_name')
		->select('pref')
		->select('types.name')
		->select('rooms')
		->select('contact_person')
		->select('phone')
		->select('email')
		->select('buildings.description')
		->select('address')
		->select('address1')
		->select('address2')
		->select('address3')
		->from($this->table)
		->where('buildings.status', 1)
		->join('types', 'types.id = buildings.type_id');

		$edit = "<a href='" . base_url('admin/building/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
		$actions = ($isEdit==1?$edit:"");

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