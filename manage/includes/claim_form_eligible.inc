<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/claim_functions.php';

$claimId = intval($_GET['insid']);
$patientId = intval($_GET['pid']);

$status = $db->getRow("SELECT status FROM dental_insurance WHERE insuranceid = '$claimId' AND patientid = '$patientId'");
$status = $status ? $status['status'] : 0; // This means default status is zero

$isSecondary = ClaimFormData::isSecondary($status) || ($_GET['instype'] == 2);
$isPending = ClaimFormData::isStatus('pending', $status);
$isPrimaryPending = ClaimFormData::isPrimary($status) && $isPending;
$isSecondaryPending = ClaimFormData::isSecondary($status) && $isPending;
$isRejected = ClaimFormData::isStatus('rejected', $status);

$patientData = $db->getRow("SELECT * FROM dental_patients WHERE patientid = '$patientId'");
$docId = intval($patientData['docid']);

/**
 * If claim is pending, regenerate claim data.
 * Otherwise, allow to load already saved data.
 *
 * Only pending states are primary pending, and secondary pending
 */
if ($isPending) {
    $claimData = ClaimFormData::dynamicDataForClaim($claimId);
} else {
    $claimData = ClaimFormData::storedDataForClaim($claimId, $patientId);
}

$referencedClaimId = intval($claimData['primary_claim_id']);
$p_m_eligible_payer_id = (!empty($claimData['p_m_eligible_payer_id']) ? $claimData['p_m_eligible_payer_id'] : '');
$p_m_eligible_payer_name = (!empty($claimData['p_m_eligible_payer_name']) ? $claimData['p_m_eligible_payer_name'] : '');
$s_m_eligible_payer_id = (!empty($claimData['s_m_eligible_payer_id']) ? $claimData['s_m_eligible_payer_id'] : '');
$s_m_eligible_payer_name = (!empty($claimData['s_m_eligible_payer_name']) ? $claimData['s_m_eligible_payer_name'] : '');
$responsibility_sequence = st($claimData['responsibility_sequence']);
$other_insured_insurance_type = $claimData['other_insured_insurance_type'];
$icd_indicator = st($claimData['icd_ind']);

$payer = [
    'id' => $claimData['payer_id'],
    'name' => $claimData['payer_name'],
    'address' => [
        'street_line_1' => $claimData['payer_address'],
        'city' => $claimData['payer_city'],
        'state' => $claimData['payer_state'],
        'zip' => $claimData['payer_zip'],
    ]
];

$billing_provider_taxonomy_code = $claimData['billing_provider_taxonomy_code'];

$p_m_dss_file = $patientData['p_m_dss_file'];
$s_m_dss_file = $patientData['s_m_dss_file'];
$patient_lastname = st($claimData['patient_lastname']);
$patient_firstname = st($claimData['patient_firstname']);
$patient_middle = st($claimData['patient_middle']);
$patient_dob = st($claimData['patient_dob']);
$patient_sex = st($claimData['patient_sex']);

$insurancetype = st($claimData['insurance_type']);
$other_insurancetype = $claimData['other_insurance_type'];
$other_insured_firstname = st($claimData['other_insured_firstname']);
$other_insured_lastname = st($claimData['other_insured_lastname']);
$other_insured_middle = st($claimData['other_insured_middle']);
$other_insured_dob = st($claimData['other_insured_dob']);
$other_insured_sex = st($claimData['other_insured_sex']);

if (empty($other_insured_insurance_plan)) {
    $other_insured_insurance_plan = st($claimData['other_insured_insurance_plan']);
}

$other_insured_policy_group_feca = st($claimData['other_insured_policy_group_feca']);
$other_insured_address = st($claimData['other_insured_address']);
$other_insured_city = st($claimData['other_insured_city']);
$other_insured_state = st($claimData['other_insured_state']);
$other_insured_zip = st($claimData['other_insured_zip']);
$insured_id_number = st($claimData['insured_id_number']);
$insured_firstname = st($claimData['insured_firstname']);
$insured_middle = st($claimData['insured_middle']);
$insured_lastname = st($claimData['insured_lastname']);
$insured_dob = st($claimData['insured_dob']);
$insured_insurance_plan = st($claimData['insured_insurance_plan']);
$insured_policy_group_feca = st($claimData['insured_policy_group_feca']);
$other_insured_id_number = st($claimData['other_insured_id_number']);
$insured_address = st($claimData['insured_address']);
$insured_city = st($claimData['insured_city']);
$insured_state = st($claimData['insured_state']);
$insured_zip = st($claimData['insured_zip']);
$insured_phone_code = st($claimData['insured_phone_code']);
$insured_phone = st($claimData['insured_phone']);
$insured_sex = st($claimData['insured_sex']);
$patient_relation_insured = st($claimData['patient_relation_insured']);
$patient_relation_other_insured = st($claimData['patient_relation_other_insured']);

$patient_address = st($claimData['patient_address']);
$patient_city = st($claimData['patient_city']);
$patient_state = st($claimData['patient_state']);
$patient_status = st($claimData['patient_status']);
$patient_status_array = explode('~',$patient_status);
$patient_zip = st($claimData['patient_zip']);
$patient_phone_code = st($claimData['patient_phone_code']);
$patient_phone = st($claimData['patient_phone']);
$employment = st($claimData['employment']);
$auto_accident = st($claimData['auto_accident']);
$auto_accident_place = st($claimData['auto_accident_place']);
$other_accident = st($claimData['other_accident']);
$insured_employer_school_name = st($claimData['insured_employer_school_name']);
$other_insured_employer_school_name = st($claimData['other_insured_employer_school_name']);
$reserved_local_use = st($claimData['reserved_local_use']);
$another_plan = st($claimData['another_plan']);
$patient_signature = st($claimData['patient_signature']);
$patient_signed_date = st($claimData['patient_signed_date']);
$insured_signature = st($claimData['insured_signature']);
$date_current = st($claimData['date_current']);
$date_same_illness = st($claimData['date_same_illness']);
$unable_date_from = st($claimData['unable_date_from']);
$unable_date_to = st($claimData['unable_date_to']);
$name_referring_provider_qualifier = st($claimData['name_referring_provider_qualifier']);
$referring_provider = st($claimData['referring_provider']);
$field_17a_dd = st($claimData['field_17a_dd']);
$field_17a = st($claimData['field_17a']);
$field_17b = st($claimData['field_17b']);
$diagnosising_npi = st($claimData['field_17b']);
$hospitalization_date_from = st($claimData['hospitalization_date_from']);
$hospitalization_date_to = st($claimData['hospitalization_date_to']);
$reserved_local_use1 = st($claimData['reserved_local_use1']);
$claim_info_code = st($claimData['claim_info_code']);
$outside_lab = st($claimData['outside_lab']);
$s_charges = st($claimData['s_charges']);
$diagnosis_1 = st($claimData['diagnosis_1']);
$diagnosis_2 = st($claimData['diagnosis_2']);
$diagnosis_3 = st($claimData['diagnosis_3']);
$diagnosis_4 = st($claimData['diagnosis_4']);
$current_qual = st($claimData['current_qual']);
$diagnosis_a = st($claimData['diagnosis_a']);
$diagnosis_b = st($claimData['diagnosis_b']);
$diagnosis_c = st($claimData['diagnosis_c']);
$diagnosis_d = st($claimData['diagnosis_d']);
$diagnosis_e = st($claimData['diagnosis_e']);
$diagnosis_f = st($claimData['diagnosis_f']);
$diagnosis_g = st($claimData['diagnosis_g']);
$diagnosis_h = st($claimData['diagnosis_h']);
$diagnosis_i = st($claimData['diagnosis_i']);
$diagnosis_j = st($claimData['diagnosis_j']);
$diagnosis_k = st($claimData['diagnosis_k']);
$diagnosis_l = st($claimData['diagnosis_l']);

