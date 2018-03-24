<?php namespace Ds3\Libraries\Legacy; ?><?php

/////////////////////
//
// Temporary file to update dental letters to use new info_id
//
//

require_once './admin/includes/main_include.php';

$l_sql = "select letterid, stepid, patientid from dental_letters";
$l_q = mysqli_query($con, $l_sql);
while($l_r = mysqli_fetch_assoc($l_q)){

  $sid = $l_r['stepid'];
  if($sid!='' && $sid != 0){

    $info_sql = "SELECT id, segmentid FROM dental_flow_pg2_info where patientid='".$l_r['patientid']."' and stepid='".$l_r['stepid']."'";
    $info_q = mysqli_query($con, $info_sql);
    $info_r = mysqli_fetch_assoc($info_q);
    if($info_r['id']!=''){
    $up_sql = "UPDATE dental_letters set info_id='".$info_r['id']."' where letterid='".$l_r['letterid']."'";
    //mysqli_query($con, $up_sql);
    echo $up_sql ."<br />";
    }

  }


}
