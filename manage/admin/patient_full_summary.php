<?
include_once "includes/top.htm";

include_once 'includes/patient_nav.php';
include_once '../includes/general_functions.php';
?>

<style type="text/css">

.space{ margin-top:20px; }

</style>

<?php

$sql = "SELECT * FROM dental_patients WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'";
$q = mysql_query($sql);
$pat = mysql_fetch_assoc($q);

$p_sql = "SELECT * FROM dental_contact where contactid='".mysql_real_escape_String($pat['p_m_ins_co'])."'";
$p_q = mysql_query($p_sql);
$p_ins = mysql_fetch_assoc($p_q);

$s_sql = "SELECT * FROM dental_contact where contactid='".mysql_real_escape_String($pat['s_m_ins_co'])."'";
$s_q = mysql_query($s_sql);
$s_ins = mysql_fetch_assoc($s_q);
?>
<div class="field">
  <label>Generated on:</label>
  <span class="data"><?= date('m/d/Y'); ?></span>
</div>

<div class="field">
  <label>Patient Name:</label>
  <span class="data"><?= $pat['salutation']." ".$pat['firstname']." ".$pat['lastname']; ?></span>
</div>

<div class="field">
  <label>Home phone:</label>
  <span class="data"><?= format_phone($pat['home_phone']); ?></span>
</div>

<div class="field">
  <label>Cell phone:</label>
  <span class="data"><?= format_phone($pat['cell_phone']); ?></span>
</div>

<div class="field">
  <label>Work phone:</label>
  <span class="data"><?= format_phone($pat['work_phone']); ?></span>
</div>

<div class="field">
  <label>Email:</label>
  <span class="data"><?= $pat['email']; ?></span>
</div>


<div class="field">
  <label>Address:</label>
  <span class="data"><?= $pat['add1']." ".$pat['add2']."<br />".$pat['city'].", ".$pat['state']." ".$pat['zip']; ?></span>
</div>

<div class="field">
  <label>DOB:</label>
  <span class="data"><?= $pat['dob']; ?></span>
</div>
<div class="field">
  <label>Gender:</label>
  <span class="data"><?= $pat['gender']; ?></span>
</div>
<div class="field">
  <label>SS#:</label>
  <span class="data"><?= $pat['ssn']; ?></span>
</div>
<div class="field">
  <label>Marital Status:</label>
  <span class="data"><?= $pat['martial_status']; ?></span>
</div>
<div class="field">
  <label>Partner/Guardian Name:</label>
  <span class="data"><?= $pat['partner_name']; ?></span>
</div>

<div class="field">
  <label>Height:</label>
  <span class="data"><?= $pat['feet']; ?> ft <?= $pat['inches']; ?> in</span>
</div>
<div class="field">
  <label>Weight:</label>
  <span class="data"><?= $pat['weight']; ?></span>
</div>
<div class="field">
  <label>BMI:</label>
  <span class="data"><?= $pat['bmi']; ?></span>
</div>

<div class="field">
  <label>Employer:</label>
  <span class="data"><?= $pat['employer']; ?></span>
</div>
<div class="field">
  <label>Employer Phone:</label>
  <span class="data"><?= $pat['emp_phone']; ?></span>
</div>
<div class="field">
  <label>Employer Fax:</label>
  <span class="data"><?= $pat['emp_fax']; ?></span>
</div>
<div class="field">
  <label>Employer Address:</label>
  <span class="data"><?= $pat['emp_add1']; ?> <?= $pat['emp_add2']; ?><br /><?= $pat['emp_city']; ?>, <?= $pat['emp_state']; ?> <?= $pat['emp_zip']; ?></span>
</div>

INSURANCE:

<div class="field">
  <label>Relationship to insured:</label>
  <span class="data"><?= $pat['p_m_relationship']; ?></span>
</div>
<div class="field">
  <label>Insured Name: </label>
  <span class="data"><?= $pat['p_m_partyfname']." ".$pat['p_m_partymname']." ".$pat['p_m_partylname']; ?></span>
</div>
<div class="field">
  <label>Insured DOB:</label>
  <span class="data"><?= $pat['ins_dob']; ?></span>
</div>
<div class="field">
  <label>Insurance Type:</label>
  <span class="data"><?= $pat['p_m_ins_type']; ?></span>
</div>
<div class="field">
  <label>Accept Assignment OR Payment to Patient</label>
  <span class="data"><?= $pat['p_m_ins_ass']; ?></span>
</div>

<div class="field">
  <label>Insurance Company:</label>
  <span class="data"><?= $p_ins['company']; ?></span>
</div>
<div class="field">
  <label>Insurance Address:</label>
  <span class="data"><?= $p_ins['add1']." ".$p_ins['add2']."<br />".$p_ins['city'].", ".$p_ins['state']." ".$p_ins['zip']; ?></span>
</div>

