<?php include 'includes/top.htm';?>

 <table>
 <tr>
 <td valign="top" style="border-right:1px solid #00457c;width:980px;">
<!--<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />-->
<!--<script src="admin/popup/popup2.js" type="text/javascript"></script>-->
<style type="text/css">

.home_third{
  width: 30%;
  float: left;
  padding: 0 1%;
  margin: 0;
  border-left: 2px solid #095D81;
  min-height: 400px; 
  }

.home_third h3{
  font-family: "Times", serif;
  color:#095D81;
  font-size: 32px;
  width: 100%;
  text-align: center;
  }

.home_menu{
  padding-left: 15px;
  }
.home_menu a{
  padding: 3px 0;
  display: block;
  font-size: 16px;
  }
</style>


<!--
##############################################################
NAV THIRD
##############################################################
-->

<div class="home_third first">
<h3>Navigation</h3>
<div class="homesuckertreemenu">
<ul id="homemenu" style="padding-top:3px;">
<li><a href="manage_patient.php">PATIENT</a>
  <ul>
              <li><a href="manage_patient.php">Manage Patients</a></li>
              <li><a href="#">Directory</a>
                  <ul>
                     <li><a href="manage_contact.php">Contacts</a></li>
                     <li><a href="manage_referredby.php">Referral List</a></li>
                     <li><a href="manage_sleeplab.php">Sleep Labs</a></li>
                     <li><a href="manage_fcontact.php">Corporate Contacts</a></li>
                   </ul>
              </li>
  </ul>
</li>
<li>
<a href="#">REPORTS</a>

  <ul>
     <li><a href="ledger_reportfull.php">Ledger</a></li>
     <li><a href="manage_claims.php">Claims (<?= $num_pending_claims; ?>)</a></li>
     <li><a href="performance.php">Performance</a></li>
     <li><a href="manage_screeners.php">Pt. Screener</a></li>
  </ul>
</li>

<?php
  $mess_count = $pending_letters + $num_preauth + $num_pc + $num_pi + $num_c;
  $mess_count = $pending_letters + $num_preauth + $num_rejected_preauth + $num_pc + $num_pi + $num_c + $num_bounce;
?>
<li><a href="#">MESSAGES (<?php echo $mess_count; ?>)</a>
  <ul>
      <li><a <?php {echo "href='letters.php?status=pending'";} ?>>Pending Letters (<?php echo $pending_letters; ?>)</a></li>
      <li><a <?php {echo "href='manage_vobs.php'";} ?>>VOBs (<?= $num_preauth; ?>)</a></li>
      <li><a <?php {echo "href='manage_patient_contacts.php'";} ?>>Patient Contacts (<?= $num_pc; ?>)</a></li>
      <li><a <?php {echo "href='manage_patient_insurance.php'";} ?>>Patient Insurance (<?= $num_pi; ?>)</a></li>
      <li><a <?php {echo "href='manage_patient_changes.php'";} ?>>Patient Changes (<?= $num_c; ?>)</a></li>
      <li><a href="manage_vobs.php?status=<?= DSS_PREAUTH_REJECTED; ?>&viewed=0">Alerts (<?= $num_rejected_preauth; ?>)</a></li>
      <li><a href="manage_email_bounces.php">Email Bounces (<?= $num_bounce; ?>)</a></li>
      <li><a href="manage_tasks.php">Tasks (<?= $num_tasks; ?>)</a></li>
  </ul>


  </ul>
</li>

</ul>
</div>


  <div style="clear: both;float:none;" class="suckertreemenu2">
     <ul id="homesettings">
       <li><a href="#">Manage Settings</a>
         <ul style="z-index:5001;margin-top:-20px;">
            <li><a class="menu_item" href="#">Directory</a></li>
                     <li><a class="submenu_item" href="manage_contact.php">Contacts</a></li>
                     <li><a class="submenu_item" href="manage_referredby.php">Referral List</a></li>
                     <li><a class="submenu_item" href="manage_sleeplab.php">Sleep Labs</a></li>
                     <li><a class="submenu_item" href="manage_fcontact.php">Corporate Contacts</a></li>
            <li><a class="menu_item" href="#">DSS Files</a></li>
                <?php 
                        $s = "SELECT * FROM dental_document_category WHERE status=1 ORDER BY name ASC";
                        $sq = mysql_query($s);
                        while($c = mysql_fetch_assoc($sq)){ ?>
                                <li><a class="submenu_item" href="view_documents.php?cat=<?= $c['categoryid'];?>"><?= $c['name']; ?></a></li>

                       <?php }
                ?>
            <li><a class="menu_item" href="#">Admin</a></li>
                     <li><a class="submenu_item" href="manage_claim_setup.php">Claim Setup</a></li>
                     <li><a class="submenu_item" href="manage_profile.php">Profile</a></li>
                     <li><a class="submenu_item" href="manage_custom.php">Custom Text</a></li>
                     <?php if($_SESSION['userid']==$_SESSION['docid']){ ?>
                     <li><a class="submenu_item" href="manage_transaction_code.php">Transaction Code</a></li>
                     <?php } ?>
                     <li><a class="submenu_item" href="manage_staff.php">Staff</a></li>
                     <li><a class="submenu_item" href="manage_user_forms.php">Forms</a></li>
                     <li><a class="submenu_item" href="manage_manuals.php">Manuals</a></li>

              <li><a class="menu_item" href="pending_patient.php">Pending Patients</a></li>
              <li><a class="menu_item" href="export_md.php" onclick="return (prompt('Enter password')=='1234');">Export MD</a></li>
          </ul>
        </li>
      </ul>
  </div>

