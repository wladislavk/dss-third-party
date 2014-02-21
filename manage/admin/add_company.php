<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
require_once('../includes/constants.inc');
include_once '../includes/general_functions.php';
if($_POST["compsub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update companies set 
				name = '".mysql_real_escape_string($_POST["name"])."',
                                add1 = '".mysql_real_escape_string($_POST["add1"])."', 
                                add2 = '".mysql_real_escape_string($_POST["add2"])."', 
                                city = '".mysql_real_escape_string($_POST["city"])."', 
                                state = '".mysql_real_escape_string($_POST["state"])."', 
                                zip = '".mysql_real_escape_string($_POST["zip"])."', 
                                phone = '".mysql_real_escape_string(num($_POST["phone"]))."', 
                                fax = '".mysql_real_escape_string(num($_POST["fax"]))."', 
                                email = '".mysql_real_escape_string($_POST["email"])."', 
				eligible_api_key= '".mysql_real_escape_string($_POST['eligible_api_key'])."',
				stripe_secret_key = '".mysql_real_escape_string($_POST['stripe_secret_key'])."',
                                stripe_publishable_key = '".mysql_real_escape_string($_POST['stripe_publishable_key'])."',
				sfax_security_context = '".mysql_real_escape_string($_POST['sfax_security_context'])."',
				sfax_app_id = '".mysql_real_escape_string($_POST['sfax_app_id'])."',
				sfax_app_key = '".mysql_real_escape_string($_POST['sfax_app_key'])."',
				sfax_init_vector = '".mysql_real_escape_string($_POST['sfax_init_vector'])."',
				status = '".mysql_real_escape_string($_POST["status"])."',
				company_type = '".mysql_real_escape_string($_POST['company_type'])."'
			where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

			$course_sql = "update content_type_profile SET
					field_companyname_value='".mysql_real_escape_string($_POST["name"])."'
                        		where field_companyid_value='".$_POST["ed"]."'";
			mysql_query($course_sql, $course_con);			

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
				name = '".mysql_real_escape_string($_POST["name"])."', 
                                add1 = '".mysql_real_escape_string($_POST["add1"])."', 
                                add2 = '".mysql_real_escape_string($_POST["add2"])."', 
                                city = '".mysql_real_escape_string($_POST["city"])."', 
                                state = '".mysql_real_escape_string($_POST["state"])."', 
                                zip = '".mysql_real_escape_string($_POST["zip"])."', 
                                phone = '".mysql_real_escape_string(num($_POST["phone"]))."', 
                                fax = '".mysql_real_escape_string(($_POST["fax"]))."', 
                                email = '".mysql_real_escape_string($_POST["email"])."', 
				eligible_api_key= '".mysql_real_escape_string($_POST['eligible_api_key'])."',
                                stripe_secret_key = '".mysql_real_escape_string($_POST['stripe_secret_key'])."',
                                stripe_publishable_key = '".mysql_real_escape_string($_POST['stripe_publishable_key'])."',
				sfax_security_context = '".mysql_real_escape_string($_POST['sfax_security_context'])."',
                                sfax_app_id = '".mysql_real_escape_string($_POST['sfax_app_id'])."',
                                sfax_app_key = '".mysql_real_escape_string($_POST['sfax_app_key'])."',
                                sfax_init_vector = '".mysql_real_escape_string($_POST['sfax_init_vector'])."',
				status = '".mysql_real_escape_string($_POST['status'])."',
                                company_type = '".mysql_real_escape_string($_POST['company_type'])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
                        $companyid = mysql_insert_id();			

			$l_sql = "INSERT INTO dental_letter_templates (name, body, companyid, triggerid) SELECT name, body, '".$companyid."', id FROM dental_letter_templates WHERE default_letter=1";
			mysql_query($l_sql);

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
    $thesql = "select * from companies where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
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
                $sfax_init_vector = $_POST['sfax_init_vector'];
		$status = $_POST['status'];
		$company_type = $_POST['company_type'];
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
                $sfax_init_vector = st($themyarray['sfax_init_vector']);
		$status = st($themyarray['status']);
		$company_type = st($themyarray['company_type']);
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
	
	<? if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" >
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
                <span class="red">*</span>
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
                <input id="phone" type="text" name="phone" value="<?=$phone;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Fax
            </td>
            <td valign="top" class="frmdata">
                <input id="fax" type="text" name="fax" value="<?=$fax;?>" class="form-control" />
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
                SFAX App ID
            </td>
            <td valign="top" class="frmdata">
                <input id="sfax_app_id" type="text" name="sfax_app_id" value="<?=$sfax_app_id;?>" class="form-control" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                SFAX App Key
            </td>
            <td valign="top" class="frmdata">
                <input id="sfax_app_key" type="text" name="sfax_app_key" value="<?=$sfax_app_key;?>" class="form-control" />
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
</body>
</html>
