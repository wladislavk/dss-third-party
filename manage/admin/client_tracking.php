<? 
include "includes/top.htm";
include '../includes/constants.inc';
if($_REQUEST["delid"] != "" && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_transaction_code where transaction_codeid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
/*$sql = "select du.name, du.userid, du.username, count(dl.ledgerid) as num_trxn from dental_users du 
    LEFT JOIN dental_ledger dl 
	ON dl.docid=du.userid 
		AND dl.status = '".DSS_PERCASE_PENDING."' 
WHERE du.docid=0
 group by du.name, du.username, du.userid";
echo $sql;
*/
if(isset($_REQUEST['start_date'])){
  $start_date = date('Y-m-d', strtotime($_REQUEST['start_date']));
  $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
}else{
  $start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-30, date('Y')));
  $end_date = date('Y-m-d');
}
if(is_super($_SESSION['admin_access'])){
  $sql = "SELECT du.userid, du.username, 
		CONCAT(du.first_name,' ', du.last_name) as doc_name,
		co.name as company_name,
		bc.name as billing_name,
		s.num_staff,
 		p.num_patient,
		c.num_contact,
		ac.access_code,
		plan.name as plan_name,
		du.adddate,
	 	DATEDIFF(now(), du.adddate) as duration,
		(i.ledger_amount + i1.monthly_amount + i2.extra_amount + i3.vob_amount) as paid,
		du.status,
		du.suspended_reason
		FROM dental_users du 
		LEFT JOIN dental_user_company uc ON uc.userid = du.userid
		LEFT JOIN companies co ON co.id=uc.companyid
		LEFT JOIN companies bc ON bc.id=du.billing_company_id
		LEFT JOIN (SELECT count(userid) as num_staff, docid FROM dental_users GROUP BY docid) s ON s.docid = du.userid
		LEFT JOIN (SELECT count(patientid) as num_patient, docid FROM dental_patients GROUP BY docid) p ON p.docid = du.userid
		LEFT JOIN (SELECT count(contactid) as num_contact, docid FROM dental_contact GROUP BY docid) c ON c.docid = du.userid
		LEFT JOIN dental_access_codes ac ON ac.id= du.access_code_id
		LEFT JOIN dental_plans plan on plan.id=du.plan_id
		LEFT JOIN (SELECT COALESCE(sum(dl.percase_amount),0) as ledger_amount, pi.docid FROM 
				dental_percase_invoice pi 
				 LEFT JOIN dental_ledger dl on pi.id=dl.percase_invoice
                		GROUP BY pi.docid) i ON i.docid=du.userid
		LEFT JOIN (SELECT COALESCE(sum(pi.monthly_fee_amount),0) as monthly_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                GROUP BY pi.docid) i1 ON i1.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(dle.percase_amount),0) as extra_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_percase_invoice_extra dle ON dle.percase_invoice=pi.id
                                GROUP BY pi.docid) i2 ON i2.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(ip.invoice_amount), 0) as vob_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_insurance_preauth ip ON ip.invoice_id = pi.id
                                GROUP BY pi.docid) i3 ON i3.docid=du.userid


                WHERE du.docid=0 ";

}

$_REQUEST['sort'] = ($_REQUEST['sort'])?$_REQUEST['sort']:'username';
$_REQUEST['sortdir'] = ($_REQUEST['sortdir'])?$_REQUEST['sortdir']:'ASC';

$sort = ' ORDER BY '.mysql_real_escape_string($_REQUEST['sort']).' '.$_REQUEST['sortdir'];



$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$my=mysql_query($sql . $sort) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Account Analysis and Tracking
</span>
<br />
<div style="width:45%; float:left;">
<?php
  $count_sql = "SELECT 
		 sum(case when status='1' THEN 1 ELSE 0 end) as num_active,
		 sum(case when status='3' THEN 1 ELSE 0 end) as num_suspended,
		 sum(case when (status='2' AND username!='' AND username IS NOT NULL) THEN 1 ELSE 0 END) as num_inactive,
		 sum(case when status='2' AND (username='' OR username IS NULL) THEN 1 ELSE 0 END) as num_unregistered
		FROM dental_users WHERE docid=0";

  $count_q = mysql_query($count_sql);
  $count_r = mysql_fetch_assoc($count_q);
?>
Active Users: <?= $count_r['num_active']; ?> 
Inactive Users: <?= $count_r['num_inactive']; ?> 
Unregistered: <?= $count_r['num_unregistered']; ?> 
Suspended: <?= $count_r['num_suspended']; ?><br />


