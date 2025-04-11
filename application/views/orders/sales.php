<div class="page-header">
	<div class="row align-items-center">
		<div class="col">
			<h3 class="page-title">Sales</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a> </li>
				<li class="breadcrumb-item active">Sales</li>
			</ul>
		</div>
	</div>
</div>

<style>
	#salesHolder{
		height: calc(100vh - 300px);
		overflow: auto;
	}
</style>

<div class="d-flex gap-3 mb-3">
	<div class="input-group">
		<span class="input-group-text"><i class='fa fa-calendar'></i></span>
	    <input type="text" class="form-control datepicker" id="fromdate" name="fromdate" placeholder="From date">
	    <span class="input-group-text">to</span>
	    <input type="text" class="form-control datepicker" id="todate" name="todate" placeholder="To date">
	</div>

	<select class="form-control" name="type" id="type">
	  <option value="All" selected>All Order Types</option>
	  <option value="Paid">Fully Paid Orders</option>
	  <option value="Partailly">Partially paid Orders</option>
	  <option value="Overpaid">Overpaid Orders</option>
	</select>

	<button class="btn btn-primary" id="search_btn" type="button">Search</button>
</div>

<div id="salesHolder" class="border">
	<table class="table table-hover table-striped">
	  <thead class="table-light">
	    <tr>
	    	<th>SN</th>
	    	<th>Customer</th>
	    	<th>Date</th>
	    	<th>Amount</th>
	    	<th>Discount</th>
	    	<th>Paid</th>
	    	<th>Balance</th>
	    	<th>Action</th>
	    </tr>
	  </thead>
	  <tbody class="bg-white">
	    <tr>
	    	<td colspan="8" class="text-center text-muted">No transactions found for the dates specified</td>
	    </tr>
	  </tbody>
	</table>
</div>
<div id="tableInfo" class="d-flex gap-3 mt-3">
	<p>Total Amount: 0.00</p>
	<p>Discount Given: 0.00</p>
	<p>Amount Paid :0.00</p>
	<p>Balance :0.00</p>
</div>

<!-- Order Details -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="modal-body" id="detailsbody">
               
            </div>
            <div class="text-center modal-footer">
            <button class="btn btn-primary printbtn"><i class="fa fa-print"></i></button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content p-4">
            <div class="modal-body">
            	<h2>Receive Payment</h2>
               <form id="receivePayments">
               	<div class="form-group">
               		<label for="">Total Amount:</label>
               		<input type="text" id="total_amount" class="form-control" readonly>
               	</div>

               	<div class="form-group">
               		<label for="">Discount:</label>
               		<input type="text" id="discount" class="form-control" readonly>
               	</div>

               	<div class="form-group">
               		<label for="">Amount Paid:</label>
               		<input type="text" id="paid" class="form-control" readonly>
               	</div>

               	<div class="form-group">
               		<label for="">Balance:</label>
               		<input type="text" id="balance" class="form-control" readonly>
               	</div>

               	<div class="form-group">
               		<label for="">Amount Paying:</label>
               		<input type="hidden" name="orderid" id="orderid">
               		<input type="number" id="amount" name="amount" value="0" class="form-control" step="0.01" required>
               	</div>
               	<div class="form-group">
               		<button class="btn btn-primary" id="submit" type="submit">Accept Payment</button>
               		<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
               	</div>
               </form>
            </div>
        </div>
    </div>
</div>