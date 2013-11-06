<?
//session_start();
include('includes/main_include.php');
include_once('includes/password.php');
if(isset($_POST["loginsub"]))
{
  if($_POST['security_code']==$_SESSION['security_code']){
        $salt_sql = "SELECT salt FROM admin WHERE username='".mysql_real_escape_string($_POST['username'])."' AND status=1";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);
      
        $pass = gen_password($_POST['password'], $salt_row['salt']);

	$check_sql = "SELECT a.*, ac.companyid  FROM admin a 
		LEFT JOIN admin_company ac ON a.adminid = ac.adminid
		where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."'";
	$check_my = mysql_query($check_sql) or die(mysql_error().' | '.$check_sql);
	
	if(mysql_num_rows($check_my) == 1) 
	{
		$check_myarray = mysql_fetch_array($check_my);
		
		$_SESSION['adminuserid']=$check_myarray['adminid'];
                $_SESSION['admin_access']=$check_myarray['admin_access'];
		$_SESSION['admincompanyid']=$check_myarray['companyid'];
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
  }else{
                $msg='Incorrect Security Code';
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
		DENTAL SLEEP SOLUTIONS
	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="351" valign="middle" align="center">
    	
        <? if(isset($_GET['msg']))
			{
		 	?> 
                <span class="red">
                    <b><?=$_GET['msg'];?></b>
                </span>
		 <? }?>
		<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
      		<table width="50%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
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
            <tr bgcolor="#ffffff">
			 	<td class="frmhead">&nbsp;
					
				</td>
			  	<td class="frmdata">
			  		<img src="../CaptchaSecurityImages.php?width=100&amp;height=40&amp;characters=5">
				</td>

			</tr>
			<tr bgcolor="#ffffff">
			 	<td class="frmhead">
					Write the characters in the image above
				</td>
			  	<td class="frmdata">
			  		<input name="security_code" type="text" class="tbox">
				</td>
			</tr>

			<tr bgcolor="#FFFFFF">
				<td colspan="2" align="center">
					<input type="hidden" name="loginsub" value="1">
					<input type="submit" name="btnsubmit" value=" Login " class="button">
					<a href="forgot_password.php">Forgot Password</a>
				</td>
			</tr>
		  </table>
    	</FORM>
	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" align="center" class="bottom_bg">&copy; dentalsleepsolutions.com

<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>

</td>
  </tr>
</table>
</BODY>
</HTML>
