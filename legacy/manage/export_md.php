<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/admin/includes/main_include.php';
include_once __DIR__ . '/includes/constants.inc';

session_write_close();

$docId = intval($_SESSION['docid']);

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=dss_md_export.csv");
header("Pragma: no-cache");
header("Expires: 0");

$out = fopen('php://output', 'w');

$csv = [
    'Salutation',
    'First Name',
    'Last Name',
    'Middle Init',
    'Company',
    'Address 1',
    'Address 2',
    'City',
    'State',
    'Zip',
    'Phone 1',
    'Phone 2',
    'Fax',
    'Email',
    'National Provider ID',
    'Qualifier',
    'ID',
    'Notes',
    'Preferred Contact Method',
    'Referrer',
    'Status'
];

fputcsv($out, $csv);

$db = new Db();

$sql = "SELECT
        dc.*,
        dq.qualifier AS qualifier_name, 
        (
            SELECT COUNT(p.patientid)
            FROM dental_patients p
            WHERE dc.contactid = p.referred_by
                AND p.referred_source = " . DSS_REFERRED_PHYSICIAN . "
        ) AS num_ref
    FROM dental_contact dc
        JOIN dental_contacttype dct ON dc.contacttypeid = dct.contacttypeid
        LEFT JOIN dental_qualifier dq ON dq.qualifierid = dc.qualifier
    WHERE dc.docid = '$docId' 
        AND dct.physician = 1
        AND dc.merge_id IS NULL
        AND dc.status = 1
    ORDER BY IF (dc.lastname = '' OR dc.lastname IS NULL, 1, 0) ASC,
        dc.lastname ASC,
        dc.firstname ASC,
        dc.company ASC,
        dct.contacttype ASC
    ";
$contacts = $db->getResults($sql);

foreach ($contacts as $each) {
    $csv = [
        $each['salutation'],
        $each['firstname'],
        $each['lastname'],
        $each['middlename'],
        $each['company'],
        $each['add1'],
        $each['add2'],
        $each['city'],
        $each['state'],
        $each['zip'],
        $each['phone1'],
        $each['phone2'],
        $each['fax'],
        $each['email'],
        $each['national_provider_id'],
        $each['qualifier_name'],
        $each['qualifierid'],
        $each['notes'],
        $each['preferredcontact'],
        $each['num_ref'] > 0 ? 'Yes' : 'No',
        $each['status'] == 1 ? 'Active' : 'Inactive',
    ];
    
    fputcsv($out, $csv);
}

fclose($out);
