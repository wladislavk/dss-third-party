<?
include "includes/top.htm";

include 'includes/patient_nav.php';

?>

<div id="content">
<ul id="summ_nav">
  <li><a href="#" onclick="show_sect('summ')" id="link_summ">SUMMARY</a></li>
  <li><a href="#" onclick="show_sect('notes')" id="link_notes">PROG NOTES <?= ($num_unsigned_notes>0)?"(".$num_unsigned_notes.")":''; ?></a></li>
  <li><a href="#" onclick="show_sect('treatment')" id="link_treatment">TREATMENT Hx</a></li>
  <li><a href="#" onclick="show_sect('health')" id="link_health">HEALTH Hx</a></li>
  <li><a href="#" onclick="show_sect('letters')" id="link_letters">LETTERS <?= ($pending_letters>0)?"(".$pending_letters.")":''; ?></a></li>
  <li><a href="#" onclick="show_sect('sleep')" id="link_sleep">SLEEP TESTS</a></li>
  <li><a href="#" onclick="show_sect('subj')" id="link_subj">SUBJ TESTS</a></li>
</ul>
<?php
if($_GET['sect']!=''){
  $sect = $_GET['sect'];
 }elseif($_COOKIE['summ_sect'] && $_COOKIE['pid'] == $_GET['pid']){
  $sect = $_COOKIE['summ_sect'];
 }else{
  $sect = 'summ';
 }
?>
  <div id="sections">
        <div id="sect_summ">
                <?php include 'patient_summ_summ.php'; ?>
        </div>
        <div id="sect_notes">
                <?php include 'patient_summ_notes.php'; ?>
        </div>
        <div id="sect_treatment">
                <?php include 'patient_summ_treatment.php'; ?>
        </div>
        <div id="sect_health">
                <?php include 'patient_summ_health.php'; ?>
        </div>
        <div id="sect_letters">
                <?php include 'patient_summ_letters.php'; ?>
        </div>
        <div id="sect_sleep">
                <?php include 'patient_summ_sleep.php'; ?>
        </div>
        <div id="sect_subj">
                <?php include 'patient_summ_subj.php'; ?>
        </div>
  </div>
<div class="clear"></div>
<div>




<script type="text/javascript">
  function show_sect(sect){
    $('.active').removeClass('active');
    $("#link_"+sect).addClass('active');
    $("#sections > div").hide();
    $("#sect_"+sect).show();
    $.cookie('pid', '<?= $_GET['pid']; ?>');
    $.cookie('summ_sect', sect);
  }
show_sect('<?= $sect; ?>');

</script>




<?php include "includes/bottom.htm"; ?>
