<?php
namespace Ds3\Libraries\Legacy;

include_once '../admin/includes/main_include.php';

	$id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : '');
	$t = (!empty($_REQUEST['type']) ? $_REQUEST['type'] : '');
	$pid = (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '');

    $s = "UPDATE dental_flow_pg2_info SET
          study_type = '".$db->escape($t)."'
          WHERE
          patientid = '".$db->escape($pid)."' AND
          id = '".$db->escape($id) . "'";

	$q = $db->query($s);
	if(!empty($q)){
	  echo '{"success":true}';
	}else{
	  echo '{"error":true}';
	}
