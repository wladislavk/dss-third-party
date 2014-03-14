<? 
include "includes/top.htm";
?><link rel="stylesheet" href="css/ledger.css" /><?php

if(is_super($_SESSION['admin_access'])){
$sql = "SELECT p.firstname, p.lastname,
		CONCAT(u.first_name,' ',u.last_name) doc_name,
		p.patientid
		FROM dental_patients p
		LEFT JOIN dental_users u ON u.userid=p.docid
WHERE (SELECT (SUM(COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0)) -
        COALESCE((SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                WHERE dl.primary_claim_id=i.insuranceid), 0)
        )
         FROM dental_insurance i 
WHERE i.patientid=p.patientid AND i.mailed_date IS NOT NULL";
if(isset($_GET['bc'])){
  $sql .= " AND i.p_m_billing_id IS NOT NULL AND i.p_m_billing_id != '' ";
}
if(isset($_GET['nbc'])){
  $sql .= " AND (i.p_m_billing_id IS NULL OR i.p_m_billing_id = '') ";
}
$sql.= ") > 0
	";
if(isset($_GET['fid'])){
  $sql .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
$sql .= "
	ORDER BY p.lastname ASC, p.firstname ASC
	";
}elseif(is_software($_SESSION['admin_access'])){
$sql = "SELECT p.firstname, p.lastname,
                CONCAT(u.first_name,' ',u.last_name) doc_name,
                p.patientid
                FROM dental_patients p
        JOIN dental_users u ON u.userid=p.docid 
        JOIN dental_user_company uc ON uc.userid = u.userid
        where uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' 
        ";
if(isset($_GET['fid'])){
  $sql .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
$sql .= " order by p.lastname, p.firstname
        ";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
$sql = "SELECT p.firstname, p.lastname,
                CONCAT(u.first_name,' ',u.last_name) doc_name,
                p.patientid
                FROM dental_patients p
        JOIN dental_users u ON u.userid=p.docid 
        where u.billing_company_id='".mysql_real_escape_string($admin['companyid'])."' 
        ";
if(isset($_GET['fid'])){
  $sql .= " AND p.docid='".mysql_real_escape_string($_GET['fid'])."' ";
}
$sql .= " order by p.lastname, p.firstname
        ";
}
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
<?php
$fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';
?>
  <form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="get" style="width:60%; float:left; margin-left:10px;">
    Account:
    <select name="fid">
      <option value="">Any</option>
      <?php $franchisees = (is_billing($_SESSION['admin_access']))?get_billing_franchisees():get_franchisees(); ?>
      <?php while ($row = mysql_fetch_array($franchisees)) { ?>
        <?php $selected = ($row['userid'] == $fid) ? 'selected' : ''; ?>
        <option value="<?= $row['userid'] ?>" <?= $selected ?>>[<?= $row['userid'] ?>] <?= $row['first_name'] ?> <?= $row['last_name'] ?></option>
      <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Filter List"/>
    <input type="button" value="Reset" onclick="window.location='<?=$_SERVER['PHP_SELF']?>'"/>
  </form>

<div style="float:right; margin-right:20px;">
  <a href="?nbc=1" class="button">No Billing Company</a>
  <a href="?bc=1" class="button">Billing Company</a>
  <a href="?all" class="button">All</a>


</div>

<style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>

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
			Account
		</th>
		<th valign="top" class="col_head">
			0-29 Days	
		</th>
                <th valign="top" class="col_head">
                        30-59 Days
                </th>
                <th valign="top" class="col_head">
                        60-89 Days
                </th>
                <th valign="top" class="col_head">
                        90-119 Days
                </th>
                <th valign="top" class="col_head">
                        120+
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
if(isset($_GET['bc'])){
  $c_sql .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
}
if(isset($_GET['nbc'])){
  $c_sql .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
}

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
          <a href="view_patient.php?pid=<?= $r['patientid']; ?>"><?= $r['firstname']." ".$r['lastname']; ?></a>
				</td>
				<td valign="top">
				  <?= $r['doc_name']; ?>
				</td>
				<td valign="top">
                                        $<?= number_format(($c_total - $p_total),2); ?>
				</td>

<?php
$c_total = $p_total = 0;
$c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
if(isset($_GET['bc'])){
  $c_sql .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
}
if(isset($_GET['nbc'])){
  $c_sql .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
}

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
                                        $<?= number_format(($c_total - $p_total),2); ?>

			</td>
<?php
  $c_total = $p_total = 0;  $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 60 DAY)";
if(isset($_GET['bc'])){
  $c_sql .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
}
if(isset($_GET['nbc'])){
  $c_sql .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
}

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
                                        $<?= number_format(($c_total - $p_total),2); ?>

                                </td>

<?php
  $c_total = $p_total = 0;  $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 90 DAY)";
if(isset($_GET['bc'])){
  $c_sql .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
}
if(isset($_GET['nbc'])){
  $c_sql .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
}

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
                                        $<?= number_format(($c_total - $p_total),2); ?>

                                </td>

<?php
  $c_total = $p_total = 0;  $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysql_real_escape_string($r['patientid'])."' AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 120 DAY)";
if(isset($_GET['bc'])){
  $c_sql .= " AND p_m_billing_id IS NOT NULL AND p_m_billing_id != '' ";
}
if(isset($_GET['nbc'])){
  $c_sql .= " AND (p_m_billing_id IS NULL OR p_m_billing_id = '') ";
}

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
                                        $<?= number_format(($c_total - $p_total),2); ?>

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
			<td></td>
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
	</tfoot>

</table>

<?php include '../report_claim_aging_breakdown.php'; ?>


<br /><br />	
<? include "includes/bottom.htm";?>
