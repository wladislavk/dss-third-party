<?php 
session_start();
require_once('../includes/constants.inc');
require_once('includes/config.php');
include("includes/sescheck.php");

if (isset($_REQUEST['ed'])) {
    // load preauth
    $sql = "SELECT "
         . "  preauth.*, pcp.salutation as 'pcp_salutation', pcp.firstname as 'pcp_firstname', "
         . "  pcp.lastname as 'pcp_lastname', pcp.phone1 as 'pcp_phone1', p.patientid as 'patientid' "
         . "FROM "
         . "  dental_insurance_preauth preauth "
         . "  JOIN dental_patients p ON p.patientid = preauth.patient_id "
         . "  LEFT OUTER JOIN dental_contact pcp ON pcp.contactid = p.docpcp "
         . "WHERE "
         . "  preauth.id = " . $_REQUEST['ed'];
		$my = mysql_query($sql) or die(mysql_error());
		$preauth = mysql_fetch_array($my);
		// load dynamic preauth info
		$sql = "SELECT "
		 . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
		 . "  p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
		 . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
		 . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
		 . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
		 . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
		 . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "
		 . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
		 . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
		 . "  p.home_phone as 'patient_phone'  "
		 . "FROM "
		 . "  dental_patients p  "
		 . "  JOIN dental_referredby r ON p.referred_by = r.referredbyid  "
		 . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
		 . "  JOIN dental_users d ON p.docid = d.userid "
		 . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
		 . "  JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
		 . "WHERE "
		 . "  p.patientid = ".$preauth['patientid'];

		$my = mysql_query($sql);
		$my_array = mysql_fetch_array($my);
		$preauth = array_merge($preauth, $my_array);
} else {
    // update preauth
    $sql = "UPDATE dental_insurance_preauth SET "
				 . "ins_co = '" . s_for($_POST["ins_co"]) . "', "
				 . "ins_rank = '" . s_for($_POST["ins_rank"]) . "', "
				 . "ins_phone = '" . s_for($_POST["ins_phone"]) . "', "
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
				 . "insured_first_name = '" . s_for($_POST["insured_first_name"]) . "', "
				 . "insured_last_name = '" . s_for($_POST["insured_last_name"]) . "', "
				 . "insured_dob = '" . s_for($_POST["insured_dob"]) . "', "
				 . "doc_npi = '" . s_for($_POST["doc_npi"]) . "', "
				 . "referring_doc_npi = '" . s_for($_POST["referring_doc_npi"]) . "', "
				 . "doc_medicare_npi = '" . s_for($_POST["doc_medicare_npi"]) . "', "
				 . "doc_tax_id_or_ssn = '" . s_for($_POST["doc_tax_id_or_ssn"]) . "', "
				 . "trxn_code_amount = '" . s_for($_POST["trxn_code_amount"]) . "', "
				 . "diagnosis_code = '" . s_for($_POST["diagnosis_code"]) . "', "
				 . "patient_phone = '" . s_for($_POST["patient_phone"]) . "', "
         . "date_of_call = '" . s_for($_POST["date_of_call"]) . "', "
         . "insurance_rep = '" . s_for($_POST["insurance_rep"]) . "', "
         . "call_reference_num = '".s_for($_POST["call_reference_num"])."', "
         . "ins_effective_date = '".s_for($_POST["ins_effective_date"])."', "
         . "ins_cal_year_start = '".s_for($_POST["ins_cal_year_start"])."', "
         . "ins_cal_year_end = '".s_for($_POST["ins_cal_year_end"])."', "
         . "trxn_code_covered = '" . s_for($_POST["trxn_code_covered"]) . "', "
         . "code_covered_notes = '".s_for($_POST["code_covered_notes"])."', "
         . "how_often = '".s_for($_POST["how_often"])."', "
         . "has_out_of_network_benefits = '" . $_POST["has_out_of_network_benefits"] . "', "
         . "out_of_network_percentage = '" . $_POST["out_of_network_percentage"] . "', "
         . "is_hmo = '" . $_POST["is_hmo"] . "', "
         . "hmo_date_called = '".s_for($_POST["hmo_date_called"])."', "
         . "hmo_date_received = '".s_for($_POST["hmo_date_received"])."', "
         . "hmo_needs_auth = '" . $_POST["hmo_needs_auth"] . "', "
         . "hmo_auth_date_requested = '".s_for($_POST["hmo_auth_date_requested"])."', "
         . "hmo_auth_date_received = '".s_for($_POST["hmo_audoc_tax_id_or_ssnth_date_received"])."', "
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
        $sql .= ", date_completed = NOW() ";
    } else {
        $sql .= ", status = " . DSS_PREAUTH_PENDING . " ";
    }
    $sql .= "WHERE id = '" . $_POST["preauth_id"] . "'";
    mysql_query($sql) or die($sql." | ".mysql_error());
    
    //echo $ed_sql.mysql_error();
    $task_label = (!empty($_POST['completed'])) ? 'Completed' : 'Updated';
    $msg = "Pre-Authorization $task_label Successfully";
    print "<script type='text/javascript'>";
    print "parent.window.location='manage_preauths.php?msg=$msg'";
    print "</script>";
}

