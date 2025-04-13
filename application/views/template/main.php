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
    
    <style>
        .sidebar {
            background-color: #005960;
            overflow: auto;
        }
        .sidebar ul li a{
            color: #669ba0;
        }

        .sidebar ul li a.active{
            color: #ffffff;
        }

        .sidebar ul li.active{
            color: #ffffff !important;
            background-color: #002426;
        }

        .sidebar-menu li.active > a {
            color: #ffffff;
        }

        .sidebar-menu ul li a:hover {
            background-color: #002426;
            color: #fff;
        }
        .small{
            font-weight: 200;
        }

        .text-primary, .dropdown-menu>li>a.text-primary {
            color: rgba(13, 110, 253, 1)!important;
        }
        .bg-primary {
            --bs-bg-opacity: 1;
            background-color: rgba(13, 110, 253, 1)!important
        }

        .bank-details-btn .btn {
            min-width: 160px;
            border-radius: 8px;
            padding: 10px 0;
            color: #fff
        }

        .bank-details-btn .bank-save-btn {
            background: #005960
        }
        .bank-details-btn .bank-save-btn:hover {
            background: #1b2559
        }

        .bg-gray-500{
            background-color: #adb5bd;
        }

        .cursor-pointer{
            cursor: pointer;
        }

        .btn-circle{
            background-color: #e6e6e6;
            border-radius: 50%;
            color: #000;
            padding: 10px;
            cursor: pointer;
            transition: transform 500ms;
        }

        .btn-circle:hover {
            color: #fff !important;
            background-color: #005960;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15)!important;
        }

        .btn-outline-primary:checked {
            color: #fff;
            background-color: #005960;
            border-color: #005960;
        }

        .btn-check:checked + .btn-outline-primary {
            color: #fff;
            background-color: #005960;
            border-color: #005960;
        }

        .btn-outline-primary:focus {
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(0, 89, 96, 0.25)
        }

        .form-check-input:focus {
            border-color: #80acb0;
            outline: none;
            box-shadow: 0 0 0 .25rem rgba(0, 89, 96, 0.25)
        }
        .form-check-input:checked {
            background-color: #005960;
            border-color: #005960
        }

        .rotate-90{
            transform: rotate(90deg);
        }

        .secondary-btn {
          background: #1b2559;
          margin-right: 10px;
        }

        .secondary-btn {
          color: #fff;
          border-radius: 8px;
        }

        .text-blue{
            color: #005960;
        }

        .object{
            width: 80%!important;
            height: 100%!important;
            position: absolute;
            top: 0;
            left: 20%;
            bottom: 0;
        }
        .objectImg{
            position: absolute;
            top: 0;
            left: 20%;
            max-width: 80%;
            height: auto
        }
        .pdf{
            border: 1px solid red;
            border-radius: 10px;
            height: 45px;
            width: 100px;
            display: block;
            align-content: center;
        }

        #printSheet{
            position: absolute;
            top: 70px;
            right: 0;
            left: 0;
            margin: 0 15px;
            display: none;
            z-index: 1000;
        }

        .select2-container .select2-selection--single {
            border: 1px solid #ddd;
            height: 50px;
            line-height: 25px;
            box-shadow: none;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 0;
            font-weight: 400;
            line-height: 2.2;
            color: #212529;
            outline: 0 !important;
        }
        .select2-container .select2-selection--single:focus{
           border:1px solid #ddd;
           box-shadow:none!important;
        }

        .button,
        .new-client-btn{
            height: 48px;
        }

        label {
            font-weight: 600;
            color: #1b2559;
        }

        .input-group .form-control,
        .form-control {
            height: 50px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
        }
        .form-control::placeholder {
            color: #8f9bba;
            font-weight: 400;
        }

        .ui-autocomplete {
            overflow-y: auto;
            height: 300px;
            overflow-x: hidden;
        }
        .text-blue{
            color: #005960;
        }

        .toast{
            z-index: 9998;
        }

        #dataTable td {
            white-space: normal;
        }

        .confirm{
            /* background-color: #005960 !important;*/
        }

        /*    My Modal    */
        .custom-screen {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1001; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: #fefefe;
            opacity: 0; /* Initially invisible */
            transition: opacity 0.3s ease; /* Smooth transition */
            transform: translateY(-50px);
            transition: transform 0.3s ease;
        }

        .custom-screen.show {
            display: block; /* Show modal */
            opacity: 1; /* Fully visible */
        }

        .custom-screen.show {
            transform: translateY(0); /* Slide-in effect */
        }

        .custom-screen .modal-header,
        .custom-screen .modal-footer {
            background: #fefefe;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            position: fixed;
            width: 100%;
            z-index: 1002;
        }

        .custom-screen .modal-header {
            top: 0;
        }

        .custom-screen .modal-footer {
            bottom: 0;
        }

        .screen-content {
            position: fixed;
            top: 69px;
            max-height: calc(100% - 147px); /* Adjust height to accommodate fixed header and footer */
            overflow-y: auto; /* Enable vertical scroll */
            background: #fefefe;
        }

        /* Custom class to increase spin speed */
        .bx-spin-fast {
            animation: bx-spin 0.8s infinite linear; /* Adjust the duration as needed */
        }

        /* Original bx-spin animation for reference */
        @keyframes bx-spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .tableexport-caption{
            display: none;
        }

        .bg-metro-teal {
            color:#fff!important;
            background-color:#00aba9!important
        }

        .bg-metro-dark-orange {
            color:#fff!important;
            background-color:#da532c!important
        }

        .bg-flat-wisteria {
            color:#fff!important;
            background-color:#8e44ad!important
        }

        .bg-deep-blue {
            color: #fff !important;
            background-color: #007AFF !important;
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
           <!--  <div class="top-nav-search">
                <form>
                    <input class="form-control" placeholder="Search here" type="text">
                        <button class="btn" type="submit">
                            <i class="fas fa-search">
                            </i>
                        </button>
                    </input>
                </form>
            </div> -->
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
                        <a class="dropdown-item" href="<?=base_url('profile')?>">
                            <i class="me-1" data-feather="user">
                            </i>
                            Account
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

        <?php $controller = $this->uri->segment(1);?>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div class="sidebar-menu" id="sidebar-menu">
                    <ul>
                        <?php if($this->session->userdata('role') == 'ADMIN'){ ?>
                    	<li class="<?=($title=='Dashboard') ? 'active' : '' ?>">
							<a href="<?=base_url()?>dashboard">
								<i data-feather="home"></i> 
								<span>Dashboard</span>
							</a>
						</li>
                        
                        <li class="<?=($title=='Users') ? 'active' : '' ?>">
                            <a href="<?=base_url()?>users">
                                <i data-feather="users"></i> 
                                <span>Users</span>
                            </a>
                        </li>

                        <li class="<?=($title=='Products') ? 'active' : '' ?>">
                            <a href="<?=base_url()?>products">
                                <i class="fa fa-pallet"></i> 
                                <span>Products</span>
                            </a>
                        </li>
                        
                        <li class="<?=($title=='Customers') ? 'active' : '' ?>">
                            <a href="<?=base_url()?>customers">
                                <i data-feather="users"></i> 
                                <span>Customers</span>
                            </a>
                        </li>
                        <?php } ?>

                        <li class="<?=($title=='Orders') ? 'active' : '' ?>">
                            <a href="<?=base_url()?>orders">
                                <i class='fa fa-archive'></i>
                                <span>Orders</span>
                            </a>
                        </li>

                        <li class="<?=($title=='POS') ? 'active' : '' ?>">
                            <a href="<?=base_url()?>pos">
                                <i class='fa fa-store'></i>
                                <span>POS</span>
                            </a>
                        </li>

                        <li class="<?=($title=='Sales') ? 'active' : '' ?>">
                            <a href="<?=base_url()?>sales">
                                <i class='fa fa-money-check-alt'></i>
                                <span>Sales</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <?php $this->load->view($page, $title); ?>
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