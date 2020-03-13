<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_transaction_model extends MY_Model {

	protected $table = 'invoice';

	public function __construct()
	{
		parent::__construct();
	}

	public function all($user = '',$status='')
	{
		$this->load->library('datatables');
		$this->datatables->select('invoice.id')
		->select('rooms.name as room_id')
		->select('stayings.staying_name')
		->select('invoice.room_amount')
		->select('(invoice.water_usage * invoice.water_price) as water_amount')
		->select('(invoice.elect_usage * invoice.elect_price) as elect_amount')
		->select('invoice.is_paid')
		->select('invoice.invoice_date')
		->from($this->table)
		->where('invoice.is_paid', $status)
		// ->where('created_by', $user)
		// ->where('status', 1)
		->join('rooms', 'rooms.id = invoice.room_id')
		->join('stayings', 'stayings.id = invoice.staying_id');
	// 	if($status=='unpaid'){
	// 	$action='<div class="btn-group">
 //                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
 //                            Action <span class="caret"></span>
 //                        </button>
 //                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
 //                            <li>
 //                                <a href="payment_transaction/create/$1" . " class="take_payment" rel="create" title="take payment"><i class="entypo-bookmarks"></i>
 //                                        Take Payment </a>
 //                            </li>
 //                            <li class="divider"></li>
                                                                
 //                            <!-- VIEWING LINK -->
 //                            <li>
 //                                <a href="payment_transaction/view_invoice/$1" . " class="view" rel="view" title="view"><i class="entypo-credit-card"></i>
 //                                        View Invoice </a>
 //                                            </li>
 //                            <li class="divider"></li>
                            
 //                            <!-- EDITING LINK -->
 //                            <li>
 //                                <a href="payment_transaction/edit/$1" . "class="edit" rel="edit"  title="edit"><i class="entypo-pencil"></i>
 //                                    Edit </a>
 //                            </li>
 //                        </ul>';
	// 	$actions = $action;
	// }else{
	// 		$take_payment = "<a href='" . base_url("admin/payment_transaction/view_invoice/$1") . "' class='view' rel='view' title='view'><i class='entypo-credit-card'></i>
	//                                         View Invoice </a>";
	// 		$actions = $take_payment;

	// }

	// 	$this->datatables->add_column(
	// 		"actions",
	// 		"<div class='text-center'>
	// 			<div class='btn-group'>
	// 				".$actions."
	// 			</div>
	// 		</div>",
	// 		"id"
	// 	);
		$this->datatables->unset_column('id');
		return $this->datatables->generate();
	}

	public function get_rate()
	{
		$this->db->select('id')
			->select('rate')
			->where('description', 'khmer')
			->where('status', 1);
		return $this->db->get('rate')->row();
	}
	
	public function take_payment($invoice_id='')
	{
		$this->db->select('invoice.id')
		->select('invoice.room_amount')
		->select('invoice.room_id')
		->select('invoice.description')
		->select('invoice.water_usage')
		->select('invoice.water_old')
		->select('invoice.water_new')
		->select('invoice.water_price')
		->select('invoice.elect_usage')
		->select('invoice.elect_old')
		->select('invoice.elect_new')
		->select('invoice.elect_price')
		->select('invoice.invoice_date')
		->select('invoice.forward_amount')
		->select('invoice.unpaid_amount')
		->select('invoice.next_paid_date')
		->select('rooms.new_water_usage as old_water_usage')
		->select('rooms.new_elect_usage  as old_elect_usage')
		->from('invoice')
		->join('rooms', 'rooms.id = invoice.room_id')
		->where('invoice.id', $invoice_id);
		return $this->db->get()->row();
	}
	public function view_invoice($invoice_id='')
	{
		$this->db->select('s.id')
			->select('s.next_paid_date')
			->select('r.name as room_name')
			->select('s.staying_name')
			->select('g.name')
			->select('s.job')
			->select('inv.room_amount')
			->select('inv.start_billing_date')
			->select('inv.end_billing_date')
			->select('inv.water_old')
			->select('inv.water_new')
			->select('inv.water_usage')
			->select('inv.water_price')
			->select('inv.elect_old')
			->select('inv.elect_new')
			->select('inv.elect_usage')
			->select('inv.elect_price')
			->select('inv.invoice_date')
			// ->select('r.water_old_date')
			// ->select('r.elect_old_date')
			->select('(inv.water_usage * inv.water_price) as total_water_price')
			->select('(inv.elect_usage * inv.elect_price)total_elect_price ')
			->from('stayings s')
			->join('invoice inv', 'inv.room_id = s.room_id')
			->join('rooms r', 'r.id = inv.room_id')
			->join('genders g', 'g.id = s.gender_id')
			->where('inv.id', $invoice_id);
		return $this->db->get()->row();
	}
	public function edit($invoice_id='')
	{
		$this->db->select('id')
			->select('water_old')
			->select('water_new')
			->select('water_usage')
			->select('water_price')
			->select('elect_old')
			->select('elect_new')
			->select('elect_usage')
			->select('elect_price')
			->select('invoice_date')
			->select('description')
			->select('(water_usage * water_price) as water_amount')
			->select('(elect_usage * elect_price) as elect_amount')
			->from('invoice')
			->where('id', $invoice_id);
		return $this->db->get()->row();
	}
}