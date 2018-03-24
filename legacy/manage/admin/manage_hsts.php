<?php namespace Ds3\Libraries\Legacy; ?><?php  
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";
require_once __DIR__ . '/includes/access.php';

$fid = (isset($_REQUEST['fid']))?$_REQUEST['fid']:'';
$pid = (isset($_GET['pid']))?$_GET['pid']:'';

$isAdmin = is_super($_SESSION['admin_access']);

define('SORT_BY_DATE', 0);
define('SORT_BY_STATUS', 1);
define('SORT_BY_PATIENT', 2);
define('SORT_BY_FRANCHISEE', 3);
define('SORT_BY_USER', 4);
define('SORT_BY_INSURANCE', 5);
define('SORT_BY_COMPANY', 6);
define('SORT_BY_AUTHORIZED', 7);
define('SORT_BY_TYPE', 8);

$sort_dir = strtolower(!empty($_REQUEST['sort_dir']) ? $_REQUEST['sort_dir'] : '');
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;
$sort_by_sql = '';
switch ($sort_by) {
  case SORT_BY_DATE:
    $sort_by_sql = "order_date $sort_dir";
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
    break;
  case SORT_BY_TYPE:
    $sort_by_sql = "hst_type $sort_dir, hst_nights $sort_dir, order_date $sort_dir";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "hst.status $sort_dir, order_date $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -99;

if (!empty($_REQUEST['delid']) && is_super($_SESSION['admin_access'])) {
    cancelHSTRequest($_REQUEST['delid'], 0);

    ?>
    <script type="text/javascript">
        window.location = '/manage/admin/manage_hsts.php?msg=<?= rawurlencode('HST Request deleted successfully.') ?>';
    </script>
    <?php

    trigger_error('Die called', E_USER_ERROR);
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

$adminCompanyId = intval($_SESSION['admincompanyid']);

if (is_super($_SESSION['admin_access'])) {
    $sql = "SELECT
            hst.id,
            i.company AS ins_co,
            hst.patient_firstname,
            hst.patient_lastname,
            hst.patient_id,
            hst.adddate,
            CONCAT(users.first_name, ' ', users.last_name) AS doc_name,
            hst.hst_type,
            hst.hst_nights,
            hst.status,
            hst.doc_id,
            DATEDIFF(NOW(), hst.adddate) AS days_pending,
            CONCAT(users2.first_name, ' ',users2.last_name) AS user_name,
            CONCAT(users3.first_name, ' ',users3.last_name) AS authorized_name,
            hst_company.name AS hst_company_name,
            hst.adddate AS order_date,
            hst.canceled_id,
            hst.canceled_date
        FROM dental_hst hst
            LEFT JOIN dental_patients p ON hst.patient_id = p.patientid
            LEFT JOIN dental_contact i ON hst.ins_co_id = i.contactid
            JOIN dental_users users ON hst.doc_id = users.userid
            JOIN dental_users users2 ON hst.user_id = users2.userid
            LEFT JOIN dental_users users3 ON hst.authorized_id = users3.userid
            LEFT JOIN companies hst_company ON hst.company_id = hst_company.id
        ";
} elseif (is_hst($_SESSION['admin_access'])) {
    $sql = "SELECT
            hst.id,
            i.company AS ins_co,
            hst.patient_firstname,
            hst.patient_lastname,
            hst.patient_id,
            hst.adddate,
            CONCAT(users.first_name, ' ', users.last_name) AS doc_name,
            hst.hst_type,
            hst.hst_nights,
            hst.status,
            hst.doc_id,
            DATEDIFF(NOW(), hst.adddate) AS days_pending,
            CONCAT(users2.first_name, ' ', users2.last_name) AS user_name,
            CONCAT(users3.first_name, ' ', users3.last_name) AS authorized_name,
            hst_company.name AS hst_company_name,
            hst.adddate AS order_date,
            hst.canceled_id,
            hst.canceled_date
        FROM dental_hst hst
            LEFT JOIN dental_patients p ON hst.patient_id = p.patientid
            LEFT JOIN dental_user_company uc ON uc.userid = p.docid
            LEFT JOIN dental_contact i ON hst.ins_co_id = i.contactid
            JOIN dental_users users ON hst.doc_id = users.userid
            JOIN dental_users users2 ON hst.user_id = users2.userid
            LEFT JOIN dental_users users3 ON hst.authorized_id = users3.userid
            JOIN dental_user_hst_company uhc ON uhc.userid = users.userid
                AND uhc.companyid = hst.company_id
                AND hst.company_id = '$adminCompanyId'
            JOIN companies hst_company ON uhc.companyid = hst_company.id
        ";
} else {
    $sql = "SELECT
            hst.id,
            i.company AS ins_co,
            hst.patient_firstname,
            hst.patient_lastname,
            hst.patient_id,
            hst.adddate,
            CONCAT(users.first_name, ' ', users.last_name) AS doc_name,
            hst.hst_type,
            hst.hst_nights,
            hst.status,
            hst.doc_id,
            DATEDIFF(NOW(), hst.adddate) AS days_pending,
            CONCAT(users2.first_name, ' ', users2.last_name) AS user_name,
            CONCAT(users3.first_name, ' ', users3.last_name) AS authorized_name,
            hst_company.name AS hst_company_name,
            hst.adddate AS order_date,
            hst.canceled_id,
            hst.canceled_date
        FROM dental_hst hst
            LEFT JOIN dental_patients p ON hst.patient_id = p.patientid
            LEFT JOIN dental_user_company uc ON uc.userid = p.docid
                AND uc.companyid = '$adminCompanyId'
            JOIN dental_contact i ON hst.ins_co_id = i.contactid
            JOIN dental_users users ON hst.doc_id = users.userid
            JOIN dental_users users2 ON hst.user_id = users2.userid
            LEFT JOIN dental_users users3 ON hst.authorized_id = users3.userid
            LEFT JOIN companies hst_company ON hst.company_id = hst_company.id
        ";
}

// filter based on select lists above table
if ((isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) || !empty($fid)) {
    $sql .= "WHERE 1 = 1 ";

    if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
          $sql .= " AND hst.status = " . $_REQUEST['status'] . " ";
    }
    
    if (!empty($fid)) {
        $sql .= " AND users.userid = " . $fid . " ";
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
      <?php

      $requested_selected = ($status == DSS_HST_REQUESTED) ? 'selected' : '';
      $pending_selected = ($status == DSS_HST_PENDING) ? 'selected' : '';
      $contacted_selected = ($status == DSS_HST_CONTACTED) ? 'selected' : '';
      $scheduled_selected = ($status == DSS_HST_SCHEDULED) ? 'selected' : '';
      $complete_selected = ($status == DSS_HST_COMPLETE) ? 'selected' : '';
      $rejected_selected = ($status == DSS_HST_REJECTED) ? 'selected' : '';
      $canceled_selected = ($status == DSS_HST_CANCELED) ? 'selected' : '';

      ?>
      <option value="" <?= $status == -99 ? 'selected' : '' ?>>Any</option>
      <option value="<?php echo DSS_HST_REQUESTED?>" <?php echo $requested_selected?>><?php echo $dss_hst_status_labels[DSS_HST_REQUESTED]?></option>
      <option value="<?php echo DSS_HST_PENDING?>" <?php echo $pending_selected?>><?php echo $dss_hst_status_labels[DSS_HST_PENDING]?></option>
      <option value="<?php echo DSS_HST_CONTACTED?>" <?php echo $contacted_selected?>><?php echo $dss_hst_status_labels[DSS_HST_CONTACTED]?></option>
      <option value="<?php echo DSS_HST_SCHEDULED?>" <?php echo $scheduled_selected?>><?php echo $dss_hst_status_labels[DSS_HST_SCHEDULED]?></option>
      <option value="<?php echo DSS_HST_COMPLETE?>" <?php echo $complete_selected?>><?php echo $dss_hst_status_labels[DSS_HST_COMPLETE]?></option>
      <option value="<?php echo DSS_HST_REJECTED?>" <?php echo $rejected_selected?>><?php echo $dss_hst_status_labels[DSS_HST_REJECTED]?></option>
      <option value="<?php echo DSS_HST_CANCELED?>" <?php echo $canceled_selected?>><?php echo $dss_hst_status_labels[DSS_HST_CANCELED]?></option>
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

      <a class="btn btn-success pull-right" href="/manage/admin/hst-report.php">HST Report</a>
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
        <td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_TYPE, $sort_dir) ?>" width="10%">
            <a href="<?= sprintf($sort_qs, SORT_BY_TYPE, get_sort_dir($sort_by, SORT_BY_TYPE, $sort_dir))?>">Type</a>
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
		while($myarray = mysqli_fetch_array($my)) {
            $tr_class = '';
            $status_color = '';
            $title = '';

            if ($myarray['status'] == DSS_HST_PENDING) {
                $status_color = $myarray['days_pending'] > 7 ? 'danger' : 'warning';
            } elseif ($myarray['status'] < 0) {
                $tr_class = 'info';
            } else {
                $status_color = 'success';
            }

            if ($myarray['status'] == DSS_HST_CANCELED) {
                $cancelDate = $myarray['canceled_date'] ? date('m/d/Y h:i a', strtotime($myarray['canceled_date'])) : '';
                $cancelerName = $db->getColumn("SELECT CONCAT(first_name, ' ', last_name) AS name
                      FROM dental_users
                      WHERE userid = '{$myarray['canceled_id']}'", 'name');

                if ($cancelDate || $cancelerName) {
                    $title = 'HST canceled' . ($cancelDate ? " on $cancelDate" : '') .
                        ($cancelerName ? " by $cancelerName" : '');
                }
            }

		?>
			<tr class="<?php echo  (isset($tr_class))?$tr_class:'';?>" <?php if ($title) { ?>title="<?= e($title) ?>"<?php } ?>>
				<td valign="top">
					<?php echo st($myarray["adddate"]);?>&nbsp;
				</td>
				<td valign="top" class="<?php echo  $status_color ?>">
					<?= st($dss_hst_status_labels[$myarray["status"]]) ?>&nbsp;
				</td>
                <td>
                    <?php

                    switch ($myarray['hst_type']) {
                        case 1:
                            echo intval($myarray['hst_nights']) . '-night';
                            break;
                        case 3:
                            echo intval($myarray['hst_nights']) . '-night titration';
                            break;
                        case 2:
                            echo 'PAP';
                            break;
                    }

                    ?>
                </td>
                                <td valign="top">
                                        <?php echo st($myarray["hst_company_name"]);?>
                                </td>
				<td valign="top">
                    <?php if ($myarray['patient_id']) { ?>
                        <a href="view_patient.php?pid=<?php echo  $myarray['patient_id']; ?>" title="View Chart">
                            <?php echo st($myarray["patient_lastname"]);?>, <?php echo st($myarray["patient_firstname"]);?>
                            (View Chart)
                        </a>
                    <?php } else { ?>
                        <?= e($myarray['patient_lastname'] . ', ' . $myarray['patient_firstname']) ?>
                    <?php } ?>
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
