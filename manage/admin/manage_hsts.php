<?php namespace Ds3\Libraries\Legacy; ?><?php  
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

$fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';
$pid = (isset($_GET['pid']))?$_GET['pid']:'';


define('SORT_BY_DATE', 0);
define('SORT_BY_STATUS', 1);
define('SORT_BY_PATIENT', 2);
define('SORT_BY_FRANCHISEE', 3);
define('SORT_BY_USER', 4);
define('SORT_BY_INSURANCE', 5);
define('SORT_BY_COMPANY', 6);
define('SORT_BY_AUTHORIZED', 7);
$sort_dir = strtolower(!empty($_REQUEST['sort_dir']) ? $_REQUEST['sort_dir'] : '');
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;
$sort_by_sql = '';
switch ($sort_by) {
  case SORT_BY_DATE:
    $sort_by_sql = "hst.adddate $sort_dir";
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
  case SORT_BY_AUTHORIZED:
    $sort_by_sql = "authorized_name $sort_dir";
    break;
  case SORT_BY_COMPANY:
    $sort_by_sql = "hst_company_name $sort_dir";
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "hst.status $sort_dir, hst.adddate $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if(!empty($_REQUEST["delid"]) && is_super($_SESSION['admin_access']))
{
	$del_sql = "delete from dental_insurance_preauth where id='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
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
     . "  hst.id, i.company as ins_co, hst.patient_firstname, hst.patient_lastname, "
     . "  hst.patient_id, "
     . "  hst.adddate, CONCAT(users.first_name, ' ',users.last_name) as doc_name, hst.status, "
     . "  hst.doc_id, "
     . "  DATEDIFF(NOW(), hst.adddate) as days_pending, "
     . "  CONCAT(users2.first_name, ' ',users2.last_name) as user_name, "
     . "  CONCAT(users3.first_name, ' ',users3.last_name) as authorized_name, "
     . "  hst_company.name AS hst_company_name "
     . "FROM "
     . "  dental_hst hst "
     . "  LEFT JOIN dental_patients p ON hst.patient_id = p.patientid "
     . "  LEFT JOIN dental_contact i ON hst.ins_co_id = i.contactid "
     . "  JOIN dental_users users ON hst.doc_id = users.userid "
     . "  JOIN dental_users users2 ON hst.user_id = users2.userid "
     . "  LEFT JOIN dental_users users3 ON hst.authorized_id = users3.userid "
     . "  LEFT JOIN companies hst_company ON hst.company_id=hst_company.id ";
}elseif(is_hst($_SESSION['admin_access'])){
$sql = "SELECT "
     . "  hst.id, i.company as ins_co, hst.patient_firstname, hst.patient_lastname, "
     . "  hst.patient_id, "
     . "  hst.adddate, CONCAT(users.first_name, ' ',users.last_name) as doc_name, hst.status, "
     . "  hst.doc_id, "
     . "  DATEDIFF(NOW(), hst.adddate) as days_pending, "
     . "  CONCAT(users2.first_name, ' ',users2.last_name) as user_name, "
     . "  CONCAT(users3.first_name, ' ',users3.last_name) as authorized_name, "
     . "  hst_company.name AS hst_company_name "
     . "FROM "
     . "  dental_hst hst "
     . "  LEFT JOIN dental_patients p ON hst.patient_id = p.patientid "
     . "  LEFT JOIN dental_user_company uc ON uc.userid = p.docid "
     . "  LEFT JOIN dental_contact i ON hst.ins_co_id = i.contactid "
     . "  JOIN dental_users users ON hst.doc_id = users.userid "
     . "  JOIN dental_users users2 ON hst.user_id = users2.userid "
     . "  LEFT JOIN dental_users users3 ON hst.authorized_id = users3.userid "
     . "  JOIN dental_user_hst_company uhc ON uhc.userid=users.userid "
     . "  	AND uhc.companyid='".$_SESSION['admincompanyid']."'"
     . "  JOIN companies hst_company ON uhc.companyid=hst_company.id ";

}else{
$sql = "SELECT "
     . "  preauth.id, i.company as ins_co, hst.patient_firstname, hst.patient_lastname, "
     . "  hst.patient_id, "
     . "  preauth.front_office_request_date, users.name as doc_name, preauth.status, "
     . "  hst.doc_id, "
     . "  DATEDIFF(NOW(), preauth.front_office_request_date) as days_pending, "
     . "  users2.name as user_name "
     . "FROM "
     . "  dental_insurance_preauth preauth "
     . "  LEFT JOIN dental_patients p ON preauth.patient_id = p.patientid "
     . "  LEFT JOIN dental_user_company uc ON uc.userid = p.docid AND uc.companyid = '".$_SESSION['admincompanyid']."'"
     . "  JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
     . "  JOIN dental_users users ON preauth.doc_id = users.userid "
     . "  JOIN dental_users users2 ON preauth.userid = users2.userid ";

}
// filter based on select lists above table
if ((isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) || !empty($fid)) {
    $sql .= "WHERE ";
    
    if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
          $sql .= "  hst.status = " . $_REQUEST['status'] . " ";
    }
    
    if (!empty($fid)) {
        if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
            $sql .= "  AND ";
        }
        $sql .= "  users.userid = " . $fid . " ";
    }
    
    if (!empty($pid)) {
        $sql .= "AND hst.patient_id = " . $pid . " ";
    }
}

$sql .= "ORDER BY " . $sort_by_sql;
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);

