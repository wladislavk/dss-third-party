<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
require_once '../includes/constants.inc';
require_once 'includes/access.php';
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="../js/masks.js"></script>
<?php
if($_POST["usersub"] == 1)
{
        $sel_check2 = "select * from dental_users where email = '".s_for($_POST["email"])."' and userid <> '".s_for($_POST['ed'])."'";
        $query_check2=mysql_query($sel_check2);

	if(mysql_num_rows($query_check2)>0)
        {
                $msg="Email already exist. So please give another Email.";
                ?>
                <script type="text/javascript">
                        alert("<?=$msg;?>");
                        window.location="#add";
                </script>
                <?
        }
        else
	{

			$recover_hash = hash('sha256', $r['patientid'].$_POST['email'].rand());

			$ins_sql = "insert into dental_users set user_access=".DSS_USER_ACCESS_DOCTOR.",
				name = '".s_for($_POST["name"])."', 
				email = '".s_for($_POST["email"])."', 
				phone = '".s_for($_POST["phone"])."',
                                use_patient_portal = '".s_for($_POST['use_patient_portal'])."',
                                use_digital_fax = '".s_for($_POST['use_digital_fax'])."',
                                use_letters = '".s_for($_POST['use_letters'])."',
                                use_eligible_api = '".s_for($_POST['use_eligible_api'])."',
                                use_course = '".s_for($_POST['use_course'])."',
                                use_course_staff = '".s_for($_POST['use_course_staff'])."',
                                user_type = '".s_for($_POST['user_type'])."',
				status = '2',
				recover_hash='".$recover_hash."',
				recover_time=NOW(),
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
                        $userid = mysql_insert_id();			
                        $code_sql = "insert into dental_transaction_code (transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, docid, amount_adjust) SELECT transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, ".$userid.", amount_adjust FROM dental_transaction_code WHERE default_code=1";
                        mysql_query($code_sql) or die($code_sql.mysql_error());
                        $custom_sql = "insert into dental_custom (title, description, docid) SELECT title, description, ".$userid." FROM dental_custom WHERE default_text=1";
                        mysql_query($custom_sql) or die($custom_sql.mysql_error());
			
			if(is_super($_SESSION['admin_access'])){
			  mysql_query("INSERT INTO dental_user_company SET userid='".mysql_real_escape_string($userid)."', companyid='".mysql_real_escape_string($_POST["companyid"])."'");
			}else{
  			  mysql_query("INSERT INTO dental_user_company SET userid='".mysql_real_escape_string($userid)."', companyid='".mysql_real_escape_string($_SESSION["companyid"])."'");
			}		
		
			//send registration email.
  $m = "<html><body><center>
<table width='600'>
<tr><td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td></tr>
<tr><td width='400'>
<h2>Create your Software Account</h2>
<p>Welcome to the Dental Sleep Solutions&reg; Team! Please click the link below to activate your software account:
<p><a href='http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$userid."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$userid."&hash=".$recover_hash."</a></p>
</td><td width='200'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
<tr><td>
<h3>Need assistance?
Contact us at 877-95-SNORE or at<br>
Support@dentalsleepsolutions.com</b></h3></td></tr>
<tr><td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td></tr>
</table>
</center></body></html>
";
$m .= DSS_EMAIL_FOOTER;
$headers = 'From: support@dentalsleepsolutions.com' . "\r\n" .
                    'Content-type: text/html' ."\r\n" .
                    'Reply-To: support@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Account Activation";
                $mail = mail($_POST['email'], $subject, $m, $headers);
		if($mail){
		  $e_sql = "UPDATE dental_users SET registration_email_date=now() WHERE userid='".mysql_real_escape_string($userid)."'";
		  mysql_query($e_sql);
		}
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_users.php?msg=<?=$msg;?>';
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
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>
	<?php
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$companyid = $_POST['companyid'];
                $use_patient_portal = $_POST['use_patient_portal'];
                $use_digital_fax = $_POST['use_digital_fax'];
                $use_letters = $_POST['use_letters'];
                $use_eligible_api = $_POST['use_eligible_api'];
                $use_course = $_POST['use_course'];
                $use_course_staff = $_POST['use_course_staff'];
                $companyid = $_POST['companyid'];
                $user_type = $_POST['user_type'];

	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return userregabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               Add User 
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input id="name" type="text" name="name" value="<?=$name;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Cell Phone
            </td>
            <td valign="top" class="frmdata">
                <input id="phone" type="text" name="phone" value="<?=$phone;?>" class="tbox phonemask" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Email
            </td>
            <td valign="top" class="frmdata">
                <input id="email" type="text" name="email" value="<?=$email;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
<?php if(is_super($_SESSION['admin_access'])){ ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                 Admin Company
            </td>
            <td valign="top" class="frmdata">
                <select name="companyid" class="tbox">
			<?php
			  $bu_sql = "SELECT * FROM companies ORDER BY name ASC";
			  $bu_q = mysql_query($bu_sql);
			  while($bu_r = mysql_fetch_assoc($bu_q)){ ?>
 			    <option value="<?= $bu_r['id']; ?>" <?= ($bu_r['id'] == $companyid)?'selected="selected"':''; ?>><?= $bu_r['name']; ?></option>
			  <?php } ?>
                </select>
            </td>
        </tr>
<?php } ?>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient Portal Active?
            </td>
            <td valign="top" class="frmdata">
                        <input type="checkbox" name="use_patient_portal" value="1" <? if($use_patient_portal == 1) echo " checked='checked'";?> />
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Digital Fax Active?
            </td>
            <td valign="top" class="frmdata">
                        <input type="checkbox" name="use_digital_fax" value="1" <? if($use_digital_fax == 1) echo " checked='checked'";?> />
            </td>
        </tr>


        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Letters Active?
            </td>
            <td valign="top" class="frmdata">
                        <input type="checkbox" name="use_letters" value="1" <? if($use_letters == 1) echo " checked='checked'";?> />
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Eligible API Active?
            </td>
            <td valign="top" class="frmdata">
                        <input type="checkbox" name="use_eligible_api" value="1" <? if($use_eligible_api == 1) echo " checked='checked'";?> />
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Course Active?
            </td>
            <td valign="top" class="frmdata">
                        <input type="checkbox" name="use_course" value="1" <? if($use_course == 1) echo " checked='checked'";?> />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Staff Course Active?
            </td>
            <td valign="top" class="frmdata">
                        <input type="checkbox" name="use_course_staff" value="1" <? if($use_course_staff == 1) echo " checked='checked'";?> />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                 User Type
            </td>
            <td valign="top" class="frmdata">
                <select name="user_type" class="tbox">
                            <option value="<?= DSS_USER_TYPE_FRANCHISEE; ?>" <?= ($user_type == DSS_USER_TYPE_FRANCHISEE)?'selected="selected"':''; ?>><?= $dss_user_type_labels[DSS_USER_TYPE_FRANCHISEE]; ?></option>
                            <option value="<?= DSS_USER_TYPE_SOFTWARE; ?>" <?= ($user_type == DSS_USER_TYPE_SOFTWARE)?'selected="selected"':''; ?>><?= $dss_user_type_labels[DSS_USER_TYPE_SOFTWARE]; ?></option>

                </select>
            </td>
        </tr>


        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="usersub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["userid"]?>" />
                <input type="submit" value=" Add User" class="button" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
