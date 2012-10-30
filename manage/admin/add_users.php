<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");
include_once('includes/password.php');
include_once '../includes/general_functions.php';
require_once '../includes/constants.inc';
if($_POST["usersub"] == 1)
{
	$sel_check = "select * from dental_users where username = '".s_for($_POST["username"])."' and userid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
        $sel_check2 = "select * from dental_users where email = '".s_for($_POST["email"])."' and userid <> '".s_for($_POST['ed'])."'";
        $query_check2=mysql_query($sel_check2);

	if(mysql_num_rows($query_check)>0)
	{
		$msg="Username already exist. So please give another Username.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	elseif(mysql_num_rows($query_check2)>0)
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
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_users set 
				username = '".s_for($_POST["username"])."',
				user_access=2,
				npi = '".s_for($_POST["npi"])."',
				medicare_npi = '".s_for($_POST["medicare_npi"])."',
				tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."', 
                                ssn = '".s_for($_POST['ssn'])."',
                                ein = '".s_for($_POST['ein'])."',
				practice = '".s_for($_POST['practice'])."', 
				name = '".s_for($_POST["name"])."', 
				email = '".s_for($_POST["email"])."', 
				address = '".s_for($_POST["address"])."', 
				city = '".s_for($_POST["city"])."', 
				state = '".s_for($_POST["state"])."', 
				zip = '".s_for($_POST["zip"])."', 
				phone = '".s_for(num($_POST["phone"]))."', 
				fax = '".s_for(num($_POST["fax"]))."',
                                mailing_practice = '".s_for($_POST['mailing_practice'])."', 
                                mailing_name = '".s_for($_POST["mailing_name"])."', 
                                mailing_address = '".s_for($_POST["mailing_address"])."', 
                                mailing_city = '".s_for($_POST["mailing_city"])."', 
                                mailing_state = '".s_for($_POST["mailing_state"])."', 
                                mailing_zip = '".s_for($_POST["mailing_zip"])."', 
                                mailing_phone = '".s_for(num($_POST["mailing_phone"]))."',
				use_patient_portal = '".s_for($_POST['use_patient_portal'])."',
				use_digital_fax = '".s_for($_POST['use_digital_fax'])."',
				status = '".s_for($_POST["status"])."' 
			where userid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

			mysql_query("DELETE FROM dental_user_admin WHERE userid='".mysql_real_escape_string($_POST["ed"])."'");
			mysql_query("INSERT INTO dental_user_admin SET userid='".mysql_real_escape_string($_POST["ed"])."', adminid='".mysql_real_escape_string($_POST["adminid"])."'");
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_users.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{

			$salt = create_salt();
			$password = gen_password($_POST['password'], $salt);

			$ins_sql = "insert into dental_users set user_access=2,
				username = '".s_for($_POST["username"])."',
				npi = '".s_for($_POST["npi"])."',
				medicare_npi = '".s_for($_POST["medicare_npi"])."',
				tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."', 
				ssn = '".s_for($_POST['ssn'])."',
				ein = '".s_for($_POST['ein'])."',
				practice = '".s_for($_POST['practice'])."', 
				password = '".mysql_real_escape_string($password)."', 
				salt = '".$salt."',
				name = '".s_for($_POST["name"])."', 
				email = '".s_for($_POST["email"])."', 
				address = '".s_for($_POST["address"])."', 
				city = '".s_for($_POST["city"])."', 
				state = '".s_for($_POST["state"])."', 
				zip = '".s_for($_POST["zip"])."', 
				phone = '".s_for(num($_POST["phone"]))."', 
				fax = '".s_for(num($_POST["fax"]))."',
                                mailing_practice = '".s_for($_POST['mailing_practice'])."',
                                mailing_name = '".s_for($_POST["mailing_name"])."', 
                                mailing_address = '".s_for($_POST["mailing_address"])."', 
                                mailing_city = '".s_for($_POST["mailing_city"])."', 
                                mailing_state = '".s_for($_POST["mailing_state"])."', 
                                mailing_zip = '".s_for($_POST["mailing_zip"])."', 
                                mailing_phone = '".s_for(num($_POST["mailing_phone"]))."',
				use_patient_portal = '".s_for($_POST['use_patient_portal'])."',
				use_digital_fax = '".s_for($_POST['use_digital_fax'])."',
				status = '".s_for($_POST["status"])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
                        $userid = mysql_insert_id();			
                        $code_sql = "insert into dental_transaction_code (transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, docid) SELECT transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, ".$userid." FROM dental_transaction_code WHERE default_code=1";
                        mysql_query($code_sql) or die($code_sql.mysql_error());
                        $custom_sql = "insert into dental_custom (title, description, docid) SELECT title, description, ".$userid." FROM dental_custom WHERE default_text=1";
                        mysql_query($custom_sql) or die($custom_sql.mysql_error());

			mysql_query("INSERT INTO dental_user_admin SET userid='".mysql_real_escape_string($userid)."', adminid='".mysql_real_escape_string($_POST["adminid"])."'");

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

    <?
    $thesql = "select u.*, a.adminid from dental_users u 
		LEFT JOIN dental_user_admin a ON u.userid = a.userid
		where u.userid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$username = $_POST['username'];
		$npi = $_POST['npi'];
		$medicare_npi = $_POST['medicare_npi'];
		$tax_id_or_ssn = $_POST['tax_id_or_ssn'];
		$ssn = $_POST['ssn'];
		$ein = $_POST['ein'];
		$practice = $_POST['practice'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];

                $mailing_practice = $_POST['mailing_practice'];
                $mailing_name = $_POST['mailing_name'];
                $mailing_address = $_POST['mailing_address'];
                $mailing_city = $_POST['mailing_city'];
                $mailing_state = $_POST['mailing_state'];
                $mailing_zip = $_POST['mailing_zip'];
                $mailing_phone = $_POST['mailing_phone'];

		$status = $_POST['status'];
		$use_patient_portal = $_POST['use_patient_portal'];
		$use_digital_fax = $_POST['use_digital_fax'];
		$adminid = $_POST['adminid'];
	}
	else
	{
		$username = st($themyarray['username']);
		$npi = st($themyarray['npi']);
		$medicare_npi = st($themyarray['medicare_npi']);
		$tax_id_or_ssn = st($themyarray['tax_id_or_ssn']);
		$ssn = st($themyarray['ssn']);
		$ein = st($themyarray['ein']);
		$practice = st($themyarray['practice']);
		$password = st($themyarray['password']);
		$name = st($themyarray['name']);
		$email = st($themyarray['email']);
		$address = st($themyarray['address']);
		$city = st($themyarray['city']);
		$state = st($themyarray['state']);
		$zip = st($themyarray['zip']);
		$phone = st($themyarray['phone']);
		$fax = st($themyarray['fax']);

                $mailing_practice = st($themyarray['mailing_practice']);
                $mailing_name = st($themyarray['mailing_name']);
                $mailing_address = st($themyarray['mailing_address']);
                $mailing_city = st($themyarray['mailing_city']);
                $mailing_state = st($themyarray['mailing_state']);
                $mailing_zip = st($themyarray['mailing_zip']);
                $mailing_phone = st($themyarray['mailing_phone']);

		$status = st($themyarray['status']);
		$use_patient_portal = st($themyarray['use_patient_portal']);
		$use_digital_fax = st($themyarray['use_digital_fax']);
		$adminid = st($themyarray['adminid']);
		$but_text = "Add ";
	}
	
	if($themyarray["userid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return userabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> User 
               <? if($username <> "") {?>
               		&quot;<?=$username;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Username
            </td>
            <td valign="top" class="frmdata">
                <input id="username" type="text" name="username" value="<?=$username?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input id="npi" type="text" name="npi" value="<?=$npi?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Medicare DME Number
            </td>
            <td valign="top" class="frmdata">
                <input id="medicare_npi" type="text" name="medicare_npi" value="<?=$medicare_npi?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Tax ID or SSN
            </td>
            <td valign="top" class="frmdata">
                <input id="tax_id_or_ssn" type="text" name="tax_id_or_ssn" value="<?=$tax_id_or_ssn?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                EIN or SSN
            </td>
            <td valign="top" class="frmdata">
                <input id="ein" type="checkbox" name="ein" value="1" <?= ($ein)?'checked="checked"':''; ?> class="tbox" />
		EIN
		<input id="ssn" type="checkbox" name="ssn" value="1" <?= ($ssn)?'checked="checked"':''; ?> class="tbox" />
                SSN
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Practice
            </td>
            <td valign="top" class="frmdata">
                <input id="practice" type="text" name="practice" value="<?=$practice?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
	<?php if(!isset($_REQUEST['ed'])){ ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Password
            </td>
            <td valign="top" class="frmdata">
                <input id="password" type="password" name="password" value="<?=$password;?>" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Re-type Password
            </td>
            <td valign="top" class="frmdata">
                <input id="password2" type="password" name="password2" value="<?=$password;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
	<?php } ?>
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
                Email
            </td>
            <td valign="top" class="frmdata">
                <input id="email" type="text" name="email" value="<?=$email;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Address
            </td>
            <td valign="top" class="frmdata">
		<input type="text" name="address" class="tbox" id="address" value="<?= $address; ?>" />
                <!--<textarea name="address" class="tbox"><?=$address;?></textarea>-->
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                City
            </td>
            <td valign="top" class="frmdata">
                <input id="city" type="text" value="<?php echo $city;?>" name="city" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                State
            </td>
            <td valign="top" class="frmdata">
                <input id="state" type="text" value="<?php echo $state;?>" name="state" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Zip
            </td>
            <td valign="top" class="frmdata">
                <input id="zip" type="text" name="zip" value="<?php echo $zip;?>" class="tbox" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Phone
            </td>
            <td valign="top" class="frmdata">
                <input id="phone" type="text" name="phone" value="<?=$phone;?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Fax
            </td>
            <td valign="top" class="frmdata">
                <input id="fax" type="text" name="fax" value="<?=$fax;?>" class="tbox" />
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Mailing Practice
            </td>
            <td valign="top" class="frmdata">
                <input id="mailing_practice" type="text" name="mailing_practice" value="<?=$mailing_practice?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Mailing Name
            </td>
            <td valign="top" class="frmdata">
                <input id="mailing_name" type="text" name="mailing_name" value="<?=$mailing_name;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Mailing Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="mailing_address" class="tbox" id="mailing_address" value="<?= $mailing_address; ?>" />
                <!--<textarea name="address" class="tbox"><?=$address;?></textarea>-->
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Mailing City
            </td>
            <td valign="top" class="frmdata">
                <input id="mailing_city" type="text" value="<?php echo $mailing_city;?>" name="mailing_city" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Mailing State
            </td>
            <td valign="top" class="frmdata">
                <input id="mailing_state" type="text" value="<?php echo $mailing_state;?>" name="mailing_state" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Mailing Zip
            </td>
            <td valign="top" class="frmdata">
                <input id="mailing_zip" type="text" name="mailing_zip" value="<?php echo $mailing_zip;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Mailing Phone
            </td>
            <td valign="top" class="frmdata">
                <input id="mailing_phone" type="text" name="mailing_phone" value="<?=$mailing_phone;?>" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>

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
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="tbox">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Backoffice User
            </td>
            <td valign="top" class="frmdata">
                <select name="adminid" class="tbox">
			<?php
			  $bu_sql = "SELECT * FROM admin WHERE admin_access='".DSS_ADMIN_ACCESS_ADMIN."'";
			  $bu_q = mysql_query($bu_sql);
			  while($bu_r = mysql_fetch_assoc($bu_q)){ ?>
 			    <option value="<?= $bu_r['adminid']; ?>" <?= ($bu_r['adminid'] == $adminid)?'selected="selected"':''; ?>><?= $bu_r['name']; ?></option>
			  <?php } ?>
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
                <input type="submit" value=" <?=$but_text?> User" class="button" />
                <?php if($themyarray["userid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_users.php?delid=<?=$themyarray["userid"];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
