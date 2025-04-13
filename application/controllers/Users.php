<?php
class Users extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$this->load->library('user_agent');
		$this->load->model(array('users_model'));
		$this->browser 			= $this->agent->browser();
		$this->browser_version 	= $this->agent->version();
		$this->os 				= $this->agent->platform();
		$this->ip_address 		= $this->input->ip_address();
		$this->user_id      	= $this->session->userdata('user_id');
		$this->role     	 = $this->session->userdata('role');

		if($this->user_id=="") redirect(base_url('login'));
	}

	public function index()
	{
		$this->db->trans_begin();

		$data = array();

		$data['title'] = 'Users';
		$data['page'] = 'users/users';

		$data['css'] = [
			'assets/css/bootstrap-datetimepicker.min.css',
			'assets/plugins/datatables/datatables.min.css',
			'assets/plugins/select2/css/select2.min.css',
			'assets/plugins/sweetalert/sweetalerts.css',
			'assets/plugins/select2/css/select2-bootstrap-5-theme.min.css',
		];

		$data['js'] = [
			'assets/plugins/datatables/jquery.dataTables.min.js',
			'assets/plugins/datatables/datatables.min.js',
			'assets/plugins/datatables/dataTables.buttons.js',
			'assets/plugins/datatables/buttons.bootstrap4.min.js',
			'assets/plugins/datatables/jszip.min.js',
			'assets/plugins/datatables/pdfmake.min.js',
			'assets/plugins/datatables/vfs_fonts.js',
			'assets/plugins/datatables/buttons.html5.js',
			'assets/plugins/datatables/buttons.print.js',
			'assets/plugins/datatables/buttons.colVis.js',
			'assets/plugins/moment/moment.min.js',
			'assets/plugins/sweetalert/sweetalerts.min.js',
			'assets/plugins/select2/js/select2.min.js',
			'assets/js/plugin/bootstrap-datetimepicker.min.js',
			'assets/js/js/helper.js',
			'assets/js/js/users/users.js'
		];


		$this->log_data('users', 'Users Page opened', []);

		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		
		$this->load->view('template/main', $data);
	}

	public function dataList()
	{
		if ($this->input->is_ajax_request()) {
           
			$output = ["data"=>[]];
			$result = $this->users_model->get_users();

			foreach($result as $row) {

				$name = $row->firstname.' '.$row->middlename.' '.$row->lastname;
				$staff = '<h2 class="table-avatar">
					<a href="#" class="avatar avatar-sm me-2">
					<img class="avatar-img rounded-circle" src="assets/img/male_avatar.png" alt="User Image"></a>
					<a href="#">'.$name.'</a>
				</h2>';

				$username = $row->username;
				$type = $row->role;
				$contact = $row->email.'<br><span class="small text-muted">'.$row->phone.'</span>';
				
				$action = "";
				$status = '';
				if($row->status=="1"){
					$action .= "<a href='javascript:void(0);' data-name='".$name."' data-staffid='".$row->id."'  data-status='5' class='activate_user btn btn-sm btn-white text-danger me-2'> <i class='fa fa-times'></i> Block </a>";

					$status = '<span class="badge badge-pill bg-success-light">Active</span>';
				}else{
					$action .= "<a href='javascript:void(0);' data-name='".$name."' data-staffid='".$row->id."' data-status='1' class='activate_user btn btn-sm btn-white text-success me-2'>
						<i class='fa fa-check'></i> Activate </a>";

					$status = '<span class="badge badge-pill bg-danger-light">Blocked</span>';
				}

				$output['data'][] = [ 
					$staff, 
					$username, 
					$type,
					$contact,
					$status,
					$action
				];
			}

			echo json_encode($output);
		}
	}

	public function set_user_status()
	{
		if ($this->input->is_ajax_request()) {
        	$this->db->trans_begin();

			$staff_id = $this->input->post('staffid');
			$status = $this->input->post('status');

			$user_data = array(
				'status'=> ($status=="1") ? '1' : '0',
			);

			$update_user = $this->users_model->update_user($user_data, ['id'=>$staff_id]);

			$log_desc = ($status=="1") ? 'Activated staff with Id '.$staff_id  :'Blocked staff with Id '.$staff_id;
			$logd = array('status'=>$status, 'id'=>$staff_id);
			
			$this->log_data('users', $log_desc, $logd);

			if ($this->db->trans_status() == true) {
	            $this->db->trans_commit();
	            response(true, "Changes saved successfully", null);
	        } else {
	            $this->db->trans_rollback();
	            response(false, "An error has occurred. Try again", null);
	        } 
    	}
	}

	public function create_user()
	{
		if ($this->input->is_ajax_request()) {
            $this->db->trans_begin();

            $firstname    		= $this->input->post('firstname');
            $middlename    		= $this->input->post('middlename');
            $lastname    		= $this->input->post('lastname');
            $role    			= $this->input->post('role');
            $email    			= $this->input->post('email');
            $phone    			= $this->input->post('phone');
            $username    		= $this->input->post('username');
            $password    		= $this->input->post('password');
            $pass_repeat 		= $this->input->post('cpassword');

            // $uppercase = preg_match('@[A-Z]@', $password);
			// $lowercase = preg_match('@[a-z]@', $password);
			// $number    = preg_match('@[0-9]@', $password);

			if ($password !== $pass_repeat) {
                response(false, 'Your passwords do not match!', '');
            }

            // if(strlen($password) < 8) {
			//   	response(false, 'Your passwords must be at least 8 characters', '');
			// }

			// if(!$uppercase) {
			//   	response(false, 'Your passwords must contain at least one Upper Case Letter', '');
			// }

			// if(!$lowercase) {
			//   	response(false, 'Your passwords must contain at least one Lower Case Letter', '');
			// }

			// if(!$number) {
			//   	response(false, 'Your passwords must contain at least one Number', '');
			// }

            //check if username exist...
            $check_username = $this->users_model->get_user_data(['username'=>$username]);
            if(!empty($check_username)){
            	response(false, 'Username is already taken', '');
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $data = array(
            	'firstname' => $firstname, 
            	'middlename' => $middlename, 
            	'lastname' => $lastname, 
            	'email' => $email, 
            	'phone' => $phone, 
            	'role' => $role, 
            	'username' => $username, 
            	'status' => '1', 
            	'password' => $password_hash, 
            );

            $this->users_model->create_users($data);

            $data_arr = array(
            	'firstname' => $firstname, 
            	'middlename' => $middlename, 
            	'lastname' => $lastname, 
            	'email' => $email, 
            	'phone' => $phone, 
            	'role' => $role, 
            	'username' => $username, 
            	'status' => '1', 
            );

            $this->log_data('users', 'Created a new user', $data_arr);

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                response(false, 'Sorry, Unknown error occurred, try again later!', '');
            } else {
                $this->db->trans_commit();
                response(true, 'User account successfully created!', '');
            }
        }
	}

	public function profile()
	{
		$this->db->trans_begin();

		$data = array();

		$data['title'] = 'Users';
		$data['page'] = 'users/profile';

		$data['css'] = [
			'assets/css/bootstrap-datetimepicker.min.css',
			'assets/plugins/select2/css/select2.min.css',
			'assets/plugins/sweetalert/sweetalerts.css',
			'assets/plugins/select2/css/select2-bootstrap-5-theme.min.css',
		];

		$data['js'] = [
			'assets/plugins/moment/moment.min.js',
			'assets/plugins/sweetalert/sweetalerts.min.js',
			'assets/plugins/select2/js/select2.min.js',
			'assets/js/plugin/bootstrap-datetimepicker.min.js',
			'assets/js/js/helper.js',
			'assets/js/js/users/profile.js'
		];

		$data['user'] = $this->users_model->get_user_data(['id'=>$this->user_id]);
		$this->log_data('profile', 'Profile Page opened', []);

		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		
		$this->load->view('template/main', $data);
	}

	public function update_profile()
	{
		if($_POST){
			$this->db->trans_begin();

            $firstname    		= $this->input->post('firstname');
            $middlename    		= $this->input->post('middlename');
            $lastname    		= $this->input->post('lastname');
            $email    			= $this->input->post('email');
            $phone    			= $this->input->post('phone');
            $username    		= $this->input->post('username');

            //check if username exist...
            $check_username = $this->users_model->get_user_data(['username'=>$username, 'id!='=>$this->user_id]);
            if(!empty($check_username)){
            	response(false, 'Username is already taken', '');
            }

            $data = array(
            	'firstname' => $firstname, 
            	'middlename' => $middlename, 
            	'lastname' => $lastname, 
            	'email' => $email, 
            	'phone' => $phone, 
            	'username' => $username, 
            );

            $this->users_model->update_user($data, ['id'=>$this->user_id]);

            $this->log_data('users', 'Updated user profile', $data);

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                response(false, 'Sorry, Unknown error occurred, try again later!', '');
            } else {
                $this->db->trans_commit();
                response(true, 'User account successfully updated!', '');
            }
		}
	}

	public function update_password()
	{
		if($_POST){
			$this->db->trans_begin();

            $current_password   = $this->input->post('current_password');
            $password    		= $this->input->post('password');
            $cpassword    		= $this->input->post('cpassword');

            $user = $this->users_model->get_user_data(['id'=>$this->user_id]);
            if(empty($user)){
            	response(false, 'User details not found', '');
            }

            if(!password_verify($current_password, $user->password)) {
				response(false, 'Wrong credentials provided. Check your credentials again');
			}

			if($password != $cpassword){
				response(false, 'Passwords donot match');
			}

			$password_hash = password_hash($password, PASSWORD_DEFAULT);
            $data = array(
            	'password' => $password_hash,
            );

            $this->users_model->update_user($data, ['id'=>$this->user_id]);

            $this->log_data('users', 'Updated user profile', $data);

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                response(false, 'Sorry, Unknown error occurred, try again later!', '');
            } else {
                $this->db->trans_commit();
                response(true, 'User password successfully updated!', '');
            }
		}
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