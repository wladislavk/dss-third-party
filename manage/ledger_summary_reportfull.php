
<div class="fullwidth">
<h3>Charges</h3>
<ul>
<?php
  $ch_total = 0;
  $ch_sql = "SELECT dl.description, sum(dl.amount) amount FROM dental_ledger dl
		JOIN dental_patients p ON p.patientid=dl.patientid
		WHERE amount != '' 
		AND dl.service_date=CURDATE()
		AND p.docid='".mysql_real_escape_string($_SESSION['docid'])."' ";

	if(isset($_GET['pid'])){
		$ch_sql .= " AND dl.patientid='".mysql_real_escape_string($_GET['pid'])."' ";
	}
	$ch_sql .= " GROUP BY dl.description";
  $ch_q = $db->getResults($ch_sql);

  if ($ch_q) {
    foreach ($ch_q as $ch_r){ 
      echo "<li><label>" . $ch_r['description'] . "</label> $" . number_format($ch_r['amount'],2) . "</li>";
      $ch_total += $ch_r['amount']; 
    }
  } ?>
  <li><label>Charges Total</label> $<?php echo number_format($ch_total,2); ?></li>
</ul>

<h3>Credit</h3>
<ul>
<?php
  $cr_total = 0;
  $cr_sql = "SELECT dl.description, sum(dl.paid_amount) amount FROM dental_ledger dl
		LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
                WHERE paid_amount != '' 
		AND dl.service_date = CURDATE()
		AND dl.docid='".$_SESSION['docid']."'
		AND tc.type != '".DSS_TRXN_TYPE_ADJ."'
		";
        if(isset($_GET['pid'])){
                $cr_sql .= " AND dl.patientid='".mysql_real_escape_string($_GET['pid'])."' ";
        }
                $cr_sql .= " GROUP BY dl.description";
  $cr_q = $db->getResults($cr_sql);

  if ($cr_q) {
    foreach ($cr_q as $cr_r){ 
      echo "<li><label>" . $cr_r['description'] . "</label> $" . number_format($cr_r['amount'],2) . "</li>";
      $cr_total += $cr_r['amount']; 
    }
  } ?>
  <li><label>Credits Total</label> $<?php echo number_format($cr_total,2); ?></li>
</ul>

<h3>Adjustments</h3>
<ul>
<?php            
  $adj_total = 0;
  $adj_sql = "SELECT dl.description, sum(dl.paid_amount) amount FROM dental_ledger dl
                JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
                WHERE paid_amount != ''
		AND dl.service_date = CURDATE() 
		AND dl.docid='".$_SESSION['docid']."'
                AND tc.type = '".DSS_TRXN_TYPE_ADJ."'
                ";
        if(isset($_GET['pid'])){
                $adj_sql .= " AND dl.patientid='".mysql_real_escape_string($_GET['pid'])."' ";
        }
                $adj_sql .= " GROUP BY dl.description";
  $adj_q = $db->getResults($adj_sql);

  if ($adj_q) {
    foreach ($adj_q as $adj_r){ 
      echo "<li><label>" . $adj_r['description'] . "</label> $" . number_format($adj_r['amount'],2) . "</li>";
      $cr_total += $adj_r['amount']; 
    }
  } ?>
  <li><label>Adjust. Total</label> $<?php echo number_format($adj_total,2); ?></li>
</ul>

