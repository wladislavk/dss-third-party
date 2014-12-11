<?php 
include "includes/top.htm";
include_once "includes/constants.inc";

if(isset($_GET['rid'])){
  $s = sprintf("UPDATE dental_hst SET viewed=1 WHERE id=%s AND doc_id=%s",$_REQUEST['rid'], $_SESSION['docid']);
  $db->query($s);
  if(isset($_GET['status']) && isset($_GET['viewed']) && $_GET['status']==DSS_HST_REJECTED && $_GET['viewed']==0){
    $r_sql = "SELECT * FROM dental_hst where doc_id=".$_SESSION['docid']." AND status='".DSS_HST_REJECTED."' AND viewed=0";
    $r_q = $db->getNumberRows($r_sql);
    if($r_q == 0){ ?>
      <script type="text/javascript">
      	window.location = 'index.php';
      </script>
    <?php }
  }
}elseif(isset($_GET['urid'])){
  $s = sprintf("UPDATE dental_hst SET viewed=0 WHERE id=%s AND doc_id=%s",$_REQUEST['urid'], $_SESSION['docid']);
  $db->query($s);
}

$sql = "select hst.*, p.firstname, p.lastname,
		CASE hst.status
			WHEN ".DSS_HST_REQUESTED."
				THEN 1
                        WHEN ".DSS_HST_PENDING."
                                THEN 2
                        WHEN ".DSS_HST_CONTACTED."
                                THEN 3
                        WHEN ".DSS_HST_SCHEDULED."
                                THEN 4
                        WHEN ".DSS_HST_COMPLETE."
                                THEN 5
                        WHEN ".DSS_HST_REJECTED."
                                THEN 6
		END as sort_status,
		CONCAT(u.first_name,' ',u.last_name) authorized_by
		from dental_hst hst 
		LEFT JOIN dental_patients p ON p.patientid=hst.patient_id 
		LEFT JOIN dental_users u ON u.userid=hst.authorized_id
		WHERE hst.doc_id = ".$_SESSION['docid']." ";

if(isset($_GET['status']) && $_GET['status']!=''){
  $sql .= " AND hst.status = '".mysqli_real_escape_string($con,$_GET['status'])."' ";
}
if(isset($_GET['viewed'])){
  if($_GET['viewed']==1){
  	$sql .= " AND hst.viewed = '".mysqli_real_escape_string($con,$_GET['viewed'])."' ";
  }else{
	$sql .= " AND (hst.viewed = '0' OR hst.viewed IS NULL) ";
  }
}
if (!empty($_GET['sort'])) {
  switch($_GET['sort']){
    case 'requested_date':
      $sql .= "ORDER BY adddate ".$_GET['sortdir'];
      break;
    case 'patient_name':
      $sql .= "ORDER BY patient_lastname ".$_GET['sortdir'].", patient_firstname ".$_GET['sortdir'];
      break;
    case 'status':
      $sql .= "ORDER BY sort_status ".$_GET['sortdir'];
      break;
    case 'authorize':
      $sql .= "ORDER BY authorizeddate ".$_GET['sortdir'];
      break;
    default:
      $sql .= "ORDER BY adddate ".$_GET['sortdir'];
      break;
  }
}

if(isset($_REQUEST['authorize'])){

  $sql = "SELECT s.* FROM dental_screener s JOIN dental_hst h ON h.screener_id = s.id WHERE h.id='".mysqli_real_escape_string($con,$_REQUEST['authorize'])."'";
  $r = $db->getRow($sql);
  $sql = "SELECT * FROM dental_hst WHERE screener_id='".mysqli_real_escape_string($con,$r['id'])."'";
  $h = $db->getRow($sql);

  $dob = ($h['patient_dob']!='')?date('m/d/Y', strtotime($h['patient_dob'])):'';
  $pat_sql = "INSERT INTO dental_patients SET
                docid='".mysqli_real_escape_string($con,$r['docid'])."',
                firstname = '".mysqli_real_escape_string($con,$r['first_name'])."',
                lastname = '".mysqli_real_escape_string($con,$r['last_name'])."',
                cell_phone = '".mysqli_real_escape_string($con,$r['phone'])."',
                email = '".mysqli_real_escape_string($con,$h['patient_email'])."',
                dob = '".mysqli_real_escape_string($con,$dob)."',
                status='1',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";

  $pat_id = $db->getInsertId($pat_sql);
  
  $hst_sql = "UPDATE dental_hst SET
                patient_id = '".$pat_id."',
                status='".DSS_HST_PENDING."',
                authorized_id='".mysqli_real_escape_string($con,$_SESSION['userid'])."',
		authorizeddate=now(),
                updatedate=now()
                WHERE id=".mysqli_real_escape_string($con,$_REQUEST['authorize']);
  $db->query($hst_sql);

  $unsent_sql = "SELECT count(*) num_unsent FROM dental_hst WHERE doc_id = ".$_SESSION['docid']." AND status='".DSS_HST_REQUESTED."'";
  $unsent_q = mysql_query($unsent_sql);
  if(mysql_num_rows($unsent_q) > 0){
  ?>
  <script type="text/javascript">
    window.location = 'manage_hst.php?status=0';
  </script>
  <?php
  }else{
  ?>
  <script type="text/javascript">
    window.location = 'manage_hst.php';
  </script>
  <?php
  }
}  

