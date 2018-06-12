<?php
namespace Ds3\Libraries\Legacy;

include_once('../includes/constants.inc');
include_once('includes/main_include.php');
include_once('includes/access.php');
include("includes/sescheck.php");
include_once('../includes/dental_patient_summary.php');
include_once('../includes/general_functions.php');
include_once('includes/invoice_functions.php');

/**
 * @see DSS-568
 */
$isSuperAdmin = is_super($_SESSION['admin_access']);
$adminCompanyId = (int)$_SESSION['admincompanyid'];
$preAuthId = (int)$_GET['ed'];

if (!empty($_POST['save_vob'])) {
    $preAuthId = (int)$_POST['preauth_id'];
}

$escapedPendingStatus = $db->escape(DSS_PREAUTH_PENDING);
$joinByUserCompany = '';
$conditionals = ["preauth.id = '$preAuthId'"];

if ($isSuperAdmin) {
} elseif (is_billing($_SESSION['admin_access'])) {
    /**
     * @see DSS-568
     *
     * Doctor billing company can see all VOBs. Former billing companies can see all owned by them, except if they
     * are DSS_PREAUTH_PENDING.
     */
    $conditionals[] = "doctor_billing_company.id = '$adminCompanyId'
        OR (
            preauth.status NOT IN ($escapedPendingStatus)
            AND vob_billing_company.id = '$adminCompanyId'
        )";
} else {
    /**
     * Restrict by HST company
     */
    $joinByUserCompany = "JOIN dental_user_company uc ON uc.userid = p.docid
        AND uc.companyid = '$adminCompanyId'";
}

$sql = "SELECT
        preauth.*,
        id.ins_diagnosis,
        pcp.salutation AS 'pcp_salutation',
        pcp.firstname AS 'pcp_firstname',
        pcp.lastname AS 'pcp_lastname',
        pcp.phone1 AS 'pcp_phone1',
        p.patientid as 'patientid',
        doctor_billing_company.id AS current_billing_company_id,
        vob_billing_company.id AS stored_billing_company_id
    FROM dental_insurance_preauth preauth
        JOIN dental_patients p ON preauth.patient_id = p.patientid
        JOIN dental_users doctor ON preauth.doc_id = doctor.userid
        LEFT OUTER JOIN dental_contact pcp ON pcp.contactid = p.docpcp
        LEFT OUTER JOIN dental_ins_diagnosis id ON id.ins_diagnosisid = preauth.diagnosis_code
        LEFT JOIN companies doctor_billing_company ON doctor_billing_company.id = doctor.billing_company_id
        LEFT JOIN admin owner ON owner.adminid = preauth.updated_by
        LEFT JOIN admin_company ac ON ac.adminid = owner.adminid
        LEFT JOIN companies vob_billing_company ON vob_billing_company.id = ac.companyid
        $joinByUserCompany
    ";

$whereConditionals = '';

if (count($conditionals)) {
    $conditionals = '(' . join(') AND (', $conditionals) . ')';
    $whereConditionals = "WHERE $conditionals";
}

$sql = "$sql $whereConditionals";
$preauth = $db->getRow($sql);

$pid = $preauth['patient_id'];

/**
 * @see DSS-568
 */
$canEdit = preAuthEditPermission($preauth, $adminCompanyId, $isSuperAdmin);

if (!$preauth) {
    $message = 'You are not authorized to view this page';
    ?>
    <script>
        window.location = 'manage_vobs.php?msg=<?= urlencode($message) ?>';
    </script>
    <?php
    
    trigger_error('Die called', E_USER_ERROR);
}

// load dynamic preauth info
$sql = "SELECT
        i.company AS 'ins_co',
        'primary' AS 'ins_rank',
        i.phone1 AS 'ins_phone',
        p.p_m_ins_grp AS 'patient_ins_group_id',
        p.p_m_ins_id AS 'patient_ins_id',
        p.firstname AS 'patient_firstname',
        p.lastname AS 'patient_lastname',
        p.add1 AS 'patient_add1',
        p.add2 AS 'patient_add2',
        p.city AS 'patient_city',
        p.state AS 'patient_state',
        p.zip AS 'patient_zip',
        p.dob AS 'patient_dob',
        p.p_m_partyfname AS 'insured_first_name',
        p.p_m_partylname AS 'insured_last_name',
        p.ins_dob AS 'insured_dob',
        d.npi AS 'doc_npi',
        r.national_provider_id AS 'referring_doc_npi',
        d.medicare_npi AS 'doc_medicare_npi',
        d.tax_id_or_ssn AS 'doc_tax_id_or_ssn',
        tc.amount AS 'trxn_code_amount',
        q2.confirmed_diagnosis AS 'diagnosis_code',
        CONCAT(d.first_name,' ',d.last_name) AS doc_name,
        d.practice AS doc_practice,
        d.address AS doc_address,
        d.phone AS doc_phone,
        p.home_phone AS 'patient_phone',
        p.work_phone AS patient_work_phone,
        p.cell_phone AS patient_cell_phone,
        p.email AS patient_email
    FROM dental_patients p
        LEFT JOIN dental_contact r ON p.referred_by = r.contactid
        JOIN dental_contact i ON p.p_m_ins_co = i.contactid
        JOIN dental_users d ON p.docid = d.userid
        JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486'
        LEFT JOIN dental_q_page2_pivot q2 ON p.patientid = q2.patientid
    WHERE p.patientid = '$pid'";
