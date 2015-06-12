<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";

if(!empty($_REQUEST["delid"]) && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_transaction_code where transaction_codeid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
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
		WHERE du.docid=0 AND uc.companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."'";
  $a_q = mysqli_query($con,$a_sql);
  $admin = mysqli_fetch_assoc($a_q);
  $sql = "SELECT du.*, count(s.id) AS num_screened FROM dental_users du 
                LEFT JOIN dental_screener s ON du.userid = s.docid AND s.adddate BETWEEN '".$start_date."' AND '".$end_date."'
                WHERE du.docid=0 
		AND du.billing_company_id = '".mysqli_real_escape_string($con,$admin['companyid'])."'
                GROUP BY du.userid
                ";
}
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$my = mysqli_query($con,$sql);
$num_users = mysqli_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Monthly Reports	
</div>
<br />

<form method="post" class="form-inline">
    <div class="row">
        <div class="col-md-4">
            <div class="input-append datepicker input-group date" id="start_date" data-date="<?php echo  date('m/d/Y', strtotime($start_date)); ?>" data-date-format="mm/dd/yyyy">
                <span class="input-group-addon">Start date:</span>
                <input class="form-control text-center" type="text" name="start_date" value="<?php echo  date('m/d/Y', strtotime($start_date)); ?>">
                <span class="input-group-addon add-on">
                    <i class="glyphicon glyphicon-calendar"></i>
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-append datepicker input-group date" id="end_date" data-date="<?php echo  date('m/d/Y', strtotime($end_date)); ?>" data-date-format="mm/dd/yyyy">
                <span class="input-group-addon">End date:</span>
                <input class="form-control text-center" type="text" name="end_date" value="<?php echo  date('m/d/Y', strtotime($end_date)); ?>">
                <span class="input-group-addon add-on">
                    <i class="glyphicon glyphicon-calendar"></i>
                </span>
            </div>
        </div>
        <input type="submit" value="Filter" class="btn btn-primary">
    </div>
</form>

<?php if(!empty($_GET['msg'])) {?>
<div class="alert alert-danger text-center">
    <?php echo $_GET['msg'];?>
</div>
<?php } ?>

