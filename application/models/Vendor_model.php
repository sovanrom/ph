<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_model extends MY_Model {

	protected $table = 'vendor';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');
		$this->datatables->select('vendor.id')
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
			->join('honorifics', 'honorifics.id = vendor.title')
			->where('vendor.status', 1);

		($user != '') ? $this->datatables->where('vendor.created_by', $user) : '' ;

		$edit = "<a href='" . base_url('admin/vendor/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
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