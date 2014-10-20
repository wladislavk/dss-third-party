<?
require_once('admin/includes/main_include.php');
include_once('admin/includes/password.php');
include_once('includes/constants.inc');

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?php echo st($page_myarray['keywords']);?>" />
<title><?php echo $sitename;?></title>
<link href="css/login.css" rel="stylesheet" type="text/css" />

</head>
<body>

<?php

if($_POST["emailsub"] == 1){
	$check_sql = "SELECT userid, username, email FROM dental_users WHERE email='".mysql_real_escape_string($_POST['email'])."'";
	$check_myarray = $db->getRow($check_sql);
	
	if($check_myarray) {
		/*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($ins_sql);*/
		$recover_hash = hash('sha256', $check_myarray['userid'].$_POST['email'].rand());
		$ins_sql = "UPDATE dental_users set recover_hash='".$recover_hash."', recover_time=NOW() WHERE userid='".$check_myarray['userid']."'";
		$db->query($ins_sql);
	
		$headers = 'From: Dental Sleep Solutions <patient@dentalsleepsolutions.com>' . "\r\n" .
					'Content-type: text/html' ."\r\n" .
					'Reply-To: patient@dentalsleepsolutions.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
	
		$subject = "Dental Sleep Solutions Password Reset";
		$message = "Please use this link to reset your password.
<br /><br />
http://".$_SERVER['HTTP_HOST']."/manage/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash;
		$message .= "<br /><br />";
		$message .= DSS_EMAIL_FOOTER;
		//$ins_id = mysql_insert_id();
		$msg = mail($check_myarray['email'], $subject, $message, $headers);
		
		?>
		<script type="text/javascript">
			//alert("<?php echo  $msg; ?>");
			window.location.replace('login.php?msg=Email sent');
		</script>
		<?php
		die();
	} else {
		$msg='Email address not found';
		?>
		<script type="text/javascript">
			window.location.replace('forgot_password.php?msg=<?php echo $msg;?>');
		</script>
		<?php
		die();
	}
}
?>
<div id="login_container">
<FORM NAME="loginfrm" METHOD="POST" ACTION="<?php echo $_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
	<table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
		<tr bgcolor="#FFFFFF">
			<td colspan="2" class="t_head">
				Forgot Password 
			</td>
		</tr>

		<?php if($_GET['msg']!=""){?> 
	        <tr bgcolor="#FFFFFF">
	            <td colspan="2" >
	                <span class="red">
						<?php echo $_GET['msg'];?>
	                </span>
	            </td>
	        </tr>
	    <?php }?>
	    <tr bgcolor="#FFFFFF">
	        <td class="t_data">
	        	E-mail
	        </td>
	        <td class="t_data">
	        	<input type="text" name="email">
	        </td>
	    </tr>
	    <tr bgcolor="#FFFFFF">
	        <td colspan="2" align="center">
	            <input type="hidden" name="emailsub" value="1">
	            <input type="submit" name="btnsubmit" value="Recover Password" class="addButton">
	        </td>
	    </tr>
	</table>
</FORM>
</div>