$claim_codes = st($claimData['claim_codes']);
$medicaid_resubmission_code = st($claimData['medicaid_resubmission_code']);
$resubmission_code_fill = st($claimData['resubmission_code_fill']);
$original_ref_no = st($claimData['original_ref_no']);
$prior_authorization_number = st($claimData['prior_authorization_number']);
$service_date1_from = st($claimData['service_date1_from']);
$service_date1_to = st($claimData['service_date1_to']);
$place_of_service1 = st($claimData['place_of_service1']);
$emg1 = st($claimData['emg1']);
$cpt_hcpcs1 = st($claimData['cpt_hcpcs1']);
$modifier1_1 = st($claimData['modifier1_1']);
$modifier1_2 = st($claimData['modifier1_2']);
$modifier1_3 = st($claimData['modifier1_3']);
$modifier1_4 = st($claimData['modifier1_4']);
$diagnosis_pointer1 = st($claimData['diagnosis_pointer1']);
$s_charges1_1 = st($claimData['s_charges1_1']);
$s_charges1_2 = st($claimData['s_charges1_2']);
$days_or_units1 = st($claimData['days_or_units1']);
$epsdt_family_plan1 = st($claimData['epsdt_family_plan1']);
$id_qua1 = st($claimData['id_qua1']);
$rendering_provider_id1 = st($claimData['rendering_provider_id1']);
$service_date2_from = st($claimData['service_date2_from']);
$service_date2_to = st($claimData['service_date2_to']);
$place_of_service2 = st($claimData['place_of_service2']);
$emg2 = st($claimData['emg2']);
$cpt_hcpcs2 = st($claimData['cpt_hcpcs2']);
$modifier2_1 = st($claimData['modifier2_1']);
$modifier2_2 = st($claimData['modifier2_2']);
$modifier2_3 = st($claimData['modifier2_3']);
$modifier2_4 = st($claimData['modifier2_4']);
$diagnosis_pointer2 = st($claimData['diagnosis_pointer2']);
$s_charges2_1 = st($claimData['s_charges2_1']);
$s_charges2_2 = st($claimData['s_charges2_2']);
$days_or_units2 = st($claimData['days_or_units2']);
$epsdt_family_plan2 = st($claimData['epsdt_family_plan2']);
$id_qua2 = st($claimData['id_qua2']);
$rendering_provider_id2 = st($claimData['rendering_provider_id2']);
$service_date3_from = st($claimData['service_date3_from']);
$service_date3_to = st($claimData['service_date3_to']);
$place_of_service3 = st($claimData['place_of_service3']);
$emg3 = st($claimData['emg3']);
$cpt_hcpcs3 = st($claimData['cpt_hcpcs3']);
$modifier3_1 = st($claimData['modifier3_1']);
$modifier3_2 = st($claimData['modifier3_2']);
$modifier3_3 = st($claimData['modifier3_3']);
$modifier3_4 = st($claimData['modifier3_4']);
$diagnosis_pointer3 = st($claimData['diagnosis_pointer3']);
$s_charges3_1 = st($claimData['s_charges3_1']);
$s_charges3_2 = st($claimData['s_charges3_2']);
$days_or_units3 = st($claimData['days_or_units3']);
$epsdt_family_plan3 = st($claimData['epsdt_family_plan3']);
$id_qua3 = st($claimData['id_qua3']);
$rendering_provider_id3 = st($claimData['rendering_provider_id3']);
$service_date4_from = st($claimData['service_date4_from']);
$service_date4_to = st($claimData['service_date4_to']);
$place_of_service4 = st($claimData['place_of_service4']);
$emg4 = st($claimData['emg4']);
$cpt_hcpcs4 = st($claimData['cpt_hcpcs4']);
$modifier4_1 = st($claimData['modifier4_1']);
$modifier4_2 = st($claimData['modifier4_2']);
$modifier4_3 = st($claimData['modifier4_3']);
$modifier4_4 = st($claimData['modifier4_4']);
$diagnosis_pointer4 = st($claimData['diagnosis_pointer4']);
$s_charges4_1 = st($claimData['s_charges4_1']);
$s_charges4_2 = st($claimData['s_charges4_2']);
$days_or_units4 = st($claimData['days_or_units4']);
$epsdt_family_plan4 = st($claimData['epsdt_family_plan4']);
$id_qua4 = st($claimData['id_qua4']);
$rendering_provider_id4 = st($claimData['rendering_provider_id4']);
$service_date5_from = st($claimData['service_date5_from']);
$service_date5_to = st($claimData['service_date5_to']);
$place_of_service5 = st($claimData['place_of_service5']);
$emg5 = st($claimData['emg5']);
$cpt_hcpcs5 = st($claimData['cpt_hcpcs5']);
$modifier5_1 = st($claimData['modifier5_1']);
$modifier5_2 = st($claimData['modifier5_2']);
$modifier5_3 = st($claimData['modifier5_3']);
$modifier5_4 = st($claimData['modifier5_4']);
$diagnosis_pointer5 = st($claimData['diagnosis_pointer5']);
$s_charges5_1 = st($claimData['s_charges5_1']);
$s_charges5_2 = st($claimData['s_charges5_2']);
$days_or_units5 = st($claimData['days_or_units5']);
$epsdt_family_plan5 = st($claimData['epsdt_family_plan5']);
$id_qua5 = st($claimData['id_qua5']);
$rendering_provider_id5 = st($claimData['rendering_provider_id5']);
$service_date6_from = st($claimData['service_date6_from']);
$service_date6_to = st($claimData['service_date6_to']);
$place_of_service6 = st($claimData['place_of_service6']);
$emg6 = st($claimData['emg6']);
$cpt_hcpcs6 = st($claimData['cpt_hcpcs6']);
$modifier6_1 = st($claimData['modifier6_1']);
$modifier6_2 = st($claimData['modifier6_2']);
$modifier6_3 = st($claimData['modifier6_3']);
$modifier6_4 = st($claimData['modifier6_4']);
$diagnosis_pointer6 = st($claimData['diagnosis_pointer6']);
$s_charges6_1 = st($claimData['s_charges6_1']);
$s_charges6_2 = st($claimData['s_charges6_2']);
$days_or_units6 = st($claimData['days_or_units6']);
$epsdt_family_plan6 = st($claimData['epsdt_family_plan6']);
$id_qua6 = st($claimData['id_qua6']);
$rendering_provider_id6 = st($claimData['rendering_provider_id6']);
$rendering_provider_entity_1  = st($claimData['rendering_provider_entity_1']);
$rendering_provider_first_name_1  = st($claimData['rendering_provider_first_name_1']);
$rendering_provider_last_name_1  = st($claimData['rendering_provider_last_name_1']);
$rendering_provider_org_1  = st($claimData['rendering_provider_org_1']);
$rendering_provider_npi_1  = st($claimData['rendering_provider_npi_1']);
$rendering_provider_entity_2  = st($claimData['rendering_provider_entity_2']);
$rendering_provider_first_name_2 = st($claimData['rendering_provider_first_name_2']);
$rendering_provider_last_name_2  = st($claimData['rendering_provider_last_name_2']);
$rendering_provider_org_2  = st($claimData['rendering_provider_org_2']);
$rendering_provider_npi_2  = st($claimData['rendering_provider_npi_2']);
$rendering_provider_entity_3  = st($claimData['rendering_provider_entity_3']);
$rendering_provider_first_name_3  = st($claimData['rendering_provider_first_name_3']);
$rendering_provider_last_name_3  = st($claimData['rendering_provider_last_name_3']);
$rendering_provider_org_3  = st($claimData['rendering_provider_org_3']);
$rendering_provider_npi_3  = st($claimData['rendering_provider_npi_3']);
$rendering_provider_entity_4  = st($claimData['rendering_provider_entity_4']);
$rendering_provider_first_name_4  = st($claimData['rendering_provider_first_name_4']);
$rendering_provider_last_name_4  = st($claimData['rendering_provider_last_name_4']);
$rendering_provider_org_4  = st($claimData['rendering_provider_org_4']);
$rendering_provider_npi_4  = st($claimData['rendering_provider_npi_4']);
$rendering_provider_entity_5  = st($claimData['rendering_provider_entity_5']);
$rendering_provider_first_name_5  = st($claimData['rendering_provider_first_name_5']);
$rendering_provider_last_name_5  = st($claimData['rendering_provider_last_name_5']);
$rendering_provider_org_5  = st($claimData['rendering_provider_org_5']);
$rendering_provider_npi_5  = st($claimData['rendering_provider_npi_5']);
$rendering_provider_entity_6  = st($claimData['rendering_provider_entity_6']);
$rendering_provider_first_name_6  = st($claimData['rendering_provider_first_name_6']);
$rendering_provider_last_name_6  = st($claimData['rendering_provider_last_name_6']);
$rendering_provider_org_6  = st($claimData['rendering_provider_org_6']);
$rendering_provider_npi_6  = st($claimData['rendering_provider_npi_6']);
$federal_tax_id_number = st($claimData['federal_tax_id_number']);
$ssn = st($claimData['ssn']);
$ein = st($claimData['ein']);
$patient_account_no = st($claimData['patient_account_no']);
$accept_assignment = st($claimData['accept_assignment']);
$total_charge = st($claimData['total_charge']);
$amount_paid = st($claimData['amount_paid']);
$balance_due = st($claimData['balance_due']);
$signature_physician = st($claimData['signature_physician']);
$physician_signed_date = st(($claimData['physician_signed_date']!='')?$claimData['physician_signed_date']:date('Y-m-d'));
$service_facility_info_name = st($claimData['service_facility_info_name']);
$service_facility_info_address = st($claimData['service_facility_info_address']);
$service_facility_info_city = st($claimData['service_facility_info_city']);
$service_facility_info = parseCityStateZip($service_facility_info_city);
$service_info_a = st($claimData['service_info_a']);
$service_info_dd = st($claimData['service_info_dd']);
$service_info_b_other = st($claimData['service_info_b_other']);
$billing_provider_phone_code = st($claimData['billing_provider_phone_code']);
$billing_provider_phone = st($claimData['billing_provider_phone']);
$billing_provider_name = st($claimData['billing_provider_name']);
$billing_provider_address = st($claimData['billing_provider_address']);
$billing_provider_city = st($claimData['billing_provider_city']);
$billing_provider_info = parseCityStateZip($billing_provider_city);
$billing_provider_a = st($claimData['billing_provider_a']);
$billing_provider_dd = st($claimData['billing_provider_dd']);
$billing_provider_b_other = st($claimData['billing_provider_b_other']);
$reject_reason = st($claimData['reject_reason']);
$status = st($claimData['status']);

