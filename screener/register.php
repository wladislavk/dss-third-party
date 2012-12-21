<?php
session_start();
require_once('../manage/admin/includes/config.php');
if(!isset($_SESSION['screener_doc'])){
  ?>
	<script type="text/javascript">
		window.location = 'login.php';
	</script>
  <?php
	die();
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
<script type="text/javascript" src="script/screener.js"></script>
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
<form class="formEl_a">
<input type="hidden" id="docid" name="docid" value="<?= $_SESSION['screener_doc']; ?>" />
<input type="hidden" id="userid" name="userid" value="<?= $_SESSION['screener_user']; ?>" />

<div class="sect" id="sect0">
<div class="dp100">
<h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>
                                                                                                        <p style="font-size:14px;"></p>


<?php
  $sql = "SELECT * FROM dental_screener where id='".mysql_real_escape_string($_GET['id'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
?>
<p>Please enter your information to complete this brief health assessment.</p>
<br />
<div class="sepH_b clear" id="first_name_div">
        <label class="lbl_a">First Name</label>
        <input class="inpt_a" type="text" id="first_name" name="first_name" value="<?php echo $r['first_name']; ?>" />
</div>

<div class="sepH_b" id="last_name_div">
        <label class="lbl_a">Last Name</label>
        <input class="inpt_a" type="text" id="last_name" name="last_name" value="<?php echo $r['last_name']; ?>" />
</div>

<div class="sepH_b" id="phone_div">
        <label class="lbl_a">Phone Number</label>
        <input class="inpt_a phonemask" type="text" id="phone" name="phone" value="<?php echo $r['phone']; ?>" />
</div>

<div class="sepH_b" id="gender_div">
        <label class="lbl_a">Gender</label>
        <input class="inpt_a" type="text" id="gender" name="gender" value="" />
</div>

<div class="sepH_b" id="address_div">
        <label class="lbl_a">Address</label>
        <input class="inpt_a" type="text" id="address" name="address" value="" />
</div>

<div class="sepH_b" id="city_div">
        <label class="lbl_a">City</label>
        <input class="inpt_a" type="text" id="city" name="city" value="" />
</div>

<div class="sepH_b" id="state_div">
        <label class="lbl_a">State</label>
        <input class="inpt_a" type="text" id="state" name="state" value="" />
</div>

<div class="sepH_b" id="zip_div">
        <label class="lbl_a">Zip</label>
        <input class="inpt_a" type="text" id="zip" name="zip" value="" />
</div>

<div class="sepH_b" id="weight_div">
        <label class="lbl_a">Weight</label>
        <input class="inpt_a" type="text" id="weight" name="weight" value="" />
</div>

<div class="sepH_b" id="height_div">
        <label class="lbl_a">Height</label>
        <input class="inpt_a" type="text" id="height" name="height" value="" />
</div>

<div class="sepH_b" id="neck_div">
        <label class="lbl_a">Neck Size</label>
        <input class="inpt_a" type="text" id="neck" name="neck" value="" />
</div>

<div class="sepH_b" id="email_div">
        <label class="lbl_a">Email</label>
        <input class="inpt_a" type="text" id="email" name="email" value="" />
</div>

<div class="sepH_b" id="ins_div">
        <label class="lbl_a">PPO Medical Insurance Company</label>
        <input class="inpt_a" type="text" id="ins" name="ins" value="" />
</div>

<div class="sepH_b" id="ins_id_div">
        <label class="lbl_a">ID#</label>
        <input class="inpt_a" type="text" id="ins_id" name="ins_id" value="" />
</div>

<div class="sepH_b" id="group_div">
        <label class="lbl_a">Group#</label>
        <input class="inpt_a" type="text" id="group" name="group" value="" />
</div>

  <div class="sepH_b" id="disorder_div">
        <div class="buttonset">
        <input type="radio" id="disorder1" name="disorder" value="8" /><label for="disorder1">Yes</label>
        <input type="radio" id="disorder2" name="disorder" value="0" /><label for="disorder2">No</label>
        </div>
        <label class="question">Have you ever been diagnosed with a sleep disorder?</label>
  </div>
  <div class="sepH_b" id="cpap_div">
        <div class="buttonset">
        <input type="radio" id="cpap1" name="cpap" value="8" /><label for="cpap1">Yes</label>
        <input type="radio" id="cpap2" name="cpap" value="0" /><label for="cpap2">No</label>
        </div>
        <label class="question">Are you currently using a CPAP machine</label>
  </div>
  <div class="sepH_b" id="cpap_every_night_div">
        <div class="buttonset">
        <input type="radio" id="cpap_every_night1" name="cpap_every_night" value="8" /><label for="cpap_every_night1">Yes</label>
        <input type="radio" id="cpap_every_night2" name="cpap_every_night" value="0" /><label for="cpap_every_night2">No</label>
        </div>
        <label class="question">If yes, do you use it every night?</label>
  </div>

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



                                                                                                                <div class="cf">
<a href="#" onclick="submit_register()" class="fr next btn btn_large btn_d">Proceed &raquo;</a>
                                                                                                                </div>
</div>
<div class="clear"></div>
</div>


<div class="sect" id="sectfinish">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>
<h3>Your Results</h3>

<p id="result_body"></p>

<a rel="fancyReg" href="#regModal" class="fr next btn btn_medium btn_d">Finished - Click Here</a>
						<div style="display:none">
							<div id="regModal">
								<h4 class="sepH_a">Survey Complete</h4>
								<p class="sepH_c">Thank you for completing the survey. Please return this device to our staff or let them know you have completed the survey.</p>
								<a href="index.php" id="finish_ok" class="btn btn_d">OK</a>
							</div>
						</div>
   </div>
  </div>
</div>

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

