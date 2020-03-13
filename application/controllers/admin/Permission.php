<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('form_validation');
	}
    public function index()
    {
        $data['scripts'] = array('user');
        $data['active'] = 'user';
        $data['title'] = 'Manage User';
        $data['content'] = 'apps/user/index';
        $this->page_construct('app', $data);
    }
	public function logout()
	{
		$this->aauth->logout();
		redirect('login','refresh');
	}
    public function permission()
    {
        $data['scripts'] = array('user');
        $data['active'] = 'user';
        $data['title'] = 'Manage User';
        $data['content'] = 'apps/user/index';
        $this->load->view('app', $data);
    }

    // create new
    function add(){
        $this->form_validation->set_rules('employee_no', 'employee_no', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        $this->form_validation->set_rules('group', 'group', 'trim|required');
        // validation from check up
        if ($this->form_validation->run() == true) {
            $data = [
                'emp_no'          => $this->input->post('employee_no'),
                'name'          => $this->input->post('name'),
                'phone'         => $this->input->post('phone'),
                'email'         => $this->input->post('email'),
                'username'      => $this->input->post('username'),
                'password'      => sha1(md5(sha1(md5($this->input->post('password'))))),
                'level'         => $this->input->post('group')
            ];

        }

        //
        if ($this->form_validation->run() == true && $this->user_model->addUser($data)) {
            $this->session->set_flashdata('message', 'user_added');
            redirect('user/add');

        } else {
            $page_data['error']    = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $page_data['group']  = $this->user_model->getGroup();
            $page_data['page']  = 'user';
            $page_data['selected']  = 'user';
            $page_data['page_name']  = 'user/add';
            $page_data['page_title'] = 'create_user';
            $this->load->view('index', $page_data);
        }
    }
    // edit
    function edit($id=''){
        $this->form_validation->set_rules('employee_no', 'employee_no', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('group', 'group', 'trim|required');
        // validation from check up
        if ($this->form_validation->run() == true) {
            $data = [
                'emp_no'          => $this->input->post('employee_no'),
                'name'          => $this->input->post('name'),
                'phone'         => $this->input->post('phone'),
                'email'         => $this->input->post('email'),
                'username'      => $this->input->post('username'),
                'level'         => $this->input->post('group')
            ];

        }
        //
        if ($this->form_validation->run() == true && $this->user_model->editUser($id,$data)) {
            $this->session->set_flashdata('message','user_edited');
            redirect('user/edit/'.$id);

        } else {
            $page_data['error']    = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $page_data['users']  = $this->user_model->getUserById($id);
            $page_data['group']  = $this->user_model->getGroup();
            $page_data['page']  = 'user';
            $page_data['selected']  = 'user';
            $page_data['page_name']  = 'user/edit';
            $page_data['page_title'] = 'edit_user';
            $this->load->view('index', $page_data);
        }
    }
    // get user list
    public function getUser(){
        $sth = $this->db->query("select 
                                    u.*,
                                    ug.group_name
                                from user u  
                                inner join user_group ug on ug.id = u.level and ug.`status`=1 
                                where u.admin_id not in(1)
                             ")->result();

        echo json_encode(array('data' =>  $sth));
    }

    /*------------------- group --------------*/
    // add_usergroup
    function add_group(){
        $this->form_validation->set_rules('group', get_phrase('group'), 'trim|required');
        // validation from check up
        if ($this->form_validation->run() == true) {
            $data = [
                'group_name'    => $this->input->post('group'),
                'description'    => $this->input->post('description'),
                'status'        => ($this->input->post('status')=='1'?1:0)
            ];

        }

        //
        if ($this->form_validation->run() == true && ($new_group_id = $this->user_model->addUserGroup($data))) {
            $this->session->set_flashdata('message',get_phrase('group_added'));
            admin_redirect('user/add_group_permission/' . $new_group_id);

        } else {
            $page_data['error']    = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $page_data['page']  = 'user';
            $page_data['selected']  = 'permission';
            $page_data['page_name']  = 'user/add_group';
            $page_data['page_title'] = get_phrase('add_group');
            $this->load->view('index', $page_data);
        }
    }
    // edit_usergroup
    function edit_group($id=''){
        $this->form_validation->set_rules('group', 'group', 'trim|required');
        // validation from check up
        if ($this->form_validation->run() == true) {
            $data = [
                'group_name'    => $this->input->post('group'),
                'description'    => $this->input->post('description'),
                'status'        => ($this->input->post('status')=='1'?1:0)
            ];

        }

        //
        if ($this->form_validation->run() == true && $this->user_model->editUserGroup($id,$data)) {
            $this->session->set_flashdata('message','group_edited');
            redirect('user/edit_group/'.$id);

        } else {
            $page_data['error']    = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $page_data['user_group']  = $this->user_model->getUserGroupById($id);
            $page_data['page']  = 'user';
            $page_data['selected']  = 'permission';
            $page_data['page_name']  = 'user/edit_group';
            $page_data['page_title'] = get_phrase('edit_group');
            $this->load->view('index', $page_data);
        }
    }
    // get UserGroup list
    public function getUserGroup(){
        $sth = $this->db->query("select 
                                    *
                                from user_group where `status`=1 and id not in(1)
                             ")->result();

        echo json_encode(array('data' =>  $sth));
    }

    /*--------------------- group permissioin -------- --*/
    function add_group_permission($id=''){
        $this->form_validation->set_rules('group', get_phrase('group'), 'is_natural_no_zero');
        if ($this->form_validation->run() == true) {
            $data = [
                'restaurant-index'             => $this->input->post('restaurant-index'),
                'restaurant-edit'              => $this->input->post('restaurant-edit'),
                'restaurant-add'               => $this->input->post('restaurant-add'),
                'restaurant-delete'            => $this->input->post('restaurant-delete'),

                'hotelresort-index'            => $this->input->post('hotelresort-index'),
                'hotelresort-edit'             => $this->input->post('hotelresort-edit'),
                'hotelresort-add'              => $this->input->post('hotelresort-add'),
                'hotelresort-delete'           => $this->input->post('hotelresort-delete'),

                'music-index'            => $this->input->post('music-index'),
                'music-edit'             => $this->input->post('music-edit'),
                'music-add'              => $this->input->post('music-add'),
                'music-delete'           => $this->input->post('music-delete'),

                'service-index'                => $this->input->post('service-index'),
                'service-edit'                 => $this->input->post('service-edit'),
                'service-add'                  => $this->input->post('service-add'),
                'service-delete'               => $this->input->post('service-delete'),

                'account-index'               => $this->input->post('account-index'),
                'account-edit'                => $this->input->post('account-edit'),
                'account-add'                 => $this->input->post('account-add'),
                'account-delete'              => $this->input->post('account-delete'),

                'expense-index'            => $this->input->post('expense-index'),
                'expense-edit'             => $this->input->post('expense-edit'),
                'expense-add'              => $this->input->post('expense-add'),
                'expense-delete'           => $this->input->post('expense-delete'),

                'report-index'            => $this->input->post('report-index'),
                'report-edit'             => $this->input->post('report-edit'),
                'report-add'              => $this->input->post('report-add'),
                'report-delete'           => $this->input->post('transfers-delete')
            ];
        }

        //
        if ($this->form_validation->run() == true && $this->user_model->editGroupPermission($id,$data)) {
            $this->session->set_flashdata('message','group_permission_edited');
            redirect('user/add_group_permission/'.$id);

        } else {
            $page_data['error']    = validation_errors() ? validation_errors() : $this->session->flashdata('error');

            $page_data['id']    = $id;
            $page_data['p']     = $this->user_model->getGroupPermissions($id);
            $page_data['group'] = $this->user_model->getUserGroupById($id);

            $page_data['page']  = 'user';
            $page_data['selected']  = 'permission';
            $page_data['page_name']  = 'user/add_group_permission';
            $page_data['page_title'] = get_phrase('group_permission');
            $this->load->view('index', $page_data);
        }
    }
}