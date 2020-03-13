<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_payment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Create_payment_model', 'create_payment');
	}

	public function index()
	{ 
		$data['scripts'] = array('create_payment');
		$data['active'] = 'create_payment';
		$data['title'] = 'Create Payment';
		$data['content'] = 'apps/create_payment/index';
		$data['settings'] =$this->Settings;
		$data['rate']=$this->create_payment->get_rate();
        $this->page_construct('app', $data);
	}
	public function get_data()
	{
		echo json_encode( $this->create_payment->create_invoices());
	}
	public function get_room()
	{
		echo json_encode( $this->create_payment->get_room($this->input->post('building_id')));
	}
	public function room_detail()
	{
		echo json_encode( $this->create_payment->room_detail($this->input->post('room_id')));
	}
	public function all()
	{
		echo $this->create_payment->all($this->user);
	}
	public function create_invoices()
	{
		if (!empty($this->input->post())) {
			$cnt=count($this->input->post('data[][room_id]'));
			for ($i=0; $i <$cnt ; $i++) {
			$total=(($this->input->post('data['.$i.'][room_amount]')*$this->create_payment->get_rate()->rate)+(($this->input->post('data['.$i.'][water_usage]')*$this->Settings->water_price)+($this->input->post('data['.$i.'][elect_usage]')*$this->Settings->elect_price)));
			$invoice = array(
				'building_id' => $this->input->post('data['.$i.'][building_id]'),
				'room_id' => $this->input->post('data['.$i.'][room_id]'),
				'staying_id'=>$this->input->post('data['.$i.'][staying_id]'),
				'is_paid' => 'Unpaid',
				'payment_method' => 1,
				'total_amount'=>$total,
				'room_amount' => $this->input->post('data['.$i.'][room_amount]'),
				'forward_amount'=>$this->input->post('data['.$i.'][unpaid_amount]'),
				'unpaid_amount'=>($this->input->post('data['.$i.'][unpaid_amount]')+$total),
				'rate_amount'=>$this->create_payment->get_rate()->rate,
				// water
				'water_old' => $this->input->post('data['.$i.'][water_old]'),
				'water_new' => $this->input->post('data['.$i.'][water_new]'),
				'water_usage' => $this->input->post('data['.$i.'][water_usage]'),
				'water_price' => $this->Settings->water_price,
				// elect
				'elect_old' => $this->input->post('data['.$i.'][elect_old]'),
				'elect_new' => $this->input->post('data['.$i.'][elect_new]'),
				'elect_usage' => $this->input->post('data['.$i.'][elect_usage]'),
				'elect_price' => $this->Settings->elect_price,

				'next_paid_date' => $this->input->post('data['.$i.'][next_paid_date]'),
	            'start_billing_date' =>date('Y-m-01', strtotime( $this->input->post('data['.$i.'][next_paid_date]'))),
	            // 'end_billing_date'  => date('Y-m-d',strtotime("+1 month",strtotime($this->input->post('data['.$i.'][next_paid_date]')))),
	            'end_billing_date'  => date('Y-m-t', strtotime( $this->input->post('data['.$i.'][next_paid_date]'))),
				'invoice_date' => date('Y-m-d H:i:s',strtotime($this->timestamp)),
				'created_at' => $this->timestamp,
				'created_by' => $this->user
			);
			
				$staying_usage = array(
							'usage_id' => 0,
							'is_paid' => 0
								);
				$this->db->where('id', $this->input->post('data['.$i.'][staying_id]'));
				$this->db->update('stayings', $staying_usage);
			
			if ($this->create_payment->is_paid($this->input->post('data['.$i.'][room_id]'))!==NULL) {

				$invoice['forward_amount']=$this->create_payment->is_paid($this->input->post('data['.$i.'][room_id]'))->unpaid_amount;
				$invoice['unpaid_amount']=$invoice['forward_amount'] + $total;
				$staying = array('unpaid_amount' => $invoice['forward_amount']);
				$this->db->where('room_id', $this->input->post('room_id'));
				$this->db->update('stayings', $staying);

				$this->db->where('id',$this->create_payment->is_paid($this->input->post('data['.$i.'][room_id]'))->id);
				$this->db->update('invoice',$invoice);
			}
			else{
				$this->db->insert('invoice', $invoice);
				}
			}
			$message = array('status' => 1);
			echo json_encode($message);
			return '';
		}
	}
	public function create()
	{
		if (!empty($this->input->post())) {
			$total=(($this->input->post('amount')*$this->create_payment->get_rate()->rate)+($this->input->post('amount_water')+$this->input->post('amount_elect')));
			$invoice = array(
				'building_id' => $this->input->post('building_id'),
				'room_id' => $this->input->post('room_id'),
				'staying_id'=>$this->input->post('staying_id'),
				'description' => $this->input->post('description'),
				'is_paid' => $this->input->post('is_paid'),
				'payment_method' => $this->input->post('payment_method'),
				'total_amount'=>$total,
				'room_amount' => $this->input->post('amount'),
				'forward_amount'=>$this->input->post('forward_amount'),
				'unpaid_amount'=>($this->input->post('forward_amount')+$total),
				'rate_amount'=>$this->input->post('rate'),
				// water
				'water_old' => $this->input->post('water_old'),
				'water_new' => $this->input->post('water_new'),
				'water_usage' => $this->input->post('water_usage'),
				'water_price' => $this->Settings->water_price,
				// elect
				'elect_old' => $this->input->post('elect_old'),
				'elect_new' => $this->input->post('elect_new'),
				'elect_usage' => $this->input->post('elect_usage'),
				'elect_price' => $this->Settings->elect_price,

				'next_paid_date' => $this->input->post('next_paid_date'),
	            'start_billing_date' => date('Y-m-d H:i:s', strtotime( $this->input->post('start_billing_date'))),
	            'end_billing_date'  =>  date('Y-m-d H:i:s', strtotime( $this->input->post('end_billing_date'))),
				'invoice_date' => date('Y-m-d H:i:s',strtotime($this->timestamp)),
				'created_at' => $this->timestamp,
				'created_by' => $this->user
			);

			// update stayings usage_id to 0
			$staying_usage = array(
					'usage_id' => 0,
					'is_paid' => 0
				);
			$this->db->where('id', $this->input->post('staying_id'));
			$this->db->update('stayings', $staying_usage);

			// add usage if there is no usage
			if ($this->input->post('usage_id')=='') {
				$usage = array(
					'room_id' => $this->input->post('room_id'),
					'old_water_usage' => $this->input->post('water_old'),
					'old_elect_usage' => $this->input->post('elect_old'),
					'elect_usage' => $this->input->post('elect_usage'),
					'water_usage' => $this->input->post('water_usage'),
					'new_water_usage' => $this->input->post('water_new'),
					'new_elect_usage' => $this->input->post('elect_new'),
					'date' => date('Y-m-d H:i:s',strtotime( $this->timestamp)),
					'created_at' => $this->timestamp,
					'created_by' => $this->user,
					'status' => ($this->input->post('status') == 'on') ? 1 : 0
				);
				$room= array(
					'new_water_usage' => $this->input->post('water_new'),
					'new_elect_usage' => $this->input->post('elect_new'),
					'updated_at' => $this->timestamp,
					'updated_by' => $this->user
				);
				$status = array('status' => 0 );
				$this->db->where('room_id', $this->input->post('room_id'));
				$this->db->update('usages', $status);

				$this->db->where('id', $this->input->post('room_id'));
				$this->db->update('rooms', $room);
				$this->db->insert('usages', $usage);
				// $usage_id=$this->db->insert_id();
				// $staying = array('usage_id' =>$usage_id );
				// $this->db->where('room_id', $this->input->post('room_id'));
				// $this->db->update('stayings', $staying);
			}
			
			// add payment if user paid when create invoice
			if ($this->input->post('is_paid')=='Paid') {
				$this->db->insert('invoice',$invoice);
				$invoice_id=$this->db->insert_id();
				$take_payment= array(
					'invoice_id'	=>   $invoice_id,
		            'room_id'   	=>   $this->input->post('room_id'),
		            'description'  	=>   $this->input->post('description'),
		            'payment_type' 	=>   'income',
		            'method'      	=>   $this->input->post('payment_method'),
		            'room_amount'	=>   $this->input->post('amount'),
		            'water_amount'	=>   $this->input->post('water_usage')*$this->Settings->water_price,
		            'elect_amount'	=>   $this->input->post('elect_usage')*$this->Settings->elect_price,
		            'paid_amount'	=>   $this->input->post('paid_amount'),
		            'paid_date'    	=>   date('Y-m-d H:i:s',strtotime($this->input->post('paid_date')))
		        );
				$this->db->insert('payment', $take_payment);
				$invoice = array('paid_date' =>   date('Y-m-d H:i:s',strtotime($this->input->post('paid_date'))));
				$this->db->where('id', $invoice_id);
				$this->db->update('invoice', $invoice);
				$staying = array(
					'paid_date' => date('Y-m-d',strtotime($this->input->post('date'))), 
					'next_paid_date' => date('Y-m-d',strtotime("+1 month",strtotime($this->input->post('next_paid_date')))),
					'unpaid_amount'=> (($this->input->post('forward_amount')+$total) - $this->input->post('paid_amount'))
				);
				$this->db->where('room_id', $this->input->post('room_id'));
				$message = ($this->db->update('stayings', $staying)) ? array('status' => 1) : array('status' => 0);
				echo json_encode($message);
				return '';
			}

			// update invoice if invoice "Unpaid"
			if ($this->create_payment->is_paid($this->input->post('room_id'))!==NULL) {

				if ($this->create_payment->is_paid($this->input->post('room_id'))->water_new !== '0') {
					$invoice['forward_amount']=$this->create_payment->is_paid($this->input->post('room_id'))->unpaid_amount;
					$invoice['unpaid_amount']=$invoice['forward_amount']+$total;

					$staying = array('unpaid_amount' => $invoice['forward_amount']);
					$this->db->where('room_id', $this->input->post('room_id'));
					$this->db->update('stayings', $staying);
				}
				$this->db->where('id',$this->create_payment->is_paid($this->input->post('room_id'))->id);
				$message = ($this->db->update('invoice',$invoice)) ? array('status' => 1) : array('status' => 0);
				echo json_encode($message);
				return '';
			}
		
			$message = ($this->db->insert('invoice',$invoice)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
	}
}