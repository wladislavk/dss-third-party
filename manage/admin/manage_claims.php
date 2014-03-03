<? 
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

if(isset($_GET['upstatus'])){
  $old_sql = "SELECT status FROM dental_insurance WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
  $old_q = mysql_query($old_sql);
  $old = mysql_fetch_assoc($old_q);
  $sql = "UPDATE dental_insurance SET status='".mysql_real_escape_string($_GET['upstatus'])."' WHERE insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
  mysql_query($sql);
  claim_status_history_update($_GET['ins_id'], $old['status'], $_GET['upstatus'], $_SESSION['userid']);
}


$fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';
$pid = (isset($_REQUEST['pid']))?$_REQUEST['pid']:'';
define('SORT_BY_DATE', '0');
define('SORT_BY_STATUS', '1');
define('SORT_BY_PATIENT', '2');
define('SORT_BY_FRANCHISEE', '3');
define('SORT_BY_USER', '4');
define('SORT_BY_BC', '5');
$sort_dir = (isset($_REQUEST['sort_dir']))?strtolower($_REQUEST['sort_dir']):'';
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;
$sort_by_sql = '';
switch ($sort_by) {
  case SORT_BY_DATE:
    $sort_by_sql = "claim.adddate $sort_dir";
    break;
  case SORT_BY_PATIENT:
    $sort_by_sql = "p.lastname $sort_dir, p.firstname $sort_dir";
    break;
  case SORT_BY_FRANCHISEE:
    $sort_by_sql = "doc_name $sort_dir";
    break;
  case SORT_BY_USER:
    $sort_by_sql = "user_name $sort_dir";
    break;
  case SORT_BY_BC:
    $sort_by_sql = "billing_name $sort_dir";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "status_order $sort_dir, claim.adddate $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if(isset($_REQUEST["delid"])  && $_SESSION['admin_access']==1) {
	$del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&fid=<?=$_REQUEST['fid']?>&pid=<?=$_REQUEST['pid']?>";
	</script>
	<?
	die();
}

if(isset($_REQUEST['sendid'])){
  if($_REQUEST['sendid']!=''){
  $sendid = $_REQUEST['sendid'];
  $send_sql = "SELECT i.*, f.description AS dispute_description FROM dental_insurance i
		LEFT JOIN dental_insurance_file f ON f.claimid=i.insuranceid
		WHERE insuranceid='".mysql_real_escape_string($sendid)."'
		ORDER BY f.id DESC";
  $send_q = mysql_query($send_sql);
  $send_r = mysql_fetch_assoc($send_q);
  $status = $send_r['status'];
  if($status == DSS_CLAIM_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SENT."' WHERE insuranceid='".mysql_real_escape_string($sendid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SENT, $_SESSION['userid']);
  }elseif( $status == DSS_CLAIM_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_PATIENT."' WHERE insuranceid='".mysql_real_escape_string($sendid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_PATIENT, $_SESSION['userid']);
  }elseif($status == DSS_CLAIM_SEC_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SEC_SENT."' WHERE insuranceid='".mysql_real_escape_string($sendid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SEC_SENT, $_SESSION['userid']);
  }elseif($status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_SEC_PATIENT."' WHERE insuranceid='".mysql_real_escape_string($sendid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_SEC_PATIENT, $_SESSION['userid']);
  }

  $note_sql = "INSERT INTO dental_ledger_note SET
		service_date = CURDATE(),
		entry_date = CURDATE(),
		private = 1,
		docid = '".$send_r['docid']."',
		patientid = '".$send_r['patientid']."',
		admin_producerid = '".$_SESSION['adminuserid']."',
		note = 'Disputed insurance claim ".$sendid." re-filed with insurance company.'";
  mysql_query($note_sql);
}
}
if(isset($_REQUEST['cancelid'])){
  $cancelid = $_REQUEST['cancelid'];
  $cancel_sql = "SELECT * FROM dental_insurance WHERE insuranceid='".mysql_real_escape_string($cancelid)."'";
  $cancel_q = mysql_query($cancel_sql);
  $cancel_r = mysql_fetch_assoc($cancel_q);
  $status = $cancel_r['status'];
  if($status == DSS_CLAIM_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SENT."' WHERE insuranceid='".mysql_real_escape_string($cancelid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SENT, $_SESSION['userid']);
  }elseif( $status == DSS_CLAIM_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_PATIENT."' WHERE insuranceid='".mysql_real_escape_string($cancelid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_PATIENT, $_SESSION['userid']);
  }elseif($status == DSS_CLAIM_SEC_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SEC_SENT."' WHERE insuranceid='".mysql_real_escape_string($cancelid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SEC_SENT, $_SESSION['userid']);
  }elseif($status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_SEC_PATIENT."' WHERE insuranceid='".mysql_real_escape_string($cancelid)."'";
    mysql_query($new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_SEC_PATIENT, $_SESSION['userid']);
  }
  $note_sql = "INSERT INTO dental_ledger_note SET
                service_date = CURDATE(),
                entry_date = CURDATE(),
                private = 1,
                docid = '".$cancel_r['docid']."',
                patientid = '".$cancel_r['patientid']."',
                admin_producerid = '".$_SESSION['adminuserid']."',
                note = 'Disputed insurance claim ".$cancelid." canceled after communication with office.'";
  mysql_query($note_sql);
}

