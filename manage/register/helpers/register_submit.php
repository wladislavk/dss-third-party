<?php include '../../admin/includes/main_include.php'; ?>
<?php include '../../includes/constants.inc'; ?>
<?php require_once '../../includes/general_functions.php'; ?>
<?php require_once '../../includes/notifications.php'; ?>
<?php require_once '../../admin/includes/password.php'; ?>
<?php include '../../includes/edx_functions.php'; ?>
<?php include_once '../../includes/help_functions.php'; ?>
<?php

	

        $sql = "UPDATE dental_users set
                first_name = '".mysql_real_escape_string($_POST['first_name'])."',
                last_name = '".mysql_real_escape_string($_POST['last_name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                phone = '".mysql_real_escape_string(num($_POST['phone']))."',
                fax = '".mysql_real_escape_string(num($_POST['fax']))."',
		practice = '".mysql_real_escape_string($_POST['practice'])."',
                address = '".mysql_real_escape_string($_POST['address'])."',
                city = '".mysql_real_escape_string($_POST['city'])."',
                state = '".mysql_real_escape_string($_POST['state'])."',
                zip = '".mysql_real_escape_string($_POST['zip'])."',
		npi = '".mysql_real_escape_string($_POST['npi'])."',
                medicare_npi = '".mysql_real_escape_string($_POST['medicare_npi'])."',
                medicare_ptan = '".mysql_real_escape_string($_POST['medicare_ptan'])."',
                tax_id_or_ssn = '".mysql_real_escape_string($_POST['tax_id_or_ssn'])."',
                ein = '".mysql_real_escape_string($_POST['ein'])."',
                ssn = '".mysql_real_escape_string($_POST['ssn'])."',
		username = '".mysql_real_escape_string($_POST['username'])."'";
	if($_POST['password'] != '' && $_POST['password'] == $_POST['confirm_password']){
		echo $_POST['password'];
		$salt = create_salt();
                $password = gen_password($_POST['password'], $salt);
		$sql .= ", password='".$password."' 
			, salt='".$salt."'";
	}	
        $sql .= " WHERE userid='".mysql_real_escape_string($_POST['userid'])."'
                ";
//echo $sql;
        $q = mysql_query($sql);
		$loc_s = "SELECT * FROM dental_locations WHERE default_location=1 AND docid = '".$_POST['userid']."'";
		$loc_q = mysql_query($loc_s);
		if(mysql_num_rows($loc_q)>0){
			$loc_r = mysql_fetch_assoc($loc_q);
                        $loc_sql = "UPDATE dental_locations SET
                                location = '".s_for($_POST['mailing_practice'])."', 
                                name = '".s_for($_POST["mailing_name"])."', 
                                address = '".s_for($_POST["mailing_address"])."', 
                                city = '".s_for($_POST["mailing_city"])."', 
                                state = '".s_for($_POST["mailing_state"])."', 
                                zip = '".s_for($_POST["mailing_zip"])."', 
                                phone = '".s_for(num($_POST["mailing_phone"]))."',
                                fax = '".s_for(num($_POST["fax"]))."'
				WHERE 
                                id = '".mysql_real_escape_string($loc_r['id'])."'"; 
		}else{
                        $loc_sql = "INSERT INTO dental_locations SET
                                location = '".s_for($_POST['mailing_practice'])."', 
                                name = '".s_for($_POST["mailing_name"])."', 
                                address = '".s_for($_POST["mailing_address"])."', 
                                city = '".s_for($_POST["mailing_city"])."', 
                                state = '".s_for($_POST["mailing_state"])."', 
                                zip = '".s_for($_POST["mailing_zip"])."', 
                                phone = '".s_for(num($_POST["mailing_phone"]))."',
                                fax = '".s_for(num($_POST["fax"]))."',
                                default_location=1,
                                docid='".$_POST['userid']."',
                                adddate=now(),
                                ip_address='".$_SERVER['REMOTE_ADDR']."'";
		}
                        mysql_query($loc_sql);

		$userid = mysql_insert_id();
		edx_user_update($userid, $edx_con);
		help_user_update($userid, $help_con);

                        $co_sql = "SELECT c.id, c.name from companies c
                                        JOIN dental_user_company uc ON c.id = uc.companyid
                                        JOIN dental_users u ON u.userid = uc.userid
                                         WHERE u.userid='".mysql_real_escape_string($userid)."'";
                        $co_q = mysql_query($co_sql);
                        $co_r = mysql_fetch_assoc($co_q);
                        $cid = $co_r['id'];
                        $cname = $co_r['name'];

	if($q){
		//echo "Successfully updated!";
	}else{
		//echo "Error";
	}


?>
