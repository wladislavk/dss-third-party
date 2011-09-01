<?
session_start();
include('includes/config.php');
include_once('includes/password.php');
if($_POST["emailsub"] == 1)
{
        $check_sql = "SELECT adminid, username, email FROM admin WHERE email='".mysql_real_escape_string($_POST['email'])."'";
        $check_my = mysql_query($check_sql);
	echo $check_sql;
        if(mysql_num_rows($check_my) >= 1)
        {
                $check_myarray = mysql_fetch_array($check_my);

                /*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
                mysql_query($ins_sql);*/
                $recover_hash = hash('sha256', $check_myarray['adminid'].$_POST['email'].rand());
                $ins_sql = "UPDATE admin set recover_hash='".$recover_hash."', recover_time=NOW() WHERE adminid='".$check_myarray['adminid']."'";
                mysql_query($ins_sql);

                $headers = 'From: dss@dentalsleepsolutions.com' . "\r\n" .
                    'Reply-To: dss@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Password Reset";
                $message = "Please use this link to reset your password.

http://".$_SERVER['HTTP_HOST']."/manage/admin/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash;
                //$ins_id = mysql_insert_id();
                $msg = mail($check_myarray['email'], $subject, $message, $headers);

                ?>
                <script type="text/javascript">
                        //alert("<?= $msg; ?>");
                        window.location.replace('index.php?msg=Email sent');
                </script>
                <?
                die();
        }
        else
        {
                $msg='Email address not found';
                ?>
                <script type="text/javascript">
                        //window.location.replace('forgot_password.php?msg=<?=$msg;?>');
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
    	
        <? if($_GET['msg']!="")
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
				<B>Admin Forgot Password</B>			 
              </td>
			</tr>
			<tr bgcolor="#FFFFFF">
			  	<td class="frmhead">
					Email	
				</td>
			  	<td class="frmdata">
			  		<input type="text" name="email" class="tbox">
				</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td colspan="2" align="center">
					<input type="hidden" name="emailsub" value="1">
					<input type="submit" name="btnsubmit" value=" Recover Password " class="button">
				</td>
			</tr>
		  </table>
    	</FORM>
	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" align="center" class="bottom_bg">&copy; dentalsleepsolutions.com</td>
  </tr>
</table>
</BODY>
</HTML>