$rec_disp = 20;

if(isset($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

if(is_super($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, p.firstname, p.lastname, "
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
     . "  JOIN dental_users users ON claim.docid = users.userid AND users.billing_company_id='".mysql_real_escape_string($_SESSION['admincompanyid'])."'"
     . "  JOIN dental_user_company uc ON uc.userid = claim.docid " 
     . "  JOIN dental_users users2 ON claim.userid = users2.userid ";
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
     . "  JOIN dental_user_company uc ON uc.userid = claim.docid AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'"
     . "  JOIN dental_users users2 ON claim.userid = users2.userid ";
}
// . "  LEFT JOIN dental_insurance_file dif ON dif.claimid = claim.insuranceid ";

// filter based on select lists above table
if ((isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) || !empty($_REQUEST['fid'])) {
    $sql .= "WHERE "; 
    if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
	if($_REQUEST['status'] == '0' ){
		//echo DSS_CLAIM_PENDING;
	   	$sql .= " (
			(claim.mailed_date IS NULL AND (claim.status=".DSS_CLAIM_SENT." OR claim.status=".DSS_CLAIM_PAID_INSURANCE." OR claim.status=".DSS_CLAIM_PAID_PATIENT." ))
			OR (claim.sec_mailed_date IS NULL AND (claim.status=".DSS_CLAIM_SEC_SENT." OR claim.status=".DSS_CLAIM_PAID_SEC_INSURANCE." OR claim.status=".DSS_CLAIM_PAID_SEC_PATIENT." ))
			 OR claim.status IN (".DSS_CLAIM_PENDING.",".DSS_CLAIM_SEC_PENDING.",".DSS_CLAIM_REJECTED.",".DSS_CLAIM_DISPUTE.",".DSS_CLAIM_SEC_DISPUTE.",".DSS_CLAIM_PATIENT_DISPUTE.",".DSS_CLAIM_SEC_PATIENT_DISPUTE.")) ";
	}elseif($_REQUEST['status'] == '1'){
		$sql .= " ((claim.mailed_date IS NOT NULL AND claim.status IN (".DSS_CLAIM_SENT.", ".DSS_CLAIM_PAID_INSURANCE.", ".DSS_CLAIM_PAID_PATIENT.")) OR
				(claim.mailed_date IS NOT NULL AND claim.status IN (".DSS_CLAIM_SEC_SENT.", ".DSS_CLAIM_PAID_SEC_INSURANCE.", ".DSS_CLAIM_PAID_SEC_PATIENT.")))";
        }elseif($_REQUEST['status'] == 'unpaid21'){
                $sql .= " claim.status NOT IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_SEC_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.",".DSS_CLAIM_PAID_SEC_PATIENT.") AND claim.adddate < DATE_SUB(NOW(), INTERVAL 21 day)";
        }elseif($_REQUEST['status'] == 'unpaid45'){
                $sql .= " claim.status NOT IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_SEC_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.",".DSS_CLAIM_PAID_SEC_PATIENT.") AND claim.adddate < DATE_SUB(NOW(), INTERVAL 45 day)";
        }else{
        	$sql .= "  claim.status = " . $_REQUEST['status'] . " ";
	}
    }
    
    if (!empty($_REQUEST['fid'])) {
        if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
            $sql .= "  AND ";
        }
        $sql .= "  users.userid = " . $_REQUEST['fid'] . " ";
    }
    
    if (!empty($_REQUEST['pid'])) {
        $sql .= "AND claim.patientid = " . $_REQUEST['pid'] . " ";
    }

}

