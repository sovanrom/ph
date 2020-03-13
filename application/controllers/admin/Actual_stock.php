<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actual_stock extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Actual_stock_model', 'actual_stock');
	}

	public function index()
	{
		$data['scripts'] = array('actual_stock');
		$data['active'] = 'actual_stock';
		$data['title'] = 'Actual_stock List';
		$data['content'] = 'apps/actual_stock/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->actual_stock->all($this->user);
	}

	// public function create()
	// {
	// 	if (!empty($this->input->post())) {
	// 		$actual_stock = array(
	// 			'item_id' => $this->input->post('item_id'),
	// 			'qty' => $this->input->post('qty'),
	// 			'created_at' => $this->timestamp,
	// 			'created_by' => $this->user,
	// 			'status' => ($this->input->post('status') == 'on') ? 1 : 0
	// 		);
	// 		$message = ($this->actual_stock->insert($actual_stock)) ? array('status' => 1) : array('status' => 0);
	// 		echo json_encode($message);
	// 		return '';
	// 	}
	// 	$data['items']=$this->actual_stock->select('items','latin');
	// 	$this->load->view('apps/actual_stock/create',$data);
	// }

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$actual_stock = array(
				// 'item_id' => $this->input->post('item_id'),
				'qty' => $this->input->post('qty'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->actual_stock->update($id, $actual_stock)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		// $data['items']=$this->actual_stock->select('items','latin');
		$data['actual_stock'] = $this->actual_stock->get_by_id($id);
		$this->load->view('apps/actual_stock/edit', $data);
	}

	public function delete($id)
	{
		$actual_stock = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->actual_stock->update($id, $actual_stock)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

}