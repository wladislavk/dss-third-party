<?php 
session_start();
require_once('../includes/constants.inc');
require_once('includes/config.php');
include("includes/sescheck.php");

if (isset($_REQUEST['ed'])) {
    // load preauth
    $sql = "SELECT "
         . "  preauth.*, pcp.salutation as 'pcp_salutation', pcp.firstname as 'pcp_firstname', "
         . "  pcp.lastname as 'pcp_lastname', pcp.phone1 as 'pcp_phone1' "
         . "FROM "
         . "  dental_insurance_preauth preauth "
         . "  JOIN dental_patients p ON p.patientid = preauth.patient_id "
         . "  JOIN dental_contact pcp ON pcp.contactid = p.docpcp "
         . "WHERE "
         . "  preauth.id = " . $_REQUEST['ed'];
	$my = mysql_query($sql) or die(mysql_error());
	$preauth = mysql_fetch_array($my);
} else {
    // update preauth
    $sql = "UPDATE dental_insurance_preauth SET "
         . "date_of_call = '" . s_for($_POST["date_of_call"]) . "', "
         . "insurance_rep = '" . s_for($_POST["insurance_rep"]) . "', "
         . "call_reference_num = '".s_for($_POST["call_reference_num"])."', "
         . "ins_effective_date = '".s_for($_POST["ins_effective_date"])."', "
         . "ins_cal_year_start = '".s_for($_POST["ins_cal_year_start"])."', "
         . "ins_cal_year_end = '".s_for($_POST["ins_cal_year_end"])."', "
         . "trxn_code_covered = '" . $_POST["trxn_code_covered"] . "', "
         . "code_covered_notes = '".s_for($_POST["code_covered_notes"])."', "
         . "has_out_of_network_benefits = '" . $_POST["has_out_of_network_benefits"] . "', "
         . "out_of_network_percentage = '" . $_POST["out_of_network_percentage"] . "', "
         . "is_hmo = '" . $_POST["is_hmo"] . "', "
         . "hmo_date_called = '".s_for($_POST["hmo_date_called"])."', "
         . "hmo_date_received = '".s_for($_POST["hmo_date_received"])."', "
         . "hmo_needs_auth = '" . $_POST["hmo_needs_auth"] . "', "
         . "hmo_auth_date_requested = '".s_for($_POST["hmo_auth_date_requested"])."', "
         . "hmo_auth_date_received = '".s_for($_POST["hmo_auth_date_received"])."', "
         . "hmo_auth_notes = '".s_for($_POST["hmo_auth_notes"])."', "
         . "in_network_percentage = '" . $_POST["in_network_percentage"] . "', "
         . "in_network_appeal_date_sent = '".s_for($_POST["in_network_appeal_date_sent"])."', "
         . "in_network_appeal_date_received = '".s_for($_POST["in_network_appeal_date_received"])."', "
         . "is_pre_auth_required = '" . $_POST["is_pre_auth_required"] . "', "
         . "verbal_pre_auth_name = '".s_for($_POST["verbal_pre_auth_name"])."', "
         . "verbal_pre_auth_ref_num = '".s_for($_POST["verbal_pre_auth_ref_num"])."', "
         . "verbal_pre_auth_notes = '".s_for($_POST["verbal_pre_auth_notes"])."', "
         . "written_pre_auth_notes = '".s_for($_POST["written_pre_auth_notes"])."', "
         . "written_pre_auth_date_received = '".s_for($_POST["written_pre_auth_date_received"])."', "
         . "network_benefits = '" . $_POST["network_benefits"] . "', "
         . "patient_deductible = '" . $_POST["patient_deductible"] . "', "
         . "patient_amount_met = '" . $_POST["patient_amount_met"] . "', "
         . "family_deductible = '" . $_POST["family_deductible"] . "', "
         . "family_amount_met = '" . $_POST["family_amount_met"] . "', "
         . "deductible_reset_date = '".s_for($_POST["deductible_reset_date"])."', "
         . "out_of_pocket_met = '" . $_POST["out_of_pocket_met"] . "', "
         . "patient_amount_left_to_meet = '" . $_POST["patient_amount_left_to_meet"] . "', "
         . "expected_insurance_payment = '" . $_POST["expected_insurance_payment"] . "', "
         . "expected_patient_payment = '" . $_POST["expected_patient_payment"] . "' ";
    
    if (isset($_POST['complete']) && ($_POST['complete'] == '1')) {
        $sql .= ", status = " . DSS_PREAUTH_COMPLETE . " ";
    } else {
        $sql .= ", status = " . DSS_PREAUTH_PENDING . " ";
    }
    
    $sql .= "WHERE id = '" . $_POST["preauth_id"] . "'";

    mysql_query($sql) or die($sql." | ".mysql_error());
    
    //echo $ed_sql.mysql_error();
    $msg = "Pre-Authorization Completed Successfully";
    print "<script type='text/javascript'>";
    print "parent.window.location='manage_preauths.php?msg=$msg'";
    print "</script>";
}

