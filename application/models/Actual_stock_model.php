<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actual_stock_model extends MY_Model {

	protected $table = 'items';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');
		$this->datatables->select('id')
		->select('latin')
		->select('khmer')
		->select('qty')
		->from($this->table)
		->where('created_by', $user)
		->where('status', 1);
	

		$edit = "<a href='" . base_url('admin/actual_stock/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
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
}