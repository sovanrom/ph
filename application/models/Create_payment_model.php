<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_payment_model extends MY_Model {

	protected $table = 'invoices';

	public function __construct()
	{
		parent::__construct();
	}

	function get_room($building=''){
		$this->db->select('id')
        	->select('name')
        	->from('rooms')
        	->where('status',1)
        	->where('building_id',$building);
        return $this->db->get()->result();
	}

	function room_detail($room_id='')
	{
		$this->db->select('rooms.id')
			->select('prices.price')
			->select('rooms.new_water_usage as r_old_water_usage')
			->select('rooms.new_elect_usage  as r_old_elect_usage')
			->select('usages.old_elect_usage')
			->select('usages.new_elect_usage')
			->select('usages.elect_usage')
			->select('usages.old_water_usage')
			->select('usages.new_water_usage')
			->select('usages.water_usage')
			->select('usages.id as usage_id')
			->select('stayings.id as staying_id')
			->select('stayings.next_paid_date')
			->select('DATE_ADD(stayings.next_paid_date, INTERVAL +1 MONTH) AS date')
			->select('stayings.unpaid_amount')
			->select('usages.status')
	        ->from('rooms')
	        ->where('rooms.status',1)
	        // ->where('usages.status',1)
	        ->where('rooms.id',$room_id)
	        ->join('prices', 'prices.id = rooms.price')
	        ->join('stayings', 'stayings.room_id = rooms.id')
	        ->join('usages', 'usages.id = stayings.usage_id','left');
        return $this->db->get()->row();
	}

	public function get_rate()
	{
		$this->db->select('id')
			->select('rate')
			->where('description', 'khmer')
			->where('status', 1);
		return $this->db->get('rate')->row();
	}

	public function create_invoices()
	{
		$this->db->select('stayings.id as staying_id')
			->select('prices.price')
			->select('rooms.id as room_id')
			->select('rooms.building_id')
			->select('usages.old_elect_usage')
			->select('usages.new_elect_usage')
			->select('usages.elect_usage')
			->select('usages.old_water_usage')
			->select('usages.new_water_usage')
			->select('usages.water_usage')
			->select('usages.id as usage_id')
			->select('stayings.next_paid_date')
			->select('stayings.unpaid_amount')
	        ->from('rooms')
	        ->where('stayings.status',1)
	        ->join('stayings', 'stayings.room_id = rooms.id')
	        ->join('prices', 'prices.id = rooms.price')
	        ->join('usages', 'usages.id =  stayings.usage_id','left');
        return $this->db->get()->result();
	}

	public function is_paid($room_id='')
	{
		$this->db->select('id')
			->select('unpaid_amount')
			->select('water_new')
			->from('invoice')
			->where('room_id', $room_id)
			->where('is_paid', 'Unpaid');
		return $this->db->get()->row();
	}
	
}