<?php namespace Ds3\Libraries\Legacy; ?><?php include_once 'admin/includes/main_include.php';
      include_once 'includes/constants.inc' ?>

<div class="fullwidth">
  <h3>Charges</h3>
  <ul>
<?php
  $ch_total = 0;
  $ch_sql = "SELECT dl.description, sum(dl.amount) amount FROM dental_ledger dl
                JOIN dental_patients p ON p.patientid=dl.patientid
                WHERE amount != '' 
                AND p.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' 
            		".(!empty($lpsql) ? $lpsql : '')." ".(!empty($l_date) ? $l_date : '')."
                ";
	if(isset($_GET['pid'])){
		$ch_sql .= " AND dl.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' ";
	}
	$ch_sql .= " GROUP BY dl.description";
  $ch_q = $db->getResults($ch_sql);
  if ($ch_q) foreach ($ch_q as $ch_r) {?>
    <li><label><?php echo $ch_r['description']; ?></label> $<?php echo number_format($ch_r['amount'],2); ?></li>
	<?php 
    $ch_total += $ch_r['amount']; 
  } ?>
    <li><label>Charges Total</label> $<?php echo number_format($ch_total,2); ?></li>
  </ul>

  <h3>Credit</h3>
  <ul>
<?php
  $cr_total = 0;
  $cr_sql = "SELECT dlp.payment_type description, sum(dlp.amount) amount, sum(dl.paid_amount) FROM dental_ledger dl
		JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
		JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                JOIN dental_patients p ON p.patientid=dl.patientid
                WHERE dlp.amount != '' 
                AND p.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'
		AND tc.type != '".DSS_TRXN_TYPE_ADJ."'
		".(!empty($lpsql) ? $lpsql : '')." ".(!empty($p_date) ? $p_date : '')."
		";
        if(isset($_GET['pid'])){
                $cr_sql .= " AND dl.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' ";
        }
                $cr_sql .= " GROUP BY description";

  $cr_q = $db->getResults($cr_sql);
  if ($cr_q) foreach ($cr_q as $cr_r) {?>
    <li><label><?php echo $dss_trxn_pymt_type_labels[$cr_r['description']]; ?></label> $<?php echo number_format($cr_r['amount'],2); ?></li>
  <?php 
      $cr_total += $cr_r['amount'];
  } 
  $cr2_sql = "SELECT dl.description, sum(dl.paid_amount) amount FROM dental_ledger dl
                JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
                JOIN dental_patients p ON p.patientid=dl.patientid
                WHERE paid_amount != '' 
                AND p.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' 
                AND tc.type != '".DSS_TRXN_TYPE_ADJ."'
                ".(!empty($lpsql) ? $lpsql : '')." ".(!empty($l_date) ? $l_date : '')."
                ";
  if(isset($_GET['pid'])){
    $cr2_sql .= " AND dl.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' ";
  }
  $cr2_sql .= " GROUP BY dl.description";
  $cr2_q = $db->getResults($cr2_sql);
  if ($cr2_q) foreach ($cr2_q as $cr2_r) {?>
    <li><label><?php echo $cr2_r['description']; ?></label> $<?php echo number_format($cr2_r['amount'],2); ?></li>
  <?php 
    $cr_total += $cr2_r['amount'];
  } ?>

    <li><label>Credits Total</label> $<?php echo number_format($cr_total,2); ?></li>
  </ul>

  <h3>Adjustments</h3>
  <ul>
<?php            
  $adj_total = 0;
  $adj_sql = "SELECT dl.description, sum(dl.paid_amount) amount FROM dental_ledger dl
                JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
                JOIN dental_patients p ON p.patientid=dl.patientid
                WHERE paid_amount != '' 
                AND p.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' 
                AND tc.type = '".DSS_TRXN_TYPE_ADJ."'
            		".(!empty($lpsql) ? $lpsql : '')." ".(!empty($l_date) ? $l_date : '')."
                ";
  if(isset($_GET['pid'])){
    $adj_sql .= " AND dl.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' ";
  }
  $adj_sql .= " GROUP BY dl.description";
  $adj_q = $db->getResults($adj_sql);
  if ($adj_q) foreach ($adj_q as $adj_r) {?>
    <li><label><?php echo $adj_r['description']; ?></label> $<?php echo number_format($adj_r['amount'],2); ?></li>
  <?php 
      $adj_total += $adj_r['amount'];
  }?>
    <li><label>Adjust. Total</label> $<?php echo number_format($adj_total,2); ?></li>
  </ul>
