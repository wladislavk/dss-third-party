<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once '../admin/includes/main_include.php';
	
	if (!empty($_REQUEST['ids']) && is_string($_REQUEST['ids'])) {
		$ids = $_REQUEST['ids'];
	} else {
		$ids = '';
	}

    $ids = preg_split('/\D+/', $ids);
    array_walk($ids, function(&$each){
        $each = intval($each);
    });
    $ids = array_unique($ids);
    $ids = "'" . join("','", $ids) . "'";

    $userId = intval($_SESSION['userid']);

	$s = "UPDATE dental_notes SET signed_id = '$userId',
			signed_on = now()
	        WHERE notesid IN ($ids)";

	if($db->query($s)){
		echo '{"success":true}';
	}else{
	 	echo '{"error":true}';
	}
?>
