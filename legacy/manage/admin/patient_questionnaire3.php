<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include "includes/patient_nav.php";
?>
<ul class="nav nav-tabs nav-justified">
    <li>
        <a href="patient_questionnaire.php?pid=<?= $_GET['pid']; ?>" id="link_summ">Sleep Symptoms</a>
    </li>
    <li>
        <a href="patient_questionnaire5.php?pid=<?= $_GET['pid']; ?>" id="link_notes">Pain/TMD Symptoms</a>
    </li>
    <li>
        <a href="patient_questionnaire2.php?pid=<?= $_GET['pid']; ?>" id="link_notes">Previous Treatments</a>
    </li>
    <li class="active">
        <a href="patient_questionnaire3.php?pid=<?= $_GET['pid']; ?>" id="link_treatment">Health Hx.</a>
    </li>
</ul>
<p>&nbsp;</p>
<?php
if (!empty($_GET['own']) && $_GET['own'] == 1) {
    $c_sql = "SELECT patientid FROM dental_patients WHERE (symptoms_status=1 || sleep_status=1 || treatments_status=1 || history_status=1) AND patientid='".mysqli_real_escape_string($con, $_GET['pid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
    $c_q = mysqli_query($con, $c_sql);
    $changed = mysqli_num_rows($c_q);

    $own_sql = "UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE patientid='".mysqli_real_escape_string($con, $_GET['pid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
    mysqli_query($con, $own_sql);
    if ($_GET['own_completed'] == 1) {
        $q1_sql = "SELECT q_page1id from dental_q_page1_pivot WHERE patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";
        $q1_q = mysqli_query($con, $q1_sql);
        if (mysqli_num_rows($q1_q) == 0) {
            $ed_sql = "INSERT INTO dental_q_page1 SET exam_date=now(), patientid='".$_GET['pid']."'";
            mysqli_query($con, $ed_sql);
        } else {
            $qPage1Id = mysqli_fetch_field($q1_q);
            $ed_sql = "UPDATE dental_q_page1 SET exam_date=now() WHERE q_page1id=$qPage1Id";
            mysqli_query($con, $ed_sql);
        }
    } ?>
    <script type="text/javascript">
        <?php if ($changed > 0) { ?>
            alert("Warning! Patient has made changes to the Questionnaire. Please review the patient's ENTIRE questionnaire for changes.");
        <?php } ?>

        window.location='q_page3.php?pid=<?=$_GET['pid']?>&addtopat=1';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
} ?>
<script type="text/javascript">
    edited = false;
    $(document).ready(function () {
        $(':input:not(#patient_search)').change(function () {
            edited = true;
        });
        $('#q_page3frm').submit(function () {
            window.onbeforeunload = null;
        });
    });
    function confirmExit() {
        return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
    }
</script>
<?php
if (!empty($_POST['q_page3sub']) && $_POST['q_page3sub'] == 1) {
    $allergens = $_POST['allergens'];
    $other_allergens = $_POST['other_allergens'];
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
    $allergenscheck = $_POST["allergenscheck"];
    $medicationscheck = $_POST["medicationscheck"];
    $historycheck = $_POST["historycheck"];
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

    $allergens_arr = '';
    if (is_array($allergens)) {
        foreach ($allergens as $val) {
            if (trim($val) != '') {
                $allergens_arr .= trim($val).'~';
            }
        }
    }

    if ($allergens_arr != '') {
        $allergens_arr = '~' . $allergens_arr;
    }

    $medications_arr = '';
    if (is_array($medications)) {
        foreach ($medications as $val) {
            if (trim($val) != '') {
                $medications_arr .= trim($val) . '~';
            }
        }
    }

    if ($medications_arr != '') {
        $medications_arr = '~' . $medications_arr;
    }

    $history_arr = '';
    if (is_array($history)) {
        foreach ($history as $val) {
            if (trim($val) != '') {
                $history_arr .= trim($val) . '~';
            }
        }
    }
	
    if ($history_arr != '') {
        $history_arr = '~' . $history_arr;
    }

    if ($_POST['ed'] == '') {
        $ins_sql = "insert into dental_q_page3 set 
            patientid = '".s_for($_GET['pid'])."',
            allergens = '".s_for($allergens_arr)."',
            other_allergens = '".s_for($other_allergens)."',
            medications = '".s_for($medications_arr)."',
            other_medications = '".s_for($other_medications)."',
            history = '".s_for($history_arr)."',
            other_history = '".s_for($other_history)."',
            allergenscheck = '".s_for($allergenscheck)."',
            medicationscheck = '".s_for($medicationscheck)."',
            historycheck = '".s_for($historycheck)."',
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

		mysqli_query($con, $ins_sql) or trigger_error($ins_sql." | ".mysqli_error($con), E_USER_ERROR);
        $ped_sql = "update dental_patients 
            set		
            premedcheck = '".s_for($_POST["premedcheck"])."',
            premed = '".s_for($_POST["premeddet"])."'
            where 
            patientid='".$_GET["pid"]."'";
        mysqli_query($con, $ped_sql) or trigger_error($ped_sql." | ".mysqli_error($con), E_USER_ERROR);

        $msg = "Added Successfully";
        if (isset($_POST['q_pagebtn_proceed'])) { ?>
            <script type="text/javascript">
                    window.location='q_page1.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
            </script>
            <?php
        } else { ?>
            <script type="text/javascript">
                window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
            </script>
            <?php
        }
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $ed_sql = " update dental_q_page3 set 
            allergens = '".s_for($allergens_arr)."',
            other_allergens = '".s_for($other_allergens)."',
            medications = '".s_for($medications_arr)."',
            other_medications = '".s_for($other_medications)."',
            history = '".s_for($history_arr)."',
            other_history = '".s_for($other_history)."',
            allergenscheck = '".s_for($allergenscheck)."',
            medicationscheck = '".s_for($medicationscheck)."',
            historycheck = '".s_for($historycheck)."',
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
    		where q_page3id = '".s_for($_POST['ed'])."'";
        mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);

        $ped_sql = "update dental_patients 
            set             
            premedcheck = '".s_for($_POST["premedcheck"])."',
            premed = '".s_for($_POST["premeddet"])."' 
            where 
            patientid='".$_GET["pid"]."'";
        mysqli_query($con, $ped_sql) or trigger_error($ped_sql." | ".mysqli_error($con), E_USER_ERROR);

		$msg = "Edited Successfully";
        if (isset($_POST['q_pagebtn_proceed'])) { ?>
            <script type="text/javascript">
                    window.location='q_page1.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
            </script>
            <?php
        } else { ?>
            <script type="text/javascript">
                window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
            </script>
            <?php
        }
        trigger_error("Die called", E_USER_ERROR);
    }
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con, $pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

$sqldpp = "select * from dental_patients where parent_patientid='".$_GET['pid']."'";
$mydpp = mysqli_query($con,$sqldpp);
$dpp_row = mysqli_fetch_array($mydpp);

$sql = "select * from dental_q_page3_pivot where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$q_page3id = st($myarray['q_page3id']);
$other_allergens = st($myarray['other_allergens']);
$other_medications = st($myarray['other_medications']);
$other_history = st($myarray['other_history']);
$dental_health = st($myarray['dental_health']);
$drymouth = st($myarray['drymouth']);
$removable = st($myarray['removable']);
$year_completed = st($myarray['year_completed']);
$completed_future = st($myarray['completed_future']);
$clinch_grind = st($myarray['clinch_grind']);
$wisdom_extraction = st($myarray['wisdom_extraction']);
$orthodontics = st($myarray['orthodontics']);

$psql = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
$pmy = mysqli_query($con,$psql);
$pmyarray = mysqli_fetch_array($pmy);
$premedcheck = st($pmyarray["premedcheck"]);
$allergenscheck = st($myarray["allergenscheck"]);
$medicationscheck = st($myarray["medicationscheck"]);
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
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
<style type="text/css">
    label {
      width: 250px;
      float: left;
    }
</style>
<link rel="stylesheet" href="css/questionnaire.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/questionnaire.js"></script>

<a name="top"></a>
<?php include "../includes/form_top.htm";?>

<br />
<br />

<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<script type="text/javascript">
    function chk_allergens() {
        fa = document.q_page3frm;
        chk_l = document.getElementsByName('allergens[]').length;
        if (fa.no_allergens.checked) {
            for (var i = 0; i < chk_l; i++) {
                document.getElementsByName('allergens[]')[i].disabled = true;
            }
            fa.other_allergens.disabled = true;
        } else {
            for (var i = 0; i < chk_l; i++) {
                document.getElementsByName('allergens[]')[i].disabled = false;
            }
            fa.other_allergens.disabled = false;
        }
    }

    function chk_medications() {
        fa = document.q_page3frm;
        chk_l = document.getElementsByName('medications[]').length;
        if (fa.no_medications.checked) {
            for (var i = 0; i < chk_l; i++) {
                document.getElementsByName('medications[]')[i].disabled = true;
            }
            fa.other_medications.disabled = true;
        } else {
            for (var i = 0; i < chk_l; i++) {
                document.getElementsByName('medications[]')[i].disabled = false;
            }
            fa.other_medications.disabled = false;
        }
    }
	
    function chk_history() {
        fa = document.q_page3frm;
        chk_l = document.getElementsByName('history[]').length;
        if (fa.no_history.checked) {
            for (var i = 0; i < chk_l; i++) {
                document.getElementsByName('history[]')[i].disabled = true;
            }
            fa.other_history.disabled = true;
        } else {
            for (var i = 0; i < chk_l; i++) {
                document.getElementsByName('history[]')[i].disabled = false;
            }
            fa.other_history.disabled = false;
        }
    }

    function chk_ortho() {
        fa = document.q_page3frm;
        if (fa.orthodontics[1].checked) {
            fa.year_completed.disabled = true;
        } else {
            fa.year_completed.disabled = false;
        }
    }
</script>

<form id="q_page3frm" class="q_form" name="q_page3frm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?>" method="post">
    <input type="hidden" name="q_page3sub" value="1" />
    <input type="hidden" name="ed" value="<?=$q_page3id;?>" />
    <input type="hidden" name="goto_p" value="<?=$cur_page?>" />

    <div style="clear:both;"></div>
    <?php
    $patient_sql = "SELECT * FROM dental_q_page3_pivot WHERE parent_patientid='".mysqli_real_escape_string($con, $_GET['pid'])."'";
    $patient_q = mysqli_query($con,$patient_sql);
    $pat_row = mysqli_fetch_assoc($patient_q);
    if (mysqli_num_rows($patient_q) == 0) {
        $showEdits = false;
    } else {
        $showEdits = true;
    } ?>
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0" style="width:90%;">
                            Premedication
                            <span id="req_0" class="req">*</span>
                        </label><br />
                        <div>
                            <span>
                                Have you been told you should receive pre-medication before dental procedures?
                                <input id="premedcheck" class="premedcheck_radio" name="premedcheck" tabindex="5" type="radio"  <?php if ($premedcheck == 1) { echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='block'" value="1" /> Yes
                                <input id="premedcheck" class="premedcheck_radio" name="premedcheck" tabindex="5" type="radio"  <?php if ($premedcheck == 0) { echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='none'" value="0" /> No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'premedcheck', $dpp_row['premedcheck'], $premedcheck, true, $showEdits, 'radio');
                                ?>
                            </span>
                            <span id="pm_det" <?php if ($premedcheck == 0 && (!$showEdits || $premedcheck == $dpp_row['premedcheck'])) { echo 'style="display:none;"';} ?>>
                                What medication(s) and why do you require it?<br />
                                <textarea name="premeddet" id="premeddet" class="field text addr tbox" style="width:610px;" tabindex="18" ><?=$premeddet;?></textarea>
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'premeddet', $dpp_row['premeddet'], $premeddet, true, $showEdits);
                                ?>
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
                        <label class="desc" id="title0" for="Field0" style="width:90%">
                            Allergens
                        </label><br />
                        <div>
                            <span>
                                <span>
                                    Do you have any known allergens (for example: aspirin, latex, penicillin, etc)?
                                    <input id="allergenscheck" class="allergenscheck_radio" name="allergenscheck" tabindex="5" type="radio"  <?php if($allergenscheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('a_det').style.display='block';$('#hide_other_allergens').hide();$('#show_other_allergens').show();" value="1" /> Yes
                                    <input id="allergenscheck" class="allergenscheck_radio" name="allergenscheck" tabindex="5" type="radio"  <?php if($allergenscheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('a_det').style.display='none';$('#hide_other_allergens').hide();$('#show_other_allergens').hide();$('#other_allergens_list').hide();" value="0" /> No
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'allergenscheck', $pat_row['allergenscheck'], $allergenscheck, true, $showEdits, 'radio');
                                    ?>
                                    <a href="#" id="show_other_allergens" onclick="$('#other_allergens_list').show();$(this).hide();$('#hide_other_allergens').show();return false;" class="addButton"<?php if ($allergenscheck == 0 ) { echo 'style="display:none;"';} ?> >View List</a>
                                    <a href="#" id="hide_other_allergens" onclick="$('#other_allergens_list').hide();$(this).hide();$('#show_other_allergens').show();return false;" class="addButton" style="display:none;">Hide List</a>
                                </span>
                                <span id="other_allergens_list" style="margin-top:10px; display:none;">
                                    <span style="display:block; width:100%; height:20px;">Click any item to add it to the text box below.</span>
                                    <?php
                                    $allergens_sql = "select * from dental_allergens where status=1 order by sortby";
                                    $allergens_my = mysqli_query($con, $allergens_sql);
                                    $i = 0;
                                    while ($allergens_myarray = mysqli_fetch_array($allergens_my)) { ?>
                                        <span style="width:32%; float:left; display:block;height:20px;">
                                            <a class="addButton" onclick="$(this).addClass('grayButton');$('#other_allergens').append('<?=st($allergens_myarray['allergens']);?>, ');return false;">
                                                <?=st($allergens_myarray['allergens']);?>
                                            </a>
                                        </span>
                                        <?php
                                        $i++;
                                    } ?>
                                </span>
                                <span id="a_det" <?php if ($allergenscheck == 0 && (!$showEdits || $allergenscheck == $dpp_row['allergenscheck'])) { echo 'style="display:none;"';} ?>>
                                    Please list everything you are allergic to:<br />
                                    <textarea name="other_allergens" id="other_allergens" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_allergens;?></textarea>
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'other_allergens', $pat_row['other_allergens'], $other_allergens, true, $showEdits);
                                    ?>
                                </span>
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
                        <label class="desc" id="title0" for="Field0" style="width:90%">
                            Current Medications
                        </label><br />
                        <div>
                            <span>
                                <span>
                                    Are you currently taking any medications?
                                    <input id="medicationscheck" class="medicationscheck_radio" name="medicationscheck" tabindex="5" type="radio"  <?php if ($medicationscheck == 1) { echo "checked=\"checked\"";} ?> onclick="document.getElementById('m_det').style.display='block';$('#hide_other_medications').hide();$('#show_other_medications').show();" value="1" /> Yes
                                    <input id="medicationscheck" class="medicationscheck_radio" name="medicationscheck" tabindex="5" type="radio"  <?php if ($medicationscheck == 0) { echo "checked=\"checked\"";} ?> onclick="document.getElementById('m_det').style.display='none';$('#hide_other_medications').hide();$('#show_other_medications').hide();$('#other_medications_list').hide();" value="0" /> No
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'medicationscheck', $pat_row['medicationscheck'], $medicationscheck, true, $showEdits, 'radio');
                                    ?>
                                    <a href="#" id="show_other_medications" onclick="$('#other_medications_list').show();$(this).hide();$('#hide_other_medications').show();return false;" class="addButton" <?php if ($medicationscheck == 0) { echo 'style="display:none;"';} ?>>View List</a>
                                    <a href="#" id="hide_other_medications" onclick="$('#other_medications_list').hide();$(this).hide();$('#show_other_medications').show();return false;" class="addButton" style="display:none;">Hide List</a>
                                </span>
                                <span style="margin-top:10px;display:none;" id="other_medications_list">
                                <span style="display:block; width:100%; height:20px;">Click any item to add it to the text box below.</span>
                                    <?php
                                    $medications_sql = "select * from dental_medications where status=1 order by sortby";
                                    $medications_my = mysqli_query($con, $medications_sql);
                                    $i = 0;
                                    while ($medications_myarray = mysqli_fetch_array($medications_my)) { ?>
                                        <span style="width:32%; float:left; display:block;height:20px;">
                                            <a class="addButton" onclick="$(this).addClass('grayButton');$('#other_medications').append('<?=st($medications_myarray['medications']);?>, ');return false;">
                                                <?=st($medications_myarray['medications']);?>
                                            </a>
                                        </span>
                                        <?php
                                        $i++;
                                    } ?>
                                </span>
                                <span id="m_det" <?php if ($medicationscheck == 0 && (!$showEdits || $medicationscheck == $dpp_row['medicationscheck'])) { echo 'style="display:none;"';} ?>>
                                    Please list all medication you are currently taking: <br />
                                    <textarea name="other_medications" id="other_medications" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_medications;?></textarea>
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'other_medications', $pat_row['other_medications'], $other_medications, true, $showEdits);
                                    ?>
                                </span>
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
                        <label class="desc" id="title0" for="Field0" style="width:90%;">
                            Medical History
                        </label>
                        <a href="#" id="show_other_history" onclick="$('#other_history_list').show();$(this).hide();$('#hide_other_history').show();return false;" class="addButton">View List</a>
                        <a href="#" id="hide_other_history" onclick="$('#other_history_list').hide();$(this).hide();$('#show_other_history').show();return false;" class="addButton" style="display:none;">Hide List</a>
                        <span id="other_history_list" style="display:none;">
                            <span style="display:block; width:100%; height:20px;">Click any item to add it to the text box below.</span>
                            <?php
                            $history_sql = "select * from dental_history where status=1 order by history";
                            $history_my = mysqli_query($con, $history_sql);
                            $i = 0;
                            while ($history_myarray = mysqli_fetch_array($history_my)) { ?>
                                <span style="width:32%; float:left; display:block;height:20px;">
                                    <a class="addButton" onclick="$(this).addClass('grayButton');$('#other_history').append('<?=st($history_myarray['history']);?>, '); return false;">
                                        <?=st($history_myarray['history']);?>
                                    </a>
                                </span>
                                <?php
                                $i++;
                             } ?>
                        </span>
                        <div>
                            <span>
                                <span>
                                    Please list all medical diagnoses and surgeries from birth until now (for example: heart attack, high blood pressure, asthma, stroke, hip replacement, HIV, diabetes, etc):
                                </span>
                                 <span id="h_det" >
                                     <textarea name="other_history" id="other_history" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_history;?></textarea>
                                     <?php
                                     showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'other_history', $pat_row['other_history'], $other_history, true, $showEdits);
                                     ?>
                                 </span>
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
                            Dental History
                        </label>
                        <div>
                            <span class="full">
                                How would you describe your dental health?
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <select name="dental_health" style="width:250px;">
                                    <option value=""></option>
                                    <option value="Excellent" <?php if ($dental_health == 'Excellent') echo " selected";?>>
                                        Excellent
                                    </option>
                                    <option value="Good" <?php if ($dental_health == 'Good') echo " selected";?>>
                                        Good
                                    </option>
                                    <option value="Fair" <?php if ($dental_health == 'Fair') echo " selected";?>>
                                        Fair
                                    </option>
                                    <option value="Poor" <?php if ($dental_health == 'Poor') echo " selected";?>>
                                        Poor
                                    </option>
                                </select>
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'dental_health', $pat_row['dental_health'], $dental_health, true, $showEdits);
                                ?>
                            </span>
                        </div>
                        <script type="text/javascript">
                            $('document').ready(function () {
                                $('.extra').each(function () {
                                    var v = $(this).val();
                                    var n = $(this).attr('name');
                                    var c = $(this).attr('checked');
                                    if (v == "Yes") {
                                        if (c) {
                                            $('#' + n + '_extra').css('display', 'inline');
                                        } else {
                                            $('#' + n + '_extra').css('display', 'none');
                                        }
                                    }
                                });
                            });
                            $(function () {
                                $('.extra').click(function (e) {
                                    var v = e.target.value;
                                    var n = e.target.name;
                                    if (v == "Yes") {
                                        $('#' + n + '_extra').css('display', 'inline');
                                    } else {
                                        $('#' + n + '_extra').css('display', 'none');
                                    }
                                });
                            });
                        </script>
                        <div>
                            <span>
                                <label>Have you ever had teeth extracted?</label>
                                <input type="radio" class="extra wisdom_extraction_radio" name="wisdom_extraction" value="Yes" <?php if ($wisdom_extraction == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra wisdom_extraction_radio" name="wisdom_extraction" value="No" <?php if ($wisdom_extraction == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'wisdom_extraction', $pat_row['wisdom_extraction'], $wisdom_extraction, true, $showEdits, 'radio');
                                ?>
                                <span id="wisdom_extraction_extra">Please describe: <input type="text" class="field text addr tbox" id="wisdom_extraction_text" name="wisdom_extraction_text" value="<?= $wisdom_extraction_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'wisdom_extraction_text', $pat_row['wisdom_extraction_text'], $wisdom_extraction_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Do you wear removable partials?</label>
                                <input type="radio" class="extra removable_radio" name="removable" value="Yes" <?php if ($removable == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra removable_radio" name="removable" value="No" <?php if ($removable == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'removable', $pat_row['removable'], $removable, true, $showEdits, 'radio');
                                ?>
                                <span id="removable_extra">Please describe: <input type="text" class="field text addr tbox" id="removable_text" name="removable_text" value="<?= $removable_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'removable_text', $pat_row['removable_text'], $removable_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Do you wear dentures?</label>
                                <input type="radio" class="extra dentures_radio" name="dentures" value="Yes" <?php if ($dentures == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra dentures_radio" name="dentures" value="No" <?php if ($dentures == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'dentures', $pat_row['dentures'], $dentures, true, $showEdits, 'radio');
                                ?>
                                <span id="dentures_extra">Please describe: <input type="text" class="field text addr tbox" id="dentures_text" name="dentures_text" value="<?= $dentures_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'dentures_text', $pat_row['dentures_text'], $dentures_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Have you worn orthodontics (braces)?</label>
                                <input type="radio" class="extra orthodontics_radio" name="orthodontics" value="Yes" <?php if ($orthodontics == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra orthodontics_radio" name="orthodontics" value="No" <?php if ($orthodontics == 'No') echo " checked";?>  />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'orthodontics', $pat_row['orthodontics'], $orthodontics, true, $showEdits, 'radio');
                                ?>
                                <span id="orthodontics_extra">Year completed: <input id="year_completed" name="year_completed" type="text" class="field text addr tbox" value="<?=$year_completed;?>" maxlength="255" style="width:225px;" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'year_completed', $pat_row['year_completed'], (!empty($dentures_extra) ? $dentures_extra : ''), true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Does your TMJ (jaw joint) click or pop?</label>
                                <input type="radio" class="extra tmj_cp_radio" name="tmj_cp" value="Yes" <?php if ($tmj_cp == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra tmj_cp_radio" name="tmj_cp" value="No" <?php if ($tmj_cp == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'tmj_cp', $pat_row['tmj_cp'], $tmj_cp, true, $showEdits, 'radio');
                                ?>
                                <span id="tmj_cp_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_cp_text" name="tmj_cp_text" value="<?= $tmj_cp_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'tmj_cp_text', $pat_row['tmj_cp_text'], $tmj_cp_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Do you have pain in this joint?</label>
                                <input type="radio" class="extra tmj_pain_radio" name="tmj_pain" value="Yes" <?php if ($tmj_pain == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra tmj_pain_radio" name="tmj_pain" value="No" <?php if ($tmj_pain == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'tmj_pain', $pat_row['tmj_pain'], $tmj_pain, true, $showEdits, 'radio');
                                ?>
                                <span id="tmj_pain_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_pain_text" name="tmj_pain_text" value="<?= $tmj_pain_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'tmj_pain_text', $pat_row['tmj_pain_text'], $tmj_pain_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Have you had TMJ (jaw joint) surgery?</label>
                                <input type="radio" class="extra tmj_surgery_radio" name="tmj_surgery" value="Yes" <?php if ($tmj_surgery == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra tmj_surgery_radio" name="tmj_surgery" value="No" <?php if ($tmj_surgery == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'tmj_surgery', $pat_row['tmj_surgery'], $tmj_surgery, true, $showEdits, 'radio');
                                ?>
                                <span id="tmj_surgery_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_surgery_text" name="tmj_surgery_text" value="<?= $tmj_surgery_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'tmj_surgery_text', $pat_row['tmj_surgery_text'], $tmj_surgery_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Have you ever had gum problems?</label>
                                <input id="gum_prob" name="gum_prob" type="radio" class="extra gum_prob_radio" value="Yes" <?= ($gum_prob == 'Yes') ? 'checked="checked"' : '';?> /> Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input id="gum_prob" name="gum_prob" type="radio" class="extra gum_prob_radio" value="No" <?= ($gum_prob == 'No') ? 'checked="checked"' : '';?> /> No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'gum_prob', $pat_row['gum_prob'], $gum_prob, true, $showEdits, 'radio');
                                ?>
                                <span id="gum_prob_extra">Please describe: <input type="text" class="field text addr tbox" id="gum_prob_text" name="gum_prob_text"  value="<?= $gum_prob_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'gum_prob_text', $pat_row['gum_prob_text'], $gum_prob_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Have you ever had gum surgery?</label>
                                <input type="radio" class="extra gum_surgery_radio" name="gum_surgery" value="Yes" <?php if ($gum_surgery == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra gum_surgery_radio" name="gum_surgery" value="No" <?php if ($gum_surgery == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'gum_surgery', $pat_row['gum_surgery'], $gum_surgery, true, $showEdits, 'radio');
                                ?>
                                <span id="gum_surgery_extra">Please describe: <input type="text" class="field text addr tbox" id="gum_surgery_text" name="gum_surgery_text" value="<?= $gum_surgery_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'gum_surgery_text', $pat_row['gum_surgery_text'], $gum_surgery_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Do you have morning dry mouth?</label>
                                <input type="radio" class="extra drymouth_radio" name="drymouth" value="Yes" <?php if ($drymouth == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra drymouth_radio" name="drymouth" value="No" <?php if ($drymouth == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'drymouth', $pat_row['drymouth'], $drymouth, true, $showEdits, 'radio');
                                ?>
                                <span id="drymouth_extra">Please describe: <input type="text" class="field text addr tbox" id="drymouth_text" name="drymouth_text" value="<?= $drymouth_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'drymouth_text', $pat_row['drymouth_text'], $drymouth_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Have you ever had injury to your head, face, neck, mouth, or teeth?</label>
                                <input type="radio" class="extra injury_radio" name="injury" value="Yes" <?php if ($injury == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra injury_radio" name="injury" value="No" <?php if ($injury == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'injury', $pat_row['injury'], $injury, true, $showEdits, 'radio');
                                ?>
                                <span id="injury_extra">Please describe: <input type="text" class="field text addr tbox" id="injury_text" name="injury_text" value="<?= $injury_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'injury_text', $pat_row['injury_text'], $injury_text, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Are you planning to have dental work done in the near future?</label>
                                <input type="radio" class="extra completed_future_radio" name="completed_future" value="Yes" <?php if ($completed_future == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra completed_future_radio" name="completed_future" value="No" <?php if ($completed_future == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'completed_future', $pat_row['completed_future'], $completed_future, true, $showEdits, 'radio');
                                ?>
                                <span id="completed_future_extra">Please describe: <input type="text" class="field text addr tbox" id="future_dental_det" name="future_dental_det"  value="<?= $future_dental_det; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'future_dental_det', $pat_row['future_dental_det'], $future_dental_det, true, $showEdits);
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Do you clench or grind your teeth?</label>
                                <input type="radio" class="extra clinch_grind_radio" name="clinch_grind" value="Yes" <?php if ($clinch_grind == 'Yes') echo " checked";?> />Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="extra clinch_grind_radio" name="clinch_grind" value="No" <?php if ($clinch_grind == 'No') echo " checked";?> />No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'clinch_grind', $pat_row['clinch_grind'], $clinch_grind, true, $showEdits, 'radio');
                                ?>
                                <span id="clinch_grind_extra">Please describe: <input type="text" class="field text addr tbox" id="clinch_grind_text" name="clinch_grind_text" value="<?= $clinch_grind_text; ?>" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'clinch_grind_text', $pat_row['clinch_grind_text'], $clinch_grind_text, true, $showEdits);
                                    ?>
                                </span>
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
                        <label class="desc" id="title0" for="Field0">
                            Family History
                        </label>
                        <div>
                            <span class="full">
                                <label>Have genetic members of your family had Heart Disease?</label>
                                <input type="radio" name="family_hd" class="family_hd_radio" value="Yes" style="width:10px;" <?= ($family_hd == "Yes") ? 'checked="checked"' : ''; ?> /> Yes
                                <input type="radio" name="family_hd" class="family_hd_radio" value="No" style="width:10px;" <?= ($family_hd == "No") ? 'checked="checked"' : ''; ?> /> No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'family_hd', $pat_row['family_hd'], $family_hd, true, $showEdits, 'radio');
                                ?>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>High Blood Pressure?</label>
                                <input type="radio" class="family_bp_radio" name="family_bp" value="Yes" style="width:10px;" <?= ($family_bp == "Yes") ? 'checked="checked"' : ''; ?> /> Yes
                                <input type="radio" class="family_bp_radio" name="family_bp" value="No" style="width:10px;" <?= ($family_bp == "No") ? 'checked="checked"' : ''; ?> /> No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'family_bp', $pat_row['family_bp'], $family_bp, true, $showEdits, 'radio');
                                ?>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Diabetes?</label>
                                <input type="radio" class="family_dia_radio" name="family_dia" value="Yes" style="width:10px;" <?= ($family_dia == "Yes")?'checked="checked"':''; ?> /> Yes
                                <input type="radio" class="family_dia_radio" name="family_dia" value="No" style="width:10px;" <?= ($family_dia == "No")?'checked="checked"':''; ?> /> No
                                <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'family_dia', $pat_row['family_dia'], $family_dia, true, $showEdits, 'radio');
                                ?>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label>Have any genetic members of your family been diagnosed or treated for a sleep disorder?</label>
                                <input type="radio" class="family_sd_radio" name="family_sd" value="Yes" style="width:10px;" <?= ($family_sd == "Yes") ? 'checked="checked"' : ''; ?> /> Yes
                                <input type="radio" class="family_sd_radio" name="family_sd" value="No" style="width:10px;" <?= ($family_sd == "No") ? 'checked="checked"' : ''; ?> /> No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'family_sd', $pat_row['family_sd'], $family_sd, true, $showEdits, 'radio');
                                ?>
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
                        <label class="desc" id="title0" for="Field0">
                            SOCIAL HISTORY
                        </label>
                        <div>
                            <span class="full">
                                Alcohol consumption: How often do you consume alcohol within 2-3 hours of bedtime?
                                <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="alcohol" value="Daily" class="tbox" style="width:10px;" <?php if ($alcohol == 'Daily') echo " checked";?> />
                                Daily
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="alcohol" value="occasionally" class="tbox" style="width:10px;" <?php if ($alcohol == 'occasionally') echo " checked";?> />
                                Occasionally
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="alcohol" value="never" class="tbox" style="width:10px;" <?php if ($alcohol == 'never') echo " checked";?> />
                                Rarely/Never
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'alcohol', $pat_row['alcohol'], $alcohol, true, $showEdits);
                                ?>
                                <br /><br />
                                Sedative Consumption: How often do you take sedatives within 2-3 hours of bedtime?
                                <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="sedative" value="Daily" class="tbox" style="width:10px;" <?php if ($sedative == 'Daily') echo " checked";?> />
                                Daily
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="sedative" value="occasionally" class="tbox" style="width:10px;" <?php if ($sedative == 'occasionally') echo " checked";?> />
                                Occasionally
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="sedative" value="never" class="tbox" style="width:10px;" <?php if ($sedative == 'never') echo " checked";?> />
                                Rarely/Never
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'sedative', $pat_row['sedative'], $sedative, true, $showEdits);
                                ?>
                                <br /><br />
                                Caffeine consumption: How often do you consume caffeine within 2-3 hours of bedtime?
                                <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="caffeine" value="Daily" class="tbox" style="width:10px;" <?php if ($caffeine == 'Daily') echo " checked";?> />
                                Daily
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="caffeine" value="occasionally" class="tbox" style="width:10px;" <?php if ($caffeine == 'occasionally') echo " checked";?> />
                                Occasionally
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="caffeine" value="never" class="tbox" style="width:10px;" <?php if ($caffeine == 'never') echo " checked";?> />
                                Rarely/Never
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'caffeine', $pat_row['caffeine'], $caffeine, true, $showEdits);
                                ?>
                                <br /><br />
                                Do you Smoke?
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="smoke" value="Yes" class="tbox smoke_radio" style="width:10px;" <?php if ($smoke == 'Yes') echo " checked";?>  onclick="displaysmoke();" />
                                Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="smoke" value="No" class="tbox smoke_radio" style="width:10px;" <?php if ($smoke == 'No') echo " checked";?> onclick="hidesmoke();" />
                                No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'smoke', $pat_row['smoke'], $smoke, true, $showEdits, 'radio');
                                ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div id="smoke">If Yes, number of packs per day
                                    <input type="text" name="smoke_packs" value="<?=$smoke_packs?>" class="tbox" style="width:50px;" />
                                    <?php
                                    showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'smoke_packs', $pat_row['smoke_packs'], $smoke_packs, true, $showEdits);
                                    ?>
                                </div>
                                <br /><br />
                                Do you use Chewing Tobacco?
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="tobacco" value="Yes" class="tbox tobacco_radio" style="width:10px;" <?php if ($tobacco == 'Yes') echo " checked";?> />
                                Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="tobacco" value="No" class="tbox tobacco_radio" style="width:10px;" <?php if ($tobacco == 'No') echo " checked";?> />
                                No
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'tobacco', $pat_row['tobacco'], $tobacco, true, $showEdits, 'radio');
                                ?>
                            </span>
                        </div>
                        <br /><br />
                        <div>
                            <span>
                                Additional Paragraph<br />
                                <textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                                <?php
                                showPatientValue('dental_q_page3_pivot', $_GET['pid'], 'additional_paragraph', $pat_row['additional_paragraph'], $additional_paragraph, true, $showEdits);
                                ?>
                            </span>
                        </div>
                        <br />
                    </li>
                </ul>
            </td>
        </tr>
    </table>
    <div style="clear:both;"></div>
</form>

<script type="text/javascript">
    chk_allergens();
    chk_medications();
    chk_history();
    chk_ortho();
</script>

<br />
<?php include "../includes/form_bottom.htm";?>
<br />

<?php include 'includes/bottom.htm'; ?>
