<?php namespace Ds3\Libraries\Legacy; ?><?php  
include "includes/top.htm";
include_once('../includes/constants.inc');
include_once "includes/general.htm";

$fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';
$pid = (isset($_GET['pid']))?$_GET['pid']:'';
$iid = (isset($_GET['iid']))?$_GET['iid']:'';

if($fid!=''){
  $account_sql = "SELECT * FROM dental_users where userid='".$fid."'";

  $account_r = $db->getRow($account_sql);
  $account_name = $account_r['last_name'].', '.$account_r['first_name'];
}
if($pid!=''){
  $account_sql = "SELECT * FROM dental_patients where patientid='".$pid."'";

  $account_r = $db->getRow($account_sql);
  $patient_name = $account_r['lastname'].', '.$account_r['firstname'];
}
if($iid!=''){
  $account_sql = "SELECT * FROM dental_contact where contactid='".$iid."'";

  $account_r = $db->getRow($account_sql);
  $insurance_name = $account_r['company'];
}


function insert_preauth_row($patient_id) {
  if (empty($patient_id)) { return; }
  
  $sql = "SELECT "
       . "  p.patientid as 'patient_id', i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
       . "  p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
       . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
       . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
       . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
       . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
       . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "
       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
       . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
       . "  d.userid as 'doc_id' "
       . "FROM " 
       . "  dental_patients p "
       . "  JOIN dental_contact r ON p.referred_by = r.contactid  "
       . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
       . "  JOIN dental_users d ON p.docid = d.userid "
       . "  JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
       . "  JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
       . "WHERE " 
       . "  p.patientid = $patient_id";
  
  $my_array = $db->getRow($sql);
  
  $sql = "INSERT INTO dental_insurance_preauth ("
       . "  patient_id, doc_id, ins_co, ins_rank, ins_phone, patient_ins_group_id, "
       . "  patient_ins_id, patient_firstname, patient_lastname, patient_add1, "
       . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
       . "  insured_first_name, insured_last_name, insured_dob, doc_npi, referring_doc_npi, "
       . "  trxn_code_amount, diagnosis_code, doc_medicare_npi, doc_tax_id_or_ssn, "
       . "  front_office_request_date, status "
       . ") VALUES ("
       . "  '" . $my_array['patient_id'] . "', "
       . "  '" . $my_array['doc_id'] . "', "
       . "  '" . $my_array['ins_co'] . "', "
       . "  '" . $my_array['ins_rank'] . "', "
       . "  '" . $my_array['ins_phone'] . "', "
       . "  '" . $my_array['patient_ins_group_id'] . "', "
       . "  '" . $my_array['patient_ins_id'] . "', "
       . "  '" . $my_array['patient_firstname'] . "', "
       . "  '" . $my_array['patient_lastname'] . "', "
       . "  '" . $my_array['patient_add1'] . "', "
       . "  '" . $my_array['patient_add2'] . "', "
       . "  '" . $my_array['patient_city'] . "', "
       . "  '" . $my_array['patient_state'] . "', "
       . "  '" . $my_array['patient_zip'] . "', "
       . "  '" . $my_array['patient_dob'] . "', "
       . "  '" . $my_array['insured_first_name'] . "', "
       . "  '" . $my_array['insured_last_name'] . "', "
       . "  '" . $my_array['insured_dob'] . "', "
       . "  '" . $my_array['doc_npi'] . "', "
       . "  '" . $my_array['referring_doc_npi'] . "', "
       . "  " . $my_array['trxn_code_amount'] . ", "
       . "  '" . $my_array['diagnosis_code'] . "', "
       . "  '" . $my_array['doc_medicare_npi'] . "', "
       . "  '" . $my_array['doc_tax_id_or_ssn'] . "', "
       . "  '" . date('Y-m-d H:i:s') . "', "
       . DSS_PREAUTH_PENDING
       . ")";
  $my = $db->query($sql);
}

if (!empty($_REQUEST['gen_preauth']) && $_REQUEST['gen_preauth'] == 1) {
  insert_preauth_row($_REQUEST['patient_id']);
}

