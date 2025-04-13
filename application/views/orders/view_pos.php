<?php
if ($this->session->userdata('user_id') == false) {
	redirect(base_url('login'));
	die();
}
$CI =& get_instance();
$CI->load->model('users_model');
$owner = $CI->users_model->get_company();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	 <meta charset="utf-8">
	<title><?=$title?> - <?=$owner->name?></title>
	<meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
    <link href="<?=base_url()?>assets/img/favicon.png" rel="shortcut icon">
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/jquery-ui.css" type="text/css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    
	<!-- Load css -->
	<?php if (isset($css)):
		foreach ($css as $css):
	?>
	<link rel="stylesheet" type="text/css" href="<?=base_url($css)?>">
	<?php
		endforeach;
		endif; 
	?>
    <!-- <link rel="stylesheet" href="<?=base_url()?>assets/css/app.css"> -->

    <style>
        .page-wrapper2{
            margin-top: 70px;
        }

        .fade-text {
            opacity: 0.1;
        }

        .cursor-pointer{
            cursor: pointer;
        }

        #itemsWrapper{
            height: calc(100vh - 65px);
            overflow-y: auto;
        }

        .item{
            padding: 10px;
            border: 1px solid #eee;
            cursor: pointer;
        }

    </style>
</head>
<body class="nk-body bg-lighter npc-default has-sidebar no-touch nk-nio-theme">
	<!-- <div id="pageLoader"></div> -->
	<script type="text/javascript">
		let base_url = "<?=base_url();?>";
	</script>

    <div class="main-wrapper">

    	<div class="header header-one">
            <div class="header-left header-left-one">
                <a class="logo" href="<?=base_url()?>">
                    <img alt="Logo" src="<?=base_url('assets/img/company-logo.png')?>">
                    </img>
                </a>
                <a class="white-logo" href="<?=base_url()?>">
                    <img alt="Logo" src="<?=base_url('assets/img/company-logo.png')?>">
                    </img>
                </a>
                <a class="logo logo-small" href="<?=base_url()?>">
                    <img alt="Logo" height="30" src="<?=base_url('assets/img/company-logo.png')?>" width="30">
                    </img>
                </a>
            </div>
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-bars">
                </i>
            </a>
            <div class="top-nav-search">
                <form>
                    <input class="form-control" placeholder="Search here" type="text">
                        <button class="btn" type="submit">
                            <i class="fas fa-search">
                            </i>
                        </button>
                    </input>
                </form>
            </div>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars">
                </i>
            </a>
            <ul class="nav nav-tabs user-menu">

                <li class="nav-item">
                    <a href="<?=base_url('orders')?>">Orders</a>
                </li>
                
                <li class="nav-item dropdown has-arrow main-drop">
                    <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#">
                        <span class="user-img">
                            <img alt="" src="<?=base_url()?>assets/img/male_avatar.png">
                                <span class="status online">
                                </span>
                            </img>
                        </span>
                        <span>
                            <?=$this->session->userdata('username')?>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.html">
                            <i class="me-1" data-feather="user">
                            </i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="<?=base_url('login/logout')?>">
                            <i class="me-1" data-feather="log-out">
                            </i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <div class="page-wrapper2">
            <div class="content container-fluid">
                <div class="d-flex gap-2">
                    <div class="col-md-6" id="itemsWrapper">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" id="sortItems" class="form-control" placeholder="Start typing product name">
                                
                                <div class="mt-3 row" id="itemsList">
                                    <?php foreach($items as $item){ ?>
                                    <div class="col-md-6 col-lg-4 item" 
                                        data-itemname="<?=$item->name?>" 
                                        data-itemprice="<?=$item->price?>" 
                                        data-itemid="<?=$item->id?>"
                                        >
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?=base_url("assets/uploads/".$item->image)?>" width="50" height="50" class="rounded" alt="...">
                                            </div>
                                            <div class="flex-grow-1 ms-3 align-self-center">
                                                <h6><?=$item->name?></h6>
                                                <small><?=number_format($item->price, 2)?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form id="prepare_form">
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-1">
                                        <div class="invoice-add-table">
                                            <div class="table-responsive">
                                                <table class="table table-center table-hover add-table-items">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 35%"> Items </th>
                                                            <th style="width: 30%"> Quantity </th>
                                                            <th style="width: 15%"> Price </th>
                                                            <th style="width: 10%"> Total Amount </th>
                                                            <th style="width: 5%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td id="total_amount">Total:0.00</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Discount</td>
                                                            <td> <input type="number" name="discount" id="discount" class="form-control" value="0" placeholder="10"> <span class="text-muted">Eg, 10, 12</span> </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Amount Paid</td>
                                                            <td> <input type="number" name="amount_paid" id="amount_paid" class="form-control" value="0" placeholder="0"> </td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <label for="customerautocomplete" class="col-md-2 align-self-center">Customer</label>
                                        <div class="col-md-8">
                                            <div id="autocompleteWrapper">
                                                <input type="text" class="form-control" id="customerautocomplete" name="customername" placeholder="customer name, phone, email...">
                                                <input type="hidden" class="form-control" id="customerid" name="customerid">
                                            </div>

                                            <div id="newClientWrapper" style="display: none">
                                                <input type="text" class="form-control" id="clientname" name="clientname" placeholder="Customer name">
                                                <input type="text" class="form-control mt-2" id="clientphone" name="clientphone" placeholder="Customer phone">
                                                <input type="email" class="form-control mt-2" id="clientemail" name="clientemail" placeholder="Customer email">
                                                <input type="date" class="form-control mt-2" id="clientdob" name="clientdob" placeholder="Date of birth">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-8 offset-md-2">
                                            <p id="addNewClient" class="text-primary cursor-pointer my-1">+ customer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="text-center">
                                    <button class="btn btn-primary button" type="submit">Create Order</button>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PRINT/VIEW -->
    <div class="modal fade" id="printSalesModal" tabindex="-1" aria-labelledby="printSalesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="printArea">
                    <div class="row">
                        <div class="col-sm-12">

                            <h4 class="text-center">OFFICIAL RECEIPT</h4>

                            <div id="printresult">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                   <button class="btn btn-primary printbtn"><i class="fa fa-print"></i></button>
                </div>
            </div>
        </div>
    </div>

	<!-- JS, Popper.js, and jQuery -->
    <script src="<?=base_url()?>assets/js/plugin/jquery-3.6.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/jquery-ui-1.9.2.custom.min.js" ></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/printThis.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/feather.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <?php if (isset($js)) {
		foreach ($js as $js) {
	?>
	<script type="text/javascript" charset="utf8" src="<?=base_url($js)?>"></script>
	<?php
		}
	}  ?>
	<script src="<?=base_url()?>assets/js/plugin/script.js"></script>
	<!-- /. Main JS Files -->
</body>
</html>