$isMedicare = $insurancetype == 1;
$acceptAssignment = isOptionSelected($accept_assignment) || $accept_assignment == 'A';

$eResponse = [];
$eligibleResponse = [];

if ($isRejected) {
    $eDescriptions = eligibleDetailsFromClaimId($claimId);
    $eResponse = $eDescriptions['e_response'];
    $eligibleResponse = $eDescriptions['eligible_response'];
}

?>
<html>
<head>
    <title>Health Insurance E-File Claim Form</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://eligibleapi.com/css/eligible-claim-1500-2014.min.css?v=20160118" />
    <link rel="stylesheet" href="/manage/css/claim_form_eligible.css?v=<?= time() ?>" />
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript" src="https://eligibleapi.com/js/eligible-claim-1500-2014.min.js?v=20160118"></script>
    <script type="text/javascript" src="/manage/js/claim_form_eligible.js"></script>
    <?php if (config('app.debug')) { ?>
        <link rel="stylesheet" href="/manage/css/claim-form-mock.css?v=<?= time() ?>" />
        <script type="text/javascript" src="/manage/js/claim-form-mock-data.js?v=<?= time() ?>"></script>
        <script type="text/javascript" src="/manage/js/claim-form-mock.js?v=<?= time() ?>"></script>
    <?php } ?>
    <script type="text/javascript">
        window.eligiblePublicKey = "-a7xWM5Kn7V9sciZtT4zV92dlpp_RWvnpHS-";
        var stateList = <?= json_encode(stateList()) ?>;
        var claimData = <?= json_encode($claimData) ?>;
    </script>