define('SORT_BY_DATE', 0);
define('SORT_BY_STATUS', 1);
define('SORT_BY_PATIENT', 2);
define('SORT_BY_FRANCHISEE', 3);
define('SORT_BY_USER', 4);
define('SORT_BY_INSURANCE', 5);
define('SORT_BY_BC', 6);
define('SORT_BY_EDIT', 7);
$sort_dir = strtolower(!empty($_REQUEST['sort_dir']) ? $_REQUEST['sort_dir'] : '');
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;
$sort_by_sql = '';
switch ($sort_by) {
  case SORT_BY_DATE:
    $sort_by_sql = "preauth.front_office_request_date $sort_dir";
    break;
  case SORT_BY_PATIENT:
    $sort_by_sql = "p.lastname $sort_dir, p.firstname $sort_dir";
    break;
  case SORT_BY_INSURANCE:
    $sort_by_sql = "ins_co $sort_dir";
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
  case SORT_BY_EDIT:
    $sort_by_sql = "updated_at $sort_dir";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "preauth.status $sort_dir, preauth.front_office_request_date $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if(!empty($_REQUEST["delid"]) && is_super($_SESSION['admin_access']))
{
	$del_sql = "delete from dental_insurance_preauth where id='".$_REQUEST["delid"]."'";
	$db->query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php 
	trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

if(is_super($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  preauth.id, preauth.patient_id, i.company as ins_co, p.firstname as patient_firstname, p.lastname as patient_lastname, "
     . "  preauth.doc_id, preauth.updated_at, "
     . "  preauth.front_office_request_date, CONCAT(users.first_name, ' ',users.last_name) as doc_name, preauth.status, "
     . "  DATEDIFF(NOW(), preauth.front_office_request_date) as days_pending, "
     . "  CONCAT(users2.first_name, ' ',users2.last_name) as user_name, "
     . "  c.name as billing_name, "
     . "  (SELECT COUNT(*) FROM dental_insurance_preauth dip where dip.patient_id=p.patientid) as total_vob "
     . "FROM "
     . "  dental_insurance_preauth preauth "
     . "  JOIN dental_patients p ON preauth.patient_id = p.patientid "
     . "  LEFT JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
     . "  JOIN dental_users users ON preauth.doc_id = users.userid "
     . "  JOIN dental_users users2 ON preauth.userid = users2.userid "
     . "  LEFT JOIN companies c ON c.id = users.billing_company_id ";
}elseif(is_billing($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  preauth.id, preauth.patient_id, i.company as ins_co, p.firstname as patient_firstname, p.lastname as patient_lastname, "
     . "  preauth.doc_id, preauth.updated_at, "
     . "  preauth.front_office_request_date, CONCAT(users.first_name, ' ',users.last_name) as doc_name, preauth.status, "
     . "  DATEDIFF(NOW(), preauth.front_office_request_date) as days_pending, "
     . "  CONCAT(users2.first_name, ' ',users2.last_name) as user_name, "
     . "  c.name as billing_name "
     . "FROM "
     . "  dental_insurance_preauth preauth "
     . "  JOIN dental_patients p ON preauth.patient_id = p.patientid "
     . "  JOIN dental_user_company uc ON uc.userid = p.docid "
     . "  LEFT JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
     . "  JOIN dental_users users ON preauth.doc_id = users.userid AND users.billing_company_id = '".$_SESSION['admincompanyid']."'"
     . "  LEFT JOIN companies c on users.billing_company_id = c.id "
     . "  JOIN dental_users users2 ON preauth.userid = users2.userid ";

}else{
$sql = "SELECT "
     . "  preauth.id, preauth.patient_id, i.company as ins_co, p.firstname as patient_firstname, p.lastname as patient_lastname, "
     . "  preauth.doc_id, preauth.updated_at, "
     . "  preauth.front_office_request_date, CONCAT(users.first_name, ' ',users.last_name) as doc_name, preauth.status, "
     . "  DATEDIFF(NOW(), preauth.front_office_request_date) as days_pending, "
     . "  CONCAT(users2.first_name, ' ',users2.last_name) as user_name "
     . "FROM "
     . "  dental_insurance_preauth preauth "
     . "  JOIN dental_patients p ON preauth.patient_id = p.patientid "
     . "  JOIN dental_user_company uc ON uc.userid = p.docid AND uc.companyid = '".$_SESSION['admincompanyid']."'"
     . "  LEFT JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
     . "  JOIN dental_users users ON preauth.doc_id = users.userid "
     . "  JOIN dental_users users2 ON preauth.userid = users2.userid ";

}
// filter based on select lists above table
if ((isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) || !empty($fid)) {
    $sql .= "WHERE ";
    
    if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
	if($_REQUEST['status']==DSS_PREAUTH_PENDING){
	  $sql .= " (preauth.status = " . $_REQUEST['status'] . " OR preauth.status = ".DSS_PREAUTH_PREAUTH_PENDING.") ";
	}elseif($_REQUEST['status']==DSS_PREAUTH_COMPLETE){
          $sql .= " (preauth.status = " . $_REQUEST['status'] . " OR preauth.status = ".DSS_PREAUTH_REJECTED.") ";
        }else{
          $sql .= "  preauth.status = " . $_REQUEST['status'] . " ";
	}
    }
    
    if (!empty($fid)) {
        if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
            $sql .= "  AND ";
        }
        $sql .= "  users.userid = " . $fid . " ";
    }
    
    if (!empty($pid)) {
        $sql .= "AND preauth.patient_id = " . $pid . " ";
    }

    if (!empty($iid)) {
        $sql .= "AND p.p_m_ins_co = " . $iid . " ";
    }

}

$sql .= "ORDER BY " . $sort_by_sql;

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);

$pending_selected = ($status == DSS_PREAUTH_PENDING) ? 'selected' : '';
$complete_selected = ($status == DSS_PREAUTH_COMPLETE) ? 'selected' : '';

?>
<link rel="stylesheet" type="text/css" media="screen" href="popup/popup.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/manage/css/search-hints.css" />
<script type="text/javascript" src="popup/popup.js"></script>
<script type="text/javascript" src="/manage/admin/js/manage_vobs.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    if ($('#patient_hints').length) {
        setup_autocomplete(
            'patient_name', 'patient_hints', 'pid', '',
            'list_patients_search.php?fid=<?php echo $fid; ?>', 'patient',
            getParameterByName('pid')
        );

        setup_autocomplete(
            'insurance_name', 'insurance_hints', 'iid', '',
            'list_insurance_search.php?fid=<?= $fid ?>', 'insurance',
            getParameterByName('pid')
        );
    }
});
</script>

