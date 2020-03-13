<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends MY_Model {

	protected $table = 'items';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');
		$this->datatables->select('items.id')
			->select('items.khmer')
			->select('items.latin')
			->select('items.item_type')
			->select('categories.latin as category_id')
			->select('items.description')
			->from($this->table)
			->join('categories', 'categories.id = items.category_id')
			->where('items.status', 1);

		($user != '') ? $this->datatables->where('items.created_by', $user) : '' ;

		$edit = "<a href='" . base_url('admin/item/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
		$actions = $edit ;

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