<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Category_model', 'category');
	}

	public function index()
	{
		$data['scripts'] = array('category');
		$data['active'] = 'category';
		$data['title'] = 'Categories';
		$data['content'] = 'apps/category/index';
        $this->page_construct('app', $data);
	}
	public function all()
	{
		echo $this->category->all();
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$category = array(
				'pref' => $this->input->post('pref'),
				'khmer' => $this->input->post('khmer'),
				'latin' => $this->input->post('latin'),
				'parent' => $this->input->post('parent'),
				'parent' => $this->input->post('parent'),
				'description' => $this->input->post('description'),
				'created_at' => $this->timestamp,
				'created_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->category->insert($category)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/category/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$category = array(
				'pref' => $this->input->post('pref'),
				'khmer' => $this->input->post('khmer'),
				'parent' => $this->input->post('parent'),
				'latin' => $this->input->post('latin'),
				'description' => $this->input->post('description'),
				'updated_at' => $this->timestamp,
				'updated_by' => $this->user,
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->category->update($id, $category)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->db->select('c.id')
				->select('cs.id as category_id')
				->select('cs.latin as category')
				->select('c.latin')
				->select('c.khmer')
				->select('c.pref')
				->select('c.description')
				->select('c.status')
				->from('categories c')
				->where('c.id', $id)
				->join('categories cs', 'cs.id = c.parent','left');
		$data['category'] = $this->db->get()->row();

		$this->load->view('apps/category/edit', $data);
	}
	public function select2()
	{
		echo json_encode(['items' => $this->category->select2($this->input->post('search'),'latin')]);
	}
}