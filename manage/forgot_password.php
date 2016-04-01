<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('admin/includes/main_include.php');
include_once('admin/includes/password.php');
include_once('includes/constants.inc');

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="keywords" content="<?php echo st(!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : '');?>" />
    <title><?php echo $sitename;?></title>
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
</head>
<body>

<?php

if(!empty($_POST["emailsub"]) && $_POST["emailsub"] == 1){
	$check_sql = "SELECT userid, username, email, first_name, last_name
		FROM dental_users
		WHERE email = '" . $db->escape($_POST['email']) . "'";
	$check_myarray = $db->getRow($check_sql);
	
	if($check_myarray) {
		$recover_hash = hash('sha256', $check_myarray['userid'].$_POST['email'].rand());
		$db->query("UPDATE dental_users
			SET recover_hash = '$recover_hash', recover_time = NOW()
			WHERE userid = '" . intval($check_myarray['userid']) . "'");

		$from = 'Dental Sleep Solutions <patient@dentalsleepsolutions.com>';
		$to = "{$check_myarray['first_name']} {$check_myarray['last_name']} <{$check_myarray['email']}>";
		$subject = 'Dental Sleep Solutions Password Reset';
		$template = getTemplate('patient/recover-password');

		$check_myarray['recover_hash'] = $recover_hash;
		sendEmail($from, $to, $subject, $template, $check_myarray);
		
		?>
		<script type="text/javascript">
			window.location.replace('login.php?msg=Email sent');
		</script>
		<?php
		trigger_error("Die called", E_USER_ERROR);
	} else {
		$msg='Email address not found';
		?>
		<script type="text/javascript">
			window.location.replace('forgot_password.php?msg=<?php echo $msg;?>');
		</script>
		<?php
		trigger_error("Die called", E_USER_ERROR);
	}
}
?>
<div id="login_container">
<FORM NAME="loginfrm" METHOD="POST" ACTION="<?php echo $_SERVER['PHP_SELF']?>">
	<table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
		<tr bgcolor="#FFFFFF">
			<td colspan="2" class="t_head">
				Forgot Password 
			</td>
		</tr>

		<?php if(!empty($_GET['msg'])){?> 
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

