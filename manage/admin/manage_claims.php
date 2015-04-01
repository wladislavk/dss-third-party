<?php  
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
	die();
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

$rec_disp = 20;

if(isset($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

if(is_super($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, p.firstname, p.lastname, claim.primary_claim_id, "
     . "  claim.adddate, claim.status, CONCAT(users.first_name,' ',users.last_name) as doc_name, CONCAT(users2.first_name,' ', users2.last_name) as user_name, "
     . "  claim.docid, "
     . "  claim.primary_fdf, claim.secondary_fdf, "
     . "  claim.mailed_date, claim.sec_mailed_date, "
     . "  claim.primary_claim_version, claim.secondary_claim_version, "
     . "  DATEDIFF(NOW(), claim.adddate) as days_pending, "
     . "  c.name as billing_name, "
     . "  
	CASE WHEN
	  claim.status IN (".DSS_CLAIM_SEC_PENDING.",".DSS_CLAIM_SEC_DISPUTE.",".DSS_CLAIM_SEC_SENT.",".DSS_CLAIM_SEC_REJECTED.",".DSS_CLAIM_PAID_SEC_INSURANCE.") THEN co2.company
		ELSE co.company 
	END as ins_name, "
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
       END AS status_order, "
     . " COALESCE(notes.num_notes, 0) num_notes, "
     . " notes_date.max_date notes_last, "
     . " (SELECT count(*) FROM dental_claim_notes where claim_id=claim.insuranceid AND create_type='1') num_fo_notes "
     . "FROM "
     . "  dental_insurance claim "
     . "  JOIN dental_patients p ON p.patientid = claim.patientid "
     . "  JOIN dental_users users ON claim.docid = users.userid "
     . "  JOIN dental_users users2 ON claim.userid = users2.userid "
     . "  LEFT JOIN companies c ON c.id = users.billing_company_id "
     . "  LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co "
     . "  LEFT JOIN dental_contact co2 ON co2.contactid = p.s_m_ins_co "
     . "  LEFT JOIN (SELECT claim_id, count(*) num_notes FROM dental_claim_notes group by claim_id) notes ON notes.claim_id=claim.insuranceid "
     . "  LEFT JOIN (SELECT claim_id, MAX(adddate) max_date FROM dental_claim_notes group by claim_id) notes_date ON notes_date.claim_id=claim.insuranceid ";
}elseif(is_billing($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, p.firstname, p.lastname, "
     . "  claim.adddate, claim.status, CONCAT(users.first_name,' ',users.last_name) as doc_name, CONCAT(users2.first_name,' ', users2.last_name) as user_name, "
     . "  claim.docid, "
     . "  claim.primary_fdf, claim.secondary_fdf, "
     . "  claim.mailed_date, claim.sec_mailed_date, "
     . "  claim.primary_claim_version, claim.secondary_claim_version, "
     . "  DATEDIFF(NOW(), claim.adddate) as days_pending, "
     . "  c.name as billing_name, "
     . "  
        CASE WHEN
          claim.status IN (".DSS_CLAIM_SEC_PENDING.",".DSS_CLAIM_SEC_DISPUTE.",".DSS_CLAIM_SEC_SENT.",".DSS_CLAIM_SEC_REJECTED.",".DSS_CLAIM_PAID_SEC_INSURANCE.") THEN co2.company
                ELSE co.company 
        END as ins_name, "

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
       END AS status_order, "
     . " COALESCE(notes.num_notes, 0) num_notes, "
     . " notes_date.max_date notes_last, "
     . " (SELECT count(*) FROM dental_claim_notes where claim_id=claim.insuranceid AND create_type='1') num_fo_notes "
     . "FROM "
     . "  dental_insurance claim "
     . "  JOIN dental_patients p ON p.patientid = claim.patientid "
     . "  JOIN dental_users users ON claim.docid = users.userid AND users.billing_company_id='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'"
     . "  JOIN dental_user_company uc ON uc.userid = claim.docid " 
     . "  JOIN dental_users users2 ON claim.userid = users2.userid "
     . "  LEFT JOIN companies c ON c.id = users.billing_company_id "
     . "  LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co "
     . "  LEFT JOIN dental_contact co2 ON co2.contactid = p.s_m_ins_co "
     . "  LEFT JOIN (SELECT claim_id, count(*) num_notes FROM dental_claim_notes group by claim_id) notes ON notes.claim_id=claim.insuranceid "
     . "  LEFT JOIN (SELECT claim_id, MAX(adddate) max_date FROM dental_claim_notes group by claim_id) notes_date ON notes_date.claim_id=claim.insuranceid ";

}
else{
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, p.firstname, p.lastname, claim.primary_claim_id, "
     . "  claim.adddate, claim.status, CONCAT(users.first_name,' ',users.last_name) as doc_name, CONCAT(users2.first_name,' ', users2.last_name) as user_name, "
     . "  claim.docid, "
     . "  claim.primary_fdf, claim.secondary_fdf, "
     . "  claim.mailed_date, claim.mailed_date, "
     . "  claim.primary_claim_version, claim.secondary_claim_version, "
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
     . "  LEFT JOIN companies c ON c.id = users.billing_company_id "
     . "  LEFT JOIN dental_contact co ON co.contactid = p.p_m_ins_co "
     . "  LEFT JOIN (SELECT claim_id, count(*) num_notes FROM dental_claim_notes group by claim_id) notes ON notes.claim_id=claim.insuranceid "
     . "  LEFT JOIN (SELECT claim_id, MAX(adddate) max_date FROM dental_claim_notes group by claim_id) notes_date ON notes_date.claim_id=claim.insuranceid ";
}
// . "  LEFT JOIN dental_insurance_file dif ON dif.claimid = claim.insuranceid ";

    $sql .= "WHERE 1=1 "; 
// filter based on select lists above table
if ((isset($_GET['status']) && ($_GET['status'] != '')) || !empty($_GET['fid'])) {
    if (isset($_GET['status']) && ($_GET['status'] != '')) {
	if($_GET['status'] == '0' ){
		//echo DSS_CLAIM_PENDING;
	   	$sql .= " AND (
			(claim.mailed_date IS NULL AND (claim.status=".DSS_CLAIM_SENT." OR claim.status=".DSS_CLAIM_PAID_INSURANCE." OR claim.status=".DSS_CLAIM_PAID_PATIENT." ))
			OR (claim.sec_mailed_date IS NULL AND (claim.status=".DSS_CLAIM_SEC_SENT." OR claim.status=".DSS_CLAIM_PAID_SEC_INSURANCE." OR claim.status=".DSS_CLAIM_PAID_SEC_PATIENT." ))
			 OR claim.status IN (".DSS_CLAIM_PENDING.",".DSS_CLAIM_SEC_PENDING.",".DSS_CLAIM_REJECTED.",".DSS_CLAIM_DISPUTE.",".DSS_CLAIM_SEC_DISPUTE.",".DSS_CLAIM_PATIENT_DISPUTE.",".DSS_CLAIM_SEC_PATIENT_DISPUTE.")) ";
	}elseif($_GET['status'] == '1'){
		$sql .= " AND ((claim.mailed_date IS NOT NULL AND claim.status IN (".DSS_CLAIM_SENT.", ".DSS_CLAIM_PAID_INSURANCE.", ".DSS_CLAIM_PAID_PATIENT.")) OR
				(claim.mailed_date IS NOT NULL AND claim.status IN (".DSS_CLAIM_SEC_SENT.", ".DSS_CLAIM_PAID_SEC_INSURANCE.", ".DSS_CLAIM_PAID_SEC_PATIENT.")))";
        }elseif($_GET['status'] == 'unpaid14'){
                $sql .= " AND claim.status NOT IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_SEC_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.",".DSS_CLAIM_PAID_SEC_PATIENT.",".DSS_CLAIM_EFILE_ACCEPTED.",".DSS_CLAIM_SEC_EFILE_ACCEPTED.") AND claim.adddate < DATE_SUB(NOW(), INTERVAL 14 day)";
        }elseif($_GET['status'] == 'unpaid21'){
                $sql .= " AND claim.status NOT IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_SEC_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.",".DSS_CLAIM_PAID_SEC_PATIENT.",".DSS_CLAIM_EFILE_ACCEPTED.",".DSS_CLAIM_SEC_EFILE_ACCEPTED.") AND claim.adddate < DATE_SUB(NOW(), INTERVAL 21 day)";
        }elseif($_GET['status'] == 'unpaid30'){
                $sql .= " AND claim.status NOT IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_SEC_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.",".DSS_CLAIM_PAID_SEC_PATIENT.",".DSS_CLAIM_EFILE_ACCEPTED.",".DSS_CLAIM_SEC_EFILE_ACCEPTED.") AND claim.adddate < DATE_SUB(NOW(), INTERVAL 30 day)";
        }elseif($_GET['status'] == 'unpaid45'){
                $sql .= " AND claim.status NOT IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_SEC_PENDING.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_SEC_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.",".DSS_CLAIM_PAID_SEC_PATIENT.",".DSS_CLAIM_EFILE_ACCEPTED.",".DSS_CLAIM_SEC_EFILE_ACCEPTED.") AND claim.adddate < DATE_SUB(NOW(), INTERVAL 45 day)";
        }else{
        	$sql .= " AND claim.status = " . $_GET['status'] . " ";
	}
    }
    
    if (!empty($_GET['fid'])) {
        $sql .= "  AND users.userid = " . $_GET['fid'] . " ";
    }
    

}
    if (!empty($_GET['pid'])) {
        $sql .= " AND claim.patientid = " . $_GET['pid'] . " ";
    }
    $sql .= "  
