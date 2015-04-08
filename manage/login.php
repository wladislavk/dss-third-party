<?php
include('admin/includes/main_include.php');
include('admin/includes/password.php');
//$page_sql = "select * from dental_pages where status=1 and  pageid='".s_for($_GET['pid'])."'";
//$page_my = mysqli_query($con, $page_sql);
//$page_myarray = mysqli_fetch_array($page_my);

if(!empty($_SESSION['loginid']))
{
	$cur_page_full =  $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
	$cur_ins_sql = "insert into dental_login_detail (loginid,userid,cur_page,adddate,ip_address) values('".$_SESSION['loginid']."','".$_SESSION['userid']."','".$cur_page_full."',now(),'".$_SERVER['REMOTE_ADDR']."')";
	$db->query($cur_ins_sql);
}

if(strpos($_SERVER['PHP_SELF'],'q_page') === false && strpos($_SERVER['PHP_SELF'],'ex_page') === false && strpos($_SERVER['PHP_SELF'],'q_sleep') === false && strpos($_SERVER['PHP_SELF'],'q_image') === false)
{
	$unload = 0 ;
}
else
{
	$unload = 1 ;
}

if(isset($_POST["loginsub"]))
{
	$salt_sql = "SELECT salt FROM dental_users WHERE username='".mysqli_real_escape_string($con, $_POST['username'])."'";
	$salt_row = $db->getRow($salt_sql);

	$pass = gen_password($_POST['password'], $salt_row['salt']);

	$check_sql = "SELECT dental_users.userid, username, name, first_name, last_name, user_access, status, 
				CASE docid
					WHEN 0 THEN dental_users.userid
					ELSE docid
				END as docid,
			user_type, uc.companyid FROM dental_users 
			LEFT JOIN dental_user_company uc ON uc.userid=(
				CASE docid
                                        WHEN 0 THEN dental_users.userid
                                        ELSE docid
                                END)
			where username='".mysqli_real_escape_string($con, $_POST['username'])."' and password='".$pass."' and status in (1, 3)";
	
	$check_myarray = $db->getRow($check_sql);

	if(!empty($check_myarray)) 
	{
		if($check_myarray['status']=='3'){
			$msg='This account has been suspended.';
		}else{
			/*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
			mysqli_query($con, $ins_sql);*/
			
			$_SESSION['userid']=$check_myarray['userid'];
			$_SESSION['username']=$check_myarray['username'];
			$_SESSION['name']=$check_myarray['first_name']." ".$check_myarray['last_name'];
			$_SESSION['user_access']=$check_myarray['user_access'];
			$_SESSION['companyid']=$check_myarray['companyid'];

			if($check_myarray['docid'] != 0)
			{
				$_SESSION['docid']=$check_myarray['docid'];
				$ut_sql = "SELECT user_type FROM dental_users WHERE userid='".mysqli_real_escape_string($con, $check_myarray['docid'])."'";
	 			$ut_r = $db->getRow($ut_sql);
				$_SESSION['user_type']=$ut_r['user_type'];
			}
			else
			{
				$_SESSION['docid']=$check_myarray['userid'];
				$_SESSION['user_type']=$check_myarray['user_type'];
			}

			$_SERVER['QUERY_STRING'];
			$ins_sql = "insert into dental_login (docid,userid,login_date,ip_address) values('".$_SESSION['docid']."','".$_SESSION['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";

			$ins_id = $db->getInsertId($ins_sql);
			
			$_SESSION['loginid']=$ins_id;
		
			header('Location: index.php');
			die();
		}
	}
	else
	{
		$msg='Wrong username or password';
	}
}

if(!empty($_GET['msg']))
{ 
	$msg = $_GET['msg'];
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $sitename;?></title>
<link href="css/login.css" rel="stylesheet" type="text/css" />

</head>
<body> 

<!--[if lte IE 7]>
<div id="alert_container">
  This application does not support old versions of IE.<br />For best performance please use Chrome, Firefox or IE8+
</div>
<![endif]-->


<div id="login_container">
	<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
		<table border="0" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
		    <tr bgcolor="#FFFFFF">
		        <td colspan="2" class="t_head">
			       Please Enter Your Login Information 
		        </td>
		    </tr>
			<?php
			if(!empty($msg)){
		    ?> 
		        <tr bgcolor="#FFFFFF">
		            <td colspan="2" >
		                <span class="red">
							<?php echo $msg;?>
		                </span>
		            </td>
		        </tr>
		    <?php
			}
			?>
		    <tr bgcolor="#FFFFFF">
		        <td class="t_data">
		        	User name
		        </td>
		        <td class="t_data">
		        	<input type="text" name="username" value="<?php echo (isset($_POST['username']))?$_POST['username']:''; ?>">
		        </td>
		    </tr>
		    <tr bgcolor="#FFFFFF">
		        <td class="t_data">
		        	Password
		        </td>
		        <td class="t_data">
		        	<input type="password" name="password">
		        </td>
			</tr>
		    <tr bgcolor="#FFFFFF">
		        <td colspan="2" align="center" >
		            <input type="hidden" name="loginsub" value="1">
		            <input type="submit" name="btnsubmit" value=" Login " class="addButton">
				<span style="float:right;">
		            <a href="register/new.php">Register</a>
				|
		            <a href="forgot_password.php">Forgot Password</a>
				</span>
		        </td>
		    </tr>
		</table>
		<span style="float:right; margin-top:4px;" class="screener">Looking for the screener? <a href="../screener">Click Here</a></span>
	</FORM>
</div>
<span style="clear:both;" id="siteseal">
	<script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
	<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a>
</span>
<div style="clear:both;"></div>
</body>
</html>
