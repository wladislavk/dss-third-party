<?
require_once('includes/main_include.php');
include_once('includes/password.php');

?>

<?php //require_once dirname(__FILE__) . '/includes/top.htm'; ?>

<script type="text/javascript">
$(document).ready(function(){
  document.getElementById('future_dental_det').style.display = 'none';
  parent.frames[0].document.getElementById('hideshow1').style.display = 'block';
  parent.frames[0].document.getElementById('hideshow2').style.display = 'none';
  parent.frames[0].document.getElementById('hideshow3').style.display = 'none';
  parent.frames[0].document.getElementById('hideshow4').style.display = 'none';
  parent.frames[0].document.getElementById('hideshow5').style.display = 'none';
});
</script>

<table width="980" border="0" cellpadding="1" cellspacing="1" align="center">
<!-- Header and nav goes here -->
  <tr>
    <td colspan="2" align="right" > 
	
	</td>
  </tr>
  <tr>
	<td valign='top' height="400">
	<div style="float:right;margin-right:20px;margin-top:8px;">
  
  <div style="text-align:center; float:left;width:50px; color:#00457c; padding-right:20px;"><a style="color:#00457c;text-decoration:none;" href="index.php" target="_self"><img border="0" src="images/homeIcon.png"><br />Home</a></div>

  <div style="text-align:center;float:right;width:50px;margin-top:7px;"><div><a style="color:#00457c;text-decoration:none;" href="#" target="_self">Login Below</div>

  </div>

  
  
  </div>

  
  
  
  <div style="height:116px; width:980px; background:url(images/dss_01.png) #0b5c82 no-repeat top left;"><div style="font-size:24px; font-weight:bold; font-family:arial; color:#FFFFFF; padding-top:20px; margin-left:20px;">Dental Sleep Solutions &reg;<font style="color:#000; font-size:14px; font-weight:bolder;padding-left:110px;font-style:italic;">Practice Management</font></div>
     
    <div style="margin-top:30px; margin-left:20px; float:left;">
    </div>
    
     <div style="clear:both;"></div>
  </div>
  <div style="height:40px; background:url(images/dss_03.jpg) #0b5c82 repeat-y top left;width:100%;"><div style="width:98.6%; background:#00457c;margin:0 auto;"><div class="suckertreemenu">
<br style="clear: left;" />
</div>
</div>
<div style="clear:both;"></div>
</div>


<div style="background:url(images/dss_03.jpg) repeat-y top left #FFFFFF;" id="contentMain">
<div style="clear:both;"></div>

 
 

<?php
	if($_POST['recoversub']==1){
		if($_POST['password1']==$_POST['password2']){
			$salt = create_salt();
                        $pass = gen_password($_POST['password1'], $salt);
			$up_sql = "UPDATE admin SET password='".$pass."', salt='".$salt."', recover_hash='' WHERE adminid='".mysqli_real_escape_string($con, $_POST['adminid'])."' AND recover_hash='".mysqli_real_escape_string($con, $_POST['hash'])."'";
			mysqli_query($con, $up_sql);
			?>
                <script type="text/javascript">
                        //alert("<?= $check_myarray['userid']; ?>");
                        window.location.replace('index.php?msg=Password reset');
                </script>
                <?
		}
	}
	$check_sql = "SELECT adminid FROM admin WHERE username='".mysqli_real_escape_string($con, $_GET['un'])."' AND recover_hash='".mysqli_real_escape_string($con, $_GET['rh'])."' AND recover_time>DATE_SUB(NOW(), INTERVAL 1 HOUR)";
	$check_my = mysqli_query($con, $check_sql);
	if(mysqli_num_rows($check_my) == 1) 
	{
		$check_myarray = mysqli_fetch_array($check_my);
		
		//$recover_hash = hash('sha256', $check_myarray['userid'].$_POST['email'].rand());
		//$ins_sql = "UPDATE dental_users set recover_hash='".$recover_hash."', recover_time=NOW() WHERE userid='".$check_myarray['userid']."'";
		//mysqli_query($con, $ins_sql);
		
		//$ins_id = mysqli_insert_id($con);
		
		
		?>
		<script type="text/javascript">
			//alert("<?= $check_myarray['userid']; ?>");
			//window.location.replace('login.php?msg=Email sent');
		</script>
		<?
	}
	else
	{
		$msg='Unable to find user.';
		?>
		<script type="text/javascript">
			//alert("<?= $msg; ?>");
			window.location.replace('forgot_password.php?msg=<?=$msg;?>');
		</script>
		<?
	}
?>
<br />
<div class="page-header">
	Reset Password
</div>
<br />
<br />
<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="hash" value="<?= $_GET['rh']; ?>" />
<input type="hidden" name="adminid" value="<?= $check_myarray['adminid']; ?>" />
<table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
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
        	Password	
        </td>
        <td class="t_data">
        	<input type="password" name="password1">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td class="t_data">
                Re-type Password        
        </td>
        <td class="t_data">
                <input type="password" name="password2">
        </td>
    </tr>

    <tr bgcolor="#FFFFFF">
        <td colspan="2" align="center">
            <input type="hidden" name="recoversub" value="1">
            <input type="submit" name="btnsubmit" value="Reset Password" class="btn btn-success">
        </td>
    </tr>
</table>
</FORM>

<?php require_once dirname(__FILE__) . '/includes/bottom.htm'; ?>
