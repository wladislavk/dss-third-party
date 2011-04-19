<? 
include "admin/includes/config.php";

if($_GET['pid'] <> '' && $_GET['fid'] == '')
{
	$p_form_sql = "select * from dental_forms where patientid='".s_for($_GET['pid'])."'";
	$p_form_my = mysql_query($p_form_sql);
	$p_form_myarray = mysql_fetch_array($p_form_my);
	
	$_GET['fid'] = $p_form_myarray['formid'];
}

$form_sql = "select * from dental_forms where formid='".s_for($_GET['fid'])."'";
$form_my = mysql_query($form_sql);
$form_myarray = mysql_fetch_array($form_my);

$pat_sql = "select * from dental_patients where patientid='".s_for($form_myarray['patientid'])."'";
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


$sql = "select * from dental_thorton where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$thortonid = st($myarray['thortonid']);
$snore_1 = st($myarray['snore_1']);
$snore_2 = st($myarray['snore_2']);
$snore_3 = st($myarray['snore_3']);
$snore_4 = st($myarray['snore_4']);
$snore_5 = st($myarray['snore_5']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?> | <?=$name;?> - Questionnaire </title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>
<table width="780" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" > 

<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
	    <td> 
<br />
<span class="admin_head">
	Thorton Snoring Scale
</span>

<br />
<script type="text/javascript">
	function cal_snore()
	{
		var fa = document.selfrm;
		
		var tot = parseInt(fa.snore_1.value) + parseInt(fa.snore_2.value) + parseInt(fa.snore_3.value) + parseInt(fa.snore_4.value) + parseInt(fa.snore_5.value); 
		
		fa.tot_score.value = tot;
	}
</script>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<br>

<form name="selfrm" action="<?=$_SERVER['PHP_SELF']?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post">

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td valign="top" colspan="2" >
			Using the following scale, choose the most appropriate number for each situation.

			<br />
			0 = Never<br />
			1 = Infrequently (1 night per week)<br />
			2 = Frequently (2-3 nights per week)<br />
			3 = Most of the time (4 or more nights)<br />
		</td>
	</tr>
	<tr>
		<td valign="top" width="60%" class="frmhead">
			1. My snoring affects my relationship with my partner:
		</td>
		<td valign="top" class="frmdata">
			<select name="snore_1" onChange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
				<option value="0" <? if($snore_1 == 0) echo " selected";?>>0</option>
				<option value="1" <? if($snore_1 == 1) echo " selected";?>>1</option>
				<option value="2" <? if($snore_1 == 2) echo " selected";?>>2</option>
				<option value="3" <? if($snore_1 == 3) echo " selected";?>>3</option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead">
			2. My snoring causes my partner to be irritable or tired:
		</td>
		<td valign="top" class="frmdata">
			<select name="snore_2" onChange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
				<option value="0" <? if($snore_2 == 0) echo " selected";?>>0</option>
				<option value="1" <? if($snore_2 == 1) echo " selected";?>>1</option>
				<option value="2" <? if($snore_2 == 2) echo " selected";?>>2</option>
				<option value="3" <? if($snore_2 == 3) echo " selected";?>>3</option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead">
			3. My snoring requires us to sleep in separate rooms:
		</td>
		<td valign="top" class="frmdata">
			<select name="snore_3" onChange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
				<option value="0" <? if($snore_3 == 0) echo " selected";?>>0</option>
				<option value="1" <? if($snore_3 == 1) echo " selected";?>>1</option>
				<option value="2" <? if($snore_3 == 2) echo " selected";?>>2</option>
				<option value="3" <? if($snore_3 == 3) echo " selected";?>>3</option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead">
			4. My snoring is loud:
		</td>
		<td valign="top" class="frmdata">
			<select name="snore_4" onChange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
				<option value="0" <? if($snore_4 == 0) echo " selected";?>>0</option>
				<option value="1" <? if($snore_4 == 1) echo " selected";?>>1</option>
				<option value="2" <? if($snore_4 == 2) echo " selected";?>>2</option>
				<option value="3" <? if($snore_4 == 3) echo " selected";?>>3</option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead">
			5. My snoring affects people when I am sleeping away from home:
		</td>
		<td valign="top" class="frmdata">
			<select name="snore_5" onChange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
				<option value="0" <? if($snore_5 == 0) echo " selected";?>>0</option>
				<option value="1" <? if($snore_5 == 1) echo " selected";?>>1</option>
				<option value="2" <? if($snore_5 == 2) echo " selected";?>>2</option>
				<option value="3" <? if($snore_5 == 3) echo " selected";?>>3</option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead">
			Your Score:
		</td>
		<td valign="top" class="frmdata">
			<input type="text" name="tot_score" value="0" class="tbox" style="width:80px;" readonly="readonly" >
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmdata" colspan="2" style="text-align:right;">
			<b>A score of 5 or greater indicates your snoring may be significantly affecting your quality of life.	</b>
		</td>
	</tr>
	
</table>
</form>
<script type="text/javascript">
	cal_snore();
</script>
<br /><br />	

			</td>
		</tr>
	</table>
    

</body>
</html>