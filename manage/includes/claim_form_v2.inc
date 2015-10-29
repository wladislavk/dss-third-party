<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/claim_functions.php';

$claimId = intval($_GET['insid']);
$patientId = intval($_GET['pid']);

$status = $db->getRow("SELECT status FROM dental_insurance WHERE insuranceid = '$claimId' AND patientid = '$patientId'");
$status = $status ? $status['status'] : 0; // This means default status is zero

$isSecondary = ClaimFormData::isSecondary($status) || ($_GET['instype'] == 2);
$isSent = ClaimFormData::isStatus('sent', $status);
$isPending = ClaimFormData::isStatus('pending', $status);
$isSecondaryPending = $isSecondary && $isPending;
$isDispute = ClaimFormData::isStatus('dispute', $status);
$isRejected = ClaimFormData::isStatus('rejected', $status);

$isNewClaim = !$claimId;

$patientData = $db->getRow("SELECT * FROM dental_patients WHERE patientid = '$patientId'");
$docId = intval($patientData['docid']);

// deleting specified claim form
if (!empty($_REQUEST["delid"]) ? $_REQUEST["delid"] : '') {
    $deleteId = intval($_REQUEST['delid']);
    $db->query("DELETE FROM dental_procedure WHERE procedureid = '$deleteId'");

    $msg = "Deleted Successfully";
    ?>
    <script type="text/javascript">
        window.location="delete_insurance.php?pid=<?= $patientId ?>&msg=<?= $msg ?>&delid=<?= $deleteId ?>";
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die
}

if (!empty($_POST['ex_statusbtn'])) { ?>
    <script type="text/javascript">
        window.location = '<?= $called_from ?>?insid=<?= $claimId ?>&checkstatus=1&pid=<?= $patientId ?>';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
} elseif (!empty($_POST['insurancesub']) && $_POST['insurancesub'] == 1 || !empty($_POST['ex_pagebtn'])) {
    // If the status is pending, then confirm changes to ledger transactions
    if ($isPending && !confirm_ledger_trxns()) { ?>
        <script type="text/javascript">
            window.location = "manage_claims.php?msg=Error sending claim: Frontoffice user has altered claim. Please reload and try again.";
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    // Save claim
    $claimId = savePaperClaimForm($claimId, $patientId, $_POST, $status, compact('called_from', 'electronic_form'));

    if ($isNewClaim) {
        $msg = "Claim Created Successfully";

        ?>
        <script type="text/javascript">
            window.location = '<?= $called_from ?>?pid=<?= $patientId ?>&msg=<?= $msg ?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die
    } else {
        $msg = "Claim Edited Successfully";

        // Single lines in redirection or the parser fails
        ?>
        <script type="text/javascript">
            <?php if (isset($_POST['ex_pagebtn_elec'])) { ?>
            window.location = '<?= $called_from ?>?status=0&insid=<?= $claimId ?>&sendins=1&pid=<?= $patientId ?>&msg=<?= $msg ?>';
            <?php } elseif (isset($_POST['elec_save'])) { ?>
            window.location = '<?= $electronic_form ?>';
            <?php } else { ?>
            window.location = '<?= $called_from ?>?status=0&insid=<?= $claimId ?>&showins=1&pid=<?= $patientId ?>&msg=<?= $msg ?>';
            <?php } ?>
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR); // already did a javascript redirect...just die
    }
}

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
$fdf_file = !empty($claimData['primary_fdf']) ? $claimData['primary_fdf'] : '';
$p_m_eligible_payer_id = !empty($claimData['p_m_eligible_payer_id']) ? $claimData['p_m_eligible_payer_id'] : '';
$p_m_eligible_payer_name = !empty($claimData['p_m_eligible_payer_name']) ? $claimData['p_m_eligible_payer_name'] : '';
$s_m_eligible_payer_id = !empty($claimData['s_m_eligible_payer_id']) ? $claimData['s_m_eligible_payer_id'] : '';
$s_m_eligible_payer_name = !empty($claimData['s_m_eligible_payer_name']) ? $claimData['s_m_eligible_payer_name'] : '';

$pica1 = st($claimData['pica1']);
$pica2 = st($claimData['pica2']);
$pica3 = st($claimData['pica3']);
$p_m_dss_file = $patientData['p_m_dss_file'];

if (!empty($patientData['exclusive'])){ $p_m_dss_file = 1; }

$s_m_dss_file = $patientData['s_m_dss_file'];
$patient_lastname = st($claimData['patient_lastname']);
$patient_firstname = st($claimData['patient_firstname']);
$patient_middle = st($claimData['patient_middle']);
$patient_dob = st($claimData['patient_dob']);
$patient_sex = st($claimData['patient_sex']);
$responsibility_sequence = $claimData['responsibility_sequence'];

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
$insured_id_number = st($claimData['insured_id_number']);
$other_insured_id_number = st($claimData['other_insured_id_number']);
$insured_firstname = st($claimData['insured_firstname']);
$insured_middle = st($claimData['insured_middle']);
$insured_lastname = st($claimData['insured_lastname']);
$insured_dob = st($claimData['insured_dob']);
$insured_insurance_plan = st($claimData['insured_insurance_plan']);
$insured_policy_group_feca = st($claimData['insured_policy_group_feca']);
$insured_address = st($claimData['insured_address']);
$insured_city = st($claimData['insured_city']);
$insured_state = st($claimData['insured_state']);
$insured_zip = st($claimData['insured_zip']);
list($insured_phone_code, $insured_phone) = parsePhoneNumber(
  $claimData['insured_phone_code'], $claimData['insured_phone']
);
$insured_sex = st($claimData['insured_sex']);
$patient_relation_insured = st($claimData['patient_relation_insured']);

$patient_address = st($claimData['patient_address']);
$patient_city = st($claimData['patient_city']);
$patient_state = st($claimData['patient_state']);
$patient_status = st($claimData['patient_status']);
$patient_status_array = explode('~',$patient_status);
$patient_zip = st($claimData['patient_zip']);

list($patient_phone_code, $patient_phone) =
    parsePhoneNumber($claimData['patient_phone_code'], $claimData['patient_phone']);

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
$current_qual = st($claimData['current_qual']);
$same_illness_qual = st($claimData['same_illness_qual']);
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
$outside_lab = st($claimData['outside_lab']);
$s_charges = st($claimData['s_charges']);
$diagnosis_1 = st($claimData['diagnosis_1']);
$diagnosis_2 = st($claimData['diagnosis_2']);
$diagnosis_3 = st($claimData['diagnosis_3']);
$diagnosis_4 = st($claimData['diagnosis_4']);

$icd_ind = st($claimData['icd_ind']);

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
$federal_tax_id_number = st($claimData['federal_tax_id_number']);
$ssn = st($claimData['ssn']);
$ein = st($claimData['ein']);
$patient_account_no = st($claimData['patient_account_no']);
$accept_assignment = st($claimData['accept_assignment']);
$total_charge = st($claimData['total_charge']);
$amount_paid = st($claimData['amount_paid']);
$balance_due = st($claimData['balance_due']);
$nucc_8a = st($claimData['nucc_8a']);
$nucc_8b = st($claimData['nucc_8b']);
$nucc_9a = st($claimData['nucc_9a']);
$nucc_9b = st($claimData['nucc_9b']);
$claim_codes = st($claimData['claim_codes']);
$other_claim_id = st($claimData['other_claim_id']);
$nucc_9c = st($claimData['nucc_9c']);
$nucc_30 = st($claimData['nucc_30']);
$signature_physician = st($claimData['signature_physician']);
$physician_signed_date = dateFormat($claimData['physician_signed_date']);
$service_facility_info_name = st($claimData['service_facility_info_name']);
$service_facility_info_address = st($claimData['service_facility_info_address']);
$service_facility_info_city = st($claimData['service_facility_info_city']);
$service_facility_info = parseCityStateZip($service_facility_info_city);
$service_info_a = st($claimData['service_info_a']);
$service_info_dd = st($claimData['service_info_dd']);
$service_info_b_other = st($claimData['service_info_b_other']);

list($billing_provider_phone_code, $billing_provider_phone) = parsePhoneNumber(
    $claimData['billing_provider_phone_code'], $claimData['billing_provider_phone']
);

$billing_provider_name = st($claimData['billing_provider_name']);
$billing_provider_address = st($claimData['billing_provider_address']);
$billing_provider_city = st($claimData['billing_provider_city']);
$billing_provider_info = parseCityStateZip($billing_provider_city);
$billing_provider_a = st($claimData['billing_provider_a']);
$billing_provider_dd = st($claimData['billing_provider_dd']);
$billing_provider_b_other = st($claimData['billing_provider_b_other']);
$reject_reason = st($claimData['reject_reason']);
$status = st($claimData['status']);

$patient_dob = dateFormat($patient_dob, false);
$insured_dob = dateFormat($insured_dob, false);
$other_insured_dob = dateFormat($other_insured_dob, false);
$date_current = dateFormat($date_current, false);
$date_same_illness = dateFormat($date_same_illness, false);
$unable_date_from = dateFormat($unable_date_from, false);
$unable_date_to = dateFormat($unable_date_to, false);
$hospitalization_date_from = dateFormat($hospitalization_date_from, false);
$hospitalization_date_to = dateFormat($hospitalization_date_to, false);
$patient_signed_date = dateFormat($patient_signed_date, false);
$physician_signed_date = dateFormat($physician_signed_date, false);

list($patient_phone_code, $patient_phone) = parsePhoneNumber($patient_phone_code, $patient_phone);
list($insured_phone_code, $insured_phone) = parsePhoneNumber($insured_phone_code, $insured_phone);
list($billing_provider_phone_code, $billing_provider_phone) = parsePhoneNumber(
    $billing_provider_phone_code, $billing_provider_phone
);

$placeServices = $db->getResults('SELECT * FROM dental_place_service ps WHERE status = 1');
$modifierCodes = $db->getResults('SELECT * FROM dental_modifier_code');

if ($isNewClaim) {
    $sql = "SELECT "
        . "  ledger.*, trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_1 as modcode2, trxn_code.days_units as daysorunits, ";

    if ($insurancetype == '1') {
        $sql .= " user.medicare_npi ";
    } else {
        $sql .= " user.npi ";
    }

    $sql .= " as 'provider_id', ps.place_service as 'place' "
        . "FROM "
        . "  dental_ledger ledger "
        . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
        . "  JOIN dental_users user ON user.userid = ledger.docid "
        . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
        . "WHERE "
        . "  ledger.status = " . DSS_TRXN_PENDING . " "
        . "  AND ledger.patientid = '$patientId'"
        . "  AND ledger.docid = '$docId'"
        . "  AND trxn_code.docid = '$docId'"
        . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
        . "ORDER BY "
        . "  ledger.service_date ASC";
} else {
    $sql = "SELECT "
        . "  ledger.*, ";

    if ($isPending || $isRejected) {
        $sql .= "trxn_code.modifier_code_1 as modcode, trxn_code.modifier_code_2 as modcode2, trxn_code.days_units as daysorunits, ";
    }

    if ($insurancetype == '1') {
        $sql .= " user.medicare_npi ";
    } else {
        $sql .= " user.npi ";
    }

    $sql .= "  as 'provider_id', ps.place_service as 'place', ps2.description AS place_description "
        . "FROM "
        . "  dental_ledger ledger "
        . "  JOIN dental_users user ON user.userid = ledger.docid "
        . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
        . "  LEFT JOIN dental_place_service ps ON trxn_code.place = ps.place_serviceid "
        . "  LEFT JOIN dental_place_service ps2 ON ledger.placeofservice = ps2.place_service "
        . "WHERE "
        . "  (ledger.primary_claim_id = '$claimId'"
        . "  OR ledger.secondary_claim_id = '$claimId')"
        . "  AND ledger.patientid = '$patientId'"
        . "  AND ledger.docid = '$docId'"
        . "  AND trxn_code.docid = '$docId'"
        . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " "
        . "ORDER BY "
        . "  ledger.service_date ASC";
}

$transactions = $db->getResults($sql);

$realTotalAmount = 0;
$oldestServiceDate = null;

foreach ($transactions as $array) {
    $realTotalAmount += $array['amount'];

    if (is_null($oldestServiceDate)) {
        $oldestServiceDate = dateToTime($array['service_date']);
    } else {
        $currentServiceDate = dateToTime($array['service_date']);
        $oldestServiceDate = $oldestServiceDate < $currentServiceDate ? $oldestServiceDate : $currentServiceDate;
    }
}

/**
 * @see CS-29
 *
 * ICD indicator default relies on service dates
 */
$total_charge = (empty($total_charge)) ? 0.00 : $total_charge;
$amount_paid = (empty($amount_paid)) ? 0.00 : number_format($amount_paid, 2);
$balance_due = (empty($balance_due)) ? 0.00 : number_format($balance_due,2);

