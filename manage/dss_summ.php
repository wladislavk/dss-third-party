<?php
include_once 'includes/constants.inc';
include 'includes/top.htm';

if(isset($_REQUEST['del_note'])){
  $s = "UPDATE dental_notes SET status=0 
	WHERE parentid='".mysql_real_escape_string($_REQUEST['del_note'])."'
		OR notesid='".mysql_real_escape_string($_REQUEST['del_note'])."'";
  mysql_query($s);
}
?>
<link rel="stylesheet" href="css/summ.css" />

<div>TOP SECTION</div>

                <?php
                        $dental_letters_query = "SELECT letterid FROM dental_letters                                 JOIN dental_patients ON dental_letters.patientid=dental_patients.patientid                                 WHERE dental_letters.status = '0' AND 
                                        dental_letters.deleted = '0' AND 
                                        dental_patients.docid = '".mysql_real_escape_string($_SESSION['docid'])."' AND
                                        dental_letters.patientid= '".mysql_real_escape_string($_REQUEST['pid'])."';";
$dental_letters_res = mysql_query($dental_letters_query);
$pending_letters = mysql_num_rows($dental_letters_res);
                ?>

<div id="content">
<ul id="summ_nav">
  <li><a href="#" onclick="show_sect('notes')" id="link_notes" class="active">PROG NOTES</a></li>
  <li><a href="#" onclick="show_sect('treatment')" id="link_treatment">TREATMENT Hx</a></li>
  <li><a href="#" onclick="show_sect('health')" id="link_health">HEALTH Hx</a></li>
  <li><a href="#" onclick="show_sect('letters')" id="link_letters">LETTERS <?= ($pending_letters>0)?"(".$pending_letters.")":''; ?></a></li>
  <li><a href="#" onclick="show_sect('sleep')" id="link_sleep">SLEEP TESTS</a></li>
  <li><a href="#" onclick="show_sect('subj')" id="link_subj">SUBJ TESTS</a></li>
  <li><a href="#" onclick="show_sect('contacts')" id="link_contacts">CONTACTS</a></li>
  <li><a href="#" onclick="show_sect('appointments')" id="link_appointments">APPOINTMENTS</a></li>
</ul>

  <div id="sections">
  	<div id="sect_notes">
		<?php include 'summ_notes.php'; ?>
	</div>
	<div id="sect_treatment">
		<?php include 'summ_treatment.php'; ?>
	</div>
	<div id="sect_health">
		<?php include 'summ_health.php'; ?>		
	</div>
	<div id="sect_letters">
                <?php include 'summ_letters.php'; ?>
        </div>
	<div id="sect_sleep">
		<?php include 'summ_sleep.php'; ?>
	</div>
	<div id="sect_subj">
		<?php include 'summ_subj.php'; ?>
	</div>
	<div id="sect_contacts">

	</div>
	<div id="sect_appointments">
		<?php //include 'summ_appointments.php'; ?>
	</div>
  </div>
<div class="clear"></div>
<div>
<? include 'includes/bottom.htm';?>

<script type="text/javascript">
  function show_sect(sect){
    $('.active').removeClass('active');
    $("#link_"+sect).addClass('active');
    $("#sections > div").hide();
    $("#sect_"+sect).show();
  }
show_sect('notes');
</script>
