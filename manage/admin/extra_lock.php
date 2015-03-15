<?php namespace Ds3\Libraries\Legacy; ?><!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.1.1
Version: 2.0.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Extra - Lock Screen</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="admin/template/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="admin/template/assets/css/pages/lock.css" rel="stylesheet" type="text/css"/>
<link href="admin/template/assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<style>
.dental_logo{
	
	padding-left:263px;
	padding-top:206px;
}


</style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>

<?php

//session_start();
include('includes/main_include.php');
include_once('includes/password.php');

	$id1=$_SESSION['adminuserid'];
	$address=$_REQUEST['addr'];
	$address=$_REQUEST['addr'];
	$check_sql = "SELECT * FROM admin WHERE adminid=".$id1;
	$check_my = mysql_query($check_sql) or die(mysql_error().' | '.$check_sql);
	$check = mysql_fetch_assoc($check_my);


if (isset($_POST['lock_submit'])) {
	
	 $pass = gen_password($_POST['password'], $check['salt']);
	 if($check['password']==$pass){ ?>
		<script type="text/javascript">
			var addrr="<?php echo $address; ?>";
            window.location.replace(addrr);
        </script>
            <?php
            die();
        }
	else{ 
		 echo "<script type='text/javascript'>
    			var id_val=".intval($id1)."	</script>";
		?> 
        <script type="text/javascript">
			
            window.location.replace('extra_lock.php?id='+id_val+'&&msg=Wrong+password');
        </script>
            <?php
            die();
        }
	
}


?>
 <div class="dental_logo">
		<a href="/manage/admin/home.php">
	 
            <h1 class="pull-left" style="color:#ffffff;font-size:25px; margin:12px;">Dental Sleep <span style="color:#ff0000;">Solutions</span></h1>
        </a>
 </div>
<div class="page-lock">
	
	<div class="page-logo">
		<a class="brand" href="index.php">
			<!--<img src="admin/template/assets/img/logo-big.png" alt="logo"/>-->
			 
			
		</a>
	</div>
	<div class="page-body">
		<img class="page-lock-img" src="images/DSS_logo_notext_transparent_SQUARE_250x250.png" alt="">
		<div class="page-lock-info" style="margin-top:20px;">
			<h1><?php echo $check['first_name'];?> <?php echo $check['last_name']; ?></h1>
			<span class="email"style="word-wrap:break-word;" >
				<?php  echo $check['email'];  ?>
			</span>
			<span class="locked">
				 Locked
			</span>
			<form class="form-inline" action="" method="post" name="lock_form">
				<div class="input-group input-medium">
					<input type="password" class="form-control" name="password" placeholder="Password">
					<span class="input-group-btn">
						<button type="submit" name="lock_submit" class="btn blue icn-only"><i class="m-icon-swapright m-icon-white"></i></button>
					</span>
				</div>
				<!-- /input-group -->
				<div class="relogin">
					<a href="index.php" style="color:#FFFFFF;">
						 Not <?php echo $check['first_name'];  echo $check['last_name']; ?> ?
					</a>
				</div>
			</form>
		</div>
	</div>
	<div class="page-footer" style="color: #FFFFFF;font-size: 14px;">
		 	2014 &copy; dentalsleepsolutions.com
	</div>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="admin/template/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="admin/template/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="admin/template/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="admin/template/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="admin/template/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="admin/template/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="admin/template/assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="admin/template/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="admin/template/assets/plugins/backstretch/jquery.backstretch.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="admin/template/assets/scripts/core/app.js"></script>
<script src="admin/template/assets/scripts/custom/lock.js"></script>
<script>
jQuery(document).ready(function() {    
   App.init();
   Lock.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
