<?php
  function edx_user_update($id)
  {
    $sql = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($id)."'";
    
    $r = $db->getRow($sql);

    $edx_id = $r['edx_id'];
    $docid = ($r['docid']!=0)?$r['docid']:$r['userid'];

    $loc_sql = "SELECT * from dental_locations WHERE docid='".mysql_real_escape_string($docid)."' order by default_location DESC limit 1";

    $loc = $db->getRow($loc_sql);
    $address = $loc['address']." ".$loc['city'].", ".$loc['state']." ".$loc['zip'];
    if($edx_id == '' || $edx_id == '0'){
      $name = $r['first_name']. ' '.$r['last_name'];
      $pass = sha1($r['username'].'ed&$s8e'.$r['email'].rand());
      $username = ($r['username'])?$r['username']:'tempusername_'.$id; 
      $edx_id = shell_exec('sh edx_scripts/edxNewUser.sh '. urlencode($username) .' '.urlencode($r['email']).' "'.urlencode($pass).'" "'.urlencode($name).'"');
      $u_sql = "UPDATE dental_users SET edx_id='".mysql_real_escape_string($edx_id)."' WHERE userid='".mysql_real_escape_string($id)."'";
      
      $db->query($u_sql);
    }else{
      $name = $r['first_name']. ' '.$r['last_name'];
      $pass = sha1($r['username'].'ed&$s8e'.$r['email'].rand());
      $edx_id = shell_exec('sh edx_scripts/edxEditUser.sh '.urlencode($edx_id).' "'.urlencode($r['username']).'" '.urlencode($r['email']).' '.urlencode($pass).' "'.urlencode($name).'"');
    }
  }

  function edx_user_delete($edx_id)
  {
    if($edx_id != '' && $edx_id != '0'){
      $ed_id = shell_exec('sh edx_scripts/edxDeleteUser.sh '.urlencode($edx_id));
    }
  }
?>
