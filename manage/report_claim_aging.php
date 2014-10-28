<?php if(!isset($_GET['print'])){ 
include "includes/top.htm";
}else{
$office_type = DSS_OFFICE_TYPE_FRONT;
?>
  <html>
<body>
<?
//include "includes/top.htm";

session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once('includes/constants.inc');
require_once('admin/includes/access.php');
}
?>
<link rel="stylesheet" href="css/ledger.css" /><?php
//COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance
$sql = "SELECT p.firstname, p.lastname,
		p.patientid
		FROM dental_patients p
	WHERE p.docid='".$_SESSION['docid']."'
	AND (SELECT (SUM(COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0)) -
	COALESCE((SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                WHERE dl.primary_claim_id=i.insuranceid), 0)
	)
	 FROM dental_insurance i 
WHERE i.patientid=p.patientid AND i.mailed_date IS NOT NULL) > 0
	ORDER BY p.lastname ASC, p.firstname ASC
	";


//(SELECT COALESCE(SUM(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2))),0) FROM dental_insurance i WHERE i.patientid=p.patientid AND i.adddate > DATE_SUB(CURDATE(), INTERVAL 830 DAY)) as total_029

$my = mysql_query($sql) or die(mysql_error());
$total_rec = mysql_num_rows($my);

//echo $sql; 
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Claim Aging Report
</span>
<div>
&nbsp;&nbsp;
<a href="ledger.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
</div>

<br />
<style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
<div align="right">
        <button onclick="Javascript: window.location='report_claim_aging.php?print';" class="addButton">
                Print
        </button>
        &nbsp;&nbsp;

</div>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table class="ledger sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<thead>
	<tr class="tr_bg_h">
		<th valign="top" class="col_head">
			Patient Name
		</th>
		<th valign="top" class="col_head">
			Current
		</th>
                <th valign="top" class="col_head">
                        30 Days
                </th>
                <th valign="top" class="col_head">
                        60 Days
                </th>
                <th valign="top" class="col_head">
                        90 Days
                </th>
                <th valign="top" class="col_head">
                        120+ Days
                </th>
                <th valign="top" class="col_head">
                        Total
                </th>
	</tr>
	</thead>	
	<tbody>
		<?php

$total_029 = $total_3059 = $total_6089 = $total_90119 = $total_120 = $grand_total = 0;

		while($r = mysql_fetch_array($my))
		{
  $c_total = $p_total = $pat_total = 0;
  $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
  $c_q = mysql_query($c_sql) or die(mysql_error());
  while($c_r = mysql_fetch_assoc($c_q)){
    $c_total += $c_r['total_charge'];
    $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
		LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
		WHERE dl.primary_claim_id='".mysql_real_escape_string($c_r['insuranceid'])."'";
    $p_q = mysql_query($p_sql);
    $p_r = mysql_fetch_assoc($p_q);
    $p_total = $p_r['paid_amount'];
  }
  $pat_total+=$c_total - $p_total;
  $total_029+=$c_total - $p_total;
		?>
			<tr>
				<td valign="top">
                	<a href="manage_ledger.php?pid=<?=$r['patientid']; ?>&addtopat=1"><?=$r['firstname']." ".$r['lastname'];?></a>
				</td>
				<td valign="top">
				  <?php if(($c_total-$p_total)!=0){ ?>
                                        <a href="manage_ledger.php?pid=<?= $r['patientid']; ?>&addtopat=1">$<?= number_format(($c_total - $p_total),2); ?></a>
				  <?php }else{ ?>
                                        $<?= number_format(($c_total - $p_total),2); ?>
				  <?php } ?>
				</td>

<?php
$c_total = $p_total = 0;
$c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
$c_q = mysql_query($c_sql) or die(mysql_error());
$p_sql = '';
while($c_r = mysql_fetch_assoc($c_q)){
$c_total += $c_r['total_charge'];
$p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
	LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
	WHERE dl.primary_claim_id='".mysql_real_escape_string($c_r['insuranceid'])."'";
$p_q = mysql_query($p_sql);
$p_r = mysql_fetch_assoc($p_q);
$p_total = $p_r['paid_amount'];
}
  $pat_total+=$c_total - $p_total;
  $total_3059+=$c_total - $p_total;
?>
			<td valign="top">
                                  <?php if(($c_total-$p_total)!=0){ ?>
                                        <a href="manage_ledger.php?pid=<?= $r['patientid']; ?>&addtopat=1">$<?= number_format(($c_total - $p_total),2); ?></a>
                                  <?php }else{ ?>
                                        $<?= number_format(($c_total - $p_total),2); ?>
                                  <?php } ?>

			</td>
<?php
  $c_total = $p_total = 0;  $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 60 DAY)";
  $c_q = mysql_query($c_sql) or die(mysql_error());
