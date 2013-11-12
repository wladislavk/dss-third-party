<? 
require_once('includes/constants.inc');
include "includes/top.htm";
include "includes/constants.inc";
if(isset($_GET['rid'])){
$s = sprintf("UPDATE dental_hst SET viewed=1 WHERE id=%s AND patient_id=%s AND doc_id=%s",$_REQUEST['rid'], $_REQUEST['pid'], $_SESSION['docid']);
mysql_query($s);
}elseif(isset($_GET['urid'])){
$s = sprintf("UPDATE dental_hst SET viewed=0 WHERE id=%s AND patient_id=%s AND doc_id=%s",$_REQUEST['urid'], $_REQUEST['pid'], $_SESSION['docid']);
mysql_query($s);
}

$sql = "select hst.*, p.firstname, p.lastname from dental_hst hst LEFT JOIN dental_patients p ON p.patientid=hst.patient_id WHERE hst.doc_id = ".$_SESSION['docid']." ";
if(isset($_GET['status'])){
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

  $pat_sql = "INSERT INTO dental_patients SET
                docid='".mysql_real_escape_string($r['docid'])."',
                firstname = '".mysql_real_escape_string($r['first_name'])."',
                lastname = '".mysql_real_escape_string($r['last_name'])."',
                cell_phone = '".mysql_real_escape_string($r['phone'])."',
                status='1',
                adddate = now(),
                ip_address = '".$_SERVER['REMOTE_ADDR']."'";
  mysql_query($pat_sql);
  $pat_id = mysql_insert_id();
  
  $hst_sql = "UPDATE dental_hst SET
                patient_id = '".$pat_id."',
                status='".DSS_HST_PENDING."'
                WHERE id=".mysql_real_escape_string($_REQUEST['authorize']);
  mysql_query($hst_sql);
  ?>
  <script type="text/javascript">
    window.location = 'manage_hst.php';
  </script>
  <?php
}  

  //$sql .= "ORDER BY ".$sort." ".$dir;
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

//$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
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

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
			<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&sort=request_date&sortdir=<?php echo ($_REQUEST['sort']=='request_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Requested</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient Name</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_vobs.php?pid=<?= $_GET['pid'] ?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Status</a>	
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
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
			<tr class="<?=$tr_class;?> <?= ($myarray['viewed'])?'':'unviewed'; ?>">
				<td valign="top">
					<?=date('m/d/Y h:i a',strtotime($myarray["adddate"]));?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["patient_firstname"]);?>&nbsp;
                    <?=st($myarray["patient_lastname"]);?> 
				</td>
				<td valign="top" class="status_<?= $myarray['status']; ?>">
					<?= $dss_hst_status_labels[$myarray["status"]];?>&nbsp;
				</td>
				<td valign="top">
					<a href="view_hst.php?pid=<?= $myarray["patient_id"]; ?>&vob_id=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
						View
					</a>
					<br />
					<?php 
					if(!$myarray['viewed']){ ?>
                                        <a href="manage_hst.php?pid=<?= $myarray["patient_id"]; ?>&rid=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
                                                Mark Read
                                        </a>
					<?php }else{ ?>
                                        <a href="manage_hst.php?pid=<?= $myarray["patient_id"]; ?>&urid=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
                                                Mark Unread
                                        </a>
					<?php } 
					?>
                                        <?php
                                        if($myarray['status']==DSS_HST_REQUESTED){ ?>
                                        <a href="manage_hst.php?authorize=<?= $myarray["id"]; ?>" class="editlink" title="EDIT">
                                                Authorize
                                        </a>
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
