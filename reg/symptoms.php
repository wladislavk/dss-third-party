<?php 
include "includes/header.php";
include 'includes/questionnaire_sections.php';
?>
<link rel="stylesheet" href="css/questionnaire.css" />
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/questionnaire_ie.css" />
<![endif]-->
<?php
$todaysdate=date("m/d/Y");
if($_POST['q_page1sub'] == 1)
{
  $s_sql = "SELECT * FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";
  $s_q = mysql_query($s_sql);
  $s_r = mysql_fetch_assoc($s_q);
  if($s_r['questionnaire_status']==0 || $s_r['questionnaire_status']==1){


	$ess = $_POST['ess'];
	$tss = $_POST['tss'];
        $chief_complaint_text = $_POST['chief_complaint_text'];	
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
		if($_POST['complaint_0'] <> '')
                {
                        $comp_arr .= '0|'.$_POST['complaint_0'].'~';
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
	echo $main_reason;
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
	
 	$exist_sql = "SELECT patientid FROM dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";	
	$exist_q = mysql_query($exist_sql);
	if(mysql_num_rows($exist_q) == 0)
	{
		$ins_sql = " insert into dental_q_page1 set 
		patientid = '".s_for($_SESSION['pid'])."',
		chief_complaint_text = '".s_for($chief_complaint_text)."',
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
		adddate = '".date('m/d/Y')."',
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
	        mysql_query("UPDATE dental_patients SET symptoms_status=1 WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");
		mysql_query("UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?= $_POST['goto_p']; ?>?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page1 set 
		chief_complaint_text = '".s_for($chief_complaint_text)."',
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
		where patientid = '".s_for($_SESSION['pid'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
	        mysql_query("UPDATE dental_patients SET symptoms_status=1 WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");		
                mysql_query("UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?= $_POST['goto_p']; ?>?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
  }else{
    //symptoms status is not 0
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='<?= $_POST['goto_p']; ?>?msg=<?=$msg;?>';
                </script>
                <?
                die();

  }
}
?>
<?php
        $exist_sql = "SELECT symptoms_status FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";
        $exist_q = mysql_query($exist_sql);
	$exist_row = mysql_fetch_assoc($exist_q);
        if($exist_row['symptoms_status'] == 0)
        {

$pat_sql = "select * from dental_patients where patientid='".s_for($_SESSION['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		//window.location = 'manage_patient.php';
	</script>
	<?
	//die();
}
$sql = "select * from dental_q_page1 where patientid='".$_SESSION['pid']."' ";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page1id = st($myarray['q_page1id']);
$chief_complaint_text = st($myarray['chief_complaint_text']);
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
<a name="top"></a>
<?php include 'includes/questionnaire_header.php'; ?>


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

<form id="q_page1frm" class="q_form" name="q_page1frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="q_page1sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page1id;?>" />
<input type="hidden" id="goto_p" name="goto_p" value="sleep.php" />
<div class="formEl_a">
	<div class="sepH_b clear">
                    <label class="lbl_a">
                        What is the main reason you are seeking treatment?
                    </label>
                        <textarea class="inpt_a" name="chief_complaint_text" id="chief_complain_text"><?= $chief_complaint_text; ?></textarea>
	</div>
	<h3>Subjective</h3>
                    <label class="lbl_a" id="title0" for="Field0">
                        Other Complaints
                    </label>
                    <? 
					$complaint_sql = "select * from dental_complaint where status=1 order by sortby";
					$complaint_my = mysql_query($complaint_sql);
					$complaint_number = mysql_num_rows($complaint_my);
					?>
                    <span class="form_info">
			Please check any other complaints below.
                    </span>
                    <br />
		   <script type="text/javascript">
			var removed = [];
			function update_c_chb(){
				var selections = [];
				$('.complaint_chb').each( function(){
					if($(this).val()!=''){
						selections.push($(this).val());
					}
				})
				$('.complaint_chb').each( function(){
					$(' option', this).each( function(){
						if(in_array($(this).attr("value"), selections) && !($(this).attr("selected")) ){
							$(this).attr('disabled','disabled');
						}else{
							$(this).removeAttr('disabled');;
						}
					});
                                })

			}
function in_array(needle, haystack)
{
    for(var key in haystack)
    {
        if(needle === haystack[key])
        {
            return true;
        }
    }

    return false;
}
			$('document').ready( function(){
				update_c_chb();
			});
		    </script>
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

                    <div style="width:48%;float:left;">
                        <span>
                    <!--    	<select id="complaint_<?=st($complaint_myarray['complaintid']);?>" name="complaint_<?=st($complaint_myarray['complaintid']);?>" class="complaint_chb field text addr tbox" style="width:50px;" onchange="update_c_chb(); chk_chief(this.value,<?=st($complaint_myarray['complaintid']);?>)">
                            	<option value=""></option>
                            	<? 
								for($i=1;$i<=$complaint_number;$i++)
								{?>
                            		<option value="<?=$i;?>" <? if($chk == $i) echo " selected";?>><?=$i;?></option>
                                <? }?>
                            </select>-->
			    <input type="checkbox" name="complaint_<?=st($complaint_myarray['complaintid']);?>" value="1" <? if($chk == 1) echo 'checked="checked"'; ?> />
                            &nbsp;&nbsp;
                            <?=st($complaint_myarray['complaint']);?><br />&nbsp;
                        </span>
                    </div>
                    <? }?>
                    <div style="width:48%;float:left;">
                        <span>
				<?php
                                                if(@array_search(0,$compid) === false)
                                                {
                                                        $chk = '';
                                                }
                                                else                                                {
                                                        $chk = $compseq[@array_search(0,$compid)];
                                                }
				?>
                            <input type="checkbox" id="complaint_0" onclick="chk_other_comp()" name="complaint_0" value="1" <? if($chk == 1) echo 'checked="checked"'; ?> />
                            &nbsp;&nbsp;
                            Other<br />&nbsp;
                        </span>
                    </div>

                    <div class="sepH_b clear" id="other_complaints">
                            	<label class="lbl_a">Additional Complaints</label>
                            (Enter Each Complaint on Different Line)<br />
                            <textarea name="other_complaint" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_complaint;?></textarea>
                        </span>
                    </div>
		<script type="text/javascript">
			function chk_other_comp(){
				if($('#complaint_0').is(':checked')){
					$('#other_complaints').show();
				}else{
					$('#other_complaints').hide();
				}			
			}

			chk_other_comp();
		</script>
		<h3 class="clear">Subjective Signs/Symptoms</h3>
                    <div class="sepH_b half num">
                                    	<label class="lbl_in">Rate your overall energy level 0 -10 (10 being the highest)</label>
                                    	<select name="energy_level" class="inpt_in">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($energy_level!='' && $energy_level == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
		    </div>
		<div class="sepH_b half string">
             		<label class="lbl_in">Have you been told you snore?</label>
                        <select name="told_you_snore" class="inpt_in">
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
                                            <option value="Sometimes" <? if($told_you_snore == "Don't know") echo " selected";?>>
                                                Don't know
                                            </option>
                                        </select>
		</div>
		<div class="sepH_b half num">
                	<label class="lbl_in">Rate the sound of your snoring 0 -10 (10 being the highest)</label>
                                        <select name="snoring_sound" class="inpt_in">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($snoring_sound!='' && $snoring_sound == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                            <option value="Don't know">Don't know</option>
                                        </select>
		</div>
		<div class="sepH_b half string">
                	<label class="lbl_in">How often do you wake up with morning headaches?</label>
                                    	<select name="morning_headaches" class="inpt_in">
                                            <option value=""></option>
                                            <option value="0" <? if($morning_headaches != '' && $morning_headaches == '0') echo " selected";?>>
                                                Everyday
                                            </option>
                                            <option value="1" <? if($morning_headaches == '1') echo " selected";?>>
                                                Often
                                            </option>
                                            <option value="2" <? if($morning_headaches == '2') echo " selected";?>>
                                                Sometimes
                                            </option>
                                            <option value="3" <? if($morning_headaches == '3') echo " selected";?>>
                                                Rarely
                                            </option>
                                            <option value="4" <? if($morning_headaches == '4') echo " selected";?>>
                                                Never
                                            </option>

                                        </select>
		</div>
		<div class="sepH_b half num">
                	<label class="lbl_in">On average how many times per night do you wake up?</label>
                                        <select name="wake_night" class="inpt_in">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($wake_night!='' && $wake_night == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
		</div>
		<div class="sepH_b half string">
                   	<label class="lbl_in">Do you have a bed time partner?</label>
                                    	<select name="bed_time_partner" class="inpt_in" onchange="disableenable()">
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
		</div>
		<div class="sepH_b half num">
                   	<label class="lbl_in">On average how many hours of sleep do you get per night?</label>
                                        <select name="hours_sleep" class="inpt_in">
                                            <option value=""></option>
                                            <? for($i=0;$i<16;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($hours_sleep!='' && $hours_sleep == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
		</div>
		<div class="sepH_b half string">
                    	<label class="lbl_in">If yes do they sleep in the same room?</label>
                                    	<select name="sleep_same_room" class="inpt_in">
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
		</div>
		<div class="sepH_b half num">
                   	<label class="lbl_in">Rate your sleep quality 0-10 (10 being the highest)</label>
                                        <select name="sleep_qual" class="inpt_in">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($sleep_qual!='' && $sleep_qual == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
		</div>
		<div class="sepH_b half string">
                    	<label class="lbl_in">How many times per night does your bedtime partner notice you quit breathing?</label>
                                    	<select name="quit_breathing" class="inpt_in">
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
                    </div>
<!--	
	<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        What is the main reason that you are seeking treatment?<br /><font style="font-size:10px;">Control + Click to select multiple (Command + Click - Mac)
                    </label>
                    
                    <div>
                    	<span class="full">
                        	<table width="100%" cellpadding="3" cellspacing="1" border="0"> 
                            	<tr>
                                    <td valign="top">
                                    	<select multiple="multiple" id="main_reason" name="main_reason[]" class="field text addr tbox" onchange="showOtherBox()" style="width:350px;" size="7">
                                    	      <?php
                                            $cmp_query = "SELECT * FROM dental_complaint WHERE status=1";
                                            $cmp_array = mysql_query($cmp_query);
                                            while($cmp_res = mysql_fetch_array($cmp_array)){
                                            ?>
                                    	
                                           	<option value="<?php echo $cmp_res['complaint']; ?><?php// echo $cmp_res['complaintid']; ?>" <?php if($main_reason == "~".$cmp_res['complaint']."~"){ echo "selected=\"selected\""; } ?>>
												                    <?php echo $cmp_res['complaint']; ?>
                                            </option>
											                      <?php } ?>
                                            <option value="other" <? if(strpos($main_reason,'~other~') === false) {} else { echo " selected";}?> >
												Other - Fill in below
											</option>
                                        </select>
				<div id="main_reason_other_div">
						<br /><br />
										Other Main Reason for Seeking Treatment:
										<br />
										<input id="main_reason_other" name="main_reason_other" type="text" class="tbox" value="<?=$main_reason_other?>" maxlength="255" />
				</div>
                                    </td>
                                </tr>
							</table>
						</span>
					</div>
				</li>
			</ul>
		</td>
	</tr>-->
	   
</table>

<script type="text/javascript">

function showOtherBox(){
sel = String($('#main_reason').val());
if($.inArray('other', sel.split(','))!=-1){
  $('#main_reason_other_div').show();
}else{
  $('#main_reason_other_div').hide();

}

}
$('document').ready( function(){
  showOtherBox();
});

</script>
<p class="confirm_text">Thank you for completing the Symptoms Questionnaire! Please click the box below to confirm and record your answers. </p>
<div align="right">
    <input type="submit" name="q_pagebtn" class="next btn btn_d" value="Save and Proceed" />
    &nbsp;&nbsp;&nbsp;
</div>
</div>
</form>


<?php }else{ 
show_section_completed($_SESSION['pid']);
} ?>

<? include "includes/footer.php";?>


