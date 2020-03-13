<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('item_model', 'item');
	}

	public function index()
	{
		$data['scripts'] = array('item');
		$data['active'] = 'item';
		$data['title'] = 'Manage Item';
		$data['content'] = 'apps/item/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->item->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$item = array(
				'khmer' => $this->input->post('khmer'),
				'latin' => $this->input->post('latin'),
				'item_type' => $this->input->post('item_type'),
				'category_id' => $this->input->post('category_id'),
				'description' => $this->input->post('description'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->item->insert($item)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['categories']= $this->item->select('categories','latin');
		$this->load->view('apps/item/create',$data);
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$item = array(
				'khmer' => $this->input->post('khmer'),
				'latin' => $this->input->post('latin'),
				'item_type' => $this->input->post('item_type'),
				'category_id' => $this->input->post('category_id'),
				'description' => $this->input->post('description'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->item->update($id, $item)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->db->select('items.id')
			->select('items.category_id')
			->select('items.latin')
			->select('items.khmer')
			->select('items.item_type')
			->select('items.description')
			->select('items.status')
			->select('categories.latin as category')
			->from('items')
			->join('categories', 'categories.id = items.category_id')
			->where('items.id', $id);
		$data['item'] = $this->db->get()->row();
		$this->load->view('apps/item/edit', $data);
	}
}