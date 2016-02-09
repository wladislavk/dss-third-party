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

/**
 * Mark a  HST Request as authorized, create proper EP worth entry and email patient
 *
 * @param int $hstId
 * @param int $hstCompanyId
 * @param int $docId
 * @return bool|int
 */
function authorizeHSTRequest ($hstId, $hstCompanyId, $docId) {
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
    $screenerData = $screenerData ?: [];

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

    $epWorthIds = $db->getColumn("SELECT epworthid FROM dental_q_sleep WHERE patientid = '$patientId'", 'epworthid');

    $epid = [];
    $epseq = [];

    if ($epWorthIds) {
        $epWorthSections = explode('~', $epWorthIds);

        foreach ($epWorthSections as $index=>$each) {
            $sections = explode('|', $each);
            $epid[$index] = $sections[0];
            $epseq[$index] = $sections[1];
        }
    }

    $epWorthList = $db->getResults("SELECT * FROM dental_epworth WHERE status = 1 ORDER BY sortby");

    foreach ($epWorthList as $epWorth) {
        $search = @array_search($epWorth['epworthid'], $epid);

        if ($search !== false) {
            $hstEpWorthData = [
                'hst_id' => $hstId,
                'epworth_id' => $epWorth['epworthid'],
                'response' => $search,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ];

            $hstEpWorthData = $db->escapeAssignmentList($hstEpWorthData);
            $db->query("INSERT INTO dental_hst_epworth SET $hstEpWorthData, adddate = NOW()");
        }
    }

    $companyEmail = $db->getColumn("SELECT email FROM companies WHERE id = '$hstCompanyId'", 'email');

    if ($companyEmail) {
        $headers = join("\r\n", [
            'From: Dental Sleep Solutions <noreply@dentalsleepsolutions.com>',
            'Content-type: text/html',
            'Reply-To: noreply@dentalsleepsolutions.com',
            'X-Mailer: PHP/' . phpversion()
        ]);

        $today = date('m/d/Y h:i p');
        $host = 'https://' . $_SERVER['HTTP_HOST'];
        $footer = DSS_EMAIL_FOOTER;

        $subject = "New HST Order Created";
        $user_sql = "SELECT * FROM dental_users WHERE userid = '$docId'";
        $user = $db->getRow($user_sql);
        $body = "<html>
            <body>
                <center>
                    <table width='600'>
                        <tr>
                            <td colspan='2'>
                                <img alt='A message from your healthcare provider'
                                    src='$host/reg/images/email/email_header_fo.png' />
                            </td>
                        </tr>
                        <tr>
                            <td width='400'>
                                <h2>New HST Order Created</h2>
                                <p>A new HST order has been submitted to you by
                                    {$user['first_name']} {$user['last_name']}
                                    at {$user['mailing_practice']}
                                    on {$today}
                                </p>
                                <p>Please log in to your DS3 backoffice account to check the details:
                                    <a href='$host/manage/admin'>
                                        $host/manage/admin
                                    </a>
                                </p>
                            </td>
                            <td>
                                <img alt='Logo' src='$host/reg/images/email/reg_logo.gif' />
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2'>
                                <img alt='A message from your healthcare provider'
                                    src='$host/reg/images/email/email_footer_fo.png' />
                            </td>
                        </tr>
                    </table>
                </center>
                <span style='font-size:12px;'>
                    This email was sent by Dental Sleep Solutions&reg;
                    on behalf of {$user['mailing_practice']}
                    {$footer}
                </span>
            </body></html>";

        $body = preg_replace('/[\s\t\r\n]+/', ' ', $body);

        mail($companyEmail, $subject, $body, $headers);
    }

    return true;
}

/**
 * Mark a HST Request as soft deleted
 *
 * @param int $hstId
 */
function deleteHSTRequest ($hstId) {
    $db = new Db();
    $hstId = intval($hstId);

    $db->query("UPDATE dental_hst SET status = -1 WHERE id = '$hstId'");
}
