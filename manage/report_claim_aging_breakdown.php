<?php namespace Ds3\Libraries\Legacy; ?><?php include_once('admin/includes/main_include.php'); 

if($office_type == DSS_OFFICE_TYPE_BACK) {
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
    if(is_software($_SESSION['admin_access'])) {
        $s .= "  JOIN dental_user_company uc ON uc.userid = u.userid ";
    }

    $s .= " WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
            (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
          ";

    if(isset($_GET['fid'])){
        $s .= " AND p.docid='".mysqli_real_escape_string($con, $_GET['fid'])."' ";
    }
    if(isset($_GET['bc'])){
        $s .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
    }
    if(isset($_GET['nbc'])){
        $s .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
    }

    if(is_software($_SESSION['admin_access'])){
        $s .= " AND uc.companyid='".mysqli_real_escape_string($con, $_SESSION['admincompanyid'])."' ";
    }
    if(is_billing($_SESSION['admin_access'])){
        $a_sql = "SELECT ac.companyid FROM admin_company ac
                  JOIN admin a ON a.adminid = ac.adminid
                  WHERE a.adminid='".mysqli_real_escape_string($con, $_SESSION['adminuserid'])."'";

        $admin = $db->getRow($a_sql);
        $s .= " AND u.billing_company_id='".mysqli_real_escape_string($con, $admin['companyid'])."' ";
    }
} else {
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

$q = $db->getResults($s);
?>
    <span class="admin_head">
      0-29 days
    </span>

<?php include 'partials/claim_aging_breakdown_table.php';

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
        $s .= "  JOIN dental_user_company uc ON uc.userid = u.userid ";
    }
    $s .= " WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
            (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE
            l.primary_claim_id=i.insuranceid),0))>0
          ";

    if(isset($_GET['fid'])){
        $s .= " AND p.docid='".mysqli_real_escape_string($con, $_GET['fid'])."' ";
    }
    if(isset($_GET['bc'])){
        $s .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
    }
    if(isset($_GET['nbc'])){
        $s .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
    }

    if(is_software($_SESSION['admin_access'])){
        $s .= " AND uc.companyid='".mysqli_real_escape_string($con, $_SESSION['admincompanyid'])."' ";
    }
    if(is_billing($_SESSION['admin_access'])){
        $a_sql = "SELECT ac.companyid FROM admin_company ac
                  JOIN admin a ON a.adminid = ac.adminid
                  WHERE a.adminid='".mysqli_real_escape_string($con, $_SESSION['adminuserid'])."'";
        
        $admin = $db->getRow($a_sql);
        $s .= " AND u.billing_company_id='".mysqli_real_escape_string($con, $admin['companyid'])."' ";
    }
} else {
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

$q = $db->getResults($s);
?>
    <span class="admin_head">
      30-59 days
    </span>

<?php include 'partials/claim_aging_breakdown_table.php'; 

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
        $s .= "  JOIN dental_user_company uc ON uc.userid = u.userid ";
    }

    $s .= " WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND
            (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
          ";

    if(isset($_GET['fid'])){
        $s .= " AND p.docid='".mysqli_real_escape_string($con, $_GET['fid'])."' ";
    }
    if(isset($_GET['bc'])){
        $s .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
    }
    if(isset($_GET['nbc'])){
        $s .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
    }

    if(is_software($_SESSION['admin_access'])){
        $s .= " AND uc.companyid='".mysqli_real_escape_string($con, $_SESSION['admincompanyid'])."' ";
    }
    if(is_billing($_SESSION['admin_access'])){
        $a_sql = "SELECT ac.companyid FROM admin_company ac
                  JOIN admin a ON a.adminid = ac.adminid
                  WHERE a.adminid='".mysqli_real_escape_string($con, $_SESSION['adminuserid'])."'";

        $admin = $db->getRow($a_sql);
        $s .= " AND u.billing_company_id='".mysqli_real_escape_string($con, $admin['companyid'])."' ";
    }
} else {
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

$q = $db->getResults($s);
?>
    <span class="admin_head">
      60-89 days
    </span>

<?php include 'partials/claim_aging_breakdown_table.php';

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
        $s .= "  JOIN dental_user_company uc ON uc.userid = u.userid ";
    }

    $s .= " WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND
            (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
          ";

    if(isset($_GET['fid'])){
        $s .= " AND p.docid='".mysqli_real_escape_string($con, $_GET['fid'])."' ";
    }
    if(isset($_GET['bc'])){
        $s .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
    }
    if(isset($_GET['nbc'])){
        $s .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
    }

    if(is_software($_SESSION['admin_access'])){
        $s .= " AND uc.companyid='".mysqli_real_escape_string($con, $_SESSION['admincompanyid'])."' ";
    }
    if(is_billing($_SESSION['admin_access'])){
        $a_sql = "SELECT ac.companyid FROM admin_company ac
                  JOIN admin a ON a.adminid = ac.adminid
                  WHERE a.adminid='".mysqli_real_escape_string($con, $_SESSION['adminuserid'])."'";
        
        $admin = $db->getRow($a_sql);
        $s .= " AND u.billing_company_id='".mysqli_real_escape_string($con, $admin['companyid'])."' ";
    }
} else {
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

$q = $db->getResults($s);
?>
    <span class="admin_head">
      90-119 days
    </span>

<?php include 'partials/claim_aging_breakdown_table.php'; 

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
        $s .= "  JOIN dental_user_company uc ON uc.userid = u.userid ";
    }

    $s .= " WHERE i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND
            (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE
            l.primary_claim_id=i.insuranceid),0))>0
          ";
    if(isset($_GET['fid'])){
        $s .= " AND p.docid='".mysqli_real_escape_string($con, $_GET['fid'])."' ";
    }
    if(isset($_GET['bc'])){
        $s .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
    }
    if(isset($_GET['nbc'])){
        $s .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
    }

    if(is_software($_SESSION['admin_access'])){
        $s .= " AND uc.companyid='".mysqli_real_escape_string($con, $_SESSION['admincompanyid'])."' ";
    }
    if(is_billing($_SESSION['admin_access'])){
        $a_sql = "SELECT ac.companyid FROM admin_company ac
                  JOIN admin a ON a.adminid = ac.adminid
                  WHERE a.adminid='".mysqli_real_escape_string($con, $_SESSION['adminuserid'])."'";

        $admin = $db->getRow($a_sql);
        $s .= " AND u.billing_company_id='".mysqli_real_escape_string($con, $admin['companyid'])."' ";
    }
} else {
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

$q = $db->getResults($s);
?>
    <span class="admin_head">
      120+ Days
    </span>
<?php include 'partials/claim_aging_breakdown_table.php'; ?>
