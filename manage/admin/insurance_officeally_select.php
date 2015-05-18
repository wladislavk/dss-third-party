<?php 
include "includes/top.htm";
include_once('../includes/constants.inc');
include_once "includes/general.htm";

if(is_super($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, p.firstname, p.lastname, "
     . "  CONCAT(p.firstname, ' ', p.lastname) pat_name, "
     . "  claim.adddate, claim.status, CONCAT(users.first_name,' ',users.last_name) as doc_name, CONCAT(users2.first_name,' ', users2.last_name) as user_name, "
     . "  claim.primary_fdf, claim.secondary_fdf, "
     . "  claim.mailed_date, claim.sec_mailed_date, "
     . "  DATEDIFF(NOW(), claim.adddate) as days_pending, "
     . "  c.name as billing_name, "
     //. "  dif.filename as eob, " 
     . "  CASE claim.status 
		WHEN ".DSS_CLAIM_PENDING." THEN 1
                WHEN ".DSS_CLAIM_SEC_PENDING." THEN 2
                WHEN ".DSS_CLAIM_DISPUTE." THEN 3
                WHEN ".DSS_CLAIM_SEC_DISPUTE." THEN 4
                WHEN ".DSS_CLAIM_SENT." THEN 5
                WHEN ".DSS_CLAIM_SEC_SENT." THEN 6
                WHEN ".DSS_CLAIM_REJECTED." THEN 7
                WHEN ".DSS_CLAIM_PAID_INSURANCE." THEN 8
                WHEN ".DSS_CLAIM_PAID_SEC_INSURANCE." THEN 9
                WHEN ".DSS_CLAIM_PAID_PATIENT." THEN 10
       END AS status_order "
     . "FROM "
     . "  dental_insurance claim "
     . "  JOIN dental_patients p ON p.patientid = claim.patientid "
     . "  JOIN dental_users users ON claim.docid = users.userid "
     . "  JOIN dental_users users2 ON claim.userid = users2.userid "
     . "  LEFT JOIN companies c ON c.id = users.billing_company_id ";
}elseif(is_billing($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, p.firstname, p.lastname, "
     . "  claim.adddate, claim.status, CONCAT(users.first_name,' ',users.last_name) as doc_name, CONCAT(users2.first_name,' ', users2.last_name) as user_name, "
     . "  claim.primary_fdf, claim.secondary_fdf, "
     . "  claim.mailed_date, claim.sec_mailed_date, "
     . "  DATEDIFF(NOW(), claim.adddate) as days_pending, "
     //. "  dif.filename as eob, " 
     . "  CASE claim.status 
                WHEN ".DSS_CLAIM_PENDING." THEN 1
                WHEN ".DSS_CLAIM_SEC_PENDING." THEN 2
                WHEN ".DSS_CLAIM_DISPUTE." THEN 3
                WHEN ".DSS_CLAIM_SEC_DISPUTE." THEN 4
                WHEN ".DSS_CLAIM_SENT." THEN 5
                WHEN ".DSS_CLAIM_SEC_SENT." THEN 6
                WHEN ".DSS_CLAIM_REJECTED." THEN 7
                WHEN ".DSS_CLAIM_PAID_INSURANCE." THEN 8
                WHEN ".DSS_CLAIM_PAID_SEC_INSURANCE." THEN 9
                WHEN ".DSS_CLAIM_PAID_PATIENT." THEN 10
       END AS status_order "
     . "FROM "
     . "  dental_insurance claim "
     . "  JOIN dental_patients p ON p.patientid = claim.patientid "
     . "  JOIN dental_users users ON claim.docid = users.userid AND users.billing_company_id='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'"
     . "  JOIN dental_user_company uc ON uc.userid = claim.docid " 
     . "  JOIN dental_users users2 ON claim.userid = users2.userid "
     . "  LEFT JOIN companies c ON c.id = users.billing_company_id ";
}
else{
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, p.firstname, p.lastname, "
     . "  claim.adddate, claim.status, CONCAT(users.first_name,' ',users.last_name) as doc_name, CONCAT(users2.first_name,' ', users2.last_name) as user_name, "
     . "  claim.primary_fdf, claim.secondary_fdf, "
     . "  claim.mailed_date, claim.mailed_date, "
     . "  DATEDIFF(NOW(), claim.adddate) as days_pending, "
     //. "  dif.filename as eob, " 
     . "  CASE claim.status 
                WHEN ".DSS_CLAIM_PENDING." THEN 1
                WHEN ".DSS_CLAIM_SEC_PENDING." THEN 2
                WHEN ".DSS_CLAIM_DISPUTE." THEN 3
                WHEN ".DSS_CLAIM_SEC_DISPUTE." THEN 4
                WHEN ".DSS_CLAIM_SENT." THEN 5
                WHEN ".DSS_CLAIM_SEC_SENT." THEN 6
                WHEN ".DSS_CLAIM_REJECTED." THEN 7
                WHEN ".DSS_CLAIM_PAID_INSURANCE." THEN 8
                WHEN ".DSS_CLAIM_PAID_SEC_INSURANCE." THEN 9
                WHEN ".DSS_CLAIM_PAID_PATIENT." THEN 10
       END AS status_order "
     . "FROM "
     . "  dental_insurance claim "
     . "  JOIN dental_patients p ON p.patientid = claim.patientid "
     . "  JOIN dental_users users ON claim.docid = users.userid "
     . "  JOIN dental_user_company uc ON uc.userid = claim.docid AND uc.companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'"
     . "  JOIN dental_users users2 ON claim.userid = users2.userid "
     . "  LEFT JOIN companies c ON c.id = users.billing_company_id ";
}
// . "  LEFT JOIN dental_insurance_file dif ON dif.claimid = claim.insuranceid ";

// filter based on select lists above table
    $sql .= "WHERE "; 
	   	$sql .= " ((claim.mailed_date IS NULL AND (claim.status=".DSS_CLAIM_SENT." OR claim.status=".DSS_CLAIM_PAID_INSURANCE." OR claim.status=".DSS_CLAIM_PAID_PATIENT." ))
                        OR (claim.sec_mailed_date IS NULL AND (claim.status=".DSS_CLAIM_SEC_SENT." OR claim.status=".DSS_CLAIM_PAID_SEC_INSURANCE." OR claim.status=".DSS_CLAIM_PAID_SEC_PATIENT." ))
                         OR claim.status IN (".DSS_CLAIM_PENDING.",".DSS_CLAIM_SEC_PENDING.",".DSS_CLAIM_REJECTED.",".DSS_CLAIM_DISPUTE.",".DSS_CLAIM_SEC_DISPUTE.",".DSS_CLAIM_PATIENT_DISPUTE.",".DSS_CLAIM_SEC_PATIENT_DISPUTE.")) ";
    

$sql .= " AND (
  CASE WHEN claim.status IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_DISPUTE.", ".DSS_CLAIM_REJECTED.", ".DSS_CLAIM_PATIENT_DISPUTE.", ".DSS_CLAIM_SENT.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.")
    THEN p.p_m_dss_file
    ELSE p.s_m_dss_file
   END = '1'
	
	 OR c.exclusive=1)
