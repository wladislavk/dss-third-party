<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once '../../admin/includes/main_include.php';
	include_once '../../includes/checkemail.php';

	$sql = "SELECT * FROM dental_access_codes WHERE status='1' AND access_code = '".$db->escape($_REQUEST['code'])."'";
	
	$n = $db->getNumberRows($sql);
	if($n > 0){
	  echo 'true';//'{"success":true}';
	}else{
	  echo 'false';//'{"error":false}';
	}
?>
