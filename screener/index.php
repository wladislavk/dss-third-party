<?php
session_start();
if(!isset($_SESSION['screener_doc'])){
  ?>
	<script type="text/javascript">
		window.location = 'login.php';
	</script>
  <?php
	die();
}
?>
<html>
  <head>
    <title>Dental Sleep Solutions :: Screener</title>
    <link rel="stylesheet" href="css/lagu.css" />
<script type="text/javascript" src="../manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="script/screener.js"></script>
<link rel="stylesheet" href="css/screener.css" />
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
        <div class="wrapper">
            <div class="brdrrad_a" id="main_section">
<form>
<input type="hidden" id="docid" name="docid" value="<?= $_SESSION['screener_doc']; ?>" />
<input type="hidden" id="userid" name="userid" value="<?= $_SESSION['screener_user']; ?>" />

<div class="sect" id="sect0">
<div class="dp50">
<h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>
                                                                                                        <p>Over 40 million Americans suffer from a sleep disorder, and 20 million suffer from Obstructive Sleep Apnea (OSA). Despite this high prevalence, 93% of women and 82% of men with moderate to severe OSA remain undiagnosed. Please take this short questionnaire to determine your risk of OSA. Your information is securely stored and will never shared without your consent. Find out whether you may be suffering from an undiagnosed sleep problem.</p>
<br />
                                                                                                                <div class="cf">
<a href="#" onclick="next_sect(1)" class="fr next btn btn_large btn_d">Proceed &raquo;</a>
                                                                                                                </div>
</div>
</div>

<div class="sect" id="sect1">

<h3>General</h3>

<div class="sepH_b clear">
	<label>First Name</label>
	<input class="inpt_a" type="text" id="first_name" name="first_name" />
</div>

<div class="field">
        <label>Last Name</label>
        <input type="text" id="last_name" name="last_name" />
</div>

<a href="#" onclick="next_sect(2)" class="fr next btn btn_d">Next</a>
</div>
<div class="sect" id="sect2">

<h3>Epworth Sleepiness Score</h3>
<div class="formEl_a">
        <div class="legend dp33">
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        <strong>0</strong> = No chance of dozing<br />
                        <strong>1</strong> = Slight chance of dozing<br />
                        <strong>2</strong> = Moderate chance of dozing<br />
                        <strong>3</strong> = High chance of dozing<br />
        </div>


<?php
  $options = "<option value=\"0\">0</option>
		<option value=\"1\">1</option>
                <option value=\"2\">2</option>
                <option value=\"3\">3</option>";
?>
<div class="dp66">
<div class="sepH_b clear">
	<select class="inpt_in" id="epworth_reading" name="epworth_reading"><?= $options; ?></select>
        <label class="lbl_in">Sitting and reading</label>
</div>


<div class="sepH_b clear">
        <select class="inpt_in" id="epworth_public" name="epworth_public"><?= $options; ?></select>
        <label class="lbl_in">Sitting inactive in a public place (e.g. a theater or meeting)</label>
</div>


<div class="sepH_b clear">
        <select class="inpt_in" id="epworth_passenger" name="epworth_passenger"><?= $options; ?></select>
        <label class="lbl_in">As a passenger in a car for an hour without a break</label>
</div>


<div class="sepH_b clear">
        <select class="inpt_in" id="epworth_lying" name="epworth_lying"><?= $options; ?></select>
        <label class="lbl_in">Lying down to rest in the afternoon when circumstances permit</label>
</div>


<div class="sepH_b clear">
        <select class="inpt_in" id="epworth_talking" name="epworth_talking"><?= $options; ?></select>
        <label class="lbl_in">Sitting and talking to someone</label>
</div>


<div class="sepH_b clear">
        <select class="inpt_in" id="epworth_lunch" name="epworth_lunch"><?= $options; ?></select>
        <label class="lbl_in">Sitting quietly after a lunch without alcohol</label>
</div> 


<div class="sepH_b clear">
        <select class="inpt_in" id="epworth_traffic" name="epworth_traffic"><?= $options; ?></select>
        <label class="lbl_in">In a car, while stopped for a few minutes in traffic</label>
