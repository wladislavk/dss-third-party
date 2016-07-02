<?php namespace Ds3\Libraries\Legacy; ?><?
include "includes/top.htm";

include 'includes/patient_nav.php';

$isSuperAdmin = is_super($_SESSION['admin_access']);
$specialFilter = '';

if ($isSuperAdmin && isset($_GET['filed_by'])) {
    switch ($_GET['filed_by']) {
        case 'front':
        case 'both':
            $specialFilter = $_GET['filed_by'];
            break;
    }
}

if(isset($_GET['upstatus'])){
  $old_sql = "SELECT status FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,$_GET['insid'])."'";
  $old_q = mysqli_query($con, $old_sql);
  $old = mysqli_fetch_assoc($old_q);
  $sql = "UPDATE dental_insurance SET status='".mysqli_real_escape_string($con,$_GET['upstatus'])."' WHERE insuranceid='".mysqli_real_escape_string($con,$_GET['insid'])."'";
  mysqli_query($con, $sql);
  claim_status_history_update($_GET['ins_id'], $old['status'], $_GET['upstatus'], '', $_SESSION['adminuserid']);
}

$fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';
$pid = (isset($_REQUEST['pid']))?$_REQUEST['pid']:'';

define('SORT_BY_DATE', '0');
define('SORT_BY_STATUS', '1');
define('SORT_BY_PATIENT', '2');
define('SORT_BY_FRANCHISEE', '3');
define('SORT_BY_USER', '4');
define('SORT_BY_BC', '5');
define('SORT_BY_FILED', '6');

$sort_dir = (isset($_REQUEST['sort_dir']))?strtolower($_REQUEST['sort_dir']):'';
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;

if ($sort_by == SORT_BY_FILED && !$isSuperAdmin) {
    $sort_by = SORT_BY_STATUS;
}

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
  case SORT_BY_FILED:
    $sort_by_sql = "filed_by_bo $sort_dir, p.lastname ASC, p.firstname ASC, status_order ASC, claim.adddate DESC";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "status_order $sort_dir, claim.adddate $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if(isset($_REQUEST["delid"])  && $_SESSION['admin_access']==1) {
	$del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delid"]."'";
	mysqli_query($con, $del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&fid=<?=$_REQUEST['fid']?>&pid=<?=$_REQUEST['pid']?>";
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

if(isset($_REQUEST['sendid'])){
  if($_REQUEST['sendid']!=''){
  $sendid = $_REQUEST['sendid'];
  $send_sql = "SELECT i.*, f.description AS dispute_description FROM dental_insurance i
		LEFT JOIN dental_insurance_file f ON f.claimid=i.insuranceid
		WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'
		ORDER BY f.id DESC";
  $send_q = mysqli_query($con, $send_sql);
  $send_r = mysqli_fetch_assoc($send_q);
  $status = $send_r['status'];
  if($status == DSS_CLAIM_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SENT, '', $_SESSION['adminuserid']);
  }elseif( $status == DSS_CLAIM_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_PATIENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SEC_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SEC_SENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_SEC_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_SEC_PATIENT, '', $_SESSION['adminuserid']);
  }

  $note_sql = "INSERT INTO dental_ledger_note SET
		service_date = CURDATE(),
		entry_date = CURDATE(),
		private = 1,
		docid = '".$send_r['docid']."',
		patientid = '".$send_r['patientid']."',
		admin_producerid = '".$_SESSION['adminuserid']."',
		note = 'Disputed insurance claim ".$sendid." re-filed with insurance company.'";
  mysqli_query($con, $note_sql);
}
}
if(isset($_REQUEST['cancelid'])){
  $cancelid = $_REQUEST['cancelid'];
  $cancel_sql = "SELECT * FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
  $cancel_q = mysqli_query($con, $cancel_sql);
  $cancel_r = mysqli_fetch_assoc($cancel_q);
  $status = $cancel_r['status'];
  if($status == DSS_CLAIM_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SENT, '', $_SESSION['adminuserid']);
  }elseif( $status == DSS_CLAIM_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_PATIENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SEC_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SEC_SENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_SEC_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con, $new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_SEC_PATIENT, '', $_SESSION['adminuserid']);
  }
  $note_sql = "INSERT INTO dental_ledger_note SET
                service_date = CURDATE(),
                entry_date = CURDATE(),
                private = 1,
                docid = '".$cancel_r['docid']."',
                patientid = '".$cancel_r['patientid']."',
                admin_producerid = '".$_SESSION['adminuserid']."',
                note = 'Disputed insurance claim ".$cancelid." canceled after communication with office.'";
  mysqli_query($con, $note_sql);
}

