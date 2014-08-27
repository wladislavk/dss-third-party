<?php 
session_start();
require_once('../includes/constants.inc');
require_once('includes/main_include.php');
include("includes/sescheck.php");
require_once('../includes/dental_patient_summary.php');
require_once('../includes/general_functions.php');
require_once('includes/invoice_functions.php');
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<script language="javascript" type="text/javascript" src="script/preauth_form_logic.js"></script>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<?php
// Get patient id for updating patient summary table
$sql = "SELECT "
		 . "  preauth.patient_id "
		 . "FROM "
		 . "  dental_insurance_preauth preauth "
		 . "WHERE "
		 . "  preauth.id = " . $_GET['ed'];
$result = mysql_query($sql);
$pid = mysql_result($result, 0);

if (isset($_GET['ed'])) {
    // load preauth
    $sql = "SELECT "
         . "  preauth.*, id.ins_diagnosis, pcp.salutation as 'pcp_salutation', pcp.firstname as 'pcp_firstname', "
         . "  pcp.lastname as 'pcp_lastname', pcp.phone1 as 'pcp_phone1', p.patientid as 'patientid' "
         . "FROM "
         . "  dental_insurance_preauth preauth "
         . "  JOIN dental_patients p ON p.patientid = preauth.patient_id "
         . "  LEFT OUTER JOIN dental_contact pcp ON pcp.contactid = p.docpcp "
	 . "  LEFT OUTER JOIN dental_ins_diagnosis id ON id.ins_diagnosisid = preauth.diagnosis_code "
         . "WHERE "
         . "  preauth.id = " . $_GET['ed'];
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
		 . "  p.home_phone as 'patient_phone', p.work_phone, p.cell_phone  "
		 . "FROM "
		 . "  dental_patients p  "
		 . "  LEFT JOIN dental_contact r ON p.referred_by = r.contactid  "
		 . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
		 . "  JOIN dental_users d ON p.docid = d.userid "
		 . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
		 . "  LEFT JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
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
				 . "ins_phone = '" . s_for(num($_POST["ins_phone"])) . "', "
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
				 . "doc_name = '". s_for($_POST["doc_name"]). "', "
				 . "doc_practice = '". s_for($_POST["doc_practice"]). "', "
				 . "doc_address = '". s_for($_POST["doc_address"]). "', "
				 . "doc_phone = '". s_for($_POST["doc_phone"]). "', "
				 . "doc_npi = '" . s_for($_POST["doc_npi"]) . "', "
				 . "referring_doc_npi = '" . s_for($_POST["referring_doc_npi"]) . "', "
				 . "doc_medicare_npi = '" . s_for($_POST["doc_medicare_npi"]) . "', "
				 . "doc_tax_id_or_ssn = '" . s_for(num($_POST["doc_tax_id_or_ssn"], false)) . "', "
				 . "trxn_code_amount = '" . s_for($_POST["trxn_code_amount"]) . "', "
				 . "diagnosis_code = '" . s_for($_POST["diagnosis_code"]) . "', "
				 . "patient_phone = '" . s_for(num($_POST["patient_phone"])) . "', "
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
         . "pre_auth_num = '".s_for($_POST["pre_auth_num"])."', "
         . "network_benefits = '" . $_POST["network_benefits"] . "', "
         . "deductible_from = '" . $_POST["deductible_from"] . "', "
         . "patient_deductible = '" . $_POST["patient_deductible"] . "', "
         . "patient_amount_met = '" . $_POST["patient_amount_met"] . "', "
         . "family_deductible = '" . $_POST["family_deductible"] . "', "
         . "family_amount_met = '" . $_POST["family_amount_met"] . "', "
         . "deductible_reset_date = '".s_for($_POST["deductible_reset_date"])."', "
         . "out_of_pocket_met = '" . $_POST["out_of_pocket_met"] . "', "
         . "patient_amount_left_to_meet = '" . $_POST["patient_amount_left_to_meet"] . "', "
         . "family_amount_left_to_meet = '" . $_POST["family_amount_left_to_meet"] . "', "
         . "expected_insurance_payment = '" . $_POST["expected_insurance_payment"] . "', "
         . "expected_patient_payment = '" . $_POST["expected_patient_payment"] . "', "
	 . "updated_at = now(), "
	 . "updated_by = '".mysql_real_escape_string($_SESSION['adminuserid'])."' ";
    
    if(isset($_POST['reject_but'])){
        $sql .= ", status = " . DSS_PREAUTH_REJECTED . " ";
	$sql .= ", reject_reason = '" . mysql_real_escape_string($_POST['reject_reason']) ."' ";
        $sql .= ", viewed = 0 ";
    }elseif (isset($_POST['complete']) && ($_POST['complete'] == '1')) {
        $sql .= ", status = " . DSS_PREAUTH_COMPLETE . " ";
        $sql .= ", date_completed = NOW() ";
	$sql .= ", viewed = 0 ";


	//IF USER TYPE = SOFTWARE BILL FOR VOB
	$ut_sql = "SELECT u.userid, u.user_type FROM dental_users u 
		JOIN dental_insurance_preauth p
			ON p.doc_id=u.userid
		WHERE p.id='".mysql_real_escape_string($_POST['preauth_id'])."'";
        $ut_q = mysql_query($ut_sql);
        $ut_r = mysql_fetch_assoc($ut_q);

	invoice_add_vob('1', $ut_r['userid'], $_POST['preauth_id']);

	if($ut_r['user_type'] == DSS_USER_TYPE_SOFTWARE){
	  //$sql .= ", invoice_amount = '45.00' ";
	}
				update_patient_summary($pid, 'vob', DSS_PREAUTH_COMPLETE);
    } elseif($_POST['is_pre_auth_required']==1){ 
        $sql .= ", status = " . DSS_PREAUTH_PREAUTH_PENDING . " ";
				update_patient_summary($pid, 'vob', DSS_PREAUTH_PREAUTH_PENDING);
    } else {
        $sql .= ", status = " . DSS_PREAUTH_PENDING . " ";
                                update_patient_summary($pid, 'vob', DSS_PREAUTH_PENDING);
    }
    $sql .= "WHERE id = '" . $_POST["preauth_id"] . "'";
    mysql_query($sql) or die($sql." | ".mysql_error());
    
    //echo $ed_sql.mysql_error();
    $task_label = (!empty($_POST['completed'])) ? 'Completed' : 'Updated';
    $msg = "Verification of Benefits $task_label Successfully";
    print "<script type='text/javascript'>";
    print "parent.window.location='manage_vobs.php?msg=$msg'";
    print "</script>";
}

