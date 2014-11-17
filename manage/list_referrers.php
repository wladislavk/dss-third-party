<?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include_once("admin/includes/general.htm");
    include_once('includes/constants.inc');
    include_once('includes/formatters.php');

    $partial = '';
    if (isset($_POST['partial_name'])) {
    	$partial = $_POST['partial_name'];
    	$partial = ereg_replace("[^ A-Za-z'\-]", "", $partial);
    	$partial = s_for($partial);
    }

    $names = explode(" ", $partial);

    $sql = "SELECT p.patientid, p.lastname, p.firstname, p.middlename, '".DSS_REFERRED_PATIENT."' AS referral_type, 'Patient' as label"
         . " FROM dental_patients p"
         . " LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
         . " LEFT JOIN dental_device d ON s.appliance = d.deviceid "
         . " WHERE ((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')" 
         . " AND (lastname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%' OR firstname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%'))"
         . " AND docid = '" . $_SESSION['docid']."'"
         . " UNION "
         . " SELECT c.contactid, c.lastname, c.firstname, c.middlename, '".DSS_REFERRED_PHYSICIAN."', ct.contacttype"
         .	" FROM dental_contact c"
         . " LEFT JOIN dental_contacttype ct ON c.contacttypeid=ct.contacttypeid"
         . " WHERE ((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')"
         . " AND (lastname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%' OR firstname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%'))"
         . " AND merge_id IS NULL "
         . " AND docid = '" . $_SESSION['docid'] . "' ORDER BY lastname ASC";

    $result = $db->getResults($sql);
    $patients = array();
    $i = 0;
    if ($result) foreach ($result as $row) {
        $patients[$i]['id'] = $row['patientid'];
        $patients[$i]['name'] = $row['lastname'].", ".$row['firstname']. " ". $row['middlename'] ." - ".$row['label'];
        $patients[$i]['source'] = $row['referral_type'];
        $i++;
    }

    if (!$result) {
        $patients = array("error" => $sql."Error: Could not select patients from database");
    }

    echo json_encode($patients);
?>