<?php namespace Ds3\Libraries\Legacy; ?><? 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");


$sql = "select * from dental_doc_marketing where doc_marketingid='".s_for($_GET['id'])."'";
$my = mysqli_query($con, $sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
$myarray = mysqli_fetch_array($my);
$num_users=mysqli_num_rows($my);

if(st($myarray['title']) == '')
{
	?>
	<script type="text/javascript">	
		parent.disablePopup1();
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/form.css" type="text/css" />
	<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
	<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
	<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<table width="700" border="0" align="center" cellpadding="5" cellspacing="1" class="em_box">
  <tr>
    <td class="em_boxhead" valign="top">Marketing Materials
	-
	<i>
	<?=st($myarray['title']);?>
    </i></td>
  </tr>
  <tr>
    <td valign="top" height="350">


<? if(st($myarray['doc_file']) <> '') {?>
	<div align="right">
		<a href="doc_file/<?=st($myarray['doc_file'])?>" target="_blank" class="view_red" title="EDIT">
			<b>View / Download Related Document</b></a>
	</div>
<? }?>

<?=html_entity_decode(st($myarray['description']));?>

<?
if(st($myarray['video_file']) != '')
{?>
	<center>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="414" height="340">
		<param name="movie" value="video_lounge_with_fullscreen.swf" />
		<param name="quality" value="high" />
		<param name="menu" value="false" />
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="FlashVars" value="flv_name=video_file/<?=st($myarray['video_file'])?>" />
		<embed src="video_lounge_with_fullscreen.swf" width="414" height="340" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" flashvars="flv_name=video_file/<?=st($myarray['video_file'])?>" allowScriptAccess="sameDomain"></embed>
	</object>
	</center>
<? 
}
?>
</td>
  </tr>
</table>
	
</body>
</html>
