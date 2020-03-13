<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Site extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function in_group($check_group, $id = false)
    {
        if (!$this->aauth->is_loggedin()) {
            return false;
        }
        $id || $id = $this->session->userdata('id');
        $group     = $this->getUserGroup($id);

        if ($group->name === $check_group) {
            return true;
        }
        return false;
    }

    public function checkPermissions()
    {
        $q = $this->db->get_where('permissions', ['group_id' => $this->session->userdata('group_id')], 1);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }
    public function get_setting()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getUserGroup($user_id = false)
    {
        if (!$user_id) {
            $user_id = $this->session->userdata('id');
        }

        $group_id = $this->getUserGroupID($user_id);
        $q = $this->db->get_where('aauth_groups', ['id' => $group_id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getUserGroupID($user_id = false)
    {
        $user = $this->getUser($user_id);
        return $user->group_id;
    }
    public function getUser($id = null)
    {
        if (!$id) {
            $id = $this->session->userdata('id');
        }
        $q = $this->db->get_where('aauth_users', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
}
