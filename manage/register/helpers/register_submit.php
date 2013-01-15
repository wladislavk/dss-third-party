<?php include '../../admin/includes/config.php'; ?>
<?php include '../../includes/constants.inc'; ?>
<?php require_once '../../includes/general_functions.php'; ?>
<?php require_once '../../includes/notifications.php'; ?>
<?php require_once '../../admin/includes/password.php'; ?>
<?php

	

        $sql = "UPDATE dental_users set
                name = '".mysql_real_escape_string($_POST['name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                phone = '".mysql_real_escape_string(num($_POST['phone']))."',
                fax = '".mysql_real_escape_string(num($_POST['fax']))."',
		practice = '".mysql_real_escape_string($_POST['practice'])."',
                address = '".mysql_real_escape_string($_POST['address'])."',
                city = '".mysql_real_escape_string($_POST['city'])."',
                state = '".mysql_real_escape_string($_POST['state'])."',
                zip = '".mysql_real_escape_string($_POST['zip'])."',
		mailing_practice = '".mysql_real_escape_string($_POST['mailing_practice'])."',
                mailing_name = '".mysql_real_escape_string($_POST['mailing_name'])."',
                mailing_phone = '".mysql_real_escape_string($_POST['mailing_phone'])."',
                mailing_address = '".mysql_real_escape_string($_POST['mailing_address'])."',
                mailing_city = '".mysql_real_escape_string($_POST['mailing_city'])."',
                mailing_state = '".mysql_real_escape_string($_POST['mailing_state'])."',
                mailing_zip = '".mysql_real_escape_string($_POST['mailing_zip'])."',
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
			, salt='".$salt."'
			, recover_hash=''
			, status='1' ";
	}	
        $sql .= " WHERE userid='".mysql_real_escape_string($_POST['userid'])."'
                ";
echo $sql;
       $q = mysql_query($sql);
	if($q){
		//echo "Successfully updated!";
	}else{
		//echo "Error";
	}


?>
