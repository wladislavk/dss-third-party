<?php namespace Ds3\Libraries\Legacy; ?><?php  
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once('includes/main_include.php');
require_once "includes/general.htm";
include_once 'includes/claim_functions.php';
include_once 'includes/invoice_functions.php';
include_once '../includes/claim_functions.php';

if(isset($_GET['upstatus'])){
  $old_sql = "SELECT status FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,$_GET['insid'])."'";
  $old_q = mysqli_query($con,$old_sql);
  $old = mysqli_fetch_assoc($old_q);
  $sql = "UPDATE dental_insurance SET status='".mysqli_real_escape_string($con,$_GET['upstatus'])."' WHERE insuranceid='".mysqli_real_escape_string($con,$_GET['insid'])."'";
  mysqli_query($con,$sql);
  claim_status_history_update($_GET['ins_id'], $old['status'], $_GET['upstatus'], '', $_SESSION['adminuserid']);
}


$fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';
$pid = (isset($_GET['pid']))?$_GET['pid']:'';
define('SORT_BY_DATE', '0');
define('SORT_BY_STATUS', '1');
define('SORT_BY_PATIENT', '2');
define('SORT_BY_FRANCHISEE', '3');
define('SORT_BY_USER', '4');
define('SORT_BY_BC', '5');
define('SORT_BY_INS', '6');
define('SORT_BY_NOTES', '7');
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
  case SORT_BY_INS:
    $sort_by_sql = "ins_name $sort_dir";
    break;
  case SORT_BY_NOTES:
    $sort_by_sql = "notes_last $sort_dir";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "status_order $sort_dir, claim.adddate $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if(isset($_REQUEST["delid"])  && $_SESSION['admin_access']==1) {
	$del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&fid=<?php echo $_REQUEST['fid']?>&pid=<?php echo $_REQUEST['pid']?>";
	</script>
	<?php 
	trigger_error("Die called", E_USER_ERROR);
}

if(isset($_REQUEST['sendid'])){
  if($_REQUEST['sendid']!=''){
  $sendid = $_REQUEST['sendid'];
  $send_sql = "SELECT i.*, f.description AS dispute_description FROM dental_insurance i
		LEFT JOIN dental_insurance_file f ON f.claimid=i.insuranceid
		WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'
		ORDER BY f.id DESC";
  $send_q = mysqli_query($con,$send_sql);
  $send_r = mysqli_fetch_assoc($send_q);
  $status = $send_r['status'];
  if($status == DSS_CLAIM_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con,$new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SENT, '', $_SESSION['adminuserid']);
  }elseif( $status == DSS_CLAIM_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con,$new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_PATIENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SEC_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con,$new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SEC_SENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_SEC_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$sendid)."'";
    mysqli_query($con,$new_sql);
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
  mysqli_query($con,$note_sql);
}
}
if(isset($_REQUEST['cancelid'])){
  $cancelid = $_REQUEST['cancelid'];
  $cancel_sql = "SELECT * FROM dental_insurance WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
  $cancel_q = mysqli_query($con,$cancel_sql);
  $cancel_r = mysqli_fetch_assoc($cancel_q);
  $status = $cancel_r['status'];
  if($status == DSS_CLAIM_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con,$new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SENT, '', $_SESSION['adminuserid']);
  }elseif( $status == DSS_CLAIM_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con,$new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_PAID_PATIENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_SEC_SENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con,$new_sql);
    claim_status_history_update($_GET['ins_id'], $status, DSS_CLAIM_SEC_SENT, '', $_SESSION['adminuserid']);
  }elseif($status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
    $new_sql = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_SEC_PATIENT."' WHERE insuranceid='".mysqli_real_escape_string($con,$cancelid)."'";
    mysqli_query($con,$new_sql);
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
  mysqli_query($con,$note_sql);
}

$rec_disp = isset($_REQUEST['count']) ? intval($_REQUEST['count']) : 20;
$index_val = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 0;

$i_val = $index_val * $rec_disp;

$statusFilter = '';

/**
 * @see DSS-142
 *
 * Filter claims for BO based on who filed the claim, and the dss filing option.
 * This query might appear at some other places, please search this "@see DSS-142" tag.
 */
$backOfficeClaimsConditional = backOfficeClaimsConditional();

