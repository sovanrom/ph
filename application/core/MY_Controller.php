<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $user;
	protected $timestamp;
    protected $GP;
    protected $Settings;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library("Aauth");
		$this->user = $this->aauth->get_user_id();
		$this->timestamp = date('Y-m-d H:i:s');
		$this->aauth->is_loggedin() ? '' : redirect('login','refresh');
        $this->Settings = $this->site->get_setting();
        $this->data['Settings'] = $this->Settings;

        if (file_exists(APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'App.php')) {
            define('ADM', 1);
        }else{
            define('ADM', 0);
        }

        $this->loggedIn         = $this->aauth->is_loggedin();
        $this->app = '';
        if ($this->loggedIn) {
            $this->Owner                    = $this->site->in_group('Owner') ? true : null;
            $this->data['Owner']            = $this->Owner;
            $this->Admin                    = $this->site->in_group('Admin') ? true : null;
            $this->data['Admin']            = $this->Admin;

            if (!$this->Owner && !$this->Admin) {
                $gp = $this->site->checkPermissions();
                $this->GP = $gp[0];
                $this->data['GP'] = $gp[0];
            } else {
                $this->data['GP'] = null;
            }
            $this->m                    = strtolower($this->router->fetch_class());
            $this->v                    = strtolower($this->router->fetch_method());
            $this->data['m']            = $this->m;
            $this->data['v']            = $this->v;
        }

	}
    public function page_construct($page, $meta = [], $data = [])
    {
        $meta['message']             = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');
        $meta['error']               = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');
        $meta['warning']             = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');

        $meta['Owner']               = $this->data['Owner'];
        $meta['Admin']               = $this->data['Admin'];
        $meta['GP']                  = $this->data['GP'];
        $this->load->view('apps/header', $meta);
        $this->load->view('apps/menu', $meta);
        $this->load->view($page, $data);
        $this->load->view('apps/footer');
    }
}
