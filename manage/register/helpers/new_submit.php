<?php include '../../admin/includes/config.php'; ?>
<?php include '../../includes/constants.inc'; ?>
<?php require_once '../../includes/general_functions.php'; ?>
<?php require_once '../../includes/notifications.php'; ?>
<?php require_once '../../admin/includes/password.php'; ?>
<?php

	
if($_POST['userid']==''){
        $sql = "INSERT INTO dental_users set
                name = '".mysql_real_escape_string($_POST['name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                phone = '".mysql_real_escape_string(num($_POST['cell_phone']))."',
		user_access=".DSS_USER_ACCESS_DOCTOR.",
		use_patient_portal = '1',
                use_digital_fax = '0',
                use_letters = '1',
                use_eligible_api = '0',
                use_course = '0',
                use_course_staff = '0',
                user_type = '".DSS_USER_TYPE_SOFTWARE."'
                ";
        	$q = mysql_query($sql);
                $userid = mysql_insert_id();
		mysql_query("INSERT INTO dental_user_company SET userid='".mysql_real_escape_string($userid)."', companyid='".mysql_real_escape_string($_POST["companyid"])."'");
}else{
        $sql = "UPDATE dental_users set
                name = '".mysql_real_escape_string($_POST['name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                phone = '".mysql_real_escape_string(num($_POST['cell_phone']))."'
		WHERE userid='".mysql_real_escape_string($_POST['userid'])."'
                ";
        	$q = mysql_query($sql);
                $userid = $_POST['userid'];
}

	if($q){
		echo '{"userid":"'.$userid.'"}';
	}else{
		//echo "Error";
	}


?>