$total_rec = $db->getNumberRows($sql);
/* $rec_disp is null that's why */ $rec_disp = $total_rec;

$rec_disp = ($rec_disp != 0) ? $rec_disp : 1;

$no_pages = $total_rec/$rec_disp;

//$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Home Sleep Tests
</span>
<?php if(isset($_GET['viewed']) && $_GET['viewed']==0){ ?>
  <a href="manage_hst.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=<?php echo (!empty($_REQUEST['sort']) ? $_REQUEST['sort'] : ''); ?>&sortdir=<?php echo (!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : ''); ?>" style="float:right; margin-right:10px;" class="addButton">Show All</a>
<?php }else{ ?>
  <a href="manage_hst.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&viewed=0&sort=<?php echo (!empty($_REQUEST['sort']) ? $_REQUEST['sort'] : ''); ?>&sortdir=<?php echo (!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : ''); ?>" style="float:right; margin-right:10px;" class="addButton">Show Unread</a>
<?php } ?>
<br />
<br />
&nbsp;
  <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" class="fullwidth" method="get">
    Status:
    <select name="status">
      <?php 
        $requested_selected = (!empty($_REQUEST['status'])) ? 'selected' : '';
        $pending_selected = (!empty($_REQUEST['status']) && $_REQUEST['status'] == DSS_HST_PENDING) ? 'selected' : '';
        $contacted_selected = (!empty($_REQUEST['status']) && $_REQUEST['status'] == DSS_HST_CONTACTED) ? 'selected' : '';
        $scheduled_selected = (!empty($_REQUEST['status']) && $_REQUEST['status'] == DSS_HST_SCHEDULED) ? 'selected' : '';
        $complete_selected = (!empty($_REQUEST['status']) && $_REQUEST['status'] == DSS_HST_COMPLETE) ? 'selected' : '';
        $rejected_selected = (!empty($_REQUEST['status']) && $_REQUEST['status'] == DSS_HST_REJECTED) ? 'selected' : ''; 
      ?>
      <option value="">Any</option>
      <option value="<?php echo DSS_HST_REQUESTED?>" <?php echo $requested_selected?>><?php echo $dss_hst_status_labels[DSS_HST_REQUESTED]?></option>
      <option value="<?php echo DSS_HST_PENDING?>" <?php echo $pending_selected?>><?php echo $dss_hst_status_labels[DSS_HST_PENDING]?></option>
      <option value="<?php echo DSS_HST_CONTACTED?>" <?php echo $contacted_selected?>><?php echo $dss_hst_status_labels[DSS_HST_CONTACTED]?></option>
      <option value="<?php echo DSS_HST_SCHEDULED?>" <?php echo $scheduled_selected?>><?php echo $dss_hst_status_labels[DSS_HST_SCHEDULED]?></option>
      <option value="<?php echo DSS_HST_COMPLETE?>" <?php echo $complete_selected?>><?php echo $dss_hst_status_labels[DSS_HST_COMPLETE]?></option>
      <option value="<?php echo DSS_HST_REJECTED?>" <?php echo $rejected_selected?>><?php echo $dss_hst_status_labels[DSS_HST_REJECTED]?></option>
    </select>
    <input type="hidden" name="sort_by" value="<?php echo (!empty($sort_by) ? $sort_by : ''); ?>"/>
    <input type="hidden" name="sort_dir" value="<?php echo (!empty($sort_dir) ? $sort_dir : ''); ?>"/>
    <input type="submit" value="Filter List"/>
    <input type="button" value="Reset" onclick="window.location='<?php echo $_SERVER['PHP_SELF']?>'"/>
  </form>

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>