</div>
</div>
</div>
<a href="#" onclick="next_sect(3)" class="fr next btn btn_d">Next</a>
</div>
<div class="sect" id="sect3">
<h3>Health Symptoms</h3>
  <div class="field">
        <input type="radio" name="breathing" value="8" /> Yes
        <input type="radio" name="breathing" value="0" /> No
        <label>Have you ever been told you stop breathing while asleep?</label>
  </div>

  <div class="field">
        <input type="radio" name="driving" value="6" /> Yes
        <input type="radio" name="driving" value="0" /> No
        <label>Have you ever fallen asleep or nodded off while driving?</label>
  </div>

  <div class="field">
        <input type="radio" name="gasping" value="6" /> Yes
        <input type="radio" name="gasping" value="0" /> No
        <label>Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</label>
  </div>

  <div class="field">
        <input type="radio" name="sleepy" value="4" /> Yes
        <input type="radio" name="sleepy" value="0" /> No
        <label>Do you feel excessively sleepy during the day?</label>
  </div>

  <div class="field">
        <input type="radio" name="snore" value="4" /> Yes
        <input type="radio" name="snore" value="0" /> No
        <label>Do you snore or have you ever been told that you snore?</label>
  </div>

  <div class="field">
        <input type="radio" name="weight_gain" value="2" /> Yes
        <input type="radio" name="weight_gain" value="0" /> No
        <label>Have you had weight gain and found it difficult to lose?</label>
  </div>

  <div class="field">
        <input type="radio" name="blood_pressure" value="2" /> Yes
        <input type="radio" name="blood_pressure" value="0" /> No
        <label>Have you taken medication for, or been diagnosed with high blood pressure?</label>
  </div>

  <div class="field">
        <input type="radio" name="jerk" value="3" /> Yes
        <input type="radio" name="jerk" value="0" /> No
        <label>Do you kick or jerk your legs while sleeping?</label>
  </div>

  <div class="field">
        <input type="radio" name="burning" value="3" /> Yes
        <input type="radio" name="burning" value="0" /> No
        <label>Do you feel burning, tingling or crawling sensations in your legs when you wake up? </label>
  </div>

  <div class="field">
        <input type="radio" name="headaches" value="3" /> Yes
        <input type="radio" name="headaches" value="0" /> No
        <label>Do you wake up with headaches during the night or in the morning?</label>
  </div>

  <div class="field">
        <input type="radio" name="falling_asleep" value="4" /> Yes
        <input type="radio" name="falling_asleep" value="0" /> No
        <label>Do you have trouble falling asleep?</label>
  </div>

  <div class="field">
        <input type="radio" name="staying_asleep" value="4" /> Yes
        <input type="radio" name="staying_asleep" value="0" /> No
        <label>Do you have trouble staying asleep once you fall asleep?</label>
  </div>

<a href="#" onclick="next_sect(4)" class="fr next btn btn_d">Next</a>

</div>

<div class="sect" id="sect4">

<h3>Rx</h3>
  <div class="field">
	<input type="checkbox" name="rx_blood_pressure" value="1" />
	<label>High blood pressure</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_hypertension" value="1" />
        <label>Hypertension</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_heart_disease" value="1" />
        <label>Heart disease</label>
  </div>
   <div class="field">
        <input type="checkbox" name="rx_stroke" value="1" />
        <label>Stroke</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_apnea" value="1" />
        <label>Sleep apnea</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_diabetes" value="1" />
        <label>Diabetes</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_lung_disease" value="1" />
        <label>Lung Disease</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_insomnia" value="1" />
        <label>Insomnia</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_depression" value="1" />
        <label>Depression</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_narcolepsy" value="1" />
        <label>Narcolepsy</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_medication" value="1" />
        <label>Sleeping medication</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_restless_leg" value="1" />
        <label>Restless leg syndrome</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_headaches" value="1" />
        <label>Morning headaches</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_heartburn" value="1" />
        <label>Heartburn (Gastroesophageal Reflux)</label>
  </div>



<a href="#" onclick="submit_screener()" class="fr next btn btn_d">Next</a>
</div>

<div class="sect" id="sectresults">

<h3>Your Results</h3>

<p id="result_body"></p>
<br />
Epworth: <span id="ep_score"></span><br />
<br />
Survey: <span id="survey_score"></span>
<br />
<div id="risk_image"></div>
<a href="index.php" class="fr next btn btn_d">Start New Survey</a>
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

