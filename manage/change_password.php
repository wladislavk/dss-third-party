<?php include 'admin/includes/config.php';

if($_SESSION['userid'] == '')
{
	?>
	<script type="text/javascript">
		alert("Members Area, Please Login");
		window.close();
	</script>
	<?
	die();
}

if($_POST['passsub'] == 1)
{
	$chk_sql = "select * from dental_users where userid='".s_for($_SESSION['userid'])."' and password='".s_for($_POST['old_pass'])."'";
	$chk_my = mysql_query($chk_sql);
	
	if(mysql_num_rows($chk_my) == 0)
	{
		$msg="Incorrect Old Password, Please Try Again.";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>";
		</script>
		<?
		die();
	}
	else
	{
		$up_sql = "update dental_users set password='".mysql_real_escape_string($_POST['new_pass'])."' where userid='".s_for($_SESSION['userid'])."'";
		mysql_query($up_sql);
		
		$msg="Password Changed Successfully.";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>";
		</script>
		<?
		die();
	}
}
?>

<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<link href="css/admin.css" rel="stylesheet" type="text/css" />

<form name="passfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return passabc(this)">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td colspan="2" align="center" class="red">
			<b><? echo $_GET['msg'];?></b>
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
