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

<a href="#" onclick="submit_screener()">Next</a>
</div>

<div class="sect" id="sectresults">

<h3>Results</h3>

Your scores are...<br />
Epworth: <span id="ep_score"></span><br />
Thornton: <span id="snore_score"></span>


</div>

</body>
</html>
