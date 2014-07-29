<?php 
include "includes/top.htm";
include "includes/patient_nav.php";

if($_GET['own']==1){
  $c_sql = "SELECT patientid FROM dental_patients WHERE (symptoms_status=1 || sleep_status=1 || treatments_status=1 || history_status=1) AND patientid='".mysql_real_escape_string($_GET['pid'])."' AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";  $c_q = mysql_query($c_sql);  $changed = mysql_num_rows($c_q);
  $own_sql = "UPDATE dental_patients SET symptoms_status=3, sleep_status=3, treatments_status=3, history_status=3 WHERE patientid='".mysql_real_escape_string($_GET['pid'])."' AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";
  mysql_query($own_sql);
 if($_GET['own_completed']==1){
  $q1_sql = "SELECT q_page1id from dental_q_page1 WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
  $q1_q = mysql_query($q1_sql);
  if(mysql_num_rows($q1_q) == 0){
    $ed_sql = "INSERT INTO dental_q_page1 SET exam_date=now(), patientid='".$_GET['pid']."'";
    mysql_query($ed_sql);
  }else{
    $ed_sql = "UPDATE dental_q_page1 SET exam_date=now() WHERE patientid='".$_GET['pid']."'";
    mysql_query($ed_sql);
  }
 }
                ?>
                <script type="text/javascript">
                        <?php if($changed>0){ ?>
                                alert("Warning! Patient has made changes to the Questionnaire. Please review the patient's ENTIRE questionnaire for changes.");
                        <?php } ?>

                        window.location='q_page1.php?pid=<?=$_GET['pid']?>&addtopat=1';
                </script>
                <?
                die();

}

?>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>