$is_complete = ($preauth['status'] == DSS_PREAUTH_COMPLETE) ? true : false;
$disabled = ($is_complete) ? 'DISABLED' : '';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<style>
.sub-question {
  border: 1px black solid;
  margin-top: 10px;
  margin-left: 20px;
  padding: 10px;
  display: none;
}
</style>
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<script language="JavaScript" src="../calendar2.js"></script>
<script>
$(function() {
  $("input[name='has_out_of_network_benefits']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#has_out_of_network_benefits_yes').css('display', 'block');
      $('#has_out_of_network_benefits_no').css('display', 'none');
    } else {
      $('#has_out_of_network_benefits_yes').css('display', 'none');
      $('#has_out_of_network_benefits_no').css('display', 'block');
    }
  });
  $("input[name='has_out_of_network_benefits']:checked").click();
  
  $("input[name='is_hmo']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#is_hmo_yes').css('display', 'block');
      $('#is_hmo_no').css('display', 'none');
    } else {
      $('#is_hmo_yes').css('display', 'none');
      $('#is_hmo_no').css('display', 'block');
    }
  });
  $("input[name='is_hmo']:checked").click();

  $("input[name='hmo_needs_auth']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#hmo_needs_auth_yes').css('display', 'block');
    } else {
      $('#hmo_needs_auth_yes').css('display', 'none');
    }
  });
  $("input[name='hmo_needs_auth']:checked").click();

  $("input[name='is_pre_auth_required']").bind('click', function() {
    if ($(this).val() == 1) {
      $('#is_pre_auth_required_yes').css('display', 'block');
    } else {
      $('#is_pre_auth_required_yes').css('display', 'none');
    }
  });
  $("input[name='is_pre_auth_required']:checked").click();
  
  $("#ins_cal_year_end").bind("focus blur click", function() {
    $("#deductible_reset_date").val($(this).val());
  });
  $("#ins_cal_year_end").click();
  
  function calc_amount_left_to_meet() {
    var deductible = $('#patient_deductible').val();
    var amountMet  = $('#patient_amount_met').val();
    if (isNaN(deductible)) { deductible = 0; }
    if (isNaN(amountMet))  { amountMet = 0; }
    $('#patient_amount_left_to_meet').val(deductible - amountMet);
  }
  
  $("#patient_deductible, #patient_amount_met").bind("focus blur click", function() {
    calc_amount_left_to_meet();
  });
  
  function calc_expected_payments() {
    var deviceAmount = $('#trxn_code_amount').val();
    var amountLeftToMeet = $('#patient_amount_left_to_meet').val();
    var hasOutOfNetwork = $("input[name='has_out_of_network_benefits']:checked").val();
    var isHmo = $("input[name='is_hmo']:checked").val();
    var outOfPocketMet = $("input[name='out_of_pocket_met']:checked").val();
    var percentagePaid = 0;
    
    if (hasOutOfNetwork == 1) {
      // percentage from out_of_network_percentage
      percentagePaid = $('#out_of_network_percentage').val();
    } else if (isHmo == 0) {
      // percentage from in_network_percentage
      percentagePaid = $('#in_network_percentage').val();
    } else {
      // no percentage, set to 0
      percentagePaid = 0;
    }
    
    if (isNaN(deviceAmount))     { deviceAmount = 0; }
    if (isNaN(percentagePaid))   { percentagePaid = 0; }
    if (isNaN(amountLeftToMeet)) { amountLeftToMeet = 0; }
    
    if (outOfPocketMet == 1) {
      $('#expected_insurance_payment').val(deviceAmount);
      $('#expected_patient_payment').val('0');
    } else {
      var expectedInsurancePayment = (deviceAmount - amountLeftToMeet) * (percentagePaid/100);
      var expectedPatientPayment = deviceAmount - expectedInsurancePayment;
      $('#expected_insurance_payment').val(expectedInsurancePayment.toFixed(2));
      $('#expected_patient_payment').val(expectedPatientPayment.toFixed(2));
    }
  }
  
  $("#patient_deductible, #patient_amount_met, #family_deductible, #family_amount_met, #out_of_pocket_met").bind("focus blur click", function() {
    calc_expected_payments();
  });
});
</script>
</head>
<body>
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="preauth_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return userabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               Pre-Authorization for <?= $preauth['patient_firstname']; ?> <?= $preauth['patient_lastname']; ?> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance Company
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="ins_co" value="<?=$preauth['ins_co']?>" class="tbox" DISABLED/>
                <span class="red">*</span>
                (<?= $preauth['ins_rank'] ?>)
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insurance Company's Phone #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="ins_phone" value="<?=$preauth['ins_phone']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_firstname" value="<?=$preauth['patient_firstname']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_lastname" value="<?=$preauth['patient_lastname']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add1" class="tbox" value="<?=$preauth['patient_add1'];?>" DISABLED/>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address 2
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add2" class="tbox" value="<?=$preauth['patient_add2'];?>" DISABLED/>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$preauth['patient_city']?>" name="patient_city" class="tbox" DISABLED/>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$preauth['patient_state']?>" name="patient_state" class="tbox" DISABLED/>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_zip" value="<?= $preauth['patient_zip']?>" class="tbox" DISABLED/>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_first_name" value="<?=$preauth['insured_first_name']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_last_name" value="<?=$preauth['insured_last_name']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_dob" value="<?=$preauth['insured_dob']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Group Insurance #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_group_id" value="<?=$preauth['patient_ins_group_id']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance ID #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins__id" value="<?=$preauth['patient_ins_id']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_dob" value="<?=$preauth['patient_dob']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Franchisee's NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_npi" value="<?=$preauth['doc_npi']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Franchisee's Medicare NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_medicare_npi" value="<?=$preauth['doc_medicare_npi']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Franchisee's Tax ID or SSN
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_tax_id_or_ssn" value="<?=$preauth['doc_tax_id_or_ssn']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Referring Doctor's NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="referring_doc_npi" value="<?=$preauth['referring_doc_npi']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Code E0486 - Durable Medical Equipment Amount
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" name="trxn_code_amount" value="<?=$preauth['trxn_code_amount']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Diagnosis Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="diagnosis_code" value="<?=$preauth['diagnosis_code']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Date of Call
            </td>
            <td valign="top" class="frmdata">
                <?php if (empty($preauth['date_of_call'])) { $preauth['date_of_call'] = date('d/m/Y'); } ?>
                <input id="date_of_call" type="text" name="date_of_call" value="<?=$preauth['date_of_call']?>" onclick="cal1.popup();" onchange="validateDate('date_of_call');" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Name of Insurance Representative
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insurance_rep" value="<?=$preauth['insurance_rep']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Reference # pertaining to call
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="call_reference_num" value="<?=$preauth['call_reference_num']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insurance Effective Date
            </td>
            <td valign="top" class="frmdata">
                <input id="ins_effective_date" type="text" name="ins_effective_date" value="<?=$preauth['ins_effective_date']?>" onclick="cal2.popup();" onchange="validateDate('ins_effective_date');" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insurance Calendar Year
            </td>
            <td valign="top" class="frmdata">
                from <input id="ins_cal_year_start" type="text" name="ins_cal_year_start" value="<?=$preauth['ins_cal_year_start']?>" onclick="cal3.popup();" onchange="validateDate('ins_cal_year_start');" class="tbox" style="width:125px" <?=$disabled?>/>
                to <input id="ins_cal_year_end" type="text" name="ins_cal_year_end" value="<?=$preauth['ins_cal_year_end']?>" onclick="cal4.popup();" onchange="validateDate('ins_cal_year_end');" class="tbox" style="width:125px" <?=$disabled?>/>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Is this code covered under their plan?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['trxn_code_covered'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['trxn_code_covered'] != '1') ? 'CHECKED' : ''; ?>
                <input type="radio" name="trxn_code_covered" value="1" <?= $yes_checked ?> <?=$disabled?>/> Yes
                <input type="radio" name="trxn_code_covered" value="0" <?= $no_checked ?> <?=$disabled?>/> No
                <br/><br/>
                Notes:<br/>
                <textarea name="code_covered_notes" class="tbox" <?=$disabled?>><?=$preauth['code_covered_notes']?></textarea>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Does the patient have "out-of-network" benefits?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['has_out_of_network_benefits'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $no_checked  = ($preauth['has_out_of_network_benefits'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="has_out_of_network_benefits" value="1" <?= $yes_checked ?> <?=$disabled?>/> Yes
                <input type="radio" name="has_out_of_network_benefits" value="0" <?= $no_checked ?> <?=$disabled?>/> No
                <br/><br/>

                <div id="has_out_of_network_benefits_yes" class="sub-question">
                  What percent do they pay an "out-of-network" provider?
                  <input type="text" id="out_of_network_percentage" name="out_of_network_percentage" value="<?=$preauth['out_of_network_percentage']?>" class="tbox" <?=$disabled?>/>% (enter 0-100)
                </div>
                
                <div id="has_out_of_network_benefits_no" class="sub-question">
                  Is this an HMO?
                  <?php $yes_checked = ($preauth['is_hmo'] == '1') ? 'CHECKED' : ''; ?>
                  <?php $no_checked  = ($preauth['is_hmo'] != '1') ? 'CHECKED' : ''; ?>
                  <input type="radio" name="is_hmo" value="1" <?= $yes_checked ?> <?=$disabled?>/> Yes
                  <input type="radio" name="is_hmo" value="0" <?= $no_checked ?> <?=$disabled?>/> No
                  
                  <div id="is_hmo_yes" class="sub-question">
                    Call primary care physician to obtain referral:<br/>
                    <?= $preauth['pcp_salutation'] ?>
                    <?= $preauth['pcp_firstname'] ?>
                    <?= $preauth['pcp_lastname'] ?><br/>
                    <?= $preauth['pcp_phone'] ?><br/>
                    <br/>
                    <?php if (empty($preauth['hmo_date_called'])) { $preauth['hmo_date_called'] = date('d/m/Y'); } ?>
                    Date Called <input id="hmo_date_called" type="text" name="hmo_date_called" value="<?=$preauth['hmo_date_called']?>" onclick="cal5.popup();" onchange="validateDate('hmo_date_called');" class="tbox" <?=$disabled?>/><br/>
                    Date Received <input id="hmo_date_received" type="text" name="hmo_date_received" value="<?=$preauth['hmo_date_received']?>" onclick="cal6.popup();" onchange="validateDate('hmo_date_received');" class="tbox" <?=$disabled?>/> <br/>
                    <br/>
                    
                    Is it necessary to obtain authorization for appropriate appointments and/or codes (not to be confused with a pre-authorization)?<br/>
                    <?php $yes_checked = ($preauth['hmo_needs_auth'] == '1') ? 'CHECKED' : ''; ?>
                    <?php $no_checked  = ($preauth['hmo_needs_auth'] != '1') ? 'CHECKED' : ''; ?>
                    <input type="radio" name="hmo_needs_auth" value="1" <?= $yes_checked ?> <?=$disabled?>/> Yes
                    <input type="radio" name="hmo_needs_auth" value="0" <?= $no_checked ?> <?=$disabled?>/> No
                    <br/><br/>
                    
                    <div id="hmo_needs_auth_yes" class="sub-question">
                      Date Requested <input id="hmo_auth_date_requested" type="text" name="hmo_auth_date_requested" value="<?=$preauth['hmo_auth_date_requested']?>" onclick="cal7.popup();" onchange="validateDate('hmo_auth_date_requested');" class="tbox" <?=$disabled?>/><br/>
                      Date Received <input id="hmo_auth_date_received" type="text" name="hmo_auth_date_received" value="<?=$preauth['hmo_auth_date_received']?>" onclick="cal8.popup();" onchange="validateDate('hmo_auth_date_received');" class="tbox" <?=$disabled?>/> 
                    </div>
                    <br/>
                    
                    Notes:<br/>
                    <textarea name="hmo_auth_notes" class="tbox" <?=$disabled?>><?=$preauth['hmo_auth_notes']?></textarea>
                  </div>

                  <div id="is_hmo_no" class="sub-question">
                    What percent do they pay an "in-network" provider?
                    <input type="text" id="in_network_percentage" name="in_network_percentage" value="<?=$preauth['in_network_percentage']?>" class="tbox" <?=$disabled?>/>% (enter 0-100)
                    <br/><br/>
                    Appeal for in network benefits needed.
                    <br/><br/>
                    Date Requested <input id="in_network_appeal_date_sent" type="text" name="in_network_appeal_date_sent" value="<?=$preauth['in_network_appeal_date_sent']?>" onclick="cal9.popup();" onchange="validateDate('in_network_appeal_date_sent');" class="tbox" <?=$disabled?>/><br/>
                    Date Received <input id="in_network_appeal_date_received" type="text" name="in_network_appeal_date_received" value="<?=$preauth['in_network_appeal_date_received']?>" onclick="cal10.popup();" onchange="validateDate('in_network_appeal_date_received');" class="tbox" <?=$disabled?>/> 
                  </div>
                </div>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Is Pre-Authorization required?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['is_pre_auth_required'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['is_pre_auth_required'] != '1') ? 'CHECKED' : ''; ?>
                <input type="radio" name="is_pre_auth_required" value="1" <?= $yes_checked ?> <?=$disabled?>/> Yes
                <input type="radio" name="is_pre_auth_required" value="0" <?= $no_checked ?> <?=$disabled?>/> No
                <br/><br/>

                <div id="is_pre_auth_required_yes" class="sub-question">
                  <h3>Verbal</h3>
                  Name <input type="text" name="verbal_pre_auth_name" value="<?=$preauth['verbal_pre_auth_name']?>" class="tbox" <?=$disabled?>/><br/>
                  Ref Num <input type="text" name="verbal_pre_auth_ref_num" value="<?=$preauth['verbal_pre_auth_ref_num']?>" class="tbox" <?=$disabled?>/><br/>
                  Notes<br/><textarea name="verbal_pre_auth_notes" class="tbox" <?=$disabled?>><?=$preauth['verbal_pre_auth_notes']?></textarea><br/>
                  
                  <h3>Written</h3>
                  Date Received <input id="written_pre_auth_date_received" type="text" name="written_pre_auth_date_received" value="<?=$preauth['written_pre_auth_date_received']?>" onclick="cal11.popup();" onchange="validateDate('written_pre_auth_date_received');" class="tbox" <?=$disabled?>/> <br/>
                  Notes<br/><textarea name="written_pre_auth_notes" class="tbox" <?=$disabled?>><?=$preauth['written_pre_auth_notes']?></textarea><br/>
                </div>
            </td>
        </tr>
        <tr><td  colspan="2" align="center">&nbsp;</td></tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Benefits
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['network_benefits'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $no_checked  = ($preauth['network_benefits'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="network_benefits" value="1" <?= $yes_checked ?> <?=$disabled?>/> Out of network
                <input type="radio" name="network_benefits" value="0" <?= $no_checked ?> <?=$disabled?>/> In Network
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient Deductible
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_deductible" name="patient_deductible" value="<?=$preauth['patient_deductible']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_amount_met" name="patient_amount_met" value="<?=$preauth['patient_amount_met']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient amount left to meet
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_amount_left_to_meet" name="patient_amount_left_to_meet" value="<?=$preauth['patient_amount_left_to_meet']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Familiy Deductible
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_deductible" name="family_deductible" value="<?=$preauth['family_deductible']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Family amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_amount_met" name="family_amount_met" value="<?=$preauth['family_amount_met']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                When does the deductible reset?
            </td>
            <td valign="top" class="frmdata">
                <input type="text" id="deductible_reset_date" name="deductible_reset_date" value="<?=$preauth['deductible_reset_date']?>" class="tbox" <?=$disabled?>/> <br/>
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Has patient's out-of-pocket expense been met?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['out_of_pocket_met'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['out_of_pocket_met'] != '1') ? 'CHECKED' : ''; ?>
                <input type="radio" name="out_of_pocket_met" value="1" <?= $yes_checked ?> <?=$disabled?>/> Yes
                <input type="radio" name="out_of_pocket_met" value="0" <?= $no_checked ?> <?=$disabled?>/> No
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Device amount
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="trxn_code_amount" name="trxn_code_amount" value="<?=$preauth['trxn_code_amount']?>" class="tbox" DISABLED/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Expected insurance payment
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="expected_insurance_payment" name="expected_insurance_payment" value="<?=$preauth['expected_insurance_payment']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Expected patient payment
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="expected_patient_payment" name="expected_patient_payment" value="<?=$preauth['expected_patient_payment']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="preauth_id" value="<?= $_REQUEST['ed'] ?>"/>
                Mark Complete <input type="checkbox" name="complete" value="1" <?php if ($is_complete) { print 'CHECKED'; } ?> <?=$disabled?>/>
                <?php if (!$is_complete) { ?>
                  <input type="submit" value="Save Pre-Authorization" class="button" />
                <?php } ?>
            </td>
        </tr>
    </table>
    </form>

<script type="text/javascript">
  var cal1 = new calendar2(document.getElementById('date_of_call'));
  var cal2 = new calendar2(document.getElementById('ins_effective_date'));
  var cal3 = new calendar2(document.getElementById('ins_cal_year_start'));
  var cal4 = new calendar2(document.getElementById('ins_cal_year_end'));
  var cal5 = new calendar2(document.getElementById('hmo_date_called'));
  var cal6 = new calendar2(document.getElementById('hmo_date_received'));
  var cal7 = new calendar2(document.getElementById('hmo_auth_date_requested'));
  var cal8 = new calendar2(document.getElementById('hmo_auth_date_received'));
  var cal9 = new calendar2(document.getElementById('in_network_appeal_date_sent'));
  var cal10 = new calendar2(document.getElementById('in_network_appeal_date_received'));
  var cal11 = new calendar2(document.getElementById('written_pre_auth_date_received'));
</script>
</body>
</html>