$is_complete = ($preauth['status'] == DSS_PREAUTH_COMPLETE) ? true : false;
$is_rejected = ($preauth['status'] == DSS_PREAUTH_REJECTED) ? true : false;
$disabled = ($is_complete || $is_rejected) ? 'DISABLED' : '';

?>

<?php require_once dirname(__FILE__) . '/includes/top.htm'; ?>

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
<script language="javascript" type="text/javascript" src="script/preauth_validation.js"></script>
<script language="javascript" type="text/javascript" src="script/preauth_form_logic.js"></script>
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="preauth_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return validatePreAuthForm(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               Verification of benefits for <?= $preauth['patient_firstname']; ?> <?= $preauth['patient_lastname']; ?> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance Company
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="ins_co" value="<?=$preauth['ins_co']?>" class="tbox readonly" readonly />
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
                <input type="text" name="ins_phone" value="<?=$preauth['ins_phone']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_firstname" value="<?=$preauth['patient_firstname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_lastname" value="<?=$preauth['patient_lastname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Phone #
            </td>
            <td valign="top" class="frmdata">
		<?php
		   if($preauth['patient_phone']!=''){
			$patient_phone = $preauth['patient_phone'];
		   }elseif($preauth['cell_phone']!=''){
                        $patient_phone = $preauth['cell_phone'];
                   }else{
                        $patient_phone = $preauth['work_phone'];
                   }
		?>
                <input type="text" name="patient_phone" value="<?=$patient_phone?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add1" class="tbox readonly" value="<?=$preauth['patient_add1'];?>" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address 2
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add2" class="tbox readonly" value="<?=$preauth['patient_add2'];?>" readonly />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$preauth['patient_city']?>" name="patient_city" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$preauth['patient_state']?>" name="patient_state" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_zip" value="<?= $preauth['patient_zip']?>" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_first_name" value="<?=$preauth['insured_first_name']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_last_name" value="<?=$preauth['insured_last_name']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insured DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="insured_dob" value="<?=$preauth['insured_dob']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Group Insurance #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_group_id" value="<?=$preauth['patient_ins_group_id']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance ID #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_id" value="<?=$preauth['patient_ins_id']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_dob" value="<?=$preauth['patient_dob']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Client Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_name" value="<?=$preauth['doc_name']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Client Practice
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_practice" value="<?=$preauth['doc_practice']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Client Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_address" value="<?=$preauth['doc_address']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Client Phone
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_phone" value="<?=$preauth['doc_phone']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Client's NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_npi" value="<?=$preauth['doc_npi']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Client's Medicare NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_medicare_npi" value="<?=$preauth['doc_medicare_npi']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Client's Tax ID or SSN
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="doc_tax_id_or_ssn" value="<?=$preauth['doc_tax_id_or_ssn']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Referring Doctor's NPI Number
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="referring_doc_npi" value="<?=$preauth['referring_doc_npi']?>" class="tbox readonly" readonly /> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Code E0486 - Durable Medical Equipment Amount
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" name="trxn_code_amount" value="<?=$preauth['trxn_code_amount']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Diagnosis Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="diagnosis_code" value="<?=$preauth['ins_diagnosis']?>" class="tbox readonly" readonly /> 
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Date of Call
            </td>
            <td valign="top" class="frmdata">
                <?php if (empty($preauth['date_of_call'])) { $preauth['date_of_call'] = date('m/d/Y'); } ?>
                <input id="date_of_call" type="text" name="date_of_call" value="<?=$preauth['date_of_call']?>" onchange="validateDate('date_of_call');" class="tbox calendar" <?=$disabled?>/> 
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
                Insurance Effective Date
            </td>
            <td valign="top" class="frmdata">
                <input id="ins_effective_date" type="text" name="ins_effective_date" value="<?=$preauth['ins_effective_date']?>" onchange="validateDate('ins_effective_date');" class="tbox calendar" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Insurance Calendar Year
            </td>
            <td valign="top" class="frmdata">
                from <input id="ins_cal_year_start" type="text" name="ins_cal_year_start" value="<?=$preauth['ins_cal_year_start']?>" onchange="validateDate('ins_cal_year_start');"class="tbox calendar" style="width:125px" <?=$disabled?>/>
                to <input id="ins_cal_year_end" type="text" name="ins_cal_year_end" value="<?=$preauth['ins_cal_year_end']?>" onchange="validateDate('ins_cal_year_end');" class="tbox calendar" style="width:125px" <?=$disabled?>/>
                <span class="red">*</span>				
		<span><a href="#" id="ins_cal_year" onclick="$('#ins_cal_year_start').val('1/1/'+(new Date).getFullYear());$('#ins_cal_year_end').val('12/31/'+(new Date).getFullYear());return false;">Jan1-Dec31</a></span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Is the CPT code E0486 covered under the patient's plan?
            </td>
            <td valign="top" class="frmdata">
		<div class="form-group">
		<div class="radio-list">
                <?php $yes_checked = ($preauth['trxn_code_covered'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['trxn_code_covered'] != '1') ? 'CHECKED' : ''; ?>
                <input type="radio" id="trxn_code_covered_yes" name="trxn_code_covered" value="1" <?= $yes_checked ?> <?=$disabled?>/> Yes
                <input type="radio" name="trxn_code_covered" value="0" <?= $no_checked ?> <?=$disabled?>/> No
		</div>
		</div>

                <br/><br/>
                Notes:<br/>
                <textarea name="code_covered_notes" class="tbox" <?=$disabled?>><?=$preauth['code_covered_notes']?></textarea>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="covered-row">
            <td valign="top" class="frmhead" width="30%">
                How often will you pay for another device?
            </td>
            <td class="frmdata" colspan="2">
                <input id="how_often" type="text" name="how_often" value="<?=$preauth['how_often']?>" class="tbox covered"/> years
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="covered-row">
		<td valign="top" class="frmhead">
		</td>
		<td valign="top" class="frmhead">
		  Out-of-network benefits?
		</td>
		<td valign="top" class="frmhead">
		  In-network benefits?
		</td>
	</tr>
        <tr bgcolor="#FFFFFF" class="covered-row">
            <td valign="top" class="frmhead" width="30%">
                Does the patient have benefits?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['has_out_of_network_benefits'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $no_checked  = ($preauth['has_out_of_network_benefits'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="has_out_of_network_benefits" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Yes
                <input type="radio" name="has_out_of_network_benefits" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> No
                <br/><br/>

                <div id="has_out_of_network_benefits_yes" class="sub-question">
                  What percent do they pay an "out-of-network" provider?
                  <input type="text" id="out_of_network_percentage" name="out_of_network_percentage" value="<?=$preauth['out_of_network_percentage']?>" class="tbox covered" <?=$disabled?>/>% (enter 0-100)
                </div>
            </td> 
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['has_in_network_benefits'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $no_checked  = ($preauth['has_in_network_benefits'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="has_in_network_benefits" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Yes
                <input type="radio" name="has_in_network_benefits" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> No
                <br/><br/>

                <div id="has_in_network_benefits_yes" class="sub-question">
                  Is this an HMO?
                  <?php $yes_checked = ($preauth['is_hmo'] == '1') ? 'CHECKED' : ''; ?>
                  <?php $no_checked  = ($preauth['is_hmo'] != '1') ? 'CHECKED' : ''; ?>
                  <input type="radio" name="is_hmo" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Yes
                  <input type="radio" name="is_hmo" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> No
                  
                  <div class="question-indent">
                    What percent do they pay an "in-network" provider?<br/>
                    <input type="text" id="in_network_percentage" name="in_network_percentage" value="<?=$preauth['in_network_percentage']?>" class="tbox covered" <?=$disabled?>/>% (enter 0-100)
                  </div>
                  
                  <div id="is_hmo_yes" class="sub-question">
                    Call primary care physician to obtain referral:<br/>
                    <?= $preauth['pcp_salutation'] ?>
                    <?= $preauth['pcp_firstname'] ?>
                    <?= $preauth['pcp_lastname'] ?><br/>
                    <?= $preauth['pcp_phone1'] ?><br/>
                    <br/>
                    <?php if (empty($preauth['hmo_date_called'])) { $preauth['hmo_date_called'] = date('m/d/Y'); } ?>
                    Date Called <input id="hmo_date_called" type="text" name="hmo_date_called" value="<?=$preauth['hmo_date_called']?>" onchange="validateDate('hmo_date_called');" class="tbox covered calendar" <?=$disabled?>/><br/>
                    Date Received <input id="hmo_date_received" type="text" name="hmo_date_received" value="<?=$preauth['hmo_date_received']?>" onchange="validateDate('hmo_date_received');" class="tbox covered calendar" <?=$disabled?>/> <br/>
                    <br/>
                    
                  </div>

                  <div id="is_hmo_no" class="sub-question">
                    Appeal for in network benefits needed.
                    <br/><br/>
                    Date Requested <input id="in_network_appeal_date_sent" type="text" name="in_network_appeal_date_sent" value="<?=$preauth['in_network_appeal_date_sent']?>" onchange="validateDate('in_network_appeal_date_sent');" class="tbox covered calendar" <?=$disabled?>/><br/>
                    Date Received <input id="in_network_appeal_date_received" type="text" name="in_network_appeal_date_received" value="<?=$preauth['in_network_appeal_date_received']?>" onchange="validateDate('in_network_appeal_date_received');" class="tbox covered calendar" <?=$disabled?>/> 
                  </div>
                  
                  <div class="question-indent">
                    Notes:<br/>
                    <textarea name="hmo_auth_notes" class="tbox covered" <?=$disabled?>><?=$preauth['hmo_auth_notes']?></textarea>
                  </div>
                </div>
            </td>
        </tr>
        <tr><td  colspan="2" align="center">&nbsp;</td></tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Deductible Calculated From
            </td>
            <td valign="top" class="frmdata">
                <?php $patient_checked = ($preauth['deductible_from'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $family_checked  = ($preauth['deductible_from'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="deductible_from" value="1" <?= $patient_checked ?> <?=$disabled?> class="covered"/> Patient Deductible 
                <input type="radio" name="deductible_from" value="0" <?= $family_checked ?> <?=$disabled?> class="covered"/> Family Deductible
            </td>
            <td valign="top" class="frmdata covered-row">
                <?php $patient_checked = ($preauth['in_deductible_from'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $family_checked  = ($preauth['in_deductible_from'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="in_deductible_from" value="1" <?= $patient_checked ?> <?=$disabled?> class="covered"/> Patient Deductible
                <input type="radio" name="in_deductible_from" value="0" <?= $family_checked ?> <?=$disabled?> class="covered"/> Family Deductible
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Patient Deductible
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_deductible" name="patient_deductible" value="<?=$preauth['patient_deductible']?>" class="tbox covered" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_patient_deductible" name="in_patient_deductible" value="<?=$preauth['in_patient_deductible']?>" class="tbox covered" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Patient amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_amount_met" name="patient_amount_met" value="<?=$preauth['patient_amount_met']?>" class="tbox covered" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_patient_amount_met" name="in_patient_amount_met" value="<?=$preauth['in_patient_amount_met']?>" class="tbox covered" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Patient amount left to meet
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_amount_left_to_meet" name="patient_amount_left_to_meet" value="<?=$preauth['patient_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_patient_amount_left_to_meet" name="in_patient_amount_left_to_meet" value="<?=$preauth['in_patient_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Family Deductible
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_deductible" name="family_deductible" value="<?=$preauth['family_deductible']?>" class="tbox covered" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_family_deductible" name="in_family_deductible" value="<?=$preauth['in_family_deductible']?>" class="tbox covered" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Family amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_amount_met" name="family_amount_met" value="<?=$preauth['family_amount_met']?>" class="tbox covered" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_family_amount_met" name="in_family_amount_met" value="<?=$preauth['in_family_amount_met']?>" class="tbox covered" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Family amount left to meet
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_amount_left_to_meet" name="family_amount_left_to_meet" value="<?=$preauth['family_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_family_amount_left_to_meet" name="in_family_amount_left_to_meet" value="<?=$preauth['in_family_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                When does the deductible reset?
            </td>
            <td valign="top" class="frmdata">
                <input type="text" id="deductible_reset_date" name="deductible_reset_date" value="<?=$preauth['deductible_reset_date']?>" placeholder="Auto-calculated field" class="tbox covered" style="color:grey" <?=$disabled?>/>
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                <input type="text" id="deductible_reset_date" name="in_deductible_reset_date" value="<?=$preauth['in_deductible_reset_date']?>" placeholder="Auto-calculated field" class="tbox covered" style="color:grey" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Has patient's out-of-pocket expense been met?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['out_of_pocket_met'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['out_of_pocket_met'] != '1') ? 'CHECKED' : ''; ?>
                <input id="out_of_pocket_met_yes" type="radio" name="out_of_pocket_met" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Yes
                <input id="out_of_pocket_met_no" type="radio" name="out_of_pocket_met" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> No
            </td>
            <td valign="top" class="frmdata covered-row">
                <?php $yes_checked = ($preauth['in_out_of_pocket_met'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['in_out_of_pocket_met'] != '1') ? 'CHECKED' : ''; ?>
                <input id="in_out_of_pocket_met_yes" type="radio" name="in_out_of_pocket_met" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Yes
                <input id="in_out_of_pocket_met_no" type="radio" name="in_out_of_pocket_met" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> No
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Is Pre-Authorization required?
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['is_pre_auth_required'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['is_pre_auth_required'] != '1') ? 'CHECKED' : ''; ?>
                <input type="radio" name="is_pre_auth_required" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Yes
                <input type="radio" name="is_pre_auth_required" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> No
                <br/><br/>

                <div id="is_pre_auth_required_yes" class="sub-question">
                  <h3>Verbal</h3>
                  Name <input type="text" name="verbal_pre_auth_name" value="<?=$preauth['verbal_pre_auth_name']?>" class="tbox covered" <?=$disabled?>/><br/>
                  Ref Num <input type="text" name="verbal_pre_auth_ref_num" value="<?=$preauth['verbal_pre_auth_ref_num']?>" class="tbox covered" <?=$disabled?>/><br/>
                  Notes<br/><textarea name="verbal_pre_auth_notes" class="tbox covered" <?=$disabled?>><?=$preauth['verbal_pre_auth_notes']?></textarea><br/>

                  <h3>Pre-Auth Approval</h3>
                  Date Received <input id="written_pre_auth_date_received" type="text" name="written_pre_auth_date_received" value="<?=$preauth['written_pre_auth_date_received']?>" onchange="validateDate('written_pre_auth_date_received');" class="tbox covered calendar" <?=$disabled?>/> <br/>
                  Pre-Authorization Number <input id="pre_auth_num" type="text" name="pre_auth_num" value="<?=$preauth['pre_auth_num']?>" class="tbox covered" <?=$disabled?>/> <br/>
                  Notes<br/><textarea name="written_pre_auth_notes" class="tbox covered" <?=$disabled?>><?=$preauth['written_pre_auth_notes']?></textarea><br/>
                </div>
            </td>
            <td valign="top" class="frmdata covered-row">
                <?php $yes_checked = ($preauth['in_is_pre_auth_required'] == '1') ? 'CHECKED' : ''; ?>
                <?php $no_checked  = ($preauth['in_is_pre_auth_required'] != '1') ? 'CHECKED' : ''; ?>
                <input type="radio" name="in_is_pre_auth_required" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Yes
                <input type="radio" name="in_is_pre_auth_required" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> No
                <br/><br/>

                <div id="in_is_pre_auth_required_yes" class="sub-question">
                  <h3>Verbal</h3>
                  Name <input type="text" name="in_verbal_pre_auth_name" value="<?=$preauth['in_verbal_pre_auth_name']?>" class="tbox covered" <?=$disabled?>/><br/>
                  Ref Num <input type="text" name="in_verbal_pre_auth_ref_num" value="<?=$preauth['in_verbal_pre_auth_ref_num']?>" class="tbox covered" <?=$disabled?>/><br/>
                  Notes<br/><textarea name="in_verbal_pre_auth_notes" class="tbox covered" <?=$disabled?>><?=$preauth['in_verbal_pre_auth_notes']?></textarea><br/>

                  <h3>Pre-Auth Approval</h3>
                  Date Received <input id="in_written_pre_auth_date_received" type="text" name="in_written_pre_auth_date_received" value="<?=$preauth['in_written_pre_auth_date_received']?>" onchange="validateDate('in_written_pre_auth_date_received');" class="tbox covered calendar" <?=$disabled?>/> <br/>
                  Pre-Authorization Number <input id="in_pre_auth_num" type="text" name="in_pre_auth_num" value="<?=$preauth['in_pre_auth_num']?>" class="tbox covered" <?=$disabled?>/> <br/>
                  Notes<br/><textarea name="in_written_pre_auth_notes" class="tbox covered" <?=$disabled?>><?=$preauth['in_written_pre_auth_notes']?></textarea><br/>
                </div>
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
            <td valign="top" class="frmdata covered-row">
                <input type="text" name="in_call_reference_num" value="<?=$preauth['in_call_reference_num']?>" class="tbox" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Device amount
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="trxn_code_amount2" name="trxn_code_amount2" value="<?=$preauth['trxn_code_amount']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_trxn_code_amount2" name="in_trxn_code_amount2" value="<?=$preauth['trxn_code_amount']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Expected insurance payment
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="expected_insurance_payment" name="expected_insurance_payment" value="<?=$preauth['in_expected_insurance_payment']?>" class="tbox readonly" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_expected_insurance_payment" name="in_expected_insurance_payment" value="<?=$preauth['in_expected_insurance_payment']?>" class="tbox readonly" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Expected patient payment
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="expected_patient_payment" name="expected_patient_payment" value="<?=$preauth['expected_patient_payment']?>" class="tbox readonly" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata covered-row">
                $<input type="text" id="in_expected_patient_payment" name="in_expected_patient_payment" value="<?=$preauth['in_expected_patient_payment']?>" class="tbox readonly" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Benefits
            </td>
            <td valign="top" class="frmdata">
                <?php $yes_checked = ($preauth['network_benefits'] == '1') ? 'CHECKED="true"' : ''; ?>
                <?php $no_checked  = ($preauth['network_benefits'] != '1') ? 'CHECKED="true"' : ''; ?>
                <input type="radio" name="network_benefits" value="1" <?= $yes_checked ?> <?=$disabled?> class="covered"/> Out of network
                <input type="radio" name="network_benefits" value="0" <?= $no_checked ?> <?=$disabled?> class="covered"/> In Network
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
		<?php if(!$is_complete && !$is_rejected){ ?>
                        <a href="#" onclick="$('#reject_reason_div').show(); return false;" class="editdel btn btn-warning pull-right" title="REJECT">Reject</a>
                        <div id="reject_reason_div" <?= ($preauth['status']==DSS_PREAUTH_REJECTED)?'':'style="display:none;"'; ?> >
                                <label>VOB will be REJECTED and the dental office will be notified.  Please list the reasons for rejection.</label><br /><textarea id="reject_reason" name="reject_reason"><?= $preauth['reject_reason']; ?></textarea>
                                <input type="submit" name="reject_but" onclick="return ($('#reject_reason').val()!='');" value="Submit rejection" class="btn btn-primary">
				<input type="button" onclick="$('#reject_reason').val(''); $('#reject_reason_div').hide(); return false;" value="Cancel"  class="btn btn-primary">
                        </div>
<br />
		<?php } ?>
                <input type="hidden" name="preauth_id" value="<?= $_GET['ed'] ?>"/>
                Mark Complete <input type="checkbox" name="complete" value="1" <?php if ($is_complete) { print 'CHECKED'; } ?> <?=$disabled?>/>
                <?php if (!$is_complete && !$is_rejected ) { ?>
                  <input type="submit" value="Save Verfication of Benefits" class="btn btn-primary">
                <?php } ?>
		<?php if(($preauth["status"] == DSS_PREAUTH_PENDING || $preauth["status"] == DSS_PREAUTH_PREAUTH_PENDING) && $_SESSION['admin_access']==1){ ?>
                    <a target="_parent" href="manage_vobs.php?delid=<?=$preauth["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
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
  var cal9 = new calendar2(document.getElementById('in_network_appeal_date_sent'));
  var cal10 = new calendar2(document.getElementById('in_network_appeal_date_received'));
  var cal11 = new calendar2(document.getElementById('written_pre_auth_date_received'));
</script>
<?php 

  //setting pid to work with eligible check
  $_GET['pid'] = $pid;
  require 'eligible_check/eligible_check.php';//'eligible_check/eligible_check.php?docid='.$preauth['doc_id'].'&pid='.$preauth['patient_id'];
 ?>


<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
//-->
</script>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>



	<?php include 'includes/bottom.htm'; ?>
