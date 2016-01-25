<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/constants.inc';

/**
 * Create a new patient, based on a HST request. The patient will NOT be created if the requested HST already has
 * a patient id set.
 *
 * @param int $hstId
 * @return int
 */
function createPatientFromHSTRequest ($hstId) {
    $db = new Db();

    $hstId = intval($hstId);
    $hstData = $db->getRow("SELECT screener_id, patient_email, patient_dob
        FROM dental_hst
        WHERE id = '$hstId'
            AND COALESCE(patient_id, 0) = 0");

    if (!$hstData) {
        return 0;
    }

    $screenerId = intval($hstData['screener_id']);
    $screenerData = $db->getRow("SELECT docid, first_name, last_name, phone
        FROM dental_screener
        WHERE id = '$screenerId'
            AND COALESCE(patient_id, 0) = 0");

    if (!$screenerData) {
        return 0;
    }

    $patientData = [
        'docid' => $screenerData['docid'],
        'firstname' => $screenerData['first_name'],
        'lastname' => $screenerData['last_name'],
        'cell_phone' => $screenerData['phone'],
        'email' => $hstData['patient_email'],
        'dob' => !empty($hstData['patient_dob']) ? date('m/d/Y', strtotime($hstData['patient_dob'])) : '',
        'ip_address' => $_SERVER['REMOTE_ADDR']
    ];

    $patientData = $db->escapeAssignmentList($patientData);
    $patientId = $db->getInsertId("INSERT INTO dental_patients SET $patientData, status = '1', adddate = NOW()");

    $db->query("UPDATE dental_hst SET patient_id = $patientId, updatedate = NOW() WHERE id = '$hstId'");
    $db->query("UPDATE dental_screener SET patient_id = '$patientId' WHERE id = '$screenerId'");

    return $patientId;
}

function authorizeHST ($hstId) {
    $db = new Db();

    $hstId = intval($hstId);
    $hstData = $db->getRow("SELECT status, screener_id, patient_id, patient_email, patient_dob
        FROM dental_hst
        WHERE id = '$hstId'");

    if (!$hstData) {
        return 0;
    }

    $screenerId = intval($hstData['screener_id']);
    $screenerData = $db->getRow("SELECT docid, patient_id, first_name, last_name, phone
        FROM dental_screener
        WHERE id = '$screenerId'
            AND COALESCE(patient_id, 0) = 0");

    if (!$hstData['patient_id'] && !$screenerData['patient_id']) {
        $patientId = createPatientFromHSTRequest($hstId);
    } else {
        $patientId = !empty($screenerData['patient_id']) ? $screenerData['patient_id'] : $hstData['patient_id'];

        if ($hstData['patient_id'] != $screenerData['patient_id']) {
            error_log("Authorize HST: The patient id differs between the HST request and the screener data.");
            error_log("HST id [$hstId]: {$hstData['patient_id']}, Screener id [$screenerId]: {$screenerData['patient_id']}");
        }
    }

    /**
     * Blindly update HST and Screener with the proper patient id
     */
    $db->query("UPDATE dental_hst SET patient_id = '$patientId' WHERE id = '$hstId'");
    $db->query("UPDATE dental_screener SET patient_id = '$patientId' WHERE id = '$screenerId'");

    if ($hstData['status'] != DSS_HST_REQUESTED) {
        return false;
    }

    $hstUpdateData = [
        'status' => DSS_HST_PENDING,
        'authorized_id' => $_SESSION['userid']
    ];

    $hstUpdateData = $db->escapeAssignmentList($hstUpdateData);
    $db->query("UPDATE dental_hst SET $hstUpdateData, authorizeddate = NOW(), updatedate = NOW()
        WHERE id = '$hstId'");

    return true;
}