// We only calculate the dollar amounts when a new claim is created because
// right now we aren't appending any trxns to an existing claim.
if ($isPending) {
    // get total_charge
    if (ClaimFormData::isPrimary($status)) {
        $sql = "SELECT "
            . "  SUM(ledger.amount) as 'total_charge' "
            . "FROM "
            . "  dental_ledger ledger "
            . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
            . "WHERE "
            . "  ledger.status = '" . DSS_TRXN_PENDING . "' "
            . "  AND ledger.patientid = '$patientId' "
            . "  AND ledger.docid = '$docId' "
            . "  AND trxn_code.docid = '$docId' "
            . "  AND trxn_code.type = '" . DSS_TRXN_TYPE_MED . "' "
            . "ORDER BY "
            . "  ledger.service_date ASC";
        $charge_my = $db->getRow($sql);

        if (!empty($charge_my)) {
            $charge_row = $charge_my;
            $total_charge = $charge_row['total_charge'];
        }
    } else {
        $sql = "SELECT "
            . "  SUM(ledger.amount) as 'total_charge' "
            . "FROM "
            . "  dental_ledger ledger "
            . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
            . "WHERE "
            . "  ledger.primary_claim_id = '$referencedClaimId' "
            . "  AND ledger.patientid = '$patientId' "
            . "  AND ledger.docid = '$docId' "
            . "  AND trxn_code.docid = '$docId' "
            . "  AND trxn_code.type = '" . DSS_TRXN_TYPE_MED . "' "
            . "ORDER BY "
            . "  ledger.service_date ASC";
        $charge_my = $db->getRow($sql);

        if (!empty($charge_my)) {
            $charge_row = $charge_my;
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
        . "  ledger.status = '" . DSS_TRXN_PENDING . "' "
        . "  AND ledger.patientid = '$patientId' "
        . "  AND ledger.docid = '$docId' "
        . "  AND trxn_code.docid = '$docId' "
        . "  AND trxn_code.type IN ('" . DSS_TRXN_TYPE_PATIENT . "','" . DSS_TRXN_TYPE_INS . "','" . DSS_TRXN_TYPE_ADJ . "') "
        . "ORDER BY "
        . "  ledger.service_date ASC";

    if (ClaimFormData::isSecondary($status) && ClaimFormData::isStatus('pending', $status)) {
        $sql = "SELECT
                sum(dlp.amount) as amount_paid
        from dental_ledger dl
                LEFT JOIN dental_users p ON dl.producerid=p.userid
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$docId."' and dl.patientid='$patientId'
                        AND primary_claim_id='$referencedClaimId'
                        AND dlp.amount != 0
                        AND dlp.payer = 0";
    }

    $paid_my = $db->getRow($sql);

    if (!empty($paid_my)) {
        $paid_row = $paid_my;
        $amount_paid = $paid_row['amount_paid'];
    }

    // re-calculate balance due
    $balance_due = $total_charge - $amount_paid;

    // Override value from faulty sql queries
    if ($isPending) {
        $total_charge = $realTotalAmount;
    }

    // format calculations
    $total_charge = number_format($total_charge, 2, '.','');
    $amount_paid = number_format($amount_paid, 2, '.','');
    $balance_due = number_format($balance_due, 2, '.','');
}

$eResponse = null;
$eligibleResponse = null;

if ($isRejected) {
    $eResponse = $db->getRow("SELECT *
        FROM dental_claim_electronic
        WHERE claimid = '$claimId'
        ORDER BY adddate DESC
        LIMIT 1");

    $eResponse = $eResponse ?: [];

    if ($eResponse['reference_id']) {
        $referenceId = intval($eResponse['reference_id']);
        $eligibleResponse = $db->getRow("SELECT *
            FROM dental_eligible_response
            WHERE reference_id = '$referenceId'
            ORDER BY adddate DESC
            LIMIT 1");
    }

    $eligibleResponse = $eligibleResponse ?: [];

    if ($eResponse) {
        $eResponse['response'] = json_decode($eResponse['response']);
    }

    if ($eligibleResponse) {
        $eligibleResponse['response'] = json_decode($eligibleResponse['response']);
    }
}

$insuranceCompanyId = intval($isSecondary ? $patientData['s_m_ins_co'] : $patientData['p_m_ins_co']);
$insuranceCompanyData = $db->getRow("SELECT * FROM dental_contact WHERE contactid ='$insuranceCompanyId'");
$insuranceCompanyData = $insuranceCompanyData ?: [];

$qualifiers = $db->getResults("SELECT * FROM dental_qualifier WHERE status = 1 ORDER BY sortby");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Health Insurance Paper Claim Form</title>
    <link rel="stylesheet" href="/manage/form/form.css?v=<?= time() ?>" type="text/css" />
    <style type="text/css">
        .style1 { font-size: 16px }
        input { text-transform: uppercase; }
    </style>
    <link rel="stylesheet" href="https://eligibleapi.com/css/eligible-claim-1500-2014.min.css" />
    <link rel="stylesheet" href="<?php echo $admin_path?>popup/popup.css" media="screen" />
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/script/autocomplete_local.js?v=<?= time() ?>"></script>
    <script type="text/javascript" src="/manage/script/validation.js"></script>
    <script type="text/javascript" src="<?php echo $manage_path?>3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="<?php echo $manage_path?>script/masks.js?v=<?= time() ?>"></script>
    <script type="text/javascript" src="<?php echo $admin_path?>popup/popup.js"></script>
    <script type="text/javascript" src="/manage/js/top.js?v=<?= time() ?>"></script>
    <?php require_once __DIR__ . '/calendarinc.php' ?>
    <?php if (config('app.debug')) { ?>
        <link rel="stylesheet" href="/manage/css/claim-form-mock.css?v=<?= time() ?>" />
        <script type="text/javascript" src="/manage/js/claim-form-mock-data.js?v=<?= time() ?>"></script>
        <script type="text/javascript" src="/manage/js/claim-form-mock.js?v=<?= time() ?>"></script>
    <?php } ?>
    <script type="text/javascript">
        var claimData = <?= json_encode($claimData) ?>;
    </script>
</head>
<body>
    <div id="top-banner">
        <h2>Paper Claim Form</h2>
        <?php if (!empty($is_front_office)) { ?>
            <br />
            <a href="/manage/view_claim.php?claimid=<?= intval($_GET['insid']) ?>&pid=<?= intval($_GET['pid']) ?>">
                <strong>&lt;&lt; Back to Manage Insurance Page</strong>
            </a>
        <?php } else if ($is_back_office) { ?>
            <br />
            <a href="manage_claims.php">
                <strong>&lt;&lt; Back to Manage Claims Page</strong>
            </a>
        <?php } ?>
        <?php if ($status==DSS_CLAIM_PENDING || $status==DSS_CLAIM_REJECTED) { ?>
            <?php if ($_SERVER['PHP_SELF'] == "/manage/admin/insurance_claim.php") { ?>
                <?php if ($_SESSION['admin_access'] == 1) { ?>
                    <a href="manage_claims.php?delid=<?= intval($claimId) ?>"
                        onclick="javascript: return confirm('Are you sure you want to delete this claim?');"
                        style="float:right; color:#f00; font-decoration:none;" class="editdel dellink"
                        title="Delete Claim">
                        Delete Claim
                    </a>
                <?php } ?>
            <?php } else { ?>
                <a href="manage_insurance.php?delid=<?php echo $claimId;?>&pid=<?php echo $_GET['pid']; ?>"
                    onclick="javascript: return confirm('Are you sure you want to delete this claim?');"
                    style="float:right; color:#f00; font-decoration:none;" class="editdel dellink"
                    title="Delete Claim">
                    Delete Claim
                </a>
            <?php } ?>
        <?php } ?>
    </div>

    <?php echo (!empty($msg) ? $msg : ''); ?>

    <?php if (!empty($is_front_office)) { ?>
        <?php if ($isSecondary) { ?>
            <h4>
                Secondary Claim
                (<a href="insurance_v2.php?insid=<?= $referencedClaimId ?>&pid=<?= $patientId ?>">
                    Primary is
                    <?= $referencedClaimId ?>
                </a>)
            </h4>
        <?php } else {
            $sec_sql = "SELECT insuranceid FROM dental_insurance WHERE primary_claim_id = '$claimId'";
            $sec_r = $db->getRow($sec_sql);

            ?>
            <h4>
                Primary Claim
                <?php if (!empty($sec_r)) { ?>
                    (<a href="insurance_v2.php?insid=<?php echo $sec_r['insuranceid']; ?>&pid=<?= $patientId ?>">
                        Secondary is <?php echo $sec_r['insuranceid']; ?>
                    </a>)
                <?php } ?>
            </h4>
        <?php } ?>
    <?php } else { ?>
        <?php if ($isSecondary) { ?>
            <h4>
                Secondary Claim
                (<a href="insurance_claim_v2.php?insid=<?= $referencedClaimId ?>&pid=<?= $patientId ?>">
                    Primary is <?= $referencedClaimId ?>
                </a>)
            </h4>
        <?php } else {
            $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='$claimId'";
            $sec_r = $db->getRow($sec_sql);

            ?>
            <h4>
                Primary Claim
                <?php if (!empty($sec_r)) { ?>
                    (<a href="insurance_claim_v2.php?insid=<?php echo $sec_r['insuranceid']; ?>&pid=<?= $patientId ?>">
                        Secondary is <?php echo $sec_r['insuranceid']; ?>
                    </a>)
                <?php } ?>
            </h4>
        <?php } ?>
    <?php } ?>
<form name="insurancefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?insid=<?php echo (!empty($_GET['insid']) ? $_GET['insid'] : '')?>&pid=<?php echo $_GET['pid']?>" method="post" id="claim-form">
	<input type="hidden" name="insurancesub" value="1" />
	<input type="hidden" name="ed" value="<?php echo $claimId;?>" />

	<div align="right">
        <?php if ($isSent) { ?>
            Claim has been sent
            <!-- Give user ability to print claim again and update claim history -->
            <input type="submit" class="print-button" name="ex_pagebtn" value="REPRINT Claim" title="Reprint your claim.&#013;&#013;If you make changes to the CMS 1500 form they will appear on the reprint&#013;and will be saved in claim history." />
            <?php if ($is_back_office) { ?>
                <input type="submit" class="print-button" name="ex_statusbtn" value="Check Status" />
            <?php } ?>
        <?php } else if (!empty($is_back_office)) { ?>
               <?php if($status == DSS_CLAIM_PENDING){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SENT?>" checked="checked" />
			<input type="hidden" name="status" value="<?php echo DSS_CLAIM_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_SEC_PENDING){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
			<input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_REJECTED){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SENT?>" />
               <?php }elseif($status == DSS_CLAIM_SEC_REJECTED){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
               <?php }else ?>
        <?php if (!$isSent) {  ?>
          <input type="submit" name="ex_pagebtn"
		<?php if($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED){ ?>
onclick="return confirm('This claim has been rejected. By printing this claim the status will be changed to SENT, and the rejection notification will be removed. Click OK to proceed.');"
		<?php } ?>
		value="Print Claim" />
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="return file_claim();" value="Electronically File Claim" />-->
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
	  <input type="submit" name="elec_save" id="elec_save" style="display:none;" />
        <?php } ?>

        <?php } elseif ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
               <?php if(($isPending || $isDispute || $isRejected)/* && $p_m_dss_file == '2'*/){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SENT?>" />
        <?php if (!$isSent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
                WHERE userid='".$db->escape($_SESSION['docid'])."'";

  $api_r = $db->getRow($api_sql);
  if($api_r['use_eligible_api']==1){
  if($isPending){
?>
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="return file_claim();" value="Electronically File Claim" />-->
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
	  <input type="submit" name="elec_save" id="elec_save" style="display:none;" />
  <?php }elseif($isRejected || $isDispute){
?>
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="return file_reject_claim();" value="Resubmit Claim" />-->
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
  <?php
  } ?>
<?php } ?>
        <?php } ?>

               <?php }elseif(($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_REJECTED) && $s_m_dss_file == '2'){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
        <?php if (!$isSent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="file_claim();return false;" value="Electronically File Claim" />-->

        <?php } ?>

               <?php } ?>

                <?php } ?>
		<!--<input type="button" class="print-button" onClick="window.print()" value="Print Claim Form"/>-->
<?php
if (!empty($is_back_office)){
?>
		<input type="button" class="print-button" onclick="window.location='claim_notes.php?id=<?php echo  (!empty($_GET['insid']) ? $_GET['insid'] : ''); ?>&pid=<?php echo  $_GET['pid']; ?>'" value="View Notes" />
<?php
}
?>

<?php if (!empty($is_front_office) && $isSent && $fdf_file!='') { ?>
    <a href="display_fdf_v2.php?f=<?php echo $fdf_file;?>" class="print-button" >Print Claim Form</a>
<?php } ?>
		&nbsp;&nbsp;&nbsp;
	</div>

<?php if ($isRejected) { ?>
    <div class="rejected-banner">
        <?php if ($eligibleResponse['response']) { ?>
            <h3>
                <?= $eligibleResponse['event_type'] ?>
                on
                <?= $eligibleResponse['adddate'] ?>
            </h3>
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
        <?php } elseif ($eResponse['response']) { ?>
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

<?php if (
    !empty($is_back_office) || (
        ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) &&
        ($isPending || $isRejected) &&
        $p_m_dss_file == '2')
) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            setup_autocomplete_local(
                'ins_payer_name',
                'ins_payer_hints',
                'p_m_eligible_payer',
                '',
                'https://eligibleapi.com/resources/payers/claims/medical.json',
                null,
                null,
                null,
                true,
                <?= json_encode($claimData['npi']) ?>,
                '<?= $is_front_office ? 1 : 2 ?>'
            );
        });
    </script>
    <input type="hidden" name="p_m_eligible_payer" id="p_m_eligible_payer"
        value="<?php echo $p_m_eligible_payer_id."-".$p_m_eligible_payer_name;?>" />
<?php } ?>

<?php if (
    !empty($is_back_office) || (
        ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) &&
        (
            !empty($isSecondaryPending) ||
            !empty($is_sec_rejected)
        ) &&
        $p_m_dss_file == '2'
    )
) { ?>
    <script type="text/javascript">
    $(document).ready(function(){
        setup_autocomplete_local(
            's_m_ins_payer_name',
            's_m_ins_payer_hints',
            's_m_eligible_payer',
            '',
            'https://eligibleapi.com/resources/payers/claims/medical.json',
            null,
            null,
            null,
            true,
            <?= json_encode($claimData['npi']) ?>,
            '<?= $is_front_office ? 1 : 2 ?>'
        );
    });
    </script>
    <input type="hidden" name="s_m_eligible_payer" id="s_m_eligible_payer"
        value="<?php echo $s_m_eligible_payer_id."-".$s_m_eligible_payer_name;?>" />
<?php } ?>

<table border="0" align="center" cellpadding="0" cellspacing="0" id="claim-form-table" class="eligibleapi claim">
	<tr>
		<td align="left" valign="top" width="50%">
			<span><div class="box_bg">1500</div></span>
			<span class="heading1">Health Insurance Claim Form</span><br />
			<span>Approved By National Uniform Claim Committee 08/05</span><br /><br />
			<span>
				<input value="<?php echo (!empty($pica1) ? $pica1 : '');?>" name="pica1" type="text" readonly
                    class="inbox_line1 grayout" maxlength="1"/>
				<input value="<?php echo (!empty($pica2) ? $pica2 : '');?>" name="pica2" type="text" readonly
                    class="inbox_line1 grayout" maxlength="1"/>
				<input value="<?php echo (!empty($pica3) ? $pica3 : '');?>" name="pica3" type="text" readonly
                    class="inbox_line1 grayout" maxlength="1"/>
				PICA
			</span>
		</td>
		<td width="50%">
		  <table>
		  <tr>
		      <td>
		      Ins. Co:
		      </td>
		      <td>
		       <?php echo $insuranceCompanyData['company']; ?>
		      </td>
		  </tr>
		     <td valign="top">
		      Address:
		      </td>
		      <td valign="top">
		       <?php echo $insuranceCompanyData['add1']; ?><br />
		   <?php echo $insuranceCompanyData['add2']; ?>
		      </td>
		  <tr>
		      <td>

		      </td>
		      <td>
		      <?php echo $insuranceCompanyData['city']; ?>&nbsp;&nbsp;
		       <?php echo $insuranceCompanyData['state']; ?>&nbsp;,

		       <?php echo $insuranceCompanyData['zip']; ?><br />
		      </td>
		  </tr>
       </table>
		   <br />
		   <br />



		</td>

		<td align="left" valign="top">
			<span></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top">
			<table width="1185" border="1" cellspacing="0" cellpadding="2" bordercolor="#333333">
				<tr>
					<td colspan="2" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">
									<span class="num">1.</span>
