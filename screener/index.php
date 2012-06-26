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
<script type="text/javascript" src="../manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="script/screener.js"></script>
</head>
<body>
<form>
<input type="hidden" id="docid" name="docid" value="<?= $_SESSION['screener_doc']; ?>" />
<input type="hidden" id="userid" name="userid" value="<?= $_SESSION['screener_user']; ?>" />
<div class="sect" id="sect1">

<h3>General</h3>

<div class="field">
	<label>First Name</label>
	<input type="text" id="first_name" name="first_name" />
</div>

<div class="field">
        <label>Last Name</label>
        <input type="text" id="last_name" name="last_name" />
</div>

<a href="#" onclick="next_sect(2)">Next</a>
</div>
<div class="sect" id="sect2">

<h3>Epworth</h3>

        <div class="legend">
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />                        <strong>0</strong> = No chance of dozing<br />
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

<div class="field">
	<label>Sitting and reading</label>
	<select id="epworth_reading" name="epworth_reading"><?= $options; ?></select>
</div>


<div class="field">
        <label>Sitting inactive in a public place (e.g. a theater or meeting)</label>
        <select id="epworth_public" name="epworth_public"><?= $options; ?></select>
</div>


<div class="field">
        <label>As a passenger in a car for an hour without a break</label>
        <select id="epworth_passenger" name="epworth_passenger"><?= $options; ?></select>
</div>


<div class="field">
        <label>Lying down to rest in the afternoon when circumstances permit</label>
        <select id="epworth_lying" name="epworth_lying"><?= $options; ?></select>
</div>


<div class="field">
        <label>Sitting and talking to someone</label>
        <select id="epworth_talking" name="epworth_talking"><?= $options; ?></select>
</div>


<div class="field">
        <label>Sitting quietly after a lunch without alcohol</label>
        <select id="epworth_lunch" name="epworth_lunch"><?= $options; ?></select>
</div>


<div class="field">
        <label>In a car, while stopped for a few minutes in traffic</label>
        <select id="epworth_traffic" name="epworth_traffic"><?= $options; ?></select>
</div>


<a href="#" onclick="next_sect(3)">Next</a>
</div>
<div class="sect" id="sect3">

<h3>Thornton</h3>

<div class="legend">
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        <strong>0</strong> = Never<br />
                        <strong>1</strong> = Infrequently (1 night per week)<br />
                        <strong>2</strong> = Frequently (2-3 nights per week)<br />
                        <strong>3</strong> = Most of the time (4 or more nights)<br />
</div>


<div class="field">
	<label class="lbl_in">1. My snoring affects my relationship with my partner:</label>
        <select id="snore_1" name="snore_1"><?= $options; ?></select>
</div>

<div class="field">
        <label class="lbl_in">2. My snoring causes my partner to be irritable or tired:</label>
        <select id="snore_2" name="snore_2"><?= $options; ?></select>
</div>

<div class="field">
        <label class="lbl_in">3. My snoring requires us to sleep in separate rooms:</label>
        <select id="snore_3" name="snore_3"><?= $options; ?></select>
</div>

<div class="field">
        <label class="lbl_in">4. My snoring is loud:</label>
        <select id="snore_4" name="snore_4"><?= $options; ?></select>
</div>

<div class="field">
        <label class="lbl_in">5. My snoring affects people when I am sleeping away from home:</label>
        <select id="snore_5" name="snore_5"><?= $options; ?></select>
</div>

<a href="#" onclick="next_sect(4)">Next</a>

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



<a href="#" onclick="submit_screener()">Next</a>
</div>

<div class="sect" id="sectresults">

<h3>Results</h3>

Your scores are...<br />
Epworth: <span id="ep_score"></span><br />
Thornton: <span id="snore_score"></span><br />
Survey: <span id="survey_score"></span>

</div>

</body>
</html>
