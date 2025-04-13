<?php
class Login extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$this->load->model(array('login_model', 'users_model'));

		$this->load->library('user_agent');
		$this->browser 			= $this->agent->browser();
		$this->browser_version 	= $this->agent->version();
		$this->os 				= $this->agent->platform();
		$this->ip_address 		= $this->input->ip_address();
		$this->user_id      	= $this->session->userdata('user_id');
	}

	public function index()
	{
		$data = array();

		$this->load->view('login/login', $data);
	}

	public function auth()
	{
		if ($this->input->is_ajax_request()) {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if (empty($username) || empty($password) ) {
				response(false, 'Provide your username and Password');
			}

			$user = $this->login_model->get_user(array('username'=>$username));
			if(empty($user)) {
				response(false, 'Wrong credentials provided', password_hash("password", PASSWORD_DEFAULT));
			}

			if($user->status == '0') {
				response(false, 'Your account has been suspended, Contact your administrator for details');
			}
	
			if(!password_verify($password, $user->password)) {
				response(false, 'Wrong credentials provided. Check your credentials again');
			}

			$owner = $this->users_model->get_company();
			$session_data = array(
				'user_id'			=> $user->id,
				'username'			=> $user->username,
				'role'				=> $user->role,
				'company_abbr'		=> $owner->abbr,
				'companyid'			=> $owner->id
			);

			$this->session->set_userdata($session_data);

			$this->log_data('login', 'Loggedin', []);

			if($user->role == 'ADMIN'){
				response(true, 'Login successful. Redirecting...', 'dashboard');
			}else{
				response(true, 'Login successful. Redirecting...', 'pos');
			}
        }
	}

	public function logout()
	{
		$this->log_data('logout', 'Logged Out', []);
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}

	private function log_data($page, $activity, $data)
	{
		$log_data = array(
			'userid' 	=> $this->user_id,
			'page' 		=> $page,
			'ip' 		=> $this->ip_address,
			'browser' 	=> $this->browser,
			'os' 		=> $this->os,
			'activity' 	=> $activity,
			'data' 		=> json_encode($data)
		);

		$this->users_model->create_log($log_data);
	}
}