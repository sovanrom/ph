<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aauth {

	public $CI;
	public $config_vars;
	public $errors = array();
	public $infos = array();
	public $flash_errors = array();
	public $flash_infos = array();
	public $aauth_db;
	private $cache_perm_id;
	private $cache_group_id;

	public function __construct() {
		$this->CI = & get_instance();
		if(CI_VERSION >= 2.2){
			$this->CI->load->library('driver');
		}
		$this->CI->load->library('session');
		$this->CI->lang->load('aauth');
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->aauth_db = $this->CI->load->database($this->config_vars['db_profile'], true);
		$this->errors = $this->CI->session->flashdata('errors') ?: array();
		$this->infos = $this->CI->session->flashdata('infos') ?: array();
		$this->cache_perm_id = array();
		$this->cache_group_id = array();
		$this->precache_perms();
		$this->precache_groups();
	}
	
	private function precache_perms() {
		$query	= $this->aauth_db->get($this->config_vars['perms']);
		foreach ($query->result() as $row) {
			$key				= str_replace(' ', '', trim(strtolower($row->name)));
			$this->cache_perm_id[$key]	= $row->id;
		}
	}
	
	private function precache_groups() {
		$query	= $this->aauth_db->get($this->config_vars['groups']);

		foreach ($query->result() as $row) {
			$key				= str_replace(' ', '', trim(strtolower($row->name)));
			$this->cache_group_id[$key]	= $row->id;
		}
	}
	
	public function login($identifier, $pass, $remember = false, $totp_code = null) {
		$cookie = array(
			'name'	 => 'user',
			'value'	 => '',
			'expire' => -3600,
			'path'	 => '/',
		);
		$this->CI->input->set_cookie($cookie);
		if ($this->config_vars['ddos_protection'] && ! $this->update_login_attempts()) {

			$this->error($this->CI->lang->line('aauth_error_login_attempts_exceeded'));
			return false;
		}
		if($this->config_vars['ddos_protection'] && $this->config_vars['recaptcha_active'] && $this->get_login_attempts() > $this->config_vars['recaptcha_login_attempts']){
			$this->CI->load->helper('recaptchalib');
			$reCaptcha = new ReCaptcha( $this->config_vars['recaptcha_secret']);
			$resp = $reCaptcha->verifyResponse( $this->CI->input->server("REMOTE_ADDR"), $this->CI->input->post("g-recaptcha-response") );

			if( ! $resp->success){
				$this->error($this->CI->lang->line('aauth_error_recaptcha_not_correct'));
				return false;
			}
		}
 		if( $this->config_vars['login_with_name'] == true){

			if( !$identifier OR strlen($pass) < $this->config_vars['min'] OR strlen($pass) > $this->config_vars['max'] )
			{
				$this->error($this->CI->lang->line('aauth_error_login_failed_name'));
				return false;
			}
			$db_identifier = 'username';
 		}else{
			$this->CI->load->helper('email');
			if( !valid_email($identifier) OR strlen($pass) < $this->config_vars['min'] OR strlen($pass) > $this->config_vars['max'] )
			{
				$this->error($this->CI->lang->line('aauth_error_login_failed_email'));
				return false;
			}
			$db_identifier = 'email';
 		}

		$query = null;
		$query = $this->aauth_db->where($db_identifier, $identifier);
		$query = $this->aauth_db->where('banned', 1);
		$query = $this->aauth_db->where('verification_code !=', '');
		$query = $this->aauth_db->get($this->config_vars['users']);

		if ($query->num_rows() > 0) {
			$this->error($this->CI->lang->line('aauth_error_account_not_verified'));
			return false;
		}

		$query = $this->aauth_db->where($db_identifier, $identifier);
		$query = $this->aauth_db->get($this->config_vars['users']);

		if($query->num_rows() == 0){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return false;
		}
		if($this->config_vars['totp_active'] == true AND $this->config_vars['totp_only_on_ip_change'] == false AND $this->config_vars['totp_two_step_login_active'] == true){
			if($this->config_vars['totp_two_step_login_active'] == true){
				$this->CI->session->set_userdata('totp_required', true);
			}

			$query = null;
			$query = $this->aauth_db->where($db_identifier, $identifier);
			$query = $this->aauth_db->get($this->config_vars['users']);
			$totp_secret =  $query->row()->totp_secret;
			if ($query->num_rows() > 0 AND !$totp_code) {
				$this->error($this->CI->lang->line('aauth_error_totp_code_required'));
				return false;
			}else {
				if(!empty($totp_secret)){
					$this->CI->load->helper('googleauthenticator');
					$ga = new PHPGangsta_GoogleAuthenticator();
					$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
					if (!$checkResult) {
						$this->error($this->CI->lang->line('aauth_error_totp_code_invalid'));
						return false;
					}
				}
			}
	 	}

	 	if($this->config_vars['totp_active'] == true AND $this->config_vars['totp_only_on_ip_change'] == true){
			$query = null;
			$query = $this->aauth_db->where($db_identifier, $identifier);
			$query = $this->aauth_db->get($this->config_vars['users']);
			$totp_secret =  $query->row()->totp_secret;
			$ip_address = $query->row()->ip_address;
			$current_ip_address = $this->CI->input->ip_address();

			if ($query->num_rows() > 0 AND !$totp_code) {
				if($ip_address != $current_ip_address ){
					if($this->config_vars['totp_two_step_login_active'] == false){
						$this->error($this->CI->lang->line('aauth_error_totp_code_required'));
						return false;
					} else if($this->config_vars['totp_two_step_login_active'] == true){
						$this->CI->session->set_userdata('totp_required', true);
					}
				}
			}else {
				if(!empty($totp_secret)){
					if($ip_address != $current_ip_address ){
						$this->CI->load->helper('googleauthenticator');
						$ga = new PHPGangsta_GoogleAuthenticator();
						$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
						if (!$checkResult) {
							$this->error($this->CI->lang->line('aauth_error_totp_code_invalid'));
							return false;
						}
					}
				}
			}
	 	}

		$query = null;
		$query = $this->aauth_db->where($db_identifier, $identifier);
		$query = $this->aauth_db->where('banned', 0);
		$query = $this->aauth_db->get($this->config_vars['users']);
		$row = $query->row();
		$password = ($this->config_vars['use_password_hash'] ? $pass : $this->hash_password($pass, $row->id));

		if ( $query->num_rows() != 0 && $this->verify_password($password, $row->pass) ) {
			$data = array(
				'id' => $row->id,
				'username' => $row->username,
				'email' => $row->email,
				'loggedin' => true
			);

			$this->CI->session->set_userdata($data);

			if ( $remember ){
				$this->CI->load->helper('string');
				$expire = $this->config_vars['remember'];
				$today = date("Y-m-d");
				$remember_date = date("Y-m-d", strtotime($today . $expire) );
				$random_string = random_string('alnum', 16);
				$this->update_remember($row->id, $random_string, $remember_date );
				$cookie = array(
					'name'	 => 'user',
					'value'	 => $row->id . "-" . $random_string,
					'expire' => 99*999*999,
					'path'	 => '/',
				);
				$this->CI->input->set_cookie($cookie);
			}
			$this->update_last_login($row->id);
			$this->update_activity();

			if($this->config_vars['remove_successful_attempts'] == true){
				$this->reset_login_attempts();
			}
			return true;
		}
		else {

			$this->error($this->CI->lang->line('aauth_error_login_failed_all'));
			return false;
		}
	}

	public function is_loggedin() {

		if ( $this->CI->session->userdata('loggedin') ){
			return true;
		} else {
			if( ! $this->CI->input->cookie('user', true) ){
				return false;
			} else {
				$cookie = explode('-', $this->CI->input->cookie('user', true));
				if(!is_numeric( $cookie[0] ) OR strlen($cookie[1]) < 13 ){return false;}
				else{
					$query = $this->aauth_db->where('id', $cookie[0]);
					$query = $this->aauth_db->where('remember_exp', $cookie[1]);
					$query = $this->aauth_db->get($this->config_vars['users']);

					$row = $query->row();

					if ($query->num_rows() < 1) {
						$this->update_remember($cookie[0]);
						return false;
					}else{

						if(strtotime($row->remember_time) > strtotime("now") ){
							$this->login_fast($cookie[0]);
							return true;
						}
						// if time is expired
						else {
							return false;
						}
					}
				}
			}
		}
		return false;
	}

	public function control( $perm_par = false ){

		$this->CI->load->helper('url');

		if($this->CI->session->userdata('totp_required')){
			$this->error($this->CI->lang->line('aauth_error_totp_verification_required'));
			redirect($this->config_vars['totp_two_step_login_redirect']);
		}

		$perm_id = $this->get_perm_id($perm_par);
		$this->update_activity();
		if($perm_par == false){
			if($this->is_loggedin()){
				return true;
			}else if(!$this->is_loggedin()){
				$this->error($this->CI->lang->line('aauth_error_no_access'));
				if($this->config_vars['no_permission'] !== false){
					redirect($this->config_vars['no_permission']);
				}
			}

		}else if ( ! $this->is_allowed($perm_id) ){
			if( $this->config_vars['no_permission'] ) {
				$this->error($this->CI->lang->line('aauth_error_no_access'));
				if($this->config_vars['no_permission'] !== false){
					redirect($this->config_vars['no_permission']);
				}
			}
			else {
				echo $this->CI->lang->line('aauth_error_no_access');
				die();
			}
		}
	}

	public function logout() {

		$cookie = array(
			'name'	 => 'user',
			'value'	 => '',
			'expire' => -3600,
			'path'	 => '/',
		);
		$this->CI->input->set_cookie($cookie);

		return $this->CI->session->sess_destroy();
	}

	public function login_fast($user_id){

		$query = $this->aauth_db->where('id', $user_id);
		$query = $this->aauth_db->where('banned', 0);
		$query = $this->aauth_db->get($this->config_vars['users']);

		$row = $query->row();

		if ($query->num_rows() > 0) {
			$data = array(
				'id' => $row->id,
				'username' => $row->username,
				'email' => $row->email,
				'loggedin' => true
			);

			$this->CI->session->set_userdata($data);
			return true;
		}
		return false;
	}

	public function reset_login_attempts() {
		$ip_address = $this->CI->input->ip_address();
		$this->aauth_db->where(
			array(
				'ip_address'=>$ip_address,
				'timestamp >='=>date("Y-m-d H:i:s", strtotime("-".$this->config_vars['max_login_attempt_time_period']))
			)
		);
		return $this->aauth_db->delete($this->config_vars['login_attempts']);
	}

	public function remind_password($email){

		$query = $this->aauth_db->where( 'email', $email );
		$query = $this->aauth_db->get( $this->config_vars['users'] );

		if ($query->num_rows() > 0){
			$row = $query->row();

			$ver_code = sha1(strtotime("now"));

			$data['verification_code'] = $ver_code;

			$this->aauth_db->where('email', $email);
			$this->aauth_db->update($this->config_vars['users'], $data);

			$this->CI->load->library('email');
			$this->CI->load->helper('url');

			if(isset($this->config_vars['email_config']) && is_array($this->config_vars['email_config'])){
				$this->CI->email->initialize($this->config_vars['email_config']);
			}

			$this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
			$this->CI->email->to($row->email);
			$this->CI->email->subject($this->CI->lang->line('aauth_email_reset_subject'));
			$this->CI->email->message($this->CI->lang->line('aauth_email_reset_text') . site_url() . $this->config_vars['reset_password_link'] . $ver_code );
			$this->CI->email->send();

			return true;
		}
		return false;
	}

	public function reset_password($ver_code){

		$query = $this->aauth_db->where('verification_code', $ver_code);
		$query = $this->aauth_db->get( $this->config_vars['users'] );

		$this->CI->load->helper('string');
		$pass_length = ($this->config_vars['min']&1 ? $this->config_vars['min']+1 : $this->config_vars['min']);
		$pass = random_string('alnum', $pass_length);

		if( $query->num_rows() > 0 ){

			$row = $query->row();
			$data =	 array(
				'verification_code' => '',
				'pass' => $this->hash_password($pass, $row->id)
			);

		 	if($this->config_vars['totp_active'] == true AND $this->config_vars['totp_reset_over_reset_password'] == true){
		 		$data['totp_secret'] = null;
		 	}

			$email = $row->email;

			$this->aauth_db->where('id', $row->id);
			$this->aauth_db->update($this->config_vars['users'] , $data);

			$this->CI->load->library('email');

			if(isset($this->config_vars['email_config']) && is_array($this->config_vars['email_config'])){
				$this->CI->email->initialize($this->config_vars['email_config']);
			}

			$this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
			$this->CI->email->to($email);
			$this->CI->email->subject($this->CI->lang->line('aauth_email_reset_success_subject'));
			$this->CI->email->message($this->CI->lang->line('aauth_email_reset_success_new_password') . $pass);
			$this->CI->email->send();

			return true;
		}

		$this->error($this->CI->lang->line('aauth_error_vercode_invalid'));
		return false;
	}

	public function update_last_login($user_id = false) {

		if ($user_id == false)
			$user_id = $this->CI->session->userdata('id');

		$data['last_login'] = date("Y-m-d H:i:s");
		$data['ip_address'] = $this->CI->input->ip_address();

		$this->aauth_db->where('id', $user_id);
		return $this->aauth_db->update($this->config_vars['users'], $data);
	}

	public function update_login_attempts() {
		$ip_address = $this->CI->input->ip_address();
		$query = $this->aauth_db->where(
			array(
				'ip_address'=>$ip_address,
				'timestamp >='=>date("Y-m-d H:i:s", strtotime("-".$this->config_vars['max_login_attempt_time_period']))
			)
		);
		$query = $this->aauth_db->get( $this->config_vars['login_attempts'] );

		if($query->num_rows() == 0){
			$data = array();
			$data['ip_address'] = $ip_address;
			$data['timestamp']= date("Y-m-d H:i:s");
			$data['login_attempts']= 1;
			$this->aauth_db->insert($this->config_vars['login_attempts'], $data);
			return true;
		}else{
			$row = $query->row();
			$data = array();
			$data['timestamp'] = date("Y-m-d H:i:s");
			$data['login_attempts'] = $row->login_attempts + 1;
			$this->aauth_db->where('id', $row->id);
			$this->aauth_db->update($this->config_vars['login_attempts'], $data);

			if ( $data['login_attempts'] > $this->config_vars['max_login_attempt'] ) {
				return false;
			} else {
				return true;
			}
		}

	}

	public function get_login_attempts() {
		$ip_address = $this->CI->input->ip_address();
		$query = $this->aauth_db->where(
			array(
				'ip_address'=>$ip_address,
				'timestamp >='=>date("Y-m-d H:i:s", strtotime("-".$this->config_vars['max_login_attempt_time_period']))
			)
		);
		$query = $this->aauth_db->get( $this->config_vars['login_attempts'] );

		if($query->num_rows() != 0){
			$row = $query->row();
			return $row->login_attempts;
		}

		return 0;
	}

	public function update_remember($user_id, $expression=null, $expire=null) {

		$data['remember_time'] = $expire;
		$data['remember_exp'] = $expression;

		$query = $this->aauth_db->where('id',$user_id);
		return $this->aauth_db->update($this->config_vars['users'], $data);
	}

	public function create_user($email, $pass, $username = false) {

		$valid = true;

		if($this->config_vars['login_with_name'] == true){
			if (empty($username)){
				$this->error($this->CI->lang->line('aauth_error_username_required'));
				$valid = false;
			}
		}
		if ($this->user_exist_by_username($username) && $username != false) {
			$this->error($this->CI->lang->line('aauth_error_username_exists'));
			$valid = false;
		}

		if ($this->user_exist_by_email($email)) {
			$this->error($this->CI->lang->line('aauth_error_email_exists'));
			$valid = false;
		}
		$valid_email = (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
		if (!$valid_email){
			$this->error($this->CI->lang->line('aauth_error_email_invalid'));
			$valid = false;
		}
		if ( strlen($pass) < $this->config_vars['min'] OR strlen($pass) > $this->config_vars['max'] ){
			$this->error($this->CI->lang->line('aauth_error_password_invalid'));
			$valid = false;
		}
		if ($username != false && !ctype_alnum(str_replace($this->config_vars['additional_valid_chars'], '', $username))){
			$this->error($this->CI->lang->line('aauth_error_username_invalid'));
			$valid = false;
		}
		if (!$valid) {
			return false;
		}

		$data = array(
			'email' => $email,
			'pass' => $this->hash_password($pass, 0),
			'username' => (!$username) ? '' : $username ,
			'date_created' => date("Y-m-d H:i:s"),
		);

		if ( $this->aauth_db->insert($this->config_vars['users'], $data )){

			$user_id = $this->aauth_db->insert_id();

			// set default group
			$this->add_member($user_id, $this->config_vars['default_group']);

			// if verification activated
			if($this->config_vars['verification'] && !$this->is_admin()){
				$data = null;
				$data['banned'] = 1;

				$this->aauth_db->where('id', $user_id);
				$this->aauth_db->update($this->config_vars['users'], $data);

				// sends verifition ( !! e-mail settings must be set)
				$this->send_verification($user_id);
			}

			// Update to correct salted password
			if( !$this->config_vars['use_password_hash']){
				$data = null;
				$data['pass'] = $this->hash_password($pass, $user_id);
				$this->aauth_db->where('id', $user_id);
				$this->aauth_db->update($this->config_vars['users'], $data);
			}

			return $user_id;

		} else {
			return false;
		}
	}

	public function update_user($user_id, $email = false, $pass = false, $username = false) {

		$data = array();
		$valid = true;
		$user = $this->get_user($user_id);

		if ($user->email == $email) {
			$email = false;
		}

		if ($email != false) {
			if ($this->user_exist_by_email($email)) {
				$this->error($this->CI->lang->line('aauth_error_update_email_exists'));
				$valid = false;
			}
			$valid_email = (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
			if (!$valid_email){
				$this->error($this->CI->lang->line('aauth_error_email_invalid'));
				$valid = false;
			}
			$data['email'] = $email;
		}

		if ($pass != false) {
			if ( strlen($pass) < $this->config_vars['min'] OR strlen($pass) > $this->config_vars['max'] ){
				$this->error($this->CI->lang->line('aauth_error_password_invalid'));
				$valid = false;
			}
			$data['pass'] = $this->hash_password($pass, $user_id);
		}

		if ($user->username == $username) {
			$username = false;
		}

		if ($username != false) {
			if ($this->user_exist_by_username($username)) {
				$this->error($this->CI->lang->line('aauth_error_update_username_exists'));
				$valid = false;
			}
			if ($username !='' && !ctype_alnum(str_replace($this->config_vars['additional_valid_chars'], '', $username))){
				$this->error($this->CI->lang->line('aauth_error_username_invalid'));
				$valid = false;
			}
			$data['username'] = $username;
		}

		if ( !$valid || empty($data)) {
			return false;
		}

		$this->aauth_db->where('id', $user_id);
		return $this->aauth_db->update($this->config_vars['users'], $data);
	}

	public function list_users($group_par = false, $limit = false, $offset = false, $include_banneds = false, $sort = false) {

		// if group_par is given
		if ($group_par != false) {

			$group_par = $this->get_group_id($group_par);
			$this->aauth_db->select('*')
				->from($this->config_vars['users'])
				->join($this->config_vars['user_to_group'], $this->config_vars['users'] . ".id = " . $this->config_vars['user_to_group'] . ".user_id")
				->where($this->config_vars['user_to_group'] . ".group_id", $group_par);

			// if group_par is not given, lists all users
		} else {

			$this->aauth_db->select('*')
				->from($this->config_vars['users']);
		}

		// banneds
		if (!$include_banneds) {
			$this->aauth_db->where('banned != ', 1);
		}

		// order_by
		if ($sort) {
			$this->aauth_db->order_by($sort);
		}

		// limit
		if ($limit) {

			if ($offset == false)
				$this->aauth_db->limit($limit);
			else
				$this->aauth_db->limit($limit, $offset);
		}

		$query = $this->aauth_db->get();

		return $query->result();
	}

	public function get_user($user_id = false) {

		if ($user_id == false)
			$user_id = $this->CI->session->userdata('id');

		$query = $this->aauth_db->where('id', $user_id);
		$query = $this->aauth_db->get($this->config_vars['users']);

		if ($query->num_rows() <= 0){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return false;
		}
		return $query->row();
	}

	public function verify_user($user_id, $ver_code){

		$query = $this->aauth_db->where('id', $user_id);
		$query = $this->aauth_db->where('verification_code', $ver_code);
		$query = $this->aauth_db->get( $this->config_vars['users'] );

		// if ver code is TRUE
		if( $query->num_rows() > 0 ){

			$data =	 array(
				'verification_code' => '',
				'banned' => 0
			);

			$this->aauth_db->where('id', $user_id);
			$this->aauth_db->update($this->config_vars['users'] , $data);
			return true;
		}
		return false;
	}

	public function send_verification($user_id){

		$query = $this->aauth_db->where( 'id', $user_id );
		$query = $this->aauth_db->get( $this->config_vars['users'] );

		if ($query->num_rows() > 0){
			$row = $query->row();

			$this->CI->load->helper('string');
			$ver_code = random_string('alnum', 16);

			$data['verification_code'] = $ver_code;

			$this->aauth_db->where('id', $user_id);
			$this->aauth_db->update($this->config_vars['users'], $data);

			$this->CI->load->library('email');
			$this->CI->load->helper('url');

			if(isset($this->config_vars['email_config']) && is_array($this->config_vars['email_config'])){
				$this->CI->email->initialize($this->config_vars['email_config']);
			}

			$this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
			$this->CI->email->to($row->email);
			$this->CI->email->subject($this->CI->lang->line('aauth_email_verification_subject'));
			$this->CI->email->message($this->CI->lang->line('aauth_email_verification_code') . $ver_code .
				$this->CI->lang->line('aauth_email_verification_text') . site_url() .$this->config_vars['verification_link'] . $user_id . '/' . $ver_code );
			$this->CI->email->send();
		}
	}

	public function delete_user($user_id) {

		$this->aauth_db->trans_begin();

		// delete from perm_to_user
		$this->aauth_db->where('user_id', $user_id);
		$this->aauth_db->delete($this->config_vars['perm_to_user']);

		// delete from user_to_group
		$this->aauth_db->where('user_id', $user_id);
		$this->aauth_db->delete($this->config_vars['user_to_group']);

		// delete user vars
		$this->aauth_db->where('user_id', $user_id);
		$this->aauth_db->delete($this->config_vars['user_variables']);

		// delete user
		$this->aauth_db->where('id', $user_id);
		$this->aauth_db->delete($this->config_vars['users']);

		if ($this->aauth_db->trans_status() === false) {
			$this->aauth_db->trans_rollback();
			return false;
		} else {
			$this->aauth_db->trans_commit();
			return true;
		}

	}

	public function ban_user($user_id) {

		$data = array(
			'banned' => 1,
			'verification_code' => ''
		);

		$this->aauth_db->where('id', $user_id);

		return $this->aauth_db->update($this->config_vars['users'], $data);
	}

	public function unban_user($user_id) {

		$data = array(
			'banned' => 0
		);

		$this->aauth_db->where('id', $user_id);

		return $this->aauth_db->update($this->config_vars['users'], $data);
	}

	public function is_banned($user_id) {

		if ( ! $this->user_exist_by_id($user_id)) {
			return true;
		}

		$query = $this->aauth_db->where('id', $user_id);
		$query = $this->aauth_db->where('banned', 1);

		$query = $this->aauth_db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	public function user_exist_by_username( $name ) {
		$query = $this->aauth_db->where('username', $name);

		$query = $this->aauth_db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	public function user_exist_by_name( $name ) {
		return $this->user_exist_by_username($name);
	}

	public function user_exist_by_email( $user_email ) {
		$query = $this->aauth_db->where('email', $user_email);

		$query = $this->aauth_db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	public function user_exist_by_id( $user_id ) {
		$query = $this->aauth_db->where('id', $user_id);

		$query = $this->aauth_db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	public function get_user_id($email=false) {

		if( ! $email){
			$query = $this->aauth_db->where('id', $this->CI->session->userdata('id'));
		} else {
			$query = $this->aauth_db->where('email', $email);
		}

		$query = $this->aauth_db->get($this->config_vars['users']);

		if ($query->num_rows() <= 0){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return false;
		}
		return $query->row()->id;
	}

	public function get_user_groups($user_id = false){

		if( !$user_id) { $user_id = $this->CI->session->userdata('id'); }
		if( !$user_id){
			$this->aauth_db->where('name', $this->config_vars['public_group']);
			$query = $this->aauth_db->get($this->config_vars['groups']);
		}else if($user_id){
			$this->aauth_db->join($this->config_vars['groups'], "id = group_id");
			$this->aauth_db->where('user_id', $user_id);
			$query = $this->aauth_db->get($this->config_vars['user_to_group']);
		}
		return $query->result();
	}

	public function get_user_perms ( $user_id = false ) {
		if( ! $user_id) { $user_id = $this->CI->session->userdata('id'); }

		if($user_id){
			$query = $this->aauth_db->select($this->config_vars['perms'].'.*');
			$query = $this->aauth_db->where('user_id', $user_id);
			$query = $this->aauth_db->join($this->config_vars['perms'], $this->config_vars['perms'].'.id = '.$this->config_vars['perm_to_user'].'.perm_id');
			$query = $this->aauth_db->get($this->config_vars['perm_to_user']);

			return $query->result();
		}

		return false;
	}

	public function update_activity($user_id = false) {

		if ($user_id == false)
			$user_id = $this->CI->session->userdata('id');

		if($user_id==false){return false;}

		$data['last_activity'] = date("Y-m-d H:i:s");

		$query = $this->aauth_db->where('id',$user_id);
		return $this->aauth_db->update($this->config_vars['users'], $data);
	}

	function hash_password($pass, $userid) {
		if($this->config_vars['use_password_hash']){
			return password_hash($pass, $this->config_vars['password_hash_algo'], $this->config_vars['password_hash_options']);
		}else{
			$salt = md5($userid);
			return hash($this->config_vars['hash'], $salt.$pass);
		}
	}

	function verify_password($password, $hash) {
		if($this->config_vars['use_password_hash']){
			return password_verify($password, $hash);
		}else{
			return ($password == $hash ? true : false);
		}
	}

	public function create_group($group_name, $definition = '') {

		$query = $this->aauth_db->get_where($this->config_vars['groups'], array('name' => $group_name));

		if ($query->num_rows() < 1) {

			$data = array(
				'name' => $group_name,
				'definition'=> $definition
			);
			$this->aauth_db->insert($this->config_vars['groups'], $data);
			$this->precache_groups();
			return $this->aauth_db->insert_id();
		}

		$this->info($this->CI->lang->line('aauth_info_group_exists'));
		return false;
	}

	public function update_group($group_par, $group_name=false, $definition=false) {

		$group_id = $this->get_group_id($group_par);

		if ($group_name != false) {
			$data['name'] = $group_name;
		}

		if ($definition != false) {
			$data['definition'] = $definition;
		}


		$this->aauth_db->where('id', $group_id);
		return $this->aauth_db->update($this->config_vars['groups'], $data);
	}

	public function delete_group($group_par) {

		$group_id = $this->get_group_id($group_par);

		$this->aauth_db->where('id',$group_id);
		$query = $this->aauth_db->get($this->config_vars['groups']);
		if ($query->num_rows() == 0){
			return false;
		}

		$this->aauth_db->trans_begin();

		// bug fixed
		// now users are deleted from user_to_group table
		$this->aauth_db->where('group_id', $group_id);
		$this->aauth_db->delete($this->config_vars['user_to_group']);

		$this->aauth_db->where('group_id', $group_id);
		$this->aauth_db->delete($this->config_vars['perm_to_group']);

		$this->aauth_db->where('group_id', $group_id);
		$this->aauth_db->delete($this->config_vars['group_to_group']);

		$this->aauth_db->where('subgroup_id', $group_id);
		$this->aauth_db->delete($this->config_vars['group_to_group']);

		$this->aauth_db->where('id', $group_id);
		$this->aauth_db->delete($this->config_vars['groups']);

		if ($this->aauth_db->trans_status() === false) {
			$this->aauth_db->trans_rollback();
			return false;
		} else {
			$this->aauth_db->trans_commit();
			$this->precache_groups();
			return true;
		}

	}

	public function add_member($user_id, $group_par) {

		$group_id = $this->get_group_id($group_par);

		if( ! $group_id ) {

			$this->error( $this->CI->lang->line('aauth_error_no_group') );
			return false;
		}

		$query = $this->aauth_db->where('user_id',$user_id);
		$query = $this->aauth_db->where('group_id',$group_id);
		$query = $this->aauth_db->get($this->config_vars['user_to_group']);

		if ($query->num_rows() < 1) {
			$data = array(
				'user_id' => $user_id,
				'group_id' => $group_id
			);

			return $this->aauth_db->insert($this->config_vars['user_to_group'], $data);
		}
		$this->info($this->CI->lang->line('aauth_info_already_member'));
		return true;
	}

	public function remove_member($user_id, $group_par) {

		$group_par = $this->get_group_id($group_par);
		$this->aauth_db->where('user_id', $user_id);
		$this->aauth_db->where('group_id', $group_par);
		return $this->aauth_db->delete($this->config_vars['user_to_group']);
	}

	public function add_subgroup($group_par, $subgroup_par) {

		$group_id = $this->get_group_id($group_par);
		$subgroup_id = $this->get_group_id($subgroup_par);

		if( ! $group_id ) {
			$this->error( $this->CI->lang->line('aauth_error_no_group') );
			return false;
		}

		if( ! $subgroup_id ) {
			$this->error( $this->CI->lang->line('aauth_error_no_subgroup') );
			return false;
		}

        if ($group_groups = $this->get_subgroups($group_id)) {
            foreach ($group_groups as $item) {
                if ($item->subgroup_id == $subgroup_id) {
                    return false;
                }
            }
        }

        if ($subgroup_groups = $this->get_subgroups($subgroup_id)) {
            foreach ($subgroup_groups as $item) {
                if ($item->subgroup_id == $group_id) {
                    return false;
                }
            }
        }

		$query = $this->aauth_db->where('group_id',$group_id);
		$query = $this->aauth_db->where('subgroup_id',$subgroup_id);
		$query = $this->aauth_db->get($this->config_vars['group_to_group']);

		if ($query->num_rows() < 1) {
			$data = array(
				'group_id' => $group_id,
				'subgroup_id' => $subgroup_id,
			);

			return $this->aauth_db->insert($this->config_vars['group_to_group'], $data);
		}
		$this->info($this->CI->lang->line('aauth_info_already_subgroup'));
		return true;
	}

	public function remove_subgroup($group_par, $subgroup_par) {

		$group_par = $this->get_group_id($group_par);
		$subgroup_par = $this->get_group_id($subgroup_par);
		$this->aauth_db->where('group_id', $group_par);
		$this->aauth_db->where('subgroup_id', $subgroup_par);
		return $this->aauth_db->delete($this->config_vars['group_to_group']);
	}

	public function remove_member_from_all($user_id) {

		$this->aauth_db->where('user_id', $user_id);
		return $this->aauth_db->delete($this->config_vars['user_to_group']);
	}
	
	public function is_member( $group_par, $user_id = false ) {
		// if user_id FALSE (not given), current user
		if( ! $user_id){
			$user_id = $this->CI->session->userdata('id');
		}

		$group_id = $this->get_group_id($group_par);

		$query = $this->aauth_db->where('user_id', $user_id);
		$query = $this->aauth_db->where('group_id', $group_id);
		$query = $this->aauth_db->get($this->config_vars['user_to_group']);

		$row = $query->row();

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function is_admin( $user_id = false ) {

		return $this->is_member($this->config_vars['admin_group'], $user_id);
	}

	public function list_groups() {

		$query = $this->aauth_db->get($this->config_vars['groups']);
		return $query->result();
	}

	public function get_group_name($group_id) {

		$query = $this->aauth_db->where('id', $group_id);
		$query = $this->aauth_db->get($this->config_vars['groups']);

		if ($query->num_rows() == 0)
			return false;

		$row = $query->row();
		return $row->name;
	}

	public function get_group_id ( $group_par ) {

		if( is_numeric($group_par) ) { return $group_par; }

		$key	= str_replace(' ', '', trim(strtolower($group_par)));

		if (isset($this->cache_group_id[$key])) {
			return $this->cache_group_id[$key];
		} else {
			return false;
		}

	}

	public function get_group ( $group_par ) {
		if ($group_id = $this->get_group_id($group_par)) {
			$query = $this->aauth_db->where('id', $group_id);
			$query = $this->aauth_db->get($this->config_vars['groups']);

			return $query->row();
		}

		return false;
	}

	public function get_group_perms ( $group_par ) {
		if ($group_id = $this->get_group_id($group_par)) {
			$query = $this->aauth_db->select($this->config_vars['perms'].'.*');
			$query = $this->aauth_db->where('group_id', $group_id);
			$query = $this->aauth_db->join($this->config_vars['perms'], $this->config_vars['perms'].'.id = '.$this->config_vars['perm_to_group'].'.perm_id');
			$query = $this->aauth_db->get($this->config_vars['perm_to_group']);

			return $query->result();
		}

		return false;
	}

	public function get_subgroups ( $group_par ) {

		$group_id = $this->get_group_id($group_par);

		$query = $this->aauth_db->where('group_id', $group_id);
		$query = $this->aauth_db->select('subgroup_id');
		$query = $this->aauth_db->get($this->config_vars['group_to_group']);

		if ($query->num_rows() == 0)
			return false;

		return $query->result();
	}

	public function create_perm($perm_name, $definition='') {

		$query = $this->aauth_db->get_where($this->config_vars['perms'], array('name' => $perm_name));

		if ($query->num_rows() < 1) {

			$data = array(
				'name' => $perm_name,
				'definition'=> $definition
			);
			$this->aauth_db->insert($this->config_vars['perms'], $data);
			$this->precache_perms();
			return $this->aauth_db->insert_id();
		}
		$this->info($this->CI->lang->line('aauth_info_perm_exists'));
		return false;
	}

	public function update_perm($perm_par, $perm_name=false, $definition=false) {

		$perm_id = $this->get_perm_id($perm_par);

		if ($perm_name != false)
			$data['name'] = $perm_name;

		if ($definition != false)
			$data['definition'] = $definition;

		$this->aauth_db->where('id', $perm_id);
		return $this->aauth_db->update($this->config_vars['perms'], $data);
	}

	public function delete_perm($perm_par) {

		$perm_id = $this->get_perm_id($perm_par);

		$this->aauth_db->trans_begin();

		// deletes from perm_to_gropup table
		$this->aauth_db->where('perm_id', $perm_id);
		$this->aauth_db->delete($this->config_vars['perm_to_group']);

		// deletes from perm_to_user table
		$this->aauth_db->where('perm_id', $perm_id);
		$this->aauth_db->delete($this->config_vars['perm_to_user']);

		// deletes from permission table
		$this->aauth_db->where('id', $perm_id);
		$this->aauth_db->delete($this->config_vars['perms']);

		if ($this->aauth_db->trans_status() === false) {
			$this->aauth_db->trans_rollback();
			return false;
		} else {
			$this->aauth_db->trans_commit();
			$this->precache_perms();
			return true;
		}

	}

	public function list_group_perms($group_par) {
		if(empty($group_par)){
			return false;
		}

		$group_par = $this->get_group_id($group_par);

		$this->aauth_db->select('*');
		$this->aauth_db->from($this->config_vars['perms']);
		$this->aauth_db->join($this->config_vars['perm_to_group'], "perm_id = ".$this->config_vars['perms'].".id");
		$this->aauth_db->where($this->config_vars['perm_to_group'].'.group_id', $group_par);

		$query = $this->aauth_db->get();
		if ($query->num_rows() == 0)
			return false;

		return $query->result();
	}

	public function is_allowed($perm_par, $user_id=false){

		$this->CI->load->helper('url');

		if($this->CI->session->userdata('totp_required')){
			$this->error($this->CI->lang->line('aauth_error_totp_verification_required'));
			redirect($this->config_vars['totp_two_step_login_redirect']);
		}

		if( $user_id == false){
			$user_id = $this->CI->session->userdata('id');
		}

		if($this->is_admin($user_id))
		{
			return true;
		}

		if ( ! $perm_id = $this->get_perm_id($perm_par)) {
			return false;
		}

		$query = $this->aauth_db->where('perm_id', $perm_id);
		$query = $this->aauth_db->where('user_id', $user_id);
		$query = $this->aauth_db->get( $this->config_vars['perm_to_user'] );

		if( $query->num_rows() > 0){
		    return true;
		} else {
			$g_allowed=false;
			foreach( $this->get_user_groups($user_id) as $group ){
				if ( $this->is_group_allowed($perm_id, $group->id) ){
					$g_allowed=true;
					break;
				}
			}
			return $g_allowed;
	    }
	}

	public function is_group_allowed($perm_par, $group_par=false){

		$perm_id = $this->get_perm_id($perm_par);

		// if group par is given
		if($group_par != false){

			// if group is admin group, as admin group has access to all permissions
			if (strcasecmp($group_par, $this->config_vars['admin_group']) == 0)
			{return true;}

			$subgroup_ids = $this->get_subgroups($group_par);
			$group_par = $this->get_group_id($group_par);
			$query = $this->aauth_db->where('perm_id', $perm_id);
			$query = $this->aauth_db->where('group_id', $group_par);
			$query = $this->aauth_db->get( $this->config_vars['perm_to_group'] );

			$g_allowed=false;
			if(is_array($subgroup_ids)){
				foreach ($subgroup_ids as $g ){
					if($this->is_group_allowed($perm_id, $g->subgroup_id)){
						$g_allowed=true;
					}
				}
			}

			if( $query->num_rows() > 0){
				$g_allowed=true;
			}
			return $g_allowed;
		}
		// if group par is not given
		// checks current user's all groups
		else {
			// if public is allowed or he is admin
			if ( $this->is_admin( $this->CI->session->userdata('id')) OR
				$this->is_group_allowed($perm_id, $this->config_vars['public_group']) )
			{return true;}

			// if is not login
			if (!$this->is_loggedin()){return false;}

			$group_pars = $this->get_user_groups();
			foreach ($group_pars as $g ){
				if($this->is_group_allowed($perm_id, $g->id)){
					return true;
				}
			}
			return false;
		}
	}

	public function allow_user($user_id, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);

		if( ! $perm_id) {
			return false;
		}

		$query = $this->aauth_db->where('user_id',$user_id);
		$query = $this->aauth_db->where('perm_id',$perm_id);
		$query = $this->aauth_db->get($this->config_vars['perm_to_user']);

		// if not inserted before
		if ($query->num_rows() < 1) {

			$data = array(
				'user_id' => $user_id,
				'perm_id' => $perm_id
			);

			return $this->aauth_db->insert($this->config_vars['perm_to_user'], $data);
		}
		return true;
	}

	public function deny_user($user_id, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);

		$this->aauth_db->where('user_id', $user_id);
		$this->aauth_db->where('perm_id', $perm_id);

		return $this->aauth_db->delete($this->config_vars['perm_to_user']);
	}

	public function allow_group($group_par, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);

		if( ! $perm_id) {
			return false;
		}

		$group_id = $this->get_group_id($group_par);

		if( ! $group_id) {
			return false;
		}

		$query = $this->aauth_db->where('group_id',$group_id);
		$query = $this->aauth_db->where('perm_id',$perm_id);
		$query = $this->aauth_db->get($this->config_vars['perm_to_group']);

		if ($query->num_rows() < 1) {

			$data = array(
				'group_id' => $group_id,
				'perm_id' => $perm_id
			);

			return $this->aauth_db->insert($this->config_vars['perm_to_group'], $data);
		}

		return true;
	}

	public function deny_group($group_par, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);
		$group_id = $this->get_group_id($group_par);

		$this->aauth_db->where('group_id', $group_id);
		$this->aauth_db->where('perm_id', $perm_id);

		return $this->aauth_db->delete($this->config_vars['perm_to_group']);
	}

	public function list_perms() {

		$query = $this->aauth_db->get($this->config_vars['perms']);
		return $query->result();
	}

	public function get_perm_id($perm_par) {

		if( is_numeric($perm_par) ) { return $perm_par; }

		$key	= str_replace(' ', '', trim(strtolower($perm_par)));

		if (isset($this->cache_perm_id[$key])) {
			return $this->cache_perm_id[$key];
		} else {
			return false;
		}

	}

	public function get_perm($perm_par) {
		if ($perm_id = $this->get_perm_id($perm_par)) {
			$query = $this->aauth_db->where('id', $perm_id);
			$query = $this->aauth_db->get($this->config_vars['perms']);

			return $query->row();
		}

		return false;
	}

	public function send_pm( $sender_id, $receiver_id, $title, $message ){

		if ( !is_numeric($receiver_id) OR $sender_id == $receiver_id ){
			$this->error($this->CI->lang->line('aauth_error_self_pm'));
			return false;
		}
		if (($this->is_banned($receiver_id) || !$this->user_exist_by_id($receiver_id)) || ($sender_id && ($this->is_banned($sender_id) || !$this->user_exist_by_id($sender_id)))){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return false;
		}
		if ( !$sender_id){
			$sender_id = 0;
		}

		if ($this->config_vars['pm_encryption']){
			$this->CI->load->library('encrypt');
			$title = $this->CI->encrypt->encode($title);
			$message = $this->CI->encrypt->encode($message);
		}

		$data = array(
			'sender_id' => $sender_id,
			'receiver_id' => $receiver_id,
			'title' => $title,
			'message' => $message,
			'date_sent' => date('Y-m-d H:i:s')
		);

		return $this->aauth_db->insert( $this->config_vars['pms'], $data );
	}

	public function send_pms( $sender_id, $receiver_ids, $title, $message ){
		if ($this->config_vars['pm_encryption']){
			$this->CI->load->library('encrypt');
			$title = $this->CI->encrypt->encode($title);
			$message = $this->CI->encrypt->encode($message);
		}
		if ($sender_id && ($this->is_banned($sender_id) || !$this->user_exist_by_id($sender_id))){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return false;
		}
		if ( !$sender_id){
			$sender_id = 0;
		}
		if (is_numeric($receiver_ids)) {
			$receiver_ids = array($receiver_ids);
		}

		$return_array = array();
		foreach ($receiver_ids as $receiver_id) {
			if ($sender_id == $receiver_id ){
				$return_array[$receiver_id] = $this->CI->lang->line('aauth_error_self_pm');
				continue;
			}
			if ($this->is_banned($receiver_id) || !$this->user_exist_by_id($receiver_id)){
				$return_array[$receiver_id] = $this->CI->lang->line('aauth_error_no_user');
				continue;
			}

			$data = array(
				'sender_id' => $sender_id,
				'receiver_id' => $receiver_id,
				'title' => $title,
				'message' => $message,
				'date_sent' => date('Y-m-d H:i:s')
			);
			$return_array[$receiver_id] = $this->aauth_db->insert( $this->config_vars['pms'], $data );
		}

		return $return_array;
	}

	public function list_pms($limit=5, $offset=0, $receiver_id=null, $sender_id=null){
		if (is_numeric($receiver_id)){
			$query = $this->aauth_db->where('receiver_id', $receiver_id);
			$query = $this->aauth_db->where('pm_deleted_receiver', null);
		}
		if (is_numeric($sender_id)){
			$query = $this->aauth_db->where('sender_id', $sender_id);
			$query = $this->aauth_db->where('pm_deleted_sender', null);
		}

		$query = $this->aauth_db->order_by('id','DESC');
		$query = $this->aauth_db->get( $this->config_vars['pms'], $limit, $offset);

		$result = $query->result();

		if ($this->config_vars['pm_encryption']){
			$this->CI->load->library('encrypt');

			foreach ($result as $k => $r)
			{
				$result[$k]->title = $this->CI->encrypt->decode($r->title);
				$result[$k]->message = $this->CI->encrypt->decode($r->message);
			}
		}

		return $result;
	}

	public function get_pm($pm_id, $user_id = null, $set_as_read = true){
		if(!$user_id){
			$user_id = $this->CI->session->userdata('id');
		}
		if( !is_numeric($user_id) || !is_numeric($pm_id)){
			$this->error( $this->CI->lang->line('aauth_error_no_pm') );
			return false;
		}

		$query = $this->aauth_db->where('id', $pm_id);
		$query = $this->aauth_db->group_start();
		$query = $this->aauth_db->where('receiver_id', $user_id);
		$query = $this->aauth_db->or_where('sender_id', $user_id);
		$query = $this->aauth_db->group_end();
		$query = $this->aauth_db->get( $this->config_vars['pms'] );

		if ($query->num_rows() < 1) {
			$this->error( $this->CI->lang->line('aauth_error_no_pm') );
			return false;
		}

		$result = $query->row();

		if ($user_id == $result->receiver_id && $set_as_read){
			$this->set_as_read_pm($pm_id);
		}

		if ($this->config_vars['pm_encryption']){
			$this->CI->load->library('encrypt');
			$result->title = $this->CI->encrypt->decode($result->title);
			$result->message = $this->CI->encrypt->decode($result->message);
		}

		return $result;
	}

	public function delete_pm($pm_id, $user_id = null){
		if(!$user_id){
			$user_id = $this->CI->session->userdata('id');
		}
		if( !is_numeric($user_id) || !is_numeric($pm_id)){
			$this->error( $this->CI->lang->line('aauth_error_no_pm') );
			return false;
		}

		$query = $this->aauth_db->where('id', $pm_id);
		$query = $this->aauth_db->group_start();
		$query = $this->aauth_db->where('receiver_id', $user_id);
		$query = $this->aauth_db->or_where('sender_id', $user_id);
		$query = $this->aauth_db->group_end();
		$query = $this->aauth_db->get( $this->config_vars['pms'] );
		$result = $query->row();
		if ($user_id == $result->sender_id){
			if($result->pm_deleted_receiver == 1){
				return $this->aauth_db->delete( $this->config_vars['pms'], array('id' => $pm_id));
			}

			return $this->aauth_db->update( $this->config_vars['pms'], array('pm_deleted_sender'=>1), array('id' => $pm_id));
		}else if ($user_id == $result->receiver_id){
			if($result->pm_deleted_sender == 1){
				return $this->aauth_db->delete( $this->config_vars['pms'], array('id' => $pm_id));
			}

			return $this->aauth_db->update( $this->config_vars['pms'], array('pm_deleted_receiver'=>1, 'date_read'=>date('Y-m-d H:i:s')), array('id' => $pm_id) );
		}
	}

	public function cleanup_pms(){
		$pm_cleanup_max_age = $this->config_vars['pm_cleanup_max_age'];
		$date_sent = date('Y-m-d H:i:s', strtotime("now -".$pm_cleanup_max_age));
		$this->aauth_db->where('date_sent <', $date_sent);

		return $this->aauth_db->delete($this->config_vars['pms']);
	}

	public function count_unread_pms($receiver_id=false){

		if(!$receiver_id){
			$receiver_id = $this->CI->session->userdata('id');
		}

		$query = $this->aauth_db->where('receiver_id', $receiver_id);
		$query = $this->aauth_db->where('date_read', null);
		$query = $this->aauth_db->where('pm_deleted_sender', null);
		$query = $this->aauth_db->where('pm_deleted_receiver', null);
		$query = $this->aauth_db->get( $this->config_vars['pms'] );

		return $query->num_rows();
	}

	public function set_as_read_pm($pm_id){

		$data = array(
			'date_read' => date('Y-m-d H:i:s')
		);

		$this->aauth_db->update( $this->config_vars['pms'], $data, "id = $pm_id");
	}

	public function error($message = '', $flashdata = false){
		$this->errors[] = $message;
		if($flashdata)
		{
			$this->flash_errors[] = $message;
			$this->CI->session->set_flashdata('errors', $this->flash_errors);
		}
	}

	public function keep_errors($include_non_flash = false)
	{
		if($include_non_flash)
		{
			$this->flash_errors = array_merge($this->flash_errors, $this->errors);
		}
		$this->flash_errors = array_merge($this->flash_errors, (array)$this->CI->session->flashdata('errors'));
		$this->CI->session->set_flashdata('errors', $this->flash_errors);
	}

	public function get_errors_array()
	{
		return $this->errors;
	}

	public function print_errors($divider = '<br />')
	{
		$msg = '';
		$msg_num = count($this->errors);
		$i = 1;
		foreach ($this->errors as $e)
		{
			$msg .= $e;

			if ($i != $msg_num)
			{
				$msg .= $divider;
			}
			$i++;
		}
		echo $msg;
	}

	public function clear_errors()
	{
		$this->errors = array();
		$this->CI->session->set_flashdata('errors', $this->errors);
	}

	public function info($message = '', $flashdata = false)
	{
		$this->infos[] = $message;
		if($flashdata)
		{
			$this->flash_infos[] = $message;
			$this->CI->session->set_flashdata('infos', $this->flash_infos);
		}
	}

	public function keep_infos($include_non_flash = false)
	{
		if($include_non_flash)
		{
			$this->flash_infos = array_merge($this->flash_infos, $this->infos);
		}
		$this->flash_infos = array_merge($this->flash_infos, (array)$this->CI->session->flashdata('infos'));
		$this->CI->session->set_flashdata('infos', $this->flash_infos);
	}

	public function get_infos_array()
	{
		return $this->infos;
	}

	public function print_infos($divider = '<br />')
	{

		$msg = '';
		$msg_num = count($this->infos);
		$i = 1;
		foreach ($this->infos as $e)
		{
			$msg .= $e;

			if ($i != $msg_num)
			{
				$msg .= $divider;
			}
			$i++;
		}
		echo $msg;
	}

	public function clear_infos()
	{
		$this->infos = array();
		$this->CI->session->set_flashdata('infos', $this->infos);
	}

	public function set_user_var( $key, $value, $user_id = false ) {

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return false;
		}

		// if var not set, set
		 if ($this->get_user_var($key,$user_id) ===false) {

			$data = array(
				'data_key' => $key,
				'value' => $value,
				'user_id' => $user_id
			);

			return $this->aauth_db->insert( $this->config_vars['user_variables'] , $data);
		}
		// if var already set, overwrite
		else {

			$data = array(
				'data_key' => $key,
				'value' => $value,
				'user_id' => $user_id
			);

			$this->aauth_db->where( 'data_key', $key );
			$this->aauth_db->where( 'user_id', $user_id);

			return $this->aauth_db->update( $this->config_vars['user_variables'], $data);
		}
	}

	public function unset_user_var( $key, $user_id = false ) {

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return false;
		}

		$this->aauth_db->where('data_key', $key);
		$this->aauth_db->where('user_id', $user_id);

		return $this->aauth_db->delete( $this->config_vars['user_variables'] );
	}

	public function get_user_var( $key, $user_id = false){

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return false;
		}

		$query = $this->aauth_db->where('user_id', $user_id);
		$query = $this->aauth_db->where('data_key', $key);

		$query = $this->aauth_db->get( $this->config_vars['user_variables'] );

		// if variable not set
		if ($query->num_rows() < 1) { return false;}

		else {

			$row = $query->row();
			return $row->value;
		}

	}

	public function get_user_vars( $user_id = false){

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return false;
		}

		$query = $this->aauth_db->select('data_key, value');

		$query = $this->aauth_db->where('user_id', $user_id);

		$query = $this->aauth_db->get( $this->config_vars['user_variables'] );

		return $query->result();

	}

	public function list_user_var_keys($user_id = false){

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return false;
		}
		$query = $this->aauth_db->select('data_key');

		$query = $this->aauth_db->where('user_id', $user_id);

		$query = $this->aauth_db->get( $this->config_vars['user_variables'] );

		// if variable not set
		if ($query->num_rows() < 1) { return false;}
		else {
			return $query->result();
		}
	}

	public function generate_recaptcha_field(){
		$content = '';
		if($this->config_vars['ddos_protection'] && $this->config_vars['recaptcha_active'] && $this->get_login_attempts() >= $this->config_vars['recaptcha_login_attempts']){
			$content .= "<script type='text/javascript' src='https://www.google.com/recaptcha/api.js'></script>";
			$siteKey = $this->config_vars['recaptcha_siteKey'];
			$content .= "<div class='g-recaptcha' data-sitekey='{$siteKey}'></div>";
		}
		return $content;
	}

	public function update_user_totp_secret($user_id = false, $secret) {

		if ($user_id == false)
			$user_id = $this->CI->session->userdata('id');

		$data['totp_secret'] = $secret;

		$this->aauth_db->where('id', $user_id);
		return $this->aauth_db->update($this->config_vars['users'], $data);
	}

	public function generate_unique_totp_secret(){
		$this->CI->load->helper('googleauthenticator');
		$ga = new PHPGangsta_GoogleAuthenticator();
		$stop = false;
		while (!$stop) {
			$secret = $ga->createSecret();
			$query = $this->aauth_db->where('totp_secret', $secret);
			$query = $this->aauth_db->get($this->config_vars['users']);
			if ($query->num_rows() == 0) {
				return $secret;
				$stop = true;
			}
		}
	}

	public function generate_totp_qrcode($secret){
		$this->CI->load->helper('googleauthenticator');
		$ga = new PHPGangsta_GoogleAuthenticator();
		return $ga->getQRCodeGoogleUrl($this->config_vars['name'], $secret);
	}

	public function verify_user_totp_code($totp_code, $user_id = false){
		if ( !$this->is_totp_required()) {
			return true;
		}
		if ($user_id == false) {
			$user_id = $this->CI->session->userdata('id');
		}
		if (empty($totp_code)) {
			$this->error($this->CI->lang->line('aauth_error_totp_code_required'));
			return false;
		}
		$query = $this->aauth_db->where('id', $user_id);
		$query = $this->aauth_db->get($this->config_vars['users']);
		$totp_secret =  $query->row()->totp_secret;
		$this->CI->load->helper('googleauthenticator');
		$ga = new PHPGangsta_GoogleAuthenticator();
		$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
		if (!$checkResult) {
			$this->error($this->CI->lang->line('aauth_error_totp_code_invalid'));
			return false;
		}else{
			$this->CI->session->unset_userdata('totp_required');
			return true;
		}
	}

	public function is_totp_required(){
		if ( !$this->CI->session->userdata('totp_required')) {
			return false;
		}else if ( $this->CI->session->userdata('totp_required')) {
			return true;
		}
	}

} 