if(isset($_GET['status']) && isset($_GET['from']) && $_GET['from']=='view' && $total_rec == 0){
  ?>
  <script type="text/javascript">
    window.location="manage_hsts.php?msg=<?php echo $_GET['msg'];?>";
  </script>
  <?php }
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con,$sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Home Sleep Tests
</div>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><?php  echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<div style="width:98%;margin:auto;">
  <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
    Status:
    <select name="status">
      <?php $requested_selected = ($status == DSS_HST_REQUESTED) ? 'selected' : ''; ?>
      <?php $pending_selected = ($status == DSS_HST_PENDING) ? 'selected' : ''; ?>
      <?php $contacted_seleted = ($status == DSS_HST_CONTACTED) ? 'selected' : ''; ?>
      <?php $scheduled_selected = ($status == DSS_HST_SCHEDULED) ? 'selected' : ''; ?>
      <?php $complete_selected = ($status == DSS_HST_COMPLETE) ? 'selected' : ''; ?>
      <option value="">Any</option>
      <option value="<?php echo DSS_HST_REQUESTED?>" <?php echo $requested_selected?>><?php echo $dss_hst_status_labels[DSS_HST_REQUESTED]?></option>
      <option value="<?php echo DSS_HST_PENDING?>" <?php echo $pending_selected?>><?php echo $dss_hst_status_labels[DSS_HST_PENDING]?></option>
      <option value="<?php echo DSS_HST_CONTACTED?>" <?php echo $contacted_selected?>><?php echo $dss_hst_status_labels[DSS_HST_CONTACTED]?></option>
      <option value="<?php echo DSS_HST_SCHEDULED?>" <?php echo $scheduled_selected?>><?php echo $dss_hst_status_labels[DSS_HST_SCHEDULED]?></option>
      <option value="<?php echo DSS_HST_COMPLETE?>" <?php echo $complete_selected?>><?php echo $dss_hst_status_labels[DSS_HST_COMPLETE]?></option>
    </select>
    &nbsp;&nbsp;&nbsp;
    Account:
    <select name="fid">
      <option value="">Any</option>
      <?php 
        $franchisees = (is_billing($_SESSION['admin_access']))?get_billing_franchisees():get_franchisees();
        if ($franchisees) foreach ($franchisees as $row) {
          $selected = ($row['userid'] == $fid) ? 'selected' : ''; ?>
        <option value="<?php echo  $row['userid'] ?>" <?php echo  $selected ?>>[<?php echo  $row['userid'] ?>] <?php echo  $row['first_name']." ".$row['last_name']; ?></option>
      <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;

    <?php if (!empty($fid)) { ?>
      Patients:
      <select name="pid">
        <option value="">Any</option>
        <?php $patients = get_patients($fid); ?>
        <?php while ($row = mysqli_fetch_array($patients)) { ?>
          <?php $selected = ($row['patientid'] == $pid) ? 'selected' : ''; ?>
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
</div>

<form name="pagefrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<?php  if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php 
				 paging($no_pages,$index_val,"status=".$_GET['status']."&fid=".$_GET['fid']."&pid=".$_GET['pid']."&sort_by=".$_GET['sort_by']."&sort_dir=".$_GET['sort_dir']);
			?>
		</TD>
	</TR>
	<?php  }?>
	<?php     $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $fid . "&pid=" . $pid
             . "&status=" . $_REQUEST['status'] . "&sort_by=%s&sort_dir=%s";
    ?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_DATE, $sort_dir) ?>" width="15%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_DATE, get_sort_dir($sort_by, SORT_BY_DATE, $sort_dir))?>">Requested</a>
		</td>
		<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_STATUS, $sort_dir) ?>" width="10%">
			<a href="<?php echo sprintf($sort_qs, SORT_BY_STATUS, get_sort_dir($sort_by, SORT_BY_STATUS, $sort_dir))?>">Status</a>
		</td>
                <td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_COMPANY, $sort_dir) ?>" width="10%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_COMPANY, get_sort_dir($sort_by, SORT_BY_COMPANY, $sort_dir))?>">Company</a>
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
                <td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, SORT_BY_AUTHORIZED, $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, SORT_BY_AUTHORIZED, get_sort_dir($sort_by, SORT_BY_AUTHORIZED, $sort_dir))?>">Authorized&nbsp;&nbsp;</a>
                </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<?php  if(mysqli_num_rows($my) == 0)
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
		while($myarray = mysqli_fetch_array($my))
		{
		?>
			<tr class="<?php echo  (isset($tr_class))?$tr_class:'';?>">
				<td valign="top">
					<?php echo st($myarray["adddate"]);?>&nbsp;
				</td>
				<?php $status_color = ($myarray["status"] == DSS_HST_PENDING ) ? "warning" : "success"; ?>
				<?php $status_color = (($myarray["status"] == DSS_HST_PENDING) && $myarray['days_pending'] > 7) ? "danger" : $status_color; ?>
				<td valign="top" class="<?php echo  $status_color ?>">
					<?php echo st($dss_hst_status_labels[$myarray["status"]]);?>&nbsp;
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["hst_company_name"]);?>
                                </td>
				<td valign="top">
                                        <a href="view_patient.php?pid=<?php echo  $myarray['patient_id']; ?>" title="View Chart">
					<?php echo st($myarray["patient_lastname"]);?>, <?php echo st($myarray["patient_firstname"]);?>
					(View Chart)
					</a>
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
                                        <?php echo st($myarray["authorized_name"]);?>&nbsp;
                                </td>
				<td valign="top">
					<a href="view_hst.php?ed=<?php echo $myarray["id"];?><?php echo  (isset($_GET['status']) && $_GET['status']!='')?"&ret_status=".$_GET['status']:""; ?>" title="Edit" class="btn btn-primary btn-sm">
						View
					 <span class="glyphicon glyphicon-pencil"></span></a>

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
