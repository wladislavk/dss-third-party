
<div class="fullwidth">
<h3>Charges</h3>
<ul>
<?php
  $ch_total = 0;
  $ch_sql = "SELECT dl.description, sum(dl.amount) amount FROM dental_ledger dl
		JOIN dental_patients p ON p.patientid=dl.patientid
		WHERE amount != '' 
		AND p.docid='".mysql_real_escape_string($_SESSION['docid'])."' ";
	if(isset($_GET['pid'])){
		$ch_sql .= " AND dl.patientid='".mysql_real_escape_string($_GET['pid'])."' ";
	}
		$ch_sql .= " GROUP BY dl.description";
  $ch_q = mysql_query($ch_sql);
  while($ch_r = mysql_fetch_assoc($ch_q)){ ?>
  <li><label><?= $ch_r['description']; ?></label> $<?= number_format($ch_r['amount'],2); ?></li>
	<?php $ch_total += $ch_r['amount']; ?>
  <?php } ?>
  <li><label>Charges Total</label> $<?= number_format($ch_total,2); ?></li>
</ul>

<h3>Credit</h3>
<ul>
<?php
  $cr_total = 0;
  $cr_sql = "SELECT dl.description, sum(dl.paid_amount) amount FROM dental_ledger dl
		JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
                WHERE paid_amount != '' 
		AND tc.type != '".DSS_TRXN_TYPE_ADJ."'
		";
        if(isset($_GET['pid'])){
                $cr_sql .= " AND dl.patientid='".mysql_real_escape_string($_GET['pid'])."' ";
        }
                $cr_sql .= " GROUP BY dl.description";
  $cr_q = mysql_query($cr_sql);
  while($cr_r = mysql_fetch_assoc($cr_q)){ ?>
  <li><label><?= $cr_r['description']; ?></label> $<?= number_format($cr_r['amount'],2); ?></li>
        <?php $cr_total += $cr_r['amount']; ?>
  <?php } ?>
  <li><label>Credits Total</label> $<?= number_format($cr_total,2); ?></li>
</ul>

<h3>Adjustments</h3>
<ul>
<?php            
  $adj_total = 0;
  $adj_sql = "SELECT dl.description, sum(dl.paid_amount) amount FROM dental_ledger dl
                JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
                WHERE paid_amount != '' 
                AND tc.type = '".DSS_TRXN_TYPE_ADJ."'
                ";
        if(isset($_GET['pid'])){
                $adj_sql .= " AND dl.patientid='".mysql_real_escape_string($_GET['pid'])."' ";
        }
                $adj_sql .= " GROUP BY dl.description";
  $adj_q = mysql_query($adj_sql);
  while($adj_r = mysql_fetch_assoc($adj_q)){ ?>
  <li><label><?= $adj_r['description']; ?></label> $<?= number_format($adj_r['amount'],2); ?></li>
        <?php $adj_total += $adj_r['amount']; ?>
  <?php } ?>
  <li><label>Adjust. Total</label> $<?= number_format($adj_total,2); ?></li>
</ul>

