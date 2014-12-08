<?php
include_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/constants.inc';
include_once 'includes/access.php';
if(is_super($_SESSION['admin_access'])){
$s = "select u.first_name,u.last_name,
	u.email, 
	c.name as company_name, 
	u.practice,
	u.address, 
	u.city, 
	u.state, 
	u.zip, 
	u.phone, 
	u.fax,
	u.status,
	u.suspended_reason,
        u.suspended_date,
	u.adddate 
	FROM dental_users u 
	JOIN dental_user_company uc on uc.userid=u.userid 
	JOIN companies c ON c.id=uc.companyid";
}elseif(is_software($_SESSION['admin_access'])){
$s = "select u.first_name,u.last_name, 
        u.email, 
        c.name as company_name, 
	u.practice,
        u.address, 
        u.city, 
        u.state, 
        u.zip, 
        u.phone, 
        u.fax,
        u.status,
        u.suspended_reason,
        u.suspended_date,
	u.adddate
        FROM dental_users u 
        JOIN dental_user_company uc on uc.userid=u.userid 
        JOIN companies c ON c.id=uc.companyid
                WHERE c.id='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."'";
  $a_q = mysqli_query($con,$a_sql);
  $admin = mysqli_fetch_assoc($a_q);
$s = "select u.first_name,u.last_name, 
        u.email, 
        c.name as company_name, 
	u.practice,
        u.address, 
        u.city, 
        u.state, 
        u.zip, 
        u.phone, 
        u.fax,
        u.status,
        u.suspended_reason,
        u.suspended_date,
	u.adddate 
        FROM dental_users u 
        JOIN dental_user_company uc on uc.userid=u.userid 
        JOIN companies c ON c.id=uc.companyid
		WHERE u.billing_company_id='".mysqli_real_escape_string($con,$admin['companyid'])."'";
}
$q = mysqli_query($con,$s);
$csv = "\"First Name\",\"Last Name\",\"Email\",\"Company\",\"Practice\",\"Address\",\"City\",\"State\",\"Zip\",\"Phone\",\"Fax\",\"Status\",\"Created\",\"Suspended\"\n";
while($r = mysqli_fetch_assoc($q)){
	switch($r['status']){
		case '1':
			$status="Active";
			$sus_date = '';
			break;
		case '2':
			$status = "Inactive";
			$sus_date = '';
			break;
		case '3':
			$status = "Suspended - ".$r['suspended_reason'];
			$sus_date = $r['suspended_date'];
			break;	
 		default:
			$status = "";
			break;
	}

	$csv .="\"".$r['first_name']."\",";
	$csv .="\"".$r['last_name']."\",";
        $csv .="\"".$r['email']."\",";
        $csv .="\"".$r['company_name']."\",";
        $csv .="\"".$r['practice']."\",";
        $csv .="\"".$r['address']."\",";
        $csv .="\"".$r['city']."\",";
        $csv .="\"".$r['state']."\",";
        $csv .="\"".$r['zip']."\",";
        $csv .="\"".$r['phone']."\",";
        $csv .="\"".$r['fax']."\",";
	$csv .="\"".$status."\",";
	$csv .="\"".$r['adddate']."\",";
	$csv .="\"".$sus_date."\"";
        $csv .="\n";
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=users.csv');
header('Pragma: no-cache');
echo($csv);
