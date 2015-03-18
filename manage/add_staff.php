<?php namespace Ds3\Libraries\Legacy; ?><?php 
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include_once('admin/includes/password.php');
    include('includes/edx_functions.php');
    include_once 'includes/help_functions.php';

    $sql = "SELECT manage_staff FROM dental_users WHERE userid = '".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
    
    $r = $db->getRow($sql);
    if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff'] != 1) {
?>
        <br />You do not have permissions to edit staff.
<?php
        trigger_error("Die called", E_USER_ERROR);
    }
?>

    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
    <script type="text/javascript" src="/manage/includes/modal.js"></script>
    <link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
    <link rel="stylesheet" href="css/modal.css" />

<?php
    if(!empty($_POST["staffsub"]) && $_POST["staffsub"] == 1) {
    	$sel_check = "select * from dental_users where username = '" . s_for($_POST["username"]) . "' and userid <> '" . s_for($_POST['ed']) . "'";
        $sel_check2 = "select * from dental_users where email = '" . s_for($_POST["email"]) . "' and userid <> '" . s_for($_POST['ed']) . "'";
    	
    	if($db->getNumberRows($sel_check) > 0) {
    		$msg = "Username already exist. So please give another Username.";
?>
    		<script type="text/javascript">
    			alert("<?php echo $msg;?>");
    			window.location = "#add";
    		</script>
<?php
    	} elseif($db->getNumberRows($sel_check2) > 0) {
            $msg = "Email already exist. So please give another Email.";
?>
            <script type="text/javascript">
                alert("<?php echo $msg;?>");
                window.location = "#add";
            </script>
<?php
        } else {
    		if(!empty($_POST["ed"])) {
                $old_sql = "SELECT username FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_POST["ed"])."'";
                
                $old_r = $db->getRow($old_sql);
                $old_username = $old_r['username'];

                $p = ($_POST['producer'] == 1) ? 1 : 0;
                $pla = ($_POST['post_ledger_adjustments'] == 1) ? 1  : 0;
                $ele = ($_POST['edit_ledger_entries'] == 1) ? 1 : 0;
    			$pf = ($_POST['producer_files'] == 1) ? 1 : 0;
                $n = ($_POST['sign_notes'] == 1) ? 1 : 0;
    			$c = ($_POST['use_course'] == 1) ? 1 : 0;
    			$s = ($_POST['manage_staff'] == 1) ? 1 : 0;
    			$ein = ($_POST['ein'] == 1) ? 1 : 0;
    			$ssn = ($_POST['ssn'] == 1) ? 1 : 0;
    			$ed_sql = "update dental_users set user_access=1, 
    				        first_name = '".s_for($_POST["first_name"])."', 
                            last_name = '".s_for($_POST["last_name"])."',
    				        email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for(num($_POST["phone"]))."', status = '".s_for($_POST["status"])."', producer=".$p.", 
                            producer_files = ".$pf.",
    				        npi = '".s_for($_POST["npi"])."',
                            medicare_npi = '".s_for($_POST["medicare_npi"])."',
    				        medicare_ptan = '".s_for($_POST["medicare_ptan"])."',
                            tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."',
                            ein = '".s_for($ein)."',
                            ssn = '".s_for($ssn)."',
                            practice = '".s_for($_POST["practice"])."',
                            city = '".s_for($_POST["city"])."',
                            state = '".s_for($_POST["state"])."',
                            zip = '".s_for($_POST["zip"])."',
            				post_ledger_adjustments = ".$pla.", 
            				edit_ledger_entries = ".$ele.", 
            				use_course = ".$c.", ";

                $sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
 
                $r = $db->getRow($sql);
                if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff']==1) {
				  $ed_sql .= " manage_staff = ".$s.", ";
				}
				$ed_sql .= " sign_notes=".$n."  where userid='".$_POST["ed"]."'";
                $db->query($ed_sql);
    			edx_user_update($_POST['ed']);
                //help_user_update will fail in dev environments since help site is not setup. Only in production
    			help_user_update($_POST['ed'] ,$help_con);	
    			$msg = "Edited Successfully";
?>
    			<script type="text/javascript">
    				parent.window.location = 'manage_staff.php?msg=<?php echo $msg;?>';
    			</script>
<?php
                trigger_error("Die called", E_USER_ERROR);
		    } else {
                $salt = create_salt();
                $password = gen_password($_POST['password'], $salt);
                $p = (!empty($_POST['producer']) && $_POST['producer'] == 1) ? 1 : 0;
                $pla = (!empty($_POST['post_ledger_adjustments']) && $_POST['post_ledger_adjustments'] == 1) ? 1 : 0;
                $ele = (!empty($_POST['edit_ledger_entries']) && $_POST['edit_ledger_entries'] == 1) ? 1 : 0;
			    $pf = (!empty($_POST['producer_files']) && $_POST['producer_files'] == 1) ? 1 : 0;
                $n = (!empty($_POST['sign_notes']) && $_POST['sign_notes'] == 1) ? 1 : 0;
			    $c = (!empty($_POST['use_course']) && $_POST['use_course'] == 1) ? 1 : 0;
                $s = (!empty($_POST['manage_staff']) && $_POST['manage_staff'] == 1) ? 1 : 0;
                $ein = (!empty($_POST['ein']) && $_POST['ein'] == 1) ? 1 : 0;
                $ssn = (!empty($_POST['ssn']) && $_POST['ssn'] == 1) ? 1 : 0;
			    $ins_sql = "insert into dental_users set user_access=1, docid='".$_SESSION['docid']."', username = '".s_for($_POST["username"])."', password = '".mysqli_real_escape_string($con,$password)."', salt='".$salt."', 
				            first_name = '".s_for($_POST["first_name"])."', 
            				last_name = '".s_for($_POST["last_name"])."', 
            				email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for(num($_POST["phone"]))."', status = '".s_for($_POST["status"])."', producer=".$p.",
                            producer_files = ".$pf.",
                            npi = '".s_for($_POST["npi"])."',
                            medicare_npi = '".s_for($_POST["medicare_npi"])."',
				            medicare_ptan = '".s_for($_POST["medicare_ptan"])."',
                            tax_id_or_ssn = '".s_for($_POST["tax_id_or_ssn"])."',
                            ein = '".s_for($ein)."',
                            ssn = '".s_for($ssn)."',
                            practice = '".s_for($_POST["practice"])."',
                            city = '".s_for($_POST["city"])."',
                            state = '".s_for($_POST["state"])."',
                            zip = '".s_for($_POST["zip"])."',
            				post_ledger_adjustments = ".$pla.", 
            				edit_ledger_entries = ".$ele.", 
            				use_course = ".$c.", ";
                $sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
                $r = $db->getRow($sql);
                if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff']==1) {
                    $ins_sql .= " manage_staff = ".$s.", ";
                }
                
                $ins_sql .= " sign_notes=".$n." ,adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
                $userid = $db->getInsertId($ins_sql);
                $docname_sql = "SELECT name from dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

                $docname_r = $db->getRow($docname_sql);
                $docname = $docname_r['name'];
                $co_sql = "SELECT c.id, c.name from companies c
                            JOIN dental_user_company uc ON c.id = uc.companyid
                            JOIN dental_users u ON u.userid = uc.userid
                            WHERE u.userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

                $co_r = $db->getRow($co_sql);
                $cid = $co_r['id'];
                $cname = $co_r['name'];

    			edx_user_update($userid);
    			help_user_update($userid, (!empty($help_con) ? $help_con : ''));
		
			    $msg = "Added Successfully";
?>
    			<script type="text/javascript">
    				parent.window.location = 'manage_staff.php?msg=<?php echo $msg;?>';
    			</script>
<?php
			    trigger_error("Die called", E_USER_ERROR);
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
        <?php
            $thesql = "select * from dental_users where userid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";

        	$themyarray = $db->getRow($thesql);
        	if(!empty($msg)) {
        		$username = $_POST['username'];
        		$password = $_POST['password'];
        		$first_name = $_POST['first_name'];
        		$last_name = $_POST['last_name'];
        		$email = $_POST['email'];
        		$address = $_POST['address'];
        		$phone = $_POST['phone'];
        		$status = $_POST['status'];
                $producer = $_POST['producer'];
                $producer_files = $_POST['producer_files'];
        		$npi = $_POST['npi'];
                $medicare_npi = $_POST['medicare_npi'];
                $medicare_ptan = $_POST['medicare_ptan'];
                $tax_id_or_ssn = $_POST['tax_id_or_ssn'];
                $ein = $_POST['ein'];
                $ssn = $_POST['ssn'];
                $practice = $_POST['practice'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $zip = $_POST['zip'];
                $phone = $_POST['phone'];
        		$post_ledger_adjustments = $_POST['post_ledger_adjustments'];
        		$edit_ledger_entries = $_POST['edit_ledger_entries'];
        		$use_course = $_POST['use_course'];
        		$manage_staff = $_POST['manage_staff'];
                $sign_notes = $_POST['sign_notes'];
	        } else {
        		$username = st($themyarray['username']);
        		$password = st($themyarray['password']);
        		$first_name = st($themyarray['first_name']);
        		$last_name = st($themyarray['last_name']);
        		$email = st($themyarray['email']);
        		$address = st($themyarray['address']);
        		$phone = st($themyarray['phone']);
        		$status = st($themyarray['status']);
                $producer = st($themyarray['producer']);
                $producer_files = st($themyarray['producer_files']);
		        $npi = st($themyarray['npi']);
                $medicare_npi = st($themyarray['medicare_npi']);
                $medicare_ptan = st($themyarray['medicare_ptan']);
                $tax_id_or_ssn = st($themyarray['tax_id_or_ssn']);
                $ein = st($themyarray['ein']);
                $ssn = st($themyarray['ssn']);
                $practice = st($themyarray['practice']);
                $address = st($themyarray['address']);
                $city = st($themyarray['city']);
                $state = st($themyarray['state']);
                $zip = st($themyarray['zip']);
                $phone = st($themyarray['phone']);
        		$post_ledger_adjustments = st($themyarray['post_ledger_adjustments']);
        		$edit_ledger_entries = st($themyarray['edit_ledger_entries']);
        		$use_course = st($themyarray['use_course']);
        		$manage_staff = st($themyarray['manage_staff']);
                $sign_notes = st($themyarray['sign_notes']);
		        $but_text = "Add ";
	        }
	
        	if($themyarray["userid"] != '') {
        		$but_text = "Edit ";
        	} else {
        		$but_text = "Add ";
        	}
	    ?>
	
	    <br /><br />
	
	    <?php if(!empty($msg)) { ?>
            <div align="center" class="red">
                <?php echo $msg;?>
            </div>
        <?php } ?>

        <form name="stafffrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return staffabc(this)">
            <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">
                       <?php echo $but_text?> Staff 
                       <?php if($username <> "") { ?>
                       		&quot;<?php echo $username;?>&quot;
                       <?php } ?>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead" width="30%">
                        Username
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="username" value="<?php echo $username?>" class="tbox" /> 
                        <span class="red">*</span>				
                    </td>
                </tr>
        	<?php if($themyarray["userid"] == '') { ?>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Password
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="password" value="<?php echo $password;?>" class="tbox" /> 
                        <span class="red">*</span>				
                    </td>
                </tr>
	        <?php } ?>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        First Name
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="first_name" value="<?php echo $first_name;?>" class="tbox" /> 
                        <span class="red">*</span>				
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Last Name
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="last_name" value="<?php echo $last_name;?>" class="tbox" /> 
                        <span class="red">*</span>				
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Email
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="email" value="<?php echo $email;?>" class="tbox" /> 
        		        <span class="red">*</span>
                    </td>
                </tr>
                    <td valign="top" class="frmhead">
                        Dentist/Producer <div id="dp_info" class="info_but"></div>
                		<div id="dp_info_modal" class="info_modal" title="Dentist/Producer explanation">
                			Check this box if the user you are creating is a licensed dentist and requires the ability to bill MEDICAL procedures under their own name or NPI/TaxID number.
                		</div>
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" <?php echo  ($producer == 1)?'checked="checked"':''; ?> value="1" id="producer" name="producer" />
                    </td>
                </tr>
                <tr class="producer_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                       Producer bills insurance under their name?
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" <?php echo  ($producer_files==1)?'checked="checked"':''; ?> value="1" id="producer_files" name="producer_files" />
                    </td>
                </tr>
            	<tr class="files_field" bgcolor"#ffffff;">
            	    <td colspan="2">
                        Fields left blank below will default to the standard billing settings for your office.
            	    </td>
            	</tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        NPI
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="npi" value="<?php echo $npi;?>" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Medicare Provider (NPI/DME) Number 
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="medicare_npi" value="<?php echo $medicare_npi;?>" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Medicare PTAN Number 
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="medicare_ptan" value="<?php echo $medicare_ptan;?>" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Tax ID or SSN
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="tax_id_or_ssn" value="<?php echo $tax_id_or_ssn;?>" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        EIN or SSN
                    </td>
                    <td valign="top" class="frmdata">
                		<input type="checkbox" <?php echo  ($ein==1)?'checked="checked"':''; ?> value="1" name="ein" /> EIN 
                		<input type="checkbox" <?php echo  ($ssn==1)?'checked="checked"':''; ?> value="1" name="ssn" /> SSN
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Practice
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="practice" value="<?php echo $practice;?>" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Address
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="text" name="address" class="tbox" id="address" value="<?php echo  $address; ?>" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        City
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="city" type="text" value="<?php echo $city;?>" name="city" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        State
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="state" type="text" value="<?php echo $state;?>" name="state" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Zip
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="zip" type="text" name="zip" value="<?php echo $zip;?>" class="tbox" />
                    </td>
                </tr>
                <tr class="files_field" bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Phone
                    </td>
                    <td valign="top" class="frmdata">
                        <input id="phone" type="text" name="phone" value="<?php echo $phone;?>" class="tbox" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        Sign Progress Notes / Order HST? <div id="spn_info" class="info_but"></div>
                        <div id="spn_info_modal" class="info_modal" title="Sign Progress Notes explanation">
                            Check this box if this user is legally allowed to sign progress notes and/or order Home Sleep Tests (HST). In most cases, this means the user must be a licensed dentist. After checking this box, the user will be able to legally sign patient progress notes that will become permanently associated with patient charts, as well as submit Home Sleep Test (HST) order requests.
                        </div>
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" <?php echo ($sign_notes==1)?'checked="checked"':''; ?> value="1" name="sign_notes" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                    Use Course?
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" <?php echo ($use_course==1)?'checked="checked"':''; ?> value="1" name="use_course" />
                    </td>
                </tr>

                <?php
                    $sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
                    
                    $r = $db->getRow($sql);
                    if($_SESSION['docid']==$_SESSION['userid'] || $r['manage_staff']==1) {
                ?>
                    <tr>
                        <td valign="top" class="frmhead">
                            Manage Staff/Codes? <div id="ms_info" class="info_but"></div>
                            <div id="ms_info_modal" class="info_modal" title="Manage Staff explanation">
                                Check this box if you want this user to be able to add or edit the staff in your account. User will also be able to add/edit insurance transaction codes and associated fees. You should ONLY check this box for office managers or other staff qualified to alter insurance codes and add or delete software accounts.
                            </div>
                        </td>
                        <td valign="top" class="frmdata">
                            <input type="checkbox" <?php echo  ($manage_staff==1)?'checked="checked"':''; ?> value="1" name="manage_staff" />
                        </td>
                    </tr>
                <?php } ?>
                
                <tr>
                    <td valign="top" class="frmhead">
                        Post Ledger Adjustments? <div id="pla_info" class="info_but"></div>
                        <div id="pla_info_modal" class="info_modal" title="Post Ledger Adjustments explanation">
                            Select this option if the user should be allowed to post adjustments to a patient ledger.  If this option is not checked, the user will still be able to see the patient ledger, but will not be able to post or edit any adjustments.
                        </div>
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" <?php echo  ($post_ledger_adjustments==1)?'checked="checked"':''; ?> value="1" name="post_ledger_adjustments" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                    	Edit Ledger Entries? <div id="ele_info" class="info_but"></div>
                        <div id="ele_info_modal" class="info_modal" title="Edit Ledger Entries explanation">
                    	    Select this option if the user is allowed to edit (make changes to) ledger entries in a patient ledger.  If this option is not checked, the user will still be able to see the patient ledger, but will not be able to edit or change any type of ledger entry.
                        </div> 
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="checkbox" <?php echo  ($edit_ledger_entries==1)?'checked="checked"':''; ?> value="1" name="edit_ledger_entries" />
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td valign="top" class="frmhead">
                        Status <div id="s_info" class="info_but"></div>
                        <div id="s_info_modal" class="info_modal" title="Status explanation">
                            Change the status of this user account here. ACTIVE staff will have full access to the software, INACTIVE staff are prohibited from accessing the software, but all their user activity will be stored for future review. If an employee has left your organization, or you want to prohibit an employee from accessing your software then choose INACTIVE.
                        </div>
                    </td>
                    <td valign="top" class="frmdata">
                    	<select name="status" class="tbox">
                        	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                        	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td  colspan="2" align="center">
                        <span class="red">
                            * Required Fields					
                        </span><br />
                        <input type="hidden" name="staffsub" value="1" />
                        <input type="hidden" name="ed" value="<?php echo $themyarray["userid"]?>" />
                        <input type="submit" value=" <?php echo $but_text?> Staff" class="button" />
                        <?php if($themyarray["userid"] != '') { ?>
                            <?php
                                $l_sql = "SELECT * from dental_login WHERE userid='".mysqli_real_escape_string($con,$themyarray['userid'])."'";
                                
                                $logins = $db->getNumberRows($l_sql);
                            ?>
                            <a style="float:right;" href="manage_staff.php?delid=<?php echo $themyarray["userid"];?>" onclick="javascript: return confirm_delete(<?php echo  $logins; ?>);" class="dellink" title="DELETE" target="_parent">
                                Delete 
                            </a>
		                <?php } ?>
                    </td>
                </tr>
            </table>
        </form>

        <script type="text/javascript" src="js/add_staff.js"></script>
    </body>
</html>
