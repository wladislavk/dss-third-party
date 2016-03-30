<?php namespace Ds3\Libraries\Legacy; ?><?php
	include 'admin/includes/main_include.php';

	if($_SESSION['userid'] == '') {
?>
		<script type="text/javascript">
			alert("Members Area, Please Login");
			window.close();
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}

	if(!empty($_POST['passsub']) && $_POST['passsub'] == 1) {
		$chk_sql = "select * from dental_users where userid='".s_for($_SESSION['userid'])."' and password='".s_for($_POST['old_pass'])."'";
		
		if($db->getNumberRows($chk_sql) == 0) {
			$msg="Incorrect Old Password, Please Try Again.";
?>
			<script type="text/javascript">
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>";
			</script>
<?php
			trigger_error("Die called", E_USER_ERROR);
		} else {
			$up_sql = "update dental_users set password='".mysqli_real_escape_string($con, $_POST['new_pass'])."' where userid='".s_for($_SESSION['userid'])."'";
			
			$db->query($up_sql);
			$msg = "Password Changed Successfully.";
?>
			<script type="text/javascript">
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>";
			</script>
<?php
			trigger_error("Die called", E_USER_ERROR);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
	<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
	<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="script/validation.js"></script>
</head>
<body>
<form name="passfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onSubmit="return passabc(this)">
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<tr>
			<td colspan="2" align="center" class="red">
				<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : ''); ?></b>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="cat_head">
				Change Password
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td valign="top" class="frmhead" width="40%">
				Old Password
			</td>
			<td valign="top" class="frmdata">
				<input type="password" name="old_pass" value="" class="tbox_2" /> 
				<span class="red">*</span>				
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td valign="top" class="frmhead">
				New Password
			</td>
			<td valign="top" class="frmdata">
				<input type="password" name="new_pass" value="" class="tbox_2" /> 
				<span class="red">*</span>				
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td valign="top" class="frmhead">
				Confirm New Password
			</td>
			<td valign="top" class="frmdata">
				<input type="password" name="re_pass" value="" class="tbox_2" /> 
				<span class="red">*</span>				
			</td>
		</tr>
		<tr>
			<td  colspan="2" align="center">
				<span class="red">
					* Required Fields		
				</span><br />
				<input type="hidden" name="passsub" value="1" />
				<input type="submit" value=" Submit " class="button" />
			</td>
		</tr>
		<tr>
			<td  colspan="2" align="center">
				<a href="Javascript: window.close();"><b>CLOSE WINDOW</b></a>
			</td>
		</tr>
	</table>
</form>
</body>
</html>
