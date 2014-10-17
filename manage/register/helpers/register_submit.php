<?php
    include '../../admin/includes/main_include.php';
    include '../../includes/constants.inc';
    include_once '../../includes/general_functions.php';
    include_once '../../includes/notifications.php';
    include_once '../../admin/includes/password.php';
    include '../../includes/edx_functions.php';
    include_once '../../includes/help_functions.php';	

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
        	use_service_npi = '".mysql_real_escape_string($_POST['use_service_npi'])."',
        	service_name = '".mysql_real_escape_string($_POST['service_name'])."',
        	service_address = '".mysql_real_escape_string($_POST['service_address'])."',
        	service_city = '".mysql_real_escape_string($_POST['service_city'])."',
        	service_state = '".mysql_real_escape_string($_POST['service_state'])."',
        	service_zip = '".mysql_real_escape_string($_POST['service_zip'])."',
        	service_phone = '".mysql_real_escape_string($_POST['service_phone'])."',
        	service_fax = '".mysql_real_escape_string($_POST['service_fax'])."',
        	service_npi = '".mysql_real_escape_string($_POST['service_npi'])."',
            service_medicare_npi = '".mysql_real_escape_string($_POST['service_medicare_npi'])."',
            service_medicare_ptan = '".mysql_real_escape_string($_POST['service_medicare_ptan'])."',
            service_tax_id_or_ssn = '".mysql_real_escape_string($_POST['service_tax_id_or_ssn'])."',
            service_ein = '".mysql_real_escape_string($_POST['service_ein'])."',
            service_ssn = '".mysql_real_escape_string($_POST['service_ssn'])."',
		    username = '".mysql_real_escape_string($_POST['username'])."'";

	if($_POST['password'] != '' && $_POST['password'] == $_POST['confirm_password']){
		$salt = create_salt();
        $password = gen_password($_POST['password'], $salt);
		$sql .= ", password='".$password."' 
			     , salt='".$salt."'";
	}	
    
    $sql .= " WHERE userid='".mysql_real_escape_string($_POST['userid'])."'";

    $q = $db->query($sql);
	$loc_s = "SELECT * FROM dental_locations WHERE default_location=1 AND docid = '".$_POST['userid']."'";
	
    $loc_q = $db->getResults($loc_s);
	if(count($loc_q) > 0) {
		$loc_r = $loc_q[0];
        $loc_sql = "UPDATE dental_locations SET
                    location = '".s_for($_POST['mailing_practice'])."', 
			        email = '".s_for($_POST['mailing_email'])."',
                    name = '".s_for($_POST["mailing_name"])."', 
                    address = '".s_for($_POST["mailing_address"])."', 
                    city = '".s_for($_POST["mailing_city"])."', 
                    state = '".s_for($_POST["mailing_state"])."', 
                    zip = '".s_for($_POST["mailing_zip"])."', 
                    phone = '".s_for(num($_POST["mailing_phone"]))."',
                    fax = '".s_for(num($_POST["fax"]))."'
			        WHERE 
                    id = '".mysql_real_escape_string($loc_r['id'])."'"; 
	} else {
        $loc_sql = "INSERT INTO dental_locations SET
                    location = '".s_for($_POST['mailing_practice'])."', 
				    email = '".s_for($_POST['mailing_email'])."',
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

	$userid = $db->getInsertId($loc_sql);
	edx_user_update($userid, $edx_con);
	help_user_update($userid, $help_con);

    $co_sql = "SELECT c.id, c.name from companies c
               JOIN dental_user_company uc ON c.id = uc.companyid
               JOIN dental_users u ON u.userid = uc.userid
               WHERE u.userid='".mysql_real_escape_string($userid)."'";

    $co_r = $db->getRow($co_sql);
    $cid = $co_r['id'];
    $cname = $co_r['name'];

	if($q){
		//echo "Successfully updated!";
	}else{
		//echo "Error";
	}

?>
