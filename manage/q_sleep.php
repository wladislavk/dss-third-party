<?php 
include "includes/top.htm";
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input :not(#patient_search)').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#q_sleepfrm').submit(function() {
			if($('#iframestatus').val() == "dirty") {
				window.onbeforeunload = confirmExit;
			} else {
				window.onbeforeunload = null;
			}
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
	
	/*echo "epworthid - ".$epworth_arr."<br>";
	echo "analysis - ".$analysis."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_q_sleep set 
		formid = '".s_for($_GET['fid'])."',
		patientid = '".s_for($_GET['pid'])."',
		epworthid = '".s_for($epworth_arr)."',
		analysis = '".s_for($analysis)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_sleep set 
		epworthid = '".s_for($epworth_arr)."',
		analysis = '".s_for($analysis)."'
		where q_sleepid = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql;
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


$form_sql = "select * from dental_forms where formid='".s_for($_GET['fid'])."'";
$form_my = mysql_query($form_sql);
$form_myarray = mysql_fetch_array($form_my);

if($form_myarray['formid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_forms.php?pid=<?=$_GET['pid'];?>';
	</script>
	<?
	die();
}

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

$sql = "select * from dental_q_sleep where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
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
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup2.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;
<a href="manage_forms.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back To Forms</b></a>
<br />

<? include("includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form id="q_sleepfrm" name="q_sleepfrm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="q_sleepsub" value="1" />
<input type="hidden" name="ed" value="<?=$q_sleepid;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
	<input type="reset" value="Reset" />
	<input type="submit" name="q_sleepbtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <tr>
        <td colspan="2" class="sub_head">
           Epworth Sleep Questionnaire
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <? 
					$epworth_sql = "select * from dental_epworth where status=1 order by sortby";
					$epworth_my = mysql_query($epworth_sql);
					$epworth_number = mysql_num_rows($epworth_my);
					?>
                    
                    <br />
                    <? 
					while($epworth_myarray = mysql_fetch_array($epworth_my))
					{
						if(@array_search($epworth_myarray['epworthid'],$epid) === false)
						{
							$chk = '';
						}
						else
						{
							$chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
						}
						
					?>
                    <div>
                        <span>
                        	<script type="text/javascript">
								function cal_analaysis(fa)
								{
									var an_tot = 0;
									for(i=0; i<document.q_sleepfrm.elements.length; i++)
									{
										if(document.q_sleepfrm.elements[i].type == 'select-one')
										{
											if(document.q_sleepfrm.elements[i].value != '')
											{
												an_tot = an_tot + parseInt(document.q_sleepfrm.elements[i].value);
											}
										}
									}
									
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
									//alert("Tot: " + an_tot+"\nText: "+an_text);
								}
							</script>
                            
                        	<select id="epworth_<?=st($epworth_myarray['epworthid']);?>" name="epworth_<?=st($epworth_myarray['epworthid']);?>" class="field text addr tbox" style="width:225px;" onchange="cal_analaysis(this.value);">
                            	<option value="" <? if($chk == '') echo " selected";?>></option>
                                <option value="0" <? if($chk == '0') echo " selected";?>>0 - No chance of dozing</option>
                                <option value="1" <? if($chk == 1) echo " selected";?>>1 - Slight chance of dozing</option>
                                <option value="2" <? if($chk == 2) echo " selected";?>>2 - Moderate chance of dozing</option>
                                <option value="3" <? if($chk == 3) echo " selected";?>>3 - High chance of dozing</option>
                            </select>
                            &nbsp;&nbsp;
                            <?=st($epworth_myarray['epworth']);?><br />&nbsp;
                        </span>
                    </div>
                    <? }?>
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Analysis
                            </span>
                            <br />
                            <textarea name="analysis" class="field text addr tbox" style="width:650px; height:100px;"><?=$analysis;?></textarea>
                        </span>
                    </div>
                    <br />
                </li>
           	</ul>
		</td>
	</tr>
    
	<tr>
        <td valign="top" class="frmhead" style="text-align:center;">
			<input id="iframestatus" name="iframestatus" type="hidden" />
			<iframe src="thorton.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" width="98%" height="420px;">Your Browser Does Not Support Iframes</iframe>
		</td>
	</tr>    
</table>

<div align="right">
	<input type="reset" value="Reset" />
    <input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>

<br />
<? include("includes/form_bottom.htm");?>
<br />


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
