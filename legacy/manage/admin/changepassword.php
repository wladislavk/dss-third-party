<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/top.htm';?>

<?
include_once('includes/password.php');

if(!empty($_POST['passsub']) && $_POST['passsub'] == 1)
{
        $salt_sql = "SELECT salt FROM admin WHERE adminid='".s_for($_SESSION['adminuserid'])."'";
        $salt_q = mysqli_query($con,$salt_sql);
        $salt_row = mysqli_fetch_assoc($salt_q);

        $old_pass = gen_password($_POST['old_pass'], $salt_row['salt']);
	$chk_sql = "select * from admin where adminid='".s_for($_SESSION['adminuserid'])."' and password='".$old_pass."'";
	$chk_my = mysqli_query($con,$chk_sql);
	
	if(mysqli_num_rows($chk_my) == 0)
	{
		$msg = "Incorrect Old Password, Please Try Again.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
			window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>";
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
	else
	{
                $salt = create_salt();
                $new_pass = gen_password($_POST['new_pass'], $salt);

                $up_sql = "update admin set password='".mysqli_real_escape_string($con,$new_pass)."', salt='".$salt."' where adminid='".s_for($_SESSION['adminuserid'])."'";
		mysqli_query($con,$up_sql);
		
		$msg="Password Changed Successfully.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
			window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>";
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
}
?>

<div class="page-header">
	<h2>Change Password <small>- 
<?php
 $a_sql = "SELECT * FROM admin WHERE adminid='".$_SESSION['adminuserid']."'";
 $a_q = mysqli_query($con,$a_sql);
 $a_r = mysqli_fetch_assoc($a_q);
 echo $a_r['username']; 
?>
</small></h2></div>
<br /><br />

<br /><br />
<div align="center" class="red">
	<?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?>
</div>
		
<form name="passfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return passabc(this)">
<table class="table table-bordered table-hover">
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
			<input type="submit" value=" Change Password " class="btn btn-warning">
		</td>
	</tr>
</table>
</form>


<?php include 'includes/bottom.htm';?>
