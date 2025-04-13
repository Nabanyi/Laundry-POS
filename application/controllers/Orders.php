<?php
class Orders extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$this->load->library('user_agent');
		$this->load->model(array('users_model', 'customers_model', 'product_model', 'orders_model'));
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

		$data['title'] = 'Orders';
		$data['page'] = 'orders/view_orders';

		$data['css'] = [
			'assets/css/bootstrap-datetimepicker.min.css',
			'assets/plugins/sweetalert/sweetalerts.css',
		];

		$data['js'] = [
			'assets/plugins/moment/moment.min.js',
			'assets/plugins/sweetalert/sweetalerts.min.js',
			'assets/plugins/select2/js/select2.min.js',
			'assets/js/plugin/bootstrap-datetimepicker.min.js',
			'assets/js/js/helper.js',
			'assets/js/js/orders/view_orders.js'
		];

		$allcustomers = $this->customers_model->get_customers();
		$customers = [];
		foreach ($allcustomers as $k => $v) {
			$customers[$v->id] = $v->firstname.' '.$v->middlename.' '.$v->lastname;
		}

		$allitems = $this->product_model->get_products();
		$items = [];
		foreach ($allitems as $k => $v) {
			$items[$v->id] = $v->name;
		}

		$data['pending'] = [];
		$data['progress'] = [];
		$data['ready'] = [];

		$orders = $this->orders_model->get_orders_args(['status!='=>'3']);
		foreach ($orders as $k => $v) {
			$itemname = $items[$v->itemid];
			$customername = $customers[$v->customer];

			$orderItems = $this->orders_model->get_order_items(['orderid'=>$v->orderid]);
			$itemp = '';
			foreach ($orderItems as $kk => $row) {
				$itemp .= $items[$row->itemid].' '.$row->quantity.' &bull; ';
			}

			if($v->status == '0'){
				$data['pending'][] = ["item"=>$itemname, "customer"=>$customername, "amount"=>$v->total_amount, "orderid"=>$v->id, "product"=>$itemp, "days"=>$this->timeAgo($v->trans_date)];
			}else if($v->status == '1'){
				$data['progress'][] = ["item"=>$itemname, "customer"=>$customername, "amount"=>$v->total_amount, "orderid"=>$v->id, "product"=>$itemp, "days"=>$this->timeAgo($v->trans_date)];
			}else{
				$data['ready'][] = ["item"=>$itemname, "customer"=>$customername, "amount"=>$v->total_amount, "orderid"=>$v->id, "product"=>$itemp, "days"=>$this->timeAgo($v->trans_date)];
			}
		}

		$this->log_data('orders', 'Orders Page opened', []);

		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		
		$this->load->view('template/main', $data);
	}

	public function pos()
	{
		$this->db->trans_begin();

		$data = array();

		$data['title'] = 'POS';
		$data['page'] = 'orders/view_pos';

		$data['css'] = [
			'assets/css/bootstrap-datetimepicker.min.css',
			'assets/plugins/sweetalert/sweetalerts.css',
		];

		$data['js'] = [
			'assets/plugins/moment/moment.min.js',
			'assets/plugins/sweetalert/sweetalerts.min.js',
			'assets/plugins/select2/js/select2.min.js',
			'assets/js/plugin/bootstrap-datetimepicker.min.js',
			'assets/js/js/helper.js',
			'assets/js/js/orders/view_pos.js'
		];

		$data['items'] = $this->product_model->get_products();

		$this->log_data('pos', 'POS Page opened', []);

		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		
		$this->load->view('orders/view_pos', $data);
	}

	public function create_order()
	{
		if($_POST){
			$this->db->trans_begin();

			$trans_date = date('Y-m-d');
            $items = $this->input->post('items');
            $quantities = $this->input->post('qty');
            $clientid = $this->input->post('customerid');
            $amount_paid = $this->input->post('amount_paid');
            $discount = $this->input->post('discount');

            if(count($items) == 0 || count($quantities)==0){
                response(false, 'Complete the form and submit again');
            }

            $pitems = [];
            $repeated_items = [];
            $repeated_counts = 0;
            $invalid_qtys = 0;
            $printRow = '';

            $total_amount = 0;
            $orderid = $this->orders_model->generate_orderid();
            for ($i=0; $i < count($items); $i++) { 
                $itemdetails = $this->product_model->get_product_args(['id'=>$items[$i]]);
                if(empty($itemdetails)) response(false, 'Item details not found. Please referesh your page and try again');

                $code = $itemdetails->id;
                $cashprice = $itemdetails->price;
                $itemname = $itemdetails->name;

                if(!is_numeric($quantities[$i])){
                    $invalid_qtys++;
                    continue;
                }

                $qtypurchasing = (float)$quantities[$i];

                if(in_array($items[$i], $repeated_items)){
                    $repeated_counts++;
                    continue;
                }else{
                    $repeated_items[] = $items[$i];
                }

                $cost = $qtypurchasing * $cashprice;
                $total_amount += $cost;
                                
                $pitems[] = ['orderid'=>$orderid, 'amount'=>$cost, 'selling_price'=>$cashprice, 'quantity'=>$qtypurchasing, 'itemid'=>$code];

                $sn =  $i + 1;
                $printRow .= '
                    <tr>
                        <td>'.$sn.'</td>
                        <td>'.$itemname.'</td>
                        <td>'.$qtypurchasing.'</td>
                        <td>'.number_format($cashprice, 2).'</td>
                        <td>'.number_format($cost, 2).'</td>
                    </tr>
                ';
            }

            if($repeated_counts > 0){
                response(false, 'Some items have been selected more than once. Please remove all duplicates');
            }

            if($invalid_qtys > 0){
                response(false, 'Some item quantities are invalid');
            }

            // create order items
            $this->orders_model->create_order_items($pitems);

            $clientname = '';
            $clientphone = '';
            $clientemail = '';
            if(empty($clientid)){
                $clientname = $this->input->post('clientname');
                $clientphone = $this->input->post('clientphone');
                $clientdob = $this->input->post('clientdob');
                $clientemail = $this->input->post('clientemail');

                if(empty($clientname) || empty($clientphone)) response(false, 'Client name and phone is required to proceed');

                $checkclient = $this->customers_model->get_customer(['phone'=>$clientphone]);
                if(!empty($checkclient)){
                    $clientid = $checkclient->id;
                    $clientname = $clientdata->firstname.' '.$clientdata->middlename.' '.$clientdata->lastname;
                    $clientemail = $checkclient->email;
                    $clientphone = $checkclient->phone;
                }else{

                	$name = $this->splitName($clientname);

                    $data = [
                        'firstname' => $name['firstname'],
                        'middlename' => $name['middlename'],
                        'lastname' => $name['lastname'],
                        'phone' => $clientphone,
                        'email' => $clientemail,
                        'dob' => $clientdob,
                        'status' => '1'
                    ];

                    $clientid = $this->customers_model->create_customer_id($data);
                }
                
            }else{
                $clientdata = $this->customers_model->get_customer(['id'=>$clientid]);
                if(empty($clientdata)) response(false, 'Client details were not found. Please refresh your page and try again.');
                $clientid = $clientdata->id;
                $clientname = $clientdata->firstname.' '.$clientdata->middlename.' '.$clientdata->lastname;
                $clientphone = $clientdata->phone;
                $clientemail = $clientdata->email;
            }

            $discount_amt = ($discount/100) * $total_amount;
            $balance = ($total_amount - $amount_paid) - $discount_amt;

            $orderdata = [
                'orderid' => $orderid,
                'itemid' => $items[0],
                'customer' => $clientid,
                'total_amount' => $total_amount,
                'amount_paid' => $amount_paid,
                'balance' => $balance,
                'discount' => $discount,
                'discount_amt' => $discount_amt,
                'trans_date' => $trans_date,
                'notes' => (count($items) > 1) ? '& others' : '',
                'status' => '0',
                'created_by' => $this->user_id,
            ];
            $orderid = $this->orders_model->create_order($orderdata);

            $owner = $this->users_model->get_company();

            $printView = '<div class="d-flex justify-content-between">
                    <div>
                        <img src="'.base_url('assets/img/company-logo.png').'" width="100">
                        <p>'.$owner->phone.'<br>'.$owner->email.'<br>'.$owner->address.'</p>
                        <p class="fw-bold">#LD00'.$orderid.'</p>
                    </div>
	            	<address>
	            	Customer:<br>
	            		'.$clientname.'<br>
	            		'.$clientphone.'<br>
	            		'.$clientemail.'<br>
	            		'.$trans_date.'<br>
	            	</address>
	            </div>

                <table class="table table-center table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10%"> SN </th>
                            <th style="width: 40%"> Items </th>
                            <th style="width: 20%"> Quantity </th>
                            <th style="width: 15%"> Price </th>
                            <th style="width: 15%"> Total Amount </th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$printRow.'
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id="total_amount">Total: '.number_format($total_amount, 2).'</td>
                        </tr>
                    </tfoot>
                </table>
            ';

            $this->log_data('pos', 'New Order created', $_POST);

			if($this->db->trans_status() == false){
				$this->db->trans_rollback();
				response(false, 'Sorry, try again later!');
			}else{
				$this->db->trans_commit();
				response(true, "Order successfully created", $printView);
			}
		}
	}

	public function get_order()
	{
		if($_POST){

            $orderid = $this->input->post('orderid');
            if(empty($orderid)){
            	response(false, "Order Id is required");
            }

            $order = $this->orders_model->get_order_args(['id'=>$orderid]);
            if(empty($orderid)){
            	response(false, "Details for this order couldnot be found");
            }

            $customer = $this->customers_model->get_customer(['id'=>$order->customer]);
            $order->customername = $customer->firstname.' '.$customer->middlename.' '.$customer->lastname;
            $order->customeremail = $customer->email;
            $order->customerphone = $customer->phone;

            $allitems = $this->product_model->get_products();
			$items = [];
			foreach ($allitems as $k => $v) {
				$items[$v->id] = $v->name;
			}

            $orderItems = $this->orders_model->get_order_items(['orderid'=>$order->orderid]);
            foreach ($orderItems as $k => $v) {
            	$orderItems[$k]->name = $items[$v->itemid];
            }

            $order->items = $orderItems;

            $owner = $this->users_model->get_company();
            $order->companyname = $owner->name;
            $order->companyphone = $owner->phone;
            $order->companyemail = $owner->email;
            $order->companyaddress = $owner->address;

            response(true, "Order retrieved successfully", $order);
        }
	}

	public function set_order_status()
	{
		if($_POST){
			$this->db->trans_begin();

            $orderid = $this->input->post('orderid');
            $status = $this->input->post('status');
            if($orderid=='' || $status==''){
            	response(false, "Order Id and status is required");
            }

            $order = $this->orders_model->get_order_args(['id'=>$orderid]);
            if(empty($orderid)){
            	response(false, "Details for this order couldnot be found");
            }

            $update_data = ['status'=>$status];
            $where_args = ['id'=>$orderid];
            $this->orders_model->update_order($update_data, $where_args);

            $this->log_data('orders', 'Updated Order status', $_POST);

			if($this->db->trans_status() == false){
				$this->db->trans_rollback();
				response(false, 'Sorry, try again later!');
			}else{
				$this->db->trans_commit();
				response(true, "Changes successfully saved");
			}
        }
	}

	public function delete_order()
	{
		if($_POST){
			$this->db->trans_begin();

            $orderid = $this->input->post('orderid');
            if($orderid==''){
            	response(false, "Order Id is required");
            }

            $order = $this->orders_model->get_order_args(['orderid'=>$orderid]);
            if(empty($orderid)){
            	response(false, "Details for this order couldnot be found");
            }

            if($this->role == 'USER'){
            	response(false, "You dont have enough permissions to carry out this operation");
            }

            $update_data = ['active'=>'0'];
            $where_args = ['orderid'=>$orderid];
            $this->orders_model->update_order($update_data, $where_args);

            $this->log_data('orders', 'Order deleted', $_POST);

			if($this->db->trans_status() == false){
				$this->db->trans_rollback();
				response(false, 'Sorry, try again later!');
			}else{
				$this->db->trans_commit();
				response(true, "Order successfully deleted");
			}
        }
	}

	public function sales()
	{
		$this->db->trans_begin();

		$data = array();

		$data['title'] = 'Sales';
		$data['page'] = 'orders/sales';

		$data['css'] = [
			'assets/css/bootstrap-datetimepicker.min.css',
			'assets/plugins/sweetalert/sweetalerts.css',
		];

		$data['js'] = [
			'assets/plugins/moment/moment.min.js',
			'assets/plugins/sweetalert/sweetalerts.min.js',
			'assets/plugins/select2/js/select2.min.js',
			'assets/js/plugin/bootstrap-datetimepicker.min.js',
			'assets/js/js/helper.js',
			'assets/js/js/orders/sales.js'
		];

		$this->log_data('sales', 'Sales Page opened', []);

		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}
		
		$this->load->view('template/main', $data);
	}

	public function get_sales()
	{
		if($_POST){
			$this->db->trans_begin();

            $fromdate = $this->input->post('fromdate');
            $todate = $this->input->post('todate');
            $type = $this->input->post('type');
           
           	$args = ['status'=>'3'];
           	if($fromdate != ""){
           		$args['trans_date >='] = $fromdate;
           	}

           	if($todate != ""){
           		$args['trans_date <='] = $todate;
           	}

           	if($type != "All"){

           		if($type == "Paid"){
           			$args['balance'] = 0;
           		}

           		if($type == "Partailly"){
           			$args['balance >'] = 0;
           		}

           		if($type == "Overpaid"){
           			$args['balance <'] = 0;
           		}
           	}

           	$allcustomers = $this->customers_model->get_customers();
			$customers = [];
			foreach ($allcustomers as $k => $v) {
				$customers[$v->id] = ["name"=>$v->firstname.' '.$v->middlename.' '.$v->lastname, "phone"=>$v->phone];
			}

           	$orders = $this->orders_model->get_orders_args($args);
           	//response(false, "debug Mode", $this->db->last_query());
           	$table = '';
           	$total_amount = 0;
           	$total_discount = 0;
           	$total_paid = 0;
           	$total_balance = 0;
           	foreach ($orders as $k => $v) {
				$customer = $customers[$v->customer]['name'].'<br>'.$customers[$v->customer]['phone'];
				$sn = $k + 1;
				$table .= '<tr>
					<td>'.$sn.'</td>
					<td>'.$customer.'</td>
					<td>'.$v->trans_date.'</td>
					<td>'.number_format($v->total_amount, 2).'</td>
					<td>'.number_format($v->discount_amt, 2).'</td>
					<td>'.number_format($v->amount_paid, 2).'</td>
					<td>'.number_format($v->balance, 2).'</td>
					<td><span data-orderid="'.$v->id.'" class="order-item p-1 rounded text-white bg-primary fa fa-print cursor-pointer me-1" title="Print"></span> <span data-amount="'.$v->total_amount.'" data-discount="'.$v->discount_amt.'" data-paid="'.$v->amount_paid.'" data-orderid="'.$v->id.'" data-balance="'.$v->balance.'" class="receive-payment p-1 rounded text-white bg-success fa fa-money-check-alt cursor-pointer" title="Receive Payment"></span> </td>
				</tr>';

				$total_amount += $v->total_amount;
	           	$total_discount += $v->discount_amt;
	           	$total_paid += $v->amount_paid;
	           	$total_balance += $v->balance;
			}

			if(count($orders) > 0){
				response(true, "Data retrieved successfully", ['table'=>$table, 'total_amount'=>$total_amount, 'total_discount'=>$total_discount, 'total_paid'=>$total_paid, 'total_balance'=>$total_balance]);
			}else{
				response(false, "No data found");
			}
        }
	}

	public function receive_payments()
	{
		if($_POST){
			$this->db->trans_begin();

            $orderid = $this->input->post('orderid');
            $amount = $this->input->post('amount');
            if(empty($orderid) || empty($amount)){
            	response(false, "Order Id and amount is required");
            }
           
           	$order = $this->orders_model->get_order_args(['id'=>$orderid]);
            if(empty($orderid)){
            	response(false, "Details for this order couldnot be found");
            }

            $balance = $order->balance;
            $new_bal = $balance - $amount;

            $update_data = ['balance'=>$new_bal];
            $where_args = ['id'=>$orderid];
            $this->orders_model->update_order($update_data, $where_args);

            $pmt_data = ['orderid'=>$orderid, 'prev_bal'=>$balance, 'amount'=>$amount, 'created_by'=>$this->user_id];
            $this->orders_model->create_payment($pmt_data);

            $this->log_data('orders', 'Updated order payment', $_POST);

			if($this->db->trans_status() == false){
				$this->db->trans_rollback();
				response(false, 'Sorry, try again later!');
			}else{
				$this->db->trans_commit();
				response(true, "Payment successfully saved");
			}
        }
	}

	private function splitName($name)
	{
	    $nameParts = explode(' ', trim($name)); // Split by spaces
	    $count = count($nameParts);

	    if ($count < 1) {
	        return ['error' => 'Invalid name'];
	    }

	    $firstName = $nameParts[0];
	    $middleName = ($count > 2) ? implode(' ', array_slice($nameParts, 1, -1)) : ''; // Middle name if exists
	    $lastName = ($count > 1) ? $nameParts[$count - 1] : ''; // Last name if available

	    return [
	        'firstname' => $firstName,
	        'middlename' => $middleName,
	        'lastname' => $lastName
	    ];
	}

	private function timeAgo($date)
	{
	    $givenTime = strtotime($date);
	    $currentTime = time();
	    $diff = $currentTime - $givenTime;
	    
	    if ($diff < 0) {
	        return "Invalid date (future date)";
	    }

	    $days = floor($diff / (60 * 60 * 24));

	    if ($days == 0) {
	        return "Today";
	    } elseif ($days == 1) {
	        return "Yesterday";
	    } else {
	        return "$days days ago";
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