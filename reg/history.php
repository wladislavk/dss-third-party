<?php 
include "includes/header.php";
include 'includes/questionnaire_sections.php';
?>
<link rel="stylesheet" href="css/questionnaire.css" />
<script type="text/javascript">
edited = false;
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			edited = true;
			//window.onbeforeunload = confirmExit;
		});
		$('#q_page3frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['q_page3sub'] == 1)
{
	$allergens = $_POST['allergens'];
	$allergenscheck = $_POST['allergenscheck'];
	$other_allergens = $_POST['other_allergens'];
	$medicationscheck = $_POST['medicationscheck'];
	$medications = $_POST['medications'];
	$other_medications = $_POST['other_medications'];
	$history = $_POST['history'];
	$other_history = $_POST['other_history'];
	$dental_health = $_POST['dental_health'];
	$removable = $_POST['removable'];
	$year_completed = $_POST['year_completed'];
	$tmj = $_POST['tmj'];
	$gum_problems = $_POST['gum_problems'];
	$dental_pain = $_POST['dental_pain'];
	$dental_pain_describe = $_POST['dental_pain_describe'];
	$completed_future = $_POST['completed_future'];
	$clinch_grind = $_POST['clinch_grind'];
	$wisdom_extraction = $_POST['wisdom_extraction'];
	$jawjointsurgery = $_POST['jawjointsurgery'];
$injurytohead = $_POST['injurytohead'];
	$injurytoface = $_POST['injurytoface'];
	$injurytoneck = $_POST['injurytoneck'];
	$injurytoteeth = $_POST['injurytoteeth'];
	$injurytomouth = $_POST['injurytomouth'];
	$drymouth = $_POST['drymouth'];
	$no_allergens = $_POST['no_allergens'];
	$no_medications = $_POST['no_medications'];
	$no_history = $_POST['no_history'];
	$orthodontics = $_POST['orthodontics'];
        $premedcheck = $_POST["premedcheck"];
 	$premed = $_POST["premeddet"];
	$family_hd = $_POST['family_hd'];
	$family_bp = $_POST['family_bp'];
	$family_dia = $_POST['family_dia'];
	$family_sd = $_POST['family_sd'];
	$alcohol = $_POST['alcohol'];
	$sedative = $_POST['sedative'];
	$caffeine = $_POST['caffeine'];
	$smoke = $_POST['smoke'];
	$smoke_packs = $_POST['smoke_packs'];
	$tobacco = $_POST['tobacco'];
	$additional_paragraph = $_POST['additional_paragraph'];
	$wisdom_extraction_text = $_POST['wisdom_extraction_text']; 
        $removable_text  = $_POST['removable_text'];
        $dentures  = $_POST['dentures'];
        $dentures_text  = $_POST['dentures_text'];
        $tmj_cp  = $_POST['tmj_cp'];
        $tmj_cp_text  = $_POST['tmj_cp_text'];
        $tmj_pain  = $_POST['tmj_pain'];
        $tmj_pain_text  = $_POST['tmj_pain_text'];
        $tmj_surgery  = $_POST['tmj_surgery'];
        $tmj_surgery_text  = $_POST['tmj_surgery_text'];
        $injury  = $_POST['injury'];
        $injury_text  = $_POST['injury_text'];
        $gum_prob  = $_POST['gum_prob'];
        $gum_prob_text  = $_POST['gum_prob_text'];
        $gum_surgery  = $_POST['gum_surgery'];
        $gum_surgery_text  = $_POST['gum_surgery_text'];
        $clinch_grind_text  = $_POST['clinch_grind_text'];
        $future_dental_det = $_POST['future_dental_det'];
	$drymouth_text = $_POST['drymouth_text'];


	
	$allergens_arr = $all_text = '';
	if(is_array($allergens))
	{
		foreach($allergens as $val)
		{
			if(trim($val) <> '')
				$as = "SELECT allergens from dental_allergens where allergensid = '".mysqli_real_escape_string($con, $val)."'";
				$aq = mysqli_query($con, $as);
				$arow = mysqli_fetch_assoc($aq);
				$all_text .= $arow['allergens'].", ";
		}
	}
	
	//if($allergens_arr != '')
		//$allergens_arr = '~'.$allergens_arr;
		
	$medications_arr = $med_text = '';
	if(is_array($medications))
	{
		foreach($medications as $val)
		{
			if(trim($val) <> '')
                                $ms = "SELECT medications from dental_medications where medicationsid = '".mysqli_real_escape_string($con, $val)."'";
                                $mq = mysqli_query($con, $ms);
                                $mrow = mysqli_fetch_assoc($mq);
                                $med_text .= $mrow['medications'].", ";
		}
	}
	
	if($medications_arr != '')
		$medications_arr = '~'.$medications_arr;
		
	$history_arr = $his_text = '';
	if(is_array($history))
	{
		foreach($history as $val)
		{
			if(trim($val) <> '')
                                $hs = "SELECT history from dental_history where historyid = '".mysqli_real_escape_string($con, $val)."'";
                                $hq = mysqli_query($con, $hs);
                                $hrow = mysqli_fetch_assoc($hq);
                                $his_text .= $hrow['history'].", ";
		}
	}
	
	if($history_arr != '')
		$history_arr = '~'.$history_arr;
	
	
        $exist_sql = "SELECT patientid FROM dental_q_page3 WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";
        $exist_q = mysqli_query($con, $exist_sql);
        if(mysqli_num_rows($exist_q) == 0)
        {

		$ins_sql = " insert into dental_q_page3 set 
		patientid = '".s_for($_SESSION['pid'])."',
		allergens = '".s_for($allergens_arr)."',
		allergenscheck = '".s_for($allergenscheck)."',
		other_allergens = '".s_for($all_text.$other_allergens)."',
		medications = '".s_for($medications_arr)."',
		medicationscheck = '".s_for($medicationscheck)."',
		other_medications = '".s_for($med_text.$other_medications)."',
		history = '".s_for($history_arr)."',
		other_history = '".s_for($his_text.$other_history)."',
		dental_health = '".s_for($dental_health)."',
		removable = '".s_for($removable)."',
		injurytohead = '".s_for($injurytohead)."',
    injurytoface = '".s_for($injurytoface)."',
	  injurytoneck = '".s_for($injurytoneck)."',
	  injurytoteeth = '".s_for($injurytoteeth)."',
	  injurytomouth = '".s_for($injurytomouth)."',
	  drymouth = '".s_for($drymouth)."',
		year_completed = '".s_for($year_completed)."',
		tmj = '".s_for($tmj)."',
		gum_problems = '".s_for($gum_problems)."',
		dental_pain = '".s_for($dental_pain)."',
		dental_pain_describe = '".s_for($dental_pain_describe)."',
		completed_future = '".s_for($completed_future)."',
		clinch_grind = '".s_for($clinch_grind)."',
		wisdom_extraction = '".s_for($wisdom_extraction)."',
		jawjointsurgery = '".s_for($jawjointsurgery)."',
		no_allergens = '".s_for($no_allergens)."',
		no_medications = '".s_for($no_medications)."',
		no_history = '".s_for($no_history)."',
		orthodontics = '".s_for($orthodontics)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		family_hd = '".s_for($family_hd)."',
                family_bp = '".s_for($family_bp)."',
                family_dia = '".s_for($family_dia)."',
	        family_sd = '".s_for($family_sd)."',	
		alcohol = '".s_for($alcohol)."',
                sedative = '".s_for($sedative)."',
                caffeine = '".s_for($caffeine)."',
                smoke = '".s_for($smoke)."',
                smoke_packs = '".s_for($smoke_packs)."',
                tobacco = '".s_for($tobacco)."',
                additional_paragraph = '".s_for($additional_paragraph)."',
		wisdom_extraction_text  = '".s_for($wisdom_extraction_text)."',
		removable_text  = '".s_for($removable_text)."',
		dentures  = '".s_for($dentures)."',
		dentures_text  = '".s_for($dentures_text)."',
		tmj_cp  = '".s_for($tmj_cp)."',
		tmj_cp_text  = '".s_for($tmj_cp_text)."',
		tmj_pain  = '".s_for($tmj_pain)."',
		tmj_pain_text  = '".s_for($tmj_pain_text)."',
		tmj_surgery  = '".s_for($tmj_surgery)."',
		tmj_surgery_text  = '".s_for($tmj_surgery_text)."',
		injury  = '".s_for($injury)."',
		injury_text  = '".s_for($injury_text)."',
		gum_prob  = '".s_for($gum_prob)."',
		gum_prob_text  = '".s_for($gum_prob_text)."',
		gum_surgery  = '".s_for($gum_surgery)."',
		gum_surgery_text  = '".s_for($gum_surgery_text)."',
		clinch_grind_text  = '".s_for($clinch_grind_text)."',
		future_dental_det = '".s_for($future_dental_det)."',
		drymouth_text = '".s_for($drymouth_text)."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysqli_query($con, $ins_sql) or die($ins_sql." | ".mysqli_error($con));
		mysqli_query($con, "UPDATE dental_patients SET history_status=1 WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");
                mysqli_query($con, "UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");
		$ped_sql = "update dental_patients 
                	set		
			premedcheck = '".s_for($_POST["premedcheck"])."',
                	premed = '".s_for($_POST["premeddet"])."'
                	where 
                	patientid='".$_SESSION["pid"]."'";
                mysqli_query($con, $ped_sql) or die($ped_sql." | ".mysqli_error($con));

		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?= $_POST['goto_p']; ?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_page3 set 
		allergens = '".s_for($allergens_arr)."',
		allergenscheck = '".s_for($allergenscheck)."',
		other_allergens = '".s_for($all_text.$other_allergens)."',
		medications = '".s_for($medications_arr)."',
		medicationscheck = '".s_for($medicationscheck)."',
		other_medications = '".s_for($med_text.$other_medications)."',
		history = '".s_for($history_arr)."',
		other_history = '".s_for($his_text.$other_history)."',
		dental_health = '".s_for($dental_health)."',
		injurytohead = '".$injurytohead."',
		injurytoface = '".s_for($injurytoface)."',
	  injurytoneck = '".s_for($injurytoneck)."',
	  injurytoteeth = '".s_for($injurytoteeth)."',
	  injurytomouth = '".s_for($injurytomouth)."',
	  drymouth = '".s_for($drymouth)."',
		removable = '".s_for($removable)."',
		year_completed = '".s_for($year_completed)."',
		tmj = '".s_for($tmj)."',
		gum_problems = '".s_for($gum_problems)."',
		dental_pain = '".s_for($dental_pain)."',
		dental_pain_describe = '".s_for($dental_pain_describe)."',
		completed_future = '".s_for($completed_future)."',
		clinch_grind = '".s_for($clinch_grind)."',
		wisdom_extraction = '".s_for($wisdom_extraction)."',
		jawjointsurgery = '".s_for($jawjointsurgery)."',
		no_allergens = '".s_for($no_allergens)."',
		no_medications = '".s_for($no_medications)."',
		no_history = '".s_for($no_history)."',
		orthodontics = '".s_for($orthodontics)."',
                family_hd = '".s_for($family_hd)."',
                family_bp = '".s_for($family_bp)."',
                family_dia = '".s_for($family_dia)."',
		family_sd = '".s_for($family_sd)."',
                alcohol = '".s_for($alcohol)."',
                sedative = '".s_for($sedative)."',
                caffeine = '".s_for($caffeine)."',
                smoke = '".s_for($smoke)."',
                smoke_packs = '".s_for($smoke_packs)."',
                tobacco = '".s_for($tobacco)."',
                additional_paragraph = '".s_for($additional_paragraph)."',
                wisdom_extraction_text  = '".s_for($wisdom_extraction_text)."',
                removable_text  = '".s_for($removable_text)."',
                dentures  = '".s_for($dentures)."',
                dentures_text  = '".s_for($dentures_text)."',
                tmj_cp  = '".s_for($tmj_cp)."',
                tmj_cp_text  = '".s_for($tmj_cp_text)."',
                tmj_pain  = '".s_for($tmj_pain)."',
                tmj_pain_text  = '".s_for($tmj_pain_text)."',
                tmj_surgery  = '".s_for($tmj_surgery)."',
                tmj_surgery_text  = '".s_for($tmj_surgery_text)."',
                injury  = '".s_for($injury)."',
                injury_text  = '".s_for($injury_text)."',
                gum_prob  = '".s_for($gum_prob)."',
                gum_prob_text  = '".s_for($gum_prob_text)."',
                gum_surgery  = '".s_for($gum_surgery)."',
                gum_surgery_text  = '".s_for($gum_surgery_text)."',
                clinch_grind_text  = '".s_for($clinch_grind_text)."',
                future_dental_det = '".s_for($future_dental_det)."',
                drymouth_text = '".s_for($drymouth_text)."'
		where patientid = '".s_for($_SESSION['pid'])."'";
		mysqli_query($con, $ed_sql) or die($ed_sql." | ".mysqli_error($con));
                mysqli_query($con, "UPDATE dental_patients SET history_status=1 WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");
                mysqli_query($con, "UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'");
		$ped_sql = "update dental_patients 
                        set             
                        premedcheck = '".s_for($_POST["premedcheck"])."',
                        premed = '".s_for($_POST["premeddet"])."' 
                        where 
                        patientid='".$_SESSION["pid"]."'";
                mysqli_query($con, $ped_sql) or die($ped_sql." | ".mysqli_error($con));
		//echo $ed_sql;
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?= $_POST['goto_p']; ?>';
		</script>
		<?
		die();
	}
}


        $exist_sql = "SELECT history_status FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";
        $exist_q = mysqli_query($con, $exist_sql);
        $exist_row = mysqli_fetch_assoc($exist_q);
        if($exist_row['history_status'] == 0)
        {

$pat_sql = "select * from dental_patients where patientid='".s_for($_SESSION['pid'])."' ";
$pat_my = mysqli_query($con, $pat_sql);
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
$sql = "select * from dental_q_page3 where patientid='".$_SESSION['pid']."' ";
$my = mysqli_query($con, $sql);
$myarray = mysqli_fetch_array($my);

$q_page3id = st($myarray['q_page3id']);
$allergens = st($myarray['allergens']);
$allergenscheck = st($myarray['allergenscheck']);
$other_allergens = st($myarray['other_allergens']);
$medications = st($myarray['medications']);
$medicationscheck = st($myarray['medicationscheck']);
$other_medications = st($myarray['other_medications']);
$history = st($myarray['history']);
$other_history = st($myarray['other_history']);
$dental_health = st($myarray['dental_health']);
$injurytohead = st($myarray['injurytohead']);
	$injurytoface = st($myarray['injurytoface']);
	$injurytoneck = st($myarray['injurytoneck']);
	$injurytoteeth = st($myarray['injurytoteeth']);
	$injurytomouth = st($myarray['injurytomouth']);
	$drymouth = st($myarray['drymouth']);
$removable = st($myarray['removable']);
$year_completed = st($myarray['year_completed']);
$tmj = st($myarray['tmj']);
$gum_problems = st($myarray['gum_problems']);
$dental_pain = st($myarray['dental_pain']);
$dental_pain_describe = st($myarray['dental_pain_describe']);
$completed_future = st($myarray['completed_future']);
$clinch_grind = st($myarray['clinch_grind']);
$wisdom_extraction = st($myarray['wisdom_extraction']);
$jawjointsurgery = st($myarray['jawjointsurgery']);
$no_allergens = st($myarray['no_allergens']);
$no_medications = st($myarray['no_medications']);
$no_history = st($myarray['no_history']);
$orthodontics = st($myarray['orthodontics']);
$psql = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";
$pmy = mysqli_query($con, $psql);
$pmyarray = mysqli_fetch_array($pmy);
$premedcheck = st($pmyarray["premedcheck"]);
$premeddet = st($pmyarray["premed"]);
$family_hd = st($myarray["family_hd"]);
$family_bp = st($myarray["family_bp"]);
$family_dia = st($myarray["family_dia"]);
$family_sd = st($myarray["family_sd"]);
$alcohol = st($myarray['alcohol']);
$sedative = st($myarray['sedative']);
$caffeine = st($myarray['caffeine']);
$smoke = st($myarray['smoke']);
$smoke_packs = st($myarray['smoke_packs']);
$tobacco = st($myarray['tobacco']);
$additional_paragraph = st($myarray['additional_paragraph']);
        $wisdom_extraction_text = $myarray['wisdom_extraction_text'];
        $removable_text  = $myarray['removable_text'];
        $dentures  = $myarray['dentures'];
        $dentures_text  = $myarray['dentures_text'];
        $tmj_cp  = $myarray['tmj_cp'];
        $tmj_cp_text  = $myarray['tmj_cp_text'];
        $tmj_pain  = $myarray['tmj_pain'];
        $tmj_pain_text  = $myarray['tmj_pain_text'];
        $tmj_surgery  = $myarray['tmj_surgery'];
        $tmj_surgery_text  = $myarray['tmj_surgery_text'];
        $injury  = $myarray['injury'];
        $injury_text  = $myarray['injury_text'];
        $gum_prob  = $myarray['gum_prob'];
        $gum_prob_text  = $myarray['gum_prob_text'];
        $gum_surgery  = $myarray['gum_surgery'];
        $gum_surgery_text  = $myarray['gum_surgery_text'];
        $clinch_grind_text  = $myarray['clinch_grind_text'];
        $future_dental_det = $myarray['future_dental_det'];
	$drymouth_text = $myarray['drymouth_text'];

?>


<a name="top"></a>
<?php include 'includes/questionnaire_header.php'; ?>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form id="q_page3frm" class="q_form" name="q_page3frm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
<input type="hidden" name="q_page3sub" value="1" />
<input type="hidden" name="ed" value="<?=$q_page3id;?>" />
<input type="hidden" id="goto_p" name="goto_p" value="index.php" />
<div class="formEl_a">
                            <h3>Premedication<span id="req_0" class="req">*</span></h3>
                        <div class="sepH_b">
                                <label class="lbl_a">Have you been told you should receive pre medication before dental procedures?</label>
				<input id="premedcheck" name="premedcheck" tabindex="5" type="radio"  <?php if($premedcheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='block'" value="1" /> Yes 
				<input id="premedcheck" name="premedcheck" tabindex="5" type="radio"  <?php if($premedcheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='none'" value="0" /> No 
                                
                            <span id="pm_det" <?php if($premedcheck == 0){ echo 'style="display:none;"';} ?>>
				<label class="lbl_a">What medication(s) and why do you require it?</label>
                                <textarea name="premeddet" id="premeddet" class="inpt_a" style="width:610px;" tabindex="18" ><?=$premeddet;?></textarea>
                            </span>
                          
                       </div>   
                        <h3>Allergens</h3>
			<div class="sepH_b">
				<label class="lbl_a">Do you have any known allergens (for example: aspirin, latex, penicillin, etc)?</label>
                                <input id="allergenscheck" name="allergenscheck" tabindex="5" type="radio"  <?php if($allergenscheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('all_det').style.display='block'" value="1" /> Yes
                                <input id="allergenscheck" name="allergenscheck" tabindex="5" type="radio"  <?php if($allergenscheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('all_det').style.display='none'" value="0" /> No
<div style="clear:both;"></div>
			<span id="all_det" <?php if($allergenscheck == 0){ echo 'style="display:none;"';} ?>>
<?
                                                        $allergens_sql = "select * from dental_allergens where status=1 order by sortby";
                                                        $allergens_my = mysqli_query($con, $allergens_sql);
                                                                $i=0;
                                                                while($allergens_myarray = mysqli_fetch_array($allergens_my))
                                                                {
                                                                        ?>
                                        <span style="width:32%; float:left; display:block;">
                                                <input type="checkbox" name="allergens[]" value="<?=st($allergens_myarray['allergensid']);?>" class="tbox" style="width:10px;" <? if(strpos($allergens,'~'.st($allergens_myarray['allergensid']).'~') === false) {} else { echo " checked";}?> />
                                            <?=st($allergens_myarray['allergens']);?>
                                        </span>
                                    <?
                                                                        $i++;

                                                                 } ?>
                            	<label class="lbl_a" style="clear:both">Please list everything you are allergic to:</label> 
                            <textarea name="other_allergens" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_allergens;?></textarea>
			</span>
                    </div>
                        <h3>Medications currently being taken</h3>
                    <div class="sepH_b">
                                <label class="lbl_a">Are you currently taking any medications?</label>
                                <input id="medicationscheck" name="medicationscheck" tabindex="5" type="radio"  <?php if($medicationscheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('med_det').style.display='block'" value="1" /> Yes
                                <input id="medicationscheck" name="medicationscheck" tabindex="5" type="radio"  <?php if($medicationscheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('med_det').style.display='none'" value="0" /> No
<div style="clear:both;"></div>
                        <span id="med_det" <?php if($medicationscheck == 0){ echo 'style="display:none;"';} ?>>
                                <?
                                                        $medications_sql = "select * from dental_medications where status=1 order by sortby";
                                                        $medications_my = mysqli_query($con, $medications_sql);
                                                                $i=0;
                                                                while($medications_myarray = mysqli_fetch_array($medications_my))
                                                                {
                                                                        ?>
                                        <span style="width:32%; float:left; display:block;">
                                                <input type="checkbox" name="medications[]" value="<?=st($medications_myarray['medicationsid']);?>" class="tbox" style="width:10px;" <? if(strpos($medications,'~'.st($medications_myarray['medicationsid']).'~') === false) {} else { echo " checked";}?> />
                                            <?=st($medications_myarray['medications']);?>
                                        </span>
                                    <?
                                                                        $i++;
                                                                 }?>

                            	<label class="lbl_a" style="clear:both;">Please list all medications you are currently taking:</label> 
                            <textarea name="other_medications" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_medications;?></textarea>
			</span>
                    </div>
                    
                        <h3>Medical History</h3>
			<div class="sepH_b">
                                <?
                                                        $history_sql = "select * from dental_history where status=1 order by history";
                                                        $history_my = mysqli_query($con, $history_sql);
                                                                $i=0;
                                                                while($history_myarray = mysqli_fetch_array($history_my))
                                                                {
                                                                        ?>
                                        <span style="width:32%; float:left; display:block;">
                                                <input type="checkbox" name="history[]" value="<?=st($history_myarray['historyid']);?>" class="tbox" style="width:10px;" <? if(strpos($history,'~'.st($history_myarray['historyid']).'~') === false) {} else { echo " checked";}?> />
                                            <?=st($history_myarray['history']);?>
                                        </span>
                                    <?
                                                                        $i++;
                                                                 }?>
                            	<label class="lbl_a" style="clear:both;">List all other medical diagnoses and surgeries from birth until now:</label>
                            <textarea name="other_history" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_history;?></textarea>
                    </div>
                        
			<h3>Dental History</h3>
                    <div class="sepH_b clear half">
			<label class="lbl_in2">How would you describe your dental health?</label>
                            <select name="dental_health" class="inpt_in2">
                            	<option value=""></option>
                                <option value="Excellent" <? if($dental_health == 'Excellent' ) echo " selected";?>>
                                	Excellent
                                </option>
                                <option value="Good" <? if($dental_health == 'Good' ) echo " selected";?>>
                                	Good
                                </option>
                                <option value="Fair" <? if($dental_health == 'Fair' ) echo " selected";?>>
                                	Fair
                                </option>
                                <option value="Poor" <? if($dental_health == 'Poor' ) echo " selected";?>>
                                	Poor
                                </option>
                            </select>
					</div>
					
					<div class="sepH_b half">
							<label class="lbl_in2">Have you ever had teeth extracted?</label>
							
							<input type="radio" class="extra" name="wisdom_extraction" value="Yes" <? if($wisdom_extraction == 'Yes') echo " checked";?> /> Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="wisdom_extraction" value="No" <? if($wisdom_extraction == 'No') echo " checked";?> /> No
                                                        <span id="wisdom_extraction_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="wisdom_extraction_text" name="wisdom_extraction_text" value="<?= $wisdom_extraction_text; ?>" /></span>
					</div>
					
					<div class="sepH_b clear half">
							<label class="lbl_in2">Do you wear removable partials?</label>
							
							<input type="radio" class="extra" name="removable" value="Yes" <? if($removable == 'Yes') echo " checked";?> /> Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="removable" value="No" <? if($removable == 'No') echo " checked";?> /> No
                                                        <span id="removable_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="removable_text" name="removable_text" value="<?= $removable_text; ?>" /></span>
					</div>
                                       <div class="sepH_b half">
                                                        <label class="lbl_in2">Do you wear dentures?</label>

                                                        <input type="radio" class="extra" name="dentures" value="Yes" <? if($dentures == 'Yes') echo " checked";?> /> Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="dentures" value="No" <? if($dentures == 'No') echo " checked";?> /> No
                                                        <span id="dentures_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="dentures_text" name="dentures_text" value="<?= $dentures_text; ?>" /></span>
                                        </div>

					
					<div class="sepH_b  clear half">
							<label class="lbl_in2">Do you wear orthodontics (braces)?</label>
							
							<input type="radio" class="extra" name="orthodontics" value="Yes" <? if($orthodontics == 'Yes') echo " checked";?>  onclick="chk_ortho()"  /> Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="orthodontics" value="No" <? if($orthodontics == 'No') echo " checked";?>  onclick="chk_ortho()" /> No
							<span id="orthodontics_extra"><label class="lbl_in2">Year completed:</label>
                            <input id="year_completed" name="year_completed" type="text" class="inpt_in2" value="<?=$year_completed;?>" maxlength="255" /></span>
					</div>
					
                                        <div class="sepH_b half">
                        <span>
                                                        <label class="lbl_in2">Does your TMJ (jaw joint) click or pop?</label>
                                                        <input type="radio" class="extra" name="tmj_cp" value="Yes" <? if($tmj_cp == 'Yes') echo " checked";?> /> Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="tmj_cp" value="No" <? if($tmj_cp == 'No') echo " checked";?> /> No
                                                        <span id="tmj_cp_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="tmj_cp_text" name="tmj_cp_text" value="<?= $tmj_cp_text; ?>" /></span>
                                        </div>
                                        <div class="sepH_b clear half">
							<label class="lbl_in2">Do you have pain in your jaw joint?</label>
                                                        <input type="radio" class="extra" name="tmj_pain" value="Yes" <? if($tmj_pain == 'Yes') echo " checked";?> /> Yes
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="extra" name="tmj_pain" value="No" <? if($tmj_pain == 'No') echo " checked";?> /> No
                                                        <span id="tmj_pain_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="tmj_pain_text" name="tmj_pain_text" value="<?= $tmj_pain_text; ?>" /></span>
                                        </div>

					<div class="sepH_b half">
							<label class="lbl_in2">Have you had TMJ (jaw joint) surgery?</label>
							<input type="radio" class="extra" name="tmj_surgery" value="Yes" <? if($tmj_surgery == 'Yes') echo " checked";?> /> Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
							<input type="radio" class="extra" name="tmj_surgery" value="No" <? if($tmj_surgery == 'No') echo " checked";?> /> No
							<span id="tmj_surgery_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="tmj_surgery_text" name="tmj_surgery_text" value="<?= $tmj_surgery_text; ?>" /></span>
					</div>
				        <div class="sepH_b clear half">
                                                        <label class="lbl_in2">Have you ever had injury to your head, face, neck, mouth, or teeth?</label>

                                                        <input type="radio" class="extra" name="injury" value="Yes" <? if($injury == 'Yes') echo " checked";?> /> Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="injury" value="No" <? if($injury == 'No') echo " checked";?> /> No
							<span id="injury_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="injury_text" name="injury_text" value="<?= $injury_text; ?>" /></span>
                                                </span>
                                        </div>
					<div class="sepH_b half">
							<label class="lbl_in2">Do you have morning dry mouth?</label>
							
							<input type="radio" class="extra" name="drymouth" value="Yes" <? if($drymouth == 'Yes') echo " checked";?> /> Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="drymouth" value="No" <? if($drymouth == 'No') echo " checked";?> /> No
                                                        <span id="drymouth_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="drymouth_text" name="drymouth_text" value="<?= $drymouth_text; ?>" /></span>							
					</div>
					
					<div class="sepH_b clear half">
							<label class="lbl_in2">Have you ever had gum problems?</label>
                            <input id="gum_prob" class="extra" name="gum_prob" type="radio" value="Yes" <?= ($gum_prob=='Yes')?'checked="checked"':'';?> /> Yes
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="gum_prob" class="extra" name="gum_prob" type="radio" value="No" <?= ($gum_prob=='No')?'checked="checked"':'';?> /> No 
                                                        <span id="gum_prob_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="gum_prob_text" name="gum_prob_text"  value="<?= $gum_prob_text; ?>" /></span> 
					</div>
					                                        
                                        <div class="sepH_b half">
                                                        <label class="lbl_in2">Have you ever had gum surgery?</label>

                                                        <input type="radio" class="extra" name="gum_surgery" value="Yes" <? if($gum_surgery == 'Yes') echo " checked";?> /> Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra" name="gum_surgery" value="No" <? if($gum_surgery == 'No') echo " checked";?> /> No
							<span id="gum_surgery_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="gum_surgery_text" name="gum_surgery_text" value="<?= $gum_surgery_text; ?>" /></span> 
                                        </div>

					
					<div class="sepH_b clear half">
							<label class="lbl_in2">Are you planning to have dental work done in the near future?</label>
							
	
							<input type="radio" class="extra" name="completed_future" value="Yes" <? if($completed_future == 'Yes') echo " checked";?> /> Yes
						 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
							<input type="radio" class="extra" name="completed_future" value="No" <? if($completed_future == 'No') echo " checked";?> /> No
							
<span id="completed_future_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="future_dental_det" name="future_dental_det"  value="<?= $future_dental_det; ?>" /></span>
					</div>
					
					<div class="sepH_b half">
							<label class="lbl_in2">Do you clinch or grind your teeth?</label>
							
							<input type="radio" class="extra" name="clinch_grind" value="Yes" <? if($clinch_grind == 'Yes') echo " checked";?> /> Yes
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio" class="extra" name="clinch_grind" value="No" <? if($clinch_grind == 'No') echo " checked";?> /> No
							<span id="clinch_grind_extra"><label class="lbl_in2">Please describe:</label><input type="text" class="inpt_in2" id="clinch_grind_text" name="clinch_grind_text" value="<?= $clinch_grind_text; ?>" /></span>
					</div>

                        <h3 class="clear">Family History</h3>
			<p>Have genetic members of your family had</p>
                    <div class="sepH_b half">
				<label class="lbl_in2">Heart Disease?</label>
                                                <input type="radio" name="family_hd" value="Yes" <?= ($family_hd == "Yes")?'checked="checked"':''; ?> /> Yes
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="family_hd" value="No" <?= ($family_hd == "No")?'checked="checked"':''; ?> /> No
		    </div>
		    <div class="sepH_b half">
				<label class="lbl_in2">High Blood Pressure?</label>
                                                <input type="radio" name="family_bp" value="Yes" <?= ($family_bp == "Yes")?'checked="checked"':''; ?> /> Yes
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="family_bp" value="No" <?= ($family_bp == "No")?'checked="checked"':''; ?> /> No
		    </div>
		    <div class="sepH_b clear half">
			     <label class="lbl_in2">Diabetes?</label>
                                                <input type="radio" name="family_dia" value="Yes" <?= ($family_dia == "Yes")?'checked="checked"':''; ?> /> Yes
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="family_dia" value="No" <?= ($family_dia == "No")?'checked="checked"':''; ?> /> No
		</div>
		<div class="sepH_b half">
				<label class="lbl_in2">Have any genetic members of your family been diagnosed or treated for a sleep disorder?</label>
				<input type="radio" name="family_sd" value="Yes" <?= ($family_sd == "Yes")?'checked="checked"':''; ?> /> Yes
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="family_sd" value="No" <?= ($family_sd == "No")?'checked="checked"':''; ?> /> No
		</div>
                        <h3 class="clear">Social History</h3>
                    <div class="sepH_b">
                                <label class="lbl_a">Alcohol consumption: How often do you consume alcohol within 2-3 hours of bedtime?</label>
                            <input type="radio" name="alcohol" value="Daily" class="tbox" <? if($alcohol == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="occasionally" class="tbox" <? if($alcohol == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="never" class="tbox" <? if($alcohol == 'never')  echo " checked";?> />
                            Never
		</div>
		<div class="sepH_b">
                            <label class="lbl_a">Sedative Consumption: How often do you take sedatives within 2-3 hours of bedtime?</label>
                            <input type="radio" name="sedative" value="Daily" class="tbox" <? if($sedative == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="sedative" value="occasionally" class="tbox" <? if($sedative == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="sedative" value="never" class="tbox" <? if($sedative == 'never')  echo " checked";?> />
                            Never
		</div>
		<div class="sepH_b">
                            <label class="lbl_a">Caffeine consumption: How often do you consume caffeine within 2-3 hours of bedtime?</label>
                            <input type="radio" name="caffeine" value="Daily" class="tbox" <? if($caffeine == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="occasionally" class="tbox" <? if($caffeine == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="never" class="tbox" <? if($caffeine == 'never')  echo " checked";?> />
                            Never
		</div>
		<div class="sepH_b">
                            <label class="lbl_a">Do you Smoke?</label>
                            <input type="radio" name="smoke" value="Yes" class="tbox" <? if($smoke == 'Yes')  echo " checked";?>  onclick="$('#smoke').show();" />
                            Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="smoke" value="No" class="tbox" <? if($smoke == 'No')  echo " checked";?> onclick="$('#smoke').hide()" />
                            No
		</div>
                            <div class="sepH_b" id="smoke" <?= ($smoke!='Yes')?'style="display:none;"':''; ?>>
				<label class="lbl_a">If Yes, number of packs per day</label>
                            <input type="text" name="smoke_packs" value="<?=$smoke_packs?>" class="inpt_a" />
                            </div>
		<div class="sepH_b">
                            <label class="lbl_a">Do you use Chewing Tobacco?</label>
                            <input type="radio" name="tobacco" value="Yes" class="tbox" <? if($tobacco == 'Yes')  echo " checked";?> />
                            Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="tobacco" value="No" class="tbox" <? if($tobacco == 'No')  echo " checked";?> />
                            No
                                        </div>
                    <div class="sepH_b">
				<label class="lbl_a">Additional Paragraph</label>
                            <textarea name="additional_paragraph" class="inpt_a" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                    </div>

<p class="confirm_text">Thank you for completing the Health History Questionnaire! Please click the box below to confirm and record your answers.</p>

<div align="right">
    <input type="submit" name="q_pagebtn" class="next btn btn_d" value="Save and Proceed" tabindex="12" />
    &nbsp;&nbsp;&nbsp;
</div>
</div>
</form>

<script type="text/javascript">
	//chk_allergens();
	//chk_medications();
	//chk_history();
	//chk_ortho();
</script>

                                        <script type="text/javascript">

                                                $(document).ready( function(){
                                                        $('.extra').each(function(){
                                                                var v = $(this).val();
                                                                var n = $(this).attr('name');
                                                                var c = $(this).attr('checked');
                                                                if(v=="Yes"){                                                                        if(c){
                                                                                $('#'+n+'_extra').css('display', 'inline');
                                                                        }else{
                                                                                $('#'+n+'_extra').css('display', 'none');                                                                        }
                                                                }                                                                                
                                                        });

                                                });
                                                $(function(){
                                                $('.extra').click(function(e){
                                                        var v = e.target.value;
                                                        var n = e.target.name;
                                                        if(v=="Yes"){
                                                                $('#'+n+'_extra').css('display', 'inline');
                                                        }else{
                                                                $('#'+n+'_extra').css('display', 'none');
                                                        }                                                });
                                                })

                                        </script>



<?php }else{
show_section_completed($_SESSION['pid']);
} ?>

<? include "includes/footer.php";?>

