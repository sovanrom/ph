<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_transaction extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Payment_transaction_model', 'payment_transaction');
	}

	public function index()
	{ 
		$data['scripts'] = array('payment_transaction');
		$data['active'] = 'payment_transaction';
		$data['title'] = 'Payment Transaction';
		$data['content'] = 'apps/payment_transaction/index';
        $this->page_construct('app', $data);
	}
	public function all()
	{
		echo $this->payment_transaction->all($this->user,$this->input->post('tab'));
	}

	public function create($invoice_id='')
	{

		if (!empty($this->input->post())) {
			$take_payment= array(
				'invoice_id'	=>   $this->input->post('invoice_id'),
	            'room_id'   	=>   $this->input->post('room_id'),
	            'description'  	=>   $this->input->post('description'),
	            'payment_type' 	=>   'income',
	            'method'      	=>   $this->input->post('payment_method'),
	            'room_amount'	=>   $this->input->post('room_amount'),
	            'water_amount'	=>   $this->input->post('water_amount'),
	            'elect_amount'	=>   $this->input->post('elect_amount'),
	            'paid_amount'	=>   $this->input->post('paid_amount'),
	            'paid_date'    	=>   date('Y-m-d H:i:s',strtotime($this->input->post('date')))
			);
			$this->db->insert('payment', $take_payment);
				
			$invoice = array(
				'paid_date' =>   date('Y-m-d H:i:s',strtotime($this->input->post('date'))),
				//water
				'water_old' => $this->input->post('water_old'),
				'water_new' => $this->input->post('water_new'),
				'water_usage' => $this->input->post('water_usage'),
				// elect
				'elect_old' => $this->input->post('elect_old'),
				'elect_new' => $this->input->post('elect_new'),
				'elect_usage' => $this->input->post('elect_usage'),
				'unpaid_amount' =>$this->input->post('unpaid_amount')
			);

			$staying = array(
				'is_paid' => 1,
				'paid_date' => date('Y-m-d',strtotime($this->input->post('date'))), 
				'next_paid_date' => date('Y-m-d',strtotime("+1 month",strtotime($this->input->post('next_paid_date')))),
				'unpaid_amount'=>  ($this->input->post('unpaid_amount') - $this->input->post('paid_amount')) 
			);


			if ($this->input->post('water_new') !== '0') {
				$invoice['unpaid_amount'] = (($this->input->post('room_amount')*$this->input->post('rate')) + $this->input->post('water_amount') + $this->input->post('elect_amount') + $this->input->post('forward_amount'));
				$staying['unpaid_amount'] = ((($this->input->post('room_amount')*$this->input->post('rate')) + $this->input->post('water_amount') + $this->input->post('elect_amount') + $this->input->post('forward_amount')) - $this->input->post('paid_amount'));
			}
				// update invoice
			$this->db->where('id', $this->input->post('invoice_id'));
			$this->db->update('invoice', $invoice);
				// update staying
			$this->db->where('room_id', $this->input->post('room_id'));
			$this->db->update('stayings', $staying);

			$data['is_paid']=$this->input->post('is_paid');	
			$this->db->where('id', $this->input->post('invoice_id'));
			$message = ($this->db->update('invoice',$data)) ? array('status' => 2,'id' => $this->input->post('invoice_id')) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['rate']=$this->payment_transaction->get_rate();
		$data['invoice']=$this->payment_transaction->take_payment($invoice_id);
		$this->load->view('apps/payment_transaction/create',$data);
	}
	public function view_invoice($invoice_id='')
	{	
		$data['result']=$this->payment_transaction->view_invoice($invoice_id);
		$this->load->view('apps/payment_transaction/invoice_form',$data);
	}
	public function edit($invoice_id='')
	{
		if (!empty($this->input->post())) {
			$invoice = array(
				'water_new' => $this->input->post('water_new'), 
				'water_usage' => $this->input->post('water_usage'),  
				'elect_new' => $this->input->post('elect_new'), 
				'elect_usage' => $this->input->post('elect_usage'), 
				'description' => $this->input->post('description'), 
				'invoice_date' => date('Y-m-d',strtotime($this->input->post('date'))) 
			);
			$this->db->where('id', $this->input->post('invoice_id'));
			$message = ($this->db->update('invoice',$invoice)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['settings'] =$this->Settings;
		$data['payment_transaction']=$this->payment_transaction->edit($invoice_id);
		$this->load->view('apps/payment_transaction/edit',$data);
	}
}