$sql .= " AND 
  CASE WHEN claim.status IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_DISPUTE.", ".DSS_CLAIM_REJECTED.", ".DSS_CLAIM_PATIENT_DISPUTE.", ".DSS_CLAIM_SENT.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.")
    THEN p.p_m_dss_file
    ELSE p.s_m_dss_file
   END = '1'
ORDER BY " . $sort_by_sql;
//print $sql;
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Claims
</div>
<br />
<br />
&nbsp;

<br />
<?php
if(isset($_GET['msg'])){
?>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<?php } ?>
<div style="width:98%;margin:auto;">
  <form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="get">
    Status:
    <select name="status">
      <?php $pending_selected = ($status == DSS_CLAIM_PENDING) ? 'selected' : ''; ?>
      <?php $sent_selected = ($status == DSS_CLAIM_SENT) ? 'selected' : ''; ?>
      <?php $unpaid21_selected = ($status == 'unpaid21') ? 'selected' : ''; ?>
      <?php $unpaid45_selected = ($status == 'unpaid45') ? 'selected' : ''; ?>
      <?php $rejected_selected = ($status == DSS_CLAIM_REJECTED) ? 'selected' : ''; ?>
      <option value="">Any</option>
      <option value="<?=DSS_CLAIM_PENDING?>" <?=$pending_selected?>><?=$dss_claim_status_labels[DSS_CLAIM_PENDING]?></option>
      <option value="<?=DSS_CLAIM_SENT?>" <?=$sent_selected?>><?=$dss_claim_status_labels[DSS_CLAIM_SENT]?></option>
      <option value="unpaid21" <?= $unpaid45_selected; ?>>Unpaid 21+ Days</option>
      <option value="unpaid45" <?= $unpaid45_selected; ?>>Unpaid 45+ Days</option>
      <option value="<?=DSS_CLAIM_REJECTED?>" <?=$rejected_selected;?>><?=$dss_claim_status_labels[DSS_CLAIM_REJECTED];?></option>
    </select>
    &nbsp;&nbsp;&nbsp;

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

    <?php if (!empty($_REQUEST['fid'])) { ?>
      Patients:
      <select name="pid">
        <option value="">Any</option>
        <?php $patients = get_patients($_REQUEST['fid']); ?>
        <?php while ($row = mysql_fetch_array($patients)) { ?>
          <?php $selected = ($row['patientid'] == $_REQUEST['pid']) ? 'selected' : ''; ?>
          <option value="<?= $row['patientid'] ?>" <?= $selected ?>>[<?= $row['patientid'] ?>] <?= $row['lastname'] ?>, <?= $row['firstname'] ?></option>
        <?php } ?>
      </select>
      &nbsp;&nbsp;&nbsp;
    <?php } ?>
    
    <input type="hidden" name="sort_by" value="<?=$sort_by?>"/>
    <input type="hidden" name="sort_dir" value="<?=$sort_dir?>"/>
    <input type="submit" value="Filter List" class="btn btn-primary">
    <input type="button" value="Reset" onclick="window.location='<?=$_SERVER['PHP_SELF']?>'" class="btn btn-primary">
  </form>
<?php
  if(is_billing($_SESSION['admin_access']) || is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access'])){ 
?>
<a style="float:right;"  href="report_claim_aging.php" class="button"> Claim Aging </a>
<?php } ?>
<div style="clear:both;"></div>
</div>

