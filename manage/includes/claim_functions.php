<?php
namespace Ds3\Libraries\Legacy;

//inserts row into dental_insurance_history
function claim_history_update ($claimId, $userId, $adminId) {
    $db = new Db();
    
    $claimId = intval($claimId);
    $userId = intval($userId);
    $adminId = intval($adminId);

    $backupColumns = $db->backupColumns('dental_insurance', 'dental_insurance_history');

    $sql = "INSERT INTO dental_insurance_history (
            $backupColumns,
            updated_by_user,
            updated_by_admin,
            updated_at
        )
        SELECT
            $backupColumns,
            '$userId',
            '$adminId',
            NOW()
        FROM dental_insurance i
        WHERE i.insuranceid = '$claimId'";

    $historyId = $db->getInsertId($sql);
    
    if (!empty($claimId)) {
        $backupColumns = $db->backupColumns('dental_ledger', 'dental_ledger_history');
        
        $sql = "INSERT INTO dental_ledger_history(
                $backupColumns,
                primary_claim_history_id,
                updated_by_user,
                updated_by_admin,
                updated_at
            )
            SELECT
                $backupColumns,
                '$historyId',
                '$userId',
                '$adminId',
                NOW()
            FROM dental_ledger l
            WHERE l.primary_claim_id = '$claimId'";

        $db->query($sql);
    }

    return $historyId;
}

function payment_history_update ($paymentId, $userId, $adminId) {
    $db = new Db();

    $paymentId = intval($paymentId);
    $userId = intval($userId);
    $adminId = intval($adminId);

    $backupColumns = $db->backupColumns('dental_ledger_payment', 'dental_ledger_payment_history');

    $sql = "INSERT INTO dental_ledger_payment_history (
            $backupColumns,
            updated_by_user,
            updated_by_admin,
            updated_at
        )
        SELECT
            $backupColumns,
            '$userId',
            '$adminId',
            NOW()
        FROM dental_ledger_payment p
        WHERE p.id = '$paymentId'";

    return $db->getInsertId($sql);
}

/**
 * Verify the ledger transactions have not changed prior to save them
 *
 * @param int   $claimId
 * @param array $serviceLines
 * @return bool
 */
function hasLedgerTransactionsChanged ($claimId, $serviceLines) {
    $db = new Db();

    $comparisons = [];
    $dynamicLines = [];
    $unorderedLines = ClaimFormData::dynamicLedgerItems($claimId);

    foreach ($unorderedLines as $each) {
        $dynamicLines [$each['ledgerid']] = $each;
    }

    foreach ($serviceLines as $serviceLine) {
        if (empty($serviceLine['ledger_id'])) {
            continue;
        }

        $ledgerId = intval($serviceLine['ledger_id']);
        $row = isset($dynamicLines[$ledgerId]) ? $dynamicLines[$ledgerId] : null;

        if (!$row) {
            return true;
        }

        $comparisons[$serviceLine['verification']] = $row['verification'];

        if ($serviceLine['verification'] != $row['verification']) {
            return true;
        }

        if ($row['status'] == DSS_TRXN_NA) {
            return true;
        }
    }

    return false;
}

/**
 * Save changes to ledger transactions
 *
 * @param int   $claimId
 * @param int   $trxnStatus
 * @param array $serviceLines
 */
function updateLedgerTransactions ($claimId, $trxnStatus, $serviceLines) {
    $db = new Db();

    $claimId = intval($claimId);
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

    foreach ($serviceLines as $serviceLine) {
        if (empty($serviceLine['ledger_id'])) {
            continue;
        }

        $ledgerId = intval($serviceLine['ledger_id']);
        $updateData = [
            'service_date' => $serviceLine['service_date_from'],
            'emg' => isOptionSelected($serviceLine['emergency']),

            'modcode' => $serviceLine['procedure_modifiers'][0],
            'modcode2' => $serviceLine['procedure_modifiers'][1],
            'modcode3' => $serviceLine['procedure_modifiers'][2],
            'modcode4' => $serviceLine['procedure_modifiers'][3],
            'diagnosispointer' => $serviceLine['diagnosis_code_pointers'][0],

            'amount' => preg_replace('/[^\d\.]+/', '', $serviceLine['charge_amount']),
            'daysorunits' => $serviceLine['units'],
            'epsdt' => $serviceLine['epsdt'],

            'status' => $trxnStatus
        ];

        if (isset($serviceLine['idqual'])) {
            $updateData['idqual'] = $serviceLine['idqual'];
        }

        /**
         * Ensure the place of service exists
         */
        if (in_array($serviceLine['place_of_service'], $placesOfService)) {
            $updateData['placeofservice'] = $serviceLine['place_of_service'];
        }

        /**
         * Ensure the procedure code exists, and is associated to the docid
         */
        $codeIndex = array_filter([
            array_search($serviceLine['procedure_code'], $codes),
            array_search($serviceLine['procedure_code'], $descriptions),
            array_search($serviceLine['procedure_code'], $longDescriptions),
        ], function ($each) { return $each !== false; });

        $codeIndex = count($codeIndex) ? array_shift($codeIndex) : false;

        if ($codeIndex !== false) {
            $updateData['transaction_code'] = $codes[$codeIndex];
        }

        $updateData = $db->escapeAssignmentList($updateData);

        $db->query("UPDATE dental_ledger SET $updateData
            WHERE ledgerid = '$ledgerId'
                AND '$claimId' IN (primary_claim_id, secondary_claim_id)");
    }
}