AND
(
 CASE WHEN claim.status IN (".DSS_CLAIM_PENDING.", ".DSS_CLAIM_DISPUTE.", ".DSS_CLAIM_REJECTED.", ".DSS_CLAIM_PATIENT_DISPUTE.", ".DSS_CLAIM_SENT.", ".DSS_CLAIM_PAID_INSURANCE.",".DSS_CLAIM_PAID_PATIENT.",".DSS_CLAIM_EFILE_ACCEPTED.")
    THEN p.p_m_dss_file
    ELSE p.s_m_dss_file
   END = '1' 

	OR c.exclusive=1)
	";

        if(isset($_GET['notes']) && $_GET['notes']==1){
          $sql .= " AND num_notes > 0 ";
        }
        if(isset($_GET['closedby']) ){
          $sql .= " AND closed_by_office_type = ".$_GET['closedby'];
        }

$sql .= " 
ORDER BY " . $sort_by_sql;
$my = mysqli_query($con,$sql) or die(mysql_error());
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con,$sql) or die(mysql_error());
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
      <?php $pending_selected = ($status == DSS_CLAIM_PENDING) ? 'selected' : ''; ?>
      <?php $sent_selected = ($status == DSS_CLAIM_SENT) ? 'selected' : ''; ?>
      <?php $unpaid14_selected = ($status == 'unpaid14') ? 'selected' : ''; ?>
      <?php $unpaid21_selected = ($status == 'unpaid21') ? 'selected' : ''; ?>
      <?php $unpaid30_selected = ($status == 'unpaid30') ? 'selected' : ''; ?>
      <?php $unpaid45_selected = ($status == 'unpaid45') ? 'selected' : ''; ?>
      <?php $rejected_selected = ($status == DSS_CLAIM_REJECTED) ? 'selected' : ''; ?>
      <?php $paid_patient_selected = ($status == DSS_CLAIM_PAID_PATIENT) ? 'selected' : ''; ?>
      <option value="">Any</option>
      <option value="<?php echo DSS_CLAIM_PENDING?>" <?php echo $pending_selected?>><?php echo $dss_claim_status_labels[DSS_CLAIM_PENDING]?></option>
      <option value="<?php echo DSS_CLAIM_SENT?>" <?php echo $sent_selected?>><?php echo $dss_claim_status_labels[DSS_CLAIM_SENT]?></option>
      <option value="unpaid14" <?php echo  $unpaid14_selected; ?>>Unpaid 14+ Days</option>
      <option value="unpaid21" <?php echo  $unpaid21_selected; ?>>Unpaid 21+ Days</option>
      <option value="unpaid30" <?php echo $unpaid30_selected; ?>>Unpaid 30+ Days</option>
      <option value="unpaid45" <?php echo  $unpaid45_selected; ?>>Unpaid 45+ Days</option>
      <option value="<?php echo DSS_CLAIM_REJECTED?>" <?php echo $rejected_selected;?>><?php echo $dss_claim_status_labels[DSS_CLAIM_REJECTED];?></option>

    </select>
    &nbsp;&nbsp;&nbsp;

    Account:
    <select name="fid">
      <option value="">Any</option>
      <?php 
        $franchisees = (is_billing($_SESSION['admin_access']))?get_billing_franchisees():get_franchisees();
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
<?php   if(is_billing($_SESSION['admin_access']) || is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access'])){ 
?>
<a style="float:right;"  href="report_claim_aging.php" class="btn btn-primary"> Claim Aging </a>
<?php } ?>