<div class="page-header">
	Manage Verification of Benefits
</div>
<div align="center" class="red">
	<b><?php  echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<div style="width:98%;margin:auto;">
    <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
        Status:
        <select name="status">
            <option value="">Any</option>
            <option value="<?= DSS_PREAUTH_PENDING ?>" <?= $pending_selected ?>>
                <?= $dss_preauth_status_labels[DSS_PREAUTH_PENDING] ?>
            </option>
            <option value="<?= DSS_PREAUTH_COMPLETE ?>" <?= $complete_selected ?>>
                <?= $dss_preauth_status_labels[DSS_PREAUTH_COMPLETE]?>
            </option>
        </select>
        &nbsp;&nbsp;&nbsp;
        Account:
        <input type="text" id="account_name" onclick="updateval(this)" autocomplete="off" name="account_name"
             value="<?= ($fid != '') ? $account_name : 'Type contact name' ?>" />
        <div id="account_hints" class="search_hints" style="display:none;">
            <ul id="account_list" class="search_list">
                <li class="template" style="display:none">Doe, John S</li>
            </ul>
        </div>
        <?php if (!empty($fid)) { ?>
            Patients:
            <input type="text" id="patient_name" onclick="updateval(this)" autocomplete="off" name="patient_name"
                 value="<?= ($pid != '') ? $patient_name : 'Type patient name' ?>" />
            <div id="patient_hints" class="search_hints" style="display:none;">
                <ul id="patient_list" class="search_list">
                    <li class="template" style="display:none">Doe, John S</li>
                </ul>
            </div>
            <input type="hidden" name="pid" id="pid" value="<?= $pid ?>" />
            &nbsp;&nbsp;&nbsp;
            Insurance:
            <input type="text" id="insurance_name" onclick="updateval(this)" autocomplete="off" name="insurance_name"
                 value="<?= ($iid != '') ? $insurance_name : 'Type contact name' ?>" />
            <div id="insurance_hints" class="search_hints" style="display:none;">
                <ul id="insurance_list" class="search_list">
                    <li class="template" style="display:none">Doe, John S</li>
                </ul>
            </div>
            <input type="hidden" name="iid" id="iid" value="<?= $iid ?>" />
        <?php } ?>
        <input type="hidden" name="fid" id="fid" value="<?= $fid ?>" />
        <input type="hidden" name="sort_by" value="<?= $sort_by ?>" />
        <input type="hidden" name="sort_dir" value="<?= $sort_dir ?> "/>
        <input type="submit" value="Filter List" class="btn btn-primary">
        <input type="button" value="Reset" onclick="window.location='<?= $_SERVER['PHP_SELF'] ?>'"
             class="btn btn-primary">
    </form>
</div>