Medicare
                                                                </td>
                                                                <td align="center" valign="top">
                                                                        MediCaID
                                                                </td>
                                                                <td align="center" valign="top">
                                                                        Tricare Champus
                                                                </td>
                                                                <td align="center" valign="top">
                                                                        Chmapva
                                                                </td>
                                                                <td align="center" valign="top">
                                                                        Group Health Plan
                                                                </td>
                                                                <td align="center" valign="top">
                                                                        Feca blklung
                                                                </td>
                                                                <td align="center" valign="top">
                                                                        Other
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="1" <?php if($insurancetype == '1') {echo " checked";}?> />
                                                                        <span class="small_cap">(Medicare #)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="2" <?php if($insurancetype == '2') {echo " checked";}?> />
                                                                        <span class="small_cap">(Medicaid #)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="3" <?php if($insurancetype == '3') {echo " checked";}?> />
                                                                        <span class="small_cap">(Sponsor's SSN)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="4" <?php if($insurancetype == '4') {echo " checked";}?> />
                                                                        <span class="small_cap">(Member ID #)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="5" <?php if($insurancetype == '5') {echo " checked";}?> />
                                                                        <span class="small_cap">(SSN or ID)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="6" <?php if($insurancetype == '6') {echo " checked";}?> />
                                                                        <span class="small_cap">(SSN)</span>
                                                                </td>
                                                                <td align="left" valign="top">
                                                                        <input name="insurance_type" type="radio" value="7" <?php if($insurancetype == '7') {echo " checked";}?> />
                                                                        <span class="small_cap">(ID)</span>
                                                                </td>


									<!--Payer

									<input type="text" name="payer_id" style="width:120px" />
									<input type="text" name="payer_name" />
									<input type="text" name="payer_add1" />
									<input type="text" name="payer_add2" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top">
									<input type="text" name="payer_city" />
									<input type="text" name="payer_state" />
									<input type="text" name="payer_zip" />
                                                                </td>
									-->
							</tr>
						</table>
						<input type="hidden" name="other_insurance_type" value="<?php echo  $other_insurancetype; ?>" />
					</td>
					<td width="448" align="left" valign="top">
						<span class="num_a">1a.</span>
						Insured's ID Number
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="small_cap">(For Program in item 1)</span>
						<br />
						<input type="text" value="<?php echo $insured_id_number?>" name="insured_id_number" size="60" />
						<input type="hidden" value="<?php echo $other_insured_id_number?>" name="other_insured_id_number" value="" size="60" />
					</td>
				</tr>
				<tr>
					<td width="429" align="left" valign="top">
						<span class="num">2.</span>
						Patient Name
						<span class="small_cap">(Last Name, First Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" value="<?php echo $patient_lastname?>" name="patient_lastname"
                                class="inbox_line3 inbox-third" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?php echo $patient_firstname?>" name="patient_firstname"
                                class="inbox_line3 inbox-third" size="18" />
							&nbsp;
							<input type="text" value="<?php echo $patient_middle?>" name="patient_middle"
                                class="inbox_line3 inbox-third" size="3" width="30" />
						</div>
					</td>
					<td width="300" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num">3.</span>
									Patient's Birth Date
									<br />
									&nbsp;&nbsp;
                                    <input id="dob" name="patient_dob" type="text" class="field text addr tbox calendar"
                                         value="<?php echo $patient_dob?>"
                                         style="width:100px;" maxlength="255"
                                         onChange="validateDate('dob');"
                                         placeholder="YYYY-MM-DD"
                                         data-date-format="Y-m-d"
                                    />
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M
									<input type="radio" name="patient_sex" value="M" <?php if($patient_sex == "M" || $patient_sex == "Male") echo " checked";?> />
									&nbsp;&nbsp;F
									<input type="radio" name="patient_sex" value="F" <?php if($patient_sex == "F" || $patient_sex == "Female") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">4.</span>
						Insured's Name &nbsp;
						<span class="small_cap">(Last Name, First Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
                            <input type="text" value="<?php echo $insured_lastname?>" name="insured_lastname"
                                class="inbox_line3 inbox-third" size="18" width="60" />
                                                        &nbsp;
							<input type="text" value="<?php echo $insured_firstname?>" name="insured_firstname"
                                class="inbox_line3 inbox-third" size="18" />
							&nbsp;
							<input type="text" value="<?php echo $insured_middle?>" name="insured_middle"
                                class="inbox_line3  inbox-third" size="3" width="30" />
						</div>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num">5.</span>
						Patient's Address
						<span class="small_cap">(No. Street)</span>
						<br />
						<input type="text" value="<?php echo $patient_address?>" name="patient_address" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num">6.</span>
						Patient Relationship To Insured
						<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<span class="small_cap">Self</span>
									<input name="patient_relation_insured" type="radio" value="Self" <?php if($patient_relation_insured == "Self" || $patient_relation_insured=="") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Spouse</span>
									<input name="patient_relation_insured" type="radio" value="Spouse" <?php if($patient_relation_insured == "Spouse") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Child</span>
									<input name="patient_relation_insured" type="radio" value="Child" <?php if($patient_relation_insured == "Child") echo " checked";?> />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Others</span>
									<input name="patient_relation_insured" type="radio" value="Other" <?php if($patient_relation_insured == "Other") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">7.</span>
						Insured's Address
						<span class="small_cap">(No. Street)</span>
						<br />
						<input value="<?php echo $insured_address?>" name="insured_address" type="text" class="inbox_line3" size="28" />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input value="<?php echo $patient_city?>" name="patient_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input value="<?php echo $patient_state?>" name="patient_state" type="text" class="inbox_line3 statemask" size="3" width="30" />
								</td>
							</tr>
						</table>
					</td>
					<td rowspan="2" align="left" valign="top" class="grayout">
						<span class="num">8.</span>
						Reserved for NUCC Use<br />
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<input name="nucc_8a" value="<?php echo  (!empty($nucc_8a) ? $nucc_8a : ''); ?>" type="text" />
									<input name="nucc_8b" value="<?php echo  (!empty($nucc_8b) ? $nucc_8b : ''); ?>" type="text" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input value="<?php echo $insured_city?>" name="insured_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input value="<?php echo $insured_state?>" name="insured_state" type="text" class="inbox_line3 statemask" size="3" width="30" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									Zip Code
									<br />
									<input value="<?php echo $patient_zip?>" name="patient_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">
                                        (<input type="text" value="<?php echo  $patient_phone_code; ?>" name="patient_phone_code"
                                        size="3" class="inbox_line3 inbox-third phonecodemask" />
                                        )
                                    </span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?php echo $patient_phone?>" name="patient_phone"
                                        class="inbox_line3 inbox-half phonemask" size="13"  />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									Zip Code
									<br />
									<input value="<?php echo $insured_zip?>" name="insured_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">
                                        (<input type="text" value="<?php echo $insured_phone_code?>" name="insured_phone_code"
                                        size="3" class="inbox_line3 inbox-third phonecodemask" />
                                        )
                                    </span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" value="<?php echo $insured_phone?>" name="insured_phone"
                                        class="inbox_line3 inbox-third phonemask" size="13" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num">9.</span>
						Other Insured's Name
						<span class="small_cap">(Last Name, first, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" value="<?php echo $other_insured_lastname?>" name="other_insured_lastname"
                                class="inbox_line3 inbox-third" size="18" />
							&nbsp;
							<input type="text" value="<?php echo $other_insured_firstname?>" name="other_insured_firstname"
                                class="inbox_line3 inbox-third" size="18" width="60" />
							&nbsp;
							<input type="text" value="<?php echo $other_insured_middle?>" name="other_insured_middle"
                                class="inbox_line3 inbox-third" size="3" width="30" />
						</div>
					</td>
					<td rowspan="4" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top" style="line-height:33px;">
									<span class="num">10.</span>
									Is patient's Condition Related To :
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">a.</span>
									Employment?
									<span class="small_cap">(current Or Previous)</span>
									<br />
									<input type="radio" name="employment" value="YES"
                                        <?= isOptionSelected($employment) ? 'checked' : '' ?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="employment" value="NO"
                                        <?= isOptionSelected($employment) ? '' : 'checked' ?> />
									NO
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">b.</span>
									Auto Accident?
									<br />
									<input type="radio" name="auto_accident" value="YES"
                                        <?= isOptionSelected($auto_accident) ? 'checked' : '' ?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="auto_accident" value="NO"
                                        <?= isOptionSelected($auto_accident) ? '' : 'checked' ?> />
									NO
									&nbsp;&nbsp;
									Place <span class="small_cap">(State)</span>
									<input type="text" value="<?php echo (!empty($auto_accident_place) ? $auto_accident_place : '')?>"
                                        class="inbox_line3 inbox-third" size="10" name="auto_accident_place" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">c.</span>
									Other Accident?
									<br />
									<input type="radio" name="other_accident" value="YES"
                                        <?= isOptionSelected($other_accident) ? 'checked' : '' ?> />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="other_accident" value="NO"
                                        <?= isOptionSelected($other_accident) ? '' : 'checked' ?> />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">11.</span>
						Insured's Policy Group or FECA Number
						<br />
						<input value="<?php echo $insured_policy_group_feca?>" name="insured_policy_group_feca" type="text" class="inbox_line3" size="28"/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">a.</span>
						Other Insured's policy Or Group Number
						<br />
						<input value="<?php echo $other_insured_policy_group_feca?>" name="other_insured_policy_group_feca" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num_a">a.</span>
									Insured's Birth Date
									<br />
									&nbsp;&nbsp;
                                    <input id="insured_dob" name="insured_dob" type="text" class="field text addr tbox calendar"
                                        value="<?php echo  $insured_dob; ?>" style="width:100px;" maxlength="255"
                                        onChange="validateDate('insured_dob');"
                                        placeholder="YYYY-MM-DD"
                                        data-date-format="Y-m-d"
                                    />
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br />
									M
									<input type="radio" name="insured_sex" value="M" <?php if($insured_sex == "M" || $insured_sex == "Male") echo " checked";?> />
									&nbsp;&nbsp;F
									<input type="radio" name="insured_sex" value="F" <?php if($insured_sex == "F" || $insured_sex == "Female") echo " checked";?> />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" class="grayout">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top">
									<span class="num_a">b.</span>
									Reserved for NUCC Use
									<br />
									<input type="text" name="nucc_9b" value="<?php echo  (!empty($nucc_9b) ? $nucc_9b : ''); ?>" class="inbox_line3" size="28"/>
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top" class="grayout">
						<span class="num_a">b.</span>
						Other Claim ID (Designated by NUCC)
						<br />
						<input name="other_claim_id" value="<?php echo  (!empty($other_claim_id) ? $other_claim_id : ''); ?>" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" class="grayout">
						<span class="num_a">c.</span>
						Reserved for NUCC Use
						<br />
						<input name="nucc_9c" value="<?php echo  (!empty($nucc_9c) ? $nucc_9c : ''); ?>" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Insurance Plan Name or Program Name
						<br />
						<input value="<?php echo $insured_insurance_plan?>" name="insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <span class="num_a">d.</span>
                                    Insurance Plan Name or Program Name
                                    <br />
                                    <input value="<?php echo $other_insured_insurance_plan?>" type="text"
                                        class="inbox_line3" size="28" name="other_insured_insurance_plan" />
                                </td>
                                <td>
                                    <span class="num_a">e.</span>
                                    Res. sequence
                                    <br />
                                    <select name="responsibility_sequence">
                                        <option value=""></option>
                                        <option value="P" <?= $responsibility_sequence === 'P' ? 'selected' : '' ?>>Primary</option>
                                        <option value="S" <?= $responsibility_sequence === 'S' ? 'selected' : '' ?>>Secondary</option>
                                        <option value="T" <?= $responsibility_sequence === 'T' ? 'selected' : '' ?>>Tertiary</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
					</td>
					<td align="left" valign="top">
						<span class="num_a">10d.</span>
						Claim Codes (Designated by NUCC)
						<br />
						<input value="<?php echo (!empty($claim_codes) ? $claim_codes : ''); ?>" name="claim_codes" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">d.</span>
						Is there another health benefit Plan?
						<br />
						<input type="radio" name="another_plan" value="yes" <?= isOptionSelected($another_plan) ? 'checked' : ''?> />YES
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="another_plan" value="no" <?= !isOptionSelected($another_plan) ? 'checked' : '' ?> />NO
						&nbsp;&nbsp;
						<span class="small_cap"><i>if yes, return to and complete item 9 a-d</i></span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" valign="top">
						<center style="text-align:center; font-weight:bold">
							Read Back of Form Before Completing & Signing This Form
						</center>
						<span class="num">12.</span>
						Patient's or Authorized Person's Signature
						<span class="small_cap"> I authorize the release of any medical or other information neccessary to process this claim. I also reuest payment of government benefits either to myself or th the party who accepts assignment below.</span>
						<br /><br /><br />

						<input type="checkbox" name="patient_signature" value="1" <?php if($patient_signature == "1" || $patient_signature == "Y") echo " checked";?> />
						Signature on File
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;
						Date:
                        <input id="patient_signed_date" name="patient_signed_date" type="text" class="field text addr tbox calendar"
                            value="<?php echo $patient_signed_date?>" style="width:100px;" maxlength="255"
                            onChange="validateDate('patient_signed_date');"
                            placeholder="YYYY-MM-DD"
                            data-date-format="Y-m-d"
                        />
					</td>
					<td align="left" valign="top">
						<span class="num">13.</span>
						Insured's or Authorized person's Signature
						<span class="small_cap"> I authorize payment of medical benefits to the undersigned physician or supplier for services described below</span>
						<br /><br /><br />

						<?php
            $patient_signature = st(!empty($claimData['patient_signature']) ? $claimData['patient_signature'] : '');
            echo "<center>SIGNATURE ON FILE: <input type='checkbox' name='insured_signature' value='1' ";
            if($insured_signature){ echo "checked"; }
	    echo " /></center>";
            ?>

					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num">14.</span>
DATE OF CURRENT ILLNESS, INJURY, or PREGNANCY (LMP)`
									<br />
									&nbsp;&nbsp;
                                    <input id="date_current" name="date_current" type="text" class="field text addr tbox calendar"
                                        value="<?php echo $date_current?>" style="width:100px;" maxlength="255"
                                        onChange="validateDate('date_current');"
                                        placeholder="YYYY-MM-DD"
                                        data-date-format="Y-m-d"
                                    />
									<span class="small_cap"> QUAL. </span>
									<input type="text" name="current_qual" class="inbox_line3 inbox-third"
                                        value="<?php echo (!empty($current_qual) ? $current_qual : ''); ?>" size="10"/>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" class="grayout">
						<span class="num">15.</span>
						Other Date
						<br />
						<span class="small_cap">QUAL.</span>
									<input type="text" name="same_illness_qual" class="inbox_line3 inbox-third" size="10"
                                        value="<?php echo (!empty($same_illness_qual) ? $same_illness_qual : ''); ?>"/>
						&nbsp;&nbsp;
                        <input id="date_same_illness" name="date_same_illness" type="text" class="field text addr tbox calendar"
                            value="<?php echo $date_same_illness?>" style="width:100px;" maxlength="255"
                            onChange="validateDate('date_same_illness');"
                            placeholder="YYYY-MM-DD"
                            data-date-format="Y-m-d"
                        />
					</td>
					<td valign="top">
						<span class="num">16.</span>
						Dates Patient unable to work in Current Occupation
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="middle" width="10%">
									From
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
                                    <input id="unable_date_from" name="unable_date_from" type="text" class="field text addr tbox calendar"
                                        value="<?php echo (!empty($unable_date_from) ? $unable_date_from : ''); ?>"
                                        style="width:100px;" maxlength="255"
                                        onChange="validateDate('unable_date_from');"
                                        placeholder="YYYY-MM-DD"
                                        data-date-format="Y-m-d"
                                    />
								</td>

								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
                                    <input id="unable_date_to" name="unable_date_to" type="text" class="field text addr tbox calendar"
                                        value="<?php echo (!empty($unable_date_to) ? $unable_date_to : ''); ?>"
                                        style="width:100px;" maxlength="255"
                                        onChange="validateDate('unable_date_to');"
                                        placeholder="YYYY-MM-DD"
                                        data-date-format="Y-m-d"
                                    />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">17.</span>
						Name of Referring Provider or Other Source
				<select name="name_referring_provider_qualifier">
                    <option value=""></option>
                    <option value="DN" <?= ($name_referring_provider_qualifier=="DN" || $insurancetype == '1' )?'selected="selected"':''; ?>>DN - Referring Provider</option>
                    <option value="DK" <?php echo  (!empty($name_referring_provider_qualifier) && $name_referring_provider_qualifier=="DK")?'selected="selected"':''; ?>>DK - Ordering Provider</option>
					<option value="DQ" <?php echo  (!empty($name_referring_provider_qualifier) && $name_referring_provider_qualifier=="DQ")?'selected="selected"':''; ?>>DQ - Supervising Provider</option>
				</select>
								<input type="text" value="<?php echo  $referring_provider; ?>" name="referring_provider" class="inbox_line3" size="20" />

					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="10%" style="border-bottom: 1px #000000 dashed;">
									<span class="num">17<span class="num_a">a.</span></span>
								</td>
								<td valign="top" width="10%" style="border-bottom: 1px #000000 dashed;">
                                    <select name="field_17a_dd" class="inbox_line3" style="width:40px;">
                                        <option value=""></option>
                                        <option value="0B" <?= $field_17a_dd == '0B' ? 'selected' : '' ?>>State License Number</option>
                                        <option value="1G" <?= $field_17a_dd == '1G' ? 'selected' : '' ?>>Provider UPIN Number</option>
                                        <option value="G2" <?= $field_17a_dd == 'G2' ? 'selected' : '' ?>>Provider Commercial Number</option>
                                    </select>
								</td>
								<td valign="top" width="80%" style="border-bottom: 1px #000000 dashed; padding-bottom:3px;">
									<input type="text" value="<?php echo (!empty($field_17a) ? $field_17a : ''); ?>" name="field_17a" class="inbox_line3" size="30"/>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<span class="num">17<span class="num_a">b.</span>
								<td valign="top">
									NPI
								</td>
								<td valign="top" style="padding-top:3px;">
									<input type="text" value="<?php echo  $diagnosising_npi; ?>" name="field_17b" class="inbox_line3" size="30"/>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">18.</span>
						Hospitalization Dates Related to Current Services

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="middle" width="10%">
									From
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
                                    <input id="hospitalization_date_from" name="hospitalization_date_from" type="text" class="field text addr tbox calendar"
                                        value="<?php echo (!empty($hospitalization_date_from) ? $hospitalization_date_from : ''); ?>"
                                        style="width:100px;" maxlength="255"
                                        onChange="validateDate('hospitalization_date_from');"
                                        placeholder="YYYY-MM-DD"
                                        data-date-format="Y-m-d"
                                    />

								</td>

								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;
                                    <input id="hospitalization_date_to" name="hospitalization_date_to" type="text" class="field text addr tbox calendar"
                                        value="<?php echo (!empty($hospitalization_date_to) ? $hospitalization_date_to : ''); ?>"
                                        style="width:100px;" maxlength="255"
                                        onChange="validateDate('hospitalization_date_to');"
                                        placeholder="YYYY-MM-DD"
                                        data-date-format="Y-m-d"
                                    />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<span class="num">19.</span>
						Additional Claim Information (DESIGNATED BY NUCC)<br />
						<input type="text" value="<?php echo (!empty($reserved_local_use1) ? $reserved_local_use1 : '')?>" name="reserved_local_use1" class="inbox_line3" size="100" />
					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="60%">
									<span class="num">20.</span>
									Outside Lab?
									<br />
									<input type="radio" name="outside_lab" value="YES"  <?= isOptionSelected($outside_lab) ? 'checked' : ''?>/>
									YES
									&nbsp;&nbsp;
									<input type="radio" name="outside_lab" value="NO" <?= !isOptionSelected($outside_lab) ? 'checked' : '' ?> />
									NO
								</td>
								<td valign="top" width="40%">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									S Charges
									<br />
									<input type="text" value="<?php echo (!empty($s_charges) ? $s_charges : ''); ?>" name="s_charges" class="inbox_line3" size="30" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2" rowspan="2">
						<span class="num">21.</span>
						Diagnosis or Nature of Illness or Injury
						<span class="small_cap">
							(Relate A-L to service line below (24E))
						</span>
                        ICD IND.
                        <select name="icd_ind" class="inbox-wide">
                            <option value="9" <?= $icd_ind == 9 ? 'selected="selected"' : '' ?>>
                                ICD-9-CM - 9
                            </option>
                            <option value="0" <?= $icd_ind == 0 || $icd_ind == 10 ? 'selected="selected"' : '' ?>>
                                ICD-10-CM - 0
                            </option>
                        </select>

						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="23%">
									<b>A.</b>
									<input type="text" name="diagnosis_a" class="inbox_line3" size="20" value="<?php echo  $diagnosis_a; ?>" />
								</td>
								<td valign="top" width="23%">
									<b>B.</b>
                                                                        <input type="text" name="diagnosis_b" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_b) ? $diagnosis_b : ''); ?>" />
								</td>
                                                                <td valign="top" width="23%">
                                                                        <b>C.</b>
                                                                        <input type="text" name="diagnosis_c" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_c) ? $diagnosis_c : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>D.</b>
                                                                        <input type="text" name="diagnosis_d" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_d) ? $diagnosis_d : ''); ?>" />
                                                                </td>

							</tr>
                                                        <tr>
                                                                <td valign="top" width="23%">
                                                                        <b>E.</b>
                                                                        <input type="text" name="diagnosis_e" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_e) ? $diagnosis_e : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>F.</b>
                                                                        <input type="text" name="diagnosis_f" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_f) ? $diagnosis_f : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>G.</b>
                                                                        <input type="text" name="diagnosis_g" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_g) ? $diagnosis_g : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>H.</b>
                                                                        <input type="text" name="diagnosis_h" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_h) ? $diagnosis_h : ''); ?>" />
                                                                </td>

                                                        </tr>
                                                        <tr>
                                                                <td valign="top" width="23%">
                                                                        <b>I.</b>
                                                                        <input type="text" name="diagnosis_i" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_i) ? $diagnosis_i : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>J.</b>
                                                                        <input type="text" name="diagnosis_j" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_j) ? $diagnosis_j : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>K.</b>
                                                                        <input type="text" name="diagnosis_k" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_k) ? $diagnosis_k : ''); ?>" />
                                                                </td>
                                                                <td valign="top" width="23%">
                                                                        <b>L.</b>
                                                                        <input type="text" name="diagnosis_l" class="inbox_line3" size="20" value="<?php echo  (!empty($diagnosis_l) ? $diagnosis_l : ''); ?>" />
                                                                </td>

                                                        </tr>

						</table>
					</td>
					<td valign="top">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td width="60%">
                                    <span class="num">22.</span>
                                    Resubmission Code
                                    <br>
                                    <label class="small_cap">
                                        <input type="radio" name="resubmission_code_fill" value="1"
                                            <?= $resubmission_code_fill == 1 ? 'checked' : '' ?> />
                                        Original
                                    </label>
                                    <label class="small_cap">
                                        <input type="radio" name="resubmission_code_fill" value="7"
                                            <?= $resubmission_code_fill == 7 ? 'checked' : '' ?> />
                                        Resubmission
                                    </label>
                                    <label class="small_cap">
                                        <input type="radio" name="resubmission_code_fill" value="8"
                                            <?= $resubmission_code_fill == 8 ? 'checked' : '' ?> />
                                        Cancellation
                                    </label>
                                </td>
                                <td width="40%">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Original Ref. No.
                                    <input type="text" value="<?= $original_ref_no ?>" name="original_ref_no"
                                        class="inbox_line3" size="30" />
                                </td>
                            </tr>
                        </table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">23.</span>
						Prior Authorization Number
						<br />
						<input type="text" value="<?php echo $prior_authorization_number?>" name="prior_authorization_number" class="inbox_line3" size="60" />
					</td>
				</tr>
<!-- START BOX 24 -->
				<tr>
					<td valign="top" colspan="3" class="vertical-center">
						<a name="procedure"></a>
						<span class="num">24.</span>
						<table width="100%" cellpadding="3" cellspacing="1" border="0" bgcolor="#000000" >
							<tr bgcolor="#FFFFFF">
								<td valign="top" rowspan="2" align="center">&nbsp;

								</td>
								<td valign="top" colspan="2" align="center">
									<span class="num_a">A.</span>
									Date(s) of service
								</td>
								<td valign="top" align="center">
									<span class="num_a">B.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">C.</span>
								</td>
								<td valign="top" colspan="5" align="center">
									<span class="num_a">D.</span>
									Procedures, Services or Supplies
									<br />
									<span class="small_cap">
										(Explain Unusual Circumstances)
									</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">E.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">F.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">G.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">H.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">I.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">J.</span>
								</td>
							</tr>

							<tr bgcolor="#FFFFFF">
								<td valign="bottom" align="center">
									<span class="small_cap">
										From
										<br />
										MM
										&nbsp;&nbsp;&nbsp;
										DD
										&nbsp;&nbsp;&nbsp;
										YY
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										To
										<br />
										MM
										&nbsp;&nbsp;&nbsp;
										DD
										&nbsp;&nbsp;&nbsp;
										YY
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										PLACE OF <br />SERVICE
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										EMG
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										CPT/HCPCS
									</span>
								</td>
								<td valign="bottom" align="center" colspan="4">
									<span class="small_cap">
										MODIFIER
									</span>
								</td>
								<td valign="bottom" align="center" width="160">
									<span class="small_cap">
										DIAGNOSIS <br />POINTER
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										$ CHARGES
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										DAYS <br />OR <br />UNITS
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										EPSDT <br />Family <br />Plan
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										ID. <br />QUAL.
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										RENDERING <br />PROVIDER ID. #
									</span>
								</td>
							</tr>
						</table>

                        <!-- START LEDGER TRXNS -->
<?php  if (!count($transactions)) { ?>
    <p style="text-align: center;"><strong>There are currently no ledger entries to be submitted.</strong></p>
<?php } else { ?>
  <?php $li = 0; ?>
  <input type="hidden" name="ledgercount" value="<?php echo count($transactions); ?>">
  <?php foreach ($transactions as $array) { ?>
    <table style="margin-left:39px;">
      <tr>
        <td width="106"><?= dateFormat($array['service_date']); ?></td>
        <td width="106"><?= dateFormat($array['service_date']); ?></td>
        <td width="91">
		<select style="width:76px" name="placeofservice<?php echo $li;?>">
			<option value=''>Select One</option>
			<?php
				$pos = ($array['placeofservice']!='')?$array['placeofservice']:$array['place'];
  				$dp = ($array['diagnosispointer']!='')?$array['diagnosispointer']:1;

				if (!empty($placeServices)) foreach ($placeServices as $psr){
				?><option value="<?php echo  $psr['place_service']; ?>" <?php echo  ($pos==$psr['place_service'])?'selected="selected"':''; ?>><?php echo  $psr['place_service']." ".$psr['description']; ?></option>
			<?php
				}
			?>
	</td>
        <td width="41">
            <input style="width:26px;" type="checkbox" name="emg<?php echo $li;?>" value="true"
                <?= isOptionSelected($array['emg']) ? 'checked' : '' ?> />
        </td>
        <td width="222"><?php echo $array['transaction_code'] . " - " .$array['description'] ; ?></td>
        <td width="191">
          <select name="modifiercode<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($modifierCodes); $i++) { ?>
              <?php $selected = ($array['modcode'] == $modifierCodes[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $modifierCodes[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $modifierCodes[$i]['modifier_code']." ".$modifierCodes[$i]['description']?></option>
            <?php } ?>
          </select>
          <select name="modifiercode2_<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($modifierCodes); $i++) { ?>
              <?php $selected = ($array['modcode2'] == $modifierCodes[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $modifierCodes[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $modifierCodes[$i]['modifier_code']." ".$modifierCodes[$i]['description']?></option>
            <?php } ?>
          </select>
          <select name="modifiercode3_<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($modifierCodes); $i++) { ?>
              <?php $selected = ($array['modcode3'] == $modifierCodes[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $modifierCodes[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $modifierCodes[$i]['modifier_code']." ".$modifierCodes[$i]['description']?></option>
            <?php } ?>
          </select>
          <select name="modifiercode4_<?php echo $li;?>" style="width:171px;">
            <option value=''>Select One</option>
            <?php for ($i = 0; $i < count($modifierCodes); $i++) { ?>
              <?php $selected = ($array['modcode4'] == $modifierCodes[$i]['modifier_code']) ? 'selected' : ''; ?>
              <option value="<?php echo $modifierCodes[$i]['modifier_code']?>" <?php echo $selected;?>><?php echo $modifierCodes[$i]['modifier_code']." ".$modifierCodes[$i]['description']?></option>
            <?php } ?>
          </select>


        </td>
        <td width="92">
		<!--diagnosispointer<?php echo $li;?>-->
<table class="eligibleapi claim"><tbody><tr class="eligibleapi claim">
<td class="input-center-hint checkbox-container"><input class="input" value="1" <?php echo  ($dp=="1")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][0]" type="checkbox"></td><td class="input-side-hint">A</td>
<td class="input-center-hint checkbox-container"><input class="input" value="2" <?php echo  ($dp=="2")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][1]" type="checkbox"></td><td class="input-side-hint">B</td>
<td class="input-center-hint checkbox-container"><input class="input" value="3" <?php echo  ($dp=="3")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][2]" type="checkbox"></td><td class="input-side-hint">C</td>
<td class="input-center-hint checkbox-container"><input class="input" value="4" <?php echo  ($dp=="4")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][3]" type="checkbox"></td><td class="input-side-hint">D</td></tr><tr class="eligibleapi claim">
<td class="input-center-hint checkbox-container"><input class="input" value="5" <?php echo  ($dp=="5")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][4]" type="checkbox"></td><td class="input-side-hint">E</td>
<td class="input-center-hint checkbox-container"><input class="input" value="6" <?php echo  ($dp=="6")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][5]" type="checkbox"></td><td class="input-side-hint">F</td>
<td class="input-center-hint checkbox-container"><input class="input" value="7" <?php echo  ($dp=="7")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][6]" type="checkbox"></td><td class="input-side-hint">G</td>
<td class="input-center-hint checkbox-container"><input class="input" value="8" <?php echo  ($dp=="8")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][7]" type="checkbox"></td><td class="input-side-hint">H</td></tr><tr class="eligibleapi claim">
<td class="input-center-hint checkbox-container"><input class="input" value="9" <?php echo  ($dp=="9")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][8]" type="checkbox"></td><td class="input-side-hint">I</td>
<td class="input-center-hint checkbox-container"><input class="input" value="10" <?php echo  ($dp=="10")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][9]" type="checkbox"></td><td class="input-side-hint">J</td>
<td class="input-center-hint checkbox-container"><input class="input" value="11" <?php echo  ($dp=="11")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][10]" type="checkbox"></td><td class="input-side-hint">K</td>
<td class="input-center-hint checkbox-container"><input class="input" value="12" <?php echo  ($dp=="12")?'checked="checked"':''; ?> name="service_lines[<?php echo  $li; ?>][diagnosis_code_pointers][11]" type="checkbox"></td><td class="input-side-hint">L</td>
</tr></tbody></table>
	</td>
        <td width="100" align="right" style="padding-right:15px;">$<?php echo  number_format($array['amount'], 2); ?></td>
        <td width="54"><input style="width:39px;" type="text" name="daysorunits<?php echo $li;?>" value="<?php echo $array['daysorunits']; ?>"></td>
        <td width="60" class="grayout"><input style="width:45px;" type="text" name="epsdt<?php echo $li;?>" value="<?php echo $array['epsdt']; ?>"></td>
        <td width="52"><input style="width:37px;" type="text" name="idqual<?php echo $li;?>" value="<?php echo $array['idqual']; ?>"></td>
        <input type="hidden" name="ledgerid<?php echo $li;?>" value="<?php echo $array['ledgerid']; ?>">
	<input type="hidden" name="service_date<?php echo $li;?>" value="<?php echo $array['service_date']; ?>">
	<input type="hidden" name="entry_date<?php echo $li;?>" value="<?php echo $array['entry_date']; ?>">
	<input type="hidden" name="transaction_code<?php echo $li;?>" value="<?php echo $array['transaction_code']; ?>">
	<input type="hidden" name="amount<?php echo $li;?>" value="<?php echo $array['amount']; ?>">
        <td width="122"><?php echo $array['provider_id']?></td>
      </tr>
    </table>
    <?php $li++; ?>
  <?php } ?>
<?php } ?>
<!-- /END LEDGER TRXNS -->

					</td>
				</tr>
<!-- /END BOX 24 -->
				<tr>
					<td valign="top" colspan="2" height="100%">
						<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="40%">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td valign="top" width="80%">
												<span class="num">25.</span>
												Federal Tax I.D.Number
												<br />
												<input type="text" value="<?= $federal_tax_id_number ?>"
                                                    name="federal_tax_id_number" size="20" class="inbox_line3" />
											</td>
											<td valign="top" width="10%" align="center">
												SSN
												<br />
												<input type="radio" name="ssnein" value="ssn" <?php if($ssn == "1") echo " checked";?> />
											</td>
											<td valign="top" width="10%" align="center">
												EIN
												<br />
												<input type="radio" name="ssnein" value="ein" <?php if($ein == "1") echo " checked";?> />
											</td>
										</tr>
									</table>
								</td>
                                <td class="b_line label grayout" align="left" valign="top" width="13"></td>
								<td valign="top" width="30%" class="grayout">
									<span class="num">26.</span>
									Patient Account No.
									<br />
									<input type="text" value="<?php echo (!empty($patient_account_no) ? $patient_account_no : ''); ?>" name="patient_account_no" class="inbox_line3" size="20" />
								</td>
                                <td class="b_line label" align="left" valign="top" width="13"></td>
								<td valign="top" width="30%">
									<span class="num">27.</span>
									Accept Assignment?
									<br />
									<span class="small_cap">(For govt. claims, see back)</span>
									<br />
									<input type="radio" name="accept_assignment" value="Yes" <?php if (isOptionSelected($accept_assignment) || $accept_assignment == "A") echo " checked";?> />
									YES
									&nbsp;&nbsp;&nbsp;
									<input type="radio" name="accept_assignment" value="No" <?php if (!isOptionSelected($accept_assignment) || $accept_assignment == "C") echo " checked";?> />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" colspan="2" height="100%">

<!-- START DOLLAR BOXES 28,29,30 -->
<table width="100%" cellpadding="1" cellspacing="1" border="0" height="100%">
  <tr>
    <td valign="top" width="33%">
      <span class="num">28.</span> Total Charge<br/>
      $ <input type="text" value="<?php echo $total_charge;?>" name="total_charge" class="inbox_line3 number_field" size="15" />
    </td>
      <td class="b_line label" align="left" valign="top" width="13"></td>
    <td valign="top" width="33%">
      <span class="num">29.</span> Amount Paid<br/>
      $ <input type="text" value="<?php echo $amount_paid;?>" name="amount_paid" class="inbox_line3 number_field" size="15"/>
    </td>
      <td class="b_line label grayout" align="left" valign="top" width="13"></td>
    <td valign="top" width="33%" class="grayout">
      <span class="num">30.</span> RSVD for NUCC Use<br/>
      <input type="text" name="nucc_30" value="<?php echo  (!empty($nucc_30) ? $nucc_30 : ''); ?>" class="inbox_line3 " size="15" />
      <br/>
      <span class="small_cap">&nbsp;</span>
    </td>
  </tr>
</table>
<!-- END DOLLAR BOXES 28,29,30 -->

					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2" height="100%">
						<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="50%">
									<span class="num">31.</span>
									Signature of Physician or Supplier Including Degrees or Credentals
									<span class="small_cap">
										(I certify that the statements on the reverse apply to this bill and are made a part thereof.)
									</span>
									<br /><br />
                                    <input type="text" class="inbox_line3 grayout" size="40" disabled />
                                    <input type="hidden" name="signature_physician" value="<?= $signature_physician ?>" />
									<br /><br />
									Signed
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Date:
                                    <div style="text-align: right">
                                       <input id="physician_signed_date" name="physician_signed_date" type="text" class="field text addr tbox calendar"
                                           value="<?php echo $physician_signed_date?>" style="width:100px;"
                                           maxlength="255"
                                           onChange="validateDate('physician_signed_date');"
                                           placeholder="YYYY-MM-DD"
                                           data-date-format="Y-m-d"
                                       />
                                    </div>
								</td>
                                <td class="b_line label" align="left" valign="top" width="13"></td>
								<td valign="top" width="50%">
									<span class="num">32.</span>
									Service Facility Location Information
                                    <input type="text" style="visibility:hidden;width:1px;" class="spacer-dont-name" />
									<table width="100%" cellpadding="1" cellspacing="1" border="0">
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Name:</span>
											</td>

											<td valign="top" width="90%" colspan="2">
                                                <input type="text" value="<?= $service_facility_info_name ?>" name="service_facility_info_name" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Address:</span>
											</td>
											<td valign="top" width="90%" colspan="2">
                                                <input type="text" value="<?= $service_facility_info_address ?>" name="service_facility_info_address" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
                                            <td valign="top">
                                                <span class="small_cap">City/State/Zip</span>
                                            </td>
                                            <td valign="top" colspan="2">
                                                <input type="text" name="service_facility_info[city]" class="inbox_line3 inbox-third"
                                                    placeholder="City"
                                                    value="<?= $service_facility_info['city'] ?>"
                                                    />
                                                <select name="service_facility_info[state]">
                                                    <option></option>
                                                    <?php foreach (stateList() as $stateCode=>$stateName) { ?>
                                                        <option value="<?= $stateCode ?>"
                                                            <?= ($service_facility_info['stateCode'] == $stateCode ? 'selected' : '') ?>>
                                                            <?= "$stateCode - $stateName" ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <input type="text" name="service_facility_info[zip]" class="inbox_line3 inbox-third"
                                                    placeholder="Zip"
                                                    value="<?= $service_facility_info['zip'] ?>"
                                                    />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" width="40%">
                                                <span class="num_a">
                                                    a.
                                                </span>
                                                <input type="text" value="<?= $service_info_a ?>"
                                                    name="service_info_a" class="inbox_line3" size="15" />
                                            </td>
                                            <td>
                                                <span class="num_a">
                                                    b.
                                                </span>
                                                <select name="service_info_dd" class="inbox_line3" style="width:50px;">
                                                    <option value=""></option>
                                                    <?php foreach ($qualifiers as $qualifier) { ?>
                                                        <option value="<?= $qualifier['qualifierid'] ?>"
                                                            <?= $service_info_dd == $qualifier['qualifierid'] ? 'selected' : '' ?>>
                                                            <?= st($qualifier['qualifier']) ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <input type="text" value="<?= htmlspecialchars($service_info_b_other) ?>"
                                                    name="service_info_b_other" class="inbox_line3 inbox-half" size="15" />
                                            </td>
                                        </tr>
                                    </table>
								</td>
							</tr>
						</table>
					</td>

					<td valign="top" >
                        <table width="100%" cellpadding="1" cellspacing="1" border="0">
                            <tr>
                                <td colspan="3" width="50%">
                                    <span class="num">33.</span>
                                    Billing Provider Info & Ph#
                                </td>
                                <td>
                                    <span class="style1">
                                        (<input type="text" value="<?php echo  $billing_provider_phone_code; ?>"
                                        name="billing_provider_phone_code" size="3" class="inbox_line3 inbox-third phonecodemask" />
                                        )
                                    </span>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="text" value="<?php echo  $billing_provider_phone; ?>" name="billing_provider_phone"
                                        class="inbox_line3 inbox-half phonemask" size="13"  />
                                </td>
						    </tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Name:</span>
								</td>
								<td valign="top" width="90%" colspan="3">
                                    <input type="text" value="<?php echo ($billing_provider_name && $billing_provider_name != '')?$billing_provider_name:$practice;?>" name="billing_provider_name" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Address:</span>
								</td>
								<td valign="top" width="90%" colspan="3">
                                    <input type="text" value="<?php echo ($billing_provider_address && $billing_provider_address != '')?$billing_provider_address:$address;?>" name="billing_provider_address" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">City/State/Zip:</span>
								</td>
                                <td valign="top" colspan="3">
                                    <input type="text" name="billing_provider_info[city]" class="inbox_line3 inbox-third"
                                           placeholder="City"
                                           value="<?= $billing_provider_info['city'] ?>"
                                        />
                                    <select name="billing_provider_info[state]">
                                        <option></option>
                                        <?php foreach (stateList() as $stateCode=>$stateName) { ?>
                                            <option value="<?= $stateCode ?>"
                                                <?= ($billing_provider_info['stateCode'] == $stateCode ? 'selected' : '') ?>>
                                                <?= "$stateCode - $stateName" ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <input type="text" name="billing_provider_info[zip]" class="inbox_line3 inbox-third"
                                           placeholder="Zip"
                                           value="<?= $billing_provider_info['zip'] ?>"
                                        />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="num_a">
                                        a.
                                    </span>
                                    <input type="text" value="<?= ($billing_provider_a != '')?$billing_provider_a:(($insurancetype == '1')?$medicare_npi:$npi); ?>"
                                        name="billing_provider_a" class="inbox_line3" size="15" />
                                </td>
                                <td colspan="2">
                                    <span class="num_a">
                                        b.
                                    </span>
                                    <select name="billing_provider_dd" class="inbox_line3" style="width:50px;">
                                        <option value=""></option>
                                        <?php foreach ($qualifiers as $qualifier) { ?>
                                            <option value="<?= $qualifier['qualifierid'] ?>"
                                                <?= $billing_provider_dd == $qualifier['qualifierid'] ? 'selected' : '' ?>>
                                                <?= st($qualifier['qualifier']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <input type="text" value="<?= htmlspecialchars($billing_provider_b_other) ?>"
                                        name="billing_provider_b_other" class="inbox_line3 inbox-half" size="15" />
                                </td>
                            </tr>
                        </table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
    <?php if ($status==DSS_CLAIM_PENDING || $status==DSS_CLAIM_REJECTED) { ?>
        <?php if ($_SERVER['PHP_SELF'] != "/manage/admin/insurance_claim.php") { ?>
		<div style="float:right;">

        <?php if (
            !$isSent &&
            !in_array($status, [DSS_CLAIM_PENDING, DSS_CLAIM_SEC_PENDING, DSS_CLAIM_REJECTED, DSS_CLAIM_SEC_REJECTED])
        ) { // Based on "else if" blocks from above ?>
          <input type="submit" name="ex_pagebtn"
                <?php if($status == DSS_CLAIM_REJECTED || $status == DSS_CLAIM_SEC_REJECTED){ ?>
onclick="return confirm('This claim has been rejected. By printing this claim the status will be changed to SENT, and the rejection notification will be removed. Click OK to proceed.');"
                <?php } ?>
                value="Print Claim" />
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
          <input type="submit" name="elec_save" id="elec_save" style="display:none;" />

                <?php } elseif ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
               <?php if(($isPending || $isDispute || $isRejected) && $p_m_dss_file == '2'){ ?>
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
                WHERE userid='".$db->escape($_SESSION['docid'])."'";

  $api_r = $db->getRow($api_sql);
  if($api_r['use_eligible_api']==1){
  if($isPending){
?>
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
          <input type="submit" name="elec_save" id="elec_save" style="display:none;" />
  <?php }elseif($isRejected || $isDispute){
?>
          <input type="button" name="elec" onclick="return change_form();" value="Switch to E-File" />
  <?php
  } ?>
<?php } ?>

        <?php } ?>

               <?php }elseif(($status == DSS_CLAIM_SEC_PENDING || $status == DSS_CLAIM_SEC_REJECTED) && $s_m_dss_file == '2'){ ?>
          Mark Sent <input type="checkbox" name="status_chk" disabled="disabled" value="<?php echo DSS_CLAIM_SEC_SENT?>" checked="checked" />
                        <input type="hidden" name="status" value="<?php echo DSS_CLAIM_SEC_SENT?>" />
        <?php if (!$isSent) {  ?>
          <input type="submit" name="ex_pagebtn" value="Print Claim" />
          <!--<input type="submit" name="ex_pagebtn_elec" onclick="file_claim();return false;" value="Electronically File Claim" />-->

        <?php } ?>

               <?php } ?>
		</div>
        </div>











			<?php } ?>
                                <?php } ?>
</form>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

</body>
</html>

<script type="text/javascript">

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
      window.location = "<?php echo  $electronic_form; ?>";
    }
  }else{
    window.location = "<?php echo  $electronic_form; ?>";
  }
  return false;
}


  form_changed=false;
$('input, select').bind('change', function(){
  form_changed=true;
});

    $(document).ready(function(){
        $('#claim-form-table')
            .removeAttr('width')
            .addClass('eligibleapi claim')
            .find('td')
            .addClass('label');

        $('\
            [name="field_17a"],\
            [name="field_17a_dd"]\
        ')
            .attr('readonly', true)
            .addClass('grayout')
            .closest('td')
            .addClass('grayout');
    });
</script>
<?php

//confirm ledger transactions and make sure they haven't changed.
function confirm_ledger_trxns(){
    $db = new Db();

    $num = 0;
    $return_val = true;

    while ($num <= ($_POST['ledgercount']-1)) {
        $ledgerid = $_POST['ledgerid'.$num];
        $sql = "SELECT * "
            . "  FROM dental_ledger "
            . "WHERE "
            . " ledgerid = '".$db->escape($ledgerid) . "'";
        $query = $db->getRow($sql);

        if (!empty($query)) {
            $row = $query;

            if (
                $row['entry_date'] != $_POST['entry_date'.$num] ||
                $row['service_date'] != $_POST['service_date'.$num] ||
                $row['transaction_code'] != $_POST['transaction_code'.$num] ||
                $row['amount'] != $_POST['amount'.$num] ||
                $row['status'] == DSS_TRXN_NA
            ) {
                $return_val = false;
            }
        } else {
            $return_val = false;
        }

        $num++;
    }

    return $return_val;
}

// update and changes to ledger trxns
// (updating associated claim id and status later w/ claim form insert and update)
function update_ledger_trxns($primary_claim_id, $trxn_status) {
    $db = new Db();

    $num = 0;
    $added_ledger_ids = array();

    while ($num <= ($_POST['ledgercount']-1)) {
        $placeofservicenum =  'placeofservice'.$num;
        $emgnum = 'emg'.$num;
        $diagnosispointernum = '[service_lines]['.$num.'][diagnosis_code_pointers][0]';
        //$diagnosispointernum = 'diagnosispointer'.$num;
        $daysorunitsnum = 'daysorunits'.$num;
        $epsdtnum = 'epsdt'.$num;
        $idqualnum = 'idqual'.$num;
        $ledgeridnum = 'ledgerid'.$num;
        $modifiercodenum = 'modifiercode'.$num;
        $modifiercode2_num = 'modifiercode2_'.$num;
        $modifiercode3_num = 'modifiercode3_'.$num;
        $modifiercode4_num = 'modifiercode4_'.$num;

        $placeofservice = $db->escape($_POST[$placeofservicenum]);
        $emg = $db->escape($_POST[$emgnum]);
        $diagnosispointer = $db->escape($_POST['service_lines'][$num]['diagnosis_code_pointers'][0]);
        $daysorunits = $db->escape($_POST[$daysorunitsnum]);
        $epsdt = $db->escape($_POST[$epsdtnum]);
        $idqual = $db->escape($_POST[$idqualnum]);
        $modifiercode = $db->escape($_POST[$modifiercodenum]);
        $modifiercode2 = $db->escape($_POST[$modifiercode2_num]);
        $modifiercode3 = $db->escape($_POST[$modifiercode3_num]);
        $modifiercode4 = $db->escape($_POST[$modifiercode4_num]);
        $ledgerid = $db->escape($_POST[$ledgeridnum]);

        array_push($added_ledger_ids, $ledgerid);

        $sql = "UPDATE "
            . "  dental_ledger "
            . "SET "
            . "  `placeofservice` = '$placeofservice', "
            . "  `emg` = '$emg', "
            . "  `diagnosispointer` = '$diagnosispointer', "
            . "  `daysorunits` = '$daysorunits', "
            . "  `epsdt` = '$epsdt', "
            . "  `idqual` = '$idqual', "
            . "  `modcode` = '$modifiercode', "
            . "  `modcode2` = '$modifiercode2', "
            . "  `modcode3` = '$modifiercode3', "
            . "  `modcode4` = '$modifiercode4', "
            . "  `status` = '$trxn_status', "
            . "  `primary_claim_id` = '$primary_claim_id' "
            . "WHERE "
            . "  `ledgerid` = '$ledgerid'";
        $query = $db->query($sql);

        $num++;
    }

    // Ids are already escaped
    $ledger_ids = "'" . join("', '", $added_ledger_ids) . "'";
    $upsql = "SELECT COUNT(*) as num_ledger from dental_ledger WHERE primary_claim_id='".$db->escape($primary_claim_id)."' AND ledgerid NOT IN (".$ledger_ids.")";

    $upr = $db->getRow($upsql);

    if ($upr['num_ledger'] > 0) {
        $prod_s = "SELECT producer FROM dental_insurance WHERE insuranceid='".$db->escape($primary_claim_id)."'";

        $prod_r = $db->getRow($prod_s);
        $claim_producer = $prod_r['producer'];
        $s = "SELECT insuranceid from dental_insurance where producer = '".$db->escape($claim_producer)."' AND patientid='".$db->escape($_GET['pid'])."' AND status='".DSS_CLAIM_PENDING."' LIMIT 1";
        $q = $db->getRow($s);

        if (!empty($q)) {
            $r = $q;
            $claim_id = $r['insuranceid'];
        } else {
            $claim_id = create_claim($_GET['pid'], $claim_producer);
        }

        $update_sql = "UPDATE dental_ledger set primary_claim_id='".$claim_id."' WHERE primary_claim_id='".$primary_claim_id."' AND ledgerid NOT IN (".$ledger_ids.")";
        $db->query($update_sql);
    }
}

/**
 * Auxiliary function to encapsulate the save logic
 *
 * The $formerStatus status can be determined from the $claimId, but we take the "lazy load" approach and reuse
 * the value already determined before calling this function.
 *
 * @param int   $claimId
 * @param int   $patientId
 * @param array $claimData
 * @param int   $formerStatus
 * @return int
 */
function savePaperClaimForm ($claimId, $patientId, $claimData, $formerStatus) {
    $db = new Db();

    $claimId = intval($claimId);
    $patientId = intval($patientId);
    $isNewClaim = !$claimId;

    $isFormerPrimary = ClaimFormData::isPrimary($formerStatus);
    $isFormerPending = ClaimFormData::isStatus('pending', $formerStatus);
    $isFormerRejected = ClaimFormData::isStatus('rejected', $formerStatus);

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
    $producer = !empty($_SESSION['userid']) ? intval($_SESSION['userid']) : $docId;

    // Put POST values into variables
    $pica1 = $claimData['pica1'];
    $pica2 = $claimData['pica2'];
    $pica3 = $claimData['pica3'];
    $insurance_type = $claimData['insurance_type'];
    $other_insurance_type = $claimData['other_insurance_type'];
    $patient_lastname = $claimData['patient_lastname'];
    $patient_firstname = $claimData['patient_firstname'];
    $patient_middle = $claimData['patient_middle'];
    //we need to convert the DOB from mm-dd-yyyy to YYYY-MM-dd
    $patient_dob = dateFormat($claimData['patient_dob'], false);
    $patient_sex = $claimData['patient_sex'];
    $patient_address = $claimData['patient_address'];
    $patient_city = $claimData['patient_city'];
    $patient_state = $claimData['patient_state'];
    $patient_status = !empty($claimData['patient_status']) ? $claimData['patient_status'] : '';
    $work_status = !empty($claimData['work_status']) ? $claimData['work_status'] : '';
    $current_qual = !empty($claimData['current_qual']) ? $claimData['current_qual'] : '';
    $same_illness_qual = !empty($claimData['same_illness_qual']) ? $claimData['same_illness_qual'] : '';
    $patient_zip = $claimData['patient_zip'];
    list($patient_phone_code, $patient_phone) =
        parsePhoneNumber($claimData['patient_phone_code'], $claimData['patient_phone']);
    $insured_id_number = $claimData['insured_id_number'];
    $insured_firstname = $claimData['insured_firstname'];
    $insured_lastname = $claimData['insured_lastname'];
    $insured_middle = $claimData['insured_middle'];
    $patient_relation_insured = $claimData['patient_relation_insured'];
    $insured_address = $claimData['insured_address'];
    $insured_state = $claimData['insured_state'];
    $insured_city = $claimData['insured_city'];
    $insured_zip = $claimData['insured_zip'];
    list($insured_phone_code, $insured_phone) =
        parsePhoneNumber($claimData['insured_phone_code'], $claimData['insured_phone']);
    $other_insured_id_number = $claimData['other_insured_id_number'];
    $other_insured_firstname = $claimData['other_insured_firstname'];
    $other_insured_lastname = $claimData['other_insured_lastname'];
    $other_insured_middle = $claimData['other_insured_middle'];
    $employment = !empty($claimData['employment']) ? $claimData['employment'] : '';
    $auto_accident = !empty($claimData['auto_accident']) ? $claimData['auto_accident'] : '';
    $auto_accident_place = $claimData['auto_accident_place'];
    $other_accident = !empty($claimData['other_accident']) ? $claimData['other_accident'] : '';
    $insured_policy_group_feca = $claimData['insured_policy_group_feca'];
    $other_insured_policy_group_feca = $claimData['other_insured_policy_group_feca'];
    $responsibility_sequence =
        !empty($claimData['responsibility_sequence']) ? $claimData['responsibility_sequence'] : '';
    //we need to convert the DOB from mm-dd-yyyy to YYYY-MM-dd
    $insured_dob = dateFormat($claimData['insured_dob'], false);
    $insured_sex = $claimData['insured_sex'];
    $other_insured_dob = dateFormat($claimData['other_insured_dob'], false);
    $other_insured_sex = !empty($claimData['other_insured_sex']) ? $claimData['other_insured_sex'] : '';
    $insured_employer_school_name =
        !empty($claimData['insured_employer_school_name']) ? $claimData['insured_employer_school_name'] : '';
    $other_insured_employer_school_name =
        !empty($claimData['other_insured_employer_school_name']) ? $claimData['other_insured_employer_school_name'] : '';
    $insured_insurance_plan = $claimData['insured_insurance_plan'];
    $other_insured_insurance_plan = $claimData['other_insured_insurance_plan'];
    $reserved_local_use = !empty($claimData['reserved_local_use']) ? $claimData['reserved_local_use'] : '';
    $another_plan = $claimData['another_plan'];
    $patient_signature = $claimData['patient_signature'];
    $patient_signed_date = $claimData['patient_signed_date'];
    $insured_signature = $claimData['insured_signature'];
    $date_current = $claimData['date_current'];
    $date_same_illness = $claimData['date_same_illness'];
    $unable_date_from = $claimData['unable_date_from'];
    $unable_date_to = $claimData['unable_date_to'];
    $name_referring_provider_qualifier = $claimData['name_referring_provider_qualifier'];
    $referring_provider = $claimData['referring_provider'];
    $field_17a_dd = $claimData['field_17a_dd'];
    $field_17a = $claimData['field_17a'];
    $field_17b = $claimData['field_17b'];
    $hospitalization_date_from = $claimData['hospitalization_date_from'];
    $hospitalization_date_to = $claimData['hospitalization_date_to'];
    $reserved_local_use1 = $claimData['reserved_local_use1'];
    $outside_lab = !empty($claimData['outside_lab']) ? $claimData['outside_lab'] : '';
    $s_charges = $claimData['s_charges'];
    $diagnosis_1 = !empty($claimData['diagnosis_1']) ? $claimData['diagnosis_1'] : '';
    $diagnosis_2 = !empty($claimData['diagnosis_2']) ? $claimData['diagnosis_2'] : '';
    $diagnosis_3 = !empty($claimData['diagnosis_3']) ? $claimData['diagnosis_3'] : '';
    $diagnosis_4 = !empty($claimData['diagnosis_4']) ? $claimData['diagnosis_4'] : '';

    $icd_ind = $claimData['icd_ind'];

    $diagnosis_a = $claimData['diagnosis_a'];
    $diagnosis_b = $claimData['diagnosis_b'];
    $diagnosis_c = $claimData['diagnosis_c'];
    $diagnosis_d = $claimData['diagnosis_d'];
    $diagnosis_e = $claimData['diagnosis_e'];
    $diagnosis_f = $claimData['diagnosis_f'];
    $diagnosis_g = $claimData['diagnosis_g'];
    $diagnosis_h = $claimData['diagnosis_h'];
    $diagnosis_i = $claimData['diagnosis_i'];
    $diagnosis_j = $claimData['diagnosis_j'];
    $diagnosis_k = $claimData['diagnosis_k'];
    $diagnosis_l = $claimData['diagnosis_l'];
    $medicaid_resubmission_code =
        (!empty($claimData['medicaid_resubmission_code']) ? $claimData['medicaid_resubmission_code'] : '');
    $resubmission_code_fill = $claimData['resubmission_code_fill'];
    $original_ref_no = $claimData['original_ref_no'];
    $prior_authorization_number = $claimData['prior_authorization_number'];
    $service_date1_from = !empty($claimData['service_date1_from']) ? $claimData['service_date1_from'] : '';
    $service_date1_to = !empty($claimData['service_date1_to']) ? $claimData['service_date1_to'] : '';
    $place_of_service1 = !empty($claimData['place_of_service1']) ? $claimData['place_of_service1'] : '';
    $emg1 = !empty($claimData['emg1']) ? $claimData['emg1'] : '';
    $cpt_hcpcs1 = !empty($claimData['cpt_hcpcs1']) ? $claimData['cpt_hcpcs1'] : '';
    $modifier1_1 = !empty($claimData['modifier1_1']) ? $claimData['modifier1_1'] : '';
    $modifier1_2 = !empty($claimData['modifier1_2']) ? $claimData['modifier1_2'] : '';
    $modifier1_3 = !empty($claimData['modifier1_3']) ? $claimData['modifier1_3'] : '';
    $modifier1_4 = !empty($claimData['modifier1_4']) ? $claimData['modifier1_4'] : '';
    $diagnosis_pointer1 = !empty($claimData['diagnosis_pointer1']) ? $claimData['diagnosis_pointer1'] : '';
    $s_charges1_1 = !empty($claimData['s_charges1_1']) ? $claimData['s_charges1_1'] : '';
    $s_charges1_2 = !empty($claimData['s_charges1_2']) ? $claimData['s_charges1_2'] : '';
    $days_or_units1 = !empty($claimData['days_or_units1']) ? $claimData['days_or_units1'] : '';
    $epsdt_family_plan1 = !empty($claimData['epsdt_family_plan1']) ? $claimData['epsdt_family_plan1'] : '';
    $id_qua1 = !empty($claimData['id_qua1']) ? $claimData['id_qua1'] : '';
    $rendering_provider_id1 = !empty($claimData['rendering_provider_id1']) ? $claimData['rendering_provider_id1'] : '';
    $service_date2_from = !empty($claimData['service_date2_from']) ? $claimData['service_date2_from'] : '';
    $service_date2_to = !empty($claimData['service_date2_to']) ? $claimData['service_date2_to'] : '';
    $place_of_service2 = !empty($claimData['place_of_service2']) ? $claimData['place_of_service2'] : '';
    $emg2 = !empty($claimData['emg2']) ? $claimData['emg2'] : '';
    $cpt_hcpcs2 = !empty($claimData['cpt_hcpcs2']) ? $claimData['cpt_hcpcs2'] : '';
    $modifier2_1 = !empty($claimData['modifier2_1']) ? $claimData['modifier2_1'] : '';
    $modifier2_2 = !empty($claimData['modifier2_2']) ? $claimData['modifier2_2'] : '';
    $modifier2_3 = !empty($claimData['modifier2_3']) ? $claimData['modifier2_3'] : '';
    $modifier2_4 = !empty($claimData['modifier2_4']) ? $claimData['modifier2_4'] : '';
    $diagnosis_pointer2 = !empty($claimData['diagnosis_pointer2']) ? $claimData['diagnosis_pointer2'] : '';
    $s_charges2_1 = !empty($claimData['s_charges2_1']) ? $claimData['s_charges2_1'] : '';
    $s_charges2_2 = !empty($claimData['s_charges2_2']) ? $claimData['s_charges2_2'] : '';
    $days_or_units2 = !empty($claimData['days_or_units2']) ? $claimData['days_or_units2'] : '';
    $epsdt_family_plan2 = !empty($claimData['epsdt_family_plan2']) ? $claimData['epsdt_family_plan2'] : '';
    $id_qua2 = !empty($claimData['id_qua2']) ? $claimData['id_qua2'] : '';
    $rendering_provider_id2 = !empty($claimData['rendering_provider_id2']) ? $claimData['rendering_provider_id2'] : '';
    $service_date3_from = !empty($claimData['service_date3_from']) ? $claimData['service_date3_from'] : '';
    $service_date3_to = !empty($claimData['service_date3_to']) ? $claimData['service_date3_to'] : '';
    $place_of_service3 = !empty($claimData['place_of_service3']) ? $claimData['place_of_service3'] : '';
    $emg3 = !empty($claimData['emg3']) ? $claimData['emg3'] : '';
    $cpt_hcpcs3 = !empty($claimData['cpt_hcpcs3']) ? $claimData['cpt_hcpcs3'] : '';
    $modifier3_1 = !empty($claimData['modifier3_1']) ? $claimData['modifier3_1'] : '';
    $modifier3_2 = !empty($claimData['modifier3_2']) ? $claimData['modifier3_2'] : '';
    $modifier3_3 = !empty($claimData['modifier3_3']) ? $claimData['modifier3_3'] : '';
    $modifier3_4 = !empty($claimData['modifier3_4']) ? $claimData['modifier3_4'] : '';
    $diagnosis_pointer3 = !empty($claimData['diagnosis_pointer3']) ? $claimData['diagnosis_pointer3'] : '';
    $s_charges3_1 = !empty($claimData['s_charges3_1']) ? $claimData['s_charges3_1'] : '';
    $s_charges3_2 = !empty($claimData['s_charges3_2']) ? $claimData['s_charges3_2'] : '';
    $days_or_units3 = !empty($claimData['days_or_units3']) ? $claimData['days_or_units3'] : '';
    $epsdt_family_plan3 = !empty($claimData['epsdt_family_plan3']) ? $claimData['epsdt_family_plan3'] : '';
    $id_qua3 = !empty($claimData['id_qua3']) ? $claimData['id_qua3'] : '';
    $rendering_provider_id3 = !empty($claimData['rendering_provider_id3']) ? $claimData['rendering_provider_id3'] : '';
    $service_date4_from = !empty($claimData['service_date4_from']) ? $claimData['service_date4_from'] : '';
    $service_date4_to = !empty($claimData['service_date4_to']) ? $claimData['service_date4_to'] : '';
    $place_of_service4 = !empty($claimData['place_of_service4']) ? $claimData['place_of_service4'] : '';
    $emg4 = !empty($claimData['emg4']) ? $claimData['emg4'] : '';
    $cpt_hcpcs4 = !empty($claimData['cpt_hcpcs4']) ? $claimData['cpt_hcpcs4'] : '';
    $modifier4_1 = !empty($claimData['modifier4_1']) ? $claimData['modifier4_1'] : '';
    $modifier4_2 = !empty($claimData['modifier4_2']) ? $claimData['modifier4_2'] : '';
    $modifier4_3 = !empty($claimData['modifier4_3']) ? $claimData['modifier4_3'] : '';
    $modifier4_4 = !empty($claimData['modifier4_4']) ? $claimData['modifier4_4'] : '';
    $diagnosis_pointer4 = !empty($claimData['diagnosis_pointer4']) ? $claimData['diagnosis_pointer4'] : '';
    $s_charges4_1 = !empty($claimData['s_charges4_1']) ? $claimData['s_charges4_1'] : '';
    $s_charges4_2 = !empty($claimData['s_charges4_2']) ? $claimData['s_charges4_2'] : '';
    $days_or_units4 = !empty($claimData['days_or_units4']) ? $claimData['days_or_units4'] : '';
    $epsdt_family_plan4 = !empty($claimData['epsdt_family_plan4']) ? $claimData['epsdt_family_plan4'] : '';
    $id_qua4 = !empty($claimData['id_qua4']) ? $claimData['id_qua4'] : '';
    $rendering_provider_id4 = !empty($claimData['rendering_provider_id4']) ? $claimData['rendering_provider_id4'] : '';
    $service_date5_from = !empty($claimData['service_date5_from']) ? $claimData['service_date5_from'] : '';
    $service_date5_to = !empty($claimData['service_date5_to']) ? $claimData['service_date5_to'] : '';
    $place_of_service5 = !empty($claimData['place_of_service5']) ? $claimData['place_of_service5'] : '';
    $emg5 = !empty($claimData['emg5']) ? $claimData['emg5'] : '';
    $cpt_hcpcs5 = !empty($claimData['cpt_hcpcs5']) ? $claimData['cpt_hcpcs5'] : '';
    $modifier5_1 = !empty($claimData['modifier5_1']) ? $claimData['modifier5_1'] : '';
    $modifier5_2 = !empty($claimData['modifier5_2']) ? $claimData['modifier5_2'] : '';
    $modifier5_3 = !empty($claimData['modifier5_3']) ? $claimData['modifier5_3'] : '';
    $modifier5_4 = !empty($claimData['modifier5_4']) ? $claimData['modifier5_4'] : '';
    $diagnosis_pointer5 = !empty($claimData['diagnosis_pointer5']) ? $claimData['diagnosis_pointer5'] : '';
    $s_charges5_1 = !empty($claimData['s_charges5_1']) ? $claimData['s_charges5_1'] : '';
    $s_charges5_2 = !empty($claimData['s_charges5_2']) ? $claimData['s_charges5_2'] : '';
    $days_or_units5 = !empty($claimData['days_or_units5']) ? $claimData['days_or_units5'] : '';
    $epsdt_family_plan5 = !empty($claimData['epsdt_family_plan5']) ? $claimData['epsdt_family_plan5'] : '';
    $id_qua5 = !empty($claimData['id_qua5']) ? $claimData['id_qua5'] : '';
    $rendering_provider_id5 = !empty($claimData['rendering_provider_id5']) ? $claimData['rendering_provider_id5'] : '';
    $service_date6_from = !empty($claimData['service_date6_from']) ? $claimData['service_date6_from'] : '';
    $service_date6_to = !empty($claimData['service_date6_to']) ? $claimData['service_date6_to'] : '';
    $place_of_service6 = !empty($claimData['place_of_service6']) ? $claimData['place_of_service6'] : '';
    $emg6 = !empty($claimData['emg6']) ? $claimData['emg6'] : '';
    $cpt_hcpcs6 = !empty($claimData['cpt_hcpcs6']) ? $claimData['cpt_hcpcs6'] : '';
    $modifier6_1 = !empty($claimData['modifier6_1']) ? $claimData['modifier6_1'] : '';
    $modifier6_2 = !empty($claimData['modifier6_2']) ? $claimData['modifier6_2'] : '';
    $modifier6_3 = !empty($claimData['modifier6_3']) ? $claimData['modifier6_3'] : '';
    $modifier6_4 = !empty($claimData['modifier6_4']) ? $claimData['modifier6_4'] : '';
    $diagnosis_pointer6 = !empty($claimData['diagnosis_pointer6']) ? $claimData['diagnosis_pointer6'] : '';
    $s_charges6_1 = !empty($claimData['s_charges6_1']) ? $claimData['s_charges6_1'] : '';
    $s_charges6_2 = !empty($claimData['s_charges6_2']) ? $claimData['s_charges6_2'] : '';
    $days_or_units6 = !empty($claimData['days_or_units6']) ? $claimData['days_or_units6'] : '';
    $epsdt_family_plan6 = !empty($claimData['epsdt_family_plan6']) ? $claimData['epsdt_family_plan6'] : '';
    $id_qua6 = !empty($claimData['id_qua6']) ? $claimData['id_qua6'] : '';
    $rendering_provider_id6 = !empty($claimData['rendering_provider_id6']) ? $claimData['rendering_provider_id6'] : '';
    $federal_tax_id_number = !empty($claimData['federal_tax_id_number']) ? $claimData['federal_tax_id_number'] : '';
    $ssn = !empty($claimData['ssnein']) && $claimData['ssnein'] == 'ssn' ? 1 : '';
    $ein = !empty($claimData['ssnein']) && $claimData['ssnein'] == 'ein' ? 1 : '';
    $patient_account_no = $claimData['patient_account_no'];
    $accept_assignment = $claimData['accept_assignment'];
    $total_charge = $claimData['total_charge'];
    $amount_paid = $claimData['amount_paid'];
    $balance_due = !empty($claimData['balance_due']) ? $claimData['balance_due'] : '';
    // In Paper form, this is a placeholder
    // $signature_physician = $claimData['signature_physician'];
    $physician_signed_date = dateFormat($claimData['physician_signed_date'], false);
    $service_facility_info_name = $claimData['service_facility_info_name'];
    $service_facility_info_address = $claimData['service_facility_info_address'];

    $service_facility_info_city = $claimData['service_facility_info']['city'] . ' ' .
        $claimData['service_facility_info']['state'] . ' ' . $claimData['service_facility_info']['zip'];

    $service_info_a = $claimData['service_info_a'];
    $service_info_dd = $claimData['service_info_dd'];
    $service_info_b_other = $claimData['service_info_b_other'];
    list($billing_provider_phone_code, $billing_provider_phone) = parsePhoneNumber(
        $claimData['billing_provider_phone_code'], $claimData['billing_provider_phone']
    );
    $billing_provider_name = $claimData['billing_provider_name'];
    $billing_provider_address = $claimData['billing_provider_address'];
    $billing_provider_city = $claimData['billing_provider_info']['city'] . ' ' .
        $claimData['billing_provider_info']['state'] . ' ' . $claimData['billing_provider_info']['zip'];
    $billing_provider_a = $claimData['billing_provider_a'];
    $billing_provider_dd = $claimData['billing_provider_dd'];
    $billing_provider_b_other = $claimData['billing_provider_b_other'];
    $reject_reason = !empty($claimData['reject_reason']) ? $claimData['reject_reason'] : '';
    $nucc_8a = $claimData['nucc_8a'];
    $nucc_8b = $claimData['nucc_8b'];
    $nucc_9a = !empty($claimData['nucc_9a']) ? $claimData['nucc_9a'] : '';
    $nucc_9b = $claimData['nucc_9b'];
    $claim_codes = $claimData['claim_codes'];
    $other_claim_id = $claimData['other_claim_id'];
    $nucc_9c = $claimData['nucc_9c'];
    $nucc_30 = $claimData['nucc_30'];

    $insurance_type_arr = $insurance_type;

    if ($insurance_type_arr != '') {
        $insurance_type_arr = '~'.$insurance_type_arr.'~';
    }

    $patient_status_arr = '~'.$patient_status.'~'.$work_status.'~';

    // Insert new claim into dental_insurance table
    if ($isNewClaim) {
        $ins_sql = "INSERT INTO dental_insurance SET
            patientid = '".$db->escape($_GET['pid'])."',
            pica1 = '".$db->escape($pica1)."',
            pica2 = '".$db->escape($pica2)."',
            pica3 = '".$db->escape($pica3)."',
            insurance_type = '".$db->escape($insurance_type)."',
            other_insurance_type = '".$db->escape($other_insurance_type)."',
            insured_id_number = '".$db->escape($insured_id_number)."',
            patient_lastname = '".$db->escape($patient_lastname)."',
            patient_firstname = '".$db->escape($patient_firstname)."',
            patient_middle = '".$db->escape($patient_middle)."',
            patient_dob = '".$db->escape($patient_dob)."',
            patient_sex = '".$db->escape($patient_sex)."',
            insured_firstname = '".$db->escape($insured_firstname)."',
            insured_lastname = '".$db->escape($insured_lastname)."',
            insured_middle = '".$db->escape($insured_middle)."',
            patient_address = '".$db->escape($patient_address)."',
            patient_relation_insured = '".$db->escape($patient_relation_insured)."',
            patient_city = '".$db->escape($patient_city)."',
            patient_state = '".$db->escape($patient_state)."',
            patient_status = '".$db->escape($patient_status_arr)."',
            patient_zip = '".$db->escape($patient_zip)."',
            patient_phone_code = '".$db->escape($patient_phone_code)."',
            patient_phone = '".$db->escape($patient_phone)."',
            insured_address = '".$db->escape($insured_address)."',
            insured_city = '".$db->escape($insured_city)."',
            insured_state = '".$db->escape($insured_state)."',
            insured_zip = '".$db->escape($insured_zip)."',
            insured_phone_code = '".$db->escape($insured_phone_code)."',
            insured_phone = '".$db->escape($insured_phone)."',
            other_insured_id_number = '".$db->escape($other_insured_id_number)."',
            other_insured_firstname = '".$db->escape($other_insured_firstname)."',
            other_insured_lastname = '".$db->escape($other_insured_lastname)."',
            other_insured_middle = '".$db->escape($other_insured_middle)."',
            employment = '".$db->escape($employment)."',
            auto_accident = '".$db->escape($auto_accident)."',
            auto_accident_place = '".$db->escape($auto_accident_place)."',
            other_accident = '".$db->escape($other_accident)."',
            insured_policy_group_feca = '".$db->escape($insured_policy_group_feca)."',
            other_insured_policy_group_feca = '".$db->escape($other_insured_policy_group_feca)."',
            responsibility_sequence = '".$db->escape($responsibility_sequence)."',
            insured_dob = '".$db->escape($insured_dob)."',
            insured_sex = '".$db->escape($insured_sex)."',
            other_insured_dob = '".$db->escape($other_insured_dob)."',
            other_insured_sex = '".$db->escape($other_insured_sex)."',
            insured_employer_school_name = '".$db->escape($insured_employer_school_name)."',
            other_insured_employer_school_name = '".$db->escape($other_insured_employer_school_name)."',
            insured_insurance_plan = '".$db->escape($insured_insurance_plan)."',
            other_insured_insurance_plan = '".$db->escape($other_insured_insurance_plan)."',
            reserved_local_use = '".$db->escape($reserved_local_use)."',
            another_plan = '".$db->escape($another_plan)."',
            patient_signature = '".$patient_signature."',
            patient_signed_date = '".$db->escape($patient_signed_date)."',
            insured_signature = '".$db->escape($insured_signature)."',
            date_current = '".$db->escape($date_current)."',
            current_qual = '".$db->escape($current_qual)."',
            same_illness_qual = '".$db->escape($same_illness_qual)."',
            date_same_illness = '".$db->escape($date_same_illness)."',
            unable_date_from = '".$db->escape($unable_date_from)."',
            unable_date_to = '".$db->escape($unable_date_to)."',
            name_referring_provider_qualifier = '".$db->escape($name_referring_provider_qualifier)."',
            referring_provider = '".$db->escape($referring_provider)."',
            field_17a_dd = '".$db->escape($field_17a_dd)."',
            field_17a = '".$db->escape($field_17a)."',
            field_17b = '".$db->escape($field_17b)."',
            hospitalization_date_from = '".$db->escape($hospitalization_date_from)."',
            hospitalization_date_to = '".$db->escape($hospitalization_date_to)."',
            reserved_local_use1 = '".$db->escape($reserved_local_use1)."',
            outside_lab = '".$db->escape($outside_lab)."',
            s_charges = '".$db->escape($s_charges)."',
            diagnosis_1 = '".$db->escape($diagnosis_1)."',
            diagnosis_2 = '".$db->escape($diagnosis_2)."',
            diagnosis_3 = '".$db->escape($diagnosis_3)."',
            diagnosis_4 = '".$db->escape($diagnosis_4)."',
            icd_ind = '".$db->escape($icd_ind)."',
            diagnosis_a = '".$db->escape($diagnosis_a)."',
            diagnosis_b = '".$db->escape($diagnosis_b)."',
            diagnosis_c = '".$db->escape($diagnosis_c)."',
            diagnosis_d = '".$db->escape($diagnosis_d)."',
            diagnosis_e = '".$db->escape($diagnosis_e)."',
            diagnosis_f = '".$db->escape($diagnosis_f)."',
            diagnosis_g = '".$db->escape($diagnosis_g)."',
            diagnosis_h = '".$db->escape($diagnosis_h)."',
            diagnosis_i = '".$db->escape($diagnosis_i)."',
            diagnosis_j = '".$db->escape($diagnosis_j)."',
            diagnosis_k = '".$db->escape($diagnosis_k)."',
            diagnosis_l = '".$db->escape($diagnosis_l)."',
            medicaid_resubmission_code = '".$db->escape($medicaid_resubmission_code)."',
            resubmission_code_fill = '".$db->escape($resubmission_code_fill)."',
            original_ref_no = '".$db->escape($original_ref_no)."',
            prior_authorization_number = '".$db->escape($prior_authorization_number)."',
            service_date1_from = '".$db->escape($service_date1_from)."',
            service_date1_to = '".$db->escape($service_date1_to)."',
            place_of_service1 = '".$db->escape($place_of_service1)."',
            emg1 = '".$db->escape($emg1)."',
            cpt_hcpcs1 = '".$db->escape($cpt_hcpcs1)."',
            modifier1_1 = '".$db->escape($modifier1_1)."',
            modifier1_2 = '".$db->escape($modifier1_2)."',
            modifier1_3 = '".$db->escape($modifier1_3)."',
            modifier1_4 = '".$db->escape($modifier1_4)."',
            diagnosis_pointer1 = '".$db->escape($diagnosis_pointer1)."',
            s_charges1_1 = '".$db->escape($s_charges1_1)."',
            s_charges1_2 = '".$db->escape($s_charges1_2)."',
            days_or_units1 = '".$db->escape($days_or_units1)."',
            epsdt_family_plan1 = '".$db->escape($epsdt_family_plan1)."',
            id_qua1 = '".$db->escape($id_qua1)."',
            rendering_provider_id1 = '".$db->escape($rendering_provider_id1)."',
            service_date2_from = '".$db->escape($service_date2_from)."',
            service_date2_to = '".$db->escape($service_date2_to)."',
            place_of_service2 = '".$db->escape($place_of_service2)."',
            emg2 = '".$db->escape($emg2)."',
            cpt_hcpcs2 = '".$db->escape($cpt_hcpcs2)."',
            modifier2_1 = '".$db->escape($modifier2_1)."',
            modifier2_2 = '".$db->escape($modifier2_2)."',
            modifier2_3 = '".$db->escape($modifier2_3)."',
            modifier2_4 = '".$db->escape($modifier2_4)."',
            diagnosis_pointer2 = '".$db->escape($diagnosis_pointer2)."',
            s_charges2_1 = '".$db->escape($s_charges2_1)."',
            s_charges2_2 = '".$db->escape($s_charges2_2)."',
            days_or_units2 = '".$db->escape($days_or_units2)."',
            epsdt_family_plan2 = '".$db->escape($epsdt_family_plan2)."',
            id_qua2 = '".$db->escape($id_qua2)."',
            rendering_provider_id2 = '".$db->escape($rendering_provider_id2)."',
            service_date3_from = '".$db->escape($service_date3_from)."',
            service_date3_to = '".$db->escape($service_date3_to)."',
            place_of_service3 = '".$db->escape($place_of_service3)."',
            emg3 = '".$db->escape($emg3)."',
            cpt_hcpcs3 = '".$db->escape($cpt_hcpcs3)."',
            modifier3_1 = '".$db->escape($modifier3_1)."',
            modifier3_2 = '".$db->escape($modifier3_2)."',
            modifier3_3 = '".$db->escape($modifier3_3)."',
            modifier3_4 = '".$db->escape($modifier3_4)."',
            diagnosis_pointer3 = '".$db->escape($diagnosis_pointer3)."',
            s_charges3_1 = '".$db->escape($s_charges3_1)."',
            s_charges3_2 = '".$db->escape($s_charges3_2)."',
            days_or_units3 = '".$db->escape($days_or_units3)."',
            epsdt_family_plan3 = '".$db->escape($epsdt_family_plan3)."',
            id_qua3 = '".$db->escape($id_qua3)."',
            rendering_provider_id3 = '".$db->escape($rendering_provider_id3)."',
            service_date4_from = '".$db->escape($service_date4_from)."',
            service_date4_to = '".$db->escape($service_date4_to)."',
            place_of_service4 = '".$db->escape($place_of_service4)."',
            emg4 = '".$db->escape($emg4)."',
            cpt_hcpcs4 = '".$db->escape($cpt_hcpcs4)."',
            modifier4_1 = '".$db->escape($modifier4_1)."',
            modifier4_2 = '".$db->escape($modifier4_2)."',
            modifier4_3 = '".$db->escape($modifier4_3)."',
            modifier4_4 = '".$db->escape($modifier4_4)."',
            diagnosis_pointer4 = '".$db->escape($diagnosis_pointer4)."',
            s_charges4_1 = '".$db->escape($s_charges4_1)."',
            s_charges4_2 = '".$db->escape($s_charges4_2)."',
            days_or_units4 = '".$db->escape($days_or_units4)."',
            epsdt_family_plan4 = '".$db->escape($epsdt_family_plan4)."',
            id_qua4 = '".$db->escape($id_qua4)."',
            rendering_provider_id4 = '".$db->escape($rendering_provider_id4)."',
            service_date5_from = '".$db->escape($service_date5_from)."',
            service_date5_to = '".$db->escape($service_date5_to)."',
            place_of_service5 = '".$db->escape($place_of_service5)."',
            emg5 = '".$db->escape($emg5)."',
            cpt_hcpcs5 = '".$db->escape($cpt_hcpcs5)."',
            modifier5_1 = '".$db->escape($modifier5_1)."',
            modifier5_2 = '".$db->escape($modifier5_2)."',
            modifier5_3 = '".$db->escape($modifier5_3)."',
            modifier5_4 = '".$db->escape($modifier5_4)."',
            diagnosis_pointer5 = '".$db->escape($diagnosis_pointer5)."',
            s_charges5_1 = '".$db->escape($s_charges5_1)."',
            s_charges5_2 = '".$db->escape($s_charges5_2)."',
            days_or_units5 = '".$db->escape($days_or_units5)."',
            epsdt_family_plan5 = '".$db->escape($epsdt_family_plan5)."',
            id_qua5 = '".$db->escape($id_qua5)."',
            rendering_provider_id5 = '".$db->escape($rendering_provider_id5)."',
            service_date6_from = '".$db->escape($service_date6_from)."',
            service_date6_to = '".$db->escape($service_date6_to)."',
            place_of_service6 = '".$db->escape($place_of_service6)."',
            emg6 = '".$db->escape($emg6)."',
            cpt_hcpcs6 = '".$db->escape($cpt_hcpcs6)."',
            modifier6_1 = '".$db->escape($modifier6_1)."',
            modifier6_2 = '".$db->escape($modifier6_2)."',
            modifier6_3 = '".$db->escape($modifier6_3)."',
            modifier6_4 = '".$db->escape($modifier6_4)."',
            diagnosis_pointer6 = '".$db->escape($diagnosis_pointer6)."',
            s_charges6_1 = '".$db->escape($s_charges6_1)."',
            s_charges6_2 = '".$db->escape($s_charges6_2)."',
            days_or_units6 = '".$db->escape($days_or_units6)."',
            epsdt_family_plan6 = '".$db->escape($epsdt_family_plan6)."',
            id_qua6 = '".$db->escape($id_qua6)."',
            rendering_provider_id6 = '".$db->escape($rendering_provider_id6)."',
            federal_tax_id_number = '".$db->escape($federal_tax_id_number)."',
            ssn = '".$db->escape($ssn)."',
            ein = '".$db->escape($ein)."',
            patient_account_no = '".$db->escape($patient_account_no)."',
            accept_assignment = '".$db->escape($accept_assignment)."',
            total_charge = '".$db->escape($total_charge)."',
            amount_paid = '".$db->escape($amount_paid)."',
            balance_due = '".$db->escape($balance_due)."',
            nucc_8a = '".$db->escape($nucc_8a)."',
            nucc_8b = '".$db->escape($nucc_8b)."',
            nucc_9a = '".$db->escape($nucc_9a)."',
            nucc_9b = '".$db->escape($nucc_9b)."',
            claim_codes = '".$db->escape($claim_codes)."',
            other_claim_id = '".$db->escape($other_claim_id)."',
            nucc_9c = '".$db->escape($nucc_9c)."',
            nucc_30 = '".$db->escape($nucc_30)."',
            signature_physician = '".$db->escape($signature_physician)."',
            physician_signed_date = '".$db->escape($physician_signed_date)."',
            service_facility_info_name = '".$db->escape($service_facility_info_name)."',
            service_facility_info_address = '".$db->escape($service_facility_info_address)."',
            service_facility_info_city = '".$db->escape($service_facility_info_city)."',
            service_info_a = '".$db->escape($service_info_a)."',
            service_info_dd = '".$db->escape($service_info_dd)."',
            service_info_b_other = '".$db->escape($service_info_b_other)."',
            billing_provider_phone_code = '".$db->escape($billing_provider_phone_code)."',
            billing_provider_phone = '".$db->escape($billing_provider_phone)."',
            billing_provider_name = '".$db->escape($billing_provider_name)."',
            billing_provider_address = '".$db->escape($billing_provider_address)."',
            billing_provider_city = '".$db->escape($billing_provider_city)."',
            billing_provider_a = '".$db->escape($billing_provider_a)."',
            billing_provider_dd = '".$db->escape($billing_provider_dd)."',
            billing_provider_b_other = '".$db->escape($billing_provider_b_other)."',
            p_m_eligible_payer_id = '".$p_m_eligible_payer_id."',
            p_m_eligible_payer_name = '".$db->escape($p_m_eligible_payer_name)."',
            s_m_eligible_payer_id = '".$s_m_eligible_payer_id."',
            s_m_eligible_payer_name = '".$db->escape($s_m_eligible_payer_name)."',
            status = '$status',
            userid = '".$db->escape($_SESSION['userid'])."',
            docid = '$docId',
            adddate = NOW(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";

        // get the id of the inserted claim
        $claimId = $db->getInsertId($ins_sql);

        // update the ledger trxns passed in with the form
        update_ledger_trxns($claimId, DSS_TRXN_PROCESSING);
        claim_history_update($claimId, $_SESSION['userid'], $_SESSION['adminuserid']);

        return $claimId;
    }

    $ed_sql = "UPDATE dental_insurance SET
        pica1 = '".$db->escape($pica1)."',
        pica2 = '".$db->escape($pica2)."',
        pica3 = '".$db->escape($pica3)."',
        patient_lastname = '".$db->escape($patient_lastname)."',
        patient_firstname = '".$db->escape($patient_firstname)."',
        patient_middle = '".$db->escape($patient_middle)."',
        patient_dob = '".$db->escape($patient_dob)."',
        patient_sex = '".$db->escape($patient_sex)."',
        patient_address = '".$db->escape($patient_address)."',
        patient_state = '".$db->escape($patient_state)."',
        patient_status = '".$db->escape($patient_status_arr)."',
        patient_city = '".$db->escape($patient_city)."',
        patient_zip = '".$db->escape($patient_zip)."',
        patient_phone_code = '".$db->escape($patient_phone_code)."',
        patient_phone = '".$db->escape($patient_phone)."',
        patient_relation_insured = '".$db->escape($patient_relation_insured)."',
        insurance_type = '".$db->escape($insurance_type)."',
        insured_id_number = '".$db->escape($insured_id_number)."',
        insured_firstname = '".$db->escape($insured_firstname)."',
        insured_lastname = '".$db->escape($insured_lastname)."',
        insured_middle = '".$db->escape($insured_middle)."',
        insured_address = '".$db->escape($insured_address)."',
        insured_city = '".$db->escape($insured_city)."',
        insured_state = '".$db->escape($insured_state)."',
        insured_zip = '".$db->escape($insured_zip)."',
        insured_phone_code = '".$db->escape($insured_phone_code)."',
        insured_phone = '".$db->escape($insured_phone)."',
        other_insured_id_number = '".$db->escape($other_insured_id_number)."',
        other_insured_firstname = '".$db->escape($other_insured_firstname)."',
        other_insured_lastname = '".$db->escape($other_insured_lastname)."',
        other_insured_middle = '".$db->escape($other_insured_middle)."',
        insured_policy_group_feca = '".$db->escape($insured_policy_group_feca)."',
        other_insured_policy_group_feca = '".$db->escape($other_insured_policy_group_feca)."',
        responsibility_sequence = '".$db->escape($responsibility_sequence)."',
        insured_dob = '".$db->escape($insured_dob)."',
        insured_sex = '".$db->escape($insured_sex)."',
        other_insured_dob = '".$db->escape($other_insured_dob)."',
        other_insured_sex = '".$db->escape($other_insured_sex)."',
        insured_employer_school_name = '".$db->escape($insured_employer_school_name)."',
        other_insured_employer_school_name = '".$db->escape($other_insured_employer_school_name)."',
        insured_insurance_plan = '".$db->escape($insured_insurance_plan)."',
        other_insured_insurance_plan = '".$db->escape($other_insured_insurance_plan)."',
        employment = '".$db->escape($employment)."',
        auto_accident = '".$db->escape($auto_accident)."',
        auto_accident_place = '".$db->escape($auto_accident_place)."',
        other_accident = '".$db->escape($other_accident)."',
        reserved_local_use = '".$db->escape($reserved_local_use)."',
        another_plan = '".$db->escape($another_plan)."',
        patient_signature = '".$db->escape($patient_signature)."',
        patient_signed_date = '".$db->escape($patient_signed_date)."',
        insured_signature = '".$db->escape($insured_signature)."',
        date_current = '".$db->escape($date_current)."',
        current_qual = '".$db->escape($current_qual)."',
        same_illness_qual = '".$db->escape($same_illness_qual)."',
        date_same_illness = '".$db->escape($date_same_illness)."',
        unable_date_from = '".$db->escape($unable_date_from)."',
        unable_date_to = '".$db->escape($unable_date_to)."',
        name_referring_provider_qualifier = '".$db->escape($name_referring_provider_qualifier)."',
        referring_provider = '".$db->escape($referring_provider)."',
        field_17a_dd = '".$db->escape($field_17a_dd)."',
        field_17a = '".$db->escape($field_17a)."',
        field_17b = '".$db->escape($field_17b)."',
        hospitalization_date_from = '".$db->escape($hospitalization_date_from)."',
        hospitalization_date_to = '".$db->escape($hospitalization_date_to)."',
        reserved_local_use1 = '".$db->escape($reserved_local_use1)."',
        outside_lab = '".$db->escape($outside_lab)."',
        s_charges = '".$db->escape($s_charges)."',
        diagnosis_1 = '".$db->escape($diagnosis_1)."',
        diagnosis_2 = '".$db->escape($diagnosis_2)."',
        diagnosis_3 = '".$db->escape($diagnosis_3)."',
        diagnosis_4 = '".$db->escape($diagnosis_4)."',
        icd_ind = '".$db->escape($icd_ind)."',
        diagnosis_a = '".$db->escape($diagnosis_a)."',
        diagnosis_b = '".$db->escape($diagnosis_b)."',
        diagnosis_c = '".$db->escape($diagnosis_c)."',
        diagnosis_d = '".$db->escape($diagnosis_d)."',
        diagnosis_e = '".$db->escape($diagnosis_e)."',
        diagnosis_f = '".$db->escape($diagnosis_f)."',
        diagnosis_g = '".$db->escape($diagnosis_g)."',
        diagnosis_h = '".$db->escape($diagnosis_h)."',
        diagnosis_i = '".$db->escape($diagnosis_i)."',
        diagnosis_j = '".$db->escape($diagnosis_j)."',
        diagnosis_k = '".$db->escape($diagnosis_k)."',
        diagnosis_l = '".$db->escape($diagnosis_l)."',
        medicaid_resubmission_code = '".$db->escape($medicaid_resubmission_code)."',
        resubmission_code_fill = '".$db->escape($resubmission_code_fill)."',
        original_ref_no = '".$db->escape($original_ref_no)."',
        prior_authorization_number = '".$db->escape($prior_authorization_number)."',
        service_date1_from = '".$db->escape($service_date1_from)."',
        service_date1_to = '".$db->escape($service_date1_to)."',
        place_of_service1 = '".$db->escape($place_of_service1)."',
        emg1 = '".$db->escape($emg1)."',
        cpt_hcpcs1 = '".$db->escape($cpt_hcpcs1)."',
        modifier1_1 = '".$db->escape($modifier1_1)."',
        modifier1_2 = '".$db->escape($modifier1_2)."',
        modifier1_3 = '".$db->escape($modifier1_3)."',
        modifier1_4 = '".$db->escape($modifier1_4)."',
        diagnosis_pointer1 = '".$db->escape($diagnosis_pointer1)."',
        s_charges1_1 = '".$db->escape($s_charges1_1)."',
        s_charges1_2 = '".$db->escape($s_charges1_2)."',
        days_or_units1 = '".$db->escape($days_or_units1)."',
        epsdt_family_plan1 = '".$db->escape($epsdt_family_plan1)."',
        id_qua1 = '".$db->escape($id_qua1)."',
        rendering_provider_id1 = '".$db->escape($rendering_provider_id1)."',
        service_date2_from = '".$db->escape($service_date2_from)."',
        service_date2_to = '".$db->escape($service_date2_to)."',
        place_of_service2 = '".$db->escape($place_of_service2)."',
        emg2 = '".$db->escape($emg2)."',
        cpt_hcpcs2 = '".$db->escape($cpt_hcpcs2)."',
        modifier2_1 = '".$db->escape($modifier2_1)."',
        modifier2_2 = '".$db->escape($modifier2_2)."',
        modifier2_3 = '".$db->escape($modifier2_3)."',
        modifier2_4 = '".$db->escape($modifier2_4)."',
        diagnosis_pointer2 = '".$db->escape($diagnosis_pointer2)."',
        s_charges2_1 = '".$db->escape($s_charges2_1)."',
        s_charges2_2 = '".$db->escape($s_charges2_2)."',
        days_or_units2 = '".$db->escape($days_or_units2)."',
        epsdt_family_plan2 = '".$db->escape($epsdt_family_plan2)."',
        id_qua2 = '".$db->escape($id_qua2)."',
        rendering_provider_id2 = '".$db->escape($rendering_provider_id2)."',
        service_date3_from = '".$db->escape($service_date3_from)."',
        service_date3_to = '".$db->escape($service_date3_to)."',
        place_of_service3 = '".$db->escape($place_of_service3)."',
        emg3 = '".$db->escape($emg3)."',
        cpt_hcpcs3 = '".$db->escape($cpt_hcpcs3)."',
        modifier3_1 = '".$db->escape($modifier3_1)."',
        modifier3_2 = '".$db->escape($modifier3_2)."',
        modifier3_3 = '".$db->escape($modifier3_3)."',
        modifier3_4 = '".$db->escape($modifier3_4)."',
        diagnosis_pointer3 = '".$db->escape($diagnosis_pointer3)."',
        s_charges3_1 = '".$db->escape($s_charges3_1)."',
        s_charges3_2 = '".$db->escape($s_charges3_2)."',
        days_or_units3 = '".$db->escape($days_or_units3)."',
        epsdt_family_plan3 = '".$db->escape($epsdt_family_plan3)."',
        id_qua3 = '".$db->escape($id_qua3)."',
        rendering_provider_id3 = '".$db->escape($rendering_provider_id3)."',
        service_date4_from = '".$db->escape($service_date4_from)."',
        service_date4_to = '".$db->escape($service_date4_to)."',
        place_of_service4 = '".$db->escape($place_of_service4)."',
        emg4 = '".$db->escape($emg4)."',
        cpt_hcpcs4 = '".$db->escape($cpt_hcpcs4)."',
        modifier4_1 = '".$db->escape($modifier4_1)."',
        modifier4_2 = '".$db->escape($modifier4_2)."',
        modifier4_3 = '".$db->escape($modifier4_3)."',
        modifier4_4 = '".$db->escape($modifier4_4)."',
        diagnosis_pointer4 = '".$db->escape($diagnosis_pointer4)."',
        s_charges4_1 = '".$db->escape($s_charges4_1)."',
        s_charges4_2 = '".$db->escape($s_charges4_2)."',
        days_or_units4 = '".$db->escape($days_or_units4)."',
        epsdt_family_plan4 = '".$db->escape($epsdt_family_plan4)."',
        id_qua4 = '".$db->escape($id_qua4)."',
        rendering_provider_id4 = '".$db->escape($rendering_provider_id4)."',
        service_date5_from = '".$db->escape($service_date5_from)."',
        service_date5_to = '".$db->escape($service_date5_to)."',
        place_of_service5 = '".$db->escape($place_of_service5)."',
        emg5 = '".$db->escape($emg5)."',
        cpt_hcpcs5 = '".$db->escape($cpt_hcpcs5)."',
        modifier5_1 = '".$db->escape($modifier5_1)."',
        modifier5_2 = '".$db->escape($modifier5_2)."',
        modifier5_3 = '".$db->escape($modifier5_3)."',
        modifier5_4 = '".$db->escape($modifier5_4)."',
        diagnosis_pointer5 = '".$db->escape($diagnosis_pointer5)."',
        s_charges5_1 = '".$db->escape($s_charges5_1)."',
        s_charges5_2 = '".$db->escape($s_charges5_2)."',
        days_or_units5 = '".$db->escape($days_or_units5)."',
        epsdt_family_plan5 = '".$db->escape($epsdt_family_plan5)."',
        id_qua5 = '".$db->escape($id_qua5)."',
        rendering_provider_id5 = '".$db->escape($rendering_provider_id5)."',
        service_date6_from = '".$db->escape($service_date6_from)."',
        service_date6_to = '".$db->escape($service_date6_to)."',
        place_of_service6 = '".$db->escape($place_of_service6)."',
        emg6 = '".$db->escape($emg6)."',
        cpt_hcpcs6 = '".$db->escape($cpt_hcpcs6)."',
        modifier6_1 = '".$db->escape($modifier6_1)."',
        modifier6_2 = '".$db->escape($modifier6_2)."',
        modifier6_3 = '".$db->escape($modifier6_3)."',
        modifier6_4 = '".$db->escape($modifier6_4)."',
        diagnosis_pointer6 = '".$db->escape($diagnosis_pointer6)."',
        s_charges6_1 = '".$db->escape($s_charges6_1)."',
        s_charges6_2 = '".$db->escape($s_charges6_2)."',
        days_or_units6 = '".$db->escape($days_or_units6)."',
        epsdt_family_plan6 = '".$db->escape($epsdt_family_plan6)."',
        id_qua6 = '".$db->escape($id_qua6)."',
        rendering_provider_id6 = '".$db->escape($rendering_provider_id6)."',
        federal_tax_id_number = '".$db->escape($federal_tax_id_number)."',
        ssn = '".$db->escape($ssn)."',
        ein = '".$db->escape($ein)."',
        patient_account_no = '".$db->escape($patient_account_no)."',
        accept_assignment = '".$db->escape($accept_assignment)."',
        total_charge = '".$db->escape($total_charge)."',
        amount_paid = '".$db->escape($amount_paid)."',
        balance_due = '".$db->escape($balance_due)."',
        nucc_8a = '".$db->escape($nucc_8a)."',
        nucc_8b = '".$db->escape($nucc_8b)."',
        nucc_9a = '".$db->escape($nucc_9a)."',
        nucc_9b = '".$db->escape($nucc_9b)."',
        claim_codes = '".$db->escape($claim_codes)."',
        other_claim_id = '".$db->escape($other_claim_id)."',
        nucc_9c = '".$db->escape($nucc_9c)."',
        nucc_30 = '".$db->escape($nucc_30)."',
        signature_physician = '".$db->escape($signature_physician)."',
        physician_signed_date = '".$db->escape($physician_signed_date)."',
        service_facility_info_name = '".$db->escape($service_facility_info_name)."',
        service_facility_info_address = '".$db->escape($service_facility_info_address)."',
        service_facility_info_city = '".$db->escape($service_facility_info_city)."',
        service_info_a = '".$db->escape($service_info_a)."',
        service_info_dd = '".$db->escape($service_info_dd)."',
        service_info_b_other = '".$db->escape($service_info_b_other)."',
        billing_provider_phone_code = '".$db->escape($billing_provider_phone_code)."',
        billing_provider_phone = '".$db->escape($billing_provider_phone)."',
        billing_provider_name = '".$db->escape($billing_provider_name)."',
        billing_provider_address = '".$db->escape($billing_provider_address)."',
        billing_provider_city = '".$db->escape($billing_provider_city)."',
        billing_provider_a = '".$db->escape($billing_provider_a)."',
        billing_provider_dd = '".$db->escape($billing_provider_dd)."',
        billing_provider_b_other = '".$db->escape($billing_provider_b_other)."',
        p_m_eligible_payer_id = '".$db->escape($p_m_eligible_payer_id)."',
        p_m_eligible_payer_name = '".$db->escape($p_m_eligible_payer_name)."',
        s_m_eligible_payer_id = '".$db->escape($s_m_eligible_payer_id)."',
        s_m_eligible_payer_name = '".$db->escape($s_m_eligible_payer_name)."',

        status = '$status',
        reject_reason = '".$db->escape($reject_reason)."'

        WHERE insuranceid = '$claimId'";

    $db->query($ed_sql);

    // update the ledger trxns passed in with the form
    $transactionStatus = ClaimFormData::isStatus('sent', $status) ? DSS_TRXN_SENT : DSS_TRXN_PROCESSING;

    // @ToDo: reimplement this functionality
    update_ledger_trxns($claimId, $transactionStatus);
    claim_history_update($claimId, $_SESSION['userid'], $_SESSION['adminuserid']);

    if (isset($claimData['p_m_ins_payer_id'])) {
        $pat_sql = "UPDATE dental_patients SET p_m_eligible_id = '".$db->escape($claimData['p_m_ins_payer_id'])."'
            WHERE patientid = '$patientId'";
        $db->query($pat_sql);
    }

    if (isset($claimData['s_m_ins_payer_id'])) {
        $pat_sql = "UPDATE dental_patients SET s_m_eligible_id = '".s_for($claimData['s_m_ins_payer_id'])."'
            WHERE patientid = '$patientId'";
        $db->query($pat_sql);
    }

    /**
     * Create secondary insurance right away for primary claims that go to Sent status
     * Claim and patient data should be cached somewhere
     */
    if (
        $isFormerPrimary && $isFormerPending &&
        isset($patientData['has_s_m_ins']) && isOptionSelected($patientData['has_s_m_ins'])
    ) {
        ClaimFormData::createSecondaryClaim($patientId, $producer, $claimId);
    }

    return $claimId;
}
