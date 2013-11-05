<? 
include "includes/top.htm";

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
  $sql = "SELECT du.*, count(s.id) AS num_screened FROM dental_users du 
		LEFT JOIN dental_screener s ON du.userid = s.docid AND s.adddate BETWEEN '".$start_date."' AND '".$end_date."'
                WHERE du.docid=0 
		GROUP BY du.userid
		";
}elseif(is_software($_SESSION['admin_access'])){
  $sql = "SELECT du.* FROM dental_users du 
		JOIN dental_user_company uc ON uc.userid = du.userid
		WHERE du.docid=0 AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
  $a_q = mysql_query($a_sql);
  $admin = mysql_fetch_assoc($a_q);
  $sql = "SELECT du.*, count(s.id) AS num_screened FROM dental_users du 
                LEFT JOIN dental_screener s ON du.userid = s.docid AND s.adddate BETWEEN '".$start_date."' AND '".$end_date."'
                WHERE du.docid=0 
		AND du.billing_company_id = '".mysql_real_escape_string($admin['companyid'])."'
                GROUP BY du.userid
                ";
}
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<!--<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>-->
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Monthly Reports	
</span>
<br />

<form method="post">
Start Date: <input type="text" id="start_date" name="start_date" class="calendar" value="<?= date('m/d/Y', strtotime($start_date)); ?>" />
End Date: <input type="text" id="end_date" name="end_date" class="calendar" value="<?= date('m/d/Y', strtotime($end_date)); ?>" />
<input type="submit" value="Filter" />
</form>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
<table class="sort_table" id="monthly_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
<thead>
	<tr class="tr_bg_h">
		<th valign="top" class="col_head">
			Username&nbsp;&nbsp;		
		</th>
                <th valign="top" class="col_head">
                        Company
                </th>
		<th valign="top" class="col_head">
			Name		
		</th>
                <th valign="top" class="col_head">
                        Pt. Screened 
                </th>
		<th valign="top" class="col_head">
			By user&nbsp;&nbsp;		
		</th>
		<th valign="top" class="col_head">
			Completed Sleep Studies
		</th>
                <th valign="top" class="col_head">
                        Consult&nbsp;&nbsp; 
		</th>
		<th valign="top" class="col_head">
			Impressions&nbsp;&nbsp;	
		</th>
                <th valign="top" class="col_head">
                        Letters Sent
                </th>
                <th valign="top" class="col_head">
                        VOBs Completed
                </th>
                <th valign="top" class="col_head">
                        Ins. Claims Sent
                </th>
                <th valign="top" class="col_head">
                        Ins. Claims Paid
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


		$co_sql = "SELECT c.name FROM companies c 
				JOIN dental_user_company uc ON uc.companyid = c.id
				WHERE uc.userid='".$myarray['userid']."'";
		$co_q = mysql_query($co_sql);
		$co_r = mysql_fetch_assoc($co_q);
		$company = $co_r['name'];

		$screen_sql = "SELECT u.username, COUNT(s.id) AS num_screened FROM dental_screener s 
                JOIN dental_users u ON u.userid=s.userid
        WHERE 
                s.docid='".$myarray['userid']."' AND
		s.adddate BETWEEN '".$start_date."' AND '".$end_date."' 
		group by u.username
";
$screen_q = mysql_query($screen_sql);
$sleepstudies = "SELECT count(ss.id) as num_ss FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.completed = 'Yes' AND ss.filename IS NOT NULL AND p.docid = '".$myarray['userid']."'
			AND str_to_date(ss.date, '%m/%d/%Y') BETWEEN '".$start_date."' AND '".$end_date."' 
		;";
  $ss_q = mysql_query($sleepstudies);
  $ss = mysql_fetch_assoc($ss_q);


$consult_sql = "SELECT count(i.id) as num_consult FROM dental_flow_pg2_info i
			JOIN dental_patients p ON p.patientid = i.patientid
			WHERE i.segmentid=2
 				AND p.docid='".mysql_real_escape_string($myarray['userid'])."'
 				AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$consult_q = mysql_query($consult_sql);
$consult = mysql_fetch_assoc($consult_q); 

$imp_sql = "SELECT count(i.id) as num_imp FROM dental_flow_pg2_info i
                        JOIN dental_patients p ON p.patientid = i.patientid
                        WHERE i.segmentid=4
				AND p.docid='".mysql_real_escape_string($myarray['userid'])."'
                                AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$imp_q = mysql_query($imp_sql);
$imp = mysql_fetch_assoc($imp_q);

$letters_sql = "SELECT count(l.letterid) as num_sent FROM dental_letters l 
                        WHERE 
                                l.docid='".mysql_real_escape_string($myarray['userid'])."'
                                AND l.date_sent BETWEEN '".$start_date."' AND '".$end_date."'";
$letters_q = mysql_query($letters_sql);
$letters = mysql_fetch_assoc($letters_q);

$vob_sql = "SELECT count(p.id) as num_completed FROM dental_insurance_preauth p
                        WHERE 
                                p.doc_id='".mysql_real_escape_string($myarray['userid'])."'
                                AND p.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$vob_q = mysql_query($vob_sql);
$vob = mysql_fetch_assoc($vob_q);

$ins_sent_sql = "SELECT count(p.id) as num_completed FROM dental_insurance_preauth p
                        WHERE 
                                p.doc_id='".mysql_real_escape_string($myarray['userid'])."'
                                AND p.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$ins_sent_q = mysql_query($ins_sent_sql);
$ins_sent = mysql_fetch_assoc($ins_sent_q);


		?>
			<tr>
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?= $company; ?>
				</td>
                                <td valign="top">
                                        <?=st($myarray["first_name"]." ".$myarray["last_name"]);?>
                                </td>
				<td valign="top" style="text-align:center;">
					<?=st($myarray["num_screened"]);?>
				</td>
				<td valign="top" style="text-align:center;">
					<?php
					  while($screen = mysql_fetch_assoc($screen_q)){
 					    echo $screen['username']." - ".$screen['num_screened']."<br />";
					  }
					?>
				</td>
				<td valign="top" align="center">
				  <?= $ss['num_ss']; ?>
				</td>	
			        <td valign="top" align="center">
                                  <?= $consult['num_consult']; ?>
                                </td>	
				<td valign="top" align="center">
				  <?= $imp['num_imp']; ?>
				</td>
                                <td valign="top" align="center">
                                  <?= $letters['num_sent']; ?>
                                </td>
                                <td valign="top" align="center">
                                  <?= $vob['num_completed']; ?>
                                </td>

			</tr>
	<? 	}

	}?>
</tbody>
</table>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
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