<ul style="clear:both; list-style:none;" class="home_menu">
  <li><a href="manage_patient.php">Manage Patients</a></li>
  <li><a href="calendar.php">Scheduler</a></li>
  <li><a href="course.php" target="_blank">Education</a></li>
  <li><a href="#">SW Tutorials</a></li>
  <li><a href="index_old.php">Old Home</a></li>
</ul>

</div>


<!--
##############################################################
ALERT THIRD
##############################################################
-->


<div class="home_third">
<h3>Notifications</h3>
  <?php if($num_rejected_preauth>0){ ?>
  <a href="manage_vobs.php?status=<?= DSS_PREAUTH_REJECTED; ?>&viewed=0" class="notification bad_count"><?= $num_rejected_preauth; ?> Alerts</a>
  <?php } ?>

  <?php if($pending_letters > 0 && $use_letters){ ?>
  <a href="letters.php?status=pending" class="notification <?= ($pending_letters==0)?"good_count":"bad_count"; ?>"><?= $pending_letters;?> Letters</a>
  <?php } ?>

  <?php if($unmailed_letters > 0 && $use_letters && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE){ ?>
  <a href="letters.php?status=sent&mailed=0" class="notification bad_count"><?= $unmailed_letters;?> Unmailed Letters</a>
  <?php } ?>


  <?php if($num_preauth > 0){ ?>
  <a href="manage_vobs.php?status=<?= DSS_PREAUTH_COMPLETE; ?>&viewed=0" class="notification <?= ($num_preauth==0)?"good_count":"great_count"; ?>"><?= $num_preauth;?> Verifications</a>
  <?php } ?>

<?php if($num_bounce !=0 ){?>
  <a href="manage_email_bounces.php" class="notification <?= ($num_bounce==0)?"good_count":"bad_count"; ?>"><?= $num_bounce;?> Email Bounces</a>
<?php } ?>

<?php if($num_unsigned !=0 ){?>
  <a href="manage_unsigned_notes.php" class="notification <?= ($num_unsigned==0)?"good_count":"bad_count"; ?>"><?= $num_unsigned;?> Unsigned Notes</a>
<?php } ?>

<?php if($num_pending_nodss_claims !=0 && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE){?>
  <a href="manage_claims.php" class="notification <?= ($num_pending_nodss_claims==0)?"good_count":"bad_count"; ?>"><?= $num_pending_nodss_claims;?> Pending Claims</a>
<?php } ?>

<?php if($num_unmailed_claims !=0 && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE){?>
  <a href="manage_claims.php?unmailed=1" class="notification <?= ($num_unmailed_claims==0)?"good_count":"bad_count"; ?>"><?= $num_unmailed_claims;?> Unmailed Claims</a>
<?php } ?>


</div>


<!--
##############################################################
TASK THIRD
##############################################################
-->



<div class="home_third">

<h3>Tasks</h3>
<div class="task_menu index_task">
<h4>My Tasks</h4>

<?php
$od_q = mysql_query($od_sql);
if(mysql_num_rows($od_q)>0){
?>

<h4 style="margin-bottom:0px;color:red;" class="task_od_header">Overdue</h4>
<ul class="task_od_list">
<?php
while($od_r = mysql_fetch_assoc($od_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" style="float:left; " class="task_status" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?>
</div>
</li>
<?php
}
?>
</ul>
<?php
}

$tod_q = mysql_query($tod_sql);
if(mysql_num_rows($tod_q)>0){
?>


<h4 style="margin-bottom:0px;" class="task_tod_header">Today</h4>
<ul class="task_tod_list">
<?php
while($od_r = mysql_fetch_assoc($tod_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" style="float:left;" class="task_status" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php

}
?>
</ul>
<?php
}

$tom_q = mysql_query($tom_sql);
if(mysql_num_rows($tom_q)>0){
?>
<h4 style="margin-bottom:0px;" class="task_tom_header">Tomorrow</h4>
<ul class="task_tom_list">
<?php
while($od_r = mysql_fetch_assoc($tom_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" style="float:left;" class="task_status" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>


<?php
$tw_q = mysql_query($tw_sql);
if(mysql_num_rows($tw_q)>0){
?>
<h4 id="task_tw_header" class="task_tw_header">This Week</h4>
<ul id="task_tw_list">
<?php
while($od_r = mysql_fetch_assoc($tw_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>

<?php
$nw_q = mysql_query($nw_sql);
if(mysql_num_rows($nw_q)>0){
?>
<h4 id="task_nw_header" class="task_nw_header">Next Week</h4>
<ul id="task_nw_list">
<?php
while($od_r = mysql_fetch_assoc($nw_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>



<?php
$lat_q = mysql_query($lat_sql);
if(mysql_num_rows($lat_q)>0){
?>
<h4 id="task_lat_header" class="task_lat_header">Later</h4>
<ul id="task_lat_list">
<?php
while($od_r = mysql_fetch_assoc($lat_q)){
?><li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
<div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
  <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
  <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
</div>
<input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
<div style="float:left; width:170px;">
<?= date('M d', strtotime($od_r['due_date'])); ?>
-
<?php echo $od_r['task']; ?>
<?php if($od_r['firstname']!='' && $od_r['lastname']!=''){
  echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
} ?></div>
</li>
<?php
}
?>
</ul>
<?php } ?>
<br /><br />
<a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>

</div>



</div>



  
</td></tr>
</table>
<br /><br />
<? include 'includes/bottom.htm';?> 