$my_array = $db->getRow($sql);

$preauth = array_merge($preauth, $my_array);

if (!empty($_POST['save_vob']) && $canEdit) {
    $vobData = processVobInput($_POST, $_SESSION['adminuserid']);
    
    if (isset($_POST['complete']) && ($_POST['complete'] == '1')) {
	    //IF USER TYPE = SOFTWARE BILL FOR VOB
	    $sql = "SELECT u.userid
            FROM dental_users u
		        JOIN dental_insurance_preauth p ON p.doc_id = u.userid
		    WHERE p.id = '$preAuthId'";
        $userId = $db->getColumn($sql, 'userid', 0);

	    invoice_add_vob('1', $userId, $preAuthId);
    }
    
    if (!isset($_POST['reject_but'])) {
        update_patient_summary($pid, 'vob', $vobData['status']);
    }

    $vobStatus = $vobData['status'];
    $vobData = $db->escapeAssignmentList($vobData);
    
    if ($vobStatus === DSS_PREAUTH_COMPLETE) {
        $vobData .= ', date_completed = NOW()';
    }
    
    $sql = "UPDATE dental_insurance_preauth
        SET $vobData, updated_at = NOW()
        WHERE id = '$preAuthId'";
    $db->query($sql);
    
    //echo $ed_sql.mysqli_error($con);
    $task_label = (!empty($_POST['completed'])) ? 'Completed' : 'Updated';
    $msg = "Verification of Benefits $task_label Successfully";
    
    ?>
    <script type="text/javascript">
        parent.window.location = 'manage_vobs.php?msg=<?= urlencode($msg) ?>';
    </script>
    <?php
    
    trigger_error('Die called', E_USER_ERROR);
}

$is_complete = ($preauth['status'] == DSS_PREAUTH_COMPLETE) ? true : false;
$is_rejected = ($preauth['status'] == DSS_PREAUTH_REJECTED) ? true : false;
$disabled = $canEdit ? '' : 'disabled';

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<?php

require_once dirname(__FILE__) . '/includes/top.htm';