<?php
  $count_sql = "SELECT 
                 sum(case when activation_date >= DATE_SUB(now(), INTERVAL 30 DAY) THEN 1 ELSE 0 end) as num_30,
                 sum(case when activation_date < DATE_SUB(now(), INTERVAL 30 DAY) AND activation_date >= DATE_SUB(now(), INTERVAL 60 DAY) THEN 1 ELSE 0 end) as num_60,
                 sum(case when activation_date < DATE_SUB(now(), INTERVAL 60 DAY)  THEN 1 ELSE 0 END) as num_plus
                FROM (SELECT 
			userid, username,
			case 
                   	  WHEN registration_date IS NOT NULL AND registration_date != ''
                     	    THEN registration_date
                   	  ELSE adddate
                 	end as activation_date
			FROM dental_users
			WHERE (username!='' && username IS NOT NULL) and docid=0
			) u
			";

  $count_q = mysql_query($count_sql);
  $count_r = mysql_fetch_assoc($count_q);
?>

Activated last 30 days: <?=$count_r['num_30'];?>
 30-60 days: <?=$count_r['num_60'];?>
 60+: <?= $count_r['num_plus']; ?>


<?php
  $count_sql = "SELECT 
                 sum(case when suspended_date >= DATE_SUB(now(), INTERVAL 30 DAY) THEN 1 ELSE 0 end) as num_30,
                 sum(case when suspended_date < DATE_SUB(now(), INTERVAL 30 DAY) AND suspended_date >= DATE_SUB(now(), INTERVAL 60 DAY) THEN 1 ELSE 0 end) as num_60,
                 sum(case when suspended_date < DATE_SUB(now(), INTERVAL 60 DAY)  THEN 1 ELSE 0 END) as num_plus
                FROM 
                        dental_users
			 	WHERE suspended_date !='' and suspended_date IS NOT NULL	 
                        ";

  $count_q = mysql_query($count_sql);
  $count_r = mysql_fetch_assoc($count_q);
?>
<br />
Suspended last 30 days: <?=$count_r['num_30'];?>
 30-60 days: <?=$count_r['num_60'];?>
 60+: <?= $count_r['num_plus']; ?>
<br/>
<?php
  $count_sql = "SELECT count(du.userid) num_paid from dental_users du
                LEFT JOIN (SELECT COALESCE(sum(dl.percase_amount),0) as ledger_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_ledger dl on pi.id=dl.percase_invoice
                                GROUP BY pi.docid) i ON i.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(pi.monthly_fee_amount),0) as monthly_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                GROUP BY pi.docid) i1 ON i1.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(dle.percase_amount),0) as extra_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_percase_invoice_extra dle ON dle.percase_invoice=pi.id
                                GROUP BY pi.docid) i2 ON i2.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(ip.invoice_amount), 0) as vob_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_insurance_preauth ip ON ip.invoice_id = pi.id
                                GROUP BY pi.docid) i3 ON i3.docid=du.userid


                WHERE du.docid=0 AND status=1 AND
	 (i.ledger_amount + i1.monthly_amount + i2.extra_amount + i3.vob_amount) > 0";
  $count_q = mysql_query($count_sql);
  $count_r = mysql_fetch_assoc($count_q); 
?>
Total Paid Active Users: <?= $count_r['num_paid']; ?>
<br />
<?php
  $count_sql = "SELECT count(du.userid) num_paid from dental_users du
                LEFT JOIN (SELECT COALESCE(sum(dl.percase_amount),0) as ledger_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_ledger dl on pi.id=dl.percase_invoice
                                GROUP BY pi.docid) i ON i.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(pi.monthly_fee_amount),0) as monthly_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                GROUP BY pi.docid) i1 ON i1.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(dle.percase_amount),0) as extra_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_percase_invoice_extra dle ON dle.percase_invoice=pi.id
                                GROUP BY pi.docid) i2 ON i2.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(ip.invoice_amount), 0) as vob_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_insurance_preauth ip ON ip.invoice_id = pi.id
                                GROUP BY pi.docid) i3 ON i3.docid=du.userid


                WHERE du.docid=0 AND status=1 AND
         COALESCE((i.ledger_amount + i1.monthly_amount + i2.extra_amount + i3.vob_amount), 0) <= 0";
  $count_q = mysql_query($count_sql);
  $count_r = mysql_fetch_assoc($count_q);
?>

Total Unpaid Active Users: <?= $count_r['num_paid']; ?>
<br />
<?php
  $count_sql = "SELECT COALESCE(sum(dc.amount),0) cc_paid from dental_charge dc
                WHERE charge_date >= DATE_SUB(now(), INTERVAL 30 DAY)";
  $count_q = mysql_query($count_sql);
  $count_r = mysql_fetch_assoc($count_q);
?>

