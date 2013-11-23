<? 
require_once('includes/constants.inc');
include "includes/top.htm";
include "includes/constants.inc";
if(isset($_GET['rid'])){
$s = sprintf("UPDATE dental_hst SET viewed=1 WHERE id=%s AND doc_id=%s",$_REQUEST['rid'], $_SESSION['docid']);
mysql_query($s);
}elseif(isset($_GET['urid'])){
$s = sprintf("UPDATE dental_hst SET viewed=0 WHERE id=%s AND doc_id=%s",$_REQUEST['urid'], $_SESSION['docid']);
mysql_query($s);
}

$sql = "select hst.*, p.firstname, p.lastname,
		CONCAT(u.first_name,' ',u.last_name) authorized_by
		from dental_hst hst 
		LEFT JOIN dental_patients p ON p.patientid=hst.patient_id 
		LEFT JOIN dental_users u ON u.userid=hst.authorized_id
		WHERE hst.doc_id = ".$_SESSION['docid']." ";
if(isset($_GET['status']) && $_GET['status']!=''){
  $sql .= " AND hst.status = '".mysql_real_escape_string($_GET['status'])."' ";
}
if(isset($_GET['viewed'])){
  if($_GET['viewed']==1){
  	$sql .= " AND hst.viewed = '".mysql_real_escape_string($_GET['viewed'])."' ";
  }else{
	$sql .= " AND (hst.viewed = '0' OR hst.viewed IS NULL) ";
  }
}

