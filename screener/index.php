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
    <div id="header">
        <div class="wrapper cf">
            <div class="logo fl">
                <h1>Dental Sleep Solutions</h1>
            </div>
	</div>
    </div>
    <div id="main">
        <div class="wrapper">
            <div class="brdrrad_a" id="main_section">
<form>
<input type="hidden" id="docid" name="docid" value="<?= $_SESSION['screener_doc']; ?>" />
<input type="hidden" id="userid" name="userid" value="<?= $_SESSION['screener_user']; ?>" />

<div class="sect" id="sect0">
<h3 class="sepH_a">Welcome!</h3>
                                                                                                        <p>Please accurately complete the information on the following pages. This will save you time at your next Dental Sleep Solutions appointment, and allow you to avoid completing additional forms later.  All information you input here is securely stored using the latest encryption technology that meets or exceeds HIPAA medical privacy standards, and you can access and update your information anytime.  We take your privacy seriously, and we never share your information without your consent.  We're excited to see you at your next visit!</p>
<br />
                                                                                                                <div class="cf">
<a href="#" onclick="next_sect(1)" class="fr next btn btn_d">Proceed &raquo;</a>
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

<h3>Epworth</h3>
<div class="formEl_a">
        <div class="legend">
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

<div class="sepH_b half">
	<label class="lbl_in">Sitting and reading</label>
	<select class="inpt_in" id="epworth_reading" name="epworth_reading"><?= $options; ?></select>
</div>


<div class="sepH_b half">
        <label class="lbl_in">Sitting inactive in a public place (e.g. a theater or meeting)</label>
        <select class="inpt_in" id="epworth_public" name="epworth_public"><?= $options; ?></select>
</div>


<div class="sepH_b half">
        <label class="lbl_in">As a passenger in a car for an hour without a break</label>
        <select class="inpt_in" id="epworth_passenger" name="epworth_passenger"><?= $options; ?></select>
</div>


<div class="sepH_b half">
        <label class="lbl_in">Lying down to rest in the afternoon when circumstances permit</label>
        <select class="inpt_in" id="epworth_lying" name="epworth_lying"><?= $options; ?></select>
</div>


<div class="sepH_b half">
        <label class="lbl_in">Sitting and talking to someone</label>
        <select class="inpt_in" id="epworth_talking" name="epworth_talking"><?= $options; ?></select>
</div>


<div class="sepH_b half">
        <label class="lbl_in">Sitting quietly after a lunch without alcohol</label>
        <select class="inpt_in" id="epworth_lunch" name="epworth_lunch"><?= $options; ?></select>
</div> 


<div class="sepH_b half">
        <label class="lbl_in">In a car, while stopped for a few minutes in traffic</label>
        <select class="inpt_in" id="epworth_traffic" name="epworth_traffic"><?= $options; ?></select>
</div>

</div>
<a href="#" onclick="next_sect(3)" class="fr next btn btn_d">Next</a>
</div>
<div class="sect" id="sect3">

<h3>Thornton</h3>
<div class="formEl_a">

<div class="legend">
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        <strong>0</strong> = Never<br />
                        <strong>1</strong> = Infrequently (1 night per week)<br />
                        <strong>2</strong> = Frequently (2-3 nights per week)<br />
                        <strong>3</strong> = Most of the time (4 or more nights)<br />
</div>


<div class="sepH_b half">
	<label class="lbl_in">1. My snoring affects my relationship with my partner:</label>
        <select class="inpt_in" id="snore_1" name="snore_1"><?= $options; ?></select>
</div>

<div class="sepH_b half">
        <label class="lbl_in">2. My snoring causes my partner to be irritable or tired:</label>
        <select class="inpt_in" id="snore_2" name="snore_2"><?= $options; ?></select>
</div>

<div class="sepH_b half">
        <label class="lbl_in">3. My snoring requires us to sleep in separate rooms:</label>
        <select class="inpt_in" id="snore_3" name="snore_3"><?= $options; ?></select>
</div>

<div class="sepH_b half">
        <label class="lbl_in">4. My snoring is loud:</label>
        <select class="inpt_in" id="snore_4" name="snore_4"><?= $options; ?></select>
</div>

<div class="sepH_b half">
        <label class="lbl_in">5. My snoring affects people when I am sleeping away from home:</label>
        <select class="inpt_in" id="snore_5" name="snore_5"><?= $options; ?></select>
</div>
</div>
<a href="#" onclick="next_sect(4)" class="fr next btn btn_d">Next</a>

</div>

<div class="sect" id="sect4">
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
        <input type="radio" name="blood_pressure" value="1" /> Yes
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

<h3>Rx</h3>
  <div class="field">
	<input type="checkbox" name="rx_tongue" value="1" />
	<label>Enlarged/Scalloped Tongue</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_reflux" value="1" />
        <label>Gastroesophageal Reflux</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_hypertension" value="1" />
        <label>Hypertension</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_jaw" value="1" />
        <label>Retruded lower Jaw</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_tonsils" value="1" />
        <label>Elarged Tonsils</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_heart" value="1" />
        <label>Heart Failure</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_pallet" value="1" />
        <label>High Arching Hard Pallet</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_metabolic" value="1" />
        <label>Metabolic Syndrome</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_stroke" value="1" />
        <label>Stroke</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_bruxism" value="1" />
        <label>Bruxism</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_diabetes" value="1" />
        <label>Diabetes</label>
  </div>
  <div class="field">
        <input type="checkbox" name="rx_obesity" value="1" />
        <label>Obesity</label>
  </div>



<a href="#" onclick="submit_screener()" class="fr next btn btn_d">Next</a>
</div>

<div class="sect" id="sectresults">

<h3>Results</h3>

Your scores are...<br />
Epworth: <span id="ep_score"></span><br />
Thornton: <span id="snore_score"></span><br />
Survey: <span id="survey_score"></span>

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

