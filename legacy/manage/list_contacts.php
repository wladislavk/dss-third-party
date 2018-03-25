<?php namespace Ds3\Libraries\Legacy; ?><?php
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

    $sql = "SELECT c.contactid, c.lastname, c.firstname, c.middlename, '".DSS_REFERRED_PHYSICIAN."' as referral_type, ct.contacttype"
         . " FROM dental_contact c"
         . " JOIN dental_contacttype ct ON c.contacttypeid=ct.contacttypeid"
         . " WHERE (((lastname LIKE '" . $names[0] . "%' OR firstname LIKE '" . $names[0] . "%')"
         . " AND (lastname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%' OR firstname LIKE '" . (!empty($names[1]) ? $names[1] : '') . "%'))"
         . " OR (firstname LIKE '" . $names[0] ."%' AND middlename LIKE '" .(!empty($names[1]) ? $names[1] : '')."%' AND lastname LIKE '" . (!empty($names[2]) ? $names[2] : '') . "%'))"
         . " AND docid = '" . $_SESSION['docid'] . "' "
         . " AND c.status=1 "
         . " AND ct.physician=1"
         . " AND merge_id IS NULL ORDER BY lastname ASC";

    $result = $db->getResults($sql);
    $patients = array();
    $i = 0;
    if ($result) foreach ($result as $row) {
        $patients[$i]['id'] = $row['contactid'];
        $patients[$i]['name'] = $row['lastname'].", ".$row['firstname'] . " " . $row['middlename'] . " - " . $row['contacttype'];
        $patients[$i]['source'] = $row['referral_type'];
        $i++;
    }

    if (!$result) {
    	$patients = array("error" => "Error: No matching contact found.");
    }

    echo json_encode($patients);
?>
