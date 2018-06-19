<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';
include_once 'checkemail.php';

$db = new Db();

$sql = "SELECT dp.*, du.use_patient_portal AS doc_use_patient_portal FROM dental_patients dp JOIN dental_users du ON du.userid=dp.docid WHERE dp.patientid='".$db->escape((!empty($_REQUEST['id']) ? $_REQUEST['id'] : ''))."'";

$r = $db->getRow($sql);

if(($r['registration_status'] == 1 || $r['registration_status'] == 2) && $r['use_patient_portal']==1 && $r['doc_use_patient_portal']==1 && $r['email']!=$_REQUEST['email']){
    echo '{"success":true}';
    trigger_error("Die called", E_USER_ERROR);
}
