<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends My_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Dashboard_model','dashboard');
	}

	public function all()
	{
		echo $this->dashboard->all($this->user,$this->input->post('room_id'));
	}
	public function index()
	{
	    if (!$this->aauth->is_loggedin()) {
            redirect('/login');
        }
		$data['scripts'] = array('dashboard');
        $data['active']   = 'dashboard';
        $data['title']   = 'Dashboard';
		$data['content'] = 'apps/dashboard';
        $this->page_construct('app', $data);
	}
	public function search()
	{
		echo json_encode($this->dashboard->search($this->input->post('room_id')));
	}
	public function void($id='')
	{
		$invoice = array('status' => 0 );
		$this->db->where('id',$id);
		$message = ($this->db->update('invoice', $invoice)) ? array('status' => 1) : array('status' => 0);
		echo json_encode($message);
		return '';
	}

	function autocomplete()
	{
		$this->db->select('rooms.id, name');
		$this->db->join('stayings s', 's.room_id = rooms.id');
		$this->db->like('name', $this->input->post('query'), 'BOTH');
		$this->db->get('rooms');
		$rooms = $this->db->last_query();

		$this->db->select('room_id, CONVERT(staying_name USING utf8) AS name');
		$this->db->like('staying_name', $this->input->post('query'), 'BOTH');
		$this->db->get('stayings');
		$stayings = $this->db->last_query();

		$sql = "$rooms UNION ALL $stayings";

		//$sql = 'SELECT id, name FROM rooms WHERE name LIKE "%'. $this->input->post('query') .'%" UNION ALL SELECT id, CONVERT(staying_name USING utf8) AS name FROM stayings WHERE staying_name LIKE "%'. $this->input->post('query') .'%"';
		$query = $this->db->query($sql);
		echo json_encode($query->result());
	}

	public function get_unpaid()
	{
		$this->db->select('invoice.id')
		 		 ->select('rooms.name as title')
		 		 ->select('stayings.next_paid_date as start')
			->from('stayings')
			->join('rooms', 'rooms.id = stayings.room_id')
			->join('invoice', 'invoice.room_id = stayings.room_id')
			->where('stayings.is_paid', 0)
			->where('invoice.is_paid', 'Unpaid')
			->where('stayings.next_paid_date >=', date('Y-m-d H:i:s', strtotime($this->input->post('start'))))
			->where('stayings.next_paid_date <=', date('Y-m-d H:i:s', strtotime($this->input->post('end'))));

		echo json_encode(['stayings' => $this->db->get()->result()]);
	}

}