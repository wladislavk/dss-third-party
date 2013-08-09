<?php
require_once 'includes/main_include.php';
require_once 'includes/sescheck.php';
$s = "select u.name, 
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
