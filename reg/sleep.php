<?php 
include "includes/header.php";
?>
<script type="text/javascript">
edited = false;
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			edited = true;
			//window.onbeforeunload = confirmExit;
		});
		$('#q_sleepfrm').submit(function() {
				window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['q_sleepsub'] == 1)
{
	$epworth_sql = "select * from dental_epworth where status=1 order by sortby";
	$epworth_my = mysql_query($epworth_sql);
	
	$epworth_arr = '';
	
	while($epworth_myarray = mysql_fetch_array($epworth_my))
	{
		if($_POST['epworth_'.$epworth_myarray['epworthid']] <> '')
		{
			$epworth_arr .= $epworth_myarray['epworthid'].'|'.$_POST['epworth_'.$epworth_myarray['epworthid']].'~';
		}
	}
	
	$analysis = $_POST['analysis'];
        $snore_1 = $_POST['snore_1'];
        $snore_2 = $_POST['snore_2'];
        $snore_3 = $_POST['snore_3'];
        $snore_4 = $_POST['snore_4'];
        $snore_5 = $_POST['snore_5'];
        $tot_score = $_POST['tot_score'];
	
	/*echo "epworthid - ".$epworth_arr."<br>";
	echo "analysis - ".$analysis."<br>";*/
	
	
		$ed_sql = " update dental_q_sleep set 
		epworthid = '".s_for($epworth_arr)."',
		analysis = '".s_for($analysis)."'
		where q_sleepid = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		$ed_sql = " update dental_thorton set 
                snore_1 = '".s_for($snore_1)."',
                snore_2 = '".s_for($snore_2)."',
                snore_3 = '".s_for($snore_3)."',
                snore_4 = '".s_for($snore_4)."',
                snore_5 = '".s_for($snore_5)."',
                tot_score = '".s_for($tot_score)."'
                where thortonid = '".s_for($_POST['ted'])."'";

                mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

		$ed_sql = "update dental_q_page1 set
			ess='".mysql_real_escape_string($_POST['epTot'])."',
			tss='".s_for($tot_score)."'
			WHERE patientid='".$_SESSION['pid']."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		//echo $ed_sql;
		$msg = " Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='sleep.php?msg=<?=$msg;?>';
		</script>
		<?
		die();
}

$sql = "select * from dental_thorton where patientid='".$_SESSION['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$thortonid = st($myarray['thortonid']);
$snore_1 = st($myarray['snore_1']);
$snore_2 = st($myarray['snore_2']);
$snore_3 = st($myarray['snore_3']);
$snore_4 = st($myarray['snore_4']);
$snore_5 = st($myarray['snore_5']);
$tot_score = st($myarray['tot_score']);

$pat_sql = "select * from dental_patients where patientid='".s_for($_SESSION['pid'])."'";
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

$sql = "select * from dental_q_sleep where patientid='".$_SESSION['pid']."'";
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

<a name="top"></a>
<?php include 'includes/questionnaire_header.php'; ?>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form id="q_sleepfrm" name="q_sleepfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<input type="hidden" name="q_sleepsub" value="1" />
<input type="hidden" name="ed" value="<?=$q_sleepid;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
	<input type="reset" value="Reset Values to Zero" />
	<input type="submit" name="q_sleepbtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    
    <tr>
        <td valign="top" class="frmhead">
    <tr>
        <td valign="top" class="frmhead" style="text-align:center;">
<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
            <td>
<br />
<span class="admin_head">
Epworth Sleep Questionnaire
</span>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr>
                <td valign="top" colspan="2" >
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        0 = No chance of dozing<br />
                        1 = Slight chance of dozing<br />
                        2 = Moderate chance of dozing<br />
                        3 = High chance of dozing<br />
                </td>
        </tr>
                    <? 
					$epworth_sql = "select * from dental_epworth where status=1 order by sortby";
					$epworth_my = mysql_query($epworth_sql);
					$epworth_number = mysql_num_rows($epworth_my);
					?>
                    
                        	<script type="text/javascript">
								function cal_analaysis(fa)
								{
									var an_tot = 0;
									/*									
									alert(document.q_sleepfrm.elements.length);
									for(i=0; i<document.q_sleepfrm.elements.length; i++)
									{
										if(document.q_sleepfrm.elements[i].type == 'select-one')
										{
											if(document.q_sleepfrm.elements[i].value != '')
											{
												an_tot = an_tot + parseInt(document.q_sleepfrm.elements[i].value, 10);
											}
										}
									}
									*/
									an_tot += parseInt($('#epworth_1').val());
                                                                        an_tot += parseInt($('#epworth_3').val());
                                                                        an_tot += parseInt($('#epworth_4').val());
                                                                        an_tot += parseInt($('#epworth_5').val());
                                                                        an_tot += parseInt($('#epworth_6').val());
                                                                        an_tot += parseInt($('#epworth_7').val());
                                                                        an_tot += parseInt($('#epworth_8').val());
									if(an_tot < 8)
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a normal amount of sleepiness.';
									}
									
									if (an_tot >= 8 && an_tot < 10)
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a average amount of sleepiness.';
									}
									
									if (an_tot >= 10 && an_tot < 16)
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which may indicate excessive sleepiness depending on the situation. The patient may want to seek medical attention.';
									}
									
									if (an_tot >= 16 )
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which indicates excessive sleepiness and medical attention should be sought.';
									}
									
									document.q_sleepfrm.analysis.value = an_text;
									document.q_sleepfrm.epTot.value = an_tot;
									//alert("Tot: " + an_tot+"\nText: "+an_text);
								}
							</script>
                    <?
                                        while($epworth_myarray = mysql_fetch_array($epworth_my))
                                        {
                                                if(@array_search($epworth_myarray['epworthid'],$epid) === false)
                                                {
                                                        $chk = '';
                                                }
                                                else
                                                {
                                                        $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];                                                }

                                        ?>

                            <tr>
                <td valign="top" width="60%" class="frmhead">        
			<?=st($epworth_myarray['epworth']);?><br />&nbsp;
		</td>
                <td valign="top" class="frmdata">
                        	<select id="epworth_<?=st($epworth_myarray['epworthid']);?>" name="epworth_<?=st($epworth_myarray['epworthid']);?>" class="field text addr tbox" style="width:125px;" onchange="cal_analaysis(this.value);">
                                <option value="0" <? if($chk == '0') echo " selected";?>>0</option>
                                <option value="1" <? if($chk == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($chk == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($chk == 3) echo " selected";?>>3</option>
                            </select>
                        </td>
                    </tr>
                    <? }?>
                    <tr>
                        <td colspan="2">
                        	<span style="color:#000000; padding-top:0px;">
                            	Analysis
                            </span>
                            <br />
                            <textarea name="analysis" class="field text addr tbox" style="width:650px; height:100px;"><?=$analysis;?></textarea>
			    <input type="hidden" name="epTot" />
                        </td>
                    </tr>
</table>
<script type="text/javascript">
cal_analaysis(0);
</script>
</td></tr> 
</table>
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
<script type="text/javascript">
        function cal_snore()
        {
                var fa = document.q_sleepfrm;
                
                var tot = parseInt(fa.snore_1.value) + parseInt(fa.snore_2.value) + parseInt(fa.snore_3.value) + parseInt(fa.snore_4.value) + parseInt(fa.snore_5.value); 
                
                fa.tot_score.value = tot;
        }
</script>
<br>

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
                        <select name="snore_1" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
                        <select name="snore_2" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
                        <select name="snore_3" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
                        <select name="snore_4" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
                        <select name="snore_5" onchange="Javascript: cal_snore()" class="tbox" style="width:80px;">
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
                        <input type="text" name="tot_score" value="<?= $tot_score; ?>" class="tbox" style="width:80px;" readonly="readonly" >
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmdata" colspan="2" style="text-align:right;">
                        <b>A score of 5 or greater indicates your snoring may be significantly affecting your quality of life.  </b>
                </td>
        </tr>
</table>
<script type="text/javascript">
  $('document').ready( function(){
        cal_snore();
 });
</script>
<br /><br />

                        </td>
                </tr>
        </table>










		</td>
	</tr>    
</table>

<div align="right">
	<input type="reset" value="Reset Values to Zero" />
    <input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>

<? include "includes/footer.php";?>

