<?php
session_start();
require 'admin/includes/main_include.php';
require 'includes/constants.inc';
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=dss_md_export.csv");
header("Pragma: no-cache");
header("Expires: 0");

$csv  = 'Salutation,';
$csv .= 'First Name,';
$csv .= 'Last Name,';
$csv .= 'Middle Init,';
$csv .= 'Company,';
$csv .= 'Address 1,';
$csv .= 'Address 2,';
$csv .= 'City,';
$csv .= 'State,';
$csv .= 'Zip,';
$csv .= 'Phone 1,';
$csv .= 'Phone 2,';
$csv .= 'Fax,';
$csv .= 'Email,';
$csv .= 'National Provider ID,';
$csv .= 'Qualifier,';
$csv .= 'ID,';
$csv .= 'Notes,';
$csv .= 'Preferred Contact Method,';
$csv .= 'Referrer,';
$csv .= 'Status';
$csv .= "\n";

$sql = "select dc.*, dq.qualifier as qualifier_name, 
		(SELECT count(p.patientid) FROM dental_patients p WHERE dc.contactid=p.referred_by 
                        AND p.referred_source=".DSS_REFERRED_PHYSICIAN.") as num_ref
		from dental_contact dc
		JOIN dental_contacttype dct ON dc.contacttypeid = dct.contacttypeid
		LEFT JOIN dental_qualifier dq ON dq.qualifierid = dc.qualifier
		where dc.docid='".$_SESSION['docid']."' 
			AND dct.physician=1
		order by dc.lastname";
$q = mysql_query($sql);
while($r = mysql_fetch_assoc($q)){

$csv .= '"'.$r['salutation'].'",';
$csv .= '"'.$r['firstname'].'",';
$csv .= '"'.$r['lastname'].'",';
$csv .= '"'.$r['middlename'].'",';
$csv .= '"'.$r['company'].'",';
$csv .= '"'.$r['add1'].'",';
$csv .= '"'.$r['add2'].'",';
$csv .= '"'.$r['city'].'",';
$csv .= '"'.$r['state'].'",';
$csv .= '"'.$r['zip'].'",';
$csv .= '"'.$r['phone1'].'",';
$csv .= '"'.$r['phone2'].'",';
$csv .= '"'.$r['fax'].'",';
$csv .= '"'.$r['email'].'",';
$csv .= '"'.$r['national_provider_id'].'",';
$csv .= '"'.$r['qualifier_name'].'",';
$csv .= '"'.$r['qualifierid'].'",';
$csv .= '"'.$r['notes'].'",';
$csv .= '"'.$r['preferredcontact'].'",';
$csv .= '"'.(($r['num_ref']>0)?'Yes':'No').'",';
$csv .= '"'.(($r['status']==1)?'Active':'Inactive').'"';
$csv .= "\n";


}


echo $csv;
?>
