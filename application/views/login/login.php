<?php
if ($this->session->userdata('user_id') != '') {
	redirect(base_url('dashboard'));
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
        <title> Login </title>
        <link href="<?=base_url()?>assets/img/favicon.png" rel="shortcut icon">
        <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
            
    </head>
    <body>
    	<script type="text/javascript">
			let base_url = "<?=base_url();?>";
		</script>
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
                <div class="container">
                    <img alt="Logo" class="logo-dark mb-2" src="<?=base_url('assets/img/company-logo.png')?>" width="100">
                        <div class="loginbox">
                            <div class="login-right">
                                <div class="login-right-wrap">
                                    <h1> Login </h1>
                                    <form id="loginForm">
                                    	<div id="msg"></div>
                                        <div class="form-group">
                                            <label class="form-control-label">Username</label>
                                            <input class="form-control" name="username" id="username" type="text" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label"> Password </label>
                                            <div class="pass-group">
                                                <input class="form-control pass-input" type="password" name="password" id="password" required />
                                                <span class="fas fa-eye toggle-password"></span>
                                            </div>
                                        </div>
                                        
                                        <button id="login_btn" class="btn btn-lg btn-block btn-primary w-100" type="submit"> Login </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </img>
                </div>
            </div>
        </div>
        <script src="<?=base_url()?>assets/js/plugin/jquery-3.6.0.min.js"></script>
        <script src="<?=base_url()?>assets/js/plugin/bootstrap.bundle.min.js"> </script>
        <script src="<?=base_url()?>assets/js/plugin/feather.min.js"> </script>
        <script src="<?=base_url()?>assets/js/plugin/script.js"> </script>
        <script src="<?=base_url()?>assets/js/js/login/login.js"> </script>
    </body>
</html>