</head>
<body>
    <div id="top-banner">
        <h2>E-File Claim Form</h2>
        <ol>
            <li>Enter electronic Payer ID or Name in Box 1.</li>
            <li>Verify all claim details.</li>
            <li>Click “Submit” on bottom left of claim to e-file your claim.</li>
        </ol>
        <?php if (!empty($is_front_office)) { ?>
            <input type="button" value="Back to Insurance Page"
                   onclick="window.location='view_claim.php?claimid=<?= $claimId ?>&pid=<?= $patientId ?>'; return false;" />
        <?php } elseif ($is_back_office) { ?>
            <input type="button" value="Back to Insurance Page"
                   onclick="window.location='manage_claims.php'; return false;" />
        <?php } ?>
        <input type="button" onclick="change_form();" value="Switch to Paper File" style="float:right;" />
        <?php if ($is_back_office) { ?>
            <input type="button" class="print-button" value="View Notes" style="float:right;margin-right:5px;"
                   onclick="window.location='claim_notes.php?id=<?= $claimId ?>&pid=<?= $patientId ?>'" />
        <?php } ?>
    </div>

<?php if ($isRejected) { ?>
    <div class="rejected-banner">
        <?php if (isset($eligibleResponse['response'])) { ?>
            <h3>
                <?= $eligibleResponse['event_type'] ?>
                on
                <?= $eligibleResponse['adddate'] ?>
            </h3>
            <?php if (is_object($eligibleResponse['response']->details)) { ?>
                <p>
                    Category:
                    <?= $eligibleResponse['response']->details->codes->category_code ?>
                    -
                    <?= $eligibleResponse['response']->details->codes->category_label ?>
                    <br />
                    Status:
                    <?= $eligibleResponse['response']->details->codes->status_code ?>
                    -
                    <?= $eligibleResponse['response']->details->codes->status_label ?>
                </p>
            <?php } elseif (is_array($eligibleResponse['response']->details) && $eligibleResponse['response']->details) { ?>
                <ul>
                    <?php foreach ($eligibleResponse['response']->details as $each) { ?>
                        <li><?= e($each) ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } elseif (isset($eResponse['response'])) { ?>
            <h3>
                Claim Electronically filed on
                <?= $eResponse['adddate'] ?>
            </h3>

            <?php if ($eResponse['response']->success === 'true' || $eResponse['response']->success === true) { ?>
                <p>
                    Success Response
                </p>
            <?php } else { ?>
                <p>Error response:</p>
                <ul>
                    <?php foreach ($eResponse['response']->errors as $error) { ?>
                        <li><?= htmlspecialchars($error->message) ?></li>
                    <?php } ?>
                </ul>
            <?php }
        } ?>
    </div>
<?php } ?>

<?php if($isSecondary){ ?>
        <h4>Secondary Claim (<a href="insurance_claim_eligible.php?insid=<?php echo $referencedClaimId; ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Primary is <?php echo $referencedClaimId; ?></a>)</h4>
<?php }else{ 
  $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='".$db->escape((!empty($_GET['insid']) ? $_GET['insid'] : ''))."'";
  $sec_r = $db->getRow($sec_sql);
?>
        <h4>Primary Claim
        <?php if(!empty($sec_r)){ ?>
                (<a href="insurance_claim_eligible.php?insid=<?php echo $sec_r['insuranceid']; ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&instype=2">Secondary is <?php echo $sec_r['insuranceid']; ?></a>)
        <?php } ?>
        </h4>
<?php } ?>

    <form style="clear:both;" method="post" id="claim-form"
        action="claim_handler.php?insid=<?= intval($_REQUEST['insid']) ?>&pid=<?= intval($_REQUEST['pid']) ?>">
        <div id="eligibleapi-claim-1500-form"></div>
    </form>

<script type="text/javascript">
function stateDropdown (fieldName) {
    var options = '', stateCode;

    // stateList is global
    for (stateCode in stateList) {
        options += '<option value="%code">%code - %name</option>'
            .replace(/%code/g, stateCode)
            .replace(/%name/g, stateList[stateCode]);
    }

    return '<select name="' + fieldName + '" class="input state"><option></option>' + options + '</select>';
}

  $(document).ready( function(){

    // set a patient signed date
    $('.input.grayout').find('input[placeholder="date"]').val('<?php echo $patient_signed_date; ?>');

      // Replace service_facility[address][state] field with a dropdown
      $('[name="service_facility[address][state]"]').replaceWith(stateDropdown('service_facility[address][state]'));
      $('[name="billing_provider[address][state]"]').replaceWith(stateDropdown('billing_provider[address][state]'));

    $('input[name="payer[id]"]').val("<?= st($payer['id']) ?>");
    $('input[name="payer[name]"]').val("<?= st($payer['name']) ?>");
    $('input[name="payer[address][street_line_1]"]').val("<?= st($payer['address']['street_line_1']) ?>");
    $('input[name="payer[address][city]"]').val("<?= st($payer['address']['city']) ?>");
    $('input[name="payer[address][state]"]').val("<?= st($payer['address']['state']) ?>");
    $('input[name="payer[address][zip]"]').val("<?= st($payer['address']['zip']) ?>");

    $('input[name="code"]').val("<?php echo $claim_codes;?>");

    $('input[name="subscriber[id]"]').val("<?php echo  $insured_id_number;?>");

    // claim[note]: old form
    // claim[additional_claim_info]: new form
    $('input[name="claim[note]"], input[name="claim[additional_claim_info]"]')
      .val("<?php echo (!empty($reserved_local_use1) ? $reserved_local_use1 : '');?>");
    $('[name="claim[additional_claim_info_code]"]')
      .val("<?php echo (!empty($claim_info_code) ? $claim_info_code : '');?>");

    $('input[name="claim[date]"]').val("<?php echo (!empty($date_current) ?  dateFormat($date_current) : '');?>");
    $('select[name="claim[date_type]"]').val("<?= $current_qual ?>");
    $('input[name="claim[outside_lab_charges]"]').val("<?php echo (!empty($s_charges) ? $s_charges : '');?>");

    $('input[name="dependent[last_name]"]').val("<?php echo  $patient_lastname;?>");
    $('input[name="dependent[first_name]"]').val("<?php echo  $patient_firstname;?>");
    $('input[name="dependent[middle_name]"]').val("<?php echo  $patient_middle;?>");

    $('input[name="dependent[dob]"]').val("<?php echo date('Y-m-d', strtotime(str_replace('-','/',$patient_dob)));?>");

    $('input[name="dependent[gender]"][value="<?= substr($patient_sex, 0, 1) ?>"]').prop('checked', true);
    $('input[name="dependent[address][street_line_1]"]').val("<?php echo  $patient_address;?>");
    $('input[name="dependent[address][city]"]').val("<?php echo  $patient_city;?>");
    $('input[name="dependent[address][state]"]').val("<?= strtoupper(trim($patient_state)) ?>").addClass("statemask");
    $('input[name="dependent[address][zip]"]').val("<?php echo  $patient_zip;?>").addClass("zipmask");
    $('input[name="dependent[phone_number]"]').val("<?php echo  $patient_phone_code.$patient_phone;?>").addClass("numbermask");
    <?php if($patient_relation_insured == 'Spouse' || $patient_relation_insured == '01'){ ?>
          $('input[name="dependent[relationship]"][value="01"]').prop('checked', true);
    <?php }elseif($patient_relation_insured == 'Child' || $patient_relation_insured == '19'){ ?>
          $('input[name="dependent[relationship]"][value="19"]').prop('checked', true);
    <?php }elseif($patient_relation_insured == 'Other' || $patient_relation_insured == 'G8'){ ?>
          $('input[name="dependent[relationship]"][value="G8"]').prop('checked', true);
    <?php } ?>
    $('input[name="subscriber[last_name]"]').val("<?= $insured_lastname;?>");
    $('input[name="subscriber[first_name]"]').val("<?= $insured_firstname;?>");
    $('input[name="subscriber[middle_name]"]').val("<?= $insured_middle;?>");
    $('input[name="subscriber[dob]"]').val("<?= date('Y-m-d', strtotime(str_replace('-','/',$insured_dob)));?>");
    $('input[name="subscriber[gender]"][value="<?= substr($insured_sex,0,1); ?>"]').prop('checked', true);
    $('input[name="subscriber[address][street_line_1]"]').val("<?= $insured_address;?>");
    $('input[name="subscriber[address][city]"]').val("<?= $insured_city;?>");
    $('input[name="subscriber[address][state]"]').val("<?= strtoupper(trim($insured_state)) ?>").addClass("statemask");
    $('input[name="subscriber[address][zip]"]').val("<?= $insured_zip;?>").addClass("zipmask");
    $('input[name="subscriber[phone_number]"]').val("<?= $insured_phone_code.$insured_phone;?>").addClass("numbermask");
    $('input[name="subscriber[group_id]"]').val("<?= $insured_policy_group_feca;?>");
    $('input[name="subscriber[group_name]"]').val("<?= $insured_insurance_plan;?>");


    $('input[name="other_payers[0][name]"]').val("<?= $other_insured_insurance_plan;?>");
    $('input[name="other_payers[0][subscriber][last_name]"]').val("<?= $other_insured_lastname;?>");
    $('input[name="other_payers[0][subscriber][first_name]"]').val("<?= $other_insured_firstname;?>");
    $('input[name="other_payers[0][subscriber][middle_name]"]').val("<?= $other_insured_middle;?>");
    $('input[name="other_payers[0][subscriber][group_id]"]').val("<?= $other_insured_policy_group_feca;?>");
    $('select[name="other_payers[0][responsibility_sequence]"]').val("<?php echo $responsibility_sequence ?>");
    $('select[name="other_payers[0][subscriber][insurance_type_code]"]').val(<?= json_encode($other_insured_insurance_type) ?>);

    <?php

    $employment = isOptionSelected($employment);
    $auto_accident = isOptionSelected($auto_accident);
    $other_accident = isOptionSelected($other_accident);
    $another_plan = isOptionSelected($another_plan);
    $outside_lab = isOptionSelected($outside_lab);

    ?>
    $('input[name="claim[related_to_employment]"][value="<?= json_encode(!!$employment) ?>"]').prop('checked', true);
    $('input[name="claim[auto_accident]"][value="<?= json_encode(!!$auto_accident) ?>"]').prop('checked', true);
    $('input[name="claim[auto_accident_state]"]').val("<?= $auto_accident_place ?>");
    $('input[name="claim[other_accident]"][value="<?= json_encode(!!$other_accident) ?>"]').prop('checked', true);
    $('input[name="other_payer"][value="<?= json_encode(!!$another_plan) ?>"]').prop('checked', true);

    $('input[name="claim[last_worked_date]"]').val("<?php echo dateFormat($unable_date_from); ?>");
    $('input[name="claim[work_return_date]"]').val("<?php echo dateFormat($unable_date_to); ?>");
    $('input[name="claim[admission_date]"]').val("<?php echo dateFormat($hospitalization_date_from); ?>");
    $('input[name="claim[discharge_date]"]').val("<?php echo dateFormat($hospitalization_date_to); ?>");

    <?php

    if (strpos($referring_provider, ',') !== false) {
        list($referring_provider_last, $referring_provider_first) = preg_split('/ *, */', $referring_provider, 2);
    } else {
        list($referring_provider_first, $referring_provider_last) = preg_split('/ +/', $referring_provider, 2);
    }

    ?>
    $('select[name="referring_provider[option], select[name="box17_provider_option"]').val("<?= $name_referring_provider_qualifier ?>");
    $('input[name="referring_provider[first_name], input[name="box17_provider[first_name]"]').val("<?= $referring_provider_first ?>");
    $('input[name="referring_provider[last_name]"], input[name="box17_provider[last_name]"]').val("<?= $referring_provider_last ?>");
    $('select[name="referring_provider[secondary_id_type]"], select[name="box17_provider[secondary_id_type]"]').val("<?php echo  $field_17a_dd; ?>");
    $('input[name="referring_provider[secondary_id]"], input[name="box17_provider[secondary_id]"]').val("<?php echo  $field_17a; ?>");
    $('input[name="referring_provider[npi]"], input[name="box17_provider[npi]').val("<?php echo  $diagnosising_npi; ?>");

    $('input[name="claim[outside_lab]"][value="<?= json_encode(!!$outside_lab) ?>"]').prop('checked', true);

    $('input[name="claim[payer_control_number]"]').val("<?php echo $original_ref_no; ?>");
    $('input[name="claim[prior_authorization_number]"]').val("<?php echo $prior_authorization_number; ?>");
  <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".$db->escape($diagnosis_1)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_a)){
      $diagnosis_a = $ins_diag['ins_diagnosis'];
     }
   ?>
   <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".$db->escape($diagnosis_2)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_b)){
       $diagnosis_b = $ins_diag['ins_diagnosis'];
     }
   ?>
   <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".$db->escape($diagnosis_3)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_c)){
       $diagnosis_c = $ins_diag['ins_diagnosis'];
     }
   ?>
   <?php
     $ins_diag_sql = "select * from dental_ins_diagnosis where ins_diagnosisid='".$db->escape($diagnosis_4)."'";
     $ins_diag_q = mysqli_query($con, $ins_diag_sql);
     $ins_diag = mysqli_fetch_assoc($ins_diag_q);
     if (!empty($ins_diag['ins_diagnosis']) && empty($diagnosis_d)){
       $diagnosis_d = $ins_diag['ins_diagnosis'];
     }
   ?>

    $('input[name="claim[diagnosis_codes][1]"]').val("<?= $diagnosis_a;?>");
    $('input[name="claim[diagnosis_codes][2]"]').val("<?= $diagnosis_b;?>");
    $('input[name="claim[diagnosis_codes][3]"]').val("<?= $diagnosis_c;?>");
    $('input[name="claim[diagnosis_codes][4]"]').val("<?= $diagnosis_d;?>");
    $('input[name="claim[diagnosis_codes][5]"]').val("<?= $diagnosis_e;?>");
    $('input[name="claim[diagnosis_codes][6]"]').val("<?= $diagnosis_f;?>");
    $('input[name="claim[diagnosis_codes][7]"]').val("<?= $diagnosis_g;?>");
    $('input[name="claim[diagnosis_codes][8]"]').val("<?= $diagnosis_h;?>");
    $('input[name="claim[diagnosis_codes][9]"]').val("<?= $diagnosis_i;?>");
    $('input[name="claim[diagnosis_codes][10]"]').val("<?= $diagnosis_j;?>");
    $('input[name="claim[diagnosis_codes][11]"]').val("<?= $diagnosis_k?>");
    $('input[name="claim[diagnosis_codes][12]"]').val("<?= $diagnosis_l;?>");

<?php

  if($isPrimaryPending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = '$patientId' "
       . "  AND ledger.docid = '$docId' "
       . "  AND trxn_code.docid = '$docId' "
       . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysqli_query($con, $sql);
    if ($charge_my && (mysqli_num_rows($charge_my) > 0)) {
      $charge_row = mysqli_fetch_array($charge_my);
      $total_charge = $charge_row['total_charge'];
    }
  }
  if($isSecondaryPending){
    $sql = "SELECT "
       . "  SUM(ledger.amount) as 'total_charge' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.primary_claim_id = '" . $referencedClaimId . "' "
       . "  AND ledger.patientid = '" . (!empty($_GET['pid']) ? $_GET['pid'] : '') . "' "
       . "  AND ledger.docid = '" . $docId . "' "
       . "  AND trxn_code.docid = '" . $docId . "' "
       . "  AND trxn_code.type = '" . DSS_TRXN_TYPE_MED . "' "
       . "ORDER BY "
       . "  ledger.service_date ASC";
    $charge_my = mysqli_query($con, $sql);
    if ($charge_my && (mysqli_num_rows($charge_my) > 0)) {
      $charge_row = mysqli_fetch_array($charge_my);
      $total_charge = $charge_row['total_charge'];
    }
  }

  // get amount paid
  $sql = "SELECT "
       . "  SUM(ledger.paid_amount) as 'amount_paid' "
       . "FROM "
       . "  dental_ledger ledger "
       . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
       . "WHERE "
       . "  ledger.status = " . DSS_TRXN_PENDING . " "
       . "  AND ledger.patientid = " . (!empty($_GET['pid']) ? $_GET['pid'] : '') . " "
       . "  AND ledger.docid = " . $docId . " "
       . "  AND trxn_code.docid = " . $docId . " "
       . "  AND trxn_code.type IN (" . DSS_TRXN_TYPE_PATIENT . "," . DSS_TRXN_TYPE_INS . "," . DSS_TRXN_TYPE_ADJ . ") "
       . "ORDER BY "
       . "  ledger.service_date ASC";
  if($status == DSS_CLAIM_SEC_PENDING){
    $sql = "SELECT
                sum(dlp.amount) as amount_paid
        from dental_ledger dl
                LEFT JOIN dental_users p ON dl.producerid=p.userid
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$docId."' and dl.patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'
                        AND primary_claim_id='".$referencedClaimId."'
                        AND dlp.amount != 0
                        AND dlp.payer = 0
        ";
  }
  $paid_my = $db->getRow($sql);
  if (!empty($paid_my)) {
    $paid_row = $paid_my;
  }

      // Get modifier codes
      $mod_sql = "SELECT * FROM dental_modifier_code";

      $mod_my = $db->getResults($mod_sql);
      $mod_array = array();
      if ($mod_my) foreach ($mod_my as $mod_row) {
        $mod_array[] = $mod_row;
      }

  // Load pending medical trxns if new claim form. Otherwise, load associated trxns.
$transactions = ClaimFormData::ledgerItems($claimId, $docId, $patientId, $insurancetype);

      /**
       * @see CS-29
       *
       * ICD-10 can be stored as "0" (paper) or "10" (e-file)
       * Since 2015-10-01, ICD-10 must be enforced
       */
      $li = 0;
      $oldestServiceDate = null;

      if ($transactions) foreach ($transactions as $array) {
        if (is_null($oldestServiceDate)) {
          $oldestServiceDate = dateToTime($array['service_date']);
        } else {
          $currentServiceDate = dateToTime($array['service_date']);
          $oldestServiceDate = $oldestServiceDate < $currentServiceDate ? $oldestServiceDate : $currentServiceDate;
        }

        $pos = ($array['placeofservice']!='')?$array['placeofservice']:$array['place'];
        $dp = ($array['diagnosispointer']!='')?$array['diagnosispointer']:1;
  ?>
        $('input[name="claim[service_lines][<?php echo $li;?>][service_date_from]"]').val("<?php echo  date('Y-m-d', strtotime($array['service_date'])); ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][service_date_to]"]').val("<?php echo  date('Y-m-d', strtotime($array['service_date'])) ?>");
        $('select[name="claim[service_lines][<?php echo $li;?>][place_of_service]"]').val("<?php echo  $pos; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][emergency]"]').val("<?php echo  $x; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_code]"]').val("<?php echo $array['transaction_code']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][0]"]').val("<?php echo  $array['modcode']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][1]"]').val("<?php echo  $array['modcode2']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][2]"]').val("<?php echo  $array['modcode3']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][procedure_modifiers][3]"]').val("<?php echo  $array['modcode4']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][diagnosis_code_pointers][<?php echo $dp-1; ?>]"]').prop('checked', true);
        $('input[name="claim[service_lines][<?php echo $li;?>][charge_amount]"]').val("<?php echo  number_format($array['amount'], 2,'.',''); ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][units]"]').val("<?php echo  $array['daysorunits']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][rendering_provider][first_name]"]').val("<?php echo  $array['provider_first_name']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][rendering_provider][last_name]"]').val("<?php echo  $array['provider_last_name']; ?>");
        $('input[name="claim[service_lines][<?php echo $li;?>][rendering_provider][npi]"]').val("<?php echo  $array['provider_id']; ?>");

      if (!$('input[name="claim[service_lines][<?= $li ?>][ledger_id]"]').length) {
          $('<input>', { type: 'hidden', name: 'claim[service_lines][<?= $li ?>][ledger_id]' })
              .insertAfter('input[name="claim[service_lines][<?= $li ?>][rendering_provider][npi]"]');
      }

      $('input[name="claim[service_lines][<?= $li ?>][ledger_id]"]').val('<?= $array['ledgerid'] ?>');
