<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Rate_model', 'rate');
	}

	public function index()
	{
		$data['scripts'] = array('rate');
		$data['active'] = 'rate';
		$data['title'] = 'Rate List';
		$data['content'] = 'apps/rate/index';
        $this->page_construct('app', $data);
	}

	public function all()
	{
		echo $this->rate->all($this->user);
	}

	public function create()
	{
		if (!empty($this->input->post())) {
			$rate = array(
				'description' => $this->input->post('description'),
				'rate' => $this->input->post('rate'),
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$message = ($this->rate->insert($rate)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$this->load->view('apps/rate/create');
	}

	public function edit($id)
	{
		if (!empty($this->input->post())) {
			$rate = array(
				'description' => $this->input->post('description'),
				'rate' => $this->input->post('rate'),
				'status' => ($this->input->post('status') == 'on') ? 1 : 0
			);
			$rate1 = array('status' =>0 );
			$this->db->where('description', $this->input->post('description'));
			$this->db->update('rate',$rate1);
			$message = ($this->rate->insert($rate)) ? array('status' => 1) : array('status' => 0);
			echo json_encode($message);
			return '';
		}
		$data['rate'] = $this->rate->get_by_id($id);
		$this->load->view('apps/rate/edit', $data);
	}

	public function delete($id)
	{
		$rate = array(
			'deleted_at'=>$this->timestamp,
			'deleted_by'=>$this->user,
			'status' => 0
		);
		$message = ($this->rate->update($id, $rate)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
	}

}