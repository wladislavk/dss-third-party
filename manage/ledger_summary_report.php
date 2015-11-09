<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include_once 'includes/constants.inc';

$docId = intval($_SESSION['docid']);
$trxnTypeAdjustment = $db->escape(DSS_TRXN_TYPE_ADJ);

?>
<div class="fullwidth">
  <h3>Charges</h3>
  <ul>
<?php
  $ch_total = 0;
  $ch_sql = "SELECT
        COALESCE(dl.description, '') AS payment_description,
        SUM(dl.amount) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_patients p ON p.patientid = dl.patientid
    WHERE dl.docid = '$docId'
        $lpsql
        AND (dl.paid_amount IS NULL OR dl.paid_amount = 0)
        $l_date";

	if(isset($_GET['pid'])){
		$ch_sql .= " AND dl.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' ";
	}
	$ch_sql .= " GROUP BY payment_description";
  $ch_q = $db->getResults($ch_sql);
  if ($ch_q) foreach ($ch_q as $ch_r) {?>
    <li><label><?php echo $ch_r['payment_description']; ?></label> $<?php echo number_format($ch_r['payment_amount'],2); ?></li>
	<?php 
    $ch_total += $ch_r['payment_amount'];
  } ?>
    <li><label>Charges Total</label> $<?php echo number_format($ch_total,2); ?></li>
  </ul>

  <h3>Credit</h3>
  <ul>
<?php
  $cr_total = 0;

  // ledger_payment
  $cr_sql = "SELECT
        COALESCE(dlp.payment_type, '0') AS payment_description,
        SUM(dlp.amount) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_patients as pat ON dl.patientid = pat.patientid
        LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
    WHERE dl.docid = '$docId'
        $lpsql
        AND dlp.amount != 0
        $p_date
        ";

        if(isset($_GET['pid'])){
                $cr_sql .= " AND dl.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' ";
        }
                $cr_sql .= " GROUP BY payment_description";

  $cr_q = $db->getResults($cr_sql);
  if ($cr_q) foreach ($cr_q as $cr_r) {?>
    <li><label><?php echo ($dss_trxn_pymt_type_labels[$cr_r['payment_description']] == 'Check') ? 'Ins. Checks' : $dss_trxn_pymt_type_labels[$cr_r['payment_description']]; ?></label> $<?php echo number_format($cr_r['payment_amount'],2); ?></li>
  <?php 
      $cr_total += $cr_r['payment_amount'];
  }

  // ledger_paid
  $cr2_sql = "SELECT
        COALESCE(dl.description, 0) AS payment_description,
        SUM(dl.paid_amount) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_patients as pat ON dl.patientid = pat.patientid
        LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
        LEFT JOIN dental_transaction_code tc ON tc.transaction_code = dl.transaction_code
            AND tc.docid = '$docId'
    WHERE dl.docid = '$docId'
        $lpsql
        AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
        AND COALESCE(tc.type, '') != '$trxnTypeAdjustment'
        $l_date
        ";

  if(isset($_GET['pid'])){
    $cr2_sql .= " AND dl.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' ";
  }
  $cr2_sql .= " GROUP BY payment_description";
  $cr2_q = $db->getResults($cr2_sql);
  if ($cr2_q) foreach ($cr2_q as $cr2_r) {?>
    <li><label><?php echo $cr2_r['payment_description'] = ($cr2_r['payment_description']=='Check')?'Pers Checks':$cr2_r['payment_description']; ?></label> $<?php echo number_format($cr2_r['payment_amount'],2); ?></li>
  <?php 
    $cr_total += $cr2_r['payment_amount'];
  } ?>


    <li><label>Credits Total</label> $<?php echo number_format($cr_total,2); ?></li>
  </ul>

  <h3>Adjustments</h3>
  <ul>
<?php            
  $adj_total = 0;
  $adj_sql = "SELECT
        COALESCE(dl.description, 0) AS payment_description,
        SUM(dl.paid_amount) AS payment_amount
    FROM dental_ledger dl
        JOIN dental_patients as pat ON dl.patientid = pat.patientid
        LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
        LEFT JOIN dental_transaction_code tc ON tc.transaction_code = dl.transaction_code
            AND tc.docid = '$docId'
    WHERE dl.docid = '$docId'
        $lpsql
        AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
        AND COALESCE(tc.type, '') = '$trxnTypeAdjustment'
        $l_date
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
