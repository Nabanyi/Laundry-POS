<div class="page-header">
	<div class="row align-items-center">
		<div class="col">
			<h3 class="page-title">Audit Logs</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a> </li>
				<li class="breadcrumb-item active">Audit</li>
			</ul>
		</div>
		<div class="col-auto">
			<div class="dropdown d-inline">
				<a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-share"></i> Export</a>

				<div class="dropdown-menu dropdown-menu-left">
					<a class="dropdown-item" id="excelExport" href="javascript:void(0);"><i class="fa fa-file-excel"></i> Excel Format</a>
					<a class="dropdown-item" id="pdfExport" href="javascript:void(0);"><i class="fa fa-file-pdf"></i> Pdf Format</a>
					<a class="dropdown-item" id="csvExport" href="view-estimate.html"><i class="fa fa-file-csv"></i> CSV Format</a>
					<a class="dropdown-item" id="printExport" href="javascript:void(0);"><i class="fa fa-print me-2"></i> Print</a>
				</div>
			</div>

			<a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
				<i class="fas fa-filter"></i>
			</a>
		</div>
	</div>
</div>

<div id="filter_inputs" class="col-md-6 offset-md-6">
	<div class="card filter-card">
		<div class="card-body pb-0">
			<div class="row">
				<div id="msg"></div>
				<form id="filter_form">
				<div class="col-sm-12">
					<div class="form-group">
						<label>User</label>
						<select class="form-control" id="filter_staff_id" name="staff_id[]" multiple="multiple">
							<?php foreach ($users as $user): ?>
								<option value="<?=$user->staff_id?>"><?=$user->username?></option>
							<?php endforeach ?>?>
						</select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Action</label>
						<select class="custome-select form-control" name="action" id="action" required>
							<option>Select...</option>
							<option value="All">All</option>
							<option value="READ">Read</option>
							<option value="EDIT">Edit</option>
							<option value="CREATE">Create</option>
							<option value="DELETE">Delete</option>
						</select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Date Range</label>
						<div class="input-group mb-3">
						  	<input type="text" class="form-control datetimepicker" name="fromDate" id="fromDate">
						  	<span class="input-group-text">to</span>
						   	<input type="text" class="form-control datetimepicker" name="toDate" id="toDate" >
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<button class="btn btn-primary" id="search_btn" type="submit">
							<i class="fa fa-search"></i> Search
						</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="example_wrapper" class="d-none">
    <div class="col-sm-12"></div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="card card-table">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-center table-hover" id="dataTable">
						<thead class="thead-light">
							<tr>
								<th>Staff</th>
								<th>Action</th>
								<th>Page</th>
								<th>Date</th>
								<th class="text-end">Actions</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>												
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewDetailModal" tabindex="-1" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
	    <div class="modal-body p-5">
	    	<button type="button" class="btn-close mb-3" data-bs-dismiss="modal" aria-label="Close"></button>
	      	
	      	<div class="d-flex justify-content-between">
	      		<h1 class="text-center">Audit Log</h1>
	      		<button class="btn btn-primary align-self-center" id="printAuditBtn"> <i class="fas fa-print"></i> </button>
	      	</div>

	      	<div id="content" class="d-flex gap-3">
	      		
	      		
	      	</div>
	    </div>
    </div>
  </div>
</div>