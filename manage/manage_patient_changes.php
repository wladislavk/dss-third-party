<?php
include "includes/top.htm";
require_once('includes/constants.inc');

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;

if(isset($_REQUEST['sort'])){
	switch($_REQUEST['sort']){
		case 'address':
			$sort = "pc.address1";
			break;
		case 'name':
			$sort = "pc.lastname";
			break;
		case 'phone':
			$sort = 'pc.phone';
			break;
	}
}else{
	$_REQUEST['sort']='name';
	$_REQUEST['sortdir']='DESC';
	$sort = "pc.lastname";
}
if(isset($_REQUEST['sortdir'])){
	$dir = $_REQUEST['sortdir'];
}else{
	$dir = 'DESC';
}
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT pc.parent_patientid, pc.firstname, pc.lastname FROM dental_patients pc 
	JOIN dental_patients p ON p.patientid = pc.parent_patientid
	WHERE p.docid=".mysqli_real_escape_string($con,$_SESSION['docid'])." AND pc.parent_patientid IS NOT NULL AND pc.parent_patientid != ''";
$sql .= "ORDER BY ".$sort." ".$dir;
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Patient Changes
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>


<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
		<td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
			<a href="manage_patient_changes.php?sort=name&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contact Name</a>
		</td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<?php if(count($my) == 0){ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="4" align="center">
			No Records
		</td>
	</tr>
	<?php
	}
	else
	{
		foreach ($my as $myarray) {?>
	<tr class="<?php echo (!empty($tr_class) ? $tr_class : '');?> <?php echo (!empty($myarray['viewed']))?'':'unviewed'; ?>">
		<td valign="top">
			<?php echo st($myarray["firstname"]);?>&nbsp;
			<?php echo st($myarray["lastname"]);?> 
		</td>
		<td valign="top">
			<a href="patient_changes.php?pid=<?php echo $myarray['parent_patientid'];?>" class="editlink" title="EDIT">
				View
			</a>
		</td>
	</tr>
	<?php }
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
