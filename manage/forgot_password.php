<?
require_once('admin/includes/config.php');
include_once('admin/includes/password.php');


?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />

</head>
<body onload="document.getElementById('future_dental_det').style.display = 'none';parent.frames[0].document.getElementById('hideshow1').style.display='block';parent.frames[0].document.getElementById('hideshow2').style.display='none';parent.frames[0].document.getElementById('hideshow3').style.display='none';parent.frames[0].document.getElementById('hideshow4').style.display='none';parent.frames[0].document.getElementById('hideshow5').style.display='none';">

<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
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

if($_POST["emailsub"] == 1)
{
	$check_sql = "SELECT userid FROM dental_users WHERE email='".mysql_real_escape_string($_POST['email'])."'";
	$check_my = mysql_query($check_sql);
	
	if(mysql_num_rows($check_my) == 1) 
	{
		$check_myarray = mysql_fetch_array($check_my);
		
		/*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($ins_sql);*/
		$recover_hash = hash('sha256', $check_myarray['userid'].$_POST['email'].rand());
		$ins_sql = "UPDATE dental_users set recover_hash='".$recover_hash."', recover_time=NOW() WHERE userid='".$check_myarray['userid']."'";
		mysql_query($ins_sql);
		
		//$ins_id = mysql_insert_id();
		
		
		?>
		<script type="text/javascript">
			alert("<?= $ins_sql; ?>");
			//window.location.replace('login.php?msg=Email sent');
		</script>
		<?
		die();
	}
	else
	{
		$msg='Email not found';
		?>
		<script type="text/javascript">
			window.location.replace('forgot_password.php?msg=<?=$msg;?>');
		</script>
		<?
		die();
	}
}
?>
<br />
<span class="admin_head">
	Forgot Password
</span>
<br />
<br />
<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
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


<? include 'includes/bottom.htm';?>
