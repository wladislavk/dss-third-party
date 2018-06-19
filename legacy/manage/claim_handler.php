<?php
namespace Ds3\Libraries\Legacy;

$is_front_office = empty($is_back_office);

include_once __DIR__ . '/includes/constants.inc';
include_once __DIR__ . '/admin/includes/main_include.php';
include_once __DIR__ . '/includes/claim_functions.php';
include_once __DIR__ . '/admin/includes/claim_functions.php';
include_once __DIR__ . '/admin/includes/invoice_functions.php';

$claimId = intval($_GET['insid']);
$patientId = intval($_GET['pid']);

// Reject processing the claim if there is no POST data
if (!isset($_POST['claim']) || !is_array($_POST['claim'])) { ?>
    <script type="text/javascript">
        window.location = "manage_claims.php";
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$db = new Db();

$status = $db->getColumn("SELECT status
    FROM dental_insurance
    WHERE insuranceid = '$claimId'
        AND patientid = '$patientId'", 'status', 0);

$isPending = ClaimFormData::isStatus('pending', $status);

if ($isPending && hasLedgerTransactionsChanged($claimId, $_POST['claim']['service_lines'])) { ?>
    <script type="text/javascript">
        window.location = "manage_claims.php?msg=Error sending claim: Frontoffice user has altered claim. Please reload and try again.";
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$jsonResponse = saveEfileClaimForm($claimId, $patientId, $_POST, $status, !$is_front_office);

if (!is_object($jsonResponse) || !isset($jsonResponse->success)) { ?>
    <script type="text/javascript">
        c = confirm('There was an error in Eligible API, the claim has been marked as sent.\n\nDo you want to go back to the Pending Claims page?');

        if (c) {
            window.location = "manage_claims.php?status=0";
        } else {
            window.history.back();
        }
    </script>
<?php } elseif (!$jsonResponse->success) {
    $confirm = ['Submission failed.'];
    $errors = $jsonResponse->errors;

    if (is_array($errors) && count($errors)) {
        foreach ($errors as $error) {
            $confirm []= $error->message;
        }
    } else {
        $confirm = ['The processing API is experiencing high load at the moment and the request could not be processed.'];
    }

    ?>
    <script type="text/javascript">
        var apiErrors = <?= json_encode($confirm) ?>;
        var message = apiErrors.shift();
        if (apiErrors.length) {
            message += '\n\n* ' + apiErrors.join('\n* ');
        }
        alert('E-File Response: ' + message);
        window.location = "manage_claims.php?status=0&insid=<?= $claimId ?>";
    </script>
<?php } else { ?>
    <script type="text/javascript">
        alert("E-File Response: [Success: true]");
        window.location = "manage_claims.php?status=0";
    </script>
<?php }

/**
 * Auxiliary function to encapsulate the save logic
 *
 * The $formerStatus status can be determined from the $claimId, but we take the "lazy load" approach and reuse
 * the value already determined before calling this function.
 *
 * This is the counterpart of the savePaperClaimForm function in claim_form_v2.inc
 *
 * @param int   $claimId
 * @param int   $patientId
 * @param array $claimData
 * @param int   $formerStatus
 * @param bool  $filedByBackOffice
 * @return object Eligible response
 */
function saveEfileClaimForm ($claimId, $patientId, $claimData, $formerStatus, $filedByBackOffice = false) {
    $db = new Db();

    /**
     * Session 'userid' is not reliable if we are not navigating a BO page
     * Yet, 'userid' cannot be empty. At a later step, we will ste a default.
     */
    $userId = $filedByBackOffice ? 0 : intval($_SESSION['userid']);

    $claimId = intval($claimId);
    $patientId = intval($patientId);
    $isNewClaim = !$claimId;

    $isFormerPrimary = !$db->getColumn("SELECT primary_claim_id FROM dental_insurance WHERE insuranceid = '$claimId'", 'primary_claim_id', 0);
    $isFormerPending = ClaimFormData::isStatus('pending', $formerStatus);
    $isFormerRejected = ClaimFormData::isStatus('rejected', $formerStatus);
    $needsBackOfficeMarkerUpdate = $isFormerPending || $isFormerRejected;

    $filedByBackOfficeMarker = $filedByBackOffice && $needsBackOfficeMarkerUpdate ? 3 : 0;

    /**
     * Status changes:
     *
     * - IF marked for rejection THEN rejected
     * - IF new claim THEN pending
     * - IF pending THEN sent
     * - IF rejected THEN sent
     * - ELSE preserve the current status
     */
    if (isset($claimData['reject_but'])) {
        $status = $isFormerPrimary ? DSS_CLAIM_REJECTED : DSS_CLAIM_SEC_REJECTED;
    } elseif ($isNewClaim) {
        $status = $isFormerPrimary ? DSS_CLAIM_PENDING : DSS_CLAIM_SEC_PENDING;
    } elseif ($isFormerPending || $isFormerRejected) {
        $status = $isFormerPrimary ? DSS_CLAIM_SENT : DSS_CLAIM_SEC_SENT;
    } else {
        $status = $formerStatus;
    }

    $patientData = $db->getRow("SELECT has_s_m_ins, docid FROM dental_patients WHERE patientid = '$patientId'");
    $patientData = $patientData ?: [];

    $docId = intval($patientData['docid']);
    $userId = $userId ?: $docId;

    // Ensure the POST fields exist
    $payer = [
        'id' => !empty($claimData['payer']['id']) ? $claimData['payer']['id'] : '',
        'name' => !empty($claimData['payer']['name']) ? $claimData['payer']['name'] : '',
        'address' => [
            'street_line_1' => !empty($claimData['payer']['address']['street_line_1']) ?
                    $claimData['payer']['address']['street_line_1'] : '',
            'city' => !empty($claimData['payer']['address']['city']) ? $claimData['payer']['address']['city'] : '',
            'state' => !empty($claimData['payer']['address']['state']) ? $claimData['payer']['address']['state'] : '',
            'zip' => !empty($claimData['payer']['address']['zip']) ? $claimData['payer']['address']['zip'] : '',
        ]
    ];

    $patient_lastname = !empty($claimData['dependent']['last_name']) ? $claimData['dependent']['last_name'] : '';
    $patient_firstname = !empty($claimData['dependent']['first_name']) ? $claimData['dependent']['first_name'] : '';
    $patient_middle = !empty($claimData['dependent']['middle_name']) ? $claimData['dependent']['middle_name'] : '';
    $patient_dob = !empty($claimData['dependent']['dob']) ? $claimData['dependent']['dob'] : '';
    $patient_address = !empty($claimData['dependent']['address']['street_line_1']) ?
        $claimData['dependent']['address']['street_line_1'] : '';
    $patient_city = !empty($claimData['dependent']['address']['city']) ?
        $claimData['dependent']['address']['city'] : '';
    $patient_state = !empty($claimData['dependent']['address']['state']) ?
        $claimData['dependent']['address']['state'] : '';
    $patient_zip = !empty($claimData['dependent']['address']['zip']) ? $claimData['dependent']['address']['zip'] : '';
    list($patient_phone_code, $patient_phone) = parsePhoneNumber($claimData['dependent']['phone_number']);
    $patient_sex = !empty($claimData['dependent']['gender']) ? $claimData['dependent']['gender'] : '';
    $insured_id_number = !empty($claimData['subscriber']['id']) ? $claimData['subscriber']['id'] : '';
    $insured_firstname = !empty($claimData['subscriber']['first_name']) ? $claimData['subscriber']['first_name'] : '';
    $insured_lastname = !empty($claimData['subscriber']['last_name']) ? $claimData['subscriber']['last_name'] : '';
    $insured_middle = !empty($claimData['subscriber']['middle_name']) ? $claimData['subscriber']['middle_name'] : '';
    $patient_relation_insured_tmp = !empty($claimData['dependent']['relationship']) ?
        $claimData['dependent']['relationship'] : '';

    if ($patient_relation_insured_tmp == '01') {
        $patient_relation_insured = "Spouse";
    } elseif ($patient_relation_insured_tmp == '19') {
        $patient_relation_insured = "Child";
    } elseif ($patient_relation_insured_tmp == 'G8') {
        $patient_relation_insured = "Other";
    } else {
        $patient_relation_insured = "Self";
    }

    $insured_address = !empty($claimData['subscriber']['address']['street_line_1']) ?
        $claimData['subscriber']['address']['street_line_1'] : '';
    $insured_state = !empty($claimData['subscriber']['address']['state']) ?
        $claimData['subscriber']['address']['state'] : '';
    $insured_city = !empty($claimData['subscriber']['address']['city']) ?
        $claimData['subscriber']['address']['city'] : '';
    $insured_zip = !empty($claimData['subscriber']['address']['zip']) ? $claimData['subscriber']['address']['zip'] : '';
    list($insured_phone_code, $insured_phone) = parsePhoneNumber($claimData['subscriber']['phone_number']);
    $other_insured_firstname = !empty($claimData['other_payers'][0]['subscriber']['first_name']) ?
        $claimData['other_payers'][0]['subscriber']['first_name'] : '';
    $other_insured_lastname = !empty($claimData['other_payers'][0]['subscriber']['last_name']) ?
        $claimData['other_payers'][0]['subscriber']['last_name'] : '';
    $other_insured_middle = !empty($claimData['other_payers'][0]['subscriber']['middle_name']) ?
        $claimData['other_payers'][0]['subscriber']['middle_name'] : '';
    $claim_codes = $claimData['code'];
    $employment = !empty($claimData['claim']['related_to_employment']) ?
        $claimData['claim']['related_to_employment'] : '';
    $auto_accident = !empty($claimData['claim']['auto_accident']) ? $claimData['claim']['auto_accident'] : '';
    $auto_accident_place = !empty($claimData['claim']['auto_accident_state']) ?
        $claimData['claim']['auto_accident_state'] : '';
    $other_accident = !empty($claimData['claim']['other_accident']) ? $claimData['claim']['other_accident'] : '';
    $insured_policy_group_feca = !empty($claimData['subscriber']['group_id']) ?
        $claimData['subscriber']['group_id'] : '';
    $other_insured_policy_group_feca = !empty($claimData['other_payers'][0]['subscriber']['group_id']) ?
        $claimData['other_payers'][0]['subscriber']['group_id'] : '';
    $insured_dob = !empty($claimData['subscriber']['dob']) ? $claimData['subscriber']['dob'] : '';
    $insured_sex = !empty($claimData['subscriber']['gender']) ? $claimData['subscriber']['gender'] : '';
    $insured_insurance_plan = !empty($claimData['subscriber']['group_name']) ?
        $claimData['subscriber']['group_name'] : '';
    $other_insured_insurance_plan = !empty($claimData['other_payers'][0]['name']) ?
        $claimData['other_payers'][0]['name'] : '';
    $other_payer = !empty($claimData['other_payer']) ? $claimData['other_payer'] : '';
    $responsibility_sequence = !empty($claimData['other_payers'][0]['responsibility_sequence']) ?
        $claimData['other_payers'][0]['responsibility_sequence'] : '';
    $other_insured_insurance_type = !empty($claimData['other_payers'][0]['subscriber']['insurance_type_code']) ?
        $claimData['other_payers'][0]['subscriber']['insurance_type_code'] : '';
    $icd_indicator = isset($claimData['claim']['icd_indicator']) ? $claimData['claim']['icd_indicator'] : '';

    // New form will use the new field
    $reserved_local_use1 = isset($claimData['claim']['note']) ? $claimData['claim']['note'] :
        (isset($claimData['claim']['additional_claim_info']) ? $claimData['claim']['additional_claim_info'] : '');
    $claim_info_code = isset($claimData['claim']['additional_claim_info_code']) ?
        $claimData['claim']['additional_claim_info_code'] : '';

    if (isOptionSelected($other_payer)) {
        $another_plan = "YES";
    } else {
        $another_plan = "NO";
    }

    $patient_signature = !empty($claimData['claim']['patient_signature_on_file']) ?
        $claimData['claim']['patient_signature_on_file'] : '';
    $insured_signature = !empty($claimData['claim']['direct_payment_authorized']) ?
        $claimData['claim']['direct_payment_authorized'] : '';
    $date_current = !empty($claimData['claim']['date']) ? $claimData['claim']['date'] : '';
    $current_qual = !empty($claimData['claim']['date_type']) ? $claimData['claim']['date_type'] : '';
    $unable_date_from = !empty($claimData['claim']['last_worked_date']) ? $claimData['claim']['last_worked_date'] : '';
    $unable_date_to = !empty($claimData['claim']['work_return_date']) ? $claimData['claim']['work_return_date'] : '';

    /**
     * @see DSS-272
     *
     * Eligible fields for box 17 were renamed by Eligible
     */
    if (!empty($claimData['box17_provider'])) {
        $name_referring_provider_qualifier = array_get($claimData, 'box17_provider_option', '');

        if (
            !empty($claimData['box17_provider']['first_name']) &&
            !empty($claimData['box17_provider']['last_name'])
        ) {
            $referring_provider = trim($claimData['box17_provider']['last_name']) . ', ' .
                trim($claimData['box17_provider']['first_name']);
        } else {
            // This concatenation will cause to lose the "last_name" field IF the first_name field is empty
            $referring_provider =
                trim($claimData['box17_provider']['first_name'] . $claimData['box17_provider']['last_name']);
        }

        $field_17a_dd = !empty($claimData['box17_provider']['secondary_id_type']) ?
            $claimData['box17_provider']['secondary_id_type'] : '';
        $field_17a = !empty($claimData['box17_provider']['secondary_id']) ?
            $claimData['box17_provider']['secondary_id'] : '';
        $field_17b = !empty($claimData['box17_provider']['npi']) ? $claimData['box17_provider']['npi'] : '';
    } else {
        $name_referring_provider_qualifier = array_get($claimData, 'referring_provider.option', '');

        if (
            !empty($claimData['referring_provider']['first_name']) &&
            !empty($claimData['referring_provider']['last_name'])
        ) {
            $referring_provider = trim($claimData['referring_provider']['last_name']) . ', ' .
                trim($claimData['referring_provider']['first_name']);
        } else {
            // This concatenation will cause to lose the "last_name" field IF the first_name field is empty
            $referring_provider =
                trim($claimData['referring_provider']['first_name'] . $claimData['referring_provider']['last_name']);
        }

        $field_17a_dd = !empty($claimData['referring_provider']['secondary_id_type']) ?
            $claimData['referring_provider']['secondary_id_type'] : '';
        $field_17a = !empty($claimData['referring_provider']['secondary_id']) ?
            $claimData['referring_provider']['secondary_id'] : '';
        $field_17b = !empty($claimData['referring_provider']['npi']) ? $claimData['referring_provider']['npi'] : '';
    }

    $hospitalization_date_from = !empty($claimData['claim']['admission_date']) ?
        $claimData['claim']['admission_date'] : '';
    $hospitalization_date_to = !empty($claimData['claim']['discharge_date']) ?
        $claimData['claim']['discharge_date'] : '';
    $outside_lab = !empty($claimData['claim']['outside_lab']) ? $claimData['claim']['outside_lab'] : '';
    $s_charges = !empty($claimData['claim']['outside_lab_charges']) ? $claimData['claim']['outside_lab_charges'] : '';
    $diagnosis_a = !empty($claimData['claim']['diagnosis_codes'][1]) ? $claimData['claim']['diagnosis_codes'][1] : '';
    $diagnosis_b = !empty($claimData['claim']['diagnosis_codes'][2]) ? $claimData['claim']['diagnosis_codes'][2] : '';
    $diagnosis_c = !empty($claimData['claim']['diagnosis_codes'][3]) ? $claimData['claim']['diagnosis_codes'][3] : '';
    $diagnosis_d = !empty($claimData['claim']['diagnosis_codes'][4]) ? $claimData['claim']['diagnosis_codes'][4] : '';
    $diagnosis_e = !empty($claimData['claim']['diagnosis_codes'][5]) ? $claimData['claim']['diagnosis_codes'][5] : '';
    $diagnosis_f = !empty($claimData['claim']['diagnosis_codes'][6]) ? $claimData['claim']['diagnosis_codes'][6] : '';
    $diagnosis_g = !empty($claimData['claim']['diagnosis_codes'][7]) ? $claimData['claim']['diagnosis_codes'][7] : '';
    $diagnosis_h = !empty($claimData['claim']['diagnosis_codes'][8]) ? $claimData['claim']['diagnosis_codes'][8] : '';
    $diagnosis_i = !empty($claimData['claim']['diagnosis_codes'][9]) ? $claimData['claim']['diagnosis_codes'][9] : '';
    $diagnosis_j = !empty($claimData['claim']['diagnosis_codes'][10]) ? $claimData['claim']['diagnosis_codes'][10] : '';
    $diagnosis_k = !empty($claimData['claim']['diagnosis_codes'][11]) ? $claimData['claim']['diagnosis_codes'][11] : '';
    $diagnosis_l = !empty($claimData['claim']['diagnosis_codes'][12]) ? $claimData['claim']['diagnosis_codes'][12] : '';
    $resubmission_code_fill = !empty($claimData['claim']['frequency']) ? $claimData['claim']['frequency'] : '';
    $original_ref_no = !empty($claimData['claim']['payer_control_number']) ?
        $claimData['claim']['payer_control_number'] : '';
    $prior_authorization_number = !empty($claimData['claim']['prior_authorization_number']) ?
        $claimData['claim']['prior_authorization_number'] : '';
    $service_date1_from = !empty($claimData['claim']['service_lines'][0]['service_date_from']) ?
        $claimData['claim']['service_lines'][0]['service_date_from'] : '';
    $service_date1_to = !empty($claimData['claim']['service_lines'][0]['service_date_to']) ?
        $claimData['claim']['service_lines'][0]['service_date_to'] : '';
    $place_of_service1 = !empty($claimData['claim']['service_lines'][0]['place_of_service']) ?
        $claimData['claim']['service_lines'][0]['place_of_service'] : '';
    $emg1 = !empty($claimData['claim']['service_lines'][0]['emergency']) ?
        $claimData['claim']['service_lines'][0]['emergency'] : '';
    $cpt_hcpcs1 = !empty($claimData['claim']['service_lines'][0]['procedure_code']) ?
        $claimData['claim']['service_lines'][0]['procedure_code'] : '';
    $modifier1_1 = !empty($claimData['claim']['service_lines'][0]['procedure_modifiers'][0]) ?
        $claimData['claim']['service_lines'][0]['procedure_modifiers'][0] : '';
    $modifier1_2 = !empty($claimData['claim']['service_lines'][0]['procedure_modifiers'][1]) ?
        $claimData['claim']['service_lines'][0]['procedure_modifiers'][1] : '';
    $modifier1_3 = !empty($claimData['claim']['service_lines'][0]['procedure_modifiers'][2]) ?
        $claimData['claim']['service_lines'][0]['procedure_modifiers'][2] : '';
    $modifier1_4 = !empty($claimData['claim']['service_lines'][0]['procedure_modifiers'][3]) ?
        $claimData['claim']['service_lines'][0]['procedure_modifiers'][3] : '';
    $diagnosis_pointer1 = !empty($claimData['claim']['service_lines'][0]['diagnosis_code_pointers']) ?
        $claimData['claim']['service_lines'][0]['diagnosis_code_pointers'] : '';
    $s_charges1_1 = !empty($claimData['claim']['service_lines'][0]['charge_amount']) ?
        $claimData['claim']['service_lines'][0]['charge_amount'] : '';
    $days_or_units1 = !empty($claimData['claim']['service_lines'][0]['units']) ?
        $claimData['claim']['service_lines'][0]['units'] : '';
    $id_qua1 = !empty($claimData['claim']['service_lines'][0]['rendering_provider']['secondary_id_type']) ?
        $claimData['claim']['service_lines'][0]['rendering_provider']['secondary_id_type'] : '';
    $rendering_provider_id1 = !empty($claimData['claim']['service_lines'][0]['ledger_id']) ?
        $claimData['claim']['service_lines'][0]['ledger_id'] : '';
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_1 = !empty($claimData['claim']['service_lines'][0]['rendering_provider']['entity']) ?
        $claimData['claim']['service_lines'][0]['rendering_provider']['entity'] : '';
    $rendering_provider_first_name_1 =
        !empty($claimData['claim']['service_lines'][0]['rendering_provider']['first_name']) ?
            $claimData['claim']['service_lines'][0]['rendering_provider']['first_name'] : '';
    $rendering_provider_last_name_1 =
        !empty($claimData['claim']['service_lines'][0]['rendering_provider']['last_name']) ?
            $claimData['claim']['service_lines'][0]['rendering_provider']['last_name'] : '';
    $rendering_provider_org_1 =
        !empty($claimData['claim']['service_lines'][0]['rendering_provider']['organization_name']) ?
            $claimData['claim']['service_lines'][0]['rendering_provider']['organization_name'] : '';
    $rendering_provider_npi_1 =
        !empty($claimData['claim']['service_lines'][0]['rendering_provider']['npi']) ?
            $claimData['claim']['service_lines'][0]['rendering_provider']['npi'] : '';

    $service_date2_from = !empty($claimData['claim']['service_lines'][1]['service_date_from']) ?
        $claimData['claim']['service_lines'][1]['service_date_from'] : '';
    $service_date2_to = !empty($claimData['claim']['service_lines'][1]['service_date_to']) ?
        $claimData['claim']['service_lines'][1]['service_date_to'] : '';
    $place_of_service2 = !empty($claimData['claim']['service_lines'][1]['place_of_service']) ?
        $claimData['claim']['service_lines'][1]['place_of_service'] : '';
    $emg2 = !empty($claimData['claim']['service_lines'][1]['emergency']) ?
        $claimData['claim']['service_lines'][1]['emergency'] : '';
    $cpt_hcpcs2 = !empty($claimData['claim']['service_lines'][1]['procedure_code']) ?
        $claimData['claim']['service_lines'][1]['procedure_code'] : '';
    $modifier2_1 = !empty($claimData['claim']['service_lines'][1]['procedure_modifiers'][0]) ?
        $claimData['claim']['service_lines'][1]['procedure_modifiers'][0] : '';
    $modifier2_2 = !empty($claimData['claim']['service_lines'][1]['procedure_modifiers'][1]) ?
        $claimData['claim']['service_lines'][1]['procedure_modifiers'][1] : '';
    $modifier2_3 = !empty($claimData['claim']['service_lines'][1]['procedure_modifiers'][2]) ?
        $claimData['claim']['service_lines'][1]['procedure_modifiers'][2] : '';
    $modifier2_4 = !empty($claimData['claim']['service_lines'][1]['procedure_modifiers'][3]) ?
        $claimData['claim']['service_lines'][1]['procedure_modifiers'][3] : '';
    $diagnosis_pointer2 = !empty($claimData['claim']['service_lines'][1]['diagnosis_code_pointers']) ?
        $claimData['claim']['service_lines'][1]['diagnosis_code_pointers'] : '';
    $s_charges2_1 = !empty($claimData['claim']['service_lines'][1]['charge_amount']) ?
        $claimData['claim']['service_lines'][1]['charge_amount'] : '';
    $days_or_units2 = !empty($claimData['claim']['service_lines'][1]['units']) ?
        $claimData['claim']['service_lines'][1]['units'] : '';
    $id_qua2 = !empty($claimData['claim']['service_lines'][1]['rendering_provider']['secondary_id_type']) ?
        $claimData['claim']['service_lines'][1]['rendering_provider']['secondary_id_type'] : '';
    $rendering_provider_id2 = !empty($claimData['claim']['service_lines'][1]['ledger_id']) ?
        $claimData['claim']['service_lines'][1]['ledger_id'] : '';
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_2 = !empty($claimData['claim']['service_lines'][1]['rendering_provider']['entity']) ?
        $claimData['claim']['service_lines'][1]['rendering_provider']['entity'] : '';
    $rendering_provider_first_name_2 =
        !empty($claimData['claim']['service_lines'][1]['rendering_provider']['first_name']) ?
            $claimData['claim']['service_lines'][1]['rendering_provider']['first_name'] : '';
    $rendering_provider_last_name_2 =
        !empty($claimData['claim']['service_lines'][1]['rendering_provider']['last_name']) ?
            $claimData['claim']['service_lines'][1]['rendering_provider']['last_name'] : '';
    $rendering_provider_org_2 =
        !empty($claimData['claim']['service_lines'][1]['rendering_provider']['organization_name']) ?
            $claimData['claim']['service_lines'][1]['rendering_provider']['organization_name'] : '';
    $rendering_provider_npi_2 = !empty($claimData['claim']['service_lines'][1]['rendering_provider']['npi']) ?
        $claimData['claim']['service_lines'][1]['rendering_provider']['npi'] : '';

    $service_date3_from = !empty($claimData['claim']['service_lines'][2]['service_date_from']) ?
        $claimData['claim']['service_lines'][2]['service_date_from'] : '';
    $service_date3_to = !empty($claimData['claim']['service_lines'][2]['service_date_to']) ?
        $claimData['claim']['service_lines'][2]['service_date_to'] : '';
    $place_of_service3 = !empty($claimData['claim']['service_lines'][2]['place_of_service']) ?
        $claimData['claim']['service_lines'][2]['place_of_service'] : '';
    $emg3 = !empty($claimData['claim']['service_lines'][2]['emergency']) ?
        $claimData['claim']['service_lines'][2]['emergency'] : '';
    $cpt_hcpcs3 = !empty($claimData['claim']['service_lines'][2]['procedure_code']) ?
        $claimData['claim']['service_lines'][2]['procedure_code'] : '';
    $modifier3_1 = !empty($claimData['claim']['service_lines'][2]['procedure_modifiers'][0]) ?
        $claimData['claim']['service_lines'][2]['procedure_modifiers'][0] : '';
    $modifier3_2 = !empty($claimData['claim']['service_lines'][2]['procedure_modifiers'][1]) ?
        $claimData['claim']['service_lines'][2]['procedure_modifiers'][1] : '';
    $modifier3_3 = !empty($claimData['claim']['service_lines'][2]['procedure_modifiers'][2]) ?
        $claimData['claim']['service_lines'][2]['procedure_modifiers'][2] : '';
    $modifier3_4 = !empty($claimData['claim']['service_lines'][2]['procedure_modifiers'][3]) ?
        $claimData['claim']['service_lines'][2]['procedure_modifiers'][3] : '';
    $diagnosis_pointer3 = !empty($claimData['claim']['service_lines'][2]['diagnosis_code_pointers']) ?
        $claimData['claim']['service_lines'][2]['diagnosis_code_pointers'] : '';
    $s_charges3_1 = !empty($claimData['claim']['service_lines'][2]['charge_amount']) ?
        $claimData['claim']['service_lines'][2]['charge_amount'] : '';
    $days_or_units3 = !empty($claimData['claim']['service_lines'][2]['units']) ?
        $claimData['claim']['service_lines'][2]['units'] : '';
    $id_qua3 = !empty($claimData['claim']['service_lines'][2]['rendering_provider']['secondary_id_type']) ?
        $claimData['claim']['service_lines'][2]['rendering_provider']['secondary_id_type'] : '';
    $rendering_provider_id3 = !empty($claimData['claim']['service_lines'][2]['ledger_id']) ?
        $claimData['claim']['service_lines'][2]['ledger_id'] : '';
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_3 = !empty($claimData['claim']['service_lines'][2]['rendering_provider']['entity']) ?
        $claimData['claim']['service_lines'][2]['rendering_provider']['entity'] : '';
    $rendering_provider_first_name_3 =
        !empty($claimData['claim']['service_lines'][2]['rendering_provider']['first_name']) ?
            $claimData['claim']['service_lines'][2]['rendering_provider']['first_name'] : '';
    $rendering_provider_last_name_3 =
        !empty($claimData['claim']['service_lines'][2]['rendering_provider']['last_name']) ?
            $claimData['claim']['service_lines'][2]['rendering_provider']['last_name'] : '';
    $rendering_provider_org_3 =
        !empty($claimData['claim']['service_lines'][2]['rendering_provider']['organization_name']) ?
            $claimData['claim']['service_lines'][2]['rendering_provider']['organization_name'] : '';
    $rendering_provider_npi_3 = !empty($claimData['claim']['service_lines'][2]['rendering_provider']['npi']) ?
        $claimData['claim']['service_lines'][2]['rendering_provider']['npi'] : '';

    $service_date4_from = !empty($claimData['claim']['service_lines'][3]['service_date_from']) ?
        $claimData['claim']['service_lines'][3]['service_date_from'] : '';
    $service_date4_to = !empty($claimData['claim']['service_lines'][3]['service_date_to']) ?
        $claimData['claim']['service_lines'][3]['service_date_to'] : '';
    $place_of_service4 = !empty($claimData['claim']['service_lines'][3]['place_of_service']) ?
        $claimData['claim']['service_lines'][3]['place_of_service'] : '';
    $emg4 = !empty($claimData['claim']['service_lines'][3]['emergency']) ?
        $claimData['claim']['service_lines'][3]['emergency'] : '';
    $cpt_hcpcs4 = !empty($claimData['claim']['service_lines'][3]['procedure_code']) ?
        $claimData['claim']['service_lines'][3]['procedure_code'] : '';
    $modifier4_1 = !empty($claimData['claim']['service_lines'][3]['procedure_modifiers'][0]) ?
        $claimData['claim']['service_lines'][3]['procedure_modifiers'][0] : '';
    $modifier4_2 = !empty($claimData['claim']['service_lines'][3]['procedure_modifiers'][1]) ?
        $claimData['claim']['service_lines'][3]['procedure_modifiers'][1] : '';
    $modifier4_3 = !empty($claimData['claim']['service_lines'][3]['procedure_modifiers'][2]) ?
        $claimData['claim']['service_lines'][3]['procedure_modifiers'][2] : '';
    $modifier4_4 = !empty($claimData['claim']['service_lines'][3]['procedure_modifiers'][3]) ?
        $claimData['claim']['service_lines'][3]['procedure_modifiers'][3] : '';
    $diagnosis_pointer4 = !empty($claimData['claim']['service_lines'][3]['diagnosis_code_pointers']) ?
        $claimData['claim']['service_lines'][3]['diagnosis_code_pointers'] : '';
    $s_charges4_1 = !empty($claimData['claim']['service_lines'][3]['charge_amount']) ?
        $claimData['claim']['service_lines'][3]['charge_amount'] : '';
    $days_or_units4 = !empty($claimData['claim']['service_lines'][3]['units']) ?
        $claimData['claim']['service_lines'][3]['units'] : '';
    $id_qua4 = !empty($claimData['claim']['service_lines'][3]['rendering_provider']['secondary_id_type']) ?
        $claimData['claim']['service_lines'][3]['rendering_provider']['secondary_id_type'] : '';
    $rendering_provider_id4 = !empty($claimData['claim']['service_lines'][3]['ledger_id']) ?
        $claimData['claim']['service_lines'][3]['ledger_id'] : '';
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_4 = !empty($claimData['claim']['service_lines'][3]['rendering_provider']['entity']) ?
        $claimData['claim']['service_lines'][3]['rendering_provider']['entity'] : '';
    $rendering_provider_first_name_4 =
        !empty($claimData['claim']['service_lines'][3]['rendering_provider']['first_name']) ?
            $claimData['claim']['service_lines'][3]['rendering_provider']['first_name'] : '';
    $rendering_provider_last_name_4 =
        !empty($claimData['claim']['service_lines'][3]['rendering_provider']['last_name']) ?
            $claimData['claim']['service_lines'][3]['rendering_provider']['last_name'] : '';
    $rendering_provider_org_4 =
        !empty($claimData['claim']['service_lines'][3]['rendering_provider']['organization_name']) ?
            $claimData['claim']['service_lines'][3]['rendering_provider']['organization_name'] : '';
    $rendering_provider_npi_4 = !empty($claimData['claim']['service_lines'][3]['rendering_provider']['npi']) ?
        $claimData['claim']['service_lines'][3]['rendering_provider']['npi'] : '';

    $service_date5_from = !empty($claimData['claim']['service_lines'][4]['service_date_from']) ?
        $claimData['claim']['service_lines'][4]['service_date_from'] : '';
    $service_date5_to = !empty($claimData['claim']['service_lines'][4]['service_date_to']) ?
        $claimData['claim']['service_lines'][4]['service_date_to'] : '';
    $place_of_service5 = !empty($claimData['claim']['service_lines'][4]['place_of_service']) ?
        $claimData['claim']['service_lines'][4]['place_of_service'] : '';
    $emg5 = !empty($claimData['claim']['service_lines'][4]['emergency']) ?
        $claimData['claim']['service_lines'][4]['emergency'] : '';
    $cpt_hcpcs5 = !empty($claimData['claim']['service_lines'][4]['procedure_code']) ?
        $claimData['claim']['service_lines'][4]['procedure_code'] : '';
    $modifier5_1 = !empty($claimData['claim']['service_lines'][4]['procedure_modifiers'][0]) ?
        $claimData['claim']['service_lines'][4]['procedure_modifiers'][0] : '';
    $modifier5_2 = !empty($claimData['claim']['service_lines'][4]['procedure_modifiers'][1]) ?
        $claimData['claim']['service_lines'][4]['procedure_modifiers'][1] : '';
    $modifier5_3 = !empty($claimData['claim']['service_lines'][4]['procedure_modifiers'][2]) ?
        $claimData['claim']['service_lines'][4]['procedure_modifiers'][2] : '';
    $modifier5_4 = !empty($claimData['claim']['service_lines'][4]['procedure_modifiers'][3]) ?
        $claimData['claim']['service_lines'][4]['procedure_modifiers'][3] : '';
    $diagnosis_pointer5 = !empty($claimData['claim']['service_lines'][4]['diagnosis_code_pointers']) ?
        $claimData['claim']['service_lines'][4]['diagnosis_code_pointers'] : '';
    $s_charges5_1 = !empty($claimData['claim']['service_lines'][4]['charge_amount']) ?
        $claimData['claim']['service_lines'][4]['charge_amount'] : '';
    $days_or_units5 = !empty($claimData['claim']['service_lines'][4]['units']) ?
        $claimData['claim']['service_lines'][4]['units'] : '';
    $id_qua5 = !empty($claimData['claim']['service_lines'][4]['rendering_provider']['secondary_id_type']) ?
        $claimData['claim']['service_lines'][4]['rendering_provider']['secondary_id_type'] : '';
    $rendering_provider_id5 = !empty($claimData['claim']['service_lines'][4]['ledger_id']) ?
        $claimData['claim']['service_lines'][4]['ledger_id'] : '';
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_5 = !empty($claimData['claim']['service_lines'][4]['rendering_provider']['entity']) ?
        $claimData['claim']['service_lines'][4]['rendering_provider']['entity'] : '';
    $rendering_provider_first_name_5 =
        !empty($claimData['claim']['service_lines'][4]['rendering_provider']['first_name']) ?
            $claimData['claim']['service_lines'][4]['rendering_provider']['first_name'] : '';
    $rendering_provider_last_name_5 =
        !empty($claimData['claim']['service_lines'][4]['rendering_provider']['last_name']) ?
            $claimData['claim']['service_lines'][4]['rendering_provider']['last_name'] : '';
    $rendering_provider_org_5 =
        !empty($claimData['claim']['service_lines'][4]['rendering_provider']['organization_name']) ?
            $claimData['claim']['service_lines'][4]['rendering_provider']['organization_name'] : '';
    $rendering_provider_npi_5 = !empty($claimData['claim']['service_lines'][4]['rendering_provider']['npi']) ?
        $claimData['claim']['service_lines'][4]['rendering_provider']['npi'] : '';

    $service_date6_from = !empty($claimData['claim']['service_lines'][5]['service_date_from']) ?
        $claimData['claim']['service_lines'][5]['service_date_from'] : '';
    $service_date6_to = !empty($claimData['claim']['service_lines'][5]['service_date_to']) ?
        $claimData['claim']['service_lines'][5]['service_date_to'] : '';
    $place_of_service6 = !empty($claimData['claim']['service_lines'][5]['place_of_service']) ?
        $claimData['claim']['service_lines'][5]['place_of_service'] : '';
    $emg6 = !empty($claimData['claim']['service_lines'][5]['emergency']) ?
        $claimData['claim']['service_lines'][5]['emergency'] : '';
    $cpt_hcpcs6 = !empty($claimData['claim']['service_lines'][5]['procedure_code']) ?
        $claimData['claim']['service_lines'][5]['procedure_code'] : '';
    $modifier6_1 = !empty($claimData['claim']['service_lines'][5]['procedure_modifiers'][0]) ?
        $claimData['claim']['service_lines'][5]['procedure_modifiers'][0] : '';
    $modifier6_2 = !empty($claimData['claim']['service_lines'][5]['procedure_modifiers'][1]) ?
        $claimData['claim']['service_lines'][5]['procedure_modifiers'][1] : '';
    $modifier6_3 = !empty($claimData['claim']['service_lines'][5]['procedure_modifiers'][2]) ?
        $claimData['claim']['service_lines'][5]['procedure_modifiers'][2] : '';
    $modifier6_4 = !empty($claimData['claim']['service_lines'][5]['procedure_modifiers'][3]) ?
        $claimData['claim']['service_lines'][5]['procedure_modifiers'][3] : '';
    $diagnosis_pointer6 = !empty($claimData['claim']['service_lines'][5]['diagnosis_code_pointers']) ?
        $claimData['claim']['service_lines'][5]['diagnosis_code_pointers'] : '';
    $s_charges6_1 = !empty($claimData['claim']['service_lines'][5]['charge_amount']) ?
        $claimData['claim']['service_lines'][5]['charge_amount'] : '';
    $days_or_units6 = !empty($claimData['claim']['service_lines'][5]['units']) ?
        $claimData['claim']['service_lines'][5]['units'] : '';
    $id_qua6 = !empty($claimData['claim']['service_lines'][5]['rendering_provider']['secondary_id_type']) ?
        $claimData['claim']['service_lines'][5]['rendering_provider']['secondary_id_type'] : '';
    $rendering_provider_id6 = !empty($claimData['claim']['service_lines'][5]['ledger_id']) ?
        $claimData['claim']['service_lines'][5]['ledger_id'] : '';
    // WHAT IS THE SECOND ID
    $rendering_provider_entity_6 = !empty($claimData['claim']['service_lines'][5]['rendering_provider']['entity']) ?
        $claimData['claim']['service_lines'][5]['rendering_provider']['entity'] : '';
    $rendering_provider_first_name_6 =
        !empty($claimData['claim']['service_lines'][5]['rendering_provider']['first_name']) ?
            $claimData['claim']['service_lines'][5]['rendering_provider']['first_name'] : '';
    $rendering_provider_last_name_6 =
        !empty($claimData['claim']['service_lines'][5]['rendering_provider']['last_name']) ?
            $claimData['claim']['service_lines'][5]['rendering_provider']['last_name'] : '';
    $rendering_provider_org_6 =
        !empty($claimData['claim']['service_lines'][5]['rendering_provider']['organization_name']) ?
            $claimData['claim']['service_lines'][5]['rendering_provider']['organization_name'] : '';
    $rendering_provider_npi_6 = !empty($claimData['claim']['service_lines'][5]['rendering_provider']['npi']) ?
        $claimData['claim']['service_lines'][5]['rendering_provider']['npi'] : '';

    $federal_tax_id_number = !empty($claimData['billing_provider']['tax_id']) ?
        $claimData['billing_provider']['tax_id'] : '';
    $ssn = !empty($claimData['billing_provider']['tax_id_type']) &&
        $claimData['billing_provider']['tax_id_type'] == "SY" ? 1 : '';
    $ein = !empty($claimData['billing_provider']['tax_id_type']) &&
        $claimData['billing_provider']['tax_id_type'] == "EI" ? 1 : '';
    $accept_assignment = !empty($claimData['claim']['accept_assignment_code']) ?
        $claimData['claim']['accept_assignment_code'] : '';
    $total_charge = !empty($claimData['claim']['total_charge']) ? $claimData['claim']['total_charge'] : '0.00';
    $amount_paid =
        !empty($claimData['claim']['patient_amount_paid']) ? $claimData['claim']['patient_amount_paid'] : NULL;
    $signature_physician = !empty($claimData['claim']['provider_signature_on_file']) ?
        $claimData['claim']['provider_signature_on_file'] : '';
    $physician_signed_date = (($claimData['claim']['signature_date'] != date('m/d/Y')) ?
        $claimData['claim']['signature_date'] : '');
    $service_facility_info_name = !empty($claimData['service_facility']['name']) ?
        $claimData['service_facility']['name'] : '';
    $service_facility_info_address = !empty($claimData['service_facility']['address']['street_line_1']) ?
        $claimData['service_facility']['address']['street_line_1'] : '';
    $service_facility_info_city = trim(
        (!empty($claimData['service_facility']['address']['city']) ?
            $claimData['service_facility']['address']['city'] . ' ' : '') .
        (!empty($claimData['service_facility']['address']['state']) ?
            $claimData['service_facility']['address']['state'] . ' ' : '') .
        (!empty($claimData['service_facility']['address']['zip']) ?
            $claimData['service_facility']['address']['zip'] : '')
    );

    //SPLIT APART?
    $service_info_a = !empty($claimData['service_facility']['npi']) ? $claimData['service_facility']['npi'] : '';
    list($billing_provider_phone_code, $billing_provider_phone) =
        parsePhoneNumber($claimData['billing_provider']['phone_number']);
    $billing_provider_name = !empty($claimData['billing_provider']['organization_name']) ?
        $claimData['billing_provider']['organization_name'] : '';
    $billing_provider_address = !empty($claimData['billing_provider']['address']['street_line_1']) ?
        $claimData['billing_provider']['address']['street_line_1'] : '';
    $billing_provider_city = trim(
        (!empty($claimData['billing_provider']['address']['city']) ?
            $claimData['billing_provider']['address']['city'] . ' ' : '') .
        (!empty($claimData['billing_provider']['address']['state']) ?
            $claimData['billing_provider']['address']['state'] . ' ' : '') .
        (!empty($claimData['billing_provider']['address']['zip']) ?
            $claimData['billing_provider']['address']['zip'] : '')
    );
    $billing_provider_a = !empty($claimData['billing_provider']['npi']) ? $claimData['billing_provider']['npi'] : '';
    $billing_provider_taxonomy_code = $claimData['billing_provider']['taxonomy_code'];
    $reject_reason = !empty($claimData['reject_reason']) ? $claimData['reject_reason'] : '';
    $p_m_eligible_payer_id = !empty($claimData['payer']['id']) ? $claimData['payer']['id'] : '';
    $p_m_eligible_payer_name = !empty($claimData['payer']['name']) ? $claimData['payer']['name'] : '';

    /**
     * Ensure that place of service and transaction code are linked to docid
     */
    $placesOfService = $db->getResults('SELECT place_service, description
        FROM dental_place_service
        WHERE status = 1');

    $transactionCodes = $db->getResults("SELECT
            code.transaction_code,
            code.description,
            CONCAT(code.transaction_code, ' - ', code.description) AS long_description
        FROM dental_transaction_code code
            JOIN dental_insurance claim ON claim.docid = code.docid
        WHERE claim.insuranceid = '$claimId'");

    $placesOfService = $placesOfService ? array_pluck($placesOfService, 'place_service') : [];

    $codes = array_pluck($transactionCodes, 'transaction_code');
    $descriptions = array_pluck($transactionCodes, 'description');
    $longDescriptions = array_pluck($transactionCodes, 'long_description');

    for ($n=1; $n<=6; $n++) {
        $localVariable = "emg$n";
        ${$localVariable} = isOptionSelected(${$localVariable});

        $localVariable = "place_of_service$n";
        ${$localVariable} = in_array(${$localVariable}, $placesOfService) ? ${$localVariable} : null;

        $localVariable = "cpt_hcpcs$n";
        $codeIndex = array_filter([
            array_search(${$localVariable}, $codes),
            array_search(${$localVariable}, $descriptions),
            array_search(${$localVariable}, $longDescriptions),
        ], function ($each) { return $each !== false; });

        $codeIndex = count($codeIndex) ? array_shift($codeIndex) : false;
        ${$localVariable} = $codeIndex !== false ? $codes[$codeIndex] : null;

        $localVariable = "s_charges{$n}_1";
        ${$localVariable} = preg_replace('/[^\d\.]+/', '', ${$localVariable});

        $localVariable = "diagnosis_pointer{$n}";

        if (is_array(${$localVariable})) {
            ${$localVariable} = join(',', ${$localVariable});
        }
    }

    $total_charge = number_format(preg_replace('/[^\d\.]+/', '', $total_charge), 2, '.', '');
    $amount_paid = is_null($amount_paid) ? NULL : number_format(preg_replace('/[^\d\.]+/', '', $amount_paid), 2, '.', '');

    $mailedDate = date('Y-m-d H:i:s');

    $ed_sql = "UPDATE dental_insurance SET
            payer_id = '".$db->escape($payer['id'])."',
            payer_name = '".$db->escape($payer['name'])."',
            payer_address = '".$db->escape($payer['address']['street_line_1'])."',
            payer_city = '".$db->escape($payer['address']['city'])."',
            payer_state = '".$db->escape($payer['address']['state'])."',
            payer_zip = '".$db->escape($payer['address']['zip'])."',
            patient_lastname = '" . $db->escape($patient_lastname) . "',
            patient_firstname = '" . $db->escape($patient_firstname) . "',
            patient_middle = '" . $db->escape($patient_middle) . "',
            patient_dob = '" . $db->escape($patient_dob) . "',
            patient_sex = '" . $db->escape($patient_sex) . "',
            patient_address = '" . $db->escape($patient_address) . "',
            patient_state = '" . $db->escape($patient_state) . "',
            patient_status = '" . $db->escape(!empty($patient_status_arr) ? $patient_status_arr : '') . "',
            patient_city = '" . $db->escape($patient_city) . "',
            patient_zip = '" . $db->escape($patient_zip) . "',
            patient_phone_code = '" . $db->escape(!empty($patient_phone_code) ? $patient_phone_code : '') . "',
            patient_phone = '" . $db->escape($patient_phone) . "',
            patient_relation_insured = '" . $db->escape($patient_relation_insured) . "',
            insured_id_number = '" . $db->escape($insured_id_number) . "',
            insured_firstname = '" . $db->escape($insured_firstname) . "',
            insured_lastname = '" . $db->escape($insured_lastname) . "',
            insured_middle = '" . $db->escape($insured_middle) . "',
            insured_address = '" . $db->escape($insured_address) . "',
            insured_city = '" . $db->escape($insured_city) . "',
            insured_state = '" . $db->escape($insured_state) . "',
            insured_zip = '" . $db->escape($insured_zip) . "',
            insured_phone_code = '" . $db->escape(!empty($insured_phone_code) ? $insured_phone_code : '') . "',
            insured_phone = '" . $db->escape($insured_phone) . "',
            other_insured_firstname = '" . $db->escape($other_insured_firstname) . "',
            other_insured_lastname = '" . $db->escape($other_insured_lastname) . "',
            other_insured_middle = '" . $db->escape($other_insured_middle) . "',
            insured_policy_group_feca = '" . $db->escape($insured_policy_group_feca) . "',
            other_insured_policy_group_feca = '" . $db->escape($other_insured_policy_group_feca) . "',
            insured_dob = '" . $db->escape($insured_dob) . "',
            insured_sex = '" . $db->escape($insured_sex) . "',
            other_insured_dob = '" . $db->escape(!empty($other_insured_dob) ? $other_insured_dob : '') . "',
            other_insured_sex = '" . $db->escape(!empty($other_insured_sex) ? $other_insured_sex : '') . "',
            insured_employer_school_name = '" . $db->escape(!empty($insured_employer_school_name) ?
                $insured_employer_school_name : '') . "',
            other_insured_employer_school_name = '" . $db->escape(!empty($other_insured_employer_school_name) ?
                $other_insured_employer_school_name : '') . "',
            insured_insurance_plan = '" . $db->escape($insured_insurance_plan) . "',
            other_insured_insurance_plan = '" . $db->escape($other_insured_insurance_plan) . "',
            employment = '" . $db->escape($employment) . "',
            auto_accident = '" . $db->escape($auto_accident) . "',
            auto_accident_place = '" . $db->escape($auto_accident_place) . "',
            other_accident = '" . $db->escape($other_accident) . "',
            reserved_local_use = '" . $db->escape(!empty($reserved_local_use) ? $reserved_local_use : '') . "',
            another_plan = '" . $db->escape($another_plan) . "',
            patient_signature = '" . $db->escape($patient_signature) . "',
            patient_signed_date = '" . $db->escape(!empty($patient_signed_date) ? $patient_signed_date : '') . "',
            insured_signature = '" . $db->escape($insured_signature) . "',
            date_current = '" . $db->escape($date_current) . "',
            date_same_illness = '" . $db->escape(!empty($date_same_illness) ? $date_same_illness : '') . "',
            unable_date_from = '" . $db->escape($unable_date_from) . "',
            unable_date_to = '" . $db->escape($unable_date_to) . "',
            name_referring_provider_qualifier = '" . $db->escape($name_referring_provider_qualifier) . "',
            referring_provider = '" . $db->escape(!empty($referring_provider) ? $referring_provider : '') . "',
            field_17a_dd = '" . $db->escape($field_17a_dd) . "',
            field_17a = '" . $db->escape($field_17a) . "',
            field_17b = '" . $db->escape($field_17b) . "',
            hospitalization_date_from = '" . $db->escape($hospitalization_date_from) . "',
            hospitalization_date_to = '" . $db->escape($hospitalization_date_to) . "',
            reserved_local_use1 = '" . $db->escape(!empty($reserved_local_use1) ? $reserved_local_use1 : '') . "',
            claim_info_code = '".$db->escape($claim_info_code)."',
            outside_lab = '" . $db->escape($outside_lab) . "',
            s_charges = '" . $db->escape($s_charges) . "',
            diagnosis_1 = '" . $db->escape(!empty($diagnosis_1) ? $diagnosis_1 : '') . "',
            diagnosis_2 = '" . $db->escape(!empty($diagnosis_2) ? $diagnosis_2 : '') . "',
            diagnosis_3 = '" . $db->escape(!empty($diagnosis_3) ? $diagnosis_3 : '') . "',
            diagnosis_4 = '" . $db->escape(!empty($diagnosis_4) ? $diagnosis_4 : '') . "',
            icd_ind = '" . $db->escape($icd_indicator) . "',
            diagnosis_a = '" . $db->escape($diagnosis_a) . "',
            diagnosis_b = '" . $db->escape($diagnosis_b) . "',
            diagnosis_c = '" . $db->escape($diagnosis_c) . "',
            diagnosis_d = '" . $db->escape($diagnosis_d) . "',
            diagnosis_e = '" . $db->escape($diagnosis_e) . "',
            diagnosis_f = '" . $db->escape($diagnosis_f) . "',
            diagnosis_g = '" . $db->escape($diagnosis_g) . "',
            diagnosis_h = '" . $db->escape($diagnosis_h) . "',
            diagnosis_i = '" . $db->escape($diagnosis_i) . "',
            diagnosis_j = '" . $db->escape($diagnosis_j) . "',
            diagnosis_k = '" . $db->escape($diagnosis_k) . "',
            diagnosis_l = '" . $db->escape($diagnosis_l) . "',
            current_qual = '" . $db->escape($current_qual) . "',
            medicaid_resubmission_code = '" . $db->escape(!empty($medicaid_resubmission_code) ?
                $medicaid_resubmission_code : '') . "',
            resubmission_code_fill = '" . $db->escape($resubmission_code_fill) . "',
            original_ref_no = '" . $db->escape($original_ref_no) . "',
            prior_authorization_number = '" . $db->escape($prior_authorization_number) . "',
            service_date1_from = '" . $db->escape($service_date1_from) . "',
            service_date1_to = '" . $db->escape($service_date1_to) . "',
            place_of_service1 = " . (is_null($place_of_service1) ? 'NULL' : "'" . $db->escape($place_of_service1) . "'") . ",
            emg1 = '" . $db->escape($emg1) . "',
            cpt_hcpcs1 = " . (is_null($cpt_hcpcs1) ? 'NULL' : "'" . $db->escape($cpt_hcpcs1) . "'") . ",
            modifier1_1 = '" . $db->escape($modifier1_1) . "',
            modifier1_2 = '" . $db->escape($modifier1_2) . "',
            modifier1_3 = '" . $db->escape($modifier1_3) . "',
            modifier1_4 = '" . $db->escape($modifier1_4) . "',
            diagnosis_pointer1 = '" . $db->escape($diagnosis_pointer1) . "',
            s_charges1_1 = '" . $db->escape($s_charges1_1) . "',
            s_charges1_2 = '" . $db->escape(!empty($s_charges1_2) ? $s_charges1_2 : '') . "',
            days_or_units1 = '" . $db->escape($days_or_units1) . "',
            epsdt_family_plan1 = '" . $db->escape(!empty($epsdt_family_plan1) ? $epsdt_family_plan1 : '') . "',
            id_qua1 = '" . $db->escape($id_qua1) . "',
            rendering_provider_id1 = '" . $db->escape($rendering_provider_id1) . "',
            service_date2_from = '" . $db->escape($service_date2_from) . "',
            service_date2_to = '" . $db->escape($service_date2_to) . "',
            place_of_service2 = " . (is_null($place_of_service2) ? 'NULL' : "'" . $db->escape($place_of_service2) . "'") . ",
            emg2 = '" . $db->escape($emg2) . "',
            cpt_hcpcs2 = " . (is_null($cpt_hcpcs2) ? 'NULL' : "'" . $db->escape($cpt_hcpcs2) . "'") . ",
            modifier2_1 = '" . $db->escape($modifier2_1) . "',
            modifier2_2 = '" . $db->escape($modifier2_2) . "',
            modifier2_3 = '" . $db->escape($modifier2_3) . "',
            modifier2_4 = '" . $db->escape($modifier2_4) . "',
            diagnosis_pointer2 = '" . $db->escape($diagnosis_pointer2) . "',
            s_charges2_1 = '" . $db->escape($s_charges2_1) . "',
            s_charges2_2 = '" . $db->escape(!empty($s_charges2_2) ? $s_charges2_2 : '') . "',
            days_or_units2 = '" . $db->escape($days_or_units2) . "',
            epsdt_family_plan2 = '" . $db->escape(!empty($epsdt_family_plan2) ? $epsdt_family_plan2 : '') . "',
            id_qua2 = '" . $db->escape($id_qua2) . "',
            rendering_provider_id2 = '" . $db->escape($rendering_provider_id2) . "',
            service_date3_from = '" . $db->escape($service_date3_from) . "',
            service_date3_to = '" . $db->escape($service_date3_to) . "',
            place_of_service3 = " . (is_null($place_of_service3) ? 'NULL' : "'" . $db->escape($place_of_service3) . "'") . ",
            emg3 = '" . $db->escape($emg3) . "',
            cpt_hcpcs3 = " . (is_null($cpt_hcpcs3) ? 'NULL' : "'" . $db->escape($cpt_hcpcs3) . "'") . ",
            modifier3_1 = '" . $db->escape($modifier3_1) . "',
            modifier3_2 = '" . $db->escape($modifier3_2) . "',
            modifier3_3 = '" . $db->escape($modifier3_3) . "',
            modifier3_4 = '" . $db->escape($modifier3_4) . "',
            diagnosis_pointer3 = '" . $db->escape($diagnosis_pointer3) . "',
            s_charges3_1 = '" . $db->escape($s_charges3_1) . "',
            s_charges3_2 = '" . $db->escape(!empty($s_charges3_2) ? $s_charges3_2 : '') . "',
            days_or_units3 = '" . $db->escape($days_or_units3) . "',
            epsdt_family_plan3 = '" . $db->escape(!empty($epsdt_family_plan3) ? $epsdt_family_plan3 : '') . "',
            id_qua3 = '" . $db->escape($id_qua3) . "',
            rendering_provider_id3 = '" . $db->escape($rendering_provider_id3) . "',
            service_date4_from = '" . $db->escape($service_date4_from) . "',
            service_date4_to = '" . $db->escape($service_date4_to) . "',
            place_of_service4 = " . (is_null($place_of_service4) ? 'NULL' : "'" . $db->escape($place_of_service4) . "'") . ",
            emg4 = '" . $db->escape($emg4) . "',
            cpt_hcpcs4 = " . (is_null($cpt_hcpcs4) ? 'NULL' : "'" . $db->escape($cpt_hcpcs4) . "'") . ",
            modifier4_1 = '" . $db->escape($modifier4_1) . "',
            modifier4_2 = '" . $db->escape($modifier4_2) . "',
            modifier4_3 = '" . $db->escape($modifier4_3) . "',
            modifier4_4 = '" . $db->escape($modifier4_4) . "',
            diagnosis_pointer4 = '" . $db->escape($diagnosis_pointer4) . "',
            ";
    $ed_sql .= "
            s_charges4_1 = '" . $db->escape($s_charges4_1) . "',
            s_charges4_2 = '" . $db->escape(!empty($s_charges4_2) ? $s_charges4_2 : '') . "',
            days_or_units4 = '" . $db->escape($days_or_units4) . "',
            epsdt_family_plan4 = '" . $db->escape(!empty($epsdt_family_plan4) ? $epsdt_family_plan4 : '') . "',
            id_qua4 = '" . $db->escape($id_qua4) . "',
            rendering_provider_id4 = '" . $db->escape($rendering_provider_id4) . "',
            service_date5_from = '" . $db->escape($service_date5_from) . "',
            service_date5_to = '" . $db->escape($service_date5_to) . "',
            place_of_service5 = " . (is_null($place_of_service5) ? 'NULL' : "'" . $db->escape($place_of_service5) . "'") . ",
            emg5 = '" . $db->escape($emg5) . "',
            cpt_hcpcs5 = " . (is_null($cpt_hcpcs5) ? 'NULL' : "'" . $db->escape($cpt_hcpcs5) . "'") . ",
            modifier5_1 = '" . $db->escape($modifier5_1) . "',
            modifier5_2 = '" . $db->escape($modifier5_2) . "',
            modifier5_3 = '" . $db->escape($modifier5_3) . "',
            modifier5_4 = '" . $db->escape($modifier5_4) . "',
            diagnosis_pointer5 = '" . $db->escape($diagnosis_pointer5) . "',
            s_charges5_1 = '" . $db->escape($s_charges5_1) . "',
            s_charges5_2 = '" . $db->escape(!empty($s_charges5_2) ? $s_charges5_2 : '') . "',
            days_or_units5 = '" . $db->escape($days_or_units5) . "',
            epsdt_family_plan5 = '" . $db->escape(!empty($epsdt_family_plan5) ? $epsdt_family_plan5 : '') . "',
            id_qua5 = '" . $db->escape($id_qua5) . "',
            rendering_provider_id5 = '" . $db->escape($rendering_provider_id5) . "',
            service_date6_from = '" . $db->escape($service_date6_from) . "',
            service_date6_to = '" . $db->escape($service_date6_to) . "',
            place_of_service6 = " . (is_null($place_of_service6) ? 'NULL' : "'" . $db->escape($place_of_service6) . "'") . ",
            emg6 = '" . $db->escape($emg6) . "',
            cpt_hcpcs6 = " . (is_null($cpt_hcpcs6) ? 'NULL' : "'" . $db->escape($cpt_hcpcs6) . "'") . ",
            modifier6_1 = '" . $db->escape($modifier6_1) . "',
            modifier6_2 = '" . $db->escape($modifier6_2) . "',
            modifier6_3 = '" . $db->escape($modifier6_3) . "',
            modifier6_4 = '" . $db->escape($modifier6_4) . "',
            diagnosis_pointer6 = '" . $db->escape($diagnosis_pointer6) . "',
            s_charges6_1 = '" . $db->escape($s_charges6_1) . "',
            s_charges6_2 = '" . $db->escape(!empty($s_charges6_2) ? $s_charges6_2 : '') . "',
            days_or_units6 = '" . $db->escape($days_or_units6) . "',
            epsdt_family_plan6 = '" . $db->escape(!empty($epsdt_family_plan6) ? $epsdt_family_plan6 : '') . "',
            id_qua6 = '" . $db->escape($id_qua6) . "',
            rendering_provider_id6 = '" . $db->escape($rendering_provider_id6) . "',
            federal_tax_id_number = '" . $db->escape($federal_tax_id_number) . "',
            ssn = '" . $db->escape($ssn) . "',
            ein = '" . $db->escape($ein) . "',
            patient_account_no = '" . $db->escape(!empty($patient_account_no) ? $patient_account_no : '') . "',
            accept_assignment = '" . $db->escape($accept_assignment) . "',
            total_charge = '" . $db->escape($total_charge) . "', " .
            (
                isset($amount_paid) && !is_null($amount_paid) ?
                    "amount_paid = '" . $db->escape($amount_paid) . "', " : ''
            ) . "
            balance_due = '" . $db->escape(!empty($balance_due) ? $balance_due : '') . "',
            claim_codes = '" . $db->escape($claim_codes) . "',
            signature_physician = '" . $db->escape($signature_physician) . "',
            physician_signed_date = '" . $db->escape(!empty($physician_signed_date) ?
                $physician_signed_date : '') . "',
            service_facility_info_name = '" . $db->escape($service_facility_info_name) . "',
            service_facility_info_address = '" . $db->escape($service_facility_info_address) . "',
            service_facility_info_city = '" . $db->escape($service_facility_info_city) . "',
            service_info_a = '" . $db->escape($service_info_a) . "',
            service_info_dd = '" . $db->escape(!empty($service_info_dd) ? $service_info_dd : '') . "',
            service_info_b_other = '" . $db->escape(!empty($service_info_b_other) ? $service_info_b_other : '') . "',
            billing_provider_phone_code = '" . $db->escape(!empty($billing_provider_phone_code) ?
                $billing_provider_phone_code : '') . "',
            billing_provider_phone = '" . $db->escape($billing_provider_phone) . "',
            billing_provider_name = '" . $db->escape($billing_provider_name) . "',
            billing_provider_address = '" . $db->escape($billing_provider_address) . "',
            billing_provider_city = '" . $db->escape($billing_provider_city) . "',
            billing_provider_a = '" . $db->escape($billing_provider_a) . "',
            billing_provider_dd = '" . $db->escape(!empty($billing_provider_dd) ? $billing_provider_dd : '') . "',
            billing_provider_b_other = '" . $db->escape(!empty($billing_provider_b_other) ?
                $billing_provider_b_other : '') . "',
            billing_provider_taxonomy_code = '".$db->escape($billing_provider_taxonomy_code)."',
            p_m_eligible_payer_id = '" . $p_m_eligible_payer_id . "',
            p_m_eligible_payer_name = '" . $db->escape($p_m_eligible_payer_name) . "',
            rendering_provider_entity_1  = '" . $db->escape($rendering_provider_entity_1) . "',
            rendering_provider_first_name_1  = '" . $db->escape($rendering_provider_first_name_1) . "',
            rendering_provider_last_name_1  = '" . $db->escape($rendering_provider_last_name_1) . "',
            rendering_provider_org_1  = '" . $db->escape($rendering_provider_org_1) . "',
            rendering_provider_npi_1  = '" . $db->escape($rendering_provider_npi_1) . "',
            rendering_provider_entity_2  = '" . $db->escape($rendering_provider_entity_2) . "',
            rendering_provider_first_name_2  = '" . $db->escape($rendering_provider_first_name_2) . "',
            rendering_provider_last_name_2  = '" . $db->escape($rendering_provider_last_name_2) . "',
            rendering_provider_org_2  = '" . $db->escape($rendering_provider_org_2) . "',
            rendering_provider_npi_2  = '" . $db->escape($rendering_provider_npi_2) . "',
            rendering_provider_entity_3  = '" . $db->escape($rendering_provider_entity_3) . "',
            rendering_provider_first_name_3  = '" . $db->escape($rendering_provider_first_name_3) . "',
            rendering_provider_last_name_3  = '" . $db->escape($rendering_provider_last_name_3) . "',
            rendering_provider_org_3  = '" . $db->escape($rendering_provider_org_3) . "',
            rendering_provider_npi_3  = '" . $db->escape($rendering_provider_npi_3) . "',
            rendering_provider_entity_4  = '" . $db->escape($rendering_provider_entity_4) . "',
            rendering_provider_first_name_4  = '" . $db->escape($rendering_provider_first_name_4) . "',
            rendering_provider_last_name_4  = '" . $db->escape($rendering_provider_last_name_4) . "',
            rendering_provider_org_4  = '" . $db->escape($rendering_provider_org_4) . "',
            rendering_provider_npi_4  = '" . $db->escape($rendering_provider_npi_4) . "',
            rendering_provider_entity_5  = '" . $db->escape($rendering_provider_entity_5) . "',
            rendering_provider_first_name_5  = '" . $db->escape($rendering_provider_first_name_5) . "',
            rendering_provider_last_name_5  = '" . $db->escape($rendering_provider_last_name_5) . "',
            rendering_provider_org_5  = '" . $db->escape($rendering_provider_org_5) . "',
            rendering_provider_npi_5  = '" . $db->escape($rendering_provider_npi_5) . "',
            rendering_provider_entity_6  = '" . $db->escape($rendering_provider_entity_6) . "',
            rendering_provider_first_name_6  = '" . $db->escape($rendering_provider_first_name_6) . "',
            rendering_provider_last_name_6  = '" . $db->escape($rendering_provider_last_name_6) . "',
            rendering_provider_org_6  = '" . $db->escape($rendering_provider_org_6) . "',
            rendering_provider_npi_6  = '" . $db->escape($rendering_provider_npi_6) . "',
            responsibility_sequence = '" . $db->escape($responsibility_sequence) . "',
            other_insured_insurance_type = '" . $db->escape($other_insured_insurance_type) . "',

            status = '$status',
            mailed_date = '$mailedDate',
            " . ($needsBackOfficeMarkerUpdate ? "p_m_dss_file = '$filedByBackOfficeMarker'," : '') . "
            reject_reason = '" . $db->escape($reject_reason) . "'
        WHERE insuranceid = '$claimId'";

    $db->query($ed_sql);

    // update the ledger trxns passed in with the form
    $transactionStatus = ClaimFormData::isStatus('sent', $status) ? DSS_TRXN_SENT : DSS_TRXN_PROCESSING;
    updateLedgerTransactions($claimId, $transactionStatus, $claimData['claim']['service_lines']);

    // Determine if this payer id is valid
    $db->query("UPDATE dental_patients SET
            p_m_eligible_payer_id = '".$db->escape($p_m_eligible_payer_id)."',
            p_m_eligible_payer_name = '".$db->escape($p_m_eligible_payer_name)."'
        WHERE patientid = '$patientId'");

    // Send request to Eligible
    $url = 'https://gds.eligibleapi.com/v1.5/claims.json';
    $apiKey = DSS_DEFAULT_ELIGIBLE_API_KEY;

    $apiKeyResult = $db->getRow("SELECT eligible_api_key
        FROM dental_user_company
            LEFT JOIN companies ON dental_user_company.companyid = companies.id
        WHERE dental_user_company.userid = '$docId'");

    if (isset($apiKeyResult['eligible_api_key']) && trim($apiKeyResult['eligible_api_key']) != '') {
        $apiKey = $apiKeyResult['eligible_api_key'];
    }

    $eligibleTest = $db->getRow("SELECT eligible_test
        FROM dental_users
            JOIN dental_insurance ON dental_insurance.docid = dental_users.userid
        WHERE insuranceid = '$claimId'");

    // Eligible API requires ALL the fields from the form
    $eligibleData = $claimData;

    // If the value is set, it gets taken into account. A tertiary operator won't work here
    if ($eligibleTest['eligible_test']) {
        $eligibleData['test'] = 'true';
    }

    $eligibleData['api_key'] = $apiKey; //Setting your api key

    // If the diagnosis codes array is not zero based, the array will be encoded as a JSON object
    if (isset($eligibleData['claim'])) {
        if (isset($eligibleData['claim']['diagnosis_codes'])) {
            if (is_array($eligibleData['claim']['diagnosis_codes'])) {
                $eligibleData['claim']['diagnosis_codes'] = array_values($eligibleData['claim']['diagnosis_codes']);
            } else {
                $eligibleData['claim']['diagnosis_codes'] = [];
            }
        }

        if (isset($eligibleData['claim']['service_lines']) && is_array($eligibleData['claim']['service_lines'])) {
            array_walk($eligibleData['claim']['service_lines'], function (&$each) {
                $each['diagnosis_code_pointers'] = array_values($each['diagnosis_code_pointers']);
            });
        }
    }

    // Remove extra fiels or Eligible API will fail
    unset($eligibleData['code']);
    unset($eligibleData['eligibleToken']);

    // We added extra variables to the form, to track ledger ids
    foreach ($eligibleData['claim']['service_lines'] as &$eligibleServiceLine) {
        unset($eligibleServiceLine['ledger_id']);
        unset($eligibleServiceLine['verification']);
    }

    // Workaround for "other_payers_subscriber_address_required not set" error
    array_set($eligibleData, 'other_payers.0.subscriber.address', null);

    //Curl post call to claim end point
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($eligibleData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $jsonResponse = json_decode($result);

    if (!empty($jsonResponse)) {
        $referenceId = $jsonResponse->reference_id;
        $success = $jsonResponse->success;
    } else {
        $referenceId = '';
        $success = '';
    }

    $eClaimId = $db->getInsertId("INSERT INTO dental_claim_electronic SET
        claimid = '$claimId',
        reference_id = '".$db->escape($referenceId)."',
        response = '".$db->escape($result)."',
        adddate = NOW(),
        ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'");

    if ($success) {
        $event = "claim_submitted";
    } else {
        $event = "claim_rejected";
    }

    $db->query("INSERT INTO dental_eligible_response SET
        response = '".$db->escape($result)."',
        reference_id = '".$db->escape($referenceId)."',
        event_type = '".$db->escape($event)."',
        adddate = NOW(),
        ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'");

    $newSentStatus = $isFormerPrimary ? DSS_CLAIM_SENT : DSS_CLAIM_SEC_SENT;

    claim_status_history_update($claimId, $newSentStatus, $formerStatus, $userId, $_SESSION['adminuserid']);
    claim_history_update($claimId, $userId, $_SESSION['adminuserid']);

    invoice_add_efile('2', $_SESSION['admincompanyid'], $eClaimId);
    invoice_add_claim('1', $docId, $claimId);

    if (!$success) {
        error_log('Claim submission failed: ' . $result);

        $rejectedStatus = $isFormerPrimary ? DSS_CLAIM_REJECTED : DSS_CLAIM_SEC_REJECTED;
        $db->query("UPDATE dental_insurance SET status = '$rejectedStatus'
            WHERE insuranceid = '$claimId'");

        claim_status_history_update($claimId, $rejectedStatus, $newSentStatus, $userId, $_SESSION['adminuserid']);
    }

    return $jsonResponse;
}
