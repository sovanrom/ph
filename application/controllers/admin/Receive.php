<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receive extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Receive_model', 'receive');
	}

	public function index()
	{
		$data['scripts'] = array('receive');
		$data['active'] = 'receive';
		$data['title'] = 'receive Request';
		$data['content'] = 'apps/receive/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->receive->all($this->user);
	}

	public function getData($id='')
	{
		echo json_encode($this->receive->getData($this->input->post('purchase_id')));
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$receives = array();
			foreach ($this->input->post('item_id[]') as $key => $item_id) {
				$receive = array(
					'item_id' 		=> $item_id,
					'purchase_id'   => $this->input->post('p_id')[$key],
					'quantity'		=> $this->input->post('quantity')[$key],
					'amount' 	=> $this->input->post('amount')[$key],
					'created_at'	=> $this->timestamp,
					'created_by'	=> $this->user
				);
				array_push($receives, $receive);
			}
			$message = ($this->db->insert_batch('receives', $receives)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		// $data['vendors'] = $this->receive->select('vendor','company_name');
		$this->db->select('id')
				 ->from('purchases');
		$data['purchases'] = $this->db->get()->result();
		$this->load->view('apps/receive/create',$data);
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			foreach ($this->input->post('item_id[]') as $key => $item_id) {
				$receive = array(
					'id'			=> $this->input->post('id')[$key],
					'item_id' 		=> $item_id,
					'quantity'		=> $this->input->post('quantity')[$key],
					'amount' 	=> $this->input->post('amount')[$key],
					'updated_at'	=> $this->timestamp,
					'updated_by'	=> $this->user
				);
				$this->receive->update($receive['id'],$receive);
			}
			$message = array('status' =>1);
			echo json_encode($message);
			return '';
		}	
		// $data['vendors'] = $this->receive->select('vendor','company_name');
		$this->db->select('id')
				 ->from('purchases');
		$data['purchases'] = $this->db->get()->result();
		$data['receives'] = $this->receive->getReceive($id);
		$this->load->view('apps/receive/edit', $data);
	}

	public function delete($id)
	{
		$receive = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->receive->update($id, $receive)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}
}