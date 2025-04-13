<div class="row">
	<h5>Welcome <?=$this->session->userdata('username')?>!</h5>
</div>

<div class="content container-fluid">
	<div class="row">
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-1"> <i class="fas fa-dollar-sign"></i> </span>
						<div class="dash-count">
							<div class="dash-title">Sales</div>
							<div class="dash-counts">
								<p><?=$count_sales->count?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-4"> <i class="far fa-file"></i> </span>
						<div class="dash-count">
							<div class="dash-title">Pending Orders</div>
							<div class="dash-counts">
								<p><?=$count_pending->count?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3"> <i class="fas fa-file-alt"></i> </span>
						<div class="dash-count">
							<div class="dash-title">Products</div>
							<div class="dash-counts">
								<p><?=$count_items->count?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-2"> <i class="fas fa-users"></i> </span>
						<div class="dash-count">
							<div class="dash-title">Users</div>
							<div class="dash-counts">
								<p><?=$count_users->count?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content container-fluid">
	<div class="row">
		<div class="card">
			<div class="card-body p-3">
				<h5>Recent Orders</h5>

				<table class="table table-hover table-striped mt-3">
				  <thead class="table-light">
				    <tr>
				    	<th>SN</th>
				    	<th>Customer</th>
				    	<th>Date</th>
				    	<th>Amount</th>
				    	<th>Discount</th>
				    	<th>Paid</th>
				    	<th>Balance</th>
				    	<th>Status</th>
				    </tr>
				  </thead>
				  <tbody class="bg-white">
				  	<?php if(count($orders) == 0){ ?>
				    <tr>
				    	<td colspan="8" class="text-center text-muted">No transactions found for the dates specified</td>
				    </tr>
				    <?php } ?>
				    <?php foreach ($orders as $k => $v) { ?>
				    <tr>
				    	<td><?=$v['sn']?></td>
				    	<td><?=$v['customer']?></td>
				    	<td><?=$v['date']?></td>
				    	<td><?=$v['amount']?></td>
				    	<td><?=$v['discount']?></td>
				    	<td><?=$v['paid']?></td>
				    	<td><?=$v['balance']?></td>
				    	<?php 
				    	$status = "";
				    	if($v['status'] == "0") {
				    		$status = '<span class="badge small badge-pill bg-danger-light">Pending</span>';
				    	}else if($v['status'] == "1"){
				    		$status = '<span class="badge small badge-pill bg-warning-light">In-Progress</span>';
				    	}else if($v['status'] == "2"){
				    		$status = '<span class="badge small badge-pill bg-success-light">Ready</span>';
				    	}else{
				    		$status = '<span class="badge small badge-pill bg-secondary">Delivered</span>';
				    	}

				    	echo "<td>".$status."</td>";
			    		?>
				    	
				    </tr>
				    <?php } ?>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>