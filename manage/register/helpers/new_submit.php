<?php include '../../admin/includes/main_include.php'; ?>
<?php include '../../includes/constants.inc'; ?>
<?php require_once '../../includes/general_functions.php'; ?>
<?php require_once '../../includes/notifications.php'; ?>
<?php require_once '../../admin/includes/password.php'; ?>
<?php

        $c_sql = "SELECT id, plan_id FROM dental_access_codes WHERE status='1' AND access_code='".$_POST['code']."'";
        $c_q = mysql_query($c_sql);
        $c_r = mysql_fetch_assoc($c_q);
	$access_code_id = $c_r['id'];
	$plan_id = $c_r['plan_id'];
	
if($_POST['userid']==''){
        $sql = "INSERT INTO dental_users set
                first_name = '".mysql_real_escape_string($_POST['first_name'])."',
		last_name = '".mysql_real_escape_string($_POST['last_name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                phone = '".mysql_real_escape_string(num($_POST['cell_phone']))."',
		access_code_id = '".mysql_real_escape_string($access_code_id)."',
		plan_id = '".mysql_real_escape_string($plan_id)."',
		user_access=".DSS_USER_ACCESS_DOCTOR.",
		use_patient_portal = '1',
                use_digital_fax = '1',
                use_letters = '1',
                use_eligible_api = '0',
                use_course = '0',
                use_course_staff = '0',
		homepage = '1',
                user_type = '".DSS_USER_TYPE_SOFTWARE."',
		adddate = now(),
		ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'
                ";
        	$q = mysql_query($sql);
                $userid = mysql_insert_id();
		mysql_query("INSERT INTO dental_user_company SET userid='".mysql_real_escape_string($userid)."', companyid='".mysql_real_escape_string($_POST["companyid"])."'");
                        mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('General', 'FFF9CF', 'general', ".$userid.")");
                        mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Follow-up', 'D6CFFF', 'follow-up', ".$userid.")");
                        mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Sleep Test', 'CFF5FF', 'sleep_test', ".$userid.")");
                        mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Impressions', 'DFFFCF', 'impressions', ".$userid.")");
                        mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('New Pt', 'FFCFCF', 'new_pt', ".$userid.")");
                        mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Deliver Device', 'FBA16C', 'deliver_device', ".$userid.")");

                        mysql_query("INSERT INTO `dental_resources` (name, rank, docid) VALUES ('Chair 1', 1, ".$userid.")");


                        $code_sql = "insert into dental_transaction_code (transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, docid, amount_adjust) SELECT transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, ".$userid.", amount_adjust FROM dental_transaction_code WHERE default_code=1";
                        mysql_query($code_sql) or die($code_sql.mysql_error());
                        $custom_sql = "insert into dental_custom (title, description, docid) SELECT title, description, ".$userid." FROM dental_custom WHERE default_text=1";
                        mysql_query($custom_sql) or die($custom_sql.mysql_error());

}else{
        $sql = "UPDATE dental_users set
                first_name = '".mysql_real_escape_string($_POST['first_name'])."',
                last_name = '".mysql_real_escape_string($_POST['last_name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
		access_code_id = '".mysql_real_escape_string($access_code_id)."',
		plan_id = '".mysql_real_escape_string($plan_id)."',
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