&nbsp;
<b>Total Records: <?php echo $total_rec;?></b>
<table class="sort_table table table-bordered table-hover" id="monthly_table">
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
                        Device Delivery&nbsp;&nbsp; 
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
	<?php if(mysqli_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php 
	}
	else
	{
		while($myarray = mysqli_fetch_array($my))
		{


		$co_sql = "SELECT c.name FROM companies c 
				JOIN dental_user_company uc ON uc.companyid = c.id
				WHERE uc.userid='".$myarray['userid']."'";
		$co_q = mysqli_query($con,$co_sql);
		$co_r = mysqli_fetch_assoc($co_q);
		$company = $co_r['name'];

		$screen_sql = "SELECT u.username, COUNT(s.id) AS num_screened FROM dental_screener s 
                JOIN dental_users u ON u.userid=s.userid
        WHERE 
                s.docid='".$myarray['userid']."' AND
		s.adddate BETWEEN '".$start_date."' AND '".$end_date."' 
		group by u.username
";
$screen_q = mysqli_query($con,$screen_sql);
$sleepstudies = "SELECT count(ss.id) as num_ss FROM dental_summ_sleeplab ss                                 
                        JOIN dental_patients p on ss.patiendid=p.patientid                        
                WHERE                                 
                        (p.p_m_ins_type!='1' OR ((ss.diagnosising_doc IS NOT NULL && ss.diagnosising_doc != '') AND (ss.diagnosising_npi IS NOT NULL && ss.diagnosising_npi != ''))) AND 
                        (ss.diagnosis IS NOT NULL && ss.diagnosis != '') AND 
                        ss.filename IS NOT NULL AND p.docid = '".$myarray['userid']."'
			AND str_to_date(ss.date, '%m/%d/%Y') BETWEEN '".$start_date."' AND '".$end_date."' 
		;";
  $ss_q = mysqli_query($con,$sleepstudies);
  $ss = mysqli_fetch_assoc($ss_q);


$consult_sql = "SELECT count(i.id) as num_consult FROM dental_flow_pg2_info i
			JOIN dental_patients p ON p.patientid = i.patientid
			WHERE i.segmentid=2
 				AND p.docid='".mysqli_real_escape_string($con,$myarray['userid'])."'
 				AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$consult_q = mysqli_query($con,$consult_sql);
$consult = mysqli_fetch_assoc($consult_q); 

$imp_sql = "SELECT count(i.id) as num_imp FROM dental_flow_pg2_info i
                        JOIN dental_patients p ON p.patientid = i.patientid
                        WHERE i.segmentid=4
				AND p.docid='".mysqli_real_escape_string($con,$myarray['userid'])."'
                                AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$imp_q = mysqli_query($con,$imp_sql);
$imp = mysqli_fetch_assoc($imp_q);

$dd_sql = "SELECT count(i.id) as num_dd FROM dental_flow_pg2_info i
                        JOIN dental_patients p ON p.patientid = i.patientid
                        WHERE i.segmentid=7
                                AND p.docid='".mysqli_real_escape_string($con,$myarray['userid'])."'
                                AND i.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$dd_q = mysqli_query($con,$dd_sql);
$dd = mysqli_fetch_assoc($dd_q);

$letters_sql = "SELECT count(l.letterid) as num_sent FROM dental_letters l 
                        WHERE 
                                l.docid='".mysqli_real_escape_string($con,$myarray['userid'])."'
                                AND l.date_sent BETWEEN '".$start_date."' AND '".$end_date."'";
$letters_q = mysqli_query($con,$letters_sql);
$letters = mysqli_fetch_assoc($letters_q);

$vob_sql = "SELECT count(p.id) as num_completed FROM dental_insurance_preauth p
                        WHERE 
                                p.doc_id='".mysqli_real_escape_string($con,$myarray['userid'])."'
                                AND p.date_completed BETWEEN '".$start_date."' AND '".$end_date."'";
$vob_q = mysqli_query($con,$vob_sql);
$vob = mysqli_fetch_assoc($vob_q);

$ins_sent_sql = "SELECT count(h.id) as num_sent FROM dental_insurance i
			JOIN dental_insurance_status_history h ON i.insuranceid=h.insuranceid
                        WHERE 
                                i.docid='".mysqli_real_escape_string($con,$myarray['userid'])."'
				AND (h.status = '".mysqli_real_escape_string($con,DSS_CLAIM_SENT)."'
					OR h.status = '".mysqli_real_escape_string($con,DSS_CLAIM_SEC_SENT)."')
                                AND h.adddate BETWEEN '".$start_date." 00:00' AND '".$end_date." 23:59'";
$ins_sent_q = mysqli_query($con,$ins_sent_sql);
$ins_sent = mysqli_fetch_assoc($ins_sent_q);

$ins_paid_sql = "SELECT count(h.id) as num_paid FROM dental_insurance i
                        JOIN dental_insurance_status_history h ON i.insuranceid=h.insuranceid
                        WHERE 
                                i.docid='".mysqli_real_escape_string($con,$myarray['userid'])."'
                                AND h.status IN (".mysqli_real_escape_string($con,DSS_CLAIM_PAID_INSURANCE).",
						".mysqli_real_escape_string($con,DSS_CLAIM_PAID_PATIENT).",
						".mysqli_real_escape_string($con,DSS_CLAIM_PAID_SEC_INSURANCE).",
						".mysqli_real_escape_string($con,DSS_CLAIM_PAID_SEC_PATIENT).")
                                AND h.adddate BETWEEN '".$start_date." 00:00' AND '".$end_date." 23:59'";
$ins_paid_q = mysqli_query($con,$ins_paid_sql);
$ins_paid = mysqli_fetch_assoc($ins_paid_q);
		?>
			<tr>
				<td valign="top">
					<?php echo st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?php echo  $company; ?>
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["first_name"]." ".$myarray["last_name"]);?>
                                </td>
				<td valign="top" style="text-align:center;">
					<?php echo st($myarray["num_screened"]);?>
				</td>
				<td valign="top" style="text-align:center;">
					<?php
					  while($screen = mysqli_fetch_assoc($screen_q)){
 					    echo $screen['username']." - ".$screen['num_screened']."<br />";
					  }
					?>
				</td>
				<td valign="top" align="center">
				  <?php echo  $ss['num_ss']; ?>
				</td>	
			        <td valign="top" align="center">
                                  <?php echo  $consult['num_consult']; ?>
                                </td>	
				<td valign="top" align="center">
				  <?php echo  $imp['num_imp']; ?>
				</td>
				<td valign="top" align="center">
				  <?php echo  $dd['num_dd']; ?>
				</td>
                                <td valign="top" align="center">
                                  <?php echo  $letters['num_sent']; ?>
                                </td>
                                <td valign="top" align="center">
                                  <?php echo  $vob['num_completed']; ?>
                                </td>
				<td valign="top" align="center">
				  <?php echo  $ins_sent['num_sent']; ?>
				</td>
                                <td valign="top" align="center">
                                  <?php echo  $ins_paid['num_paid']; ?>
                                </td>
			</tr>
	<?php 	}

	}?>
</tbody>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