<form name="pagefrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"status=".$_GET['status']."&fid=".$_GET['fid']."&pid=".$_GET['pid']."&sort_by=".$_GET['sort_by']."&sort_dir=".$_GET['sort_dir']);
			?>
		</TD>
	</TR>
	<? }?>
	<?php
    $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $fid . "&pid=" . $pid
             . "&status=" . ((isset($_REQUEST['status']))?$_REQUEST['status']:'') . "&sort_by=%s&sort_dir=%s";
    ?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_DATE, $sort_dir) ?>" width="15%">
			<a href="<?=sprintf($sort_qs, SORT_BY_DATE, get_sort_dir($sort_by, SORT_BY_DATE, $sort_dir))?>">Added</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_STATUS, $sort_dir) ?>" width="10%">
			<a href="<?=sprintf($sort_qs, SORT_BY_STATUS, get_sort_dir($sort_by, SORT_BY_STATUS, $sort_dir))?>">Status</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_PATIENT, $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, SORT_BY_PATIENT, get_sort_dir($sort_by, SORT_BY_PATIENT, $sort_dir))?>">Patient Name</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_FRANCHISEE, $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, SORT_BY_FRANCHISEE, get_sort_dir($sort_by, SORT_BY_FRANCHISEE, $sort_dir))?>">Account</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_USER, $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, SORT_BY_USER, get_sort_dir($sort_by, SORT_BY_USER, $sort_dir))?>">User</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_BC, $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, SORT_BY_BC, get_sort_dir($sort_by, SORT_BY_BC, $sort_dir))?>">Billing Company</a>
                </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
		<td valign="top" class="col_head" width="15%">
			Mailed
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="7" align="center">
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
					<a href="view_patient.php?pid=<?=$myarray['patientid'];?>"><?=st($myarray["lastname"]);?>, <?=st($myarray["firstname"]);?></a>
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
				<td valign="top">
				    <?php
					//$primary_link = ($myarray['primary_fdf']!='')?'../insurance_fdf_view.php?file='.$myarray['primary_fdf']:'../insurance_fdf.php?insid='.$myarray['insuranceid'].'&type=primary&pid='.$myarray['patientid'];
					//$secondary_link = ($myarray['secondary_fdf']!='')?'../insurance_fdf_view.php?file='.$myarray['secondary_fdf']:'../insurance_fdf.php?insid='.$myarray['insuranceid'].'&type=secondary&pid='.$myarray['patientid'];
					$primary_link = "insurance_claim.php?insid=".$myarray['insuranceid']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid'];
					$secondary_link = "insurance_claim.php?insid=".$myarray['insuranceid']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid']."&instype=2";
					?>
				    <?php if($myarray["status"] == DSS_CLAIM_PENDING || $myarray["status"] == DSS_CLAIM_REJECTED){ ?>
				    <a href="insurance_claim.php?insid=<?=$myarray['insuranceid']?>&fid_filter=<?=$fid?>&pid_filter=<?=$pid?>&pid=<?=$myarray['patientid']?>" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a> 
				<?php }elseif($myarray["status"] == DSS_CLAIM_SEC_PENDING){ ?>
                                    <a href="insurance_claim.php?insid=<?=$myarray['insuranceid']?>&fid_filter=<?=$fid?>&pid_filter=<?=$pid?>&pid=<?=$myarray['patientid']?>&instype=2" title="Edit" class="btn btn-primary btn-sm">
                                                Edit Secondary
                                         <span class="glyphicon glyphicon-pencil"></span></a><br />
					<a href="<?= $primary_link; ?>" title="Edit" class="btn btn-primary btn-sm">View Primary <span class="glyphicon glyphicon-pencil"></span></a>
                                <?php }elseif($myarray["status"] == DSS_CLAIM_SEC_SENT || $myarray["status"] == DSS_CLAIM_PAID_SEC_INSURANCE){ ?>
                                    <a href="<?= $secondary_link; ?>" title="Edit" class="btn btn-primary btn-sm">
                                                View Secondary
                                         <span class="glyphicon glyphicon-pencil"></span></a><br />
                                        <a href="<?= $primary_link; ?>" title="Edit" class="btn btn-primary btn-sm">View Primary <span class="glyphicon glyphicon-pencil"></span></a>
                                <?php }else{ ?>
					<a href="<?= $primary_link; ?>" title="Edit" class="btn btn-primary btn-sm">View <span class="glyphicon glyphicon-pencil"></span></a>
				<?php } ?>
				<?php 
					$eobsql = "SELECT * FROM dental_insurance_file WHERE claimid='".mysql_real_escape_string($myarray['insuranceid'])."'";
					$eobq = mysql_query($eobsql);
					while($eobr = mysql_fetch_assoc($eobq)){
						?><br /><a href="display_file.php?f=<?= $eobr['filename']; ?>" title="Edit" class="btn btn-primary btn-sm">View <?= $eobr['claimtype']; ?> EOB <span class="glyphicon glyphicon-pencil"></span></a>
				<?php } ?>
