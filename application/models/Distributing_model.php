<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributing_model extends MY_Model {

	protected $table = 'purchase_details';

	public function __construct()
	{
		parent::__construct();
	}
	public function all($user = '',$purchase_id='')
	{
		$this->db->select('purchase_details.id')
			->select('items.latin as item')
			->select('purchase_details.item_id')
			->select('purchase_details.quantity')
			->select('distributing.id as p_id')
			->select('distributing.confirm')
			->select('distributing.department')
			->from($this->table)
			->where('purchase_details.status', 1)
			->where('purchase_details.purchase_id', $purchase_id)
			->join('items', 'items.id = purchase_details.item_id')
			->join('distributing', 'distributing.purchase_detail_id = purchase_details.id', 'left');

		// ($user != '') ? $this->db->where('purchase_details.created_by', $user) : '' ;	
		return $this->db->get()->result();
	}
}