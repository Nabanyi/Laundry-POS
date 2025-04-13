<?php
if ($this->session->userdata('user_id') == false) {
	redirect(base_url('/login'));
	die();
}
$CI =& get_instance();
$CI->load->model('settings_model');
$owner = $CI->settings_model->get_company();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title?> - <?=$owner->name?></title>
	<meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
    <link href="<?=base_url()?>assets/img/favicon.png" rel="shortcut icon">
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">

    <!-- JS, Popper.js, and jQuery -->
    <script src="<?=base_url()?>assets/js/js/helper.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/jquery-3.6.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/printThis.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/xlsx.core.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/FileSaver.min.js"></script>
    <script src="<?=base_url()?>assets/js/plugin/tableexport.js"></script>
</head>
<body>
	
	<div class="container">
		<?php $this->load->view($page, $title); ?>
	</div>

	<center><span style="font-size: 12px;color: #808080;"> SIKA Accounting Software V3.0.1 - ROPAT SYSTEMS LTD</span></center>
</body>
</html>