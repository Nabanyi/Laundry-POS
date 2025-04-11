<?php
class Dashboard extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$this->load->library('user_agent');
		$this->load->model(['users_model', 'orders_model', 'customers_model']);
		$this->browser 			= $this->agent->browser();
		$this->browser_version 	= $this->agent->version();
		$this->os 				= $this->agent->platform();
		$this->ip_address 		= $this->input->ip_address();
		$this->user_id      	= $this->session->userdata('user_id');
		$this->role      	= $this->session->userdata('role');

		if($this->user_id=="") redirect(base_url('login'));

		if($this->role == 'USER'){
			redirect(base_url('pos'));
		}
	}

	public function index()
	{
		$data = array();

		$data['title'] = 'Dashboard';
		$data['page'] = 'dashboard';

		$data['js'] = [
			'js/js/dashboard.js'
		];

		$data['count_sales'] = $this->orders_model->count_sales();
		$data['count_items'] = $this->orders_model->count_items();
		$data['count_users'] = $this->orders_model->count_users();
		$data['count_pending'] = $this->orders_model->count_pending_orders();

		$allcustomers = $this->customers_model->get_customers();
		$customers = [];
		foreach ($allcustomers as $k => $v) {
			$customers[$v->id] = ["name"=>$v->firstname.' '.$v->middlename.' '.$v->lastname, "phone"=>$v->phone];
		}

		$orders = $this->orders_model->get_dashboard_orders();
		$data['orders'] = [];
		foreach ($orders as $k => $v) {
			$customer = $customers[$v->customer]['name'].'<br>'.$customers[$v->customer]['phone'];

			$sn = $k + 1;

			$row = ['sn'=>$sn, 'customer'=>$customer, 'date'=>$v->trans_date, 'amount'=>$v->total_amount, 'discount'=>$v->discount_amt, 'paid'=>$v->amount_paid, 'balance'=>$v->balance, 'status'=>$v->status];

			$data['orders'][] = $row;
		}

		$this->log_data('dashboard', 'View Dashboard', []);
		
		$this->load->view('template/main', $data);
	}

	private function log_data($page, $activity, $data)
	{
		$log_data = array(
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