if ($disabled) { ?>
    <script type="text/javascript">
        var disableAutomaticCalculations = true;
    </script>
<?php } ?>
<script language="javascript" type="text/javascript" src="script/preauth_form_logic.js?v=<?= time() ?>"></script>
<script src="popup/popup.js" type="text/javascript"></script>
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
<script language="javascript" type="text/javascript" src="script/preauth_form_logic.js?v=<?= time() ?>"></script>
	<br /><br />
	
	<? if(!empty($msg)) {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
<form name="preauth_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return validatePreAuthForm(this)">
    <input type="hidden" name="save_vob" value="1" />
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
                Patient's Contact Phone #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_phone" value="<?= e($preauth['patient_phone']) ?>" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Work Phone #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_work_phone" value="<?= e($preauth['patient_work_phone']) ?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Celll Phone #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_cell_phone" value="<?= e($preauth['patient_cell_phone']) ?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Email
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_email" value="<?= e($preauth['patient_email']) ?>" class="tbox readonly" readonly />
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
                <span><a href="#" id="ins_effective_year" onclick="$('#ins_effective_date').val('1/1/'+(new Date).getFullYear());return false;">Jan1</a></span>
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
        <tr bgcolor="#FFFFFF" class="header-row">
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
            <td valign="top" class="frmdata">
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
                $<input type="text" id="patient_deductible" name="patient_deductible" value="<?=$preauth['patient_deductible']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="in_patient_deductible" name="in_patient_deductible" value="<?=$preauth['in_patient_deductible']?>" class="tbox" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Patient amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="patient_amount_met" name="patient_amount_met" value="<?=$preauth['patient_amount_met']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="in_patient_amount_met" name="in_patient_amount_met" value="<?=$preauth['in_patient_amount_met']?>" class="tbox" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Patient amount left to meet
            </td>
            <td valign="top" class="frmdata">
                $<input tabindex="-1" type="text" id="patient_amount_left_to_meet" name="patient_amount_left_to_meet" value="<?=$preauth['patient_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                $<input tabindex="-1" type="text" id="in_patient_amount_left_to_meet" name="in_patient_amount_left_to_meet" value="<?=$preauth['in_patient_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Family Deductible
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_deductible" name="family_deductible" value="<?=$preauth['family_deductible']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="in_family_deductible" name="in_family_deductible" value="<?=$preauth['in_family_deductible']?>" class="tbox" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Family amount met
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="family_amount_met" name="family_amount_met" value="<?=$preauth['family_amount_met']?>" class="tbox" <?=$disabled?>/> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="in_family_amount_met" name="in_family_amount_met" value="<?=$preauth['in_family_amount_met']?>" class="tbox" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF" class="">
            <td valign="top" class="frmhead" width="30%">
                Family amount left to meet
            </td>
            <td valign="top" class="frmdata">
                $<input tabindex="-1" type="text" id="family_amount_left_to_meet" name="family_amount_left_to_meet" value="<?=$preauth['family_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/>
                <span class="red">*</span>
            </td>
            <td valign="top" class="frmdata">
                $<input tabindex="-1" type="text" id="in_family_amount_left_to_meet" name="in_family_amount_left_to_meet" value="<?=$preauth['in_family_amount_left_to_meet']?>" class="tbox covered readonly" <?=$disabled?>/>
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
            <td valign="top" class="frmdata">
                <input type="text" id="in_deductible_reset_date" name="in_deductible_reset_date" value="<?=$preauth['in_deductible_reset_date']?>" placeholder="Auto-calculated field" class="tbox covered" style="color:grey" <?=$disabled?>/>
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
            <td valign="top" class="frmdata">
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
            <td valign="top" class="frmdata">
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
            <td valign="top" class="frmdata">
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
            <td valign="top" class="frmdata">
                $<input type="text" id="in_trxn_code_amount2" name="in_trxn_code_amount2" value="<?=$preauth['trxn_code_amount']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Expected insurance payment
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" id="expected_insurance_payment" name="expected_insurance_payment" value="<?=$preauth['expected_insurance_payment']?>" class="tbox readonly" <?=$disabled?>/>
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
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
            <td valign="top" class="frmdata">
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
                </span>
                <br />
                <a <?= $disabled ?> href="#" onclick="$('#reject_reason_div').show(); return false;"
                   class="editdel btn btn-warning pull-right" title="REJECT">
                    Reject
                </a>

                <div id="reject_reason_div" <?= ($preauth['status']==DSS_PREAUTH_REJECTED)?'':'style="display:none;"'; ?> >
                    <label>
                        VOB will be REJECTED and the dental office will be notified.
                        Please list the reasons for rejection.
                    </label>
                    <br />
                    <textarea id="reject_reason" name="reject_reason"><?= e($preauth['reject_reason']) ?></textarea>

                    <input <?= $disabled ?> type="submit" name="reject_but" onclick="return ($('#reject_reason').val()!='');"
                           value="Submit rejection" class="btn btn-primary">
                    <input <?= $disabled ?> type="button" onclick="$('#reject_reason').val(''); $('#reject_reason_div').hide(); return false;"
                               value="Cancel"  class="btn btn-primary">
                </div>
                <br />
                    
                <input type="hidden" name="preauth_id" value="<?= $_GET['ed'] ?>"/>
                Mark Complete
                <input type="checkbox" name="complete" value="1" <?= $is_complete ? 'checked' : '' ?> <?=$disabled?>/>

                <input <?= $disabled ?> type="submit" value="Save Verification of Benefits" class="btn btn-primary">

                <?php if ($isSuperAdmin) { ?>
                    <a target="_parent" href="manage_vobs.php?delid=<?=$preauth["id"];?>"
                       onclick="javascript: return confirm('Do Your Really want to Delete?.');"
                       class="editdel btn btn-danger pull-right" title="DELETE">
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
require 'eligible_check/eligible_check.php';

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
<?php

require_once __DIR__ . '/includes/bottom.htm';

/**
 * Determine edit permissions. Only Pending statuses can be edited.
 *
 * @param array $preAuthData
 * @param int   $adminCompanyId
 * @param bool  $isSuperAdmin
 * @return bool
 */
function preAuthEditPermission (array $preAuthData, $adminCompanyId, $isSuperAdmin) {
    $status = (int)$preAuthData['status'];
    $isStatusPending = $status === DSS_PREAUTH_PENDING;
    $isStatusPreAuth = $status === DSS_PREAUTH_PREAUTH_PENDING;
    $isAnyPendingStatus = $isStatusPending || $isStatusPreAuth;

    if (!$isAnyPendingStatus) {
        return false;
    }

    if ($isSuperAdmin) {
        return true;
    }

    $currentBillingCompanyId = (int)$preAuthData['current_billing_company_id'];
    $storedBillingCompanyId = (int)$preAuthData['stored_billing_company_id'];

    if (!$currentBillingCompanyId && !$storedBillingCompanyId) {
        return false;
    }

    if ($currentBillingCompanyId === $storedBillingCompanyId) {
        return true;
    }

    $isCurrentBillingCompany = $currentBillingCompanyId === $adminCompanyId;
    $isStoredBillingCompany = $storedBillingCompanyId === $adminCompanyId;

    if ($isStoredBillingCompany && $isStatusPreAuth) {
        return true;
    }

    if ($isCurrentBillingCompany && $isStatusPending) {
        return true;
    }

    return false;
}

/**
 * @param array $input
 * @param int   $adminId
 * @return mixed
 */
function processVobInput (Array $input, $adminId) {
    $vobData = array_only($input, [
        'ins_co',
        'ins_rank',
        'ins_phone',
        'patient_ins_group_id',
        'patient_ins_id',
        'patient_firstname',
        'patient_lastname',
        'patient_add1',
        'patient_add2',
        'patient_city',
        'patient_state',
        'patient_zip',
        'patient_dob',
        'insured_first_name',
        'insured_last_name',
        'insured_dob',
        'doc_name',
        'doc_practice',
        'doc_address',
        'doc_phone',
        'doc_npi',
        'referring_doc_npi',
        'doc_medicare_npi',
        'doc_tax_id_or_ssn',
        'trxn_code_amount',
        'patient_phone',
        'patient_work_phone',
        'patient_cell_phone',
        'patient_email',
        'date_of_call',
        'insurance_rep',
        'call_reference_num',
        'ins_effective_date',
        'ins_cal_year_start',
        'ins_cal_year_end',
        'trxn_code_covered',
        'code_covered_notes',
        'how_often',
        'has_out_of_network_benefits',
        'out_of_network_percentage',
        'is_hmo',
        'hmo_date_called',
        'hmo_date_received',
        'hmo_needs_auth',
        'hmo_auth_date_requested',
        'hmo_auth_notes',
        'in_network_percentage',
        'in_network_appeal_date_sent',
        'in_network_appeal_date_received',
        'is_pre_auth_required',
        'verbal_pre_auth_name',
        'verbal_pre_auth_ref_num',
        'verbal_pre_auth_notes',
        'written_pre_auth_notes',
        'written_pre_auth_date_received',
        'pre_auth_num',
        'network_benefits',
        'deductible_from',
        'patient_deductible',
        'patient_amount_met',
        'family_deductible',
        'family_amount_met',
        'deductible_reset_date',
        'out_of_pocket_met',
        'patient_amount_left_to_meet',
        'family_amount_left_to_meet',
        'expected_insurance_payment',
        'expected_patient_payment',
        'in_deductible_from',
        'in_patient_deductible',
        'in_patient_amount_met',
        'in_family_deductible',
        'in_family_amount_met',
        'in_deductible_reset_date',
        'in_out_of_pocket_met',
        'in_patient_amount_left_to_meet',
        'in_family_amount_left_to_meet',
        'in_expected_insurance_payment',
        'in_expected_patient_payment',
        'has_in_network_benefits',
        'in_is_pre_auth_required',
        'in_call_reference_num',
        'in_verbal_pre_auth_name',
        'in_verbal_pre_auth_ref_num',
        'in_verbal_pre_auth_notes',
        'in_written_pre_auth_date_received',
        'in_pre_auth_num',
        'in_written_pre_auth_notes',
    ]);
    
    $vobData['hmo_auth_date_received'] = $input['hmo_audoc_tax_id_or_ssnth_date_received'];
    $vobData['updated_by'] = $adminId;
    
    $vobData['ins_phone'] = num($vobData['ins_phone']);
    $vobData['doc_tax_id_or_ssn'] = num($vobData['doc_tax_id_or_ssn']);
    $vobData['patient_phone'] = num($vobData['patient_phone']);
    
    if (isset($input['reject_but'])) {
        $vobData['status'] = DSS_PREAUTH_REJECTED;
        $vobData['viewed'] = 0;
        $vobData['reject_reason'] = $input['reject_reason'];
        
        return $vobData;
    }
    
    if (isset($input['complete']) && ($input['complete'] == '1')) {
        $vobData['status'] = DSS_PREAUTH_COMPLETE;
        $vobData['viewed'] = 0;
        
        return $vobData;
    }
    
    if ($input['is_pre_auth_required'] == 1) {
        $vobData['status'] = DSS_PREAUTH_PREAUTH_PENDING;
        return $vobData;
    }
    
    $vobData['status'] = DSS_PREAUTH_PENDING;
    return $vobData;
}
