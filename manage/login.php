<?
session_start();
require_once('admin/includes/config.php');
include_once('admin/includes/password.php');
$page_sql = "select * from dental_pages where status=1 and  pageid='".s_for($_GET['pid'])."'";
$page_my = mysql_query($page_sql);
$page_myarray = mysql_fetch_array($page_my);

if($_SESSION['loginid'] <> '')
{
$cur_page_full =  $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
$cur_ins_sql = "insert into dental_login_detail (loginid,userid,cur_page,adddate,ip_address) values('".$_SESSION['loginid']."','".$_SESSION['userid']."','".$cur_page_full."',now(),'".$_SERVER['REMOTE_ADDR']."')";
mysql_query($cur_ins_sql);
}

if(strpos($_SERVER['PHP_SELF'],'q_page') === false && strpos($_SERVER['PHP_SELF'],'ex_page') === false && strpos($_SERVER['PHP_SELF'],'q_sleep') === false && strpos($_SERVER['PHP_SELF'],'q_image') === false)
{
	$unload = 0 ;
}
else
{
	$unload = 1 ;
}

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
	$salt_sql = "SELECT salt FROM dental_users WHERE username='".mysql_real_escape_string($_POST['username'])."'";
	$salt_q = mysql_query($salt_sql);
	$salt_row = mysql_fetch_assoc($salt_q);

	$pass = gen_password($_POST['password'], $salt_row['salt']);
	
	$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."' and status=1";
	$check_my = mysql_query($check_sql);
	
	if(mysql_num_rows($check_my) == 1) 
	{
		$check_myarray = mysql_fetch_array($check_my);
		
		/*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($ins_sql);*/
		
		session_register("userid");
		session_register("username");
		session_register("name");
		session_register("user_access");
		session_register("docid");
		
		$_SESSION['userid']=$check_myarray['userid'];
		$_SESSION['username']=$check_myarray['username'];
		$_SESSION['name']=$check_myarray['name'];
		$_SESSION['user_access']=$check_myarray['user_access'];
		if($check_myarray['docid'] != 0)
		{
			$_SESSION['docid']=$check_myarray['docid'];
		}
		else
		{
			$_SESSION['docid']=$check_myarray['userid'];
		}
		$_SERVER['QUERY_STRING'];
		$ins_sql = "insert into dental_login (docid,userid,login_date,ip_address) values('".$_SESSION['docid']."','".$_SESSION['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($ins_sql);
		
		$ins_id = mysql_insert_id();
		
		$_SESSION['loginid']=$ins_id;
		
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
<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
    <tr bgcolor="#FFFFFF">
        <td colspan="2" class="t_head">
	       Please Enter Your Login Information 
        </td>
    </tr>
	<? if($_GET['msg']!="")
    {
    ?> 
        <tr bgcolor="#FFFFFF">
            <td colspan="2" >
                <span class="red">
					<?=$_GET['msg'];?>
                </span>
            </td>
        </tr>
    <? }?>
    <tr bgcolor="#FFFFFF">
        <td class="t_data">
        	User name
        </td>
        <td class="t_data">
        	<input type="text" name="username">
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
            <a style="float:right; margin-top:4px;" href="forgot_password.php">Forgot Password</a>
        </td>
    </tr>
</table>
</FORM>
</div>
<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>
</body>
</html>
