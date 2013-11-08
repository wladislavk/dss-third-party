<?php 
session_start();
require_once('../includes/constants.inc');
require_once('includes/main_include.php');
include("includes/sescheck.php");
require_once('../includes/dental_patient_summary.php');
require_once('../includes/general_functions.php');
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
// Get patient id for updating patient summary table
$sql = "SELECT "
		 . "  preauth.patient_id "
		 . "FROM "
		 . "  dental_insurance_preauth preauth "
		 . "WHERE "
		 . "  preauth.id = " . $_REQUEST['ed'];
$result = mysql_query($sql);
$pid = mysql_result($result, 0);

if (isset($_REQUEST['ed'])) {
    // load preauth
    $sql = "SELECT "
         . "  hst.* "
         . "FROM "
         . "  dental_hst hst "
         . "  JOIN dental_patients p ON p.patientid = hst.patient_id "
         . "WHERE "
         . "  hst.id = " . $_REQUEST['ed'];
		$my = mysql_query($sql) or die(mysql_error());
		$hst = mysql_fetch_array($my);
} else {
    // update preauth
    $sql = "UPDATE dental_hst SET "
				 . "ins_co_id = '" . s_for($_POST["ins_co_id"]) . "', "
				 . "patient_ins_group_id = '" . s_for($_POST["patient_ins_group_id"]) . "', "
				 . "patient_ins_id = '" . s_for($_POST["patient_ins_id"]) . "', "
				 . "patient_firstname = '" . s_for($_POST["patient_firstname"]) . "', "
				 . "patient_lastname = '" . s_for($_POST["patient_lastname"]) . "', "
				 . "patient_add1 = '" . s_for($_POST["patient_add1"]) . "', "
				 . "patient_add2 = '" . s_for($_POST["patient_add2"]) . "', "
				 . "patient_city = '" . s_for($_POST["patient_city"]) . "', "
				 . "patient_state = '" . s_for($_POST["patient_state"]) . "', "
				 . "patient_zip = '" . s_for($_POST["patient_zip"]) . "', "
				 . "patient_dob = '" . s_for($_POST["patient_dob"]) . "', "
				 . "insured_firstname = '" . s_for($_POST["insured_firstname"]) . "', "
				 . "insured_lastname = '" . s_for($_POST["insured_lastname"]) . "', "
				 . "insured_dob = '" . s_for($_POST["insured_dob"]) . "', "
         			 . " status = " . s_for($_POST['status']) . " ";
    $sql .= "WHERE id = '" . $_POST["hst_id"] . "'";
    mysql_query($sql) or die($sql." | ".mysql_error());
    
    //echo $ed_sql.mysql_error();
    $msg = "HST Updated Successfully";
    print "<script type='text/javascript'>";
    print "parent.window.location='manage_hsts.php?msg=$msg'";
    print "</script>";
}

$is_complete = ($hst['status'] == DSS_PREAUTH_COMPLETE) ? true : false;
$is_rejected = ($hst['status'] == DSS_PREAUTH_REJECTED) ? true : false;
$disabled = ($is_complete || $is_rejected) ? 'DISABLED' : '';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<style>
.readonly {
  background-color: #cccccc;
}

.sub-question {
  border: 1px black solid;
  margin-top: 10px;
  margin-left: 20px;
  padding: 10px;
  display: none;
}

.question-indent {
  margin-top: 10px;
  margin-left: 20px;
}
</style>
  <?php include($_SERVER['DOCUMENT_ROOT'] . "/manage/includes/calendarinc.php"); ?>
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<script language="javascript" type="text/javascript" src="script/preauth_validation.js"></script>
<script language="JavaScript" src="../calendar2.js"></script>
<script language="javascript" type="text/javascript" src="script/preauth_form_logic.js"></script>
</head>
<body>
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="preauth_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return validatePreAuthForm(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               HST for <?= $hst['patient_firstname']; ?> <?= $hst['patient_lastname']; ?> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance Company
            </td>
            <td valign="top" class="frmdata">
	  <select name="ins_co_id" class="readonly" onclick="return false;" readonly="readonly">
<?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$hst['doc_id']."'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($hst['ins_co_id'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>;
                                
                                <?php } ?>
</select>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_firstname" value="<?=$hst['patient_firstname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_lastname" value="<?=$hst['patient_lastname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add1" class="tbox readonly" value="<?=$hst['patient_add1'];?>" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address 2
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add2" class="tbox readonly" value="<?=$hst['patient_add2'];?>" readonly />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$hst['patient_city']?>" name="patient_city" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$hst['patient_state']?>" name="patient_state" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_zip" value="<?= $hst['patient_zip']?>" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_firstname" value="<?=$hst['insured_firstname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_lastname" value="<?=$hst['insured_lastname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_dob" value="<?=$hst['insured_dob']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Group Insurance #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_group_id" value="<?=$hst['patient_ins_group_id']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance ID #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_id" value="<?=$hst['patient_ins_id']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_dob" value="<?=$hst['patient_dob']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Status
            </td>
            <td valign="top" class="frmdata">
                <select name="status" class="tbox">
			<option value="<?= DSS_HST_PENDING; ?>" <?= ($hst['status']==DSS_HST_PENDING)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_PENDING]; ?></option>
                        <option value="<?= DSS_HST_SCHEDULED; ?>" <?= ($hst['status']==DSS_HST_SCHEDULED)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_SCHEDULED]; ?></option>
                        <option value="<?= DSS_HST_COMPLETE; ?>" <?= ($hst['status']==DSS_HST_COMPLETE)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_COMPLETE]; ?></option>
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="hst_id" value="<?= $_REQUEST['ed'] ?>"/>
                  <input type="submit" value="Save HST" class="button" />
            </td>
        </tr>
    </table>
    </form>

</body>
</html>
