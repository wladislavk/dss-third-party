<?php namespace Ds3\Libraries\Legacy; ?><?php 
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
//include "includes/general_functions.php";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="js/masks.js"></script>
    <link rel="stylesheet" href="css/form.css" type="text/css" />
</head>
<body>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if(!empty($_POST["contactsub"]) && $_POST["contactsub"] == 1){
    $ins_sql = "insert into dental_contact set company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', contacttypeid = '11', notes = '".s_for($_POST["notes"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["status"])."', preferredcontact = '".$preferredcontact."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
    $pc_id = $db->getInsertId($ins_sql);
    $pcsql = "SELECT patientid, insurancetype FROM dental_patient_insurance WHERE id='".mysqli_real_escape_string($con,$_REQUEST['id'])."'";
    $pcr = $db->getRow($pcsql);
    $psql = "UPDATE dental_patients SET ";
    switch($pcr['insurancetype']){
        case '1':
        default:
            $psql .= " p_m_ins_co ";
            break;
        case '2':
            $psql .= " s_m_ins_co ";
            break;
    }
    $psql .= " = '".$pc_id."' WHERE patientid='".$pcr['patientid']."' OR parent_patientid='".$pcr['patientid']."'";
    //echo $psql;
    $db->query($psql);
    $d = "DELETE FROM dental_patient_insurance where id='".mysqli_real_escape_string($con,$_REQUEST['id'])."'";
    $db->query($d);?>
    <script type="text/javascript">
        parent.window.location = "patient_changes.php?pid=<?php echo $pcr['patientid']; ?>";
    </script>
    <?php	
}
?>
<?php /*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
</head>
<body width="98%"> */ ?>

<?php
$thesql = "select * from dental_patient_insurance where id='".mysqli_real_escape_string($con,(!empty($_REQUEST["id"]) ? $_REQUEST["id"] : ''))."'";
$themyarray = $db->getRow($thesql);

$lastname = st(!empty($themyarray['lastname']) ? $themyarray['lastname'] : '');
$company = st($themyarray['company']);
$add1 = st($themyarray['address1']);
$add2 = st($themyarray['address2']);
$city = st($themyarray['city']);
$state = st($themyarray['state']);
$zip = st($themyarray['zip']);
$phone1 = st($themyarray['phone']);
$phone2 = st(!empty($themyarray['phone2']) ? $themyarray['phone2'] : '');
$fax = st($themyarray['fax']);
$email = st($themyarray['email']);
$national_provider_id = st(!empty($themyarray['national_provider_id']) ? $themyarray['national_provider_id'] : '');
$qualifier = st(!empty($themyarray['qualifier']) ? $themyarray['qualifier'] : '');
$qualifierid = st(!empty($themyarray['qualifierid']) ? $themyarray['qualifierid'] : '');
$greeting = st(!empty($themyarray['greeting']) ? $themyarray['greeting'] : '');
$sincerely = st(!empty($themyarray['sincerely']) ? $themyarray['sincerely'] : '');
$contacttypeid = st(!empty($themyarray['contacttypeid']) ? $themyarray['contacttypeid'] : '');
$notes = st(!empty($themyarray['notes']) ? $themyarray['notes'] : '');
$preferredcontact = st(!empty($themyarray['preferredcontact']) ? $themyarray['preferredcontact'] : '');
$name = st(!empty($themyarray['firstname']) ? $themyarray['firstname'] : '')." ".st(!empty($themyarray['middlename']) ? $themyarray['middlename'] : '')." ".st(!empty($themyarray['lastname']) ? $themyarray['lastname'] : '');

$but_text = "Add ";
?>
	
<br /><br />

<?php if(!empty($msg)) { ?>
    <div align="center" class="red">
        <?php echo $msg;?>
    </div>
<?php } ?>
<form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" onSubmit="return patinsabc(this)">
    <input type="hidden" name="contact_type" value="<?php echo (!empty($_GET['ctype']) ? $_GET['ctype'] : ''); ?>" />
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
        		Add Insurance Company
            </td>
        </tr>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            <span>
                            <span style="color:#000000">Company <?php echo (!empty($_GET['ctype']) && $_GET['ctype']=='ins')?'<span id="req_0" class="req">*</span>':''; ?></span>
                            <input id="company" name="company" type="text" class="field text addr tbox" value="<?php echo $company;?>" tabindex="5" style="width:575px;"  maxlength="255"/>
                            </span>
                        </label>
                    </li>
				</ul>
            </td>
        </tr>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            Address
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                            <span>
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="<?php echo $add1?>" tabindex="6" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="<?php echo $add2?>" tabindex="7" style="width:325px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="<?php echo $city?>" tabindex="8" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" class="field text addr tbox" value="<?php echo $state?>" tabindex="9" style="width:80px;" maxlength="255" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="<?php echo $zip?>" tabindex="10" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip / Post Code </label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div>
                            <span>
                                <input id="phone1" name="phone1" type="text" class="extphonemask field text addr tbox" value="<?php echo $phone1?>" tabindex="11" maxlength="255" style="width:200px;" />
                                <label for="phone1">Phone 1</label>
                            </span>
                            <span>
                                <input id="phone2" name="phone2" type="text" class="extphonemask field text addr tbox" value="<?php echo $phone2?>" tabindex="12" maxlength="255" style="width:200px;" />
                                <label for="phone2">Phone 2</label>
                            </span>
                            <span>
                                <input id="fax" name="fax" type="text" class="phonemask field text addr tbox" value="<?php echo $fax?>" tabindex="13" maxlength="255" style="width:200px;" />
                                <label for="fax">Fax</label>
                            </span>
						</div>
                        <div>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="<?php echo $email?>" tabindex="14" maxlength="255" style="width:325px;" />
                                <label for="email">Email</label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
         <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	 <label class="desc" id="title0" for="Field0">
                            Notes:
                        </label>
                        <div>
                            <span class="full">
                            	<textarea name="notes" id="notes" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?php echo $notes?></textarea>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Preferred Contact Method
            </td>
            <td valign="top" class="frmdata">
            	<select id="preferredcontact" name="preferredcontact" class="tbox" tabindex="22">
                	<option value="paper" <?php if($preferredcontact == 'paper') echo " selected";?>>Paper Mail</option>
                	<option value="email" <?php if($preferredcontact == 'email') echo " selected";?>>Email</option>
                	<option value="fax" <?php if($preferredcontact == 'fax') echo " selected";?>>Fax</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
        
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="tbox" tabindex="22">
                	<option value="1" <?php if(!empty($status) && $status == 1) echo " selected";?>>Active</option>
                	<option value="2" <?php if(!empty($status) && $status == 2) echo " selected";?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="contactsub" value="1" />
                <input type="hidden" name="id" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" value=" <?php echo $but_text?> Contact" class="button" />
            </td>
        </tr>
    </table>
</form>
</div>
<!--<div style="margin:0 auto;background:url(images/dss_05.png) no-repeat top left;width:980px; height:28px;"> </div>
  </td>
</tr>-->
<!-- Stick Footer Section Here -->
<!--</table>-->
<!--<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
-->
</body>
</html>
