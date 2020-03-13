<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Price_model', 'price');
	}

	public function index()
	{
		$data['scripts'] = array('price');
		$data['active'] = 'price';
		$data['title'] = 'Price List';
		$data['content'] = 'apps/price/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->price->all($this->user);
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$price = array(
				'price' => $this->input->post('price'),
				'description' => $this->input->post('description'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->price->insert($price)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/price/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$price = array(
				'price' => $this->input->post('price'),
				'description' => $this->input->post('description'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->price->update($id, $price)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['price'] = $this->price->get_by_id($id);
		$this->load->view('apps/price/edit', $data);
	}

	public function delete($id)
	{
		$price = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->price->update($id, $price)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}
	public function select2()
	{
		echo json_encode(['items' => $this->price->select2($this->input->post('search'),'price')]);
	}
}