Credit Card Billing Last 30 days: $<?= $count_r['cc_paid']; ?>
<br />
<?php
  $total_charge = 0;
  $sql = "SELECT id, monthly_fee_amount FROM dental_percase_invoice pi
	WHERE adddate >= DATE_SUB(now(), INTERVAL 30 DAY)
	AND NOT EXISTS (SELECT dc.invoice_id FROM dental_charge dc WHERE dc.invoice_id=pi.id)
	";
  $q = mysql_query($sql);
  while($myarray = mysql_fetch_assoc($q)){
$total_charge += $myarray['monthly_fee_amount'];
$case_sql = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl                 JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$myarray['docid']."' AND                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_percase_invoice_extra dl         WHERE 
                dl.percase_invoice='".$myarray['id']."'
        UNION
SELECT CONCAT('Insurance Verification Services – ', patient_firstname, ' ', patient_lastname), invoice_date, '', invoice_amount, id FROM dental_insurance_preauth
        WHERE
                invoice_id='".$myarray['id']."'
        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_fax_invoice        WHERE
                invoice_id='".$myarray['id']."'";
$case_q = mysql_query($case_sql);
while($case_r = mysql_fetch_assoc($case_q)){
$total_charge += $case_r['percase_amount'];
}
}
?>
Other Invoices Last 30 days: $<?= $total_charge; ?>
<br />
Total CC + Invoice Last 30 days: $<?= $total_charge + $count_r['cc_paid']; ?>
</div>


<div style="width:50%; float:left;">
<?php include 'report_user_activated.php'; ?>
<?php include 'report_user_paid.php'; ?>
</div>





<div align="center" class="red" style="clear:both;">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
<table class="sort_table table table-bordered table-hover" id="tracking_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
<thead>
	<tr class="tr_bg_h">
		<th class="col_head">Username</th>
		<th class="col_head">Name</th>
		<th class="col_head">Company</th>
		<th class="col_head">HST</th>
                <th class="col_head"> 
                        Billing Company
                </th>
                <th class="col_head">
			# Staff
		</th>
                <th class="col_head">
			# Patients
		</th>
                <th class="col_head">
			# Contacts
		</th>
                <th class="col_head">
			Act. Code
		</th>
                <th class="col_head">
			Plan
                </th>
                <th class="col_head">
			Activated
                </th>
                <th class="col_head">
			Duration
                </th>
                <th class="col_head">
			$ Paid
                </th>
                <th class="col_head">
			Status
		</th>
	</tr>
</thead>
<tbody>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{

		?>
			<tr class="status_<?= $myarray['status']; ?>">
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?= $myarray['doc_name']; ?>
				</td>
				<td valign="top">
					<?= $myarray['company_name']; ?>
				</td>
                                <td valign="top">
				<?php
					$hst_sql = "SELECT hst.name FROM companies hst
								INNER JOIN dental_user_hst_company uhc ON uhc.companyid=hst.id
								WHERE uhc.userid='".mysql_real_escape_string($myarray['userid'])."'";
					$hst_q = mysql_query($hst_sql);
					while($hst_r = mysql_fetch_assoc($hst_q)){
						echo $hst_r['name']."<br />";
					}
				?>
                                </td>
				<td valign="top" style="text-align:center;">
					<?=st($myarray["billing_name"]);?>
				</td>
				<td valign="top" style="text-align:center;">
					<?= $myarray['num_staff'];?>
				</td>
				<td valign="top" align="center">
				  <?= $myarray['num_patient']; ?>
				</td>	
			        <td valign="top" align="center">
                                  <?= $myarray['num_contact']; ?>
                                </td>	
				<td valign="top" align="center">
				  <?= $myarray['access_code']; ?>
				</td>
                                <td valign="top" align="center">
                                  <?= $myarray['plan_name']; ?>
                                </td>
                                <td valign="top" align="center">
                                  <?= ($myarray['adddate'])?date('m/d/Y',strtotime($myarray['adddate'])):''; ?>
                                </td>
				<td valign="top" align="center">
				  <?= $myarray['duration']; ?>
				</td>
                                <td valign="top" align="center">
                                  <?= $myarray['paid']; ?>
                                </td>
				<td valign="top" align="center">
				  <?php if($myarray['status']==DSS_USER_STATUS_SUSPENDED){ ?>
					<a href="#" onclick="return false;" title="<?= $myarray['suspended_reason']; ?>"><?= $dss_user_status_labels[$myarray['status']]; ?></a>	
				  <?php }else{ ?>
				  <?= $dss_user_status_labels[$myarray['status']]; ?>
				  <?php } ?>
				</td>
			</tr>
	<? 	}

	}?>
</tbody>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<script type="text/javascript">
$(document).ready(function() 
    { 
        $('#monthly_table').tablesorter(); 
    } 
); 
</script>
<? include "includes/bottom.htm";?>
