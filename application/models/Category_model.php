<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {

	protected $table = 'categories';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');

		$this->datatables->select('categories.id')
			->select('categories.pref')
			->select('categories.khmer')
			->select('categories.latin')
			->select('categories.description')
			->select('sub.latin as parent')
			->from($this->table)
			->where('categories.status', 1)
			->join('categories sub', 'sub.id = categories.parent', 'left');

		($user != '') ? $this->datatables->where('created_by', $user) : '' ;

		$edit = "<a href='" . base_url('admin/category/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
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