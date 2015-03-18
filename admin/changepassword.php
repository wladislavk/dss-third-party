<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/top.htm';?>

<?
include_once('../manage/admin/includes/password.php');

if($_POST['passsub'] == 1)
{

        $salt_sql = "SELECT salt FROM admin WHERE adminid='".s_for($_SESSION['adminuserid'])."'";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);

        $old_pass = gen_password($_POST['old_pass'], $salt_row['salt']);

	$chk_sql = "select * from admin where adminid='".s_for($_SESSION['adminuserid'])."' and password='".$old_pass."'";
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
		trigger_error("Die called", E_USER_ERROR);
	}
	else
	{


		$salt = create_salt();
		$new_pass = gen_password($_POST['new_pass'], $salt);

		$up_sql = "update admin set password='".$new_pass."', salt='".$salt."' where adminid='".s_for($_SESSION['adminuserid'])."'";
		mysql_query($up_sql);
		
		$msg="Password Changed Successfully.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>";
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
}
?>

<br />
<span class="admin_head">
	Change Password
</span>
<br /><br />

<br />
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
