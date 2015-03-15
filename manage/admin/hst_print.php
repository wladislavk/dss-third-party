<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once 'includes/main_include.php';
require_once 'includes/access.php';
require_once '../includes/constants.inc';

if(is_super($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  hst.id, i.company as ins_co, hst.patient_firstname, hst.patient_lastname, hst.patient_dob, hst.authorizeddate, "
     . "  hst.adddate, CONCAT(users.first_name, ' ',users.last_name) as doc_name, hst.status, "
     . "  DATEDIFF(NOW(), hst.adddate) as days_pending, "
     . "  CONCAT(users2.first_name, ' ',users2.last_name) as user_name, "
     . "  CONCAT(users3.first_name, ' ',users3.last_name) as authorized_name, "
     . "  hst_company.name AS hst_company_name "
     . "FROM "
     . "  dental_hst hst "
     . "  LEFT JOIN dental_patients p ON hst.patient_id = p.patientid "
     . "  LEFT JOIN dental_contact i ON hst.ins_co_id = i.contactid "
     . "  JOIN dental_users users ON hst.doc_id = users.userid "
     . "  JOIN dental_users users2 ON hst.user_id = users2.userid "
     . "  LEFT JOIN dental_users users3 ON hst.authorized_id = users3.userid "
     . "  LEFT JOIN companies hst_company ON hst.company_id=hst_company.id ";
}elseif(is_hst($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  hst.id, i.company as ins_co, hst.patient_firstname, hst.patient_lastname, hst.patient_dob, hst.authorizeddate, "
     . "  hst.adddate, CONCAT(users.first_name, ' ',users.last_name) as doc_name, hst.status, "
     . "  DATEDIFF(NOW(), hst.adddate) as days_pending, "
     . "  CONCAT(users2.first_name, ' ',users2.last_name) as user_name, "
     . "  CONCAT(users3.first_name, ' ',users3.last_name) as authorized_name, "
     . "  hst_company.name AS hst_company_name "
     . "FROM "
     . "  dental_hst hst "
     . "  LEFT JOIN dental_patients p ON hst.patient_id = p.patientid "
     . "  LEFT JOIN dental_user_company uc ON uc.userid = p.docid "
     . "  LEFT JOIN dental_contact i ON hst.ins_co_id = i.contactid "
     . "  JOIN dental_users users ON hst.doc_id = users.userid "
     . "  JOIN dental_users users2 ON hst.user_id = users2.userid "
     . "  LEFT JOIN dental_users users3 ON hst.authorized_id = users3.userid "
     . "  JOIN dental_user_hst_company uhc ON uhc.userid=users.userid "
     . "        AND uhc.companyid='".$_SESSION['admincompanyid']."'"
     . "  JOIN companies hst_company ON uhc.companyid=hst_company.id ";

}

$sql .= " WHERE hst.id='".mysql_real_escape_string($_GET['hst'])."'";

$q = mysql_query($sql);
$hst = mysql_fetch_assoc($q);



?>
<html>
<body>
<h1>Home Sleep Test Request</h1>
<h3>Patient: <?= $hst['patient_firstname']; ?> <?= $hst['patient_lastname']; ?></h3>
<h3>DOB: <?= ($hst['patient_dob']!='')?date('m/d/Y', strtotime($hst['patient_dob'])):''; ?></h3>
<h3>Requested by: <?= $hst['authorized_name']; ?></h3>
<p>&nbsp;</p>
<p>Dr. <?= $hst['authorized_name']; ?> has electronically requested a Home Sleep Test for <?= $hst['patient_firstname']; ?> <?= $hst['patient_lastname']; ?> for Obstructive Sleep Apnea (OSA).</p>
<p>Authorized on: <?= ($hst['authorizeddate']!='')?date('m/d/Y h:i a', strtotime($hst['authorizeddate'])):''; ?></p>
</body>
</html>