$p_sql = '';
  while($c_r = mysql_fetch_assoc($c_q)){
    $c_total += $c_r['total_charge'];
    $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                WHERE dl.primary_claim_id='".mysql_real_escape_string($c_r['insuranceid'])."'";
    $p_q = mysql_query($p_sql);
    $p_r = mysql_fetch_assoc($p_q);
    $p_total = $p_r['paid_amount'];
  }
  $pat_total+=$c_total - $p_total;
  $total_6089+=$c_total - $p_total;
?>
                                <td valign="top">
                                  <?php if(($c_total-$p_total)!=0){ ?>
                                        <a href="manage_ledger.php?pid=<?= $r['patientid']; ?>&addtopat=1">$<?= number_format(($c_total - $p_total),2); ?></a>
                                  <?php }else{ ?>
                                        $<?= number_format(($c_total - $p_total),2); ?>
                                  <?php } ?>

                                </td>

<?php
  $c_total = $p_total = 0;  $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 90 DAY)";
  $c_q = mysql_query($c_sql) or die(mysql_error());
$p_sql = '';
  while($c_r = mysql_fetch_assoc($c_q)){
    $c_total += $c_r['total_charge'];
    $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                WHERE dl.primary_claim_id='".mysql_real_escape_string($c_r['insuranceid'])."'";
    $p_q = mysql_query($p_sql);
    $p_r = mysql_fetch_assoc($p_q);
    $p_total = $p_r['paid_amount'];
  }
  $pat_total+=$c_total - $p_total;
  $total_90119+=$c_total - $p_total;
?>
                                <td valign="top">
                                  <?php if(($c_total-$p_total)!=0){ ?>
                                        <a href="manage_ledger.php?pid=<?= $r['patientid']; ?>&addtopat=1">$<?= number_format(($c_total - $p_total),2); ?></a>
                                  <?php }else{ ?>
                                        $<?= number_format(($c_total - $p_total),2); ?>
                                  <?php } ?>

                                </td>

<?php
  $c_total = $p_total = 0;  $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 120 DAY)";
  $c_q = mysql_query($c_sql) or die(mysql_error());
$p_sql = '';
  while($c_r = mysql_fetch_assoc($c_q)){
    $c_total += $c_r['total_charge'];
    $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                WHERE dl.primary_claim_id='".mysql_real_escape_string($c_r['insuranceid'])."'";
    $p_q = mysql_query($p_sql);
    $p_r = mysql_fetch_assoc($p_q);
    $p_total = $p_r['paid_amount'];
  }
  $pat_total+=$c_total - $p_total;
  $total_120+=$c_total - $p_total;
?>
                                <td valign="top">
                                  <?php if(($c_total-$p_total)!=0){ ?>
                                        <a href="manage_ledger.php?pid=<?= $r['patientid']; ?>&addtopat=1">$<?= number_format(($c_total - $p_total),2); ?></a>
                                  <?php }else{ ?>
                                        $<?= number_format(($c_total - $p_total),2); ?>
                                  <?php } ?>

                                </td>
                                <td valign="top">
					<?php $grand_total+=$pat_total; ?>
                                        $<?= number_format($pat_total,2); ?>
                                </td>

			</tr>
	<? 	}
	?> 
	  </tbody>
	  <tfoot>
		<tr>
			<td valign="top">
				<b>Totals</b>
			</td>
			<td valign="top">
			  <strong><?php echo "$".number_format($total_029,2); ?></strong>
			</td>
                        <td valign="top">
                          <strong><?php echo "$".number_format($total_3059,2); ?></strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo "$".number_format($total_6089,2); ?></strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo "$".number_format($total_90119,2); ?></strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo "$".number_format($total_120,2); ?></strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo "$".number_format($grand_total,2); ?></strong>
                        </td>

                </tr>
                <tr>
                        <td valign="top">
                                <b>Percentage</b>
                        </td>
                        <td valign="top">
                          <strong><?php echo number_format(($total_029/$grand_total)*100,2); ?>%</strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo number_format(($total_3059/$grand_total)*100,2); ?>%</strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo number_format(($total_6089/$grand_total)*100,2); ?>%</strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo number_format(($total_90119/$grand_total)*100,2); ?>%</strong>
                        </td>
                        <td valign="top">
                          <strong><?php echo number_format(($total_120/$grand_total)*100,2); ?>%</strong>
                        </td>
                        <td valign="top">
                          <strong>100%</strong>
                        </td>

                </tr>

	</tfoot>

</table>

<?php include 'report_claim_aging_breakdown.php'; ?>

<div id="popupContact" style="width:750px;">
	    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php if(!isset($_GET['print'])){ ?>
<? include "includes/bottom.htm";?>
<?php } ?>
