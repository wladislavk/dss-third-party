<?
session_start();
include('includes/config.php');
include_once('../manage/admin/includes/password.php');

if($_POST["loginsub"] == 1)
{
	$salt_sql = "SELECT salt FROM admin WHERE username='".mysql_real_escape_string($_POST['username'])."'";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);	

        $pass = gen_password($_POST['password'], $salt_row['salt']);
	$check_sql = "SELECT * FROM admin where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."'";
	$check_my = mysql_query($check_sql) or die(mysql_error().' | '.$check_sql);
	
	if(mysql_num_rows($check_my) == 1) 
	{
		$check_myarray = mysql_fetch_array($check_my);
		
		session_register("adminuserid");
		$_SESSION['adminuserid']=$check_myarray['adminid'];
		?>
		<script type="text/javascript">
			window.location.replace('home.php');
		</script>
		<?
		die();
	}
	else
	{
		$msg='Wrong username or password';
		?>
		<script type="text/javascript">
			window.location.replace('index.php?msg=<?=$msg;?>');
		</script>
		<?
		die();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin </title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>
<table width="980" align="center"  border="0" cellpadding="0" cellspacing="0" class="main_bor">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" class="header_bg"> 
		<?=$site_name;?>
	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="351" valign="middle" align="center">
    	
        <? if($_GET['msg']!="")
			{
		 	?> 
                <span class="red">
                    <b><?=$_GET['msg'];?></b>
                </span>
		 <? }?>
		<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
      		<table width="40%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
			<tr bgcolor="#FFFFFF">
			  <td colspan="2" class="cat_head">
				<B>Admin Login</B>			 
              </td>
			</tr>
			<tr bgcolor="#FFFFFF">
			  	<td class="frmhead">
					User name
				</td>
			  	<td class="frmdata">
			  		<input type="text" name="username" class="tbox">
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
			 	<td class="frmhead">
					Password
				</td>
			  	<td class="frmdata">
			  		<input type="password" name="password" class="tbox">
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td colspan="2" align="center">
					<input type="hidden" name="loginsub" value="1">
					<input type="submit" name="btnsubmit" value=" Login " class="button">
				</td>
			</tr>
		  </table>
    	</FORM>
	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" align="center" class="bottom_bg">
    	&copy; <?=$site_url;?>
    </td>
  </tr>
</table>
</BODY>
</HTML>