$sql = "SELECT
        claim.insuranceid,
        claim.patientid,
        p.firstname,
        p.lastname,
        claim.primary_claim_id,
        claim.adddate,
        claim.status,
        CONCAT(users.first_name, ' ', users.last_name) AS doc_name,
        CONCAT(users2.first_name, ' ', users2.last_name) AS user_name,
        claim.docid,
        claim.primary_fdf,
        claim.secondary_fdf,
        claim.mailed_date,
        claim.sec_mailed_date,
        claim.primary_claim_version,
        claim.secondary_claim_version,
        DATEDIFF(NOW(), claim.adddate) AS days_pending,
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
        END AS status_order
    ";

if (is_super($_SESSION['admin_access'])) {
    $sql .= ",
            c.name AS billing_name,
            IF (COALESCE(claim.primary_claim_id, 0), co2.company, co.company) AS ins_name,
            COALESCE(notes.num_notes, 0) AS num_notes,
            notes_date.max_date AS notes_last,
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
            LEFT JOIN (
                SELECT claim_id, COUNT(claim_id) AS num_notes
                FROM dental_claim_notes
                GROUP BY claim_id
            ) notes ON notes.claim_id = claim.insuranceid
            LEFT JOIN (
                SELECT claim_id, MAX(adddate) AS max_date
                FROM dental_claim_notes
                GROUP BY claim_id
            ) notes_date ON notes_date.claim_id = claim.insuranceid
        ";
} elseif (is_billing($_SESSION['admin_access'])) {
    $sql .= ",
            c.name AS billing_name,
            IF (COALESCE(claim.primary_claim_id, 0), co2.company, co.company) AS ins_name,
            COALESCE(notes.num_notes, 0) AS num_notes,
            notes_date.max_date AS notes_last,
            (
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = claim.insuranceid
                    AND create_type = '1'
            ) AS num_fo_notes
        FROM dental_insurance claim
            JOIN dental_patients p ON p.patientid = claim.patientid
            JOIN dental_users users ON claim.docid = users.userid
                AND users.billing_company_id = '" . $db->escape($_SESSION['admincompanyid']) . "'
            JOIN dental_user_company uc ON uc.userid = claim.docid
            JOIN dental_users users2 ON claim.userid = users2.userid
            LEFT JOIN companies c ON c.id = users.billing_company_id
            LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co
            LEFT JOIN dental_contact co2 ON co2.contactid = p.s_m_ins_co
            LEFT JOIN (
                SELECT claim_id, COUNT(claim_id) AS num_notes
                FROM dental_claim_notes
                GROUP BY claim_id
            ) notes ON notes.claim_id = claim.insuranceid
            LEFT JOIN (
                SELECT claim_id, MAX(adddate) AS max_date
                FROM dental_claim_notes
                GROUP BY claim_id
            ) notes_date ON notes_date.claim_id = claim.insuranceid
        ";
} else {
    $sql .= "FROM dental_insurance claim
            JOIN dental_patients p ON p.patientid = claim.patientid
            JOIN dental_users users ON claim.docid = users.userid
            JOIN dental_user_company uc ON uc.userid = claim.docid
                AND uc.companyid = '" . $db->escape($_SESSION['admincompanyid']) . "'
            JOIN dental_users users2 ON claim.userid = users2.userid
            LEFT JOIN companies c ON c.id = users.billing_company_id
            LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co
            LEFT JOIN (
                SELECT claim_id, COUNT(claim_id) AS num_notes
                FROM dental_claim_notes
                GROUP BY claim_id
            ) notes ON notes.claim_id = claim.insuranceid
            LEFT JOIN (
                SELECT claim_id, MAX(adddate) AS max_date
                FROM dental_claim_notes
                GROUP BY claim_id
            ) notes_date ON notes_date.claim_id = claim.insuranceid
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
$sql .= "WHERE $backOfficeClaimsConditional ";

if (isset($_GET['status']) && ($_GET['status'] != '')) {
    $statusFilter = $_GET['status'];

    switch ($statusFilter) {
        case 'action': // Actionable claims
            $statusList = $db->escapeList(ClaimFormData::statusListByName('actionable'));
            $sql .= " AND claim.status IN ($statusList)
                ";

            break;
        case 'no-action':
            $sql .= " AND claim.status NOT IN (
                    '" . DSS_CLAIM_SENT . "', '" . DSS_CLAIM_SEC_SENT . "',
                    '" . DSS_CLAIM_PAID_INSURANCE . "', '" . DSS_CLAIM_PAID_SEC_INSURANCE . "',
                    '" . DSS_CLAIM_PAID_PATIENT . "', '" . DSS_CLAIM_PAID_SEC_PATIENT . "'
                )
                ";

            break;
        case 'unpaid14':
        case 'unpaid21':
        case 'unpaid30':
        case 'unpaid45':
            $intervalDays = str_replace('unpaid', '', $statusFilter);

            $sql .= " AND claim.status NOT IN (
                    '" . DSS_CLAIM_PENDING . "', '" . DSS_CLAIM_SEC_PENDING . "',
                    '" . DSS_CLAIM_PAID_INSURANCE . "', '" . DSS_CLAIM_PAID_SEC_INSURANCE . "',
                    '" . DSS_CLAIM_PAID_PATIENT . "', '" . DSS_CLAIM_PAID_SEC_PATIENT . "'
                )
                AND claim.adddate < DATE_SUB(NOW(), INTERVAL $intervalDays day)
                ";

            break;
        default:
            $statusList = ClaimFormData::statusListByName($statusFilter);

            if (count($statusList)) {
                $statusList = $db->escapeList($statusList);
                $sql .= " AND claim.status IN ($statusList) ";
            }
    }
}

