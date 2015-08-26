<?php namespace Ds3\Libraries\Legacy; ?><?php
session_start();
require_once('../manage/admin/includes/main_include.php');
include_once '../manage/includes/constants.inc';
if(!isset($_SESSION['screener_doc'])){
  ?>
	<script type="text/javascript">
		window.location = 'login.php';
	</script>
  <?php
	trigger_error("Die called", E_USER_ERROR);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Dental Sleep Solutions :: Screener</title>
    <link rel="stylesheet" href="css/lagu.css" />
<script type="text/javascript" src="../manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="../manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
			<script type="text/javascript" src="../reg/lib/fancybox/jquery.easing-1.3.pack.js"></script>
			<script type="text/javascript" src="../reg/lib/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<!--<script type="text/javascript" src="script/screener.js"></script>-->
<?php include 'script/screener.php'; ?>
    <script type="text/javascript" src="../manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="script/screener_masks.js"></script>
<link rel="stylesheet" href="css/screener.css" />
<link rel="stylesheet" href="../manage/admin/css/jquery-ui-1.8.22.custom.css" />
<link rel="stylesheet" href="../reg/lib/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/style_ie.css" />
<![endif]-->
</head>
<body class="fixed">
    <div id="header" >
        <div class="wrapper cf">
            <div class="logo fl">
                <h1>Dental Sleep Solutions</h1>
            </div>
            <ul id="main_nav" class="fr">
                                <li class="nav_item lgutipT" title="start over" style="display:none;" id="restart_nav"><a href="index.php" class="main_link" onclick="return confirm('Are you sure? All current progress will be lost.');"><img class="img_holder" style="background-image: url(images/images/icons/refresh.png)" alt="" src="images/blank.gif"/><span>Reset and Start Over</span></a></li>

                                <li class="nav_item lgutipT" title="Log Out"><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')" class="main_link"><img class="img_holder" style="background-image: url(images/icons/locked2.png)" alt="" src="images/blank.gif"/><span>Log Out</span></a></li>

            </ul>

	</div>
    </div>
    <div id="main">
        <div class="wrapper cf">
            <div class="cf brdrrad_a" id="main_section">
<form class="formEl_a screener">
<input type="hidden" id="docid" name="docid" value="<?= $_SESSION['screener_doc']; ?>" />
<input type="hidden" id="userid" name="userid" value="<?= $_SESSION['screener_user']; ?>" />

<div class="sect" id="sect0">
<div class="dp50">
<h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>
                                                                                                        <p style="font-size:14px;">More than 20 million Americans suffer from Obstructive Sleep Apnea (OSA). Despite this high prevalence, 93% of women and 82% of men with moderate to severe OSA remain UNDIAGNOSED and UNAWARE that they have a deadly disease.<br />
Please complete this short questionnaire to determine your risk of OSA. Your information is confidential and will only be shared with healthcare providers for diagnostic and treatment purposes.</p>
<br />
<p>Please enter your contact information to complete this brief health assessment.</p>
<br />
<div class="sepH_b clear" id="first_name_div">
        <label class="lbl_a">First Name</label>
        <input class="inpt_a" type="text" id="first_name" name="first_name" />
</div>

<div class="sepH_b" id="last_name_div">
        <label class="lbl_a">Last Name</label>
        <input class="inpt_a" type="text" id="last_name" name="last_name" />
</div>

<div class="sepH_b" id="phone_div">
        <label class="lbl_a">Phone Number</label>
        <input class="inpt_a phonemask" type="text" id="phone" name="phone" />
</div>


</div>
<div class="dp50">
<img src="images/sleeping_couple.png" style="float:right;"/>
<br />
                                                                                                                <div class="cf">
<a href="#"  id="sect1_next" class="fr next btn btn_large btn_d">Proceed &raquo;</a>
<span id="sect1_next_dis" class="fr next btn btn_large btn_d disabled">Proceed &raquo;</a>
                                                                                                                </div>
</div>
<div class="clear"></div>
</div>

<div class="sect" id="sect2">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>
<h3>Epworth Sleepiness Scale</h3>
<br />
<p>How likely are you to sleep or doze in each of the following situations?</p>
<div class="formEl_a">
<?php
  $options = "<option value=\"\">Select an answer</option>
		<option value=\"0\">0 - No chance of dozing</option>
		<option value=\"1\">1 - Slight chance of dozing</option>
                <option value=\"2\">2 - Moderate chance of dozing</option>
                <option value=\"3\">3 - High chance of dozing</option>";
?>
<div class="dp66">
<div class="msg_box msg_error" id="epworth_error_box" style="display:none;"></div>

<?php
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($epworth_myarray = mysqli_fetch_array($epworth_my))
  {
?>
<div class="sepH_b clear" id="epworth_<?= $epworth_myarray['epworthid']; ?>_div">
        <select class="inpt_in epworth_select" id="epworth_<?=$epworth_myarray['epworthid']; ?>" name="epworth_<?= $epworth_myarray['epworthid']; ?>"><?= $options; ?></select>
        <label class="lbl_in"><?= $epworth_myarray['epworth']; ?></label>
</div>

<?php } ?>
<!--
<div class="sepH_b clear" id="epworth_reading_div">
	<select class="inpt_in epworth_select" id="epworth_reading" name="epworth_reading"><?= $options; ?></select>
        <label class="lbl_in">Sitting and reading</label>
</div>


<div class="sepH_b clear" id="epworth_public_div">
        <select class="inpt_in epworth_select" id="epworth_public" name="epworth_public"><?= $options; ?></select>
        <label class="lbl_in">Sitting inactive in a public place (e.g. a theater or meeting)</label>
</div>


<div class="sepH_b clear" id="epworth_passenger_div">
        <select class="inpt_in epworth_select" id="epworth_passenger" name="epworth_passenger"><?= $options; ?></select>
        <label class="lbl_in">As a passenger in a car for an hour without a break</label>
</div>


<div class="sepH_b clear" id="epworth_lying_div">
        <select class="inpt_in epworth_select" id="epworth_lying" name="epworth_lying"><?= $options; ?></select>
        <label class="lbl_in">Lying down to rest in the afternoon when circumstances permit</label>
</div>


<div class="sepH_b clear" id="epworth_talking_div">
        <select class="inpt_in epworth_select" id="epworth_talking" name="epworth_talking"><?= $options; ?></select>
        <label class="lbl_in">Sitting and talking to someone</label>
</div>


<div class="sepH_b clear" id="epworth_lunch_div">
        <select class="inpt_in epworth_select" id="epworth_lunch" name="epworth_lunch"><?= $options; ?></select>
        <label class="lbl_in">Sitting quietly after a lunch without alcohol</label>
</div> 


<div class="sepH_b clear" id="epworth_traffic_div">
        <select class="inpt_in epworth_select" id="epworth_traffic" name="epworth_traffic"><?= $options; ?></select>
        <label class="lbl_in">In a car, while stopped for a few minutes in traffic</label>
</div>
-->
</div>
        <div class="legend dp33">
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        <strong>0</strong> = No chance of dozing<br />
                        <strong>1</strong> = Slight chance of dozing<br />
                        <strong>2</strong> = Moderate chance of dozing<br />
                        <strong>3</strong> = High chance of dozing<br />
        </div>
<div style="clear:both;"></div>
</div>
<a href="#" id="sect2_next" class="fr next btn btn_medium btn_d">Next</a>
<span id="sect2_next_dis" class="fr next btn btn_medium btn_d disabled">Next</span>
</div>
<div class="sect" id="sect3">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>
<h3>Health Symptoms</h3>
  <p>Please answer the following questions about your sleep habits.</p>
<div class="msg_box msg_error" id="sect3_error_box" style="display:none;"></div>
  <div class="sepH_b" id="breathing_div">
	<div class="buttonset">
        <input type="radio" id="breathing1" name="breathing" value="8" /><label for="breathing1">Yes</label>
        <input type="radio" id="breathing2" name="breathing" value="0" /><label for="breathing2">No</label>
  	</div>
        <label class="question">Have you ever been told you stop breathing while asleep?</label>
  </div>
<script>
	$(function() {
		$(".buttonset").buttonset();
	});
	</script>
  <div class="sepH_b" id="driving_div">
	<div class="buttonset">
          <input type="radio" id="driving1" name="driving" value="6" /><label for="driving1">Yes</label>
          <input type="radio" id="driving2" name="driving" value="0" /><label for="driving2">No</label>
	</div>
        <label class="question">Have you ever fallen asleep or nodded off while driving?</label>
  </div>

  <div class="sepH_b" id="gasping_div">
        <div class="buttonset">
        <input type="radio" name="gasping" value="6" id="gasping1" /><label for="gasping1">Yes</label>
        <input type="radio" name="gasping" value="0" id="gasping2" /><label for="gasping2">No</label>
        </div>
        <label class="question">Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</label>
  </div>

  <div class="sepH_b" id="sleepy_div">
        <div class="buttonset">
        <input type="radio" name="sleepy" value="4" id="sleepy1" /><label for="sleepy1">Yes</label>
        <input type="radio" name="sleepy" value="0" id="sleepy2" /><label for="sleepy2">No</label>
        </div>
        <label class="question">Do you feel excessively sleepy during the day?</label>
  </div>

  <div class="sepH_b" id="snore_div">
        <div class="buttonset">
        <input type="radio" name="snore" value="4" id="snore1" /><label for="snore1">Yes</label>
        <input type="radio" name="snore" value="0" id="snore2" /><label for="snore2">No</label>
        </div>
        <label class="question">Do you snore or have you ever been told that you snore?</label>
  </div>

  <div class="sepH_b" id="weight_gain_div">
        <div class="buttonset">
        <input type="radio" name="weight_gain" value="2" id="weight_gain1" /><label for="weight_gain1">Yes</label>
        <input type="radio" name="weight_gain" value="0" id="weight_gain2" /><label for="weight_gain2">No</label>
        </div>
        <label class="question">Have you had weight gain and found it difficult to lose?</label>
  </div>

  <div class="sepH_b" id="blood_pressure_div">
        <div class="buttonset">
        <input type="radio" name="blood_pressure" value="2" id="blood_pressure1" /><label for="blood_pressure1">Yes</label>
        <input type="radio" name="blood_pressure" value="0" id="blood_pressure2" /><label for="blood_pressure2">No</label>
        </div>
        <label class="question">Have you taken medication for, or been diagnosed with high blood pressure?</label>
  </div>

  <div class="sepH_b" id="jerk_div">
        <div class="buttonset">
        <input type="radio" name="jerk" value="3" id="jerk1" /><label for="jerk1">Yes</label>
        <input type="radio" name="jerk" value="0" id="jerk2" /><label for="jerk2">No</label>
        </div>
        <label class="question">Do you kick or jerk your legs while sleeping?</label>
  </div>

  <div class="sepH_b" id="burning_div">
        <div class="buttonset">
        <input type="radio" name="burning" value="3" id="burning1" /><label for="burning1">Yes</label>
        <input type="radio" name="burning" value="0" id="burning2" /><label for="burning2">No</label>
        </div>
        <label class="question">Do you feel burning, tingling or crawling sensations in your legs when you wake up? </label>
  </div>

  <div class="sepH_b" id="headaches_div">
        <div class="buttonset">
        <input type="radio" name="headaches" value="3" id="headaches1" /><label for="headaches1">Yes</label>
        <input type="radio" name="headaches" value="0" id="headaches2" /><label for="headaches2">No</label>
        </div>
        <label class="question">Do you wake up with headaches during the night or in the morning?</label>
  </div>

  <div class="sepH_b" id="falling_asleep_div">
        <div class="buttonset">
        <input type="radio" name="falling_asleep" value="4" id="falling_asleep1" /><label for="falling_asleep1">Yes</label>
        <input type="radio" name="falling_asleep" value="0" id="falling_asleep2" /><label for="falling_asleep2">No</label>
        </div>
        <label class="question">Do you have trouble falling asleep?</label>
  </div>

  <div class="sepH_b" id="staying_asleep_div">
        <div class="buttonset">
        <input type="radio" name="staying_asleep" value="4" id="staying_asleep1" /><label for="staying_asleep1">Yes</label>
        <input type="radio" name="staying_asleep" value="0" id="staying_asleep2" /><label for="staying_asleep2">No</label>
        </div>
        <label class="question">Do you have trouble staying asleep once you fall asleep?</label>
  </div>

<a href="#" id="sect3_next" class="fr next btn btn_medium btn_d">Next</a>
<span id="sect3_next_dis" class="fr next btn btn_medium btn_d disabled">Next</span>

</div>

<div class="sect" id="sect4">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>
<h3>Previous medical diagnoses</h3>
<br />

<div class="sepH_b" id="rx_cpap_div">
  <div class="buttonset">
  <input type="radio" id="rx_cpap1" name="rx_cpap" value="4" /><label for="rx_cpap1">Yes</label>
  <input type="radio" id="rx_cpap2" name="rx_cpap" value="0" /><label for="rx_cpap2">No</label> 
</div>
  <label class="question">Have you ever used CPAP before?</label>
</div>

<br /><br />
  <p class="clear">Please check any conditions for which you have been medically diagnosed or treated.</p>
  <div class="field half">
        <input type="checkbox" name="rx_heart_failure" value="1" />
        <label>Heart Failure</label>
  </div>
   <div class="field half">
        <input type="checkbox" name="rx_stroke" value="1" />
        <label>Stroke</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_hypertension" value="1" />
        <label>Hypertension</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_diabetes" value="1" />
        <label>Diabetes</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_metabolic_syndrome" value="1" />
        <label>Metabolic Syndrome</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_obesity" value="1" />
        <label>Obesity</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_heartburn" value="1" />
        <label>Heartburn (Gastroesophageal Reflux)</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_afib" value="1" />
        <label>Atrial Fibrillation</label>
  </div>


<a href="#" id="sect4_next" class="fr next btn btn_medium btn_d">Next</a>
<span id="sect4_next_dis" class="fr next btn btn_medium btn_d disabled">Next</a>
</div>

<div class="sect" id="sectresults">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>
<h3>Your Results</h3>

<p id="result_body"></p>
<!--
<br />
Epworth: <span id="ep_score"></span><br />
<br />
Survey: <span id="survey_score"></span>
<br />-->
<div class="risk_desc" id="risk_low">
<!-- LOW RISK -->
<span class="pat_name"></span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at low risk for sleep apnea, indicating a normal amount of sleepiness. Should any of your symptoms change, please let us know so we can reassess your sleepiness and risk for sleep apnea.

Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.
</div>
<?php
  $s = "SELECT name FROM dental_users where userid='".mysqli_real_escape_string($con, $_SESSION['screener_doc'])."'";
  $q = mysqli_query($con, $s);
  $r = mysqli_fetch_assoc($q);
?>

<div class="risk_desc" id="risk_moderate">
<!-- MODERATE RISK -->
<span class="pat_name"></span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at moderate risk for sleep apnea, indicating that some of your symptoms may be signs of Obstructive Sleep Apnea (OSA). Please talk to <?= $r['name']; ?> or any of our staff to find out about our advanced tools for diagnosing sleep apnea. We are here to answer your questions and help you breathe and sleep better! 

Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.
</div>

<div class="risk_desc" id="risk_high">
<!-- HIGH RISK -->
<span class="pat_name"></span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at high risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness, and medical attention should be sought. Please talk to <?= $r['name']; ?> or any of our staff to find out about our advanced tools for diagnosing sleep apnea. 

Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your HIGH risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We're here to help!
</div>

<div class="risk_desc" id="risk_severe">
<!-- SEVERE RISK -->
<span class="pat_name"></span>, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at severe risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness and medical attention should be sought. Please talk to <?= $r['name']; ?> or any of our staff to find out about our advanced tools for diagnosing sleep apnea.

Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your SEVERE risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We're here to help!
</div>
<div id="risk_image"></div>
<h2>Thank you for completing the survey. Please return the device to your provider.</h2>


<a href="#" id="sect5_next" class="fr next btn btn_medium btn_d">Dentist Only - Click Here &raquo;</a>
</div>







<div class="sect" id="sectdoctor">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>

<h3 class="sepH_a">Dental Sleep Solutions - Summary of Results</h3>
<p>Please choose from the options below. You may view the patient results, finish this screener and allow a new patient to be screened, or request a Home Sleep Test for the patient by clicking the buttons below.</p>
<br />
<div id="risk_image_doc"></div>

<a href="#results" id="sect_results_next" class="fl next btn btn_medium btn_d">View Results</a>
<?php
                          $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
                                        JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con, $_SESSION['screener_doc'])."'
                                        WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
                                 $bu_q = mysqli_query($con, $bu_sql);
                                if(mysqli_num_rows($bu_q)>0){
?>

<a style="margin-left:20px;" href="#" id="sect6_next" class="fr next btn btn_medium btn_d">Request HST (Doctor Only) &raquo;</a>
<?php } ?>

