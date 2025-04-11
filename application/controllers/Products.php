<?php
class Products extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$this->load->library('user_agent');
		$this->load->model(array('users_model', 'product_model'));
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

		$data['title'] = 'Products';
		$data['page'] = 'products/view_products';

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
			'assets/js/js/products/view_products.js'
		];

		$this->log_data('products', 'Products Page opened', []);

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
			$result = $this->product_model->get_products();

			foreach($result as $row) {

				$name = $row->name;
				$sku = $row->sku;
				$price = number_format($row->price, 2);

				$product = '<h2 class="table-avatar">
					<a href="#" class="avatar avatar-sm me-2">
					<img class="avatar-img rounded" src="assets/uploads/'.$row->image.'" alt="Product Image"></a>
					<a href="#">'.$name.'</a>
				</h2>';

				$action = "<span data-itemid='".$row->id."' class='editItem cursor-pointer p-1 small bg-primary rounded text-white me-2 fa fa-edit' title='Edit'></span>";
				$status = '';
				if($row->status=="1"){
					$action .= " <span data-name='".$name."' data-itemid='".$row->id."'  data-status='5' class='activate_product cursor-pointer ps-1 pe-1 small bg-danger rounded text-white me-2' title='Deactivate'><i class='fas fa-times'></i></span>";

					$status = '<span class="badge badge-pill bg-success-light">Active</span>';
				}else{
					$action .= " <span data-name='".$name."' data-itemid='".$row->id."' data-status='1' class='activate_product cursor-pointer small bg-success text-white ps-1 pe-1 rounded' title='Activate'><i class='fa fa-check'></i></span>";

					$status = '<span class="badge badge-pill bg-danger-light">Deactivated</span>';
				}

				$output['data'][] = [ 
					$product, 
					$sku, 
					$price,
					$status,
					$action
				];
			}

			echo json_encode($output);
		}
	}

	public function set_product_status()
	{
		if ($this->input->is_ajax_request()) {
        	$this->db->trans_begin();

			$id = $this->input->post('id');
			$status = $this->input->post('status');

			$p_data = array(
				'status'=> ($status=="1") ? '1' : '0',
			);

			$this->product_model->update_product($p_data, ['id'=>$id]);

			$log_desc = ($status=="1") ? 'Activated product with Id '.$id  : 'Deactivated product with Id '.$id;
			$logd = array('status'=>$status, 'id'=>$id);
			
			$this->log_data('products', $log_desc, $logd);

			if ($this->db->trans_status() == true) {
	            $this->db->trans_commit();
	            response(true, "Changes saved successfully", null);
	        } else {
	            $this->db->trans_rollback();
	            response(false, "An error has occurred. Try again", null);
	        } 
    	}
	}

	public function create()
	{
        if (empty($_FILES['image']['name'])) {
            response(false, 'Image is required', '');
        }

        if(empty($_POST['name'] || empty($_POST['price']))){
        	response(false, 'All fields are required, complete the form and retry again', '');
        }

        $this->db->trans_begin();

        $name  = $this->input->post('name');
        $price = $this->input->post('price');
        $sku = $this->input->post('sku');

        $checkName = $this->product_model->get_product_args(['name'=>$name]);
        if(!empty($checkName)){
        	response(false, 'This product already exist, try another name', '');
        }

        $checkSku = $this->product_model->get_product_args(['sku'=>$sku]);
        if(!empty($checkSku)){
        	response(false, 'This product already exist, try another sku', '');
        }

        $newFileName = time() . '_' . uniqid();
        $config['upload_path'] 		= './assets/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 1024;
        $config['file_name']     = $newFileName;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            response(false, $this->upload->display_errors('', ''), '');
        }

        $uploadData = $this->upload->data();
        $data = [
            'name'  => $name,
            'price' => $price,
            'sku' => $sku,
            'status' => '1',
            'image' => $uploadData['file_name']
        ];

        $this->product_model->insert($data);

        $this->log_data('products', 'Products added', $data);

		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			response(false, 'Sorry an unknown error has occurred, try again after sometime', '');
		}else{
			$this->db->trans_commit();
			response(true, 'Product added successfully', '');
		}
	}

	public function update()
	{
		if($_POST){
			if(empty($_POST['name'] || empty($_POST['price']) || empty($_POST['id']) )){
	        	response(false, 'All fields are required, complete the form and retry again', '');
	        }

	        $this->db->trans_begin();
	        $name = $this->input->post('name');
	        $id = $this->input->post('id');
	        $sku = $this->input->post('sku');
	        $price = $this->input->post('price');

	        $checkProduct = $this->product_model->get_product_args(['id!='=>$id, 'name'=>$name]);
	        if(!empty($checkProduct)){
	        	response(false, "Product name is already assigned to another product");
	        }

	        $checkSku = $this->product_model->get_product_args(['sku'=>$sku, 'id!='=>$id]);
	        if(!empty($checkSku)){
	        	response(false, 'This product already exist, try another sku', '');
	        }

	        $data = [
	            'name'  => $name,
	            'price' => $price,
	            'sku' => $sku,
	        ];

	        $this->product_model->update_product($data, ['id'=>$id]);

	        $this->log_data('products', 'Products updated', $data);

			if($this->db->trans_status() == false){
				$this->db->trans_rollback();
				response(false, 'Sorry an unknown error has occurred, try again after sometime', '');
			}else{
				$this->db->trans_commit();
				response(true, 'Changes saved successfully', '');
			}
		}
		
	}

	public function getProduct()
	{
		if($_POST){
			$id = $this->input->post('id');
			if(empty($id)){
				response(false, "Product Id is required");
			}

			$product = $this->product_model->get_product_args(['id'=>$id]);
			if(empty($product)){
				response(false, "Product details not found");
			}

			response(true, "Product details retrieved successfully", $product);
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