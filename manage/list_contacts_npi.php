<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/admin/includes/access.php';
require_once __DIR__ . '/admin/includes/general.htm';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/formatters.php';

$partial = '';
$isBackOffice = !empty($is_back_office);
$andDocIdConditional = '';

if ($isBackOffice) {
    require_once __DIR__ . '/admin/includes/sescheck.php';

    /**
     * Validate docid and corresponding company. Super admin will not have this restriction
     */
    if (!is_super($_SESSION['admin_access'])) {
        $patientId = intval($_POST['patient_id']);
        $docId = $db->getColumn("SELECT docid FROM dental_patients WHERE patientid = '$patientId'", 'docid', 0);
        $userCompany = intval($_SESSION['admincompanyid']);

        $doctorCompanies = $db->getRow("SELECT
                user.billing_company_id AS billing_id,
                software.companyid AS software_id,
                hst.companyid AS hst_id
            FROM dental_users user
                LEFT JOIN dental_user_company software ON software.userid = user.userid
                LEFT JOIN dental_user_hst_company hst ON hst.userid = user.userid
            WHERE user.userid ='$docId'
            LIMIT 1
            ");

        if (is_software($_SESSION['admin_access'])) {
            $referenceId = $doctorCompanies['software_id'];
        } elseif (is_hst($_SESSION['admin_access'])) {
            $referenceId = $doctorCompanies['hst_id'];
        } elseif (is_billing($_SESSION['admin_access'])) {
            $referenceId = $doctorCompanies['billing_id'];
        } else {
            $referenceId = null;
        }

        $andDocIdConditional = $userCompany == $referenceId ? "AND docid = '$docId'" : 'AND 1 = 0';
    }
} else {
    require_once __DIR__ . '/includes/sescheck.php';

    $docId = intval($_SESSION['docid']);
    $andDocIdConditional = "AND docid = '$docId'";
}

if (isset($_POST['partial_name'])) {
    $partial = $_POST['partial_name'];
    $partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
    $partial = s_for($partial);
}

$names = explode(" ", $partial);

$sql = "SELECT c.contactid, c.lastname, c.firstname, c.middlename, national_provider_id, '" . DSS_REFERRED_PHYSICIAN . "' as referral_type, ct.contacttype"
    . " FROM dental_contact c"
    . " JOIN dental_contacttype ct ON c.contacttypeid=ct.contacttypeid"
    . " WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')"
    . " AND (lastname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%' OR firstname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%'))"
    . " OR (firstname LIKE '" . $names[0] . "%' AND middlename LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%' AND lastname LIKE '" . (!empty($names[2]) ? $names[2] : '') . "%'))"
    . " $andDocIdConditional "
    . " AND c.status=1 "
    . " AND ct.physician=1"
    . " AND merge_id IS NULL ORDER BY lastname ASC";

$result = $db->getResults($sql);
$patients = [];
$i = 0;
if ($result) foreach ($result as $row) {
    $patients[$i]['id'] = $row['national_provider_id'];
    $patients[$i]['name'] = $row['firstname'] . " " . $row['lastname'] . " - " . $row['contacttype'];
    $patients[$i]['source'] = $row['referral_type'];
    $i++;
}

if (!$result) {
    $patients = ["error" => "Error: No matching contact found."];
}

echo json_encode($patients);