<a rel="fancyReg" href="#regModal" class="fr next btn btn_medium btn_d">Finish/Screen New Patient</a>
						<div style="display:none">
							<div id="regModal">
								<h4 class="sepH_a">Survey Complete</h4>
								<p class="sepH_c">Thank you for completing the survey. Please return this device to our staff or let them know you have completed the survey.</p>
								<a href="index.php" id="finish_ok" class="btn btn_d">OK</a>
							</div>
						</div>
  <a name="results"></a>
  <div id="results_div" style="display:none; clear:both;">
   <H4>Results</h4>
   <div style="width:58%; float:left;">
    <div class="check">
      <label>First name:</label>
      <span id="r_first_name"></span>
    </div>
    <div class="check">
      <label>Last name:</label>
      <span id="r_last_name"></span>
    </div>
    <div class="check">
      <label>Phone:</label>
      <span id="r_phone"></span>
    </div>
    <div><strong>Epworth Sleepiness Scale</strong></div>
    <div>
       <span id="r_ep_total"></span> -
       <label>Epworth Sleepiness Scale Total</label>
    </div>
<?php
  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysqli_query($con, $epworth_sql);
  $epworth_number = mysqli_num_rows($epworth_my);
  while($ea = mysqli_fetch_array($epworth_my))
  {
?>
    <div class="check">
      <span id="r_epworth_<?=$ea['epworthid'];?>"></span> -
      <label><?=$ea['epworth']; ?></label>
    </div>
<?php } ?>
  </div>
  <div style="width:38%;float:left;">
    <div><strong>Health Symptoms</strong></div>
    <div class="check">
      <span id="r_breathing"></span>
      <label>Have you ever been told you stop breathing while asleep?</label>
    </div>
    <div class="check">
      <span id="r_driving"></span>
      <label>Have you ever fallen asleep or nodded off while driving?</label>
    </div>
    <div class="check">
      <span id="r_gasping"></span>
      <label>Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</label>
    </div>
    <div class="check">
      <span id="r_sleepy"></span>
      <label>Do you feel excessively sleepy during the day?</label>
    </div>
    <div class="check">
      <span id="r_snore"></span>
      <label>Do you snore or have you ever been told that you snore?</label>
    </div>
    <div class="check">
      <span id="r_weight_gain"></span>
      <label>Have you had weight gain and found it difficult to lose?</label>
    </div>
    <div class="check">
      <span id="r_blood_pressure"></span>
      <label>Have you taken medication for, or been diagnosed with high blood pressure?</label>
    </div>
    <div class="check">
      <span id="r_jerk"></span>
      <label>Do you kick or jerk your legs while sleeping?</label>
    </div>
    <div class="check">
      <span id="r_burning"></span>
      <label>Do you feel burning, tingling or crawling sensations in your legs when you wake up?</label>
    </div>
    <div class="check">
      <span id="r_headaches"></span>
      <label>Do you wake up with headaches during the night or in the morning?</label>
    </div>
    <div class="check">
      <span id="r_falling_asleep"></span>
      <label>Do you have trouble falling asleep?</label>
    </div>
    <div class="check">
      <span id="r_staying_asleep"></span>
      <label>Do you have trouble staying asleep once you fall asleep?</label>
    </div>
    <div class="check">
      <span id="r_rx_cpap"></span>
      <label>Have you ever used CPAP before?</label>
    </div><br />
    <div><strong>Co-morbidity</strong></div>
    <div>
      <label>Please check any conditions for which you have been medically diagnosed or treated.</label>
      <ul id="r_diagnosed"></ul>
    </div>
   </div>
  </div>
