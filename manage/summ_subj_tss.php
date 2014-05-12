<?php
require_once 'admin/includes/config.php';
require_once 'admin/includes/general.htm';
if($_POST['q_sleepsub'] == 1)
{

$snore_1 = $_POST['snore_1'];
$snore_2 = $_POST['snore_2'];
$snore_3 = $_POST['snore_3'];
$snore_4 = $_POST['snore_4'];
$snore_5 = $_POST['snore_5'];
$tot_score = $snore_1 + $snore_2 + $snore_3 + $snore_4 + $snore_5;
                        ?>
                          <script type="text/javascript">
                                parent.update_tss('<?= $_REQUEST['id']; ?>', '<?= $snore_1; ?>', '<?= $snore_2; ?>', '<?= $snore_3; ?>', '<?= $snore_4; ?>', '<?= $snore_5; ?>', '<?= $tot_score; ?>');
				//parent.disablePopup();
                          </script>
                        <?php
}

$sql = "select * from dental_thorton where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$thortonid = st($myarray['thortonid']);
$snore_1 = 0;//st($myarray['snore_1']);
$snore_2 = 0;//st($myarray['snore_2']);
$snore_3 = 0;//st($myarray['snore_3']);
$snore_4 = 0;//st($myarray['snore_4']);
$snore_5 = 0;//st($myarray['snore_5']);

                                $a_sql = "SELECT answer, thorntonid FROM dentalsummfu_tss
                                                WHERE
                                                        followupid='".mysql_real_escape_string($_GET['id'])."';";
                                $a_q = mysql_query($a_sql);
                                while($a = mysql_fetch_assoc($a_q)){
                                  ${'snore_'.$a['thorntonid']} = $a['answer'];
				}


$sql = "select * from dental_q_sleep where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_sleepid = st($myarray['q_sleepid']);
$epworthid = st($myarray['epworthid']);
$analysis = st($myarray['analysis']);

if($epworthid <> '')
{	
$epworth_arr1 = split('~',$epworthid);

foreach($epworth_arr1 as $i => $val)
{
	$epworth_arr2 = explode('|',$val);
	
	$epid[$i] = $epworth_arr2[0];
	$epseq[$i] = $epworth_arr2[1];
}
}

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup2.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>



<form id="q_sleepfrm" name="q_sleepfrm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>&id=<?=$_GET['id']; ?>" method="post">
<input type="hidden" name="q_sleepsub" value="1" />

<div align="right">
<input type="submit" name="q_sleepbtn" value="Save" />
&nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">

<tr>
<td valign="top" class="frmhead">
<tr>
<td valign="top" class="frmhead" style="text-align:center;">


<tr>
<td valign="top" class="frmhead" style="text-align:center;">
<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
<tr bgcolor="#FFFFFF">
    <td>
<br />
<span class="admin_head">
Thornton Snoring Scale
</span>

<br />

<input type="hidden" name="thortonsub" value="1" />
<input type="hidden" name="ted" value="<?=$thortonid;?>" />
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
		<select id="snore_1" name="snore_1" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
		<select id="snore_2" name="snore_2" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
		<select id="snore_3" name="snore_3" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
		<select id="snore_4" name="snore_4" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
		<select id="snore_5" name="snore_5" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
			<option value="0" <? if($snore_5 == 0) echo " selected";?>>0</option>
			<option value="1" <? if($snore_5 == 1) echo " selected";?>>1</option>
			<option value="2" <? if($snore_5 == 2) echo " selected";?>>2</option>
			<option value="3" <? if($snore_5 == 3) echo " selected";?>>3</option>
		</select>
	</td>
</tr>
</table>
<br /><br />

		</td>
	</tr>
</table>










	</td>
</tr>    
</table>

<div align="right">
<input type="submit" name="q_pagebtn" value="Save" />
&nbsp;&nbsp;&nbsp;
</div>
</form>
<script type="text/javascript">
  v = parent.top.$('#thornton_<?=$_GET['id'];?>_1').val();
  $('#snore_1').val(v);
  v = parent.top.$('#thornton_<?=$_GET['id'];?>_2').val();
  $('#snore_2').val(v);
  v = parent.top.$('#thornton_<?=$_GET['id'];?>_3').val();
  $('#snore_3').val(v);
  v = parent.top.$('#thornton_<?=$_GET['id'];?>_4').val();
  $('#snore_4').val(v);
  v = parent.top.$('#thornton_<?=$_GET['id'];?>_5').val();
  $('#snore_5').val(v);
</script>



