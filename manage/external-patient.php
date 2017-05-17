<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';

$externalPatientId = $db->escape($_GET['id']);
$externalCompanyId = $db->escape($_GET['sw']);

$sql = "SELECT p.patientid, p.status
    FROM dental_patients p
        JOIN dental_external_patients ep ON ep.patient_id = p.patientid
    WHERE ep.external_id = '$externalPatientId'
        AND ep.software = '$externalCompanyId'
    LIMIT 1";

$externalPatient = $db->getRow($sql);

if ($externalPatient) {
    if (in_array([1, 2, '1', '2'], $externalPatient['status'])) {
        header("Location: /manage/add_patient.php?pid={$externalPatient['patientid']}");
    } else {
        header("Location: /manage/pending_patient.php?pid={$externalPatient['patientid']}#external-patient");
    }
} else {
    header('Location: /manage/manage_patient.php?msg=Patient+not+found');
}
