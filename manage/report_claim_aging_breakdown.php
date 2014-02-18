
<?php
if($office_type == DSS_OFFICE_TYPE_BACK){
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
                        LEFT JOIN dental_users u ON u.userid=p.docid
";
if(is_software($_SESSION['admin_access'])){
  $s .=       "  JOIN dental_user_company uc ON uc.userid = u.userid ";
}

$s .= "       WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
             ";
if(isset($_GET['fid'])){
  $s .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
if(is_software($_SESSION['admin_access'])){
  $s .= " AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' ";
}
if(is_billing($_SESSION['admin_access'])){
$a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
  $s .= " AND u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."' ";
}
}else{
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
		CONCAT(u.first_name, ' ', u.last_name) doc_name,
		l.amount, l.ledgerid, l.transaction_code,
		(SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
		FROM dental_insurance i
			LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
			LEFT JOIN dental_patients p ON p.patientid=i.patientid
			LEFT JOIN dental_users u ON u.userid=p.docid
	WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
		(COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
		AND p.docid='".$_SESSION['docid']."'";
} 

  $q= mysql_query($s);
?>
<span class="admin_head">
  0-29 days
</span>
<?php include 'partials/claim_aging_breakdown_table.php'; ?>



<?php
if($office_type==DSS_OFFICE_TYPE_BACK){

  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
                        LEFT JOIN dental_users u ON u.userid=p.docid
        ";
if(is_software($_SESSION['admin_access'])){
  $s .=       "  JOIN dental_user_company uc ON uc.userid = u.userid ";
}

$s .= " WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE
 l.primary_claim_id=i.insuranceid),0))>0
        ";
if(isset($_GET['fid'])){
  $s .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
if(is_software($_SESSION['admin_access'])){
  $s .= " AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' ";
}
if(is_billing($_SESSION['admin_access'])){
$a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
  $s .= " AND u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."' ";
}


}else{
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
		CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
			LEFT JOIN dental_users u ON u.userid=p.docid
        WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
		AND p.docid='".$_SESSION['docid']."'";
} 

  $q= mysql_query($s);
?>
<span class="admin_head">
  30-59 days
</span>
<?php include 'partials/claim_aging_breakdown_table.php'; ?>

<?php
if($office_type==DSS_OFFICE_TYPE_BACK){
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
                        LEFT JOIN dental_users u ON u.userid=p.docid
        ";
if(is_software($_SESSION['admin_access'])){
  $s .=       "  JOIN dental_user_company uc ON uc.userid = u.userid ";
}

$s .= " WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
        ";
if(isset($_GET['fid'])){
  $s .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
if(is_software($_SESSION['admin_access'])){
  $s .= " AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' ";
}
if(is_billing($_SESSION['admin_access'])){
$a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
  $s .= " AND u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."' ";
}

}else{
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
		CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
			LEFT JOIN dental_users u ON u.userid=p.docid
        WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
		AND p.docid='".$_SESSION['docid']."'";
} 


  $q= mysql_query($s);
?>
<span class="admin_head">
  60-89 days
</span>
<?php include 'partials/claim_aging_breakdown_table.php'; ?>


<?php
if($office_type==DSS_OFFICE_TYPE_BACK){
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
                        LEFT JOIN dental_users u ON u.userid=p.docid
        ";
if(is_software($_SESSION['admin_access'])){
  $s .=       "  JOIN dental_user_company uc ON uc.userid = u.userid ";
}

$s .= " WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
        ";
if(isset($_GET['fid'])){
  $s .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
if(is_software($_SESSION['admin_access'])){
  $s .= " AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' ";
}
if(is_billing($_SESSION['admin_access'])){
$a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
  $s .= " AND u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."' ";
}


}else{
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
		CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
			LEFT JOIN dental_users u ON u.userid=p.docid
        WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
		AND p.docid='".$_SESSION['docid']."'";
} 


  $q= mysql_query($s);
?>
<span class="admin_head">
  90-119 days
</span>
<?php include 'partials/claim_aging_breakdown_table.php'; ?>

<?php
if($office_type==DSS_OFFICE_TYPE_BACK){
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid                        LEFT JOIN dental_users u ON u.userid=p.docid
        ";
if(is_software($_SESSION['admin_access'])){
  $s .=       "  JOIN dental_user_company uc ON uc.userid = u.userid ";
}

$s .= " WHERE i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE
 l.primary_claim_id=i.insuranceid),0))>0
        ";
if(isset($_GET['fid'])){
  $s .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
if(is_software($_SESSION['admin_access'])){
  $s .= " AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' ";
}
if(is_billing($_SESSION['admin_access'])){
$a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
  $s .= " AND u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."' ";
}

}else{
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
		CONCAT(u.first_name, ' ', u.last_name) doc_name,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
			LEFT JOIN dental_users u ON u.userid=p.docid
        WHERE i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
		AND p.docid='".$_SESSION['docid']."'";
} 


  $q= mysql_query($s);
?>
<span class="admin_head">
  120+ Days
</span>
<?php include 'partials/claim_aging_breakdown_table.php'; ?>

