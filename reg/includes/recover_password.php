<?php namespace Ds3\Legacy; ?><?php
require_once '../../manage/admin/includes/main_include.php';

    $s = "SELECT * FROM dental_patients WHERE email='".mysql_real_escape_string($_POST['email'])."'";
    $q = mysql_query($s);
    if(mysql_num_rows($q) > 0){
      $r = mysql_fetch_assoc($q);
                $recover_hash = substr(hash('sha256', $r['patientid'].$_POST['email'].rand()), 0, 7);
                $ins_sql = "UPDATE dental_patients set recover_hash='".$recover_hash."', recover_time=NOW() WHERE patientid='".$r['patientid']."'";
                mysql_query($ins_sql);
          echo '{"success":true}';
    }else{
	echo '{"error":"email"}';
    }
?> 
