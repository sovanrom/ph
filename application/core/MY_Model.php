<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->get($this->table)->result();
    }
	
    public function get_by_id($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_where($where) {
        return $this->db->where($where)->get($this->table)->result();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    public function select($table, $column = 'name', $order_by = 'id', $type = 'asc'){
        $this->db->select('id')
            ->select($column)
            ->from($table)
            ->where('status',1)
            ->order_by($order_by, $type);
        return $this->db->get()->result();
    }

    public function select2($search = '', $column = 'name'){
        $this->db->select('id')
            ->select($column . ' as text')
            ->from($this->table)
            ->like($column, $search, 'both')
            ->where('status', 1)
            ->limit(15);
        return $this->db->get()->result();
    }

    public function is_exist($column, $conditin)
    {
        $this->db->where($column, $conditin);
        return (($this->db->get($this->table)->num_rows() > 0) ? true : false) ;
    }
}
