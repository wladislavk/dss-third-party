<?php
namespace Ds3\Libraries\Legacy;

require_once '../../manage/admin/includes/main_include.php';
require_once __DIR__ . '/../../manage/includes/constants.inc';
require_once __DIR__ . '/../../manage/includes/hst_functions.php';

$hstData = [
    'screener_id' => $_REQUEST['screenerid'],
    'doc_id' => $_REQUEST['docid'],
    'user_id' => $_REQUEST['userid'],
    'company_id' => $_REQUEST['companyid'],
    'patient_firstname' => $_REQUEST['patient_first_name'],
    'patient_lastname' => $_REQUEST['patient_last_name'],
    'patient_dob' => date('Y-m-d', strtotime($_REQUEST['patient_dob'])),
    'patient_cell_phone' => $_REQUEST['patient_cell_phone'],
    'patient_email' => $_REQUEST['patient_email'],
    'snore_1' => $_REQUEST['snore_1'],
    'snore_2' => $_REQUEST['snore_2'],
    'snore_3' => $_REQUEST['snore_3'],
    'snore_4' => $_REQUEST['snore_4'],
    'snore_5' => $_REQUEST['snore_5'],
    'status' => DSS_HST_REQUESTED,
    'ip_address' => $_SERVER['REMOTE_ADDR']
];

$hstData = $db->escapeAssignmentList($hstData);
$hstId = $db->getInsertId("INSERT INTO dental_hst SET $hstData, adddate = NOW()");

if ($hstId) {
    createPatientFromHSTRequest($hstId);

  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($epworth_myarray = mysqli_fetch_array($epworth_my))
  {
    $chk = $_REQUEST['epworth_'.$epworth_myarray['epworthid']];
    if($chk != ''){
      $hst_sql = "INSERT INTO dental_hst_epworth SET
                        hst_id = '".mysqli_real_escape_string($con, $hstId)."',
                        epworth_id = '".mysqli_real_escape_string($con, $epworth_myarray['epworthid'])."',
                        response = '".mysqli_real_escape_string($con, $chk)."',
                        adddate = now(),
                        ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'";
      mysqli_query($con, $hst_sql);
    }
  }

  echo '{"success":true}';
}else{
  echo '{"error":true}';
}

if (!function_exists(__NAMESPACE__ . '\\num')) {
    function num($n, $phone=true){
        $n = preg_replace('/\D/', '', $n);

        if (!$phone) {
            return $n;
        }

        $pattern = '/([1]*)(.*)/';

        if (preg_match($pattern, $n, $matches)) {
            return $matches[2];
        }

        return $n;
    }
}