if (!empty($_GET['fid'])) {
    $sql .= "  AND users.userid = " . $db->escape($_GET['fid']) . " ";
}

if (!empty($_GET['pid'])) {
    $sql .= " AND claim.patientid = " . $db->escape($_GET['pid']) . " ";
}

if (isset($_GET['notes']) && $_GET['notes'] == 1) {
    $sql .= " AND num_notes > 0 ";
}

if (isset($_GET['closedby'])) {
    $sql .= " AND closed_by_office_type = '" . $db->escape($_GET['closedby']) . "'";
}

/**
 * @see DSS-142
 *
 * To count the results, we will prepend the initial "SELECT" with "COUNT(claim.insuranceid) AS total"
 * Count is better done before ordering
 */
$claimCountSql = preg_replace('/^SELECT[\s\r\t\n]/', 'SELECT COUNT(claim.insuranceid) AS total, ', $sql);

$total_rec = $db->getColumn($claimCountSql, 'total', 0);
$no_pages = $total_rec/$rec_disp;

$sql .= " ORDER BY $sort_by_sql LIMIT $i_val, $rec_disp";
$my = $db->query($sql);

$statusDropdown = [
    'action' => 'Action required',
    'no-action' => 'No action required',
    'pending' => 'Pending',
    'sent' => 'Sent',
    'efile-accepted' => 'E-File Accepted',
    'unpaid14' => 'Unpaid 14+ Days',
    'unpaid21' => 'Unpaid 21+ Days',
    'unpaid30' => 'Unpaid 30+ Days',
    'unpaid45' => 'Unpaid 45+ Days',
];

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Claims
</div>
<?php if(isset($_GET['msg'])){
?>
<div align="center" class="red">
	<b><?php  echo $_GET['msg'];?></b>
</div>
<?php } ?>
<div style="width:98%;margin:auto;">
  <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
    Status:
    <select name="status">
      <option value="">Any</option>
      <?php foreach ($statusDropdown as $value=>$label) { ?>
        <option <?= $value == $statusFilter ? 'selected' : '' ?> value="<?= e($value) ?>"><?= e($label) ?></option>
      <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;

    Account:
    <select name="fid">
      <option value="">Any</option>
      <?php

      if (is_super($_SESSION['admin_access'])) {
          $franchisees = get_franchisees();
      } elseif (is_software($_SESSION['admin_access'])) {
          $franchisees = get_software_franchisees();
      } elseif (is_billing($_SESSION['admin_access'])) {
          $franchisees = get_billing_franchisees();
      } elseif (is_hst($_SESSION['admin_access'])) {
          $franchisees = get_hst_franchisees();
      } else {
          $franchisees = [];
      }

      if ($franchisees) foreach ($franchisees as $row) {
          $selected = ($row['userid'] == $fid) ? 'selected' : ''; ?>
        <option value="<?php echo  $row['userid'] ?>" <?php echo  $selected ?>>[<?php echo  $row['userid'] ?>] <?php echo  $row['first_name'] ?> <?php echo  $row['last_name'] ?></option>
      <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;

    <?php if (!empty($_REQUEST['fid'])) { ?>
      Patients:
      <select name="pid">
        <option value="">Any</option>
        <?php $patients = get_patients($_REQUEST['fid']); ?>
        <?php while ($row = mysqli_fetch_array($patients)) { ?>
          <?php $selected = ($row['patientid'] == $_REQUEST['pid']) ? 'selected' : ''; ?>
          <option value="<?php echo  $row['patientid'] ?>" <?php echo  $selected ?>>[<?php echo  $row['patientid'] ?>] <?php echo  $row['lastname'] ?>, <?php echo  $row['firstname'] ?></option>
        <?php } ?>
      </select>
      &nbsp;&nbsp;&nbsp;
    <?php } ?>
    
    <input type="hidden" name="sort_by" value="<?php echo $sort_by?>"/>
    <input type="hidden" name="sort_dir" value="<?php echo $sort_dir?>"/>
    <input type="submit" value="Filter List" class="btn btn-primary">
    <input type="button" value="Reset" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>'" class="btn btn-primary">
  </form>
    <a style="float:right;"  href="payment_reports_list.php?unviewed=1" class="btn btn-primary">Payment Reports</a>
    <?php   if(is_billing($_SESSION['admin_access']) || is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access'])){
?>
    <a style="float:right;margin-right:3px;"  href="report_claim_aging.php" class="btn btn-primary"> Claim Aging </a>
<?php } ?>
<?php if(isset($_GET['closedby']) && $_GET['closedby']==1){ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?status=<?php echo (isset($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (isset($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary"> Show All Claims </a>
<?php }else{ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?closedby=1&status=<?php echo (isset($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (isset($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary" title="Show only claims closed by frontoffice (not backoffice) user."> Frontoffice Closed </a>
<?php } ?>

<?php if(isset($_GET['notes']) && $_GET['notes']==1){ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?status=<?php echo (isset($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (isset($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary"> Show All Claims </a>
<?php }else{ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?notes=1&status=<?php echo (isset($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (isset($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary" title="Show only claims that have notes"> Show Claim w Notes </a>
<?php } ?>

<div style="clear:both;"></div>
</div>

<form name="pagefrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<?php  if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php 
				 paging($no_pages,$index_val,"status=".(isset($_GET['status']) ? $_GET['status'] : '')."&notes=".(!empty($_GET['notes']) ? $_GET['notes'] : '')."&fid=".(!empty($_GET['fid']) ? $_GET['fid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '')."&sort_by=".(isset($_GET['sort_by']) ? $_GET['sort_by'] : '')."&sort_dir=".(!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''));
			?>
		</TD>
	</TR>
	<?php  }?>
	<?php     $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $fid . "&pid=" . $pid
             . "&status=" . ((isset($_REQUEST['status']))?$_REQUEST['status']:'') . "&sort_by=%s&sort_dir=%s";
    ?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_DATE, $sort_dir) ?>" width="15%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_DATE, get_sort_dir($sort_by, SORT_BY_DATE, $sort_dir))?>">Added</a>
		</td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_STATUS, $sort_dir) ?>" width="10%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_STATUS, get_sort_dir($sort_by, SORT_BY_STATUS, $sort_dir))?>">Status</a>
		</td>
        <td>
            E-File
        </td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_PATIENT, $sort_dir) ?>" width="20%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_PATIENT, get_sort_dir($sort_by, SORT_BY_PATIENT, $sort_dir))?>">Patient Name</a>
		</td>
                <td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_INS, $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_INS, get_sort_dir($sort_by, SORT_BY_INS, $sort_dir))?>">Insurance Company</a>
                </td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_FRANCHISEE, $sort_dir) ?>" width="15%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_FRANCHISEE, get_sort_dir($sort_by, SORT_BY_FRANCHISEE, $sort_dir))?>">Account</a>
		</td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_USER, $sort_dir) ?>" width="15%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_USER, get_sort_dir($sort_by, SORT_BY_USER, $sort_dir))?>">User</a>
		</td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_BC, $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_BC, get_sort_dir($sort_by, SORT_BY_BC, $sort_dir))?>">Billing Company</a>
                </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
                <td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_NOTES, $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_NOTES, get_sort_dir($sort_by, SORT_BY_NOTES, $sort_dir))?>">Notes</a>
                </td>
		<td valign="top" class="col_head" width="15%">
			Mailed
		</td>
	</tr>
	<?php  if(mysqli_num_rows($my) == 0)
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
			<tr class="<?php echo  (isset($tr_class))?$tr_class:'';?>">
				<td valign="top">
					<?php echo st($myarray["adddate"]);?>&nbsp;
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
				<td valign="top" class="claim_<?php echo  $myarray["status"]; ?> <?php echo  ($myarray['days_pending']>7)?'old':''; ?> <?php echo  $status_color;?>">
					<?php echo st($dss_claim_status_labels[$myarray["status"]]);?>&nbsp;
				</td>
                <td>
                    <?php

                    $eResponse = retrieveEClaimResponse($myarray['insuranceid']);

                    if ($eResponse['type'] === 'payment') { ?>
                        <a href="payment_report.php?report_id=<?= $eResponse['data']['payment_id'] ?>">
                            Paid - <?= $eResponse['data']['adddate'] ?> (View)
                        </a>
                    <?php } elseif ($eResponse['type'] === 'webhook' || $eResponse['type'] === 'response') { ?>
                        <?= $eResponse['data']['event_type'] ?> - <?= $eResponse['data']['adddate'] ?>
                    <?php } ?>
                </td>
				<td valign="top">
					<a href="view_patient.php?pid=<?php echo $myarray['patientid'];?>"><?php echo st($myarray["lastname"]);?>, <?php echo st($myarray["firstname"]);?> (View Chart)</a>
				</td>
				<td valign="top">
					<?php echo st($myarray["ins_name"]);?>&nbsp;
				</td>
				<td valign="top">
					<a href="view_user.php?ed=<?php echo  $myarray['docid']; ?>"><?php echo st($myarray["doc_name"]);?></a>&nbsp;
				</td>
				<td valign="top">
					<?php echo st($myarray["user_name"]);?>&nbsp;
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["billing_name"]);?>&nbsp;
                                </td>
            <td valign="top">
            <?php
            //$primary_link = ($myarray['primary_fdf']!='')?'../insurance_fdf_view.php?file='.$myarray['primary_fdf']:'../insurance_fdf.php?insid='.$myarray['insuranceid'].'&type=primary&pid='.$myarray['patientid'];
            //$secondary_link = ($myarray['secondary_fdf']!='')?'../insurance_fdf_view.php?file='.$myarray['secondary_fdf']:'../insurance_fdf.php?insid='.$myarray['insuranceid'].'&type=secondary&pid='.$myarray['patientid'];
            $primary_link = "insurance_claim" . (($myarray['primary_claim_version'] != "1") ? '_eligible' : '_v2') . ".php?insid=" . $myarray['insuranceid'] . "&fid_filter=" . $fid . "&pid_filter=" . $pid . "&pid=" . $myarray['patientid'];
            $paid_statuses = array(0 => DSS_CLAIM_PAID_INSURANCE, 1 => DSS_CLAIM_PAID_SEC_INSURANCE);
            $secondary_link = "insurance_claim" . (($myarray['secondary_claim_version'] != "1") ? '_eligible' : '_v2') . ".php?insid=" . $myarray['insuranceid'] . "&fid_filter=" . $fid . "&pid_filter=" . $pid . "&pid=" . $myarray['patientid'] . "&instype=2";
            $reference_id_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='" . mysqli_real_escape_string($con, $myarray['insuranceid']) . "' ORDER BY adddate DESC LIMIT 1";
            $reference_id_query = mysqli_query($con, $reference_id_sql);
            if (mysqli_num_rows($reference_id_query)) {
                $reference_id_result = mysqli_fetch_assoc($reference_id_query);
                $reference_id = $reference_id_result['reference_id'];
                if ($reference_id != "" && !in_array($myarray['status'], $paid_statuses)) {
                    $update_claim_url = "request_claim_update.php?insid=" . $myarray['insuranceid'];
                    ?>
                    <a href="<?php echo $update_claim_url ?>" class="btn btn-primary btn-sm">Check Status</a>

                <?php
                } else if ($reference_id != "" && in_array($myarray['status'], $paid_statuses)) {
                    $payment_status_url = "request_payment_report.php?insid=" . $myarray['insuranceid'];
                    ?>
                    <a href="<?php echo $payment_status_url ?>" class="btn btn-primary btn-sm">Check Payment Status</a>

                <?php
                }
            }
        

        ?>
				    <?php if($myarray["status"] == DSS_CLAIM_PENDING || $myarray["status"] == DSS_CLAIM_REJECTED){ ?>
				    <a href="insurance_claim<?php echo ($myarray['primary_claim_version']!="1")?'_eligible':'_v2'; ?>.php?insid=<?php echo $myarray['insuranceid']?>&fid_filter=<?php echo $fid?>&pid_filter=<?php echo $pid?>&pid=<?php echo $myarray['patientid']?>" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a> 
				<?php }elseif($myarray["status"] == DSS_CLAIM_SEC_PENDING){ ?>
                                    <a href="insurance_claim<?php echo ($myarray['secondary_claim_version']!="1")?'_eligible':''; ?>.php?insid=<?=$myarray['insuranceid']?>&fid_filter=<?=$fid?>&pid_filter=<?=$pid?>&pid=<?=$myarray['patientid']?>" title="Edit Secondary" class="btn btn-primary btn-sm">
                                                Edit Secondary
                                         <span class="glyphicon glyphicon-pencil"></span></a><br />
					<a href="<?php echo "insurance_claim".(($myarray['primary_claim_version']!="1")?'_eligible':'_v2').".php?insid=".$myarray['primary_claim_id']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid'] ?>" title="View Primary" class="btn btn-primary btn-sm">View Primary <span class="glyphicon glyphicon-pencil"></span></a>
                                <?php }elseif($myarray["status"] == DSS_CLAIM_SEC_SENT || $myarray["status"] == DSS_CLAIM_PAID_SEC_INSURANCE){ ?>
                                    <a href="<?php echo  $secondary_link; ?>" title="View Secondary" class="btn btn-primary btn-sm">
                                                View Secondary
                                         <span class="glyphicon glyphicon-pencil"></span></a><br />
                                        <a href="<?php echo "insurance_claim".(($myarray['primary_claim_version']!="1")?'_eligible':'_v2').".php?insid=".$myarray['primary_claim_id']."&fid_filter=".$fid."&pid_filter=".$pid."&pid=".$myarray['patientid'] ?>" title="View Primary" class="btn btn-primary btn-sm">View Primary <span class="glyphicon glyphicon-pencil"></span></a>
                                <?php }else{ ?>
					<a href="<?php echo  $primary_link; ?>" title="View" class="btn btn-primary btn-sm">View <span class="glyphicon glyphicon-pencil"></span></a>
				<?php } ?>
				<?php 
					$eobsql = "SELECT * FROM dental_insurance_file WHERE claimid='".mysqli_real_escape_string($con,$myarray['insuranceid'])."'";
					$eobq = mysqli_query($con,$eobsql);
					while($eobr = mysqli_fetch_assoc($eobq)){
						?><br /><a href="display_file.php?f=<?php echo  $eobr['filename']; ?>" title="View <?php echo  $eobr['claimtype']; ?> EOB" class="btn btn-primary btn-sm">View <?php echo  $eobr['claimtype']; ?> EOB <span class="glyphicon glyphicon-pencil"></span></a>
				<?php } ?>
<?php if($myarray['status'] == DSS_CLAIM_DISPUTE || $myarray['status'] == DSS_CLAIM_PATIENT_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='primary' AND f.claimid='".mysqli_real_escape_string($con,$myarray['insuranceid'])."'";
            $sq = mysqli_query($con,$s);
            if(mysqli_num_rows($sq)>0){
            $file = mysqli_fetch_assoc($sq);
            ?>
	   <br />
           <a href="javascript:alert('Dispute Reason:\n<?php echo  $file['description']; ?>');">Reason</a>
		<br />
	 <?php } ?>
		<a href="manage_claims.php?status=<?php echo  (!empty($_GET['status']) ? $_GET['status'] : ''); ?>&sendid=<?php echo  $myarray['insuranceid']; ?>" onclick="return confirm('This will mark the disputed claim as sent and notify the frontoffice. Proceed?')">Mark Complete</a>
                <a href="manage_claims.php?status=<?php echo  (!empty($_GET['status']) ? $_GET['status'] : ''); ?>&cancelid=<?php echo  $myarray['insuranceid']; ?>" onclick="return confirm('This will CANCEL the disputed claim and notify the frontoffice. Proceed?')">Cancel Dispute</a>
	 <?php           }elseif($myarray['status'] == DSS_CLAIM_SEC_DISPUTE || $myarray['status'] == DSS_CLAIM_SEC_PATIENT_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='secondary' AND f.claimid='".mysqli_real_escape_string($con,$myarray['insuranceid'])."'";
            $sq = mysqli_query($con,$s);
            if(mysqli_num_rows($sq)>0){
            $file = mysqli_fetch_assoc($sq);
            ?>
	   <br />
           <a href="javascript:alert('Dispute Reason:\n<?php echo  $file['description']; ?>');">Reason</a>
	   <br />
        <?php }
		?><a href="manage_claims.php?status=<?php echo  (!empty($_GET['status']) ? $_GET['status'] : ''); ?>&sendid=<?php echo  $myarray['insuranceid']; ?>" onclick="return confirm('This will mark the disputed claim as sent and notify the frontoffice. Proceed?')">Mark Complete</a><?php            } ?>

				</td>
	<td valign="top" class="<?= $myarray['num_fo_notes'] > 0 ? ' info ' : '' ?><?= $myarray['num_notes'] > 0 ? ' notes_col ' : '' ?>">
		<a href="claim_notes.php?id=<?php echo  $myarray['insuranceid']; ?>&pid=<?php echo $myarray['patientid'];?>">View (<?php echo  $myarray['num_notes'];?>)
		<?php 			if($myarray['notes_last']!=''){
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
<?php   if($myarray['status'] == DSS_CLAIM_SENT || $myarray['status'] == DSS_CLAIM_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_INSURANCE || $myarray['status'] == DSS_CLAIM_PENDING || $myarray['status'] == DSS_CLAIM_PAID_PATIENT || $myarray['status'] == DSS_CLAIM_REJECTED || $myarray['status'] == DSS_CLAIM_PATIENT_DISPUTE || $myarray['status'] == DSS_CLAIM_EFILE_ACCEPTED){
	?><input type="checkbox" class="mailed_chk" value="<?php echo  $myarray['insuranceid']; ?>" <?php   echo ($myarray['mailed_date'] !='')?'checked="checked"':''; 
}elseif($myarray['status'] == DSS_CLAIM_SEC_SENT || $myarray['status'] == DSS_CLAIM_SEC_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_SEC_INSURANCE || $myarray['status'] == DSS_CLAIM_SEC_PENDING || $myarray['status'] == DSS_CLAIM_PAID_SEC_PATIENT || $myarray['status'] == DSS_CLAIM_SEC_REJECTED || $myarray['status'] == DSS_CLAIM_SEC_PATIENT_DISPUTE || $myarray['status'] == DSS_CLAIM_EFILE_ACCEPTED){
        ?><input type="checkbox" class="sec_mailed_chk" value="<?php echo  $myarray['insuranceid']; ?>" <?php   echo ($myarray['sec_mailed_date'] !='')?'checked="checked"':''; 
}
?>
/></td>
			</tr>
	<?php
}
  }
  ?>
</table>
</form>

<br /><br />	
<?php if(isset($_GET['sendins'])&&$_GET['sendins']==1){
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
    window.location = "../insurance_fdf_v2.php?insid=<?php echo  $_GET['insid']; ?>&type=<?php echo $_GET['type'];?>&pid=<?php echo  $_GET['pid'];?>&bo=1";
  </script>
  <?php }
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

$(document).ready(function(){
  $(".notes_col").bind("mousemove", function(event) {
    $(this).find("div.notetip").css({
        top: event.pageY + "px",
        left: event.pageX - 150 + "px"
    }).show();
}).bind("mouseout", function() {
    $("div.notetip").hide();
});
});

</script>

<?php  include "includes/bottom.htm";?>
