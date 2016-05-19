<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
include_once("admin/includes/general.htm");

if (isset($_POST['templateid']) && isset($_POST['patientid'])) {
    $patientid = intval($_POST['patientid']);
} else {
    $patientid = '';
}

$md_list = get_mdcontactids($patientid, false);
$md_referral_list = get_mdreferralids($patientid, false);
$contactinfo = get_contact_info($patientid, $md_list, $md_referral_list);

$contacts = [
    [
        'type' => 'patient',
        'id' => $patientid,
        'name' =>
            (!empty($contactinfo['patient'][0]['salutation']) ? $contactinfo['patient'][0]['salutation'] : '') . " " .
            (!empty($contactinfo['patient'][0]['firstname']) ? $contactinfo['patient'][0]['firstname'] : '') . " " .
            (!empty($contactinfo['patient'][0]['lastname']) ? $contactinfo['patient'][0]['lastname'] : ''),
        'email' => (!empty($contactinfo['patient'][0]['email']) ? $contactinfo['patient'][0]['email'] : ''),
        'fax' => (!empty($contactinfo['patient'][0]['fax']) ? $contactinfo['patient'][0]['fax'] : ''),
    ]
];

if ($contactinfo) foreach ($contactinfo['md_referrals'] as $md) {
    $contacts []= [
        'type' => 'md_referral',
        'id' => $md['id'],
        'name' => $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'],
        'email' => $md['email'],
        'fax' => $md['fax'],
        'status' => $md['status'],
    ];
}

$contact_sql = "SELECT docsleep, docpcp, docdentist, docent, docmdother, docmdother2, docmdother3
    FROM dental_patients
    WHERE patientid = '$patientid'";
$row = $db->getRow($contact_sql);
$row = $row ?: [];

$contactTypeList = [
    'docsleep' => 'Sleep MD',
    'docpcp' => 'Primary Care MD',
    'docdentist' => 'Dentist',
    'docent' => 'ENT',
];

foreach ($row as $contactType => $contactId) {
    $contactId = intval($contactId);

    if (!$contactId) {
        continue;
    }

    $sql = "SELECT
            dental_contact.contactid AS id,
            dental_contact.salutation,
            dental_contact.firstname,
            dental_contact.lastname,
            dental_contact.email,
            dental_contact.fax,
            dental_contact.status
        FROM dental_contact
            LEFT JOIN dental_contacttype ON dental_contact.contacttypeid = dental_contacttype.contacttypeid
        WHERE dental_contact.contactid = '$contactId'
        ";

    $md = $db->getRow($sql);

    if (!$md) {
        continue;
    }

    $contacts []= [
        'type' => 'md',
        'label' => array_get($contactTypeList, $contactType, 'Other MD'),
        'id' => $md['id'],
        'name' => $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'],
        'email' => $md['email'],
        'fax' => $md['fax'],
        'status' => $md['status'],
    ];
}

echo json_encode($contacts);
