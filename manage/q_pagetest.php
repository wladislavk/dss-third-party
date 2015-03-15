<?php namespace Ds3\Legacy; ?><? 
include "includes/top2.htm";

if($_POST['q_page1sub'] == 1)
{
	$feet = $_POST['feet'];
	$inches = $_POST['inches'];
	$weight = $_POST['weight'];
	$bmi = $_POST['bmi'];
	
	$complaint_sql = "select * from dental_complaint where status=1 order by sortby";
	$complaint_my = mysql_query($complaint_sql);
	
	$comp_arr = '';
	
	while($complaint_myarray = mysql_fetch_array($complaint_my))
	{
		if($_POST['complaint_'.$complaint_myarray['complaintid']] <> '')
		{
			$comp_arr .= $complaint_myarray['complaintid'].'|'.$_POST['complaint_'.$complaint_myarray['complaintid']].'~';
		}
	}
	
	$other_complaint = $_POST['other_complaint'];
	$additional_paragraph = $_POST['additional_paragraph'];
	
	$energy_level = $_POST['energy_level'];
	$snoring_sound = $_POST['snoring_sound'];
	$breathing_night = $_POST['breathing_night'];
	$wake_night = $_POST['wake_night'];
	$morning_headaches = $_POST['morning_headaches'];
	$hours_sleep = $_POST['hours_sleep'];
	$quit_breathing = $_POST['quit_breathing'];
	$bed_time_partner = $_POST['bed_time_partner'];
	$sleep_qual = $_POST['sleep_qual'];
	$sleep_same_room = $_POST['sleep_same_room'];
	$told_you_snore = $_POST['told_you_snore'];
	$main_reason = $_POST['main_reason'];
	$main_reason_other = $_POST['main_reason_other'];
	
	$main_reason_arr = '';
	if(is_array($main_reason))
	{
		foreach($main_reason as $val)
		{
			if(trim($val) <> '')
				$main_reason_arr .= trim($val).'~';
		}
	}
	if($main_reason_arr != '')
		$main_reason_arr = '~'.$main_reason_arr;
	
	/*
	echo "feet - ".$feet."<br>";
	echo "inches - ".$inches."<br>";
	echo "weight - ".$weight."<br>";
	echo "bmi - ".$bmi."<br>";
	echo "complaintid - ".$comp_arr ."<br>";
	echo "other_complaint - ".$other_complaint ."<br>";
	echo "additional_paragraph - ".$additional_paragraph ."<br>";
	echo "energy_level - ".$energy_level ."<br>";
	echo "snoring_sound - ".$snoring_sound ."<br>";
	echo "wake_night - ".$wake_night ."<br>";
	echo "breathing_night - ".$breathing_night ."<br>";
	echo "morning_headaches - ".$morning_headaches ."<br>";
	echo "hours_sleep - ".$hours_sleep ."<br>";
	echo "quit_breathing - ".$quit_breathing ."<br>";
	echo "bed_time_partner - ".$bed_time_partner ."<br>";
	echo "sleep_same_room - ".$sleep_same_room ."<br>";
	echo "told_you_snore - ".$told_you_snore ."<br>";
	echo "main_reason - ".$main_reason_arr ."<br>";
	echo "main_reason_other - ".$main_reason_other."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_q_page1 set 
		patientid = '".s_for($_GET['pid'])."',
		feet = '".s_for($feet)."',
		inches = '".s_for($inches)."',
		weight = '".s_for($weight)."',
		bmi = '".s_for($bmi)."',
		sleep_qual = '".s_for($sleep_qual)."',
		complaintid = '".s_for($comp_arr)."',
		other_complaint = '".s_for($other_complaint)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		energy_level = '".s_for($energy_level)."',
		snoring_sound = '".s_for($snoring_sound)."',
		wake_night = '".s_for($wake_night)."',
		breathing_night = '".s_for($breathing_night)."',
		morning_headaches = '".s_for($morning_headaches)."',
		hours_sleep = '".s_for($hours_sleep)."',
		quit_breathing = '".s_for($quit_breathing)."',
		bed_time_partner = '".s_for($bed_time_partner)."',
		sleep_same_room = '".s_for($sleep_same_room)."',
		told_you_snore = '".s_for($told_you_snore)."',
		main_reason = '".s_for($main_reason_arr)."',
		main_reason_other = '".s_for($main_reason_other)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>#form';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page1 set 
		feet = '".s_for($feet)."',
		inches = '".s_for($inches)."',
		weight = '".s_for($weight)."',
		bmi = '".s_for($bmi)."',
		complaintid = '".s_for($comp_arr)."',
		sleep_qual = '".s_for($sleep_qual)."',
		other_complaint = '".s_for($other_complaint)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		energy_level = '".s_for($energy_level)."',
		snoring_sound = '".s_for($snoring_sound)."',
		wake_night = '".s_for($wake_night)."',
		breathing_night = '".s_for($breathing_night)."',
		morning_headaches = '".s_for($morning_headaches)."',
		hours_sleep = '".s_for($hours_sleep)."',
		quit_breathing = '".s_for($quit_breathing)."',
		bed_time_partner = '".s_for($bed_time_partner)."',
		sleep_same_room = '".s_for($sleep_same_room)."',
		told_you_snore = '".s_for($told_you_snore)."',
		main_reason = '".s_for($main_reason_arr)."',
		main_reason_other = '".s_for($main_reason_other)."'
		where q_page1id = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>#form';
		</script>
		<?
		die();
	}
}

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
$sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page1id = st($myarray['q_page1id']);
$feet = st($myarray['feet']);
$inches = st($myarray['inches']);
$weight = st($myarray['weight']);
$bmi = st($myarray['bmi']);
$complaintid = st($myarray['complaintid']);
$other_complaint = st($myarray['other_complaint']);
$additional_paragraph = st($myarray['additional_paragraph']);
$energy_level = st($myarray['energy_level']);
$snoring_sound = st($myarray['snoring_sound']);
$wake_night = st($myarray['wake_night']);
$breathing_night = st($myarray['breathing_night']);
$morning_headaches = st($myarray['morning_headaches']);
$hours_sleep = st($myarray['hours_sleep']);
$quit_breathing = st($myarray['quit_breathing']);
$bed_time_partner = st($myarray['bed_time_partner']);
$sleep_same_room = st($myarray['sleep_same_room']);
$told_you_snore = st($myarray['told_you_snore']);
$main_reason = st($myarray['main_reason']);
$main_reason_other = st($myarray['main_reason_other']);
$sleep_qual = st($myarray['sleep_qual']);


if($complaintid <> '')
{	
	$comp_arr1 = split('~',$complaintid);
	
	foreach($comp_arr1 as $i => $val)
	{
		$comp_arr2 = explode('|',$val);
		
		$compid[$i] = $comp_arr2[0];
		$compseq[$i] = $comp_arr2[1];
	}
}

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

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

<script type="text/javascript">
	function chk_chief(sel_val,comp_id)
	{
		fa = document.q_page1frm;
		
		same = 0;
		<? 
		$complaint_sql = "select * from dental_complaint where status=1 order by sortby";
		$complaint_my = mysql_query($complaint_sql);
		
		while($complaint_myarray = mysql_fetch_array($complaint_my))
		{?>
		if(comp_id != <?=st($complaint_myarray['complaintid']);?>)
		{
			if(fa.complaint_<?=st($complaint_myarray['complaintid']);?>.value == sel_val && fa.complaint_<?=st($complaint_myarray['complaintid']);?>.value != '')
			{
				same = 1;
			}
		}
		<?
		}
		?>
		
		if(same == 1)
		{
			alert("Duplicate Sequence, Please Select another Sequence");
			eval("fa.complaint_"+comp_id).value = '';
			eval("fa.complaint_"+comp_id).focus();
		}
		
	}
</script>

<form name="q_page1frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="q_page1sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page1id;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
	<input type="reset" value="Reset" />
	<input type="submit" name="q_pagebtn" value="Save" /> 
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <tr>
        <td colspan="2" class="sub_head">
           Additional Patient Information
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<script type="text/javascript">
				function cal_bmi()
				{
					fa = document.q_page1frm;
					if(fa.feet.value != 0 && fa.inches.value != 0 && fa.weight.value != 0)
					{
						var inc = (parseInt(fa.feet.value) * 12) + parseInt(fa.inches.value);
						//alert(inc);
						
						var inc_sqr = parseInt(inc) * parseInt(inc);
						var wei = parseInt(fa.weight.value) * 703;
						var bmi = parseInt(wei) / parseInt(inc_sqr);
						
						//alert("BMI " + bmi.toFixed(2));
						fa.bmi.value = bmi.toFixed(1);
					}
					else
					{
						fa.bmi.value = '';
					}
				}
			</script>
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Body Mass Index Calculation
                    </label>
                    <div>
                        <span>
                            <select name="feet" id="feet" class="field text addr tbox" style="width:100px;" tabindex="5" onchange="cal_bmi();" >
                            	<option value="0">Feet</option>
                            	<? for($i=1;$i<9;$i++)
								{
								?>
									<option value="<?=$i?>" <? if($feet == $i) echo " selected";?>><?=$i?></option>
								<?
								}?>
                            </select>
                            <label for="feet">Feet</label>
                        </span>
                        
                        <span>
                            <select name="inches" id="inches" class="field text addr tbox" style="width:100px;" tabindex="6" onchange="cal_bmi();">
                            	<option value="0">Inches</option>
                            	<? for($i=1;$i<12;$i++)
								{
								?>
									<option value="<?=$i?>" <? if($inches == $i) echo " selected";?>><?=$i?></option>
								<?
								}?>
                            </select>
                            <label for="inches">Inches</label>
                        </span>
                        
                        <span>
                            <select name="weight" id="weight" class="field text addr tbox" style="width:100px;" tabindex="7" onchange="cal_bmi();">
                            	<option value="0">Weight</option>
                            	<? for($i=1;$i<800;$i++)
								{
								?>
									<option value="<?=$i?>" <? if($weight == $i) echo " selected";?>><?=$i?></option>
								<?
								}?>
                            </select>
                            <label for="inches">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </span>
                        
                        <span>
                        	<span style="color:#000000; padding-top:2px;">BMI</span>
                           	<input id="bmi" name="bmi" type="text" class="field text addr tbox" value="<?=$bmi?>" tabindex="8" maxlength="255" style="width:50px;" readonly="readonly" />
                        </span>
                        <span>
                        	<label for="inches"> 
                            	&lt; 18.5 is Underweight
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                18.5 - 24.9 is Normal 
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                25 - 29.9 is Overweight
                                <br />
                                &gt; 30 is Obese
                            </label>
                        </span>
                   </div>   
                </li>
            </ul>
            
        </td>
    </tr>
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
					<span class="form_info">Subjective</span>
                    <br />
                    <label class="desc" id="title0" for="Field0">
                        Chief Complaints
                    </label>
                    <? 
					$complaint_sql = "select * from dental_complaint where status=1 order by sortby";
					$complaint_my = mysql_query($complaint_sql);
					$complaint_number = mysql_num_rows($complaint_my);
					?>
                    <span class="form_info">
                    	Select Complaint Sequence from the DropDown or leave is Blank.
                    </span>
                    <br />
                    <? 
					while($complaint_myarray = mysql_fetch_array($complaint_my))
					{
						if(@array_search($complaint_myarray['complaintid'],$compid) === false)
						{
							$chk = '';
						}
						else
						{
							$chk = $compseq[@array_search($complaint_myarray['complaintid'],$compid)];
						}
						
					?>
                    <div>
                        <span>
                        	<select id="complaint_<?=st($complaint_myarray['complaintid']);?>" name="complaint_<?=st($complaint_myarray['complaintid']);?>" class="field text addr tbox" style="width:50px;" onchange="chk_chief(this.value,<?=st($complaint_myarray['complaintid']);?>)">
                            	<option value=""></option>
                            	<? 
								for($i=1;$i<=$complaint_number;$i++)
								{?>
                            		<option value="<?=$i;?>" <? if($chk == $i) echo " selected";?>><?=$i;?></option>
                                <? }?>
                            </select>
                            &nbsp;&nbsp;
                            <?=st($complaint_myarray['complaint']);?><br />&nbsp;
                        </span>
                    </div>
                    <? }?>
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each Complaint on Different Line)<br />
                            <textarea name="other_complaint" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_complaint;?></textarea>
                        </span>
                    </div>
                    <br />
                </li>
           	</ul>
		</td>
	</tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<a name="add_para"></a>
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Additional Paragraph
                        /
                        <button onclick="Javascript: loadPopup1('select_custom.php'); return false;">Custom Text</button>
                    </label>
                    
                    <div>
                    	<span>
                        	<textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                        </span>
                    </div>
                    <br />
                </li>
			</ul>
		</td>
	</tr> 
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        <!--Other Options
                        (**One or Other) -->
						Subjective Signs/Symptoms
                    </label>
                    
                    <div>
                    	<span class="full">
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0"> 
                            	<tr>
                                	<td valign="top" width="60%">
                                    	Rate your overall energy level 1 -10 (10 being the highest) 
                                    </td>
                                    <td valign="top">
                                    	<select name="energy_level" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=1;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($energy_level == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                                    </td>
                                </tr>
                                 								<tr>
                                	<td valign="top">
                                    	Have you been told you snore?
                                    </td>
                                    <td valign="top">
                                    	<select name="told_you_snore" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Yes" <? if($told_you_snore== 'Yes') echo " selected";?>>
                                            	Yes
                                            </option>
                                            <option value="No" <? if($told_you_snore == 'No') echo " selected";?>>
                                            	No
                                            </option>
                                            <option value="Sometimes" <? if($told_you_snore == 'Sometimes') echo " selected";?>>
                                            	Sometimes
                                            </option>
                                        </select>
                                    </td>
                                </tr>
								
                                <tr>
                                	<td valign="top">
                                    	Rate the sound of your snoring 1 -10 (10 being the highest) 
                                    </td>
                                    <td valign="top">
                                    	<select name="snoring_sound" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=1;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($snoring_sound == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                            <option value="Don't know">Don't know</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	On average how many times per night do you wake up?  
                                    </td>
                                    <td valign="top">
                                    	<select name="wake_night" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=1;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($wake_night == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                                    </td>
                                </tr>
                                <!--<tr>
                                	<td valign="top">
                                    	On average how many times per night does your bed time partner notice you quick breathing per night?
                                    </td>
                                    <td valign="top">
                                    	<select name="breathing_night" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=1;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($breathing_night == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                                    </td>
                                </tr> -->
                                <tr>
                                	<td valign="top">
                                    	How often do you wake up with morning headaches?
                                    </td>
                                    <td valign="top">
                                    	<select name="morning_headaches" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Most Mornings" <? if($morning_headaches == 'Most Mornings') echo " selected";?>>
                                            	Most Mornings
                                            </option>
                                            <option value="Several times per week" <? if($morning_headaches == 'Several times per week') echo " selected";?>>
                                            	Several times per week
                                            </option>
                                            <option value="Several times per month" <? if($morning_headaches == 'Several times per month') echo " selected";?>>
                                            	Several times per month
                                            </option>
                                            <option value="Occasionally" <? if($morning_headaches == 'Occasionally') echo " selected";?>>
                                            	Occasionally
                                            </option>
                                            <option value="Rarely" <? if($morning_headaches == 'Rarely') echo " selected";?>>
                                            	Rarely
                                            </option>
                                            <option value="Never" <? if($morning_headaches == 'Never') echo " selected";?>>
                                            	Never
                                            </option>
                                        </select>
                                    </td>
                                </tr>
								
                                <tr>
                                	<td valign="top">
                                    	On average how many hours of sleep do you get per night?
                                    </td>
                                    <td valign="top">
                                    	<select name="hours_sleep" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=1;$i<16;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($hours_sleep == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                                    </td>
                                </tr>
                                
                                                                <tr>
                                	<td valign="top">
                                    	Rate your sleep quality
                                    </td>
                                    <td valign="top">
                                    	<select name="sleep_qual" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=1;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($sleep_qual == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                                    </td>
                                </tr>
                                
                                								<tr>
                                	<td valign="top">
                                    	Do you have a bed time partner?
                                    </td>
                                    <td valign="top">
                                    	<select name="bed_time_partner" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Yes" <? if($bed_time_partner== 'Yes') echo " selected";?>>
                                            	Yes
                                            </option>
                                            <option value="No" <? if($bed_time_partner == 'No') echo " selected";?>>
                                            	No
                                            </option>
                                            <option value="Sometimes" <? if($bed_time_partner == 'Sometimes') echo " selected";?>>
                                            	Sometimes
                                            </option>
                                        </select>
                                    </td>
                                </tr>
								<tr>
                                	<td valign="top">
                                    	How many times per night does bedtime partner notice you quit breathing?
                                    </td>
                                    <td valign="top">
                                    	<select name="quit_breathing" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Several times per night" <? if($quit_breathing== 'Several times per night') echo " selected";?>>
                                            	Several times per night
                                            </option>
                                            <option value="One time per night" <? if($quit_breathing == 'One time per night') echo " selected";?>>
                                            	One time per night
                                            </option>
                                            <option value="Several times per week" <? if($quit_breathing == 'Several times per week') echo " selected";?>>
                                            	Several times per week
                                            </option>
                                            <option value="Occasionally" <? if($quit_breathing == 'Occasionally') echo " selected";?>>
                                            	Occasionally
                                            </option>
                                            <option value="Seldom" <? if($quit_breathing == 'Seldom') echo " selected";?>>
                                            	Seldom
                                            </option>
                                            <option value="Never" <? if($quit_breathing == 'Never') echo " selected";?>>
                                            	Never
                                            </option>
                                        </select>
                                    </td>
                                </tr>
								

								
								<tr>
                                	<td valign="top">
                                    	If yes do they sleep in the same room?
                                    </td>
                                    <td valign="top">
                                    	<select name="sleep_same_room" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="Yes" <? if($sleep_same_room== 'Yes') echo " selected";?>>
                                            	Yes
                                            </option>
                                            <option value="No" <? if($sleep_same_room == 'No') echo " selected";?>>
                                            	No
                                            </option>
                                            <option value="Sometimes" <? if($sleep_same_room == 'Sometimes') echo " selected";?>>
                                            	Sometimes
                                            </option>
                                        </select>
                                    </td>
                                </tr>
								

                            </table>
                        	
                        </span>
                    </div>
                    <br />
                    
                </li>
			</ul>
		</td>
	</tr>  
	
	<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        What is the main reason that you are seeking treatment?
                    </label>
                    
                    <div>
                    	<span class="full">
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0"> 
                            	<tr>
                                    <td valign="top">
                                    	<select name="main_reason[]" class="field text addr tbox" style="width:350px;" size="7">
                                           	<option value="snoring" <? if(strpos($main_reason,'~snoring~') === false) {} else { echo " selected";}?> >
												snoring
											</option>
                                           	<option value="excessive daytime sleepiness" <? if(strpos($main_reason,'~excessive daytime sleepiness~') === false) {} else { echo " selected";}?> >
												excessive daytime sleepiness
											</option>
                                           	<option value="fatigue" <? if(strpos($main_reason,'~fatigue~') === false) {} else { echo " selected";}?> >
												fatigue
											</option>
                                           	<option value="witness apneas" <? if(strpos($main_reason,'~witness apneas~') === false) {} else { echo " selected";}?> >
												witness apneas
											</option>
                                           	<option value="headaches" <? if(strpos($main_reason,'~headaches~') === false) {} else { echo " selected";}?> >
												headaches
											</option>
                                           	<option value="had sleep study due to medical reasons" <? if(strpos($main_reason,'~had sleep study due to medical reasons~') === false) {} else { echo " selected";}?> >
												had sleep study due to medical reasons
											</option>

                                        </select>
										<br /><br />
										Other:
										<br />
										<input id="main_reason_other" name="main_reason_other" type="text" class="tbox" value="<?=$main_reason_other?>" maxlength="255" />
                                    </td>
                                </tr>
							</table>
						</span>
					</div>
				</li>
			</ul>
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
<? include "includes/bottom2.htm";?>
