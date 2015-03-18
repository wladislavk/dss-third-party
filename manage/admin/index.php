<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include 'includes/main_include.php';
	include_once 'includes/password.php';
	include_once '../includes/constants.inc';

	if(!empty($_POST["emailsub"]) && $_POST["emailsub"] == 1) {
        $check_sql = "SELECT adminid, username, email FROM admin WHERE email='".mysqli_real_escape_string($con,$_POST['email'])."'";
        
        $check_my = $db->getResults($check_sql);
        if(count($check_my) >= 1) {
            $check_myarray = $check_my[0];
            $recover_hash = hash('sha256', $check_myarray['adminid'].$_POST['email'].rand());
            $ins_sql = "UPDATE admin set recover_hash='".$recover_hash."', recover_time=NOW() WHERE adminid='".$check_myarray['adminid']."'";
            
            $db->query($ins_sql);

            $headers = 'From: SWsupport@dentalsleepsolutions.com' . "\r\n" .
					   'Content-type: text/html' ."\r\n" .
                	   'Reply-To: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                 	   'X-Mailer: PHP/' . phpversion();

            $subject = "Dental Sleep Solutions Password Reset";
            $message = "Please use this link to reset your password.<br /><br />
						<a href=\"http://".$_SERVER['HTTP_HOST']."/manage/admin/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash."\">
						http://".$_SERVER['HTTP_HOST']."/manage/admin/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash."
						</a>";
			$message .= "<br /><br />";
			$message .= DSS_EMAIL_FOOTER;
            $msg = mail($check_myarray['email'], $subject, $message, $headers);
?>
            <script type="text/javascript">
                window.location.replace('index.php?msg=Email sent');
            </script>
<?php             trigger_error("Die called", E_USER_ERROR);
        } else {
            $msg = 'Email address not found';
?>
            <script type="text/javascript">
                window.location.replace('index.php?msg=<?php echo  $msg;?>');
            </script>
<?php             trigger_error("Die called", E_USER_ERROR);
        }
	}

	if (isset($_POST["loginsub"])) {
		
	    if ($_POST['security_code'] == $_SESSION['security_code']) {
	        $salt_sql = "SELECT salt FROM admin WHERE username='".mysqli_real_escape_string($con,$_POST['username'])."' AND status=1";
	        
	        $salt_row = $db->getRow($salt_sql);

	        $pass = gen_password($_POST['password'], $salt_row['salt']);

	        $check_sql = "SELECT a.*, ac.companyid  FROM admin a
	            		  LEFT JOIN admin_company ac ON a.adminid = ac.adminid
	            		  where username='".mysqli_real_escape_string($con,$_POST['username'])."' and password='".$pass."'";
	        
	        $check_my = $db->getResults($check_sql);
       
	        if (count($check_my) == 1) {
	            $check_myarray = $check_my[0];
	            
	            $_SESSION['adminuserid'] = $check_myarray['adminid'];
	            $_SESSION['admin_access'] = $check_myarray['admin_access'];
            	$_SESSION['admincompanyid'] = $check_myarray['companyid'];
            
?>
		        <script type="text/javascript">
		            window.location.replace('home.php');
		        </script>
<?php             	trigger_error("Die called", E_USER_ERROR);
        	} else {
?>
		        <script type="text/javascript">
		            window.location.replace('index.php?msg=Wrong+username+or+password');
		        </script>
<?php             	trigger_error("Die called", E_USER_ERROR);
        	}
    	} else {
?>
	        <script type="text/javascript">
	            window.location.replace('index.php?msg=Incorrect+security+code');
	        </script>
<?php         	trigger_error("Die called", E_USER_ERROR);
    	}
	}
?>

<?php include_once dirname(__FILE__) . '/includes/login_top.htm'; ?>
	<!-- BEGIN LOGO -->
	<div class="logo">
		<h1  style="color:#ffffff;font-size:30px; margin:9px;">Dental Sleep <span style="color:#187eb7;">Solutions</span></h1>
	</div>
	<!-- END LOGO -->

	<div class="content">
		<!-- BEGIN LOGIN FORM -->
		<?php if (isset($_GET['msg'])) { ?>
			<div class="alert alert-danger text-center">
				<strong><?php echo $_GET['msg'] ?></strong>
			</div>
		<?php } ?>
	
		<form name="loginfrm" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return loginabc(this)" class="login-form form-horizontal">
			<h3 class="form-title">Login to your DS3 account</h3>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input type="text" name="username" placeholder="Username" autocomplete="off" id="username" class="form-control placeholder-no-fix">
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input type="password" name="password" placeholder="Password" id="password" autocomplete="off" class="form-control placeholder-no-fix">
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon">
					<img src="../CaptchaSecurityImages.php?width=100&amp;height=40&amp;characters=5" style="margin-bottom:5px;" width="100" height="40" alt="If you cannot see the captcha, reload the page please">
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input type="text" class="form-control" name="security_code" id="captcha"  placeholder="write the characters in the image">
				</div>
			</div>
			<div class="form-actions" style="margin-left:-35px;">
				<input type="hidden" name="loginsub" value="1" />
				<button type="submit" class="btn blue pull-right" name="loginbut" >Login
				<i class="m-icon-swapright m-icon-white"></i>
			</div>
			<div class="forget-password">
				<h4>Forgot your password ?</h4>
				<p>no worries, click <a id="forget-password" href="javascript:;">here</a>
				 to reset your password.
				</p>
			</div>
		</form>
		<form class="forget-form" action="index.php" method="post">
			<h3>Forget Password ?</h3>
			<p>Enter your e-mail address below to reset your password.</p>
			<div class="form-group">
				<div class="input-icon">
					<i class="fa fa-envelope"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
					<input type="hidden" name="emailsub" value="1" />
				</div>
			</div>
			<div class="form-actions">
				<button type="button" id="back-btn" class="btn">
				<i class="m-icon-swapleft"></i> Back </button>
				<button type="submit" class="btn blue pull-right">
				Submit <i class="m-icon-swapright m-icon-white"></i>
				</button>
			</div>
		</form>
	</div>	
	
	<!-- END LOGIN FORM -->
		
	<div class="copyright">2014 &copy; dentalsleepsolutions.com</div>  

<?php //require_once dirname(__FILE__) . '/includes/bottom.htm'; ?>