<?php
        $li++;
      }

      // Deactivate the ledger transactions that cannot be edited
      for (;$li<6;$li++) { ?>
          $('[name="claim[service_lines][<?= $li ?>][service_date_from]"]')
              .closest('tr')
              .addClass('grayout')
              .find('input, select')
              .attr('readonly', true);
      <?php }

    ?>
      $('input[name="claim[frequency]"][value="<?= $resubmission_code_fill ?>"]').prop('checked', true);
      // ICD Indicator: <?= $icd_indicator ?> .
      $('input[name="claim[icd_indicator]"]').val("<?= $icd_indicator ?>").addClass('numbermask');

  <?php if ($rendering_provider_first_name_1 != "") { ?>
      <?php if ($rendering_provider_entity_1){ ?>
      $('input[name="claim[service_lines][0][rendering_provider][entity]"][value="true"]').prop('checked', true);
      <?php } else { ?>
      $('input[name="claim[service_lines][0][rendering_provider][entity]"][value=""]').prop('checked', true);
      <?php } ?>
      $('input[name="claim[service_lines][0][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_1; ?>");
      $('input[name="claim[service_lines][0][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_1;  ?>");
      $('input[name="claim[service_lines][0][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_1;  ?>");
      $('input[name="claim[service_lines][0][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_1;  ?>");
      $('input[name="claim[service_lines][0][units]"]').val("<?php echo $days_or_units1;  ?>");
      <?php if ($rendering_provider_entity_2){ ?>
      $('input[name="claim[service_lines][1][rendering_provider][entity]"][value="true"]').prop('checked', true);
      <?php } else { ?>
      $('input[name="claim[service_lines][1][rendering_provider][entity]"][value=""]').prop('checked', true);
      <?php } ?>
      $('input[name="claim[service_lines][1][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_2; ?>");
      $('input[name="claim[service_lines][1][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_2;  ?>");
      $('input[name="claim[service_lines][1][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_2;  ?>");
      $('input[name="claim[service_lines][1][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_2;  ?>");
      $('input[name="claim[service_lines][1][units]"]').val("<?php echo $days_or_units2;  ?>");
      <?php if ($rendering_provider_entity_3){ ?>
      $('input[name="claim[service_lines][2][rendering_provider][entity]"][value="true"]').prop('checked', true);
      <?php } else { ?>
      $('input[name="claim[service_lines][2][rendering_provider][entity]"][value=""]').prop('checked', true);
      <?php } ?>
      $('input[name="claim[service_lines][2][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_3; ?>");
      $('input[name="claim[service_lines][2][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_3;  ?>");
      $('input[name="claim[service_lines][2][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_3;  ?>");
      $('input[name="claim[service_lines][2][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_3;  ?>");
      $('input[name="claim[service_lines][2][units]"]').val("<?php echo $days_or_units3;  ?>");
      <?php if ($rendering_provider_entity_4){ ?>
      $('input[name="claim[service_lines][3][rendering_provider][entity]"][value="true"]').prop('checked', true);
      <?php } else { ?>
      $('input[name="claim[service_lines][3][rendering_provider][entity]"][value=""]').prop('checked', true);
      <?php } ?>
      $('input[name="claim[service_lines][3][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_4; ?>");
      $('input[name="claim[service_lines][3][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_4;  ?>");
      $('input[name="claim[service_lines][3][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_4;  ?>");
      $('input[name="claim[service_lines][3][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_4;  ?>");
      $('input[name="claim[service_lines][3][units]"]').val("<?php echo $days_or_units4;  ?>");
      <?php if ($rendering_provider_entity_5){ ?>
      $('input[name="claim[service_lines][4][rendering_provider][entity]"][value="true"]').prop('checked', true);
      <?php } else { ?>
      $('input[name="claim[service_lines][4][rendering_provider][entity]"][value=""]').prop('checked', true);
      <?php } ?>
      $('input[name="claim[service_lines][4][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_5; ?>");
      $('input[name="claim[service_lines][4][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_5;  ?>");
      $('input[name="claim[service_lines][4][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_5;  ?>");
      $('input[name="claim[service_lines][4][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_5;  ?>");
      $('input[name="claim[service_lines][4][units]"]').val("<?php echo $days_or_units5;  ?>");
      <?php if ($rendering_provider_entity_6){ ?>
      $('input[name="claim[service_lines][5][rendering_provider][entity]"][value="true"]').prop('checked', true);
      <?php } else { ?>
      $('input[name="claim[service_lines][5][rendering_provider][entity]"][value=""]').prop('checked', true);
      <?php } ?>
      $('input[name="claim[service_lines][5][rendering_provider][first_name]"]').val("<?php echo $rendering_provider_first_name_6; ?>");
      $('input[name="claim[service_lines][5][rendering_provider][last_name]"]').val("<?php echo $rendering_provider_last_name_6;  ?>");
      $('input[name="claim[service_lines][5][rendering_provider][organization_name]"]').val("<?php echo $rendering_provider_org_6;  ?>");
      $('input[name="claim[service_lines][5][rendering_provider][npi]"]').val("<?php echo $rendering_provider_npi_6;  ?>");
      $('input[name="claim[service_lines][5][units]"]').val("<?php echo $days_or_units6; ?>");
      <?php
}

  if($acceptAssignment){ ?>
        $('input[name="claim[accept_assignment_code]"][value="A"]').prop('checked', true);
      <?php }else{ ?>
        $('input[name="claim[accept_assignment_code]"][value="C"]').prop('checked', true);
      <?php } ?>

      $('input[name="billing_provider[tax_id]"]').val("<?= $federal_tax_id_number ?>");
     
      <?php if($ssn=="1") { ?>
        $('input[name="billing_provider[tax_id_type]"][value="SY"]').prop('checked', true) 
      <?php } elseif($ein == "1") { ?>
        $('input[name="billing_provider[tax_id_type]"][value="EI"]').prop('checked', true) 
      <?php } ?>

      // This property change might not fire the change in the view
      $('input[name="billing_provider[entity]"][value="true"]').prop('checked', true);

      $('input[name="service_facility[name]"]').val("<?= $service_facility_info_name ?>");
      $('input[name="service_facility[address][street_line_1]"]').val("<?= $service_facility_info_address ?>");
      $('input[name="service_facility[address][city]"]').val("<?= $service_facility_info['city'] ?>");
      $('[name="service_facility[address][state]"]').val("<?= $service_facility_info['stateCode'] ?>");
      $('input[name="service_facility[address][zip]"]').val("<?= $service_facility_info['zip'] ?>").addClass("zipmask");
      $('input[name="service_facility[npi]"]').val("<?= $service_info_a ?>");
      $('input[name="billing_provider[phone_number]"]').val("<?= $billing_provider_phone_code.$billing_provider_phone ?>").addClass("numbermask");
      $('input[name="billing_provider[organization_name]"]').val("<?= $billing_provider_name ?>");
      $('input[name="billing_provider[address][street_line_1]"]').val("<?= $billing_provider_address ?>");
      $('input[name="billing_provider[address][city]"]').val("<?= $billing_provider_info['city'] ?>");
      $('[name="billing_provider[address][state]"]').val("<?= $billing_provider_info['stateCode'] ?>");
      $('input[name="billing_provider[address][zip]"]').val("<?= $billing_provider_info['zip'] ?>").addClass("zipmask");
      $('input[name="billing_provider[npi]"]').val("<?= $billing_provider_a ?>");
      $('input[name="billing_provider[taxonomy_code]"]').val(<?= json_encode($billing_provider_taxonomy_code) ?>)
          .attr('title', 'Common value: 332B00000X');
      $('input[name="claim[direct_payment_authorized]"]').prop('checked', <?= $insured_signature ? 'true' : 'false' ?>);

<?php
      $total_charge = (empty($total_charge)) ? 0.00 : $total_charge;
      $amount_paid = (empty($amount_paid)) ? 0.00 : number_format($amount_paid, 2);

      // We only calculate the dollar amounts when a new claim is created because
      // right now we aren't appending any trxns to an existing claim.
      if ($isPending) {

        // get total_charge
        if($isPrimaryPending){
          $sql = "SELECT "
             . "  SUM(ledger.amount) as 'total_charge' "
             . "FROM "
             . "  dental_ledger ledger "
             . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
             . "WHERE "
             . "  ledger.status = " . DSS_TRXN_PENDING . " "
             . "  AND ledger.primary_claim_id = '$claimId' "
           . "  AND ledger.patientid = '$patientId' "
           . "  AND ledger.docid = '$docId' "
           . "  AND trxn_code.docid = '$docId' "
           . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
           . "ORDER BY "
           . "  ledger.service_date ASC";

          $charge_my = $db->getResults($sql);
          if (($charge_my !== false) && (count($charge_my) > 0)) {
            $charge_row = $charge_my[0];
            $total_charge = $charge_row['total_charge'];
          }
        }
        // get amount paid
        $sql = "SELECT "
             . "  SUM(ledger.paid_amount) as 'amount_paid' "
             . "FROM "
             . "  dental_ledger ledger "
             . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
             . "WHERE "
             . "  ledger.status = " . DSS_TRXN_PENDING . " "
             . "  AND ledger.patientid = '$patientId' "
             . "  AND ledger.docid = '$docId' "
             . "  AND trxn_code.docid = '$docId' "
             . "  AND trxn_code.type IN (" . DSS_TRXN_TYPE_PATIENT . "," . DSS_TRXN_TYPE_INS . "," . DSS_TRXN_TYPE_ADJ . ") "
             . "ORDER BY "
             . "  ledger.service_date ASC";

        if($isSecondary && $status == DSS_CLAIM_SEC_PENDING) {
          $sql = "SELECT sum(dlp.amount) as amount_paid
                  from dental_ledger dl
                  LEFT JOIN dental_users p ON dl.producerid=p.userid
                  LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                  where dl.docid='$docId' and dl.patientid='$patientId'
                  AND primary_claim_id='$claimId'
                  AND dlp.amount != 0
                  AND dlp.payer = 0";
        }

        $paid_my = $db->getResults($sql);
        if (($paid_my !== false) && (count($paid_my) > 0)) {
          $paid_row = $paid_my[0];
        }

        // format calculations
        $total_charge = number_format($total_charge, 2, '.','');
      }

      $patient_signature = isOptionSelected($patient_signature);
      $signature_physician = isOptionSelected($signature_physician);

      ?>
      $('input[name="claim[total_charge]"]').val("<?php echo  $total_charge; ?>");
      $('input[name="claim[patient_amount_paid]"]').val("<?php echo  $amount_paid; ?>");
      $('input[name="claim[patient_signature_on_file]"]').prop('checked', <?= json_encode(!!$patient_signature) ?>);
      $('input[name="claim[provider_signature_on_file]"]').prop('checked', <?= json_encode(!!$signature_physician) ?>);
      $('input[name="claim[signature_date]"]').val("<?php echo dateFormat($physician_signed_date); ?>");

      $('input, select').bind('change', function(){
          form_changed=true;
      });

      // No DB columns for these fields, or no data goes here
      $('\
          [name="payer[address][street_line_2]"], \
          [name="dependent[address][street_line_2]"], \
          [name="subscriber[address][street_line_2]"], \
          [name="referring_provider[middle_name]"], \
          [name="box17_provider[middle_name]"], \
          [name="service_facility[address][street_line_2]"], \
          [name="billing_provider[address][street_line_2]"], \
          [name="referring_provider[secondary_id_type]"], \
          [name="box17_provider[secondary_id_type]"], \
          [name="referring_provider[secondary_id]"], \
          [name="box17_provider[secondary_id]"] \
      ')
          .attr('readonly', true)
          .addClass('grayout')
          .closest('td')
          .addClass('grayout');
  });

  $(".date_field").keydown(function(e){
      var key = e.charCode || e.keyCode || 0;

      // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
      return (
          key == 8 ||
              key == 9 ||
              key == 46 ||
              key == 189 ||
              key == 191 ||
              (key >= 37 && key <= 40) ||
              (key >= 48 && key <= 57) ||
              (key >= 96 && key <= 105));
  });
  $(".number_field").keydown(function(e){
      var key = e.charCode || e.keyCode || 0;

      // allow backspace, tab, delete, numbers and keypad numbers ONLY
      return (
          key == 8 ||
              key == 9 ||
              key == 46 ||
              key == 110 ||
              key == 190 ||
              (key >= 48 && key <= 57) ||
              (key >= 96 && key <= 105));
  });

  function file_reject_claim(){
      if($('#p_m_ins_payer_id').val()==""){
          alert('Insurance payer must be selected to electronically file claim.');
          return false;
      }
      c = confirm('You are about to resubmit a rejected claim. Please make sure you have corrected all errors, then click OK to resend the claim.');
      return c;
  }
  function file_claim(){
      if($('#p_m_ins_payer_id').val()==""){
          alert('Insurance payer must be selected to electronically file claim.');
          return false;
      }
      c = confirm('You are about to electronically submit this claim, are you sure?');
      return c;
  }

  function change_form(){
      if(form_changed){
          if(confirm('Your changes to this claim will be lost if you change to electronic submission. Click \'Ok\' to proceed or \'Cancel\' to return to paper form.')){
              window.location = "<?= $v2_form ?>";
          }
      }else{
          window.location = "<?= $v2_form ?>";
      }
      return false;
  }
  form_changed=false;

</script>

  <div id="change_confirm" style="display:none;top:0;height:100%;background:#fff; position:fixed; top:20px; width:100%; opacity:90%;">
    <p>MESSAGE</p>
    <input type="button" value="Save" />
    <input type="button" onclick="window.location='<?php echo  $v2_form; ?>';" value="Don't Save" />
    <input type="button" onclick="$('#change_confirm').hide();" value="Cancel" />
  </div>

</body>
</html>