if(isset($_REQUEST['authorize'])){

  $sql = "SELECT s.* FROM dental_screener s JOIN dental_hst h ON h.screener_id = s.id WHERE h.id='".mysql_real_escape_string($_REQUEST['authorize'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
  $sql = "SELECT * FROM dental_hst WHERE screener_id='".mysql_real_escape_string($r['id'])."'";
  $q = mysql_query($sql);
  $h = mysql_fetch_assoc($q);
  $dob = ($h['patient_dob']!='')?date('m/d/Y', strtotime($h['patient_dob'])):'';
  $pat_sql = "INSERT INTO dental_patients SET
                docid='".mysql_real_escape_string($r['docid'])."',
                firstname = '".mysql_real_escape_string($r['first_name'])."',
                lastname = '".mysql_real_escape_string($r['last_name'])."',
                cell_phone = '".mysql_real_escape_string($r['phone'])."',
                email = '".mysql_real_escape_string($h['patient_email'])."',
                dob = '".mysql_real_escape_string($dob)."',
                status='1',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
  mysql_query($pat_sql);
  $pat_id = mysql_insert_id();
  
  $hst_sql = "UPDATE dental_hst SET
                patient_id = '".$pat_id."',
                status='".DSS_HST_PENDING."',
                authorized_id='".mysql_real_escape_string($_SESSION['userid'])."',
		authorizeddate=now(),
                updatedate=now()
                WHERE id=".mysql_real_escape_string($_REQUEST['authorize']);
  mysql_query($hst_sql);

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

  //$sql .= "ORDER BY ".$sort." ".$dir;
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

//$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Home Sleep Tests
</span>
<?php if(isset($_GET['viewed']) && $_GET['viewed']==0){ ?>
<a href="manage_hst.php?pid=<?= $_GET['pid'] ?>&sort=<?php echo $_REQUEST['sort']; ?>&sortdir=<?php echo $_REQUEST['sortdir']; ?>" style="float:right; margin-right:10px;" class="addButton">Show All</a>
<?php }else{ ?>
<a href="manage_hst.php?pid=<?= $_GET['pid'] ?>&viewed=0&sort=<?php echo $_REQUEST['sort']; ?>&sortdir=<?php echo $_REQUEST['sortdir']; ?>" style="float:right; margin-right:10px;" class="addButton">Show Unread</a>
<?php } ?>
<br />
<br />
&nbsp;
  <form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" class="fullwidth" method="get">
    Status:
    <select name="status">
      <?php $requested_selected = ($_REQUEST['status'] == '0') ? 'selected' : ''; ?>
      <?php $pending_selected = ($_REQUEST['status'] == DSS_HST_PENDING) ? 'selected' : ''; ?>
      <?php $scheduled_selected = ($_REQUEST['status'] == DSS_HST_SCHEDULED) ? 'selected' : ''; ?>
      <?php $complete_selected = ($_REQUEST['status'] == DSS_HST_COMPLETE) ? 'selected' : ''; ?>
      <option value="">Any</option>
      <option value="<?=DSS_HST_REQUESTED?>" <?=$requested_selected?>><?=$dss_hst_status_labels[DSS_HST_REQUESTED]?></option>
      <option value="<?=DSS_HST_PENDING?>" <?=$pending_selected?>><?=$dss_hst_status_labels[DSS_HST_PENDING]?></option>
      <option value="<?=DSS_HST_SCHEDULED?>" <?=$scheduled_selected?>><?=$dss_hst_status_labels[DSS_HST_SCHEDULED]?></option>
      <option value="<?=DSS_HST_COMPLETE?>" <?=$complete_selected?>><?=$dss_hst_status_labels[DSS_HST_COMPLETE]?></option>
    </select>
    <input type="hidden" name="sort_by" value="<?=$sort_by?>"/>
    <input type="hidden" name="sort_dir" value="<?=$sort_dir?>"/>
    <input type="submit" value="Filter List"/>
    <input type="button" value="Reset" onclick="window.location='<?=$_SERVER['PHP_SELF']?>'"/>
  </form>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" id="hst_table" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']);
			?>
		</TD>
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'request_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_hst.php?pid=<?= $_GET['pid'] ?>&sort=request_date&sortdir=<?php echo ($_REQUEST['sort']=='request_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Requested</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_hst.php?pid=<?= $_GET['pid'] ?>&sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient Name</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_hst.php?pid=<?= $_GET['pid'] ?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Status</a>	
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
		<td valign="top" class="col_head" width="15%">
			Authorize
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="4" align="center">
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
			<tr class="<?=$tr_class;?> <?= (!$myarray['viewed'] && $myarray['status'] == DSS_HST_COMPLETE)?'unviewed':''; ?>">
				<td valign="top">
					<?=date('m/d/Y h:i a',strtotime($myarray["adddate"]));?>&nbsp;
				</td>
				<td valign="top">
				  <?php if($myarray['patient_id']){?>
					<a href="dss_summ.php?pid=<?= $myarray['patient_id']; ?>&addtopat=1&sect=sleep">
					  <?=st($myarray["patient_firstname"]);?>&nbsp;
                    			  <?=st($myarray["patient_lastname"]);?> 
					</a>
				  <?php }else{ ?>
					<?=st($myarray["patient_firstname"]);?>&nbsp;
                    			<?=st($myarray["patient_lastname"]);?>
				  <?php } ?>
				</td>
				<td valign="top" class="status_<?= $myarray['status']; ?>">
					<?= $dss_hst_status_labels[$myarray["status"]];?>&nbsp;
					<?= ($myarray['status'] != DSS_HST_PENDING && $myarray['updatedate'])? date('m/d/Y H:i a', strtotime($myarray['updatedate'])):''; ?>
                                        <?= ($myarray['status'] == DSS_HST_SCHEDULED)?$myarray['office_notes']:'';?>
				</td>
				<td valign="top">
				  <?php if($myarray['status']==DSS_HST_COMPLETE){ ?>
					<a href="dss_summ.php?pid=<?= $myarray['patient_id']; ?>&addtopat=1&sect=sleep" class="editlink" title="EDIT">
					View</a>
				 <?php }else{ ?>
					<a href="hst_view.php?pid=<?= $myarray['patient_id']; ?>&hst_id=<?= $myarray["id"]; ?>" style="float:left;" class="editlink" title="EDIT">
						View
					</a>
				  <?php } ?>
					<?php 
					if($myarray['status'] == DSS_HST_COMPLETE){
					if(!$myarray['viewed']){ ?>
                                        <a href="manage_hst.php?rid=<?= $myarray["id"]; ?>" style="float:right;" class="editlink" title="EDIT">
                                                Mark Read
                                        </a>
					<?php }else{ ?>
                                        <a href="manage_hst.php?urid=<?= $myarray["id"]; ?>" style="float:right;" class="editlink" title="EDIT">
                                                Mark Unread
                                        </a>
					<?php } 
					}
					?>
					</td>
					<td valign="top">
                                        <?php
$sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysql_real_escape_string($_SESSION['userid'])."'";
        $sign_q = mysql_query($sign_sql);
        $sign_r = mysql_fetch_assoc($sign_q);
        $user_sign = $sign_r['sign_notes'];

                                      if($myarray['status']==DSS_HST_REQUESTED){
					if($user_sign || $_SESSION['docid']==$_SESSION['userid']){ ?>
                                        <a href="manage_hst.php?authorize=<?= $myarray["id"]; ?>" onclick="return confirm('By clicking OK, you certify that you have discussed HST protocols with this patient and are legally qualified to request a HST for this patient. Your digital signature will be attached to this submission. You will be notified by the HST company when the patient\'s HST is complete.');" class="button" title="Authorize HST">
                                                Authorize
                                        </a>
                                        <?php }else{ ?>
<a href="#" onclick="alert('You do not have sufficient permission to order a Home Sleep Test. Only a dentist may do this.');return false;" class="button" title="Authorize HST">
                                                Authorize
                                        </a>
					<?php } ?>
				      <?php }else{ ?>
					<?= ($myarray['authorizeddate'])?date('m/d/Y h:i a', strtotime($myarray['authorizeddate'])):''; ?>
					- <?= $myarray['authorized_by'] ?>
				      <?php } ?>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>




<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
