<?php
include "admin/includes/main_include.php";
?>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
  <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input').change(function() { 
			parent.window.onbeforeunload = confirmExit;
			parent.document.q_sleepfrm.iframestatus.value = "dirty";
		});
		$('#selfrm').submit(function() {
			parent.document.q_sleepfrm.iframestatus.value = "clean";
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['thortonsub'] == 1)
{
	$snore_1 = $_POST['snore_1'];
	$snore_2 = $_POST['snore_2'];
	$snore_3 = $_POST['snore_3'];
	$snore_4 = $_POST['snore_4'];
	$snore_5 = $_POST['snore_5'];
	$tot_score = $_POST['tot_score'];
	
	/*echo "snore_1 - ".$snore_1."<br>";
	echo "snore_2 - ".$snore_2."<br>";
	echo "snore_3 - ".$snore_3."<br>";
	echo "snore_4 - ".$snore_4."<br>";
	echo "snore_5 - ".$snore_5."<br>";
	echo "tot_score - ".$tot_score."<br>";*/
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_thorton set 
		patientid = '".s_for($_GET['pid'])."',
		snore_1 = '".s_for($snore_1)."',
		snore_2 = '".s_for($snore_2)."',
		snore_3 = '".s_for($snore_3)."',
		snore_4 = '".s_for($snore_4)."',
		snore_5 = '".s_for($snore_5)."',
		tot_score = '".s_for($tot_score)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_thorton set 
		snore_1 = '".s_for($snore_1)."',
		snore_2 = '".s_for($snore_2)."',
		snore_3 = '".s_for($snore_3)."',
		snore_4 = '".s_for($snore_4)."',
		snore_5 = '".s_for($snore_5)."',
		tot_score = '".s_for($tot_score)."'
		where thortonid = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}

$sql = "select * from dental_thorton where patientid='".$_GET['pid']."'";
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
<title><?=$sitename;?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

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

<form id="selfrm" name="selfrm" action="<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="thortonsub" value="1" />
<input type="hidden" name="ed" value="<?=$thortonid;?>" />
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
			<select name="snore_1" onchange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
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
			<select name="snore_2" onchange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
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
			<select name="snore_3" onchange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
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
			<select name="snore_4" onchange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
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
			<select name="snore_5" onchange="Jacasvript: cal_snore()" class="tbox" style="width:80px;">
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
	<tr>
		<td valign="top" colspan="2" style="text-align:center;">
			<input type="submit" name="thortonbtn" value="Save" />
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
