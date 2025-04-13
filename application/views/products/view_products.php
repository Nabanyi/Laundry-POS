<div class="page-header">
	<div class="row align-items-center">
		<div class="col">
			<h3 class="page-title">Products</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a> </li>
				<li class="breadcrumb-item active">Products</li>
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

			<a class="btn btn-primary filter-btn" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addProductModal">
				<i class='fa fa-plus'></i> Product
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
								<th>Product</th>
								<th>SKU</th>
								<th>Price</th>
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

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-4">
            <div class="modal-body">
            	<h2 class="modal-title text-center">Add Product</h2>

                <form id="productForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" class="form-control" name="sku" placeholder="Enter product SKU">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter product price" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image" accept="image/png, image/jpeg" required>
                    </div>
                    <div class="form-group text-center">
                    	<button type="submit" id="addBtn" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-4">
            <div class="modal-body">
            	<h2 class="modal-title text-center">Update Product</h2>

                <form id="updateForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter product SKU">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter product price" step="0.01" required>
                    </div>
                    
                    <div class="form-group text-center">
                    	<button type="submit" id="editBtn" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
