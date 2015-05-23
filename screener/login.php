<?
session_start();
require_once('../manage/admin/includes/main_include.php');
include_once('../manage/admin/includes/password.php');

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?></title>
<link href="css/login.css" rel="stylesheet" type="text/css" />

</head>
<body> 


<?php

if($_POST["loginsub"] == 1)
{
	$salt_sql = "SELECT salt FROM dental_users WHERE username='".mysqli_real_escape_string($con, $_POST['username'])."'";
	$salt_q = mysqli_query($con, $salt_sql);
	$salt_row = mysqli_fetch_assoc($salt_q);

	$pass = gen_password($_POST['password'], $salt_row['salt']);
	
	$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysqli_real_escape_string($con, $_POST['username'])."' and password='".$pass."' and status=1";
	$check_my = mysqli_query($con, $check_sql);
	
	if(mysqli_num_rows($check_my) == 1) 
	{
		$check_myarray = mysqli_fetch_array($check_my);

		$_SESSION['screener_user']=$check_myarray['userid'];
	        if($check_myarray['docid'] != 0)
                {
                        $_SESSION['screener_doc']=$check_myarray['docid'];
                }
                else
                {
                        $_SESSION['screener_doc']=$check_myarray['userid'];
                }	
		?>
		<script type="text/javascript">
			window.location.replace('index.php');
		</script>
		<?
		die();
	}
	else
	{
		$msg='Wrong username or password';
		?>
		<script type="text/javascript">
			window.location.replace('login.php?msg=<?=$msg;?>');
		</script>
		<?
		die();
	}
}
?>
<div id="login_container">
  <h1>Dental Sleep Solutions</h1>
  <div class="login_content" id="login_sect">
    <h2>Screener Tool</h2>
    <?php if($login_error){ ?>
      <span class="error">
        Error! Wrong email address or password.
      </span>
    <?php } ?>
    <?php if($_GET['activated']==1){ ?>
      <span class="success">
        Account created! Please login below.
      </span>

    <?php } ?>
      <FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>

    <div class="field">
      <label>Username</label>
      <input type="text" tabindex="1" name="username" >
    </div>

    <div class="field">
      <label>Password</label>
      <input type="password" tabindex="2" name="password">
    </div>

    <div class="field">
            <input type="hidden" name="loginsub" value="1">
      <button type="submit" name="loginbut" class="large">Log In</button>
    </div>
        </form>
  </div>
</div>

<div style="clear:both;"></div>
<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>
</body>
</html>
