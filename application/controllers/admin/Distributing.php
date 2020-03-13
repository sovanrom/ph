<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributing extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Distributing_model', 'distributing');
	}

	public function index()
	{
		$this->db->select('id')
				 ->from('purchases');
		$data['purchases'] = $this->db->get()->result();
		$data['scripts'] = array('distributing');
		$data['active'] = 'distributing';
		$data['title'] = 'Distributing';
		$data['content'] = 'apps/distributing/index';
		$data['departments'] = $this->distributing->select('departments');
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo json_encode($this->distributing->all($this->user,$this->input->post('purchase_id')));
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$distributings= array();
			$cnt=count($this->input->post('data'));
			for ($i=0; $i < $cnt; $i++){
			 	$distributing = array(
					'item_id' => $this->input->post('data')[$i]['item_id'],
					'purchase_detail_id' => $this->input->post('data')[$i]['id'],
					'quantity' => $this->input->post('data')[$i]['quantity'],
					'department' => $this->input->post('data')[$i]['department'],
					'created_at' => $this->timestamp,
					'created_by' => $this->user,
					'confirm' => $this->input->post('data')[$i]['confirm']
				);
				array_push($distributings, $distributing);
			}
			$message = ($this->db->insert_batch('distributing', $distributings)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
	}

	public function edit()
	{
		if (!empty($this->input->post())) {
			$cnt=count($this->input->post('data'));
			for ($i=0; $i < $cnt; $i++){
			 	$distributing = array(
					'id' => $this->input->post('data')[$i]['p_id'],
					'item_id' => $this->input->post('data')[$i]['item_id'],
					'purchase_detail_id' => $this->input->post('data')[$i]['id'],
					'quantity' => $this->input->post('data')[$i]['quantity'],
					'department' => $this->input->post('data')[$i]['department'],
					'updated_at' => $this->timestamp,
					'updated_by' => $this->user,
					'confirm' => $this->input->post('data')[$i]['confirm']
				);
				$this->db->where('id', $distributing['id']);
				$this->db->update('distributing', $distributing);
			 }  			
			$message = array('status' => 1);
			echo json_encode($message);
			return '';
		}
	}

	public function delete($id)
	{
		$distributing = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->distributing->update($id, $distributing)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}
}