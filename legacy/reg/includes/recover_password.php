<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once '../../manage/admin/includes/main_include.php';

    $s = "SELECT * FROM dental_patients WHERE email='".$db->escape( $_POST['email'])."'";
    $q = mysqli_query($con, $s);
    if(mysqli_num_rows($q) > 0){
      $r = mysqli_fetch_assoc($q);
        linkRequestData('dental_patients', $r['pateintid']);
                $recover_hash = substr(hash('sha256', $r['patientid'].$_POST['email'].rand()), 0, 7);
                $ins_sql = "UPDATE dental_patients set recover_hash='".$recover_hash."', recover_time=NOW() WHERE patientid='".$r['patientid']."'";
                mysqli_query($con, $ins_sql);
          echo '{"success":true}';
    }else{
        linkRequestData('dental_patients', 0);
	echo '{"error":"email"}';
    }
?> 
