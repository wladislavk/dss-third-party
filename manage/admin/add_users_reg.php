<?php namespace Ds3\Libraries\Legacy; ?><?php 
session_start();
require_once('includes/main_include.php');
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
        $query_check2=mysqli_query($con, $sel_check2);

	if(mysqli_num_rows($query_check2)>0)
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
                                use_payment_report = '".s_for($_POST['use_payment_report'])."',
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
			mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con)trigger_error);
                        $userid = mysqli_insert_id($con);			
                        $code_sql = "insert into dental_transaction_code (transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, docid, amount_adjust) SELECT transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, ".$userid.", amount_adjust FROM dental_transaction_code WHERE default_code=1";
                        mysqli_query($con, $code_sql) or trigger_error($code_sql.mysqli_error($con)trigger_error);
                        $custom_sql = "insert into dental_custom (title, description, docid) SELECT title, description, ".$userid." FROM dental_custom WHERE default_text=1";
                        mysqli_query($con, $custom_sql) or trigger_error($custom_sql.mysqli_error($con)trigger_error);
			
			if(is_super($_SESSION['admin_access'])){
			  mysqli_query($con, "INSERT INTO dental_user_company SET userid='".mysqli_real_escape_string($con, $userid)."', companyid='".mysqli_real_escape_string($con, $_POST["companyid"])."'");
			}else{
  			  mysqli_query($con, "INSERT INTO dental_user_company SET userid='".mysqli_real_escape_string($con, $userid)."', companyid='".mysqli_real_escape_string($con, $_SESSION["companyid"])."'");
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
		  $e_sql = "UPDATE dental_users SET registration_email_date=now() WHERE userid='".mysqli_real_escape_string($con, $userid)."'";
		  mysqli_query($con, $e_sql);
		}
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_users.php?msg=<?=$msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
	<?php
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$companyid = $_POST['companyid'];
                $use_patient_portal = $_POST['use_patient_portal'];
                $use_payment_report = $_POST['use_payment_report'];
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
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return userregabc(this)">
    <table class="table table-bordered table-hover">
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
                <input id="name" type="text" name="name" value="<?=$name;?>" class="form-control" /> 
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
                <input id="email" type="text" name="email" value="<?=$email;?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
<?php if(is_super($_SESSION['admin_access'])){ ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                 Admin Company
            </td>
            <td valign="top" class="frmdata">
                <select name="companyid" class="form-control">
			<?php
			  $bu_sql = "SELECT * FROM companies ORDER BY name ASC";
			  $bu_q = mysqli_query($con, $bu_sql);
			  while($bu_r = mysqli_fetch_assoc($bu_q)){ ?>
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
                Payment Reports
            </td>
            <td valign="top" class="frmdata">
                        <input type="checkbox" name="use_payment_report" value="0" <? if($use_payment_report == 1) echo " checked='checked'";?> />
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
                <select name="user_type" class="form-control">
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
                <input type="submit" value="Add User" class="btn btn-primary">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
