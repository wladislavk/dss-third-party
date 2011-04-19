<?php include 'includes/top.htm';?>

<?
if($_POST['passsub'] == 1)
{
	$chk_sql = "select * from admin where adminid='".s_for($_SESSION['adminuserid'])."' and password='".s_for($_POST['old_pass'])."'";
	$chk_my = mysql_query($chk_sql);
	
	if(mysql_num_rows($chk_my) == 0)
	{
		$msg="Incorrect Old Password, Please Try Again.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>";
		</script>
		<?
		die();
	}
	else
	{
		$up_sql = "update admin set password='".s_for($_POST['new_pass'])."' where adminid='".s_for($_SESSION['adminuserid'])."'";
		mysql_query($up_sql);
		
		$msg="Password Changed Successfully.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>";
		</script>
		<?
		die();
	}
}
?>

<span class="admin_head">
	Change Password
</span>
<br /><br />

<br /><br />
<div align="center" class="red">
	<? echo $_GET['msg'];?>
</div>
		
<form name="passfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onsubmit="return passabc(this)">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr>
		<td colspan="2" class="cat_head">
			Change Password
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td valign="top" class="frmhead" width="30%">
			Old Password	
		</td>
		<td valign="top" class="frmdata">
			<input type="password" name="old_pass" value="" class="tbox" /> 
			<span class="red">*</span>				
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td valign="top" class="frmhead">
			New Password	
		</td>
		<td valign="top" class="frmdata">
			<input type="password" name="new_pass" value="" class="tbox" /> 
			<span class="red">*</span>				
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td valign="top" class="frmhead">
			Re-Enter New Password	
		</td>
		<td valign="top" class="frmdata">
			<input type="password" name="re_pass" value="" class="tbox" /> 
			<span class="red">*</span>				
		</td>
	</tr>
	<tr>
		<td  colspan="2" align="center">
			<span class="red">
				* Compulsory					
			</span><br />
			<input type="hidden" name="passsub" value="1" />
			<input type="submit" value=" Change Password " class="button" />
		</td>
	</tr>
</table>
</form>


<? include 'includes/bottom.htm';?>