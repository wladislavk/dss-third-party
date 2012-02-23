<? 
require_once('includes/constants.inc');
include "includes/top.htm";

$rec_disp = 20;

if($_REQUEST["page"] != "")
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
$sql = "SELECT pc.parent_patientid, pc.firstname, pc.lastname FROM dental_patients pc WHERE parent_patientid IS NOT NULL AND parent_patientid != ''";
  $sql .= "ORDER BY ".$sort." ".$dir;
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
	Manage Patient Contacts
</span>
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
				 paging($no_pages,$index_val,"");
			?>
		</TD>
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
			<a href="manage_patient_changes.php?sort=name&sortdir=<?php echo ($_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contact Name</a>
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
					<?=st($myarray["firstname"]);?>&nbsp;
                    			<?=st($myarray["lastname"]);?> 
				</td>
				<td valign="top">
					<a href="#" onclick="loadPopup('patient_changes.php?pid=<?=$myarray['parent_patientid'];?>');return false;" class="editlink" title="EDIT">
					        View
					</a>
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