$is_complete = ($preauth['status'] == DSS_PREAUTH_COMPLETE) ? true : false;
$disabled = ($is_complete) ? 'disabled' : '';
$bgcolor = ($is_complete) ? 'style="background-color:#cccccc;color:#3c3c3c;"' : '';

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
<script language="javascript" type="text/javascript" src="script/preauth_validation.js"></script>
<script language="JavaScript" src="../calendar2.js"></script>
<script>
$(function() {
  //$('input, select, textarea').each(function() { console.log($(this).attr('name')); });
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
  $("#ins_cal_year_end").blur();
  
  function calc_amount_left_to_meet() {
    var deductible = $('#patient_deductible').val();
    var amountMet  = $('#patient_amount_met').val();
    if (isNaN(deductible)) { deductible = 0; }
    if (isNaN(amountMet))  { amountMet = 0; }
    var leftToMeet = deductible - amountMet;
    if (leftToMeet < 0) { leftToMeet = 0; }
    $('#patient_amount_left_to_meet').val(leftToMeet.toFixed(2));
  }
  
  $("#patient_deductible, #patient_amount_met").bind("focus blur click", function() {
    calc_amount_left_to_meet();
  });
  
  function calc_expected_payments() {
    var debug = false;
    if (debug) { console.log('calc_expected_payments'); }
    
    var deviceAmount = $('#trxn_code_amount').val();
    var amountLeftToMeet = $('#patient_amount_left_to_meet').val();
    var hasOutOfNetwork = $("input[name='has_out_of_network_benefits']:checked").val();
    var isHmo = $("input[name='is_hmo']:checked").val();
    var outOfPocketMet = $("input[name='out_of_pocket_met']:checked").val();
    var percentagePaid = 0;
    
    if (debug) { 
      console.log('amountLeftToMeet: ' + amountLeftToMeet);
      console.log('hasOutOfNetwork: ' + hasOutOfNetwork);
      console.log('isHmo: ' + isHmo);
      console.log('outOfPocketMet: ' + outOfPocketMet);
    }
    
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
    
    if (debug) { console.log('percentagePaid: ' + percentagePaid); }

    if (isNaN(deviceAmount))     { deviceAmount = 0; }
    if (isNaN(percentagePaid))   { percentagePaid = 0; }
    if (isNaN(amountLeftToMeet)) { amountLeftToMeet = 0; }
    
    if (outOfPocketMet == 1) {
      $('#expected_insurance_payment').val(deviceAmount);
      $('#expected_patient_payment').val('0.00');
      if (debug) { 
        console.log('expected_insurance_payment: ' + deviceAmount);
        console.log('expected_patient_payment: ' + 0.00);
      }
    } else {
      var expectedInsurancePayment = (deviceAmount - amountLeftToMeet) * (percentagePaid/100);
      if (expectedInsurancePayment < 0) { expectedInsurancePayment = 0; }

      var expectedPatientPayment = deviceAmount - expectedInsurancePayment;
      if (expectedPatientPayment < 0) { expectedPatientPayment = 0; }

      if (debug) { 
        console.log('expectedInsurancePayment: ' + expectedInsurancePayment.toFixed(2));
        console.log('expectedPatientPayment: ' + expectedPatientPayment.toFixed(2));
      }
      $('#expected_insurance_payment').val(expectedInsurancePayment.toFixed(2));
      $('#expected_patient_payment').val(expectedPatientPayment.toFixed(2));
    }
    
    if (debug) { console.log('-----------------------'); }
  }
  
  // Fields that should be clear on focus if value is 0
  $('#patient_deductible, #patient_amount_met, #family_deductible, #family_amount_met').bind('focus', function() {
    var value = $(this).val();
    if (isNaN(value) || (value == 0)) {
      $(this).val('');
    }
  });
  
  // Fields that should display two decimal places on blur
  $('#patient_deductible, #patient_amount_met, #family_deductible, #family_amount_met').bind('blur', function() {
    var value = parseFloat($(this).val());
    if (!isNaN(value)) {
      $(this).val(value.toFixed(2));
    }
  });
  
  // Fields that should trigger calculations
  $('#out_of_network_percentage, #in_network_percentage, #patient_deductible, #patient_amount_met').bind("mouseup keyup", function() {
    calc_expected_payments();
  });
  $("[name='has_out_of_network_benefits'], [name='is_hmo'], [name='out_of_pocket_met']").bind('change', function() {
    calc_expected_payments();
  });
  
  // Fields where the user shouldn't be able to gain focus
  $('#patient_amount_left_to_meet, #deductible_reset_date, #expected_insurance_payment, #expected_patient_payment').bind('focus', function() {
    $(this).blur();
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
    <form name="preauth_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return validatePreAuthForm(this)">
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
                <input type="text" name="ins_co" value="<?=$preauth['ins_co']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly />
                <span class="red">*</span>
                (<?= $preauth['ins_rank'] ?>)
								<input type="hidden" value="<?= $preauth['ins_rank'] ?>" />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insurance Company's Phone #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="ins_phone" value="<?=$preauth['ins_phone']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_firstname" value="<?=$preauth['patient_firstname']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_lastname" value="<?=$preauth['patient_lastname']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Phone #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_phone" value="<?=$preauth['patient_phone']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add1" class="tbox" value="<?=$preauth['patient_add1'];?>" style="background-color:#cccccc;color:#3c3c3c;" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address 2
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add2" class="tbox" value="<?=$preauth['patient_add2'];?>" style="background-color:#cccccc;color:#3c3c3c;" readonly />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$preauth['patient_city']?>" name="patient_city" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$preauth['patient_state']?>" name="patient_state" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_zip" value="<?= $preauth['patient_zip']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_first_name" value="<?=$preauth['insured_first_name']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_last_name" value="<?=$preauth['insured_last_name']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_dob" value="<?=$preauth['insured_dob']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Group Insurance #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_group_id" value="<?=$preauth['patient_ins_group_id']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance ID #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_id" value="<?=$preauth['patient_ins_id']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_dob" value="<?=$preauth['patient_dob']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Franchisee's NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_npi" value="<?=$preauth['doc_npi']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Franchisee's Medicare NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_medicare_npi" value="<?=$preauth['doc_medicare_npi']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Franchisee's Tax ID or SSN
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_tax_id_or_ssn" value="<?=$preauth['doc_tax_id_or_ssn']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Referring Doctor's NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="referring_doc_npi" value="<?=$preauth['referring_doc_npi']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Code E0486 - Durable Medical Equipment Amount
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" name="trxn_code_amount" value="<?=$preauth['trxn_code_amount']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Diagnosis Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="diagnosis_code" value="<?=$preauth['diagnosis_code']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Date of Call
            </td>
            <td valign="top" class="frmdata">
                <?php if (empty($preauth['date_of_call'])) { $preauth['date_of_call'] = date('m/d/Y'); } ?>
                <input id="date_of_call" type="text" name="date_of_call" value="<?=$preauth['date_of_call']?>" onclick="cal1.popup();" onchange="validateDate('date_of_call');" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Name of Insurance Representative
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insurance_rep" value="<?=$preauth['insurance_rep']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Reference # pertaining to call
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="call_reference_num" value="<?=$preauth['call_reference_num']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insurance Effective Date
            </td>
            <td valign="top" class="frmdata">
                <input id="ins_effective_date" type="text" name="ins_effective_date" value="<?=$preauth['ins_effective_date']?>" onclick="cal2.popup();" onchange="validateDate('ins_effective_date');" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insurance Calendar Year
            </td>
            <td valign="top" class="frmdata">
                from <input id="ins_cal_year_start" type="text" name="ins_cal_year_start" value="<?=$preauth['ins_cal_year_start']?>" onclick="cal3.popup();" onchange="validateDate('ins_cal_year_start');" class="tbox" style="width:125px;<?php print $is_complete ? 'background-color:#cccccc;color:#3c3c3c;' : ''; ?>" <?=$disabled?>/>
                to <input id="ins_cal_year_end" type="text" name="ins_cal_year_end" value="<?=$preauth['ins_cal_year_end']?>" <onclick="cal4.popup();" onchange="validateDate('ins_cal_year_end');" class="tbox" style="width:125px;<?php print $is_complete ? 'background-color:#cccccc;color:#3c3c3c;' : ''; ?>" <?=$bgcolor?> <?=$disabled?>/>
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
                <input type="radio" name="trxn_code_covered" value="1" <?= $yes_checked ?> <?=$bgcolor?> <?=$disabled?>/> Yes
                <input type="radio" name="trxn_code_covered" value="0" <?= $no_checked ?> <?=$bgcolor?> <?=$disabled?>/> No
                <br/><br/>
                Notes:<br/>
                <textarea name="code_covered_notes" class="tbox" <?=$bgcolor?> <?=$disabled?>><?=$preauth['code_covered_notes']?></textarea>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                How often will you pay for another device?
            </td>
            <td class="frmdata">
                <input id="how_often" type="text" name="how_often" value="<?=$preauth['how_often']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/> years
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Does the patient have "out-of-network" benefits?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['has_out_of_network_benefits'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $no_checked  = ($preauth['has_out_of_network_benefits'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="has_out_of_network_benefits" value="1" <?= $yes_checked ?> <?=$bgcolor?> <?=$disabled?>/> Yes
                <input type="radio" name="has_out_of_network_benefits" value="0" <?= $no_checked ?> <?=$bgcolor?> <?=$disabled?>/> No
                <br/><br/>

                <div id="has_out_of_network_benefits_yes" class="sub-question">
                  What percent do they pay an "out-of-network" provider?
                  <input type="text" id="out_of_network_percentage" name="out_of_network_percentage" value="<?=$preauth['out_of_network_percentage']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/>% (enter 0-100)
                </div>
                
                <div id="has_out_of_network_benefits_no" class="sub-question">
                  Is this an HMO?
                  <?php $yes_checked = ($preauth['is_hmo'] == '1') ? 'CHECKED' : ''; ?>
                  <?php $no_checked  = ($preauth['is_hmo'] != '1') ? 'CHECKED' : ''; ?>
                  <input type="radio" name="is_hmo" value="1" <?= $yes_checked ?> <?=$bgcolor?> <?=$disabled?>/> Yes
                  <input type="radio" name="is_hmo" value="0" <?= $no_checked ?> <?=$bgcolor?> <?=$disabled?>/> No
                  
                  <div id="is_hmo_yes" class="sub-question">
                    Call primary care physician to obtain referral:<br/>
                    <?= $preauth['pcp_salutation'] ?>
                    <?= $preauth['pcp_firstname'] ?>
                    <?= $preauth['pcp_lastname'] ?><br/>
                    <?= $preauth['pcp_phone'] ?><br/>
                    <br/>
                    <?php if (empty($preauth['hmo_date_called'])) { $preauth['hmo_date_called'] = date('m/d/Y'); } ?>
                    Date Called <input id="hmo_date_called" type="text" name="hmo_date_called" value="<?=$preauth['hmo_date_called']?>" onclick="cal5.popup();" onchange="validateDate('hmo_date_called');" class="tbox" <?=$bgcolor?> <?=$disabled?>/><br/>
                    Date Received <input id="hmo_date_received" type="text" name="hmo_date_received" value="<?=$preauth['hmo_date_received']?>" onclick="cal6.popup();" onchange="validateDate('hmo_date_received');" class="tbox" <?=$bgcolor?> <?=$disabled?>/> <br/>
                    <br/>
                    
                    Is it necessary to obtain authorization for appropriate appointments and/or codes (not to be confused with a pre-authorization)?<br/>
                    <?php $yes_checked = ($preauth['hmo_needs_auth'] == '1') ? 'CHECKED' : ''; ?>
                    <?php $no_checked  = ($preauth['hmo_needs_auth'] != '1') ? 'CHECKED' : ''; ?>
                    <input type="radio" name="hmo_needs_auth" value="1" <?= $yes_checked ?> <?=$bgcolor?> <?=$disabled?>/> Yes
                    <input type="radio" name="hmo_needs_auth" value="0" <?= $no_checked ?> <?=$bgcolor?> <?=$disabled?>/> No
                    <br/><br/>
                    
                    <div id="hmo_needs_auth_yes" class="sub-question">
                      Date Requested <input id="hmo_auth_date_requested" type="text" name="hmo_auth_date_requested" value="<?=$preauth['hmo_auth_date_requested']?>" onclick="cal7.popup();" onchange="validateDate('hmo_auth_date_requested');" class="tbox" <?=$bgcolor?> <?=$disabled?>/><br/>
                      Date Received <input id="hmo_auth_date_received" type="text" name="hmo_auth_date_received" value="<?=$preauth['hmo_auth_date_received']?>" onclick="cal8.popup();" onchange="validateDate('hmo_auth_date_received');" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                    </div>
                    <br/>
                    
                    Notes:<br/>
                    <textarea name="hmo_auth_notes" class="tbox" <?=$bgcolor?> <?=$disabled?>><?=$preauth['hmo_auth_notes']?></textarea>
                  </div>

                  <div id="is_hmo_no" class="sub-question">
                    What percent do they pay an "in-network" provider?
                    <input type="text" id="in_network_percentage" name="in_network_percentage" value="<?=$preauth['in_network_percentage']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/>% (enter 0-100)
                    <br/><br/>
                    Appeal for in network benefits needed.
                    <br/><br/>
                    Date Requested <input id="in_network_appeal_date_sent" type="text" name="in_network_appeal_date_sent" value="<?=$preauth['in_network_appeal_date_sent']?>" onclick="cal9.popup();" onchange="validateDate('in_network_appeal_date_sent');" class="tbox" <?=$bgcolor?> <?=$disabled?>/><br/>
                    Date Received <input id="in_network_appeal_date_received" type="text" name="in_network_appeal_date_received" value="<?=$preauth['in_network_appeal_date_received']?>" onclick="cal10.popup();" onchange="validateDate('in_network_appeal_date_received');" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
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
                <input type="radio" name="is_pre_auth_required" value="1" <?= $yes_checked ?> <?=$bgcolor?> <?=$disabled?>/> Yes
                <input type="radio" name="is_pre_auth_required" value="0" <?= $no_checked ?> <?=$bgcolor?> <?=$disabled?>/> No
                <br/><br/>

                <div id="is_pre_auth_required_yes" class="sub-question">
                  <h3>Verbal</h3>
                  Name <input type="text" name="verbal_pre_auth_name" value="<?=$preauth['verbal_pre_auth_name']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/><br/>
                  Ref Num <input type="text" name="verbal_pre_auth_ref_num" value="<?=$preauth['verbal_pre_auth_ref_num']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/><br/>
                  Notes<br/><textarea name="verbal_pre_auth_notes" class="tbox" <?=$bgcolor?> <?=$disabled?>><?=$preauth['verbal_pre_auth_notes']?></textarea><br/>
                  
                  <h3>Written</h3>
                  Date Received <input id="written_pre_auth_date_received" type="text" name="written_pre_auth_date_received" value="<?=$preauth['written_pre_auth_date_received']?>" onclick="cal11.popup();" onchange="validateDate('written_pre_auth_date_received');" class="tbox" <?=$bgcolor?> <?=$disabled?>/> <br/>
                  Notes<br/><textarea name="written_pre_auth_notes" class="tbox" <?=$bgcolor?> <?=$disabled?>><?=$preauth['written_pre_auth_notes']?></textarea><br/>
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
                <input type="radio" name="network_benefits" value="1" <?= $yes_checked ?> <?=$bgcolor?> <?=$disabled?>/> Out of network
                <input type="radio" name="network_benefits" value="0" <?= $no_checked ?> <?=$bgcolor?> <?=$disabled?>/> In Network
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient Deductible
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_deductible" name="patient_deductible" value="<?=$preauth['patient_deductible']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_amount_met" name="patient_amount_met" value="<?=$preauth['patient_amount_met']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient amount left to meet
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_amount_left_to_meet" name="patient_amount_left_to_meet" value="<?=$preauth['patient_amount_left_to_meet']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Family Deductible
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_deductible" name="family_deductible" value="<?=$preauth['family_deductible']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Family amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_amount_met" name="family_amount_met" value="<?=$preauth['family_amount_met']?>" class="tbox" <?=$bgcolor?> <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                When does the deductible reset?
            </td>
            <td valign="top" class="frmdata">
                <input type="text" id="deductible_reset_date" name="deductible_reset_date" value="<?=$preauth['deductible_reset_date']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" <?=$disabled?>/>
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
                <input type="radio" name="out_of_pocket_met" value="1" <?= $yes_checked ?> <?=$bgcolor?> <?=$disabled?>/> Yes
                <input type="radio" name="out_of_pocket_met" value="0" <?= $no_checked ?> <?=$bgcolor?> <?=$disabled?>/> No
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Device amount
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="trxn_code_amount" name="trxn_code_amount" value="<?=$preauth['trxn_code_amount']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Expected insurance payment
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="expected_insurance_payment" name="expected_insurance_payment" value="<?=$preauth['expected_insurance_payment']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Expected patient payment
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="expected_patient_payment" name="expected_patient_payment" value="<?=$preauth['expected_patient_payment']?>" class="tbox" style="background-color:#cccccc;color:#3c3c3c;" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="preauth_id" value="<?= $_REQUEST['ed'] ?>"/>
                Mark Complete <input type="checkbox" name="complete" value="1" <?php if ($is_complete) { print 'CHECKED'; } ?> <?=$bgcolor?> <?=$disabled?>/>
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