";
//print $sql;
$sort_dir = (isset($_REQUEST['sort_dir']))?strtolower($_REQUEST['sort_dir']):'';
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : 'adddate';
$sort_by_sql = $sort_by ." ".$sort_dir;
$sql .= " ORDER BY ".$sort_by_sql;
$my = mysqli_query($con,$sql);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Claims
</div>
<p style="margin-left:20px;">Select the claims you wish to export to Office Ally, then click the button to generate the export file. This file can then be uploaded to Office Ally.</p>

<br />
<?php
if(isset($_GET['msg'])){
?>
<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>
<?php } ?>
<div style="float:right; margin-right:20px;">
  <a href="#" style="padding:2px;" onclick="$('#oa_form :checkbox').attr('checked','checked');$('#oa_form :checkbox').parent().addClass('checked');" class="btn btn-primary">Select All</a>
</div>
<div style="clear:both;"></div>
<br />
<form name="pagefrm" id="oa_form" action="insurance_officeally.php" method="post" target="_blank" onsubmit="setTimeout(function () { window.location.reload(); }, 500)">
<table class="table table-bordered table-hover">
	<?php if(!empty($total_rec) && $total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"status=".$_GET['status']."&fid=".$_GET['fid']."&pid=".$_GET['pid']."&sort_by=".$_GET['sort_by']."&sort_dir=".$_GET['sort_dir']);
			?>
		</TD>
	</TR>
	<?php }?>
	<?php
    $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . (!empty($fid) ? $fid : '') . "&pid=" . (!empty($pid) ? $pid : '')
             . "&status=" . ((isset($_REQUEST['status']))?$_REQUEST['status']:'') . "&sort_by=%s&sort_dir=%s";
    ?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'adddate', $sort_dir) ?>" width="15%">
			<a href="<?=sprintf($sort_qs, 'adddate', get_sort_dir($sort_by, 'adddate', $sort_dir))?>">Added</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'status', $sort_dir) ?>" width="10%">
			<a href="<?=sprintf($sort_qs, 'status', get_sort_dir($sort_by, 'status', $sort_dir))?>">Status</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'pat_name', $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, 'pat_name', get_sort_dir($sort_by, 'pat_name', $sort_dir))?>">Patient Name</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'doc_name', $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, 'doc_name', get_sort_dir($sort_by, 'doc_name', $sort_dir))?>">Account</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'user_name', $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, 'user_name', get_sort_dir($sort_by, 'user_name', $sort_dir))?>">User</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'billing_name', $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, 'billing_name', get_sort_dir($sort_by, 'billing_name', $sort_dir))?>">Billing Company</a>
                </td>
		<td valign="top" class="col_head" width="15%">
			Select	
		</td>
	</tr>
	<?php if(mysqli_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="7" align="center">
				No Records
			</td>
		</tr>
	<?php 
	}
	else
	{
		while($myarray = mysqli_fetch_array($my))
		{
		?>
			<tr class="<?= (isset($tr_class))?$tr_class:'';?>">
				<td valign="top">
					<?=st($myarray["adddate"]);?>&nbsp;
				</td>
				<?php $status_color = ($myarray["status"] == DSS_CLAIM_PENDING) ? "yellow" : "green"; ?>
				<?php $status_color = ($myarray["status"] == DSS_CLAIM_PENDING && $myarray['days_pending'] > 7) ? "red" : $status_color; ?>
				<?php $status_text = ($myarray["status"] == DSS_CLAIM_PENDING) ? "black" : "white"; ?>
				<td valign="top" class="claim_<?= $myarray["status"]; ?> <?= ($myarray['days_pending']>7)?'old':''; ?>">
					<?=st($dss_claim_status_labels[$myarray["status"]]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["lastname"]);?>, <?=st($myarray["firstname"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["doc_name"]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["user_name"]);?>&nbsp;
				</td>
                                <td valign="top">
                                        <?=st($myarray["billing_name"]);?>&nbsp;
                                </td>
<td>
        <input type="checkbox" name="claim[]" value="<?= $myarray['insuranceid']; ?>" 
/></td>
			</tr>
	<?php 	}
	}?>
</table>

<input type="checkbox" name="claims_sent" value="1" /> Mark selected claims as sent
<br />

<input type="submit" value="Export Selected Claims" class="btn btn-primary">
</form>

<br /><br />	
<?php include "includes/bottom.htm";?>
<?php
if(isset($_GET['sendins'])&&$_GET['sendins']==1){
  include '../insurance_electronic_file.php';
}
if(isset($_GET['checkstatus'])&&$_GET['checkstatus']==1){
  include '../insurance_check_status.php';
}
if(isset($_GET['showins'])&&$_GET['showins']==1){
  /*
  $api_sql = "SELECT u.use_eligible_api, p.p_m_eligible_id FROM dental_users u
		JOIN dental_insurance i ON i.docid = u.userid
 		JOIN dental_patients p ON p.patientid=i.patientid
                WHERE i.insuranceid='".mysqli_real_escape_string($con,$_GET['insid'])."'";
  $api_q = mysqli_query($con,$api_sql);
  $api_r = mysqli_fetch_assoc($api_q);
  if($api_r['use_eligible_api']==1 && $api_r['p_m_eligible_id']!=''){
    include '../insurance_electronic_file.php';
  } */
  ?>
  <script type="text/javascript">
    window.location = "../insurance_fdf.php?insid=<?= $_GET['insid']; ?>&type=<?=$_GET['type'];?>&pid=<?= $_GET['pid'];?>";
  </script>
  <?php
}
?>

<script type="text/javascript">
  $('.mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
                                   $.ajax({
                                        url: "../includes/claim_mail.php",
                                        type: "post",
                                        data: {lid: lid, mailed: c, type:'pri'},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        //window.location.reload();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

  });

  $('.sec_mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
                                   $.ajax({
                                        url: "../includes/claim_mail.php",
                                        type: "post",
                                        data: {lid: lid, mailed: c, type: 'sec'},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        //window.location.reload();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

  });

</script>
