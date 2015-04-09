<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once 'admin/includes/main_include.php';
require_once 'includes/constants.inc';
$request_body = file_get_contents('php://input');
$json = json_decode($request_body);

$event = $json->{"event"};
//$success = $json->{"success"};

if($event == "claim_rejected"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_REJECTED."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);

}elseif($event == "claim_paid"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_PAID_INSURANCE."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);

}elseif($event == "claim_denied"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_REJECTED."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);

}elseif($event == "claim_pended"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_SENT."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);

}elseif($event == "claim_created"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_SENT."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);

}elseif($event == "claim_received"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_SENT."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);

}elseif($event == "claim_accepted"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_EFILE_ACCEPTED."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);
  
}elseif($event == "claim_more_info_required"){
  $ref_id = $json->{"reference_id"};
  $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
  $e_q = mysqli_query($con, $e_sql);
  $e = mysqli_fetch_assoc($e_q);
  $up_sql = "UPDATE dental_insurance SET
                status='".DSS_CLAIM_REJECTED."'
                WHERE insuranceid='".mysqli_real_escape_string($con, $e['claimid'])."'";
  mysqli_query($con, $up_sql);

}elseif($event == "enrollment_status"){
  $ref_id = $json->{"details"}->{"id"};
  $status = $json->{"details"}->{"status"};
  if($status=="accepted"){
    $up_sql = "UPDATE dental_eligible_enrollment SET
    status='1'
    WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
    mysqli_query($con, $up_sql);
  }
}elseif($event == "received_pdf"){
    $ref_id = $json->{"details"}->{"id"};
    $download_url = $json->{"details"}->{"received_pdf"}->{"download_url"};
    if($download_url){
        $up_sql = "UPDATE dental_eligible_enrollment SET
          status='".DSS_ENROLLMENT_PDF_RECEIVED."',
            download_url = '".mysqli_real_escape_string($con, $download_url)."'
            WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
        mysqli_query($con, $up_sql);
    }
}elseif($event == "payment_report"){
    $ref_id = $json->{"reference_id"};
    $status = "payment_report";

    $e_sql = "SELECT claimid FROM dental_claim_electronic WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
    $e_q = mysqli_query($con, $e_sql);
    $e = mysqli_fetch_assoc($e_q);

    $payment_report_sql = "INSERT INTO dental_payment_reports SET
        claimid = '".mysqli_real_escape_string($con, $e['claimid'])."',
        reference_id = '".mysqli_real_escape_string($con, $ref_id)."',
        response = '".mysqli_real_escape_string($con, $request_body)."',
        adddate = now(),
        ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'";
    mysqli_query($con, $payment_report_sql);
}elseif($event == "received_pdf"){
    $ref_id = $json->{"details"}->{"id"};
    $download_url = $json->{"details"}->{"received_pdf"}->{"download_url"};
    if($download_url){
        $up_sql = "UPDATE dental_eligible_enrollment SET
    status='".DSS_ENROLLMENT_PDF_RECEIVED."',
    download_url = '".mysqli_real_escape_string($con, $download_url)."'
    WHERE reference_id='".mysqli_real_escape_string($con, $ref_id)."'";
        mysqli_query($con, $up_sql);
    }
}



$sql = "INSERT INTO dental_eligible_response SET
  response = '".mysqli_real_escape_string($con, $request_body)."',
  reference_id = '".mysqli_real_escape_string($con, $ref_id)."',
  event_type = '".mysqli_real_escape_string($con, $event)."',
  adddate = now(),
  ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."'";
mysqli_query($con, $sql);

?>
