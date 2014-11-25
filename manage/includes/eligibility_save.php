<?php
    include_once '../admin/includes/main_include.php';
    include_once '../includes/constants.inc';
    include_once '../admin/includes/invoice_functions.php';

    $pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');
    $d = json_decode((!empty($_REQUEST['response']) ? $_REQUEST['response'] : ''), true);
    //print_r($d);

    $pi = $d['primary_insurance'];
    $s = "INSERT INTO dental_eligibility SET
    	patientid='".mysqli_real_escape_string($con,$pid)."',
    	userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."',
    	eligible_id='".mysqli_real_escape_string($con,$d['eligible_id'])."',
    	adddate=now(),
            ip_address='".$_SERVER['REMOTE_ADDR']."',
    	response='".(!empty($_REQUEST['response']) ? $_REQUEST['response'] : '')."'";

    $eid = $db->getInsertId($s);
    $type = (isset($_REQUEST['type']))?$_REQUEST['type']:'1';
    invoice_add_eligibility($type, (!empty($_SESSION['admincompanyid']) ? $_SESSION['admincompanyid'] : ''), $eid);
    if($q){
      echo '{"success":true,"id":"'.$eid.'"}';
    }else{
      //echo mysql_error();
      echo '{"error":true,"id":"'.$eid.'"}';
    }
?>