<form name="pagefrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<?php  if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php 
				 paging($no_pages,$index_val,"fid=".$_GET['fid']."&pid=". $_GET['pid']."&status=". $_GET['status']."&sort_by=".$_GET['sort_by']."&sort_dir=".$_GET['sort_dir']);
			?>
		</TD>
	</TR>
	<?php  }?>
	<?php     $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $fid . "&pid=" . $pid
             . "&status=" . (!empty($_REQUEST['status']) ? $_REQUEST['status'] : '') . "&sort_by=%s&sort_dir=%s";
    ?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_DATE, $sort_dir) ?>" width="15%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_DATE, get_sort_dir($sort_by, SORT_BY_DATE, $sort_dir))?>">Requested</a>
		</td>
                <td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_EDIT, $sort_dir) ?>" width="15%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_EDIT, get_sort_dir($sort_by, SORT_BY_EDIT, $sort_dir))?>">Last Edit</a>
                </td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_STATUS, $sort_dir) ?>" width="10%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_STATUS, get_sort_dir($sort_by, SORT_BY_STATUS, $sort_dir))?>">Status</a>
		</td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_PATIENT, $sort_dir) ?>" width="20%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_PATIENT, get_sort_dir($sort_by, SORT_BY_PATIENT, $sort_dir))?>">Patient Name</a>
		</td>
                <td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_INSURANCE, $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_INSURANCE, get_sort_dir($sort_by, SORT_BY_INSURANCE, $sort_dir))?>">Insurance</a>
                </td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_FRANCHISEE, $sort_dir) ?>" width="20%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_FRANCHISEE, get_sort_dir($sort_by, SORT_BY_FRANCHISEE, $sort_dir))?>">Account</a>
		</td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_USER, $sort_dir) ?>" width="20%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_USER, get_sort_dir($sort_by, SORT_BY_USER, $sort_dir))?>">User</a>
		</td>
                <td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_BC, $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_BC, get_sort_dir($sort_by, SORT_BY_BC, $sort_dir))?>">Billing Company</a>
                </td>

		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<?php  if(count($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="6" align="center">
				No Records
			</td>
		</tr>
	<?php  
	}
	else
	{
		foreach ($my as $myarray)
		{
		?>
			<tr class="<?php echo  (isset($tr_class))?$tr_class:'';?>">
				<td valign="top">
					<?php echo st($myarray["front_office_request_date"]);?>&nbsp;
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["updated_at"]);?>&nbsp;
                                </td>
				<?php $status_color = ($myarray["status"] == DSS_PREAUTH_PENDING || $myarray["status"] == DSS_PREAUTH_PREAUTH_PENDING) ? "warning" : "success"; ?>
				<?php $status_color = (($myarray["status"] == DSS_PREAUTH_PENDING || $myarray["status"] == DSS_PREAUTH_PREAUTH_PENDING) && $myarray['days_pending'] > 7) ? "danger" : $status_color; ?>
				<td valign="top" class="<?php echo  $status_color; ?>">
					<?php echo st($dss_preauth_status_labels[$myarray["status"]]);?>&nbsp;
				</td>
				<td valign="top">
					<a href="view_patient.php?pid=<?php echo  $myarray['patient_id'];?>"><?php echo st($myarray["patient_lastname"]);?>, <?php echo st($myarray["patient_firstname"]);?> (View Chart)</a>
				</td>
				<td valign="top">
					<?php echo st($myarray["ins_co"]);?>&nbsp;
				</td>
				<td valign="top">
					<a href="view_user.php?ed=<?php echo  $myarray['doc_id']; ?>"><?php echo st($myarray["doc_name"]);?></a>&nbsp;
				</td>
				<td valign="top">
					<?php echo st($myarray["user_name"]);?>&nbsp;
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["billing_name"]);?>&nbsp;
                                </td>
				<td valign="top">
				    <?php $link_label = ($myarray["status"] == DSS_PREAUTH_PENDING) ? 'Edit' : 'View'; ?>
					<a href="process_vob_page.php?ed=<?php echo $myarray["id"];?>" title="Edit" class="btn btn-primary btn-sm">
						<?php echo  $link_label ?>
					 <span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="manage_vobs.php?fid=<?php echo $myarray['doc_id']; ?>&pid=<?php echo $myarray["patient_id"];?>" title="Edit" class="btn btn-primary btn-sm">
						History <?php echo  ($myarray['total_vob']>1)?"(".$myarray['total_vob'].")":''; ?>
                                         </a>

				</td>
			</tr>
	<?php  	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;height:500px;">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php  include "includes/bottom.htm";?>
