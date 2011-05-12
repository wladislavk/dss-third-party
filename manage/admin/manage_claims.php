<? 
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

define('SORT_BY_DATE', 0);
define('SORT_BY_STATUS', 1);
define('SORT_BY_PATIENT', 2);
define('SORT_BY_FRANCHISEE', 3);

$sort_by  = (!empty($_REQUEST['sort_by']))  ? $_REQUEST['sort_by'] : SORT_BY_STATUS;
$sort_dir = (!empty($_REQUEST['sort_dir'])) ? $_REQUEST['sort_dir'] : 'DESC';

$sort_by_sql = array(
  SORT_BY_DATE => "claim.adddate $sort_dir",
  SORT_BY_STATUS => "claim.status $sort_dir",
  SORT_BY_PATIENT => "claim.patient_lastname $sort_dir, claim.patient_firstname $sort_dir",
  SORT_BY_FRANCHISEE => "doc_name $sort_dir"
);

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
     . "  claim.adddate, claim.status, users.name as doc_name "
     . "FROM "
     . "  dental_insurance claim "
     . "  JOIN dental_users users ON claim.docid = users.userid ";

if (!empty($_REQUEST['fid'])) {
    $sql .= "WHERE "
          . "  users.userid = " . $_REQUEST['fid'] . " ";
    
    if (!empty($_REQUEST['pid'])) {
        $sql .= "AND claim.patientid = " . $_REQUEST['pid'] . " ";
    }
}

$sql .= "ORDER BY "
      . "  " . $sort_by_sql[$sort_by] . ", "
      . "  claim.adddate ASC";
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
          <option value="<?= $row['patientid'] ?>" <?= $selected ?>>[<?= $row['patientid'] ?>] <?= $row['firstname'] ?> <?= $row['lastname'] ?></option>
        <?php } ?>
      </select>
      &nbsp;&nbsp;&nbsp;
    <?php } ?>
    
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
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="15%">
			Added
		</td>
		<td valign="top" class="col_head" width="10%">
			Status
		</td>
		<td valign="top" class="col_head" width="30%">
			Patient Name
		</td>
		<td valign="top" class="col_head" width="30%">
			Franchisee Name
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="5" align="center">
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
				<?php $status_text = ($myarray["status"] == DSS_CLAIM_PENDING) ? "black" : "white"; ?>
				<td valign="top" style="background-color:<?= $status_color ?>; color: <?= $status_text ?>;">
					<?=st($dss_claim_status_labels[$myarray["status"]]);?>&nbsp;
				</td>
				<td valign="top">
					<?=st($myarray["patient_lastname"]);?>, <?=st($myarray["patient_firstname"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["doc_name"]);?>&nbsp;
				</td>
				<td valign="top">
				    <?php $link_label = ($myarray["status"] == DSS_CLAIM_PENDING) ? 'Edit' : 'View'; ?>
				    <a href="insurance_claim.php?insid=<?=$myarray['insuranceid']?>&fid_filter=<?=$_REQUEST['fid']?>&pid_filter=<?=$_REQUEST['pid']?>&pid=<?=$myarray['patientid']?>" class="editlink" title="EDIT">
						<?= $link_label ?> 
					</a>
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["insuranceid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						Delete
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>

<br /><br />	
<? include "includes/bottom.htm";?>