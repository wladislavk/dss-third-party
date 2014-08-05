<? 
include "includes/top.htm"; 
require_once('includes/patient_info.php');
if ($patient_info) {

if($_POST['q_recipientssub'] == 1)
{
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
	</script>
	<?
	die();
}

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_q_image where imageid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		window.location="<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>";
	</script>
	<?
	die();
}


//$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}

$sql = "select i.*,
	CASE 
		WHEN i.userid!=''
		THEN CONCAT(u.first_name, ' ',u.last_name)
		WHEN i.adminid!=''
		THEN CONCAT(a.first_name, ' ',a.last_name)
	END added_by

	 from dental_q_image i
	LEFT join dental_users u ON u.userid=i.userid
	LEFT join admin a ON a.adminid=i.adminid
	where i.patientid='".$_GET['pid']."'";
if($_GET['sh'] <> '')
	$sql .= " and imagetypeid='".$_GET['sh']."' ";

If(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'adddate';
}
If(!isset($_REQUEST['sortdir'])){
  $_REQUEST['sortdir'] = 'DESC';
}
$sql .= " order by ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
$my = mysql_query($sql);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup2.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>

<!--<div style="visibility:hidden; height:10px;"><?php //include("includes/form_top.htm");?></div>-->
&nbsp;&nbsp;
<b>Show Image Type</b>
&nbsp;&nbsp;
<? 
$itype_sql = "select * from dental_imagetype where status=1 order by sortby";
$itype_my = mysql_query($itype_sql); 
?>
<select name="imagetypeid" class="field text addr tbox" onchange="Javascript: window.location='<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid'];?>&sh='+this.value;">
	<option value="">All</option>
	<? while($itype_myarray = mysql_fetch_array($itype_my))
	{?>
		<option value="<?=st($itype_myarray['imagetypeid']);?>" <? if($_GET['sh'] == st($itype_myarray['imagetypeid'])) echo " selected";?>>
			<?=st($itype_myarray['imagetype']);?>
		</option>
	<? }?>
</select>
<br />
<div align="right">
	<button onclick="Javascript: loadPopupRefer('add_image.php?pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>&flow=<?=$_GET['flow'];?>');" class="addButton">
		Add New Image
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>


<form name="q_imagefrm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>&sh=<?=$_GET['sh'];?>" method="post" >
<input type="hidden" name="q_recipientssub" value="1" />
<input type="hidden" name="ed" value="<?=$q_recipientsid;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<?php include 'partials/patient_images.php'; ?>
</form>
<br />
<div style="visibility:hidden;"><? include("includes/form_bottom.htm");?></div>
<br />


<div id="popupMemo" style="width:750px;z-index:5000; position:absolute;height:400px;display:none;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<div id="popupRefer" style="width:750px;height:430px">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>

<br /><br />	

<?php

} else {  // end pt info check
	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}

?>

<? include "includes/bottom.htm";?>
