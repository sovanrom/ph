<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Purchase_model', 'purchase');
	}

	public function index()
	{
		$data['scripts'] = array('purchase');
		$data['active'] = 'purchase';
		$data['title'] = 'Purchase Request';
		$data['content'] = 'apps/purchase/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->purchase->all($this->user);
	}

	public function is_item($item_id='')
	{
		$this->db->select('id');
		$this->db->select('item_type');
		$this->db->select('description');
		$this->db->from('items');
		$this->db->where('id', $item_id);
		echo json_encode($this->db->get()->row());
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$file = '';
			$extention = '';
			$file_name = isset($_FILES["file"]["name"]) ? $_FILES["file"]["name"] : '' ;
			if ($file_name != '') {
				$extention = explode('.', $file_name);
				$extention = end($extention);
				$file = time();
				move_uploaded_file($_FILES['file']['tmp_name'], './uploads/purchases/'. $file . '.' . $extention);	
			}
			$purchase = [
				'post_date' 		=> date('Y-m-d H:i:s',strtotime( $this->input->post('post_date'))),
				'valid_until' 		=> date('Y-m-d H:i:s',strtotime( $this->input->post('valid_until'))),
				'document_date' 	=> date('Y-m-d H:i:s',strtotime( $this->input->post('doc_date'))),
				'required_date' 	=> date('Y-m-d H:i:s',strtotime( $this->input->post('required_date'))),
				'file'         		=> (($file !="") ? $file. '.'.$extention : ""),
				'user_id' 			=> $this->input->post('user_id'),
				'non_budget' 		=> ($this->input->post('non_budget') == 'on')? 1 : 0,
				'comment' 			=> $this->input->post('comment'),
				'vat' 			=> $this->input->post('vat'),
				'subtotal' 			=> $this->input->post('subtotal'),
				'grand' 			=> $this->input->post('grand'),
				'status' 			=> $this->input->post('status'),
				'created_at' 		=> $this->timestamp,
				'created_by' 		=> $this->user
			];
			$message = [];

			$this->db->trans_begin();

			$this->db->insert('purchases', $purchase);

			$purchase_id = $this->db->insert_id();

			foreach ($this->input->post('item_id[]') as $key => $item_id) {

				$purchase_detail = [
					'purchase_id'	=> $purchase_id,
					'item_id' 		=> $item_id,
					'free_text' 	=> $this->input->post('free_text')[$key],
					'vendor_id'		=> null,
					'due_date'		=> date('Y-m-d',strtotime($this->input->post('due_date')[$key])),
					'quantity'		=> null,
					'price'			=> $this->input->post('price')[$key],
					'disc'			=> null,
					'tax_code'		=> $this->input->post('tax_code')[$key],
					'uom_code'		=> null,
					'total'			=> $this->input->post('total')[$key],
					'budget_code'	=> null,
					'created_at'	=> $this->timestamp,
					'created_by'	=> $this->user
				];
					
				if (!empty($this->input->post('vendor_id')[$key])) {
					$purchase_detail['vendor_id']   = $this->input->post('vendor_id')[$key];
					$purchase_detail['quantity']    = $this->input->post('qty')[$key];
					$purchase_detail['disc']        = $this->input->post('disc')[$key];
					$purchase_detail['uom_code']    = $this->input->post('uom_code')[$key];
					$purchase_detail['budget_code'] = $this->input->post('budget_code')[$key];
				}
				$this->db->insert('purchase_details', $purchase_detail);
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$message = ['status' => 0];
			} else {
				$this->db->trans_commit();
				$message = ['status' => 1];
			}

			echo json_encode($message);
			return '';
		}
		$data['vendors'] = $this->purchase->select('vendor','company_name');
		$data['prices']  = $this->purchase->select('prices','price');
		$data['uoms']    = $this->purchase->select('uoms','description');
		$data['users']   = $this->db->select(['id', 'full_name'])->get('aauth_users')->result();
		$data['items']   = $this->purchase->select('items','latin');
		$this->load->view('apps/purchase/create',$data);
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$file = '';
			$extention = '';
			$file_name = ($_FILES["file"]["name"] == null) ? $this->input->post('file_name') : $_FILES["file"]["name"];
			if ($file_name != '') {
				$extention = explode('.', $file_name);
				$extention = end($extention);
				$file = time();
				if (file_exists('uploads/purchases/'.$this->input->post('file_name')));
					move_uploaded_file($_FILES['file']['tmp_name'], './uploads/purchases/'. $file . '.' . $extention);	
				}
			$purchase = [
				'post_date' 		=> date('Y-m-d H:i:s',strtotime( $this->input->post('post_date'))),
				'valid_until' 		=> date('Y-m-d H:i:s',strtotime( $this->input->post('valid_until'))),
				'document_date' 	=> date('Y-m-d H:i:s',strtotime( $this->input->post('doc_date'))),
				'required_date' 	=> date('Y-m-d H:i:s',strtotime( $this->input->post('required_date'))),
				'file'         		=> (($file !="") ? $file. '.'.$extention : ""),
				'user_id' 			=> $this->input->post('user_id'),
				'non_budget' 		=> ($this->input->post('non_budget') == 'on')? 1 : 0,
				'comment' 			=> $this->input->post('comment'),
				'vat' 			=> $this->input->post('vat'),
				'subtotal' 			=> $this->input->post('subtotal'),
				'grand' 			=> $this->input->post('grand'),
				'status' 			=> $this->input->post('status'),
				'updated_at' 		=> $this->timestamp,
				'updated_by' 		=> $this->user
			];
			if ($_FILES["file"]["name"] == null) {
				$purchase['file'] = $this->input->post('file_name');
			}
			
			$message = [];

			$this->db->trans_begin();

			$this->purchase->update($id, $purchase);

			$this->db->update('purchase_details', ['status' => 0], ['purchase_id' => $id]);

			foreach ($this->input->post('item_id[]') as $key => $item_id) {

				$purchase_detail = [
					'id'			=> $this->input->post('id')[$key],
					'purchase_id'	=> $id,
					'item_id' 		=> $item_id,
					'free_text' 	=> $this->input->post('free_text')[$key],
					'vendor_id'		=> null,
					'due_date'		=> date('Y-m-d',strtotime($this->input->post('due_date')[$key])),
					'quantity'		=> null,
					'price'			=> $this->input->post('price')[$key],
					'disc'			=> null,
					'tax_code'		=> $this->input->post('tax_code')[$key],
					'uom_code'		=> null,
					'total'			=> $this->input->post('total')[$key],
					'budget_code'	=> null,
					'created_at'	=> $this->input->post('created_at'),
					'created_by'	=> $this->input->post('created_by'),
					'updated_at'	=> $this->timestamp,
					'updated_by'	=> $this->user
				];
				if (!empty($this->input->post('vendor_id')[$key])) {
					$purchase_detail['vendor_id']   = $this->input->post('vendor_id')[$key];
					$purchase_detail['quantity']    = $this->input->post('qty')[$key];
					$purchase_detail['disc']        = $this->input->post('disc')[$key];
					$purchase_detail['uom_code']    = $this->input->post('uom_code')[$key];
					$purchase_detail['budget_code'] = $this->input->post('budget_code')[$key];
				}

				$this->db->replace('purchase_details', $purchase_detail);

			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$message = ['status' => 0];
			} else {
				$this->db->trans_commit();
				$message = ['status' => 1];
			}

			echo json_encode($message);
			return '';
		}

		$this->db->select('*')
			->from('purchase_details')
			->where(['purchase_id' => $id, 'status' => 1]);
		
		$details = $this->db->get()->result();
		$data['vendors']  = $this->purchase->select('vendor','company_name');
		$data['prices']   = $this->purchase->select('prices','price');
		$data['uoms']     = $this->purchase->select('uoms','description');
		$data['users']    = $this->db->select(['id', 'full_name'])->get('aauth_users')->result();
		$data['purchase'] = $this->purchase->get_by_id($id);
		$data['details']  = $details;
		$data['items']    = $this->purchase->select('items','latin');
		$this->load->view('apps/purchase/edit', $data);
	}

	public function delete($id)
	{
		$purchase = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->purchase->update($id, $purchase)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

	function autocomplete()
	{
		$this->db->select(array('id', 'username'));
        $this->db->from('aauth_users');
        $this->db->like('username', $this->input->post('query'), 'both');
        $query = $this->db->get();
        echo json_encode( $query->result_array());
	}


}