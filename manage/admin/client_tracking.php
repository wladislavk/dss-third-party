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
		du.status
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
<?php
  $count_sql = "SELECT 
		 sum(case when status='1' THEN 1 ELSE 0 end) as num_active,
		 sum(case when status='3' THEN 1 ELSE 0 end) as num_suspended,
		 sum(case when status='2' AND (username='' OR username IS NULL) THEN 1 ELSE 0 END) as num_unregistered
		FROM dental_users WHERE docid=0";

  $count_q = mysql_query($count_sql);
  $count_r = mysql_fetch_assoc($count_q);
?>
Active Users: <?= $count_r['num_active']; ?> 
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




<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
<table class="sort_table table table-bordered table-hover" id="tracking_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
<thead>
	<tr class="tr_bg_h">
		<td class="col_head <?= ($_REQUEST['sort'] == 'username')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=username&sortdir=<?php echo ($_REQUEST['sort']=='username'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Username</a>
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'company_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=company_name&sortdir=<?php echo ($_REQUEST['sort']=='company_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
                </td>
		<th valign="top" class="col_head">
			HST	
		</th>
                <td class="col_head <?= ($_REQUEST['sort'] == 'billing_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=billing_name&sortdir=<?php echo ($_REQUEST['sort']=='billing_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
                        Billing Company</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'num_staff')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=num_staff&sortdir=<?php echo ($_REQUEST['sort']=='num_staff'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			# Staff</a>
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'num_patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=num_patient&sortdir=<?php echo ($_REQUEST['sort']=='num_patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			# Patients</a>
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'num_contact')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=num_contact&sortdir=<?php echo ($_REQUEST['sort']=='num_contact'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			# Contacts</a>
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'access_code')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=access_code&sortdir=<?php echo ($_REQUEST['sort']=='access_code'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			Act. Code</a>
		</td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'plan_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=plan_name&sortdir=<?php echo ($_REQUEST['sort']=='plan_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			Plan</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'adddate')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			Activated</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'duration')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=duration&sortdir=<?php echo ($_REQUEST['sort']=='duration'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			Duration</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'paid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=paid&sortdir=<?php echo ($_REQUEST['sort']=='paid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			$ Paid</a>
                </td>
                <td class="col_head <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="client_tracking.php?sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
			Status</a>
		</td>
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
				  <?= $dss_user_status_labels[$myarray['status']]; ?>
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