<script type="text/javascript">
	edited = false;
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			//window.onbeforeunload = confirmExit;
			//window.onunload = submitForm;
			edited = true;
		});
		$('#q_page1frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
$todaysdate=date("m/d/Y");
if($_POST['q_page1sub'] == 1)
{
        $exam_date = ($_POST['exam_date']!='')?date('Y-m-d', strtotime($_POST['exam_date'])):'';
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
                exam_date = '".s_for($exam_date)."',
		ess = '".s_for($ess)."',
		tss = '".s_for($tss)."',
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
		
		$msg = "Added Successfully";
                if(isset($_POST['q_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='q_page2.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>#form';
		</script>
		<?
		}
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page1 set 
                exam_date = '".s_for($exam_date)."',
                ess = '".s_for($ess)."',
                tss = '".s_for($tss)."',
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
		where q_page1id = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
                if(isset($_POST['q_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='q_page2.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>#form';
		</script>
		<?
		}
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


        $exist_sql = "SELECT symptoms_status, sleep_status, treatments_status, history_status FROM dental_patients WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
        $exist_q = mysql_query($exist_sql);
        $exist_row = mysql_fetch_assoc($exist_q);
        if($exist_row['symptoms_status'] == 0 && $exist_row['sleep_status'] == 0 && $exist_row['treatments_status'] == 0 && $exist_row['history_status'] == 0)
        {
                ?>
                <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It has not been edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please  
                        <a href="q_page1.php?pid=<?= $_GET['pid']; ?>&own=1&addtopat=1">click here</a>.</div>
                <?php

        }elseif($exist_row['symptoms_status'] != 2 && $exist_row['sleep_status'] != 2 && $exist_row['treatments_status'] != 2 && $exist_row['history_status'] != 2 &&
                $exist_row['symptoms_status'] != 3 && $exist_row['sleep_status'] != 3 && $exist_row['treatments_status'] != 3 && $exist_row['history_status'] != 3)
        {
                ?>
                <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It is currently being edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please
                        <a href="q_page1.php?pid=<?= $_GET['pid']; ?>&own=1&addtopat=1">click here</a>.</div>
                <?php

        }else{


		if($exist_row['history_status'] == 2 || $exist_row['sleep_status'] == 2 || $exist_row['history_status'] == 2 || $exist_row['history_status'] == 2){
                ?>
                <div style="width:500px; margin:30px auto 0 auto;">This section has been edited by the patient. All patient changes are visible below. Review each page of the Questionnaire then
                        <a href="q_page1.php?pid=<?= $_GET['pid']; ?>&own=1&own_completed=1&addtopat=1" onclick="return confirm('I certify that I have reviewed the entire Questionnaire for accuracy.')">CLICK HERE</a> to accept the changes.</div>
                <?php

		}	  

$sql = "select p1.*, s.analysis from dental_q_page1 p1 
	LEFT JOIN dental_q_sleep s ON s.patientid=p1.patientid
	where p1.patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page1id = st($myarray['q_page1id']);
$exam_date = st($myarray['exam_date']);
$ess = st($myarray['ess']);
$tss = st($myarray['tss']);
$analysis = $myarray['analysis'];
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

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />

<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/questionnaire.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/questionnaire.js" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;

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

<form id="q_page1frm"  class="q_form" name="q_page1frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="q_page1sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page1id;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div style="float:left; margin-left:10px;">
        <input type="reset" value="Undo Changes" />
</div>
<div style="float:right;">
        <input type="submit" name="q_pagebtn" value="Save" />
        <input type="submit" name="q_pagebtn_proceed" value="Save And Proceed" />
    &nbsp;&nbsp;&nbsp;
</div>
<div style="clear:both;"></div>
<?php
        $patient_sql = "SELECT * FROM dental_q_page1 WHERE parent_patientid='".mysql_real_escape_string($_GET['pid'])."'";    
        $patient_q = mysql_query($patient_sql);
	$pat_row = mysql_fetch_assoc($patient_q);
        if(mysql_num_rows($patient_q) == 0){
		$showEdits = false;
		//echo "Patient edits.";
	}else{
		$showEdits = true;
	}
?>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <tr>
        <td colspan="2">
           Exam date: <input type="text" id="exam_date" name="exam_date" class="calendar" value="<?= ($exam_date!='')?date('m/d/Y', strtotime($exam_date)):date('m/d/Y'); ?>" />
           <script type="text/javascript">
             var cal_exam = new calendar2(document.getElementById('exam_date'));
           </script>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="sub_head">
           Additional Patient Information
        </td>
    </tr>
    
    <tr>
	<td valign="top" class="frmhead">
	  Baseline Epworth Sleepiness Score: <input type="text" id="ess" style="width:30px;" name="ess" onclick="window.location = 'q_sleep.php?pid=<?=$_GET['pid']; ?>';" readonly="readonly" value="<?= $ess; ?>" />
                            <?php
				if($pat_row['ess']!=''){
                                  showPatientValue('dental_q_page1', $_GET['pid'], 'ess', $pat_row['ess'], $ess, true, $showEdits);
				}
                            ?>
<?= $analysis; ?>
	  <br /><br />
	  Baseline Thornton Snoring Scale: <input type="text" id="tss" name="tss" style="width:30px;" onclick="window.location = 'q_sleep.php?pid=<?=$_GET['pid']; ?>';" readonly="readonly" value="<?= $tss; ?>" />
                            <?php
				if($pat_row['tss']!=''){
                                  showPatientValue('dental_q_page1', $_GET['pid'], 'tss', $pat_row['tss'], $tss, true, $showEdits);
				}
                            ?>
> 5 indicates snoring is significantly affecting quality of life.
	<?php
	  $sleep_sql = "SELECT * FROM dental_q_sleep WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
	  $sleep_q = mysql_query($sleep_sql);
	  if(mysql_num_rows($sleep_q) == 0){
	 	?>
		<br />
		<a href="q_sleep.php?pid=<?= $_GET['pid']; ?>">Complete sleep section</a>
		<?php
	  }else{
		?>
		 <br />
                <a href="#" onclick="$('#sleep_results').toggle(); return false;">View results</a>
		<div id="sleep_results" style="display:none;">

                  <div style="width:48%; float:left;">
                        <h3>Epworth</h3>
		    <?php
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


                                        $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
                                        $epworth_my = mysql_query($epworth_sql);
                                        $epworth_number = mysql_num_rows($epworth_my);
                                        ?>

                    <?
                                        while($epworth_myarray = mysql_fetch_array($epworth_my))                                        {
                                                if(@array_search($epworth_myarray['epworthid'],$epid) === false)
                                                {
                                                        $chk = '';
                                                }
                                                else                                                {
                                                        $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
                                                }

					?>
					<?= $chk; ?>
					-	
					<?=st($epworth_myarray['epworth']);?>
					<br />
					<?php
					}
			?>
			<?= $ess; ?> - Total

		  </div>
		  <div style="width:48%; float:left;">
			<h3>Thornton</h3>
		    <?php
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
			<?= $snore_1; ?> - My snoring affects my relationship with my partner<br />
			<?= $snore_2; ?> - My snoring causes my partner to be irritable or tired<br />
			<?= $snore_3; ?> - My snoring requires us to sleep in separate rooms<br />
			<?= $snore_4; ?> - My snoring is loud<br />
			<?= $snore_5; ?> - My snoring affects people when I am sleeping away from home<br />

			<?=$tss; ?> - Total
			<?php

		    ?>

		  </div>
		</div>
                <?php

	  }
	?>
	</td>
    </tr>
    <tr>
	<td valign="top" class="frmhead">
                    <label style="display:block;">
                        What is the main reason you are seeking treatment? 
                    </label>
                        <textarea style="width:400px; height:100px;" name="chief_complaint_text" id="chief_complain_text"><?= $chief_complaint_text; ?></textarea>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'chief_complaint_text', $pat_row['chief_complaint_text'], $chief_complaint_text, true, $showEdits);
                            ?>

	</td>
    </tr>
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
					<span class="form_info">Subjective</span>
                    <br />
                    <label class="desc" id="title0" for="Field0">
                        Other Complaints
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'complaintid', $pat_row['complaintid'], $complaintid, false, $showEdits);
                            ?>
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

        $patcomp_arr1 = split('~',$pat_row['complaintid']);

        foreach($patcomp_arr1 as $i => $val)
        {
                $patcomp_arr2 = explode('|',$val);

                $patcompid[$i] = $patcomp_arr2[0];
                $patcompseq[$i] = $patcomp_arr2[1];
        }

					while($complaint_myarray = mysql_fetch_array($complaint_my))
					{
						if(@array_search($complaint_myarray['complaintid'],$compid) === false)
						{
							$chk = '';
						}
						else
						{
							$chk = ($compseq[@array_search($complaint_myarray['complaintid'],$compid)])?1:0;
						}
					        if(@array_search($complaint_myarray['complaintid'],$patcompid) === false)
                                                {
                                                        $patchk = '';
                                                }
                                                else
                                                {
                                                        $patchk = 1;//($compseq[@array_search($complaint_myarray['complaintid'],$pat_row['complaintid'])])?1:0;
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
			    <input type="checkbox" name="complaint_<?=st($complaint_myarray['complaintid']);?>" id="complaint_<?=st($complaint_myarray['complaintid']);?>" value="1" <? if($chk == 1) echo 'checked="checked"'; ?> />
<?php if($pat_row['complaintid'] !=  $complaintid && $showEdits){ ?>
<input type="checkbox" <? if($patchk == 1) echo 'checked="checked"'; ?> disabled="disabled" style="background:#c333;" />
<?php } ?>
                            &nbsp;&nbsp;
                            <?=st($complaint_myarray['complaint']);?>

				<br />&nbsp;
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

                    <div id="other_complaints">
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Additional Complaints<br />
                            </span>
                            (Enter Each Complaint on Different Line)<br />
                            <textarea name="other_complaint" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_complaint;?></textarea>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'other_complaint', $pat_row['other_complaint'], $other_complaint, true, $showEdits);
                            ?>
                        </span>
                    </div>
                    <br />
                </li>
           	</ul>
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
                                    	Rate your overall energy level 0 -10 (10 being the highest) 
                                    </td>
                                    <td valign="top">
                                    	<select name="energy_level" id="energy_level" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($energy_level!='' && $energy_level == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'energy_level', $pat_row['energy_level'], $energy_level, true, $showEdits);
                            ?>

                                    </td>
                                </tr>
                                                                <tr>
                                        <td valign="top">
                                        Rate your sleep quality 0-10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                        <select name="sleep_qual" id="sleep_qual" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($sleep_qual!=''&&$sleep_qual == $i){echo " selected";}?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'sleep_qual', $pat_row['sleep_qual'], $sleep_qual, true, $showEdits);
                            ?>
                                    </td>
                                </tr>

                                 								<tr>
                                	<td valign="top">
                                    	Have you been told you snore?
                                    </td>
                                    <td valign="top">
                                    	<select name="told_you_snore" id="told_you_snore" class="field text addr tbox" style="width:150px;">
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
                                            <option value="Don't know" <? if($told_you_snore == "Don't know") echo " selected";?>>
                                                Don't know
                                            </option>

                                        </select>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'told_you_snore', $pat_row['told_you_snore'], $told_you_snore, true, $showEdits);
                            ?>
                                    </td>
                                </tr>
								
                                <tr>
                                	<td valign="top">
                                    	Rate the sound of your snoring 0 -10 (10 being the highest) 
                                    </td>
                                    <td valign="top">
                                    	<select name="snoring_sound" id="snoring_sound" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($snoring_sound == $i && $snoring_sound!='') echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                            <option value="Don't know">Don't know</option>
                                        </select>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'snoring_sound', $pat_row['snoring_sound'], $snoring_sound, true, $showEdits);
                            ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">
                                    	On average how many times per night do you wake up?  
                                    </td>
                                    <td valign="top">
                                    	<select name="wake_night" id="wake_night" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($wake_night!='' && $wake_night == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'wake_night', $pat_row['wake_night'], $wake_night, true, $showEdits);
                            ?>

                                    </td>
                                </tr>
                                <!--<tr>
                                	<td valign="top">
                                    	On average how many times per night does your bed time partner notice you quick breathing per night?
                                    </td>
                                    <td valign="top">
                                    	<select name="breathing_night" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=0;$i<11;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($breathing_night!='' && $breathing_night == $i) echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                                    </td>
                                </tr> -->
                                <tr>
                                	<td valign="top">
                                    	On average how many hours of sleep do you get per night?
                                    </td>
                                    <td valign="top">
                                    	<select name="hours_sleep" id="hours_sleep" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <? for($i=0;$i<16;$i++)
                                            {?>
                                                <option value="<?=$i;?>" <? if($hours_sleep == $i && $hours_sleep != '') echo " selected";?>><?=$i;?></option>
                                            <? }?>
                                        </select>
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'hours_sleep', $pat_row['hours_sleep'], $hours_sleep, true, $showEdits);
                            ?>
                                    </td>
                                </tr>
                                                               <tr>
                                        <td valign="top">
                                        How often do you wake up with morning headaches?
                                    </td>
                                    <td valign="top">
					<select name="morning_headaches" id="morning_headaches" class="field text addr tbox" style="width:150px;">
                                            <option value=""></option>
                                            <option value="0" <? if($morning_headaches == '0') echo " selected";?>>
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
                                        <!--<select name="morning_headaches" id="morning_headaches" class="field text addr tbox" style="width:150px;">
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
                                        </select>-->
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'morning_headaches', $pat_row['morning_headaches'], $morning_headaches, true, $showEdits);
                            ?>
                                    </td>
                                </tr>
 
                                								<tr>
                                	<td valign="top">
                                    	Do you have a bed time partner?
                                    </td>
                                    <td valign="top">
                                    	<select name="bed_time_partner" id="bed_time_partner" class="field text addr tbox" style="width:150px;" onchange="disableenable()">
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
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'bed_time_partner', $pat_row['bed_time_partner'], $bed_time_partner, true, $showEdits);
                            ?>

                                    </td>
                                </tr>
								
								

								
								<tr>
                                	<td valign="top">
                                    	If yes do they sleep in the same room?
                                    </td>
                                    <td valign="top">
                                    	<select name="sleep_same_room" id="sleep_same_room" class="field text addr tbox" style="width:150px;">
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
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'sleep_same_room', $pat_row['sleep_same_room'], $sleep_same_room, true, $showEdits);
                            ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                	<td valign="top">
                                    	How many times per night does your bedtime partner notice you quit breathing?
                                    </td>
                                    <td valign="top">
                                    	<select name="quit_breathing" id="quit_breathing" class="field text addr tbox" style="width:150px;">
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
                            <?php
                                showPatientValue('dental_q_page1', $_GET['pid'], 'quit_breathing', $pat_row['quit_breathing'], $quit_breathing, true, $showEdits);
                            ?>

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

<div style="float:left; margin-left:10px;">
        <input type="reset" value="Undo Changes" />
</div>
<div style="float:right;">
        <input type="submit" name="q_pagebtn" value="Save" />
        <input type="submit" name="q_pagebtn_proceed" value="Save And Proceed" />
    &nbsp;&nbsp;&nbsp;
</div>
<div style="clear:both;"></div>

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

<?php
} //end symptom status check


?>


<? include "includes/bottom.htm";?>