<?php if($myarray['status'] == DSS_CLAIM_DISPUTE || $myarray['status'] == DSS_CLAIM_PATIENT_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='primary' AND f.claimid='".mysql_real_escape_string($myarray['insuranceid'])."'";
            $sq = mysql_query($s);
            if(mysql_num_rows($sq)>0){
            $file = mysql_fetch_assoc($sq);
            ?>
	   <br />
           <a href="javascript:alert('Dispute Reason:\n<?= $file['description']; ?>');">Reason</a>
		<br />
	 <?php } ?>
		<a href="manage_claims.php?status=<?= $_GET['status']; ?>&sendid=<?= $myarray['insuranceid']; ?>" onclick="return confirm('This will mark the disputed claim as sent and notify the frontoffice. Proceed?')">Mark Complete</a>
                <a href="manage_claims.php?status=<?= $_GET['status']; ?>&cancelid=<?= $myarray['insuranceid']; ?>" onclick="return confirm('This will CANCEL the disputed claim and notify the frontoffice. Proceed?')">Cancel Dispute</a>
	 <?php
          }elseif($myarray['status'] == DSS_CLAIM_SEC_DISPUTE || $myarray['status'] == DSS_CLAIM_SEC_PATIENT_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='secondary' AND f.claimid='".mysql_real_escape_string($myarray['insuranceid'])."'";
            $sq = mysql_query($s);
            if(mysql_num_rows($sq)>0){
            $file = mysql_fetch_assoc($sq);
            ?>
	   <br />
           <a href="javascript:alert('Dispute Reason:\n<?= $file['description']; ?>');">Reason</a>
	   <br />
        <?php }
		?><a href="manage_claims.php?status=<?= $_GET['status']; ?>&sendid=<?= $myarray['insuranceid']; ?>" onclick="return confirm('This will mark the disputed claim as sent and notify the frontoffice. Proceed?')">Mark Complete</a><?php
           } ?>

				</td>
<td>
<?php
  if($myarray['status'] == DSS_CLAIM_SENT || $myarray['status'] == DSS_CLAIM_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_INSURANCE || $myarray['status'] == DSS_CLAIM_PENDING || $myarray['status'] == DSS_CLAIM_PAID_PATIENT || $myarray['status'] == DSS_CLAIM_REJECTED || $myarray['status'] == DSS_CLAIM_PATIENT_DISPUTE ){
	?><input type="checkbox" class="mailed_chk" value="<?= $myarray['insuranceid']; ?>" <?php
  echo ($myarray['mailed_date'] !='')?'checked="checked"':''; 
}elseif($myarray['status'] == DSS_CLAIM_SEC_SENT || $myarray['status'] == DSS_CLAIM_SEC_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_SEC_INSURANCE || $myarray['status'] == DSS_CLAIM_SEC_PENDING || $myarray['status'] == DSS_CLAIM_PAID_SEC_PATIENT || $myarray['status'] == DSS_CLAIM_SEC_REJECTED || $myarray['status'] == DSS_CLAIM_SEC_PATIENT_DISPUTE ){
        ?><input type="checkbox" class="sec_mailed_chk" value="<?= $myarray['insuranceid']; ?>" <?php
  echo ($myarray['sec_mailed_date'] !='')?'checked="checked"':''; 
}
?>
/></td>
			</tr>
	<? 	}
	}?>
</table>
</form>

<br /><br />	
<? include "includes/bottom.htm";?>
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
                WHERE i.insuranceid='".mysql_real_escape_string($_GET['insid'])."'";
  $api_q = mysql_query($api_sql);
  $api_r = mysql_fetch_assoc($api_q);
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