<div class="field">
  <label>Ins ID:</label>
  <span class="data"><?= $pat['p_m_ins_id']; ?></span>
</div>
<div class="field">
  <label>Ins Group Number:</label>
  <span class="data"><?= $pat['p_m_ins_grp']; ?></span>
</div>
<div class="field">
  <label>Ins Plan Name:</label>
  <span class="data"><?= $pat['p_m_ins_plan']; ?></span>
</div>

Does the patient have Secondary Insurance? <?= $pat['has_s_m_ins']; ?> 
<?php
  if($pat['has_s_m_ins']=='Yes'){ ?>
<div class="field">
  <label>Relationship to insured:</label>
  <span class="data"><?= $pat['s_m_relationship']; ?></span>
</div>
<div class="field">
  <label>Insured Name: </label>
  <span class="data"><?= $pat['s_m_partyfname']." ".$pat['s_m_partymname']." ".$pat['s_m_partylname']; ?></span>
</div>
<div class="field">
  <label>Insured DOB:</label>
  <span class="data"><?= $pat['ins2_dob']; ?></span>
</div>
<div class="field">
  <label>Insurance Type:</label>
  <span class="data"><?= $pat['s_m_ins_type']; ?></span>
</div>
<div class="field">
  <label>Accept Assignment OR Payment to Patient</label>
  <span class="data"><?= $pat['s_m_ins_ass']; ?></span>
</div>

<div class="field">
  <label>Insurance Company:</label>
  <span class="data"><?= $s_ins['company']; ?></span>
</div>
<div class="field">
  <label>Insurance Address:</label>
  <span class="data"><?= $s_ins['add1']." ".$s_ins['add2']."<br />".$s_ins['city'].", ".$s_ins['state']." ".$s_ins['zip']; ?></span>
</div>

<div class="field">
  <label>Ins ID:</label>
  <span class="data"><?= $pat['s_m_ins_id']; ?></span>
</div>
<div class="field">
  <label>Ins Group Number:</label>
  <span class="data"><?= $pat['s_m_ins_grp']; ?></span>
</div>
<div class="field">
  <label>Ins Plan Name:</label>
  <span class="data"><?= $pat['s_m_ins_plan']; ?></span>
</div>


  <?php } ?>

<div class="space">Medical Contacts:</div>
<?php if($pat['docpcp']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['docpcp'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Primary Care MD:</label>
  <span class="data"><?= $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?= $doc['add1']." ".$doc['add2']; ?><br /><?= $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?= format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?= format_phone($doc['fax']); ?></span>
</div>

<?php } ?>

<?php if($pat['docent']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['docent'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>ENT:</label>
  <span class="data"><?= $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?= $doc['add1']." ".$doc['add2']; ?><br /><?= $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?= format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?= format_phone($doc['fax']); ?></span>
</div>

<?php } ?>

<?php if($pat['docsleep']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['docsleep'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Sleep MD:</label>
  <span class="data"><?= $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?= $doc['add1']." ".$doc['add2']; ?><br /><?= $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?= format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?= format_phone($doc['fax']); ?></span>
</div>

<?php } ?>

<?php if($pat['docdentist']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['docdentist'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Dentist:</label>
  <span class="data"><?= $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?= $doc['add1']." ".$doc['add2']; ?><br /><?= $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?= format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?= format_phone($doc['fax']); ?></span>
</div>

<?php } ?>
<?php if($pat['docmdother']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['docmdother'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Other MD:</label>
  <span class="data"><?= $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?= $doc['add1']." ".$doc['add2']; ?><br /><?= $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?= format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?= format_phone($doc['fax']); ?></span>
</div>

<?php } ?>
<?php if($pat['docmdother2']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['docmdother2'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Other MD 2:</label>
  <span class="data"><?= $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?= $doc['add1']." ".$doc['add2']; ?><br /><?= $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?= format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?= format_phone($doc['fax']); ?></span>
</div>

<?php } ?>
<?php if($pat['docmdother3']){ 
  $doc_sql = "SELECT * FROM dental_contact WHERE contactid='".mysql_real_escape_string($pat['docmdother3'])."'";
  $doc_q = mysql_query($doc_sql);
  $doc = mysql_fetch_assoc($doc_q);
?>
<div class="field space">
  <label>Other MD 3:</label>
  <span class="data"><?= $doc['firstname']." ".$doc['lastname']; ?></span>
</div>
<div class="field">
  <label>Address:</label>
  <span class="data"><?= $doc['add1']." ".$doc['add2']; ?><br /><?= $doc['city']." ".$doc['state']." ".$doc['zip']; ?></span>
</div>
<div class="field">
  <label>Phone:</label>
  <span class="data"><?= format_phone($doc['phone1']); ?></span>
</div>
<div class="field">
  <label>Fax:</label>
  <span class="data"><?= format_phone($doc['fax']); ?></span>
</div>

<?php } ?>



<?php include "includes/bottom.htm"; ?>
