<?php

include "includes/top.htm";
include 'includes/patient_nav.php';

?>
<div id="content">
    <ul class="nav nav-tabs nav-justified">
        <li class="active">
            <a href="#sect_summ" id="link_summ" data-toggle="tab">SUMMARY</a>
        </li>
        <li>
            <a href="#sect_notes" id="link_notes" data-toggle="tab">PROG NOTES <?php echo  (!empty($num_unsigned_notes) && $num_unsigned_notes>0)?"(".$num_unsigned_notes.")":''; ?></a>
        </li>
        <li>
            <a href="#sect_treatment" id="link_treatment" data-toggle="tab">TREATMENT Hx</a>
        </li>
        <li>
            <a href="#sect_health" id="link_health" data-toggle="tab">HEALTH Hx</a>
        </li>
        <li>
            <a href="#sect_letters" id="link_letters" data-toggle="tab">LETTERS <?php echo  ($pending_letters>0)?"(".$pending_letters.")":''; ?></a>
        </li>
        <li>
            <a href="#sect_sleep" id="link_sleep" data-toggle="tab">SLEEP TESTS</a>
        </li>
        <li>
            <a href="#sect_subj" id="link_subj" data-toggle="tab">SUBJ TESTS</a>
        </li>
    </div>
    <p>&nbsp;</p>
<?php
if(!empty($_GET['sect'])){
  $sect = $_GET['sect'];
 }elseif(!empty($_COOKIE['summ_sect']) && !empty($_GET['pid']) && $_COOKIE['pid'] == $_GET['pid']){
  $sect = $_COOKIE['summ_sect'];
 }else{
  $sect = 'summ';
 }
?>
  <div id="sections" class="tab-content">
        <div class="tab-pane fade in active" id="sect_summ">
            <?php include 'patient_summ_summ.php'; ?>
        </div>
        <div class="tab-pane fade" id="sect_notes">
            <?php include 'patient_summ_notes.php'; ?>
        </div>
        <div class="tab-pane fade" id="sect_treatment">
            <?php include 'patient_summ_treatment.php'; ?>
        </div>
        <div class="tab-pane fade" id="sect_health">
            <?php include 'patient_summ_health.php'; ?>
        </div>
        <div class="tab-pane fade" id="sect_letters">
                <?php include 'patient_summ_letters.php'; ?>
        </div>
        <div class="tab-pane fade" id="sect_sleep">
                <?php include 'patient_summ_sleep.php'; ?>
        </div>
        <div class="tab-pane fade" id="sect_subj">
                <?php include 'patient_summ_subj.php'; ?>
        </div>
        <div class="clearfix"></div>
  </div>
<div>
<?php include "includes/bottom.htm"; ?>
