
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receive_model extends MY_Model {

	protected $table = 'receives';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '')
	{
		$this->load->library('datatables');
		$this->datatables->select("$this->table.purchase_id as id")
			->select("items.latin as item")
			->select("$this->table.quantity")
			->select("$this->table.amount")
			// ->select('vendor.company_name as vendors')
			->from($this->table)
			->where("$this->table.status", 1)
			->join('items', "items.id = $this->table.item_id");
			// ->join('vendor', "vendor.id = $this->table.vendor_id");

		$edit = "<a href='" . base_url('admin/receive/edit/$1') . "' class='edit' title='edit'><i class='entypo-pencil'></i></a>";
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
			$this->db->select('purchases.id')
			->select('purchase_details.item_id ')
			->select('items.latin as item ')
			->select('purchase_details.id as pd_id')
			// ->select('purchase_details.quantity')
			->from('purchases')
			->where('purchases.id', $id)
			->where('purchase_details.status', 1)
			->join('purchase_details', 'purchase_details.purchase_id = purchases.id')
			->join('items', 'items.id = purchase_details.item_id');
			return $this->db->get()->result();
	}

	public function getReceive($id='')
	{
		
		$this->db->select("$this->table.id")
				->select("item_id")
				->select("quantity")
				->select("items.latin as item")
				->select("purchase_id")
				->select("amount")
				->from($this->table)
				->where("$this->table.status", 1)
				->where("purchase_id", $id)
				->join('items', 'items.id = receives.item_id');
		return $this->db->get()->result();
	}
}