</div>






<div class="sect" id="secthst">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>

<h3 class="sepH_a">Dental Sleep Solutions - Home Sleep Test Request</h3>
<p>Please enter your contact information to request a home sleep test.</p>
<br />
<div class="dp50">
<div class="sepH_b clear" id="hst_company_id_div">
        <label class="lbl_a">HST Company</label>
  <?php
                          $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
                                        JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con, $_SESSION['screener_doc'])."'
                                        WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
                                 $bu_q = mysqli_query($con, $bu_sql);
                          while($bu_r = mysqli_fetch_assoc($bu_q)){ ?>
<?php if($bu_r['logo'] && isSharedFile($bu_r['logo'])){ ?>
  <img src="../manage/q_file/<?= $bu_r['logo']; ?>" /><br />
<?php } ?>

                            <input type="radio" name="hst_company_id" value="<?= $bu_r['id']; ?>"  /> <?= $bu_r['name']; ?>

<br /><br />
                          <?php } ?>
</div>
<div class="sepH_b clear" id="hst_first_name_div">
        <label class="lbl_a">First Name</label>
        <input class="inpt_a" type="text" id="hst_first_name" name="hst_first_name" />
</div>

<div class="sepH_b" id="hst_last_name_div">
        <label class="lbl_a">Last Name</label>
        <input class="inpt_a" type="text" id="hst_last_name" name="hst_last_name" />
</div>
<div class="sepH_b" id="hst_dob_div">
        <label class="lbl_a">Date of Birth</label>
        <input class="inpt_a datemask" type="text" id="hst_dob" name="hst_dob" />
</div>
</div>
<div class="dp50">
<div class="sepH_b" id="hst_phone_div">
        <label class="lbl_a">Phone Number</label>
        <input class="inpt_a phonemask" type="text" id="hst_phone" name="hst_phone" />
</div>
<div class="sepH_b" id="hst_email_div">
        <label class="lbl_a">Email</label>
        <input class="inpt_a" type="text" id="hst_email" name="hst_email" />
</div>
</div>
<a href="#" id="sect7_next" class="fr next btn btn_medium btn_d">Submit Request</a>
          </div>
<div style="clear:both;"></div>

        </div>
    </div>

    <!-- footer section -->
    <div id="footer">
        <div class="wrapper">
            <span class="fr">Copyright Dental Sleep Solutions 2012</span>
        </div>
    </div>

  </body>
</html>