<?php if(isset($_GET['closedby']) && $_GET['closedby']==1){ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?status=<?php echo (!empty($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (!empty($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary"> Show All Claims </a>
<?php }else{ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?closedby=1&status=<?php echo (!empty($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (!empty($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary" title="Show only claims closed by frontoffice (not backoffice) user."> Frontoffice Closed </a>
<?php } ?>

<?php if(isset($_GET['notes']) && $_GET['notes']==1){ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?status=<?php echo (!empty($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (!empty($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary"> Show All Claims </a>
<?php }else{ ?>
<a style="float:right;margin-right:3px;"  href="manage_claims.php?notes=1&status=<?php echo (!empty($_GET['status']) ? $_GET['status'] : '');?>&fid=<?php echo (!empty($_GET['fid']) ? $_GET['fid'] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sort_by=<?php echo  (!empty($_GET['sort_by']) ? $_GET['sort_by'] : ''); ?>&sort_dir=<?php echo (!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''); ?>" class="btn btn-primary" title="Show only claims that have notes"> Show Claim w Notes </a>
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
				 paging($no_pages,$index_val,"status=".(!empty($_GET['status']) ? $_GET['status'] : '')."&notes=".(!empty($_GET['notes']) ? $_GET['notes'] : '')."&fid=".(!empty($_GET['fid']) ? $_GET['fid'] : '')."&pid=".(!empty($_GET['pid']) ? $_GET['pid'] : '')."&sort_by=".(!empty($_GET['sort_by']) ? $_GET['sort_by'] : '')."&sort_dir=".(!empty($_GET['sort_dir']) ? $_GET['sort_dir'] : ''));
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
                    $payment_report_sql = "SELECT * FROM dental_payment_reports WHERE claimid='" . mysql_real_escape_string($myarray['insuranceid']) . "' ORDER BY adddate DESC LIMIT 1";
                    $payment_report_query = mysql_query($payment_report_sql);
                    $payment_report_result = mysql_fetch_assoc($payment_report_query);
                    if ($payment_report_result) {
                        echo '<a href="view_payment_reports.php?insid=' . $payment_report_result['claimid'] . '"> Paid - ' . $payment_report_result['adddate'] . " (View)</a>";
                    } else {
                        $reference_id_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='" . mysql_real_escape_string($myarray['insuranceid']) . "' ORDER BY adddate DESC LIMIT 1";
                        $reference_id_query = mysql_query($reference_id_sql);
                        $reference_id_result = mysql_fetch_assoc($reference_id_query);
                        if ($reference_id_result) {
                            $reference_id = $reference_id_result['reference_id'];
                            if ($reference_id != "") {
                                $eligible_response_sql = "SELECT event_type, adddate FROM dental_eligible_response WHERE reference_id='" . $reference_id . "' ORDER BY adddate DESC";
                                $eligible_response_query = mysql_query($eligible_response_sql);
                                $eligible_response_result = mysql_fetch_assoc($eligible_response_query);
                                echo $eligible_response_result['event_type'] . " - " . $eligible_response_result['adddate'];
                            }
                        }
                    }
                    ?>
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
            $reference_id_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='" . mysql_real_escape_string($myarray['insuranceid']) . "' ORDER BY adddate DESC LIMIT 1";
            $reference_id_query = mysql_query($reference_id_sql);
            if (mysql_num_rows($reference_id_query)) {
                $reference_id_result = mysql_fetch_assoc($reference_id_query);
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
	<td valign="top" <?php echo  ($myarray['num_fo_notes']>0)?' info ':''; ?><?php echo ($myarray['num_notes']>0)?' notes_col ':''; ?>">
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
        				where n.claim_id='".mysql_real_escape_string($myarray['insuranceid'])."'
        				ORDER BY adddate ASC";
 				$n_q = mysql_query($n_sql) or die(mysql_error());
				while($n = mysql_fetch_assoc($n_q)){
					echo $n['note'] .' - '. $n['creator_name'].'<br />';
				}
				?>
		</div>
	</td>
<td>
<?php   if($myarray['status'] == DSS_CLAIM_SENT || $myarray['status'] == DSS_CLAIM_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_INSURANCE || $myarray['status'] == DSS_CLAIM_PENDING || $myarray['status'] == DSS_CLAIM_PAID_PATIENT || $myarray['status'] == DSS_CLAIM_REJECTED || $myarray['status'] == DSS_CLAIM_PATIENT_DISPUTE ){
	?><input type="checkbox" class="mailed_chk" value="<?php echo  $myarray['insuranceid']; ?>" <?php   echo ($myarray['mailed_date'] !='')?'checked="checked"':''; 
}elseif($myarray['status'] == DSS_CLAIM_SEC_SENT || $myarray['status'] == DSS_CLAIM_SEC_DISPUTE || $myarray['status'] == DSS_CLAIM_PAID_SEC_INSURANCE || $myarray['status'] == DSS_CLAIM_SEC_PENDING || $myarray['status'] == DSS_CLAIM_PAID_SEC_PATIENT || $myarray['status'] == DSS_CLAIM_SEC_REJECTED || $myarray['status'] == DSS_CLAIM_SEC_PATIENT_DISPUTE ){
        ?><input type="checkbox" class="sec_mailed_chk" value="<?php echo  $myarray['insuranceid']; ?>" <?php   echo ($myarray['sec_mailed_date'] !='')?'checked="checked"':''; 
}
?>
/></td>
			</tr>
	<?php  	}
	}?>
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
