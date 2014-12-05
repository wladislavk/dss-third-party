<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if(!empty($_POST["compsub"]) && $_POST["compsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update companies set 
				name = '".mysqli_real_escape_string($con,$_POST["name"])."',
                                add1 = '".mysqli_real_escape_string($con,$_POST["add1"])."', 
                                add2 = '".mysqli_real_escape_string($con,$_POST["add2"])."', 
                                city = '".mysqli_real_escape_string($con,$_POST["city"])."', 
                                state = '".mysqli_real_escape_string($con,$_POST["state"])."', 
                                zip = '".mysqli_real_escape_string($con,$_POST["zip"])."', 
                                phone = '".mysqli_real_escape_string($con,num($_POST["phone"]))."', 
                                fax = '".mysqli_real_escape_string($con,num($_POST["fax"]))."', 
                                email = '".mysqli_real_escape_string($con,$_POST["email"])."', 
				eligible_api_key= '".mysqli_real_escape_string($con,$_POST['eligible_api_key'])."',
				stripe_secret_key = '".mysqli_real_escape_string($con,$_POST['stripe_secret_key'])."',
                                stripe_publishable_key = '".mysqli_real_escape_string($con,$_POST['stripe_publishable_key'])."',
				sfax_security_context = '".mysqli_real_escape_string($con,$_POST['sfax_security_context'])."',
				sfax_app_id = '".mysqli_real_escape_string($con,$_POST['sfax_app_id'])."',
				sfax_app_key = '".mysqli_real_escape_string($con,$_POST['sfax_app_key'])."',
				sfax_encryption_key = '".mysqli_real_escape_string($con,$_POST['sfax_encryption_key'])."',
				sfax_init_vector = '".mysqli_real_escape_string($con,$_POST['sfax_init_vector'])."',
				plan_id = '".mysqli_real_escape_string($con,$_POST['plan_id'])."',
				status = '".mysqli_real_escape_string($con,$_POST["status"])."',
				use_support = '".mysqli_real_escape_string($con,$_POST["use_support"])."',
				exclusive = '".mysqli_real_escape_string($con,$_POST["exclusive"])."',
				company_type = '".mysqli_real_escape_string($con,$_POST['company_type'])."',
				vob_require_test = '".mysqli_real_escape_string($con,$_POST['vob_require_test'])."'
			where id='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql) or die($ed_sql." | ".mysql_error());

			$course_sql = "update content_type_profile SET
					field_companyname_value='".mysqli_real_escape_string($con,$_POST["name"])."'
                        		where field_companyid_value='".$_POST["ed"]."'";
			mysqli_query($con,$course_sql, $course_con);			

			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_companies.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{


			$ins_sql = "insert into companies set 
				name = '".mysqli_real_escape_string($con,$_POST["name"])."', 
                                add1 = '".mysqli_real_escape_string($con,$_POST["add1"])."', 
                                add2 = '".mysqli_real_escape_string($con,$_POST["add2"])."', 
                                city = '".mysqli_real_escape_string($con,$_POST["city"])."', 
                                state = '".mysqli_real_escape_string($con,$_POST["state"])."', 
                                zip = '".mysqli_real_escape_string($con,$_POST["zip"])."', 
                                phone = '".mysqli_real_escape_string($con,num($_POST["phone"]))."', 
                                fax = '".mysqli_real_escape_string($con,($_POST["fax"]))."', 
                                email = '".mysqli_real_escape_string($con,$_POST["email"])."', 
				eligible_api_key= '".mysqli_real_escape_string($con,$_POST['eligible_api_key'])."',
                                stripe_secret_key = '".mysqli_real_escape_string($con,$_POST['stripe_secret_key'])."',
                                stripe_publishable_key = '".mysqli_real_escape_string($con,$_POST['stripe_publishable_key'])."',
				sfax_security_context = '".mysqli_real_escape_string($con,$_POST['sfax_security_context'])."',
                                sfax_app_id = '".mysqli_real_escape_string($con,$_POST['sfax_app_id'])."',
                                sfax_app_key = '".mysqli_real_escape_string($con,$_POST['sfax_app_key'])."',
                                sfax_encryption_key = '".mysqli_real_escape_string($con,$_POST['sfax_encryption_key'])."',
                                sfax_init_vector = '".mysqli_real_escape_string($con,$_POST['sfax_init_vector'])."',
				plan_id = '".mysqli_real_escape_string($con,(!empty($_POST['plan_id']) ? $_POST['plan_id'] : ''))."',
				status = '".mysqli_real_escape_string($con,$_POST['status'])."',
				use_support = '".mysqli_real_escape_string($con,(!empty($_POST["use_support"]) ? $_POST["use_support"] : ''))."',
				exclusive = '".mysqli_real_escape_string($con,(!empty($_POST["exclusive"]) ? $_POST["exclusive"] : ''))."',
                                company_type = '".mysqli_real_escape_string($con,$_POST['company_type'])."',
				vob_require_test = '".mysqli_real_escape_string($con,(!empty($_POST['vob_require_test']) ? $_POST['vob_require_test'] : ''))."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);
                        $companyid = mysqli_insert_id($con);			

			$l_sql = "INSERT INTO dental_letter_templates (name, body, companyid, triggerid) SELECT name, body, '".$companyid."', id FROM dental_letter_templates WHERE default_letter=1";
			mysqli_query($con,$l_sql);
			$ct_sql = "insert into dental_claim_text (title, description, companyid) SELECT title, description, ".$companyid." FROM dental_claim_text WHERE default_text=1";
                        mysqli_query($con,$ct_sql);

			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_companies.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from companies where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$name = $_POST['name'];
		$add1 = $_POST['add1'];
		$add2 = $_POST['add2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];   	
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$eligible_api_key = $_POST['eligible_api_key'];
                $stripe_secret_key = $_POST['stripe_secret_key'];
                $stripe_publishable_key = $_POST['stripe_publishable_key'];
		$sfax_securty_context = $_POST['sfax_security_context'];
                $sfax_app_id = $_POST['sfax_app_id'];
                $sfax_app_key = $_POST['sfax_app_key'];
                $sfax_encryption_key = $_POST['sfax_encryption_key'];
                $sfax_init_vector = $_POST['sfax_init_vector'];
		$plan_id = $_POST['plan_id'];
		$status = $_POST['status'];
		$use_support = $_POST['use_support'];
		$exclusive = $_POST['exclusive'];
		$company_type = $_POST['company_type'];
		$vob_require_test = $_POST['vob_require_test'];
	}
	else
	{
		$name = st($themyarray['name']);
		$add1 = st($themyarray['add1']);
                $add2 = st($themyarray['add2']);
                $city = st($themyarray['city']);
                $state = st($themyarray['state']);
                $zip = st($themyarray['zip']);
                $phone = st($themyarray['phone']);
                $fax = st($themyarray['fax']);
                $email = st($themyarray['email']);
		$eligible_api_key = st($themyarray['eligible_api_key']);
                $stripe_secret_key = st($themyarray['stripe_secret_key']);
                $stripe_publishable_key = st($themyarray['stripe_publishable_key']);
		$sfax_security_context = st($themyarray['sfax_security_context']);
                $sfax_app_id = st($themyarray['sfax_app_id']);
                $sfax_app_key = st($themyarray['sfax_app_key']);
                $sfax_encryption_key = st($themyarray['sfax_encryption_key']);
                $sfax_init_vector = st($themyarray['sfax_init_vector']);
		$plan_id = st($themyarray['plan_id']);
		$status = st($themyarray['status']);
		$use_support = st($themyarray['use_support']);
		$exclusive = st($themyarray['exclusive']);
		$company_type = st($themyarray['company_type']);
		$vob_require_test = $themyarray['vob_require_test'];
		$but_text = "Add ";
	}
	
	if($themyarray["id"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return check_add();">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Company 
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
                Address 1
            </td>
            <td valign="top" class="frmdata">
                <input id="add1" type="text" name="add1" value="<?=$add1;?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Address 2
            </td>
            <td valign="top" class="frmdata">
                <input id="add2" type="text" name="add2" value="<?=$add2;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                City
            </td>
            <td valign="top" class="frmdata">
                <input id="city" type="text" name="city" value="<?=$city;?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                State
            </td>
            <td valign="top" class="frmdata">
                <input id="state" type="text" name="state" value="<?=$state;?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Postal Code
            </td>
            <td valign="top" class="frmdata">
                <input id="zip" type="text" name="zip" value="<?=$zip;?>" class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Phone
            </td>
            <td valign="top" class="frmdata">
                <input id="phone" type="text" name="phone" value="<?=$phone;?>" class="form-control extphonemask" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Fax
            </td>
            <td valign="top" class="frmdata">
                <input id="fax" type="text" name="fax" value="<?=$fax;?>" class="form-control phonemask" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Email
            </td>
            <td valign="top" class="frmdata">
                <input id="email" type="text" name="email" value="<?=$email;?>" class="form-control" />
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Eligible API Key
            </td>
            <td valign="top" class="frmdata">
                <input id="zip" type="text" name="eligible_api_key" value="<?=$eligible_api_key;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Stripe SECRET Key
            </td>
            <td valign="top" class="frmdata">
                <input id="stripe_secret_key" type="text" name="stripe_secret_key" value="<?=$stripe_secret_key;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Stripe PUBLISHABLE Key
            </td>
            <td valign="top" class="frmdata">
                <input id="stripe_publishable_key" type="text" name="stripe_publishable_key" value="<?=$stripe_publishable_key;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                SFAX Security Context
            </td>
            <td valign="top" class="frmdata">
                <input id="sfax_security_context" type="text" name="sfax_security_context" value="<?=$sfax_security_context;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                SFAX Username
            </td>
            <td valign="top" class="frmdata">
                <input id="sfax_app_id" type="text" name="sfax_app_id" value="<?=$sfax_app_id;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                SFAX API Key
            </td>
            <td valign="top" class="frmdata">
                <input id="sfax_app_key" type="text" name="sfax_app_key" value="<?=$sfax_app_key;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                SFAX Encryption Key
            </td>
            <td valign="top" class="frmdata">
                <input id="sfax_encryption_key" type="text" name="sfax_encryption_key" value="<?=$sfax_encryption_key;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                SFAX Init Vector
            </td>
            <td valign="top" class="frmdata">
                <input id="sfax_init_vector" type="text" name="sfax_init_vector" value="<?=$sfax_init_vector;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Company Type
            </td>
            <td valign="top" class="frmdata">
                <select name="company_type" class="form-control">
                        <option value="<?= DSS_COMPANY_TYPE_SOFTWARE; ?>" <? if($company_type == DSS_COMPANY_TYPE_SOFTWARE) echo " selected";?>><?= $dss_company_type_labels[DSS_COMPANY_TYPE_SOFTWARE]; ?></option>
                        <option value="<?= DSS_COMPANY_TYPE_BILLING; ?>" <? if($company_type!='' && $company_type == DSS_COMPANY_TYPE_BILLING) echo " selected";?>><?= $dss_company_type_labels[DSS_COMPANY_TYPE_BILLING]; ?></option>
                        <option value="<?= DSS_COMPANY_TYPE_HST; ?>" <? if($company_type!='' && $company_type == DSS_COMPANY_TYPE_HST) echo " selected";?>><?= $dss_company_type_labels[DSS_COMPANY_TYPE_HST]; ?></option>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
		Sleep Test Required for VOB?
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" name="vob_require_test" value="1" <?= ($vob_require_test==1)?'checked="checked"':''; ?> />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                <attr title="Choose backoffice billing plan associated with this account.  This is the plan that the Super Administrator will bill the COMPANY.">Plan</attr>
            </td>
            <td valign="top" class="frmdata">
                    <select name="plan_id" id="plan_id" class="form-control">
                        <?php

                        $p_sql = "SELECT * FROM dental_plans WHERE office_type='2' ORDER BY name ASC";
                        $p_q = mysqli_query($con,$p_sql);

                        while ($p_r = mysqli_fetch_assoc($p_q)) { ?>
                        <option value="<?= $p_r['id']; ?>" <?= ($p_r['id'] == $plan_id)?'selected="selected"':''; ?>><?= $p_r['name']; ?></option>
                        <?php } ?>
                    </select>
	    </td>
	</tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                <attr title="This option will allow any frontoffice user associated with this company to send Support tickets directly to this company by choosing the company in the ‘Send To’ section of the ticket.">Support Tickets Active?</attr> 
            </td>
            <td valign="top" class="frmdata">
		<input type="checkbox" name="use_support" value="1" <?= ($use_support==1)?'checked="checked"':''; ?> />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                <attr title="This option is for BILLING companies.  If checked it will NOT allow frontoffice user to file their own claims, all billing will go exclusively to the backoffice billing company.">Exclusive?</attr>
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" name="exclusive" value="1" <?= ($exclusive==1)?'checked="checked"':''; ?> />
            </td>
        </tr>

        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="compsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value="<?=$but_text?> Company" class="btn btn-primary">
                <?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_companies.php?delid=<?=$themyarray["id"];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
<script type="text/javascript">

  function check_add(){
    if($('#name').val()=="" ||
	$('#add1').val() == "" ||
	$('#city').val() == "" ||
	$('#state').val() == "" ||
	$('#zip').val() == ""){
	alert('Please enter all required fields.');
	return false;
     }
    return true;
  }
</script>
</body>
</html>
