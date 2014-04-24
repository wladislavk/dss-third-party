<?php
//session_start();
include('includes/main_include.php');
include_once('includes/password.php');
       //echo $pass = gen_password('admin', $salt_row['salt']);

if (isset($_POST["loginsub"])) {
	
    if ($_POST['security_code'] == $_SESSION['security_code']) {
    //if (1) {
        $salt_sql = "SELECT salt FROM admin WHERE username='".mysql_real_escape_string($_POST['username'])."' AND status=1";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);
        
		$pass = gen_password($_POST['password'], $salt_row['salt']);
        $check_sql = "SELECT a.*, ac.companyid  FROM admin a
            LEFT JOIN admin_company ac ON a.adminid = ac.adminid
            where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."'";
        
        //$check_my = mysql_query($check_sql) or die(mysql_error().' | '.$check_sql);
        	$con = mysql_connect('localhost', 'root', 'root') or die('connection failure');	
			$db = mysql_select_db('dentalsl_main_skin');
        
        $check_my = mysql_query($check_sql) or die(mysql_error().' | '.$check_sql);
        
        if (mysql_num_rows($check_my) == 1) { 
            $check_myarray = mysql_fetch_array($check_my);
            
            $_SESSION['adminuserid']=$check_myarray['adminid'];
            $_SESSION['admin_access']=$check_myarray['admin_access'];
            $_SESSION['admincompanyid']=$check_myarray['companyid'];
            
            ?>
        <script type="text/javascript">
            window.location.replace('home.php');
        </script>
            <?php
            die();
        }
        else { ?>
        <script type="text/javascript">
            window.location.replace('index.php?msg=Wrong+username+or+password');
        </script>
            <?php
            die();
        }
    }
    else { ?>
        <script type="text/javascript">
            window.location.replace('index.php?msg=Incorrect+security+code');
        </script>
        <?php
        die();
    }
}

?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
		<!-- BEGIN LOGO -->
<div class="logo">
	<h1  style="color:#ffffff;font-size:20px; margin:9px;">Dental Sleep <span style="color:#ff0000;">Solutions</span></h1>
</div>
<!-- END LOGO -->

<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>" class="login-form"  onsubmit="return loginabc(this)" novalidate="novalidate">
		<?php if (isset($_GET['msg'])) { ?>
		<div class="alert alert-danger text-center">
			<strong><?= $_GET['msg'] ?></strong>
		</div>
	
	
     <?php } ?>
		<h3 class="form-title">Login to your account</h3>
		
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<!--<label class="control-label visible-ie8 visible-ie9">Username</label>-->
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input type="text" name="username" placeholder="Username" autocomplete="off" id="username" class="form-control placeholder-no-fix">
			</div>
		</div>
		<div class="form-group">
			<!--<label class="control-label visible-ie8 visible-ie9">Password</label>-->
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
			<!--<label for="captcha" class="col-md-3 control-label">Captcha</label>-->
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input type="text" class="form-control" name="security_code" id="captcha" placeholder="write the characters in the image">
			</div>
		</div>
		<div class="form-actions" style="margin-left:-35px;">
			<label class="checkbox">
			<div class="checker"><span><input type="checkbox" value="1" name="remember"></span></div> Remember me </label>
			<button type="submit" class="btn blue pull-right" name="loginsub" >Login
			<i class="m-icon-swapright m-icon-white"></i>
		</div>
		
		<div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				 no worries, click
				<a id="forget-password" href="/manage/admin/forgot_password.php">
					 here
				</a>
				 to reset your password.
			</p>
		</div>
		<div class="create-account">
			<p>
				 Don't have an account yet ?&nbsp;
				<a id="register-btn" href="javascript:;">
					 Create an account
				</a>
			</p>
		</div>
	</form>
</div>	
			
		
	<!-- END LOGIN FORM -->
		
	<div class="copyright">
	 2014 &copy; dentalsleepsolutions.com
</div>  

<?php //require_once dirname(__FILE__) . '/includes/bottom.htm'; ?>
