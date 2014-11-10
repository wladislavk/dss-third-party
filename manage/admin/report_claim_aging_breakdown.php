
<?php
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
		l.amount, l.ledgerid, l.transaction_code,
		(SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
		FROM dental_insurance i
			LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
			LEFT JOIN dental_patients p ON p.patientid=i.patientid
	WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
		(COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
	";

  $q = $db->getResults($s);
?>
<span class="admin_head">
  0-29 days
</span>
<?php include '../partials/claim_aging_breakdown_table.php'; ?>



<?php
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
        WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
        ";

  $q = $db->getResults($s);
?>
<span class="admin_head">
  30-59 days
</span>
<?php include '../partials/claim_aging_breakdown_table.php'; ?>

<?php
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
        WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
        ";

  $q = $db->getResults($s);
?>
<span class="admin_head">
  60-89 days
</span>
<?php include '../partials/claim_aging_breakdown_table.php'; ?>


<?php
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
        WHERE i.mailed_date > DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
        ";

  $q = $db->getResults($s);
?>
<span class="admin_head">
  90-119 days
</span>
<?php include '../partials/claim_aging_breakdown_table.php'; ?>

<?php
  $s = "SELECT i.insuranceid, i.mailed_date, l.service_date, p.patientid, p.firstname, p.lastname, i.total_charge,
                l.amount, l.ledgerid, l.transaction_code,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l2 ON l2.ledgerid=dlp.ledgerid WHERE l2.ledgerid=l.ledgerid AND dlp.payer in (0,1)) AS ins_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l3 ON l3.ledgerid=dlp.ledgerid WHERE l3.ledgerid=l.ledgerid AND dlp.payer in (2)) AS client_payment,
                (SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l4 ON l4.ledgerid=dlp.ledgerid WHERE l4.ledgerid=l.ledgerid AND dlp.payer in (3,4)) AS adj_payment
                FROM dental_insurance i
                        LEFT JOIN dental_ledger l ON l.primary_claim_id=i.insuranceid
                        LEFT JOIN dental_patients p ON p.patientid=i.patientid
        WHERE i.mailed_date <= DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND
                (COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0) - COALESCE((SELECT SUM(dlp.amount) FROM dental_ledger_payment dlp INNER JOIN dental_ledger l ON l.ledgerid=dlp.ledgerid WHERE l.primary_claim_id=i.insuranceid),0))>0
        ";

  $q = $db->getResults($s);
?>
<span class="admin_head">
  120+ Days
</span>
<?php include '../partials/claim_aging_breakdown_table.php'; ?>

