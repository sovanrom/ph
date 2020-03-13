<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends MY_Model {

	protected $table = 'invoice';

	public function __construct()
	{
		parent::__construct();
	}
	public function all($isEdit=0,$room_id='')
	{
		$this->load->library('datatables');
		$this->datatables->select('invoice.id')
		->select('invoice.paid_date')
		->select('(water_usage * water_price) as water_amount')
		->select('(elect_usage * elect_price) as elect_amount')
		->select('invoice.is_paid')
		->select('invoice.room_amount')
		->select('invoice.unpaid_amount as total')
		->select('invoice.forward_amount')
		->select('invoice.status')
		->from($this->table)
		->where('stayings.status', 1)
		->where('invoice.room_id', $room_id)
		->join('rooms', 'rooms.id = invoice.room_id')
		->join('stayings', 'stayings.room_id = rooms.id');

		$action='<div class="btn-group">
		                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		                            Action <span class="caret"></span>
		                        </button>
		                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
		                            <li class="take_payment">
		                                <a href="payment_transaction/create/$1" . "  rel="create" title="take payment"><i class="entypo-bookmarks"></i>
		                                        Paid</a>
		                            </li>
		                            <li class="divider"></li>
		                                                                
		                            <!-- VIEWING LINK -->
		                            <li class="view">
		                                <a href="payment_transaction/view_invoice/$1" . "  rel="view" title="view"><i class="entypo-credit-card"></i>
		                                        View Invoice </a>
		                                            </li>
		                            <li class="divider"></li>
		                            <!-- VOID LINK -->
		                            <li class="void">
		                                <a href="dashboard/void/$1" . "  rel="void" title="void"><i class="entypo-credit-card"></i>
		                                        Void </a>
		                                            </li>
		                            <li class="divider"></li>
		                            
		                            <!-- EDITING LINK -->
		                            <li class="edit">
		                                <a href="payment_transaction/edit/$1" . "  rel="edit"  title="edit"><i class="entypo-pencil"></i>
		                                    Edit </a>
		                            </li>
		                        </ul>';
		$actions = $action;
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

	 function search($room=''){
		$this->db->select('stayings.id')
			->select('stayings.room_id')
			->select('rooms.name')
			->select('stayings.staying_name')
			->select('stayings.phone')
			->select('stayings.number_person')
			->select('prices.price')
			->select('stayings.paid_date')
			->select('stayings.date_in')
			->select('stayings.next_paid_date')
			->select('usages.new_water_usage')
			->select('usages.old_water_usage')
			->select('usages.new_elect_usage')
			->select('usages.old_elect_usage')
			->select('types.name as type')
			->select('rooms.new_water_usage as water_usage')
			->select('rooms.new_elect_usage as elect_usage')

	        ->from('stayings')
	        ->where('stayings.status',1)
	        ->where('stayings.room_id',$room)
	        ->join('rooms', 'rooms.id = stayings.room_id')
	        ->join('prices', 'prices.id = rooms.price')
	        ->join('usages', 'usages.id = stayings.usage_id','left')
	        // ->join('checkups', 'checkups.room_id = rooms.id','left')
	        ->join('types', 'types.id = rooms.type_id','left');
        return $this->db->get()->row();
	}
}