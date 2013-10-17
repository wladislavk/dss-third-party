<?php
require_once 'includes/main_include.php';
require_once 'includes/sescheck.php';
require_once '../includes/constants.inc';
require_once 'includes/access.php';
if(is_super($_SESSION['admin_access'])){
$s = "select CONCAT(u.first_name,' ',u.last_name) name,
	u.email, 
	c.name as company_name, 
	u.address, 
	u.city, 
	u.state, 
	u.zip, 
	u.phone, 
	u.fax,
	u.status 
	FROM dental_users u 
	JOIN dental_user_company uc on uc.userid=u.userid 
	JOIN companies c ON c.id=uc.companyid";
}elseif(is_software($_SESSION['admin_access'])){
$s = "select CONCAT(u.first_name,' ',u.last_name) name, 
        u.email, 
        c.name as company_name, 
        u.address, 
        u.city, 
        u.state, 
        u.zip, 
        u.phone, 
        u.fax,
        u.status 
        FROM dental_users u 
        JOIN dental_user_company uc on uc.userid=u.userid 
        JOIN companies c ON c.id=uc.companyid
                WHERE c.id='".mysql_real_escape_string($_SESSION['admincompanyid'])."'";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
$s = "select CONCAT(u.first_name,' ',u.last_name) name, 
        u.email, 
        c.name as company_name, 
        u.address, 
        u.city, 
        u.state, 
        u.zip, 
        u.phone, 
        u.fax,
        u.status 
        FROM dental_users u 
        JOIN dental_user_company uc on uc.userid=u.userid 
        JOIN companies c ON c.id=uc.companyid
		WHERE u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."'";
}
$q = mysql_query($s);
$csv = "\"Name\",\"Email\",\"Company\",\"Address\",\"City\",\"State\",\"Zip\",\"Phone\",\"Fax\",\"Status\"\n";
while($r = mysql_fetch_assoc($q)){
	switch($r['status']){
		case '1':
			$status="Active";
			break;
		case '2':
			$status = "Inactive";
			break;
		default:
			$status = "";
			break;
	}

	$csv .="\"".$r['name']."\",";
        $csv .="\"".$r['email']."\",";
        $csv .="\"".$r['company_name']."\",";
        $csv .="\"".$r['address']."\",";
        $csv .="\"".$r['city']."\",";
        $csv .="\"".$r['state']."\",";
        $csv .="\"".$r['zip']."\",";
        $csv .="\"".$r['phone']."\",";
        $csv .="\"".$r['fax']."\",";
	$csv .="\"".$status."\"";
        $csv .="\n";
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=users.csv');
header('Pragma: no-cache');
echo($csv);
