<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends MY_Model {

	protected $table = 'supplier';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');
		$this->datatables->select('supplier.id')
			->select('company_name')
			->select('honorifics.name as title')
			->select('last_name')
			->select('first_name')
			->select('phone1')
			->select('phone2')
			->select('email')
			->select('website')
			->select('address')
			->from($this->table)
			->join('honorifics', 'honorifics.id = supplier.title')
			->where('supplier.status', 1);

		($user != '') ? $this->datatables->where('supplier.created_by', $user) : '' ;

		$edit = "<a href='" . base_url('admin/supplier/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
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