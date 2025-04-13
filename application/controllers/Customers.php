<?php
class Customers extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$this->load->library('user_agent');
		$this->load->model(array('users_model', 'customers_model'));
		$this->browser 			= $this->agent->browser();
		$this->browser_version 	= $this->agent->version();
		$this->os 				= $this->agent->platform();
		$this->ip_address 		= $this->input->ip_address();
		$this->user_id      	= $this->session->userdata('user_id');
		$this->role     	 = $this->session->userdata('role');

		if($this->user_id=="") redirect(base_url('login'));

		if($this->role == 'USER') redirect(base_url('pos'));
	}

	public function index()
	{
		$this->db->trans_begin();

		$data = array();

		$data['title'] = 'Customers';
		$data['page'] = 'customers/customers';

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
			'assets/js/js/customers/customers.js'
		];


		$this->log_data('customers', 'Customers Page opened', []);

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
			$result = $this->customers_model->get_customers();

			foreach($result as $row) {

				$name = $row->firstname.' '.$row->middlename.' '.$row->lastname;
				$customer = '<h2 class="table-avatar">
					<a href="#" class="avatar avatar-sm me-2">
					<img class="avatar-img rounded-circle" src="assets/img/male_avatar.png" alt="User Image"></a>
					<a href="#">'.$name.'</a>
				</h2>';

				$email = $row->email;
				$phone = $row->phone;
				$dob = $row->dob;
				
				$action = "<span data-staffid='".$row->id."' class='edit_customer cursor-pointer bg-primary text-white p-1 rounded bx bxs-edit'></span> ";
				$status = '';
				if($row->status=="1"){
					$action .= "<span data-name='".$name."' data-staffid='".$row->id."'  data-status='5' class='activate_user cursor-pointer rounded p-1 bg-danger text-white fa fa-times'></span>";

					$status = '<span class="badge badge-pill bg-success-light">Active</span>';
				}else{
					$action .= "<span data-name='".$name."' data-staffid='".$row->id."' data-status='1' class='activate_user cursor-pointer cursor-pointer rounded p-1 text-white bg-success fa fa-user-check'> </span>";

					$status = '<span class="badge badge-pill bg-danger-light">Blocked</span>';
				}

				$output['data'][] = [ 
					$customer, 
					$email, 
					$phone,
					$dob,
					$status,
					$action
				];
			}

			echo json_encode($output);
		}
	}

	public function set_status()
	{
		if ($this->input->is_ajax_request()) {
        	$this->db->trans_begin();

			$customer_id = $this->input->post('staffid');
			$status = $this->input->post('status');

			$customer_data = array(
				'status'=> ($status=="1") ? '1' : '0',
			);

			$update_user = $this->customers_model->update_customer($customer_data, ['id'=>$customer_id]);

			$log_desc = ($status=="1") ? 'Activated customer with Id '.$staff_id  :'Blocked customer with Id '.$staff_id;
			$logd = array('status'=>$status, 'id'=>$staff_id);
			
			$this->log_data('customers', $log_desc, $logd);

			if ($this->db->trans_status() == true) {
	            $this->db->trans_commit();
	            response(true, "Changes saved successfully", null);
	        } else {
	            $this->db->trans_rollback();
	            response(false, "An error has occurred. Try again", null);
	        } 
    	}
	}

	public function get_customer()
	{
		if ($this->input->is_ajax_request()) {

        	$this->db->trans_begin();

			$customerid = $this->input->post('customerid');
			if(empty($customerid)){
				response(false, "Customer ID is required", '');
			}

			$customer = $this->customers_model->get_customer(['id'=>$customerid]);
			
			$this->log_data('customers', 'Get customer details', []);

			if ($this->db->trans_status() == true) {
	            $this->db->trans_commit();
	            response(true, "Customer details successfully retrieved", $customer); //0244743143, 0244408354
	        } else {
	            $this->db->trans_rollback();
	            response(false, "An error has occurred. Try again", null);
	        } 
    	}
	}

	public function create_customer()
	{
		if ($this->input->is_ajax_request()) {
            $this->db->trans_begin();

            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $lastname = $this->input->post('lastname');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $dob   = $this->input->post('dob');

            $data = array(
            	'firstname' => $firstname, 
            	'middlename' => $middlename, 
            	'lastname' => $lastname, 
            	'email' => $email, 
            	'phone' => $phone, 
            	'address' => $address, 
            	'dob' => $dob, 
            	'status' => '1', 
            );

            $this->customers_model->create_customer($data);

            $this->log_data('customers', 'Created a new customer', $data);

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                response(false, 'Sorry, Unknown error occurred, try again later!', '');
            } else {
                $this->db->trans_commit();
                response(true, 'Customer successfully added!', '');
            }
        }
	}

	public function update_customer()
	{
		if ($this->input->is_ajax_request()) {
            $this->db->trans_begin();

            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $lastname = $this->input->post('lastname');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $dob   = $this->input->post('dob');
            $id   = $this->input->post('customerid');

            $data = array(
            	'firstname' => $firstname, 
            	'middlename' => $middlename, 
            	'lastname' => $lastname, 
            	'email' => $email, 
            	'phone' => $phone, 
            	'address' => $address, 
            	'dob' => $dob, 
            );

            $this->customers_model->update_customer($data, ['id'=>$id]);

            $this->log_data('customers', 'Updated customer details', $data);

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
                response(false, 'Sorry, Unknown error occurred, try again later!', '');
            } else {
                $this->db->trans_commit();
                response(true, 'Changes successfully saved!', '');
            }
        }
	}

	public function search_customer()
    {
        if($this->input->is_ajax_request()){
        	$search = $this->input->post('search');

            $results = $this->customers_model->search_customers($search);
            $jsonResponse = array();
            foreach ($results as $key) {
            	$name = $key->firstname.' '.$key->middlename.' '.$key->lastname;
                $jsonResponse[] = array(
                    "value"=>$name,
                    "label"=>$name,
                    "actual_value"=>$key->id,
                );
            }

            echo json_encode($jsonResponse);
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