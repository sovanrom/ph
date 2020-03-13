<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

	protected $table = 'aauth_users';

	public function __construct()
	{
		parent::__construct();
	}

	public function all()
	{
		$this->load->library('datatables');
		$this->datatables->select('aauth_users.id')
			->select('aauth_users.emp_no')
			->select('aauth_users.full_name')
			->select('aauth_users.phone')
			->select('aauth_users.email')
			->select('aauth_users.username')
			->select('aauth_users.pass')
			->select('aauth_groups.name as group_id')
			->from($this->table)
			->join('aauth_groups', 'aauth_groups.id = aauth_users.group_id')
			->where('aauth_users.status', 1);

		$edit = "<a href='" . base_url('admin/user/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
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

}