<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include "includes/patient_nav.php";
?>
<ul class="nav nav-tabs nav-justified">
        <li>
            <a href="patient_questionnaire.php?pid=<?= $_GET['pid']; ?>" id="link_summ">Symptoms</a>
        </li>
        <li class="active">
            <a href="patient_questionnaire2.php?pid=<?= $_GET['pid']; ?>" id="link_notes">Previous Treatments</a>
        </li>
        <li>
            <a href="patient_questionnaire3.php?pid=<?= $_GET['pid']; ?>" id="link_treatment">Health Hx.</a>
        </li>
    </ul>
    <p>&nbsp;</p>

<?php

if(!empty($_GET['own']) && $_GET['own']==1){
  $c_sql = "SELECT patientid FROM dental_patients WHERE (symptoms_status=1 || sleep_status=1 || treatments_status=1 || history_status=1) AND patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' AND docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
  $c_q = mysqli_query($con,$c_sql);
  $changed = mysqli_num_rows($c_q);
  $own_sql = "UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."' AND docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
  mysqli_query($con,$own_sql);
 if($_GET['own_completed']==1){
  $q1_sql = "SELECT q_page1id from dental_q_page1 WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
  $q1_q = mysqli_query($con,$q1_sql);
  if(mysqli_num_rows($q1_q) == 0){
    $ed_sql = "INSERT INTO dental_q_page1 SET exam_date=now(), patientid='".$_GET['pid']."'";
    mysqli_query($con,$ed_sql);
  }else{
    $ed_sql = "UPDATE dental_q_page1 SET exam_date=now() WHERE patientid='".$_GET['pid']."'";
    mysqli_query($con,$ed_sql);
  }
 }

                ?>
                <script type="text/javascript">
			<?php if($changed>0){ ?>
				alert("Warning! Patient has made changes to the Questionnaire. Please review the patient's ENTIRE questionnaire for changes.");
			<?php } ?>
                        window.location='q_page2.php?pid=<?=$_GET['pid']?>&addtopat=1';
                </script>
                <?
                die();

}
?>

<script type="text/javascript">
edited = false;
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			edited = true;
			//window.onbeforeunload = confirmExit;
		});
		$('#q_page2frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>


<?php
if(!empty($_POST['q_page2sub']) && $_POST['q_page2sub'] == 1)
{
	$polysomnographic = $_POST['polysomnographic'];
	$sleep_center_name_text = $_POST['sleep_center_name_text'];
	$sleep_study_on = $_POST['sleep_study_on'];
	$confirmed_diagnosis = $_POST['confirmed_diagnosis'];
	$rdi = $_POST['rdi'];
	$ahi = $_POST['ahi'];
	$cpap = $_POST['cpap'];
	$cur_cpap = $_POST['cur_cpap'];
	$intolerance = $_POST['intolerance'];
	$other_intolerance = $_POST['other_intolerance'];
	$other_therapy = $_POST['other_therapy'];
	$other = $_POST['other'];
	$other_chk = $_POST['other_chk'];
	$affidavit = $_POST['affidavit'];
	$type_study = $_POST['type_study'];
	$nights_wear_cpap = $_POST['nights_wear_cpap'];
	$percent_night_cpap = $_POST['percent_night_cpap'];
	$custom_diagnosis = $_POST['custom_diagnosis'];
	$sleep_study_by = $_POST['sleep_study_by'];
	$triedquittried = $_POST['triedquittried'];
	$timesovertime = $_POST['timesovertime'];
	$dd_wearing = $_POST['dd_wearing'];
	$dd_prev = $_POST['dd_prev'];
	$dd_otc = $_POST['dd_otc'];
	$dd_fab = $_POST['dd_fab'];
	$dd_who = $_POST['dd_who'];
	$dd_experience = $_POST['dd_experience'];
   	$surgery = $_POST['surgery'];
	$num_surgery = $_POST['num_surgery'];
	
	$int_arr = '';
	if(is_array($intolerance))
	{
		foreach($intolerance as $val)
		{
			if(trim($val) <> '')
				$int_arr .= trim($val).'~';
		}
	}
	
	if($int_arr != '')
		$int_arr = '~'.$int_arr;
		
	$other_arr = '';
	if(is_array($other))
	{
		foreach($other as $val)
		{
			if(trim($val) <> '')
				$other_arr .= trim($val).'~';
		}
	}
	
	if($other_chk != '')
		$other_arr .= 'Other~';
	
	if($other_arr != '')
		$other_arr = '~'.$other_arr;
	
		
	if($polysomnographic == '')
		$polysomnographic = 0;
	
	/*echo "polysomnographic - ".$polysomnographic."<br>";
	echo "sleep_center_name - ".$sleep_center_name."<br>";
	echo "sleep_study_on - ".$sleep_study_on."<br>";
	echo "confirmed_diagnosis - ".$confirmed_diagnosis."<br>";
	echo "rdi - ".$rdi."<br>";
	echo "ahi - ".$ahi."<br>";
	echo "cpap - ".$cpap."<br>";
	echo "intolerance - ".$intolerance."<br>";
	echo "other_intolerance - ".$other_intolerance ."<br>";
	echo "other_therapy - ".$other_therapy ."<br>";
	echo "int_arr - ".$int_arr ."<br>";
	echo "other - ".$other_arr ."<br>";
	echo "affidavit - ".$affidavit ."<br>";
	echo "type_study - ".$type_study ."<br>";
	echo "nights_wear_cpap - ".$nights_wear_cpap ."<br>";
	echo "percent_night_cpap - ".$percent_night_cpap ."<br>";
	echo "custom_diagnosis - ".$custom_diagnosis ."<br>";
	echo "sleep_study_by - ".$sleep_study_by."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_q_page2 set 
		patientid = '".s_for($_GET['pid'])."',
		polysomnographic = '".s_for($polysomnographic)."',
		sleep_center_name_text = '".s_for($sleep_center_name_text)."',
		sleep_study_on = '".s_for($sleep_study_on)."',
		confirmed_diagnosis = '".s_for($confirmed_diagnosis)."',
		rdi = '".s_for($rdi)."',
		ahi = '".s_for($ahi)."',
		cpap = '".s_for($cpap)."',
		cur_cpap = '".s_for($cur_cpap)."',
		intolerance = '".s_for($int_arr)."',
		other_intolerance = '".s_for($other_intolerance)."',
		other_therapy = '".s_for($other_therapy)."',
		other = '".s_for($other_arr)."',
		affidavit = '".s_for($affidavit)."',
		type_study = '".s_for($type_study)."',
		nights_wear_cpap = '".s_for($nights_wear_cpap)."',
		percent_night_cpap = '".s_for($percent_night_cpap)."',
		custom_diagnosis = '".s_for($custom_diagnosis)."',
		sleep_study_by = '".s_for($sleep_study_by)."',
		triedquittried = '".s_for($triedquittried)."',
		timesovertime = '".s_for($timesovertime)."',
		dd_wearing = '".s_for($dd_wearing)."',
		dd_prev = '".s_for($dd_prev)."',
		dd_otc = '".s_for($dd_otc)."',
		dd_fab = '".s_for($dd_fab)."',
		dd_who = '".s_for($dd_who)."',
		dd_experience = '".s_for($dd_experience)."',
		surgery = '".s_for($surgery)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysqli_query($con,$ins_sql);
		
		$msg = "Added Successfully";
                if(isset($_POST['q_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='q_page3.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		}
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page2 set 
		polysomnographic = '".s_for($polysomnographic)."',
		sleep_center_name_text = '".s_for($sleep_center_name_text)."',
		sleep_study_on = '".s_for($sleep_study_on)."',
		confirmed_diagnosis = '".s_for($confirmed_diagnosis)."',
		rdi = '".s_for($rdi)."',
		ahi = '".s_for($ahi)."',
		cpap = '".s_for($cpap)."',
                cur_cpap = '".s_for($cur_cpap)."',
		intolerance = '".s_for($int_arr)."',
		other_intolerance = '".s_for($other_intolerance)."',
		other_therapy = '".s_for($other_therapy)."',
		other = '".s_for($other_arr)."',
		affidavit = '".s_for($affidavit)."',
		type_study = '".s_for($type_study)."',
		nights_wear_cpap = '".s_for($nights_wear_cpap)."',
		percent_night_cpap = '".s_for($percent_night_cpap)."',
		custom_diagnosis = '".s_for($custom_diagnosis)."',
		sleep_study_by = '".s_for($sleep_study_by)."',
		triedquittried = '".s_for($triedquittried)."',
		timesovertime = '".s_for($timesovertime)."',
                dd_wearing = '".s_for($dd_wearing)."',
                dd_prev = '".s_for($dd_prev)."',
                dd_otc = '".s_for($dd_otc)."',
                dd_fab = '".s_for($dd_fab)."',
                dd_who = '".s_for($dd_who)."',
                dd_experience = '".s_for($dd_experience)."',
		surgery = '".s_for($surgery)."'
		where q_page2id = '".s_for($_POST['ed'])."'";
		
		mysqli_query($con,$ed_sql);

		for($i=0;$i<$num_surgery;$i++){
			if($_POST['surgery_id_'.$i]==0){
				if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
					$s = "INSERT INTO dental_q_page2_surgery (patientid, surgery_date, surgery, surgeon) VALUES ('".$_REQUEST['pid']."', '".$_POST['surgery_date_'.$i]."','".$_POST['surgery_'.$i]."','".$_POST['surgeon_'.$i]."')";
				}
			}else{
				if(trim($_POST['surgery_date_'.$i])!=''||trim($_POST['surgery_'.$i])!=''||trim($_POST['surgeon_'.$i])!=''){
					$s = "UPDATE dental_q_page2_surgery SET surgery_date='".$_POST['surgery_date_'.$i]."', surgery='".$_POST['surgery_'.$i]."', surgeon='".$_POST['surgeon_'.$i]."' WHERE id='".$_POST['surgery_id_'.$i]."'"; 
				}else{
					$s = "DELETE FROM dental_q_page2_surgery WHERE id='".$_POST['surgery_id_'.$i]."'";
				}
			}	
			mysqli_query($con,$s);
		}	
		$msg = "Edited Successfully";
                if(isset($_POST['q_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='q_page3.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		}
		die();
	}
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con,$pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

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


        $exist_sql = "SELECT symptoms_status, sleep_status, treatments_status, history_status FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
        $exist_q = mysqli_query($con,$exist_sql);
        $exist_row = mysqli_fetch_assoc($exist_q);
        if($exist_row['symptoms_status'] == 0 && $exist_row['sleep_status'] == 0 && $exist_row['treatments_status'] == 0 && $exist_row['history_status'] == 0)
        {
                ?>
                <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It has not been edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please
                        <a href="q_page2.php?pid=<?= $_GET['pid']; ?>&own=1&addtopat=1">click here</a>.</div>
                <?php

        }elseif($exist_row['symptoms_status'] != 2 && $exist_row['sleep_status'] != 2 && $exist_row['treatments_status'] != 2 && $exist_row['history_status'] != 2 &&
                $exist_row['symptoms_status'] != 3 && $exist_row['sleep_status'] != 3 && $exist_row['treatments_status'] != 3 && $exist_row['history_status'] != 3)
        {
                ?>
                <div style="width:700px; margin:30px auto 0 auto;">This section can be edited by the patient via the Patient Portal. It is currently being edited by the patient. You will be notified when the patient completes this section. If you would like to take ownership of this section and prohibit the patient from making any new changes, please
                        <a href="q_page2.php?pid=<?= $_GET['pid']; ?>&own=1&addtopat=1">click here</a>.</div>
                <?php

        }else{

                if($exist_row['history_status'] == 2 || $exist_row['sleep_status'] == 2 || $exist_row['history_status'] == 2 || $exist_row['history_status'] == 2){
                ?>                                <div style="width:500px; margin:30px auto 0 auto;">This section has been edited by the patient. All patient changes are visible below. Review each page of the Questionnaire then
                        <a href="q_page1.php?pid=<?= $_GET['pid']; ?>&own=1&own_completed=1&addtopat=1" onclick="return confirm('I certify that I have reviewed the entire Questionnaire for accuracy.')">CLICK HERE</a> to accept the changes.</div>
                <?php

                }
$sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$q_page2id = st($myarray['q_page2id']);

$polysomnographic = st($myarray['polysomnographic']);
$sleep_center_name_text = st($myarray['sleep_center_name_text']);
$sleep_study_on = st($myarray['sleep_study_on']);
$confirmed_diagnosis = st($myarray['confirmed_diagnosis']);
$rdi = st($myarray['rdi']);
$ahi = st($myarray['ahi']);
$cpap = st($myarray['cpap']);
$cur_cpap = st($myarray['cur_cpap']);
$intolerance = st($myarray['intolerance']);
$other_intolerance = st($myarray['other_intolerance']);
$other_therapy = st($myarray['other_therapy']);
$other = st($myarray['other']);
$affidavit = st($myarray['affidavit']);
$type_study = st($myarray['type_study']);
$nights_wear_cpap = st($myarray['nights_wear_cpap']);
$percent_night_cpap = st($myarray['percent_night_cpap']);
$custom_diagnosis = st($myarray['custom_diagnosis']);
$sleep_study_by = st($myarray['sleep_study_by']);
$triedquittried = st($myarray['triedquittried']);
$timesovertime = st($myarray['timesovertime']);
$dd_wearing = st($myarray['dd_wearing']);
$dd_prev = st($myarray['dd_prev']);
$dd_otc = st($myarray['dd_otc']);
$dd_fab = st($myarray['dd_fab']);
$dd_who = st($myarray['dd_who']);
$dd_experience = st($myarray['dd_experience']);
$surgery = st($myarray['surgery']);

if($cpap == '')
	$cpap = 'No';
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/questionnaire.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/questionnaire.js" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;

<? include("../includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><? echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<script>
	function chk_poly()
	{ 	
		fa = document.q_page2frm;
		
		if(fa.polysomnographic[0].checked)
		{
			$('.poly_options').show();
		}
		else
		{
			$('.poly_options').hide();
		}
	}
	
	function other_chk1()
	{ 	
		fa = document.q_page2frm;
		
		if(fa.other_chk.checked)
		{
			fa.other_therapy.disabled = false;
		}
		else
		{
			fa.other_therapy.disabled = true;
		}
	}
 	function chk_cpap_other(){
		if($('#cpap_other').attr('checked')){
		  $('.cpap_other_text').show();
		}else{
		  $('.cpap_other_text').hide();
		}

	}	
        function chk_dd()
        {       
                fa = document.q_page2frm;
                
                
                if(fa.dd_wearing[0].checked || fa.dd_prev[0].checked)
                {
                        $('.dd_options').show();
                }
                else
		{
			$('.dd_options').hide();
		}
	}
	function chk_s()
        {       
                fa = document.q_page2frm;
                
                
                if(fa.surgery[0].checked)
                {
                        $('.s_options').show();
                }
                else
                {
                        $('.s_options').hide();
                }
        }
	function chk_cpap()
	{ 	
		fa = document.q_page2frm;
		
		chk_l = document.getElementsByName('intolerance[]').length;
		
		if(fa.cpap[1].checked)
		{
			$('.cpap_options').hide();
			$('.cpap_options2').hide();
		}
		else
		{
			$('.cpap_options').show();
                  if(fa.cur_cpap[0].checked)
                  {
                        $('.cpap_options2').show();
                  }
                  else
                  {
                        $('.cpap_options2').hide();
                  }
		}
	}
	
	function q_page2abc(fa) {
	    var errorMsg = '';
	    
		if (trim(fa.sleep_study_on.value) != '') { 
			if (is_date(trim(fa.sleep_study_on.value)) == -1 ||  is_date(trim(fa.sleep_study_on.value)) == false) {
				errorMsg += "- Invalid Date Format, Valid Format : (mm/dd/YYYY);\n";
				fa.sleep_study_on.focus();
			}
		}
		
		if (document.getElementById('polysomnographic_yes').checked && trim(fa.confirmed_diagnosis.selectedIndex) < 1) {
		    errorMsg += "- Missing Confirmed Diagnosis\n";
		}
		if (errorMsg != '') {
		    alert(errorMsg);
		}
		
		return (errorMsg == '');
	}
</script>

<form id="q_page2frm" class="q_form" name="q_page2frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post" onsubmit="return q_page2abc(this)">
<input type="hidden" name="q_page2sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page2id;?>" />
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
        $patient_sql = "SELECT * FROM dental_q_page2 WHERE parent_patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
        $patient_q = mysqli_query($con,$patient_sql);
        $pat_row = mysqli_fetch_assoc($patient_q);
        if(mysqli_num_rows($patient_q) == 0){
		$showEdits = false;
                //echo "Patient edits.";
        }else{
		$showEdits = true;
	}
?>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <tr>
        <td colspan="2" class="sub_head">
           Sleep Center Evaluation
        </td>
    </tr>
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
<label class="desc" id="title0" for="Field0">
                        Sleep Studies
                    </label>

                    <div>
                        <span>
							Have you had a sleep study
							
							<input type="radio" class="polysomnographic_radio" id="polysomnographic_yes" name="polysomnographic" value="1" <? if($polysomnographic == '1') echo " checked";?> onclick="chk_poly()" />
                            Yes
                            
                            <input type="radio" class="polysomnographic_radio" name="polysomnographic" value="0" <? if($polysomnographic == '0') echo " checked";?> onclick="chk_poly()"  />
                            No
						                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'polysomnographic', $pat_row['polysomnographic'], $polysomnographic, true, $showEdits, 'radio');
                            ?>
	
                        	<!--<input type="checkbox" name="polysomnographic" value="1" class="tbox" style="width:10px;"  onclick="chk_poly()" <? if($polysomnographic == 1) echo " checked";?> />
                            A polysomnographic evaluation was performed at a sleep disorder center -->
                        </span>
                    </div>
                    
                    <br />
                    <div class="poly_options">
                    	<span>
                        	If yes where 
							
                            <input id="sleep_center_name_text" name="sleep_center_name_text" type="text" class="field text addr tbox" value="<?=$sleep_center_name_text;?>"  maxlength="255" style="width:225px;" /> 
                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'sleep_center_name_text', $pat_row['sleep_center_name_text'], $sleep_center_name_text, true, $showEdits);
                            ?>
	
							Date
                            &nbsp;&nbsp;
                            <input id="sleep_study_on" name="sleep_study_on" type="text" class="field text addr tbox" value="<?=$sleep_study_on;?>"  maxlength="10" style="width:75px;" /> 
                            <?php   
                                showPatientValue('dental_q_page2', $_GET['pid'], 'sleep_study_on', $pat_row['sleep_study_on'], $sleep_study_on, true, $showEdits);
                            ?>

                        </span>
                    </div>
					<br />
					
                    <br />
                    
                </li>
            </ul>
           <script>
				chk_poly();
		   </script>
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        CPAP Intolerance
                    </label>
                    <div>
                        <span>
                        	Have you tried CPAP?
                            <input type="radio" class="cpap_radio" name="cpap" value="Yes" <? if($cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />
                            Yes
                            
                            <input type="radio" class="cpap_radio" name="cpap" value="No" <? if($cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No
		    <?php
			showPatientValue('dental_q_page2', $_GET['pid'], 'cpap', $pat_row['cpap'], $cpap, true, $showEdits, 'radio');
		    ?>

		</span>
                   	</div>
                    <div class="cpap_options">
                        <span>
                                Are you currently using CPAP?
                            <input type="radio" class="cur_cpap_radio" name="cur_cpap" value="Yes" <? if($cur_cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />                            Yes

                            <input type="radio" class="cur_cpap_radio" name="cur_cpap" value="No" <? if($cur_cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No
                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'cur_cpap', $pat_row['cur_cpap'], $cur_cpap, true, $showEdits, 'radio');
                            ?>

                        </span>
                        </div>

                   
                                        <div class="cpap_options2">                        <span>
                                                        If currently using CPAP, how many nights / week do you wear it? <input id="nights_wear_cpap" name="nights_wear_cpap" type="text" class="field text addr tbox" value="<?=$nights_wear_cpap;?>" maxlength="255" style="width:225px;" />
                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'nights_wear_cpap', $pat_row['nights_wear_cpap'], $nights_wear_cpap, true, $showEdits);
                            ?>

                                                        <br />&nbsp;
                                                </span>
                                        </div>

                                        <div class="cpap_options2">
                        <span>
                                                        How many hours each night do you wear it? <input id="percent_night_cpap" name="percent_night_cpap" type="text" class="field text addr tbox" value="<?=$percent_night_cpap;?>" maxlength="255" style="width:225px;" />
				                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'percent_night_cpap', $pat_row['percent_night_cpap'], $percent_night_cpap, true, $showEdits);
                            ?>

                                                        <br />&nbsp;
                                                </span>
                                        </div>

                   	<div id="cpap_options" class="cpap_options">
                        <span>
				What are your chief complaints about CPAP?
                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'intolerance', $pat_row['intolerance'], $intolerance, false, $showEdits);
                            ?>

                            <br />
                            
                            <?
							$intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
							$intolerance_my = mysqli_query($con,$intolerance_sql);
							
							while($intolerance_myarray = mysqli_fetch_array($intolerance_my))
							{
							?>
								<input type="checkbox" id="intolerance" name="intolerance[]" value="<?=st($intolerance_myarray['intoleranceid'])?>" <? if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
				<?php if($intolerance != $pat_row['intolerance'] && $showEdits){ ?>
  								<input type="checkbox" disabled="disabled" <? if(strpos($pat_row['intolerance'],'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
				<?php } ?>
                                &nbsp;&nbsp;
                                <?=st($intolerance_myarray['intolerance']);?><br />
							<?
							}
							?>
					<input type="checkbox" id="cpap_other" name="intolerance[]" value="0" <? if(strpos($intolerance,'~'.st('0~')) === false) {} else { echo " checked";}?> onclick="chk_cpap_other()" /> 
                                <?php if($intolerance != $pat_row['intolerance'] && $showEdits){ ?>
                                                                <input type="checkbox" disabled="disabled" <? if(strpos($pat_row['intolerance'],'~'.st('0~')) === false) {} else { echo " checked";}?> />
                                <?php } ?>

&nbsp;&nbsp; Other<br />
                       	</span>
					</div>
                    <br />
                    <div class="cpap_options">
                        <span class="cpap_other_text">
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_intolerance" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_intolerance;?></textarea>
							<br />&nbsp;
                        </span>
                    </div>
                   						
					<script type="text/javascript">
						chk_cpap();
						chk_cpap_other();
					</script>
                </li>
            </ul>
           
        </td>
    </tr>
    
        <tr>
        <td valign="top" class="frmhead">
                <ul>
                <li id="foli8" class="complex">
                    <label class="desc" id="title0" for="Field0">
                      	Dental Devices 
                    </label>
                    <div>
			<span>
				Are you currently wearing a dental device specifically designed to treat sleep apnea?
                            <input type="radio" class="dd_wearing_radio" name="dd_wearing" value="Yes" <? if($dd_wearing == 'Yes') echo " checked";?> onclick="chk_dd()"  />
                            Yes

                            <input type="radio" class="dd_wearing_radio" name="dd_wearing" value="No" <? if($dd_wearing == 'No') echo " checked";?> onclick="chk_dd()"  />
                            No
                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_wearing', $pat_row['dd_wearing'], $dd_wearing, true, $showEdits, 'radio');
                            ?>

			</span>
		    </div>
		    <div>
			<span>
 			 	Have you previously tried a dental device for sleep apnea treatment?		
                            <input type="radio" class="dd_prev_radio" name="dd_prev" value="Yes" <? if($dd_prev == 'Yes') echo " checked";?> onclick="chk_dd()"  />
                            Yes

                            <input type="radio" class="dd_prev_radio" name="dd_prev" value="No" <? if($dd_prev == 'No') echo " checked";?> onclick="chk_dd()"  />
                            No
                            <?php                                
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_prev', $pat_row['dd_prev'], $dd_prev, true, $showEdits, 'radio');
                            ?>

			</span>
		    </div>
		    <div class="dd_options">
			<span>
				Was it over-the-counter (OTC)? 	
                            <input type="radio" class="dd_otc_radio" name="dd_otc" value="Yes" <? if($dd_otc == 'Yes') echo " checked";?> />
                            Yes

                            <input type="radio" class="dd_otc_radio" name="dd_otc" value="No" <? if($dd_otc == 'No') echo " checked";?> />
                            No
                            <?php                                
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_otc', $pat_row['dd_otc'], $dd_otc, true, $showEdits, 'radio');
                            ?>

			</span>
		    </div>
		    <div class="dd_options">
			<span>
				Was it fabricated by a dentist?
                            <input type="radio" class="dd_fab_radio" name="dd_fab" value="Yes" <? if($dd_fab == 'Yes') echo " checked";?> />
                            Yes

                            <input type="radio" class="dd_fab_radio" name="dd_fab" value="No" <? if($dd_fab == 'No') echo " checked";?> />
                            No
                            <?php                                
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_fab', $pat_row['dd_fab'], $dd_fab, true, $showEdits, 'radio');
                            ?>

			<span>
		    </div>
		    <div class="dd_options">
			<span>
				Who <input type="text" id="dd_who" name="dd_who" value="<?= $dd_who; ?>" />
                            <?php                                
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_who', $pat_row['dd_who'], $dd_who, true, $showEdits);
                            ?>

			</span>
	 	    </div>
		    <div class="dd_options">
			<span>
				Describe your experience<br />
				<textarea id="dd_experience" class="field text addr tbox" style="width:650px; height:100px;" name="dd_experience"><?= $dd_experience; ?></textarea>
                            <?php                                
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_experience', $pat_row['dd_experience'], $dd_experience, true, $showEdits);
                            ?>

			</span>
		    </div>
			<script type="text/javascript">
				chk_dd();
			</script>
		</td>
        </tr>
        <tr>
        <td valign="top" class="frmhead">
                <ul>
                <li id="foli8" class="complex">
                    <label class="desc" id="title0" for="Field0">
                        Surgery
                    </label>
                    <div>
                        <span>
				Have you had surgery for snoring or sleep apnea?
                            <input type="radio" class="surgery_radio" name="surgery" value="Yes" <? if($surgery == 'Yes') echo " checked";?> onclick="chk_s()" />
                            Yes

                            <input type="radio" class="surgery_radio" name="surgery" value="No" <? if($surgery == 'No') echo " checked";?> onclick="chk_s()" />
                            No
                            <?php                                
                                showPatientValue('dental_q_page2', $_GET['pid'], 'surgery', $pat_row['surgery'], $surgery, true, $showEdits, 'radio');
                            ?>

			</span>
		    </div>
		    <div class="s_options">
                        <span>
Please list any nose, palatal, throat, tongue, or jaw surgeries you have had.  (each is individual text field in SW)
	<table id="surgery_table">
	<tr><th>Date</th><th>Surgeon</th><th>Surgery</th><th></th></tr>	
		<?php
		  $s_sql = "SELECT * FROM dental_q_page2_surgery WHERE patientid='".mysqli_real_escape_string($con,$_REQUEST['pid'])."'";
		  $s_q = mysqli_query($con,$s_sql);
		  $s_count = 0;
		  while($s_row = mysqli_fetch_assoc($s_q)){
		?>
	  <tr id="surgery_row_<?= $s_count; ?>">
		<td><input type="hidden" name="surgery_id_<?= $s_count; ?>" value="<?= $s_row['id']; ?>" /><input type="text" id="surgery_date_<?= $s_count; ?>" name="surgery_date_<?= $s_count; ?>" value="<?= $s_row['surgery_date']; ?>" /></td>
		<td><input type="text" id="surgeon_<?= $s_count; ?>" name="surgeon_<?= $s_count; ?>" value="<?= $s_row['surgeon']; ?>" /></td>
		<td><input type="text" id="surgery_<?= $s_count; ?>" name="surgery_<?= $s_count; ?>" value="<?= $s_row['surgery']; ?>" /></td>
		<td><input type="button" name="delete_<?= $s_count; ?>" value="Delete" onclick="delete_surgery('<?= $s_count; ?>'); return false;" /></td>
	  </tr>
		<?php
			$s_count++;
			}
		?>
          <tr id="surgery_row_<?= $s_count; ?>">
                <td><input type="hidden" name="surgery_id_<?= $s_count; ?>" value="0" /><input type="text" id="surgery_date_<?= $s_count; ?>" name="surgery_date_<?= $s_count; ?>" /></td>
                <td><input type="text" id="surgeon_<?= $s_count; ?>" name="surgeon_<?= $s_count; ?>" /></td>
                <td><input type="text" id="surgery_<?= $s_count; ?>" name="surgery_<?= $s_count; ?>" /></td>
		<td><input type="button" name="delete_<?= $s_count; ?>" value="Delete" onclick="delete_surgery('<?= $s_count; ?>'); return false;" /></td>
          </tr>
	</table>
		<input type="hidden" id="num_surgery" name="num_surgery" value="<?= $s_count+1; ?>" />
		<input type="button" onclick="add_surgery(); return false;" value="Add Surgery" />
			</span>
		    </div>
		    <script type="text/javascript">
			chk_s();
			function add_surgery(){
				n = $('#num_surgery').attr('value');
				$('#surgery_table').append('<tr id="surgery_row_'+n+'"><td><input type="hidden" id="surgery_id_'+n+'" name="surgery_id_'+n+'" value="0" /><input type="text" id="surgery_date_'+n+'" name="surgery_date_'+n+'" /></td><td><input type="text" id="surgeon_'+n+'" name="surgeon_'+n+'" /></td><td><input type="text" id="surgery_'+n+'" name="surgery_'+n+'" /></td><td><input type="button" name="delete_'+n+'" value="Delete" onclick="delete_surgery(\''+n+'\'); return false;" /></td></tr>');				
				$('#num_surgery').attr('value', (parseInt(n,10)+1));
			}
			function delete_surgery(n){
				$('#surgery_date_'+n).val('');
				$('#surgeon_'+n).val('');
				$('#surgery_'+n).val('');
				$('#surgery_row_'+n).hide();
			}
		    </script>
	</td>
	</tr> 
        <tr>        <td valign="top" class="frmhead">
                <ul>                <li id="foli8" class="complex">
                    <label class="desc" id="title0" for="Field0">
                        OTHER ATTEMPTED THERAPIES
                    </label>
                    <div>
                        <span>
			    Please comment about other therapy attempts and how each impacted your snoring and apnea and sleep quality.
                            <br />
                            <textarea name="other_therapy" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_therapy;?></textarea>
                            <?php                                
                                showPatientValue('dental_q_page2', $_GET['pid'], 'other_therapy', $pat_row['other_therapy'], $other_therapy, true, $showEdits);
                            ?>

                        </span>
                                                        <script>
                                                                other_chk1();
                                                   </script>
                        </div>
                    <br />
                                </li>
                        </ul>
                </td>
        </tr>

</table>

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
<? include("../includes/form_bottom.htm");?>
<br />

<div id="popupRefer" style="width:750px;">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	

<?php
} //end treatment status check

?>






<?php include 'includes/bottom.htm'; ?>
