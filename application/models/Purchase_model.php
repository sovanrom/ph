
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends MY_Model {

	protected $table = 'purchases';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');
		$this->datatables->select("$this->table.id")
			->select("$this->table.comment")
			->select("$this->table.post_date")
			->select("$this->table.status")
			->select('aauth_users.full_name as user')
			->from($this->table)
			->join('aauth_users', "aauth_users.id = $this->table.user_id");
			// ->where('purchases.status', 1);

		$edit = "<a href='" . base_url('admin/purchase/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
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