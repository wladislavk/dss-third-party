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
 * @param array $verificationLines
 * @return bool
 */
function hasLedgerTransactionsChanged ($verificationLines) {
    $db = new Db();

    foreach ($verificationLines as $verificationLine) {
        $serviceLine = @json_decode($verificationLine);

        if (empty($serviceLine['ledger_id'])) {
            continue;
        }

        $ledgerId = intval($serviceLine['ledger_id']);
        $row = $db->getRow("SELECT *
            FROM dental_ledger
            WHERE ledgerid = '$ledgerId'");

        if (!$row) {
            return true;
        }

        $verificationRow = json_encode($row);

        if ($verificationLine !== $verificationRow || $row['status'] == DSS_TRXN_NA) {
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
    $primaryClaimId = $db->getColumn("SELECT IF(primary_claim_id, primary_claim_id, insuranceid) AS claim_id
        FROM dental_insurance
        WHERE insuranceid = '$claimId'", 'claim_id');

    foreach ($serviceLines as $serviceLine) {
        if (empty($serviceLine['ledger_id'])) {
            continue;
        }

        $ledgerId = intval($serviceLine['ledger_id']);
        $insertData = $db->escapeAssignmentList([
            'service_date' => $serviceLine['service_date_from'],
            'placeofservice' => $serviceLine['place_of_service'],
            'emg' => $serviceLine['emergency'],
            'transaction_code' => $serviceLine['procedure_code'],

            'modifiercode' => $serviceLine['procedure_modifiers'][0],
            'modifiercode2' => $serviceLine['procedure_modifiers'][1],
            'modifiercode3' => $serviceLine['procedure_modifiers'][2],
            'modifiercode4' => $serviceLine['procedure_modifiers'][3],
            'diagnosispointer' => $serviceLine['diagnosis_code_pointers'][0],

            'amount' => $serviceLine['charge_amount'],
            'daysorunits' => $serviceLine['units'],
            'epsdt' => $serviceLine['epsdt'],
            'idqual' => $serviceLine['idqual'],

            'status' => $trxnStatus,
            'primary_claim_id' => $primaryClaimId
        ]);

        $db->query("UPDATE dental_ledger SET $insertData
            WHERE ledgerid = '$ledgerId'");
    }
}