$rec_disp = 20;

if(isset($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$patientId = intval($_REQUEST['pid']);

$frontOfficeClaimsConditional = frontOfficeClaimsConditional();
$backOfficeClaimsConditional = backOfficeClaimsConditional();

switch ($specialFilter) {
    case 'both':
        $whichOfficeConditional = '(TRUE)';
        break;
    case 'front':
        $whichOfficeConditional = $frontOfficeClaimsConditional;
        break;
    default:
        $whichOfficeConditional = $backOfficeClaimsConditional;
}

$filedByBackOfficeConditional = filedByBackOfficeConditional();

$sql = "SELECT
    claim.insuranceid,
    claim.patientid,
    claim.primary_claim_id,
    claim.p_m_dss_file,
    claim.s_m_dss_file,
    p.firstname,
    p.lastname,
    claim.adddate,
    claim.status,
    CONCAT(users.first_name, ' ', users.last_name) AS doc_name,
    CONCAT(users2.first_name, ' ', users2.last_name) AS user_name,
    claim.primary_fdf,
    claim.secondary_fdf,
    claim.mailed_date,
    claim.sec_mailed_date,
    DATEDIFF(NOW(), claim.adddate) AS days_pending,
    IF (
        COALESCE(claim.primary_claim_id, 0),
        COALESCE(co2.company, ''),
        COALESCE(co.company, '')
    ) AS ins_name,
    CASE claim.status
        WHEN '" . DSS_CLAIM_PENDING . "' THEN 1
        WHEN '" . DSS_CLAIM_SEC_PENDING . "' THEN 2
        WHEN '" . DSS_CLAIM_DISPUTE . "' THEN 3
        WHEN '" . DSS_CLAIM_SEC_DISPUTE . "' THEN 4
        WHEN '" . DSS_CLAIM_SENT . "' THEN 5
        WHEN '" . DSS_CLAIM_SEC_SENT . "' THEN 6
        WHEN '" . DSS_CLAIM_REJECTED . "' THEN 7
        WHEN '" . DSS_CLAIM_PAID_INSURANCE . "' THEN 8
        WHEN '" . DSS_CLAIM_PAID_SEC_INSURANCE . "' THEN 9
        WHEN '" . DSS_CLAIM_PAID_PATIENT . "' THEN 10
        WHEN '" . DSS_CLAIM_PAID_SEC_PATIENT . "' THEN 11
    END AS status_order,
    c.name AS billing_name
    ";

if (is_super($_SESSION['admin_access'])) {
    $sql .= ",
            $filedByBackOfficeConditional AS filed_by_bo,
            (
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = claim.insuranceid
            ) AS num_notes,
            (
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = claim.insuranceid
                    AND create_type = '1'
            ) AS num_fo_notes
        FROM dental_insurance claim
            JOIN dental_patients p ON p.patientid = claim.patientid
            JOIN dental_users users ON claim.docid = users.userid
            JOIN dental_users users2 ON claim.userid = users2.userid
            LEFT JOIN companies c ON c.id = users.billing_company_id
            LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co
            LEFT JOIN dental_contact co2 ON co2.contactid = p.s_m_ins_co
        ";
} elseif (is_billing($_SESSION['admin_access'])) {
    $sql .= "
        FROM dental_insurance claim
            JOIN dental_patients p ON p.patientid = claim.patientid
            JOIN dental_users users ON claim.docid = users.userid
                AND users.billing_company_id = '" . $db->escape($_SESSION['admincompanyid']) . "'
            LEFT JOIN companies c ON c.id = users.billing_company_id
            JOIN dental_user_company uc ON uc.userid = claim.docid
            LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co
            LEFT JOIN dental_contact co2 ON co2.contactid = p.s_m_ins_co
            JOIN dental_users users2 ON claim.userid = users2.userid
        ";
} else {
    $sql .= "
        FROM dental_insurance claim
            JOIN dental_patients p ON p.patientid = claim.patientid
            JOIN dental_users users ON claim.docid = users.userid
            LEFT JOIN companies c ON c.id = users.billing_company_id
            JOIN dental_user_company uc ON uc.userid = claim.docid
                AND uc.companyid = '" . $db->escape($_SESSION['admincompanyid']) . "'
            LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co
            LEFT JOIN dental_contact co2 ON co2.contactid = p.s_m_ins_co
            JOIN dental_users users2 ON claim.userid = users2.userid
        ";
}

/**
 * @see DSS-142
 * @see CS-73
 *
 * Filter BO claims by actionable claims.
 * This query might appear at some other places, please search this "@see DSS-142" tag.
 *
 * The old logic checks the p_m_dss_file and s_m_dss_file columns, which are copies of the options set from the
 * patient's table. This logic does not really set if the claim is filed in the BO.
 *
 * The legacy values are: YES = 1, NO = 2. Thus, if the option is NOT 1 THEN the value is NOT YES.
 *
 * The new indicator will only be the p_m_dss_file column. To avoid conflicts with the previous set of values, the
 * YES indicator will be 3.
 */
$sql .= "
    WHERE claim.patientid = '$patientId'
        AND $whichOfficeConditional
    ORDER BY $sort_by_sql";

$countSql = preg_replace('/^SELECT/', 'SELECT COUNT(claim.insuranceid) AS total, ', $sql);
$total_rec = $db->getColumn($countSql, 'total');
$no_pages = $total_rec/$rec_disp;

$sql .= " LIMIT $i_val, $rec_disp";
$my = $db->getResults($sql);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
    Manage Claims
    <?php if ($isSuperAdmin) { ?>
        <a class="btn btn-xs <?= $specialFilter == 'front' ? 'btn-info active' : 'btn-default' ?>"
           href="/manage/admin/patient_claims.php?pid=<?= $patientId ?>&amp;filed_by=front">FO Claims</a>
        <a class="btn btn-xs <?= !$specialFilter ? 'btn-info active' : 'btn-default' ?>"
           href="/manage/admin/patient_claims.php?pid=<?= $patientId ?>">BO Claims</a>
        <a class="btn btn-xs <?= $specialFilter == 'both' ? 'btn-info active' : 'btn-default' ?>"
           href="/manage/admin/patient_claims.php?pid=<?= $patientId ?>&amp;filed_by=both">Both</a>
    <?php } ?>
</div>
<?php
if(isset($_GET['msg'])){
?>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<?php } ?>

<form name="pagefrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"status=".$_GET['status']."&fid=".$_GET['fid']."&pid=".$_GET['pid']."&sort_by=".$_GET['sort_by']."&sort_dir=".$_GET['sort_dir'] . ($specialFilter ? "&filed_by=$specialFilter" : ''));
			?>
		</TD>
	</TR>
	<? }?>
	<?php
    $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $fid . "&pid=" . $pid
             . "&status=" . ((isset($_REQUEST['status']))?$_REQUEST['status']:'') . "&sort_by=%s&sort_dir=%s" .
        ($specialFilter ? "&filed_by=$specialFilter" : '');
    ?>
  <tr class="tr_bg_h">
    <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_DATE, $sort_dir) ?>" width="15%">
      <a href="<?=sprintf($sort_qs, SORT_BY_DATE, get_sort_dir($sort_by, SORT_BY_DATE, $sort_dir))?>">Added</a>
    </td>
    <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_STATUS, $sort_dir) ?>" width="10%">
      <a href="<?=sprintf($sort_qs, SORT_BY_STATUS, get_sort_dir($sort_by, SORT_BY_STATUS, $sort_dir))?>">Status</a>
    </td>
    <td>
      E-File
    </td>
    <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_PATIENT, $sort_dir) ?>" width="20%">
      <a href="<?=sprintf($sort_qs, SORT_BY_PATIENT, get_sort_dir($sort_by, SORT_BY_PATIENT, $sort_dir))?>">Patient Name</a>
    </td>
                <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_INS, $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, SORT_BY_INS, get_sort_dir($sort_by, SORT_BY_INS, $sort_dir))?>">Insurance Company</a>
                </td>
    <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_FRANCHISEE, $sort_dir) ?>" width="15%">
      <a href="<?=sprintf($sort_qs, SORT_BY_FRANCHISEE, get_sort_dir($sort_by, SORT_BY_FRANCHISEE, $sort_dir))?>">Account</a>
    </td>
    <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_USER, $sort_dir) ?>" width="15%">
      <a href="<?=sprintf($sort_qs, SORT_BY_USER, get_sort_dir($sort_by, SORT_BY_USER, $sort_dir))?>">User</a>
    </td>
    <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_BC, $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, SORT_BY_BC, get_sort_dir($sort_by, SORT_BY_BC, $sort_dir))?>">Billing Company</a>
                </td>
    <?php if ($isSuperAdmin) { ?>
      <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_FILED, $sort_dir) ?>" width="10%">
          <a href="<?= sprintf($sort_qs, SORT_BY_FILED, get_sort_dir($sort_by, SORT_BY_FILED, $sort_dir))?>">Filed By</a>
      </td>
    <?php } ?>
    <td valign="top" class="col_head" width="15%">
      Action
    </td>
                <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_NOTES, $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, SORT_BY_NOTES, get_sort_dir($sort_by, SORT_BY_NOTES, $sort_dir))?>">Notes</a>
                </td>
    <td valign="top" class="col_head" width="15%">
      Mailed
    </td>
  </tr>
  <?php if (!count($my)) { ?>
    <tr class="tr_bg">
      <td valign="top" class="col_head" colspan="7" align="center">
        No Records
      </td>
    </tr>
  <?php } else {
    foreach ($my as $myarray) { ?>
      <tr class="<?= (isset($tr_class))?$tr_class:'';?>">
        <td valign="top">
          <?=st($myarray["adddate"]);?>&nbsp;
        </td>
        <?php 
        switch($myarray['status']){
          case 0:
          case 2:
          case 6:
          case 8:
          case 10:
          case 12:
            if($myarray['days_pending']>7){
              $status_color = "danger";
            }else{
              $status_color = "warning";
            }
            break;
          case 4:
          case 13:
            $status_color = "danger";
            break;
          default:
            $status_color = "success";
            break;
        }
    
    //$status_color = ($myarray["status"] == DSS_CLAIM_PENDING) ? "warning" : "success"; ?>
        <?php //$status_color = ($myarray["status"] == DSS_CLAIM_PENDING && $myarray['days_pending'] > 7) ? "danger" : $status_color; ?>
        <td valign="top" class="claim_<?= $myarray["status"]; ?> <?= ($myarray['days_pending']>7)?'old':''; ?> <?= $status_color;?>">
          <?=st($dss_claim_status_labels[$myarray["status"]]);?>&nbsp;
        </td>
        <td>
          <?php
            $payment_report_sql = "SELECT * FROM dental_payment_reports WHERE claimid='".mysqli_real_escape_string($con, $myarray['insuranceid'])."' ORDER BY adddate DESC LIMIT 1";
            $payment_report_query = mysqli_query($con, $payment_report_sql);
            $payment_report_result = mysqli_fetch_assoc($payment_report_query);
            if($payment_report_result){
              echo '<a href="view_payment_reports.php?insid='.$payment_report_result['claimid'].'"> Paid - '.$payment_report_result['adddate']." (View)</a>";
            } else {
              $reference_id_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysqli_real_escape_string($con, $myarray['insuranceid'])."' ORDER BY adddate DESC LIMIT 1"; 
              $reference_id_query = mysqli_query($con, $reference_id_sql);
              $reference_id_result = mysqli_fetch_assoc($reference_id_query);
              if($reference_id_result){
                $reference_id = $reference_id_result['reference_id'];
                if($reference_id != ""){
                  $eligible_response_sql = "SELECT event_type, adddate FROM dental_eligible_response WHERE reference_id='".$reference_id."' ORDER BY adddate DESC";
                  $eligible_response_query = mysqli_query($con, $eligible_response_sql);
                  $eligible_response_result = mysqli_fetch_assoc($eligible_response_query);
                  echo $eligible_response_result['event_type']." - ".$eligible_response_result['adddate'];
                }
              }
            }
          ?>
        </td>
        <td valign="top">
          <a href="view_patient.php?pid=<?=$myarray['patientid'];?>"><?=st($myarray["lastname"]);?>, <?=st($myarray["firstname"]);?> (View Chart)</a>
        </td>
        <td valign="top">
          <?=st($myarray["ins_name"]);?>&nbsp;
        </td>
        <td valign="top">
          <a href="view_user.php?ed=<?= $myarray['docid']; ?>"><?=st($myarray["doc_name"]);?></a>&nbsp;
        </td>
        <td valign="top">
          <?=st($myarray["user_name"]);?>&nbsp;
        </td>
                                <td valign="top">
                                        <?=st($myarray["billing_name"]);?>&nbsp;
                                </td>
        <?php if ($isSuperAdmin) {
            $isPending = ClaimFormData::isStatus('pending', $myarray['status']);
            ?>
            <td valign="top">
                <p class="input-group text-center"
                    <?= $isPending ? 'title="This flag cannot be modified while the claim is pending"' : '' ?>>
                    <span class="input-group-btn bo-status-switch">
                        <button <?= $isPending ? 'disabled' : '' ?>
                            class="filed-by-fo btn btn-xs <?= !$myarray['filed_by_bo'] ? 'btn-info active' : 'btn-default' ?>"
                            type="button" data-claim-id="<?= $myarray['insuranceid'] ?>"
                            <?= $myarray['filed_by_bo'] ? 'title="Mark the claim as filed by the FO"' : '' ?>>FO</button>
                        <button <?= $isPending ? 'disabled' : '' ?>
                            class="filed-by-bo btn btn-xs <?= $myarray['filed_by_bo'] ? 'btn-info active' : 'btn-default' ?>"
                            type="button" data-claim-id="<?= $myarray['insuranceid'] ?>"
                            <?= !$myarray['filed_by_bo'] ? 'title="Mark the claim as filed by the BO"' : '' ?>>BO</button>
                    </span>
                </p>
            </td>
        <?php } ?>
        <td valign="top">
            <?php
          //$primary_link = ($myarray['primary_fdf']!='')?'../insurance_fdf_view.php?file='.$myarray['primary_fdf']:'../insurance_fdf.php?insid='.$myarray['insuranceid'].'&type=primary&pid='.$myarray['patientid'];
          //$secondary_link = ($myarray['secondary_fdf']!='')?'../insurance_fdf_view.php?file='.$myarray['secondary_fdf']:'../insurance_fdf.php?insid='.$myarray['insuranceid'].'&type=secondary&pid='.$myarray['patientid'];
          $paid_statuses = array(0 => DSS_CLAIM_PAID_INSURANCE, 1 => DSS_CLAIM_PAID_SEC_INSURANCE);
          $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='".mysqli_real_escape_string($con, $_GET['insid'])."'";
          $sec_q = mysqli_query($con, $sec_sql);
          $sec_r = mysqli_fetch_assoc($sec_q);
          $primary_link = "insurance_claim".(($myarray['primary_claim_version']!="1")?'_eligible':'_v2').".php?insid=".$myarray['insuranceid']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid'];
          $secondary_link = "insurance_claim".(($myarray['secondary_claim_version']!="1")?'_eligible':'_v2').".php?insid=".$sec_r['insuranceid']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid']."&instype=2";
          $reference_id_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysqli_real_escape_string($con, $myarray['insuranceid'])."' ORDER BY adddate DESC LIMIT 1"; 
          $reference_id_query = mysqli_query($con, $reference_id_sql);
          if(mysqli_num_rows($reference_id_query)){
            $reference_id_result = mysqli_fetch_assoc($reference_id_query);
            $reference_id = $reference_id_result['reference_id'];
            if($reference_id != "" && !in_array($myarray['status'], $paid_statuses)){
              $update_claim_url = "request_claim_update.php?insid=".$myarray['insuranceid'];
              ?>
                <a href="<?php echo $update_claim_url?>" class="btn btn-primary btn-sm" >Check Status</a>

              <?php
            } else if($reference_id != "" && in_array($myarray['status'], $paid_statuses)){
              $payment_status_url = "request_payment_report.php?insid=".$myarray['insuranceid'];
              ?>
                <a href="<?php echo $payment_status_url?>" class="btn btn-primary btn-sm" >Check Payment Status</a>

              <?php
            }
          }

              ?>
            <?php if($myarray["status"] == DSS_CLAIM_PENDING || $myarray["status"] == DSS_CLAIM_REJECTED){ ?>
            <a href="insurance_claim<?=($myarray['primary_claim_version']!="1")?'_eligible':'_v2'; ?>.php?insid=<?=$myarray['insuranceid']?>&fid_filter=<?=$fid?>&pid_filter=<?=$pid?>&pid=<?=$myarray['patientid']?>" class="btn btn-primary btn-sm">
            Edit
           <span class="glyphicon glyphicon-pencil"></span></a> 
        <?php }elseif($myarray["status"] == DSS_CLAIM_SEC_PENDING){ ?>
                                    <a href="insurance_claim<?=($myarray['secondary_claim_version']!="1")?'_eligible':'_v2'; ?>.php?insid=<?=$myarray['insuranceid']?>&fid_filter=<?=$fid?>&pid_filter=<?=$pid?>&pid=<?=$myarray['patientid']?>&instype=2" class="btn btn-primary btn-sm">
                                                Edit Secondary
                                         <span class="glyphicon glyphicon-pencil"></span></a><br />
          <a href="<?= "insurance_claim".(($myarray['primary_claim_version']!="1")?'_eligible':'_v2').".php?insid=".$myarray['primary_claim_id']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid'] ?>" class="btn btn-primary btn-sm">View Primary <span class="glyphicon glyphicon-pencil"></span></a>
                                <?php }elseif($myarray["status"] == DSS_CLAIM_SEC_SENT || $myarray["status"] == DSS_CLAIM_PAID_SEC_INSURANCE){ ?>
                                    <a href="<?= $secondary_link; ?>" class="btn btn-primary btn-sm">
                                                View Secondary
                                         <span class="glyphicon glyphicon-pencil"></span></a><br />
                                        <a href="<?= "insurance_claim".(($myarray['primary_claim_version']!="1")?'_eligible':'_v2').".php?insid=".$myarray['primary_claim_id']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid'] ?>" class="btn btn-primary btn-sm">View Primary <span class="glyphicon glyphicon-pencil"></span></a>
                                <?php }else{ ?>
          <a href="<?= $primary_link; ?>" class="btn btn-primary btn-sm">View <span class="glyphicon glyphicon-pencil"></span></a>
        <?php } ?>
        <?php 
          $eobsql = "SELECT * FROM dental_insurance_file WHERE claimid='".mysqli_real_escape_string($con, $myarray['insuranceid'])."'";
          $eobq = mysqli_query($con, $eobsql);
          while($eobr = mysqli_fetch_assoc($eobq)){
            ?><br /><a href="display_file.php?f=<?= $eobr['filename']; ?>" <?= $eobr['claimtype']; ?> EOB" class="btn btn-primary btn-sm">View <?= $eobr['claimtype']; ?> EOB <span class="glyphicon glyphicon-pencil"></span></a>
        <?php } ?>
<?php if($myarray['status'] == DSS_CLAIM_DISPUTE || $myarray['status'] == DSS_CLAIM_PATIENT_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='primary' AND f.claimid='".mysqli_real_escape_string($con,$myarray['insuranceid'])."'";
            $sq = mysqli_query($con, $s);
            if(mysqli_num_rows($sq)>0){
            $file = mysqli_fetch_assoc($sq);
            ?>
     <br />
           <a href="javascript:alert('Dispute Reason:\n<?= $file['description']; ?>');">Reason</a>
    <br />
   <?php } ?>
    <a href="manage_claims.php?status=<?= $_GET['status']; ?>&sendid=<?= $myarray['insuranceid']; ?>" onclick="return confirm('This will mark the disputed claim as sent and notify the frontoffice. Proceed?')">Mark Complete</a>
                <a href="manage_claims.php?status=<?= $_GET['status']; ?>&cancelid=<?= $myarray['insuranceid']; ?>" onclick="return confirm('This will CANCEL the disputed claim and notify the frontoffice. Proceed?')">Cancel Dispute</a>
   <?php
          }elseif($myarray['status'] == DSS_CLAIM_SEC_DISPUTE || $myarray['status'] == DSS_CLAIM_SEC_PATIENT_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='secondary' AND f.claimid='".mysqli_real_escape_string($con,$myarray['insuranceid'])."'";
            $sq = mysqli_query($con, $s);
            if(mysqli_num_rows($sq)>0){
            $file = mysqli_fetch_assoc($sq);
            ?>
     <br />
           <a href="javascript:alert('Dispute Reason:\n<?= $file['description']; ?>');">Reason</a>
     <br />
        <?php }
    ?><a href="manage_claims.php?status=<?= $_GET['status']; ?>&sendid=<?= $myarray['insuranceid']; ?>" onclick="return confirm('This will mark the disputed claim as sent and notify the frontoffice. Proceed?')">Mark Complete</a><?php
           } ?>

        </td>
  <td valign="top" class="<?= ($myarray['num_fo_notes']>0)?' info ':''; ?><?= ($myarray['num_notes']>0)?' notes_col ':''; ?>">
    <a href="claim_notes.php?id=<?= $myarray['insuranceid']; ?>&pid=<?=$myarray['patientid'];?>">View (<?= $myarray['num_notes'];?>)
    <?php
      if($myarray['notes_last']!=''){
        echo date('m/d/y h:i a', strtotime($myarray['notes_last']));
      }
    ?>
    </a>
    <div class="notetip">
      <?php
        $n_sql = "SELECT n.*,
                CASE
                    WHEN create_type='0'
                      THEN CONCAT(a.first_name, ' ', a.last_name)
                  ELSE
                      CONCAT(u.first_name, ' ', u.last_name)
                  END as creator_name
                FROM dental_claim_notes n 
                  left join dental_users u ON n.creator_id = u.userid
                  left join admin a ON n.creator_id = a.adminid
                where n.claim_id='".mysqli_real_escape_string($con, $myarray['insuranceid'])."'
                ORDER BY adddate ASC";
        $n_q = mysqli_query($con, $n_sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
        while($n = mysqli_fetch_assoc($n_q)){
          echo $n['note'] .' - '. $n['creator_name'].'<br />';
        }
        ?>
    </div>
  </td>
<td>
<?php
  if($myarray['status'] == DSS_CLAIM_SENT || $myarray['status'] == DSS_CLAIM_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_INSURANCE || $myarray['status'] == DSS_CLAIM_PENDING || $myarray['status'] == DSS_CLAIM_PAID_PATIENT || $myarray['status'] == DSS_CLAIM_REJECTED || $myarray['status'] == DSS_CLAIM_PATIENT_DISPUTE  || $myarray['status'] == DSS_CLAIM_EFILE_ACCEPTED  ){
  ?><input type="checkbox" class="mailed_chk" value="<?= $myarray['insuranceid']; ?>" <?php
  echo ($myarray['mailed_date'] !='')?'checked="checked"':''; 
}elseif($myarray['status'] == DSS_CLAIM_SEC_SENT || $myarray['status'] == DSS_CLAIM_SEC_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_SEC_INSURANCE || $myarray['status'] == DSS_CLAIM_SEC_PENDING || $myarray['status'] == DSS_CLAIM_PAID_SEC_PATIENT || $myarray['status'] == DSS_CLAIM_SEC_REJECTED || $myarray['status'] == DSS_CLAIM_SEC_PATIENT_DISPUTE  || $myarray['status'] == DSS_CLAIM_SEC_EFILE_ACCEPTED  ){
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
  $api_q = mysqli_query($con, $api_sql);
  $api_r = mysqli_fetch_assoc($api_q);
  if($api_r['use_eligible_api']==1 && $api_r['p_m_eligible_id']!=''){
    include '../insurance_electronic_file.php';
  } */
  ?>
  <script type="text/javascript">
    window.location = "../insurance_fdf.php?insid=<?= $_GET['insid']; ?>&type=<?=$_GET['type'];?>&pid=<?= $_GET['pid'];?>&bo=1";
  </script>
<?php } ?>
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
    $(document).ready(function(){
        $('.bo-status-switch button').click(function(){
            var $this = $(this),
                claimId = $this.data('claim-id'),
                switchToBackOffice = $this.is('.filed-by-bo'),
                message = 'This action will mark this claim as "filed by ' +
                    (switchToBackOffice ? 'Back' : 'Front') +
                    ' Office"\n\nAre you sure you want to continue?';

            if (confirm(message)) {
                $('.bo-status-switch button').prop('disabled');

                $.ajax({
                    url: '/manage/admin/claim-switch.php',
                    data: { claim_id: claimId, filed_by_back_office: switchToBackOffice ? 1 : 0 },
                    type: 'post',
                    complete: function(){
                        $('.bo-status-switch button').removeProp('disabled');
                    },
                    success: function(response){
                        if (response.success) {
                            window.location = window.location;
                        } else if (response.message) {
                            alert('The following error was found while trying to change the flag:\n\n' + message);
                        } else {
                            alert('There was an error changing the flag. Please try again later.');
                        }
                    },
                    error: function(){
                        alert('There was an error changing the flag. Please try again later.');
                    }
                });
            }
        });
    });
</script>
<?php

include "includes/bottom.htm";