<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <table width="98%" cellpadding="5" id="hst_table" cellspacing="1" bgcolor="#FFFFFF" align="center" >
  	<?php if($total_rec > $rec_disp) {?>
  	<TR bgColor="#ffffff">
  		<TD  align="right" colspan="15" class="bp">
  			Pages:
  			<?php
  				 paging($no_pages,$index_val,"sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']);
  			?>
  		</TD>
  	</TR>
  	<?php }?>
  	<tr class="tr_bg_h">
  		<td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'request_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
  			<a href="manage_hst.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=request_date&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='request_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
          Requested
        </a>
  		</td>
  		<td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
  			<a href="manage_hst.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=patient_name&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
          Patient Name
        </a>
  		</td>
  		<td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
  			<a href="manage_hst.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=status&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
          Status
        </a>	
  		</td>
  		<td valign="top" class="col_head" width="15%">
  			Action
  		</td>
	  	<td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'authorize')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
        <a href="manage_hst.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=authorize&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='authorize'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
          Authorize
        </a>
  		</td>
  	</tr>
  	<?php if(count($my) == 0)
  	{ ?>
  		<tr class="tr_bg">
  			<td valign="top" class="col_head" colspan="4" align="center">
  				No Records
  			</td>
  		</tr>
  	<?php 
  	}
  	else
  	{
      foreach ($my as $myarray){	?>
      <tr class="<?php echo (!empty($tr_class) ? $tr_class : '');?> <?php echo (!$myarray['viewed'] && ($myarray['status'] == DSS_HST_COMPLETE || $myarray['status']==DSS_HST_REJECTED))?'unviewed':''; ?>">
        <td valign="top">
          <?php echo date('m/d/Y h:i a',strtotime($myarray["adddate"]));?>&nbsp;
        </td>
        <td valign="top">
        <?php if($myarray['patient_id']){?>
          <a href="dss_summ.php?pid=<?php echo $myarray['patient_id']; ?>&addtopat=1&sect=sleep">
            <?php echo st($myarray["patient_firstname"]) . '&nbsp;' . st($myarray["patient_lastname"]);?>
          </a>
        <?php }else{ 
          echo st($myarray["patient_firstname"]) . '&nbsp;' . st($myarray["patient_lastname"]);
        } ?>
        </td>
        <td valign="top" class="status_<?php echo $myarray['status']; ?>">
          <?php echo $dss_hst_status_labels[$myarray["status"]] . '&nbsp;';?>
          <?php echo ($myarray['status'] != DSS_HST_PENDING && $myarray['status'] != DSS_HST_REJECTED && $myarray['updatedate'])? date('m/d/Y H:i a', strtotime($myarray['updatedate'])):''; ?>
          <?php echo $myarray['office_notes'];?>
          <?php echo ($myarray['status'] == DSS_HST_REJECTED && $myarray['rejecteddate'])? date('m/d/Y h:i a', strtotime($myarray['rejecteddate'])):''; ?>
          <?php echo ($myarray['status'] == DSS_HST_REJECTED)?$myarray['rejected_reason']:'';?>
        </td>
        <td valign="top">
        <?php if($myarray['status']==DSS_HST_COMPLETE){ ?>
          <a href="dss_summ.php?pid=<?php echo $myarray['patient_id']; ?>&addtopat=1&sect=sleep" class="editlink" title="EDIT"  onclick="alert('After you view the test results, please return to this page and click “Mark Read” to clear the item from your pending queue.');">
            View
          </a>
        <?php }else{ ?>
          <a href="hst_view.php?pid=<?php echo $myarray['patient_id']; ?>&hst_id=<?php echo $myarray["id"]; ?>" style="float:left;" class="editlink" title="EDIT" onclick="alert('After you view the test results, please return to this page and click “Mark Read” to clear the item from your pending queue.');">
            View
          </a>
        <?php } 
        if($myarray['status'] == DSS_HST_COMPLETE || $myarray['status'] == DSS_HST_REJECTED){
          if(!$myarray['viewed']){ ?>
          <a href="manage_hst.php?rid=<?php echo $myarray["id"]; ?>&status=<?php echo $_GET['status'];?>&viewed=<?php echo $_GET['viewed'];?>" style="float:right;" class="editlink" title="EDIT">
           Mark Read
          </a>
          <?php }else{ ?>
          <a href="manage_hst.php?urid=<?php echo $myarray["id"]; ?>&status=<?php echo $_GET['status'];?>" style="float:right;" class="editlink" title="EDIT">
            Mark Unread
          </a>
        <?php } 
        } ?>
        </td>
        <td valign="top">
          <?php
          $sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
          $sign_r = $db->getRow($sign_sql);
          $user_sign = $sign_r['sign_notes'];

          if($myarray['status']==DSS_HST_REQUESTED){
            if($user_sign || $_SESSION['docid']==$_SESSION['userid']){ ?>
            <a href="manage_hst.php?authorize=<?php echo $myarray["id"]; ?>" onclick="return confirm('By clicking OK, you certify that you have discussed HST protocols with this patient and are legally qualified to request a HST for this patient. Your digital signature will be attached to this submission. You will be notified by the HST company when the patient\'s HST is complete.');" class="button" title="Authorize HST">
              Authorize
            </a>
            <?php }else{ ?>
            <a href="#" onclick="alert('You do not have sufficient permission to order a Home Sleep Test. Only a dentist may do this.');return false;" class="button" title="Authorize HST">
              Authorize
            </a>
            <?php } 
            }else{
              echo ($myarray['authorizeddate'])?date('m/d/Y h:i a', strtotime($myarray['authorizeddate'])):'';
              echo ' - ' . $myarray['authorized_by'];
            } ?>
        </td>
      </tr>
  	<?php 	}
  	}?>
  </table>
</form>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
