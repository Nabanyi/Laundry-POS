<div class="page-header">
	<div class="row align-items-center">
		<div class="col">
			<h3 class="page-title">System Users</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a> </li>
				<li class="breadcrumb-item active">Users</li>
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

			<a class="btn btn-primary filter-btn" href="javascript:void(0);" id="add_new_user_btn">
				<i class='fa fa-plus'></i> User
			</a>
		</div>
	</div>
</div>

<div id="add_new_user_wrapper" class="col-md-12" style="display: none;">
	<div class="card filter-card">
		<div class="card-body pb-0">
			<div class="row">
				<div id="msg"></div>
				<form id="addForm">
					<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label>Firstname</label>
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" required>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label>Middlename</label>
							<input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middlename">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Lastname</label>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label>Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label>Role</label>
							<select class="form-select" name="role" id="role" required>
								<option value="" disabled>Choose...</option>
								<option value="ADMIN">Admin</option>
								<option value="USER">User</option>
							</select>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label>Phone</label>
							<input type="number" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
						</div>
					</div>
					
					<div class="col-sm-12">
						<div class="form-group">
							<button class="btn btn-primary" id="add_btn" type="submit"> Add User </button>
						</div>
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
								<th>Username</th>
								<th>Type</th>
								<th>Last Login</th>
								<th>Status</th>
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