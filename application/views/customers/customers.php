<div class="page-header">
	<div class="row align-items-center">
		<div class="col">
			<h3 class="page-title">Customers</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a> </li>
				<li class="breadcrumb-item active">Customers</li>
			</ul>
		</div>
		<div class="col-auto">
			<div class="dropdown d-inline">
				<a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-share"></i> Export</a>

				<div class="dropdown-menu dropdown-menu-left">
					<a class="dropdown-item" id="excelExport" href="javascript:void(0);"><i class="fa fa-file-excel"></i> Excel Format</a>
					<a class="dropdown-item" id="pdfExport" href="javascript:void(0);"><i class="fa fa-file-pdf"></i> Pdf Format</a>
					<a class="dropdown-item" id="csvExport" href="javascript:void(0);"><i class="fa fa-file-csv"></i> CSV Format</a>
					<a class="dropdown-item" id="printExport" href="javascript:void(0);"><i class="fa fa-print me-2"></i> Print</a>
				</div>
			</div>

			<a class="btn btn-primary filter-btn" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addModal">
				<i class='fa fa-plus'></i> Customer
			</a>
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

<!-- Add Customer Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-4">
            
            <h2 class="modal-title text-center">Add Customer</h2>
            
            <div class="modal-body">
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

					<div class="col-sm-12">
						<div class="form-group">
							<label>Date of Birth</label>
							<input type="date" class="form-control" id="dob" name="dob" placeholder="YYYY-MM-DD" >
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label>Adress</label>
							<textarea type="text" class="form-control" id="address" name="address" placeholder="Address"></textarea>
						</div>
					</div>
					
					<div class="col-sm-12">
						<div class="form-group text-center">
	                    	<button type="submit" id="add_btn" class="btn btn-primary">Add Customer</button>
	                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	                    </div>
					</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-4">
            
            <h2 class="modal-title text-center">Update Customer</h2>
            
            <div class="modal-body">
               <form id="editForm">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Firstname</label>
								<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" required>
								<input type="hidden" name="customerid" id="customerid"/>
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

						<div class="col-sm-12">
							<div class="form-group">
								<label>Date of Birth</label>
								<input type="date" class="form-control" id="dob" name="dob" placeholder="YYYY-MM-DD" >
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label>Adress</label>
								<textarea type="text" class="form-control" id="address" name="address" placeholder="Address"></textarea>
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="form-group text-center">
		                    	<button type="submit" id="edit_btn" class="btn btn-primary">Save Changes</button>
		                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		                    </div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
