<? 
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

define('SORT_BY_DATE', 0);
define('SORT_BY_STATUS', 1);
define('SORT_BY_PATIENT', 2);
define('SORT_BY_FRANCHISEE', 3);
define('SORT_BY_USER', 4);

$sort_dir = strtolower($_REQUEST['sort_dir']);
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : SORT_BY_STATUS;
$sort_by_sql = '';
switch ($sort_by) {
  case SORT_BY_DATE:
    $sort_by_sql = "claim.adddate $sort_dir";
    break;
  case SORT_BY_PATIENT:
    $sort_by_sql = "claim.patient_lastname $sort_dir, claim.patient_firstname $sort_dir";
    break;
  case SORT_BY_FRANCHISEE:
    $sort_by_sql = "doc_name $sort_dir";
    break;
  case SORT_BY_USER:
    $sort_by_sql = "user_name $sort_dir";
    break;
  default:
    // default is SORT_BY_STATUS
    $sort_by_sql = "status_order $sort_dir, claim.adddate $sort_dir";
    break;
}

$status = (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) ? $_REQUEST['status'] : -1;

if($_REQUEST["delid"] != "") {
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

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT "
     . "  claim.insuranceid, claim.patientid, claim.patient_firstname, claim.patient_lastname, "
     . "  claim.adddate, claim.status, users.name as doc_name, users2.name as user_name, "
     . "  DATEDIFF(NOW(), claim.adddate) as days_pending, "
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
     . "  JOIN dental_users users ON claim.docid = users.userid "
     . "  JOIN dental_users users2 ON claim.userid = users2.userid ";

// filter based on select lists above table
if ((isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) || !empty($_REQUEST['fid'])) {
    $sql .= "WHERE ";
    
    if (isset($_REQUEST['status']) && ($_REQUEST['status'] != '')) {
        $sql .= "  claim.status = " . $_REQUEST['status'] . " ";
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

$sql .= "ORDER BY " . $sort_by_sql;
//print $sql;
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Claims
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<div style="width:98%;margin:auto;">
  <form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="get">
    Status:
    <select name="status">
      <?php $pending_selected = ($status == DSS_CLAIM_PENDING) ? 'selected' : ''; ?>
      <?php $sent_selected = ($status == DSS_CLAIM_SENT) ? 'selected' : ''; ?>
      <option value="">Any</option>
      <option value="<?=DSS_CLAIM_PENDING?>" <?=$pending_selected?>><?=$dss_claim_status_labels[DSS_CLAIM_PENDING]?></option>
      <option value="<?=DSS_CLAIM_SENT?>" <?=$sent_selected?>><?=$dss_claim_status_labels[DSS_CLAIM_SENT]?></option>
    </select>
    &nbsp;&nbsp;&nbsp;

    Franchisees:
    <select name="fid">
      <option value="">Any</option>
      <?php $franchisees = get_franchisees(); ?>
      <?php while ($row = mysql_fetch_array($franchisees)) { ?>
        <?php $selected = ($row['userid'] == $_REQUEST['fid']) ? 'selected' : ''; ?>
        <option value="<?= $row['userid'] ?>" <?= $selected ?>>[<?= $row['userid'] ?>] <?= $row['name'] ?></option>
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
    <input type="submit" value="Filter List"/>
    <input type="button" value="Reset" onclick="window.location='<?=$_SERVER['PHP_SELF']?>'"/>
  </form>
</div>

<form name="pagefrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>
	</TR>
	<? }?>
	<?php
    $sort_qs = $_SERVER['PHP_SELF'] . "?fid=" . $_REQUEST['fid'] . "&pid=" . $_REQUEST['pid']
             . "&status=" . $_REQUEST['status'] . "&sort_by=%s&sort_dir=%s";
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
			<a href="<?=sprintf($sort_qs, SORT_BY_FRANCHISEE, get_sort_dir($sort_by, SORT_BY_FRANCHISEE, $sort_dir))?>">Franchisee</a>
		</td>
		<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, SORT_BY_USER, $sort_dir) ?>" width="20%">
			<a href="<?=sprintf($sort_qs, SORT_BY_USER, get_sort_dir($sort_by, SORT_BY_USER, $sort_dir))?>">User</a>
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="6" align="center">
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
			<tr class="<?=$tr_class;?>">
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
					<?=st($myarray["patient_lastname"]);?>, <?=st($myarray["patient_firstname"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["doc_name"]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["user_name"]);?>&nbsp;
				</td>
				<td valign="top">
				    <?php $link_label = ($myarray["status"] == DSS_CLAIM_PENDING) ? 'Edit' : 'View'; ?>
				    <a href="insurance_claim.php?insid=<?=$myarray['insuranceid']?>&fid_filter=<?=$_REQUEST['fid']?>&pid_filter=<?=$_REQUEST['pid']?>&pid=<?=$myarray['patientid']?>" class="editlink" title="EDIT">
						<?= $link_label ?> 
					</a>
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["insuranceid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						Delete
					</a>
<?php if($myarray['status'] == DSS_CLAIM_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='primary' AND f.claimid='".mysql_real_escape_string($myarray['insuranceid'])."'";
            $sq = mysql_query($s);
            if(mysql_num_rows($sq)>0){
            $file = mysql_fetch_assoc($sq);
            ?>

           <a href="../q_file/<?= $file['filename']; ?>" target="_blank" class="editlink">EOB</a>
           <a href="javascript:alert('Dispute Reason:\n<?= $file['description']; ?>');">Reason</a>

        <?php } 
          }elseif($myarray['status'] == DSS_CLAIM_SEC_DISPUTE){
            $s = "SELECT filename, description FROM dental_insurance_file f WHERE f.claimtype='secondary' AND f.claimid='".mysql_real_escape_string($myarray['insuranceid'])."'";
            $sq = mysql_query($s);
            if(mysql_num_rows($sq)>0){
            $file = mysql_fetch_assoc($sq);
            ?>

           <a href="../q_file/<?= $file['filename']; ?>" target="_blank" class="editlink">EOB</a>
           <a href="javascript:alert('Dispute Reason:\n<?= $file['description']; ?>');">Reason</a>

        <?php }
           } ?>

				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>

<br /><br />	
<? include "includes/bottom.htm";?>
