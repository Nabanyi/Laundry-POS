<div class="page-header">
	<div class="row align-items-center">
		<div class="col">
			<h3 class="page-title">Orders</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a> </li>
				<li class="breadcrumb-item active">Orders</li>
			</ul>
		</div>
		<div class="col-auto">
			<a class="btn btn-primary filter-btn" href="<?=base_url('pos')?>">
				<i class='fa fa-plus'></i> Order
			</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Orders Pending</h5>
                <?php foreach ($pending as $k => $v) { ?>                
				<div data-orderid="<?=$v['orderid']?>" class="alert alert-danger cursor-pointer order-item" role="alert">
				    <h4 class="alert-heading">#<?=$v['orderid']?></h4>
				    <h5 class="small"><?=$v['customer']?></h5>
				    <p class="ellipsis-text"><?=$v['product']?></p>
				    <hr>
				    <p class="mb-0"><?=$v['days']?> &bull; GH <?=number_format($v['amount'], 2)?></p>
				</div>
				<?php } ?>
				<?php if(count($pending) == 0){?>
					<p class="text-muted">No data in this folder</p>
				<?php }?>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Orders In-Progress</h5>
				<?php foreach ($progress as $k => $v) { ?> 
				<div data-orderid="<?=$v['orderid']?>" class="alert alert-warning cursor-pointer order-item" role="alert">
				    <h4 class="alert-heading">#<?=$v['orderid']?></h4>
				    <h5 class="small"><?=$v['customer']?></h5>
				    <p class="ellipsis-text"><?=$v['product']?></p>
				    <hr>
				    <p class="mb-0"><?=$v['days']?> &bull; GH <?=number_format($v['amount'], 2)?></p>
				</div>
				<?php } ?>

				<?php if(count($progress) == 0){?>
					<p class="text-muted">No data in this folder</p>
				<?php }?>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Orders Ready</h5>
				<?php foreach ($ready as $k => $v) { ?> 
				<div data-orderid="<?=$v['orderid']?>" class="alert alert-success cursor-pointer order-item" role="alert">
				    <h4 class="alert-heading">#<?=$v['orderid']?></h4>
				    <h5 class="small"><?=$v['customer']?></h5>
				    <p class="ellipsis-text"><?=$v['product']?></p>
				    <hr>
				    <p class="mb-0"><?=$v['days']?> &bull; GH <?=number_format($v['amount'], 2)?></p>
				</div>
				<?php } ?>

				<?php if(count($ready) == 0){?>
					<p class="text-muted">No data in this folder</p>
				<?php }?>
			</div>
		</div>
	</div>
</div>

<!-- Order Details -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="modal-body" id="detailsbody">
               
            </div>
        </div>
    </div>
</div>

<?php
$activator = ($this->session->userdata('role') == 'ADMIN') ? '' : 'd-none';
?>
<script>
	const activator = "<?=$activator?>";
</script>