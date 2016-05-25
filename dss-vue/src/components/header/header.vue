<template>
    <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
    <!-- Header and nav goes here -->
        <tr>
            <td colspan="2" align="right" ></td>
        </tr>
        <tr>
            <td valign='top' height="400">
      <?php
        $task_sql = "select dt.*, du.name, p.firstname, p.lastname from dental_task dt
                JOIN dental_users du ON dt.responsibleid=du.userid
                LEFT JOIN dental_patients p ON p.patientid=dt.patientid
           WHERE (dt.status = '0' OR
                dt.status IS NULL) AND
                dt.responsibleid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

        $num_tasks = $db->getNumberRows($task_sql);
      ?>

      <?php $mess_count = $pending_letters + $num_preauth + $num_rejected_preauth + $num_pc + $num_pi + $num_c + $num_bounce + $num_unsigned + $num_pending_duplicates; ?>

      <?php
        if ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) {
         $mess_count += $num_unmailed_claims + $num_pending_nodss_claims;
        } else {
         $mess_count += $num_pending_claims;
        }
      ?>

      <div class="suckertreemenu2">
        <ul id="topmenu2">
          <li>
            <a href="index.php"> Notifications(<?php echo $mess_count; ?>)</a>
          </li>

          <li id="header_support" <?php echo  ($num_support>0)?'class="pending"':""; ?>>
            <a href="support.php">Support <?php echo  ($num_support>0)?"(".$num_support.")":""; ?></a>
          </li>

          <li>
            <a href="logout.php">Sign Out</a>
          </li>
        </ul>
      </div>

      <script type="text/javascript">
        if (window.task_function) { task_function(); }
      </script>

      <?php
        $task_sql = "select dt.*, du.name, p.firstname, p.lastname from dental_task dt
                JOIN dental_users du ON dt.responsibleid=du.userid
                LEFT JOIN dental_patients p ON p.patientid=dt.patientid
           WHERE (dt.status = '0' OR
                dt.status IS NULL) AND
                dt.responsibleid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

        $num_tasks = $db->getNumberRows($task_sql);
      ?>

      <div id="task_menu" class="task_menu" style="margin-top:8px;float:right">
        <span id="task_header">
          My Tasks (<span id="task_count"><?php echo  $num_tasks; ?></span>)
        </span>

        <div id="task_list" style="border: solid 1px #000; position: absolute; z-index:20;background:#fff;padding:10px;display:none;">

          <?php
            $od_sql = $task_sql . " AND dt.due_date < CURDATE();";
            $tod_sql = $task_sql . " AND dt.due_date = CURDATE();";
            $tom_sql = $task_sql . " AND dt.due_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY);";

            if (date('N') == 7) {
              $this_sun = date('Y-m-d');
              $next_mon = date('Y-m-d',  strtotime("next Tuesday"));
              $next_sun = date('Y-m-d',  strtotime("next Sunday"));
            } else {
              $this_sun = date('Y-m-d',  strtotime("next Sunday"));
              $next_mon = date('Y-m-d',  strtotime("next Monday"));
              $next_sun = date('Y-m-d',  strtotime("next Sunday + 1 week"));
            }

            $tw_sql = $task_sql . " AND dt.due_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND '".$this_sun."'";

            $nw_sql = $task_sql . " AND dt.due_date BETWEEN '".$next_mon."' AND '".$next_sun."'";
            $lat_sql = $task_sql . " AND dt.due_date > '".$next_sun."' ORDER BY dt.due_date ASC";

            $od_q = $db->getResults($od_sql);
            $od_num = count($od_q);
            if ($od_num > 0) {
          ?>

            <h4 id="task_od_header" style="color:red;" class="task_od_header">Overdue</h4>
            <ul id="task_od_list">

              <?php foreach ($od_q as $od_r) { ?>

                <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>

                  <input type="checkbox" class="task_status" style="float:left;" value="<?php echo  $od_r['id']; ?>" />

                  <div style="float:left; width:170px;">
                    <?php echo $od_r['task']; ?>

                    <?php
                      if ($od_r['firstname']!='' && $od_r['lastname']!='') {
                        echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                      } 
                    ?>
                  </div>
                </li>
              <?php } ?>

            </ul>
          <?php }
            $tod_q = $db->getResults($tod_sql);
            $tod_num = count($tod_q);

            if ($tod_num > 0) {
          ?>
            <h4 id="task_tod_header" class="task_tod_header">Today</h4>
            <ul id="task_tod_list">

              <?php foreach($tod_q as $od_r) { ?>

                <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>

                  <input type="checkbox" class="task_status" style="float:left;" value="<?php echo  $od_r['id']; ?>" />

                  <div style="float:left; width:170px;">
                    <?php echo $od_r['task']; ?>

                    <?php
                      if($od_r['firstname']!='' && $od_r['lastname']!='') {
                        echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                      }
                    ?>
                  </div>
                </li>

              <?php } ?>

            </ul>

          <?php }

            $tom_q = $db->getResults($tom_sql);
            $tom_num = count($tom_q);

            if ($tom_num > 0) {
          ?>
              <h4 id="task_tom_header" class="task_tom_header">Tomorrow</h4>
              <ul id="task_tom_list">

                <?php foreach ($tom_q as $od_r) { ?>

                  <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                    <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                      <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>

                      <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                    </div>

                    <input type="checkbox" class="task_status" style="float:left;" value="<?php echo  $od_r['id']; ?>" />

                    <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                      <?php
                        if($od_r['firstname']!='' && $od_r['lastname']!=''){
                          echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                        } 
                      ?>
                    </div>
                  </li>

                <?php } ?>
              </ul>
          <?php } ?>

          <?php
            $tw_q = $db->getResults($tw_sql);
            $tw_num = count($tw_q);

            if ($tw_num > 0) {
          ?>
            <h4 id="task_tw_header" class="task_tw_header">This Week</h4>
            <ul id="task_tw_list">

              <?php foreach($tw_q as $od_r) { ?>

                <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>

                  <input type="checkbox" class="task_status" style="float:left;" value="<?php echo  $od_r['id']; ?>" />

                  <div style="float:left; width:170px;">
                    <?php echo $od_r['task']; ?>

                    <?php
                      if($od_r['firstname']!='' && $od_r['lastname']!=''){
                        echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                      }
                    ?>
                  </div>
                </li>
              <?php } ?>

            </ul>

          <?php } ?>

          <?php
            $nw_q = $db->getResults($nw_sql);
            $nw_num = count($nw_q);

            if ($nw_num > 0) {
          ?>

            <h4 id="task_nw_header" class="task_nw_header">Next Week</h4>
            <ul id="task_nw_list">

              <?php foreach ($nw_q as $od_r) { ?>
                <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>

                  <input type="checkbox" class="task_status" style="float:left;" value="<?php echo  $od_r['id']; ?>" />

                  <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                    <?php
                      if($od_r['firstname']!='' && $od_r['lastname']!=''){
                        echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                      }
                    ?>
                  </div>
                </li>
              <?php } ?>

            </ul>
          <?php } ?>

          <?php
            $lat_q = $db->getResults($lat_sql);
            $lat_num = count($lat_q);

            if ($lat_num > 0) {
          ?>

            <h4 id="task_lat_header" class="task_lat_header">Later</h4>
            <ul id="task_lat_list">

              <?php foreach($lat_q as $od_r) { ?>

                <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>

                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>

                  <input type="checkbox" class="task_status" style="float:left;" value="<?php echo  $od_r['id']; ?>" />

                  <div style="float:left; width:170px;">
                    <?php echo  date('M d', strtotime($od_r['due_date'])); ?>
                    -
                    <?php echo $od_r['task']; ?>

                    <?php
                      if($od_r['firstname']!='' && $od_r['lastname']!=''){
                        echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                      }
                    ?>
                  </div>
                </li>
              
              <?php } ?>

            </ul>

          <?php } ?>

          <?php
            if($od_num == 0 && $tod_num == 0 && $tom_num == 0){
            }
          ?>

          <br /><br />

          <a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>
        </div>
      </div> 

      <?php
        if ($_SESSION['docid'] == $_SESSION['userid']) {
          $course_sql = "SELECT use_course FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

          $course_r = $db->getRow($course_sql);

          if ($course_r['use_course'] == 1) {
      ?>

            <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="edx_login.php" target="_blank" onclick="removeCECookies(); return true;">Online CE</a>

            <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="help_login.php" target="_blank" onclick="removeCECookies(); return true;">Snoozle/Help</a>

      <?php
          }
        } else {
          $course_sql = "SELECT s.use_course, d.use_course_staff FROM dental_users s
                         JOIN dental_users d ON d.userid = s.docid
                         WHERE s.userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

          $course_r = $db->getRow($course_sql);

          if ($course_r['use_course'] == 1 && $course_r['use_course_staff'] == 1) {
      ?>

            <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="edx_login.php" target="_blank" onclick="removeCECookies(); return true;">Online CE</a>

            <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="help_login.php" target="_blank" onclick="removeCECookies(); return true;">Snoozle/Help</a>

      <?php
          }
        }
      ?>

      <a style="display:block; margin-right:20px;  margin-top:8px; float:right;" href="calendar.php">Scheduler</a>

      <script type="text/javascript" src="js/task.js"></script> 
      <script type="text/javascript" src="script/autocomplete.js"></script>
      <script type="text/javascript" src="script/autocomplete_local.js?v=<?= time() ?>"></script>
 
      <div style="height:89px; width:100%; background:url(images/dss_01.png) #0b5c82 no-repeat top left;"> 
        <div style="margin-top:10px; margin-left:20px; float:left;">
          <a href="/manage" id="logo">Dashboard</a>
        </div>

        <div style="float:left; width:68%;">
          <form>
            <div id="patient_search_div">
              <input type="text" id="patient_search" value="Patient Search" name="q" autocomplete="off" /><br />

              <div id="search_hints"  class="search_hints" style="display:none;">
                <ul id="patient_list">
                  <li class="template" style="display:none">Doe, John S</li>
                </ul>
              </div>
            </div> 
          </form>

          <button onclick="window.location='add_patient.php'" style="padding: 3px; margin-top:27px;">+ Add Patient</button>

          <button onclick="loadPopup('add_task.php<?php echo  (isset($_GET['pid']))?'?pid='.$_GET['pid']:''; ?>')" style="padding: 3px; margin-top:27px;">+ Add Task</button>
        </div>

        <?php
          $logo_sql = "SELECT c.logo FROM companies c
                       JOIN dental_user_company uc ON uc.companyid = c.id
                       WHERE uc.userid='".$_SESSION['userid']."'";

          $logo_r = $db->getRow($logo_sql);

          if ($logo_r['logo'] != '') {
        ?>
           <div style="float:right;margin:13px 15px 0 0;">
            <img src="display_file.php?f=<?php echo $logo_r['logo']; ?>" />
           </div> 
        <?php } ?>
        
        <div style="clear:both;"></div>
      </div>
  
      <div style="background:url(images/dss_03.jpg) #0b5c82 repeat-y top left;width:100%;">
        <div style="width:98.6%; background:#00457c;margin:0 auto;">

          <?php if (isset($_GET['pid']) && $_GET['pid'] != '') { ?>

            <div id="patient_name_div" <?php echo  (!empty($thename) && strlen($thename)>20)?'style="font-size:14px"':''; ?>>
              <div id="patient_name_inner">

               <?php if (!empty($medicare)) { ?>
                 <img src="images/medicare_logo_small.png" /> 

                 <span class="medicare_name">
               <?php } else { ?>
                 <span class="name">
               <?php } ?>

               <?php echo  (!empty($thename) ? $thename : ''); ?>

               <?php if ($displayAlert && !empty($alertText)) { ?>
                <a href="#" title="<?php echo 'Notes: ' . $alertText; ?>" onclick="return false" style="font-weight:bold; font-size:18px; color:#FF0000;">Notes</a>
               <?php } ?>

               <?php
                  if (!empty($premed) && $premed == 1 || !empty($allergen) && $allergen == 1) {
                    echo "<a href=\"q_page3.php?pid=".$_GET['pid']."\" title=\"".$title."\" style=\"font-weight:bold; font-size:18px; color:#FF0000;\">*Med</a>";
                  }
               ?>
                 </span>
              </div>
            </div>

          <?php
            $t_sql = "select dt.*, du.name, p.firstname, p.lastname from dental_task dt JOIN dental_users du ON dt.responsibleid=du.userid LEFT JOIN dental_patients p ON p.patientid=dt.patientid WHERE (dt.status = '0' OR
              dt.status IS NULL) AND (du.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' OR du.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."') AND dt.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";

            $t_num_sql = $t_sql;
            $num_pat_tasks = $db->getNumberRows($t_num_sql);
            if($num_pat_tasks > 0) {
          ?>

            <div class="task_menu" id="pat_task_menu" style="float:left; margin:10px 0 0 10px;">
              <span id="pat_task_header" style="font-size:14px; font-weight:normal; color:#fff;">Tasks(<?php echo  $num_pat_tasks; ?>)</span>

              <?php
                $od_sql = $t_sql . " AND dt.due_date < CURDATE();";
                $tod_sql = $t_sql . " AND dt.due_date = CURDATE();";
                $tom_sql = $t_sql . " AND dt.due_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY);";
                $fut_sql = $t_sql . " AND dt.due_date > DATE_ADD(CURDATE(), INTERVAL 1 DAY);";
              ?>

              <div class="task_list" id="pat_task_list" style="display:none;">

                <?php
                  $od_q = $db->getResults($od_sql);
                  $od_num = count($od_q);

                  if ($od_num > 0) {
                ?>
                  <h4 id="pat_task_od_header" style="color:red" class="task_od_header">Overdue</h4>
                  <ul id="pat_task_od_list">

                    <?php foreach($od_q as $od_r) { ?>

                      <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                        <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                          <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>

                          <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                        </div>

                        <input type="checkbox" class="task_status" value="<?php echo  $od_r['id']; ?>" />

                        <?php echo $od_r['task']; ?>

                        <?php
                          if($od_r['firstname']!='' && $od_r['lastname']!='') {
                            echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                          }
                        ?>
                      </li>
                    <?php } ?>

                  </ul>

                <?php } ?>

                <?php
                  $od_q = $db->getResults($tod_sql);
                  $od_num = count($od_q);

                  if ($od_num > 0) {
                ?>

                    <h4 id="pat_task_tod_header" class="task_tod_header">Today</h4>
                    <ul id="pat_task_tod_list">

                      <?php foreach($od_q as $od_r) { ?>

                        <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                          <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                            <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>

                            <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                          </div>

                          <input type="checkbox" class="task_status" value="<?php echo  $od_r['id']; ?>" />

                          <?php echo $od_r['task']; ?>

                          <?php
                            if($od_r['firstname']!='' && $od_r['lastname']!=''){
                              echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                            }
                          ?>
                        </li>

                      <?php } ?>

                    </ul>

                <?php } ?>

                <?php
                  $od_q = $db->getResults($tom_sql);
                  $od_num = count($od_q);

                  if ($od_num > 0) {
                ?>

                  <h4 id="pat_task_tom_header" class="task_tom_header">Tomorrow</h4>
                  <ul id="pat_task_tom_list">

                    <?php foreach($od_q as $od_r) { ?>

                      <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                        <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                          <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>

                          <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                        </div>

                        <input type="checkbox" class="task_status" value="<?php echo  $od_r['id']; ?>" />

                        <?php echo $od_r['task']; ?>

                        <?php
                          if($od_r['firstname']!='' && $od_r['lastname']!=''){
                            echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                          }
                        ?>
                      </li>

                    <?php } ?>

                  </ul>
                <?php } ?>

                <?php
                  $od_q = $db->getResults($fut_sql);
                  $od_num = count($od_q);

                  if ($od_num > 0) {
                ?>

                  <h4 id="pat_task_fut_header" class="task_fut_header">Future</h4>
                  <ul id="pat_task_fut_list">

                    <?php foreach($od_q as $od_r) { ?>

                      <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                        <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                          <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                          <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                        </div>

                        <input type="checkbox" class="task_status" value="<?php echo  $od_r['id']; ?>" />

                        <?php echo $od_r['task']; ?>

                        <?php
                          if($od_r['firstname']!='' && $od_r['lastname']!='') {
                            echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                          }
                        ?>
                      </li>

                    <?php } ?>

                  </ul>

                <?php } ?>
              </div>
            </div>
          <?php } ?>
        <?php } ?>

        <?php if(isset($_GET['pid'])) { ?>

          <a href="#" style="float:left; margin-left:10px;margin-top:8px;<?php echo  (!empty($_COOKIE['hide_pat_warnings']) && $_COOKIE['hide_pat_warnings'] == $_GET['pid'])?'':'display:none;';?>" class="button" id="show_patient_warnings" onclick="$.cookie('hide_pat_warnings', '');$('#patient_warnings').show();$('#show_patient_warnings').hide();$('#hide_patient_warnings').show();return false;">Show Warnings</a>

          <a href="#" style="float:left; margin-left:10px;margin-top:8px;<?php echo  (!empty($_COOKIE['hide_pat_warnings']) && $_COOKIE['hide_pat_warnings'] == $_GET['pid'])?'display:none':'';?>" class="button" id="hide_patient_warnings" onclick="$.cookie('hide_pat_warnings', <?php echo $_GET['pid'];?>);$('#patient_warnings').hide();$('#show_patient_warnings').show();$('#hide_patient_warnings').hide();return false;">Hide Warnings</a>

        <?php } ?>

        <div class="suckertreemenu">
          <span style="line-height:38px; margin-right:10px;font-size:20px; color:#fff; float:right;">
            Welcome <?php echo  $_SESSION['username']; ?>
          </span>
        </div>

        <?php if(isset($_GET['pid']) && $_GET['pid']!='') { ?>

          <div id="patient_nav">
            <ul>
              <li>
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_flowsheet3.php')?'nav_active':'';?>" <?php {echo "href='manage_flowsheet3.php?pid=".$_GET['pid']."&addtopat=1'";} ?>>Tracker</a>
              </li>

              <li>
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/dss_summ.php')?'nav_active':'';?>" <?php {echo "href='dss_summ.php?pid=".$_GET['pid']."&addtopat=1'";} ?>>Summary Sheet</a>
              </li>

              <li>
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_ledger.php')?'nav_active':'';?>" <?php {echo "href='manage_ledger.php?pid=".$_GET["pid"]."&addtopat=1'";} ?>>Ledger</a>
              </li>

              <li>
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_insurance.php')?'nav_active':'';?>" <?php { echo "href='manage_insurance.php?pid=".$_GET["pid"]."&addtopat=1'";} ?>>Insurance</a>
              </li>

              <li>
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/manage_progress_notes.php')?'nav_active':'';?>" <?php {echo "href='dss_summ.php?sect=notes&pid=".$_GET["pid"]."&addtopat=1'";} ?>>Progress Notes</a>
              </li>

              <li>
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/patient_letters.php')?'nav_active':'';?>" <?php {echo "href='dss_summ.php?sect=letters&pid=".$_GET['pid']."&addtopat=1'";} ?>>Letters</a>
              </li>

              <li>
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/q_image.php')?'nav_active':'';?>" href="q_image.php?pid=<?php echo  $_GET['pid'] ?>">Images</a>
              </li>

              <li>
                <a class="<?php echo  (strpos($_SERVER['PHP_SELF'],'q_page') || strpos($_SERVER['PHP_SELF'],'q_sleep'))?'nav_active':'';?>" href="q_page1.php?pid=<?php echo  $_GET['pid'] ?>&addtopat=1">Questionnaire</a>
              </li>

              <li>
                <a class="<?php echo  (strpos($_SERVER['PHP_SELF'],'ex_page'))?'nav_active':'';?>" href="ex_page4.php?pid=<?php echo  $_GET['pid'] ?>&addtopat=1">Clinical Exam</a>
              </li>

              <li class="last">
                <a class="<?php echo  ($_SERVER['PHP_SELF']=='/manage/add_patient.php')?'nav_active':'';?>" href="add_patient.php?ed=<?php echo  $_GET['pid'] ?>&addtopat=1&pid=<?php echo  $_GET['pid'] ?>">Patient Info</a>
              </li>
            </ul>
          </div>

        <?php } else { ?>
          <div style="clear:both;"></div>
        <?php } ?>   
      </div>
    <div style="clear:both;"></div>
  </div>

  <div style="background:url(images/dss_03.jpg) repeat-y top left #FFFFFF;" id="contentMain">
    <div style="clear:both;"></div>

      <?php if(isset($_GET['pid']) && $_GET['pid']!= ''){ ?>
        <div style="margin-left:20px;float:left;width:400px;display:none;">
          <?php echo "You are currently in a patient chart - " ?>

          <a href="manage_patient.php" target="_self" style="font-weight:bold;">BACK TO PATIENT LIST</a>

        </div>

        <div style="float:right;width:300px;"> 
          <?php
            $sql = "select * from dental_patients where docid='".$_SESSION['docid']."' AND patientid='".$_GET['pid']."'";
          
            $my = $db->getResults($sql);

            foreach ($my as $myarray) {
              $thename = $myarray['firstname'] . " " . $myarray['lastname'];
              
              if ($myarray["premedcheck"] == 1) {
              }
            }
          ?>
        </div>
      <?php } ?>

      <br />

      <?php if(isset($_COOKIE['hide_pat_warnings']) && (!isset($_GET['pid']) || $_COOKIE['hide_pat_warnings'] != $_GET['pid'])) { ?>

        <script type="text/javascript">
         $.cookie('hide_pat_warnings', '');
        </script>

      <?php }
        if (isset($_GET['pid'])) {
      ?>

      <div id="patient_warnings" <?php echo  (!empty($_COOKIE['hide_pat_warnings']) && $_COOKIE['hide_pat_warnings'] == $_GET['pid'])?'style="display:none;"':'';?>>

        <?php
          if (isset($_GET['pid']) && $_GET['pid'] != '' && $_GET['pid'] != '0') {
             $s = "SELECT * FROM dental_patients WHERE parent_patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";
           
            $pat = $db->getRow($s);
            $n = count($pat);
            $n = num_patient_changes($_GET['pid']);
           
            $contacts_sql = "SELECT pc.id, pc.contacttype, pc.firstname, pc.lastname, pc.address1, pc.address2, pc.city, pc.state, pc.zip, pc.phone,
              p.firstname as patfirstname, p.lastname as patlastname
              FROM dental_patient_contacts pc 
              INNER JOIN dental_patients p ON pc.patientid=p.patientid
              WHERE p.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND
              p.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";

            $total_contacts = $db->getNumberRows($contacts_sql);

            $insurance_sql = "SELECT pi.*, p.firstname as patfirstname, p.lastname as patlastname FROM dental_patient_insurance pi INNER JOIN dental_patients p ON pi.patientid=p.patientid 
                WHERE p.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND
                p.patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";

            $total_insurance = $db->getNumberRows($insurance_sql);

            if (($n + $total_contacts + $total_insurance) > 0) {
        ?>

          <a class="warning" href="patient_changes.php?pid=<?php echo $_GET['pid'];?>">
            <span>Warning! Patient has updated their PROFILE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
          </a>
        <?php } 
          $exist_sql = "SELECT symptoms_status, treatments_status, history_status FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";

          $exist_row = $db->getRow($exist_sql);

          if(isset($exist_row['symptoms_status']) && $exist_row['symptoms_status'] == 2 || isset($exist_row['treatments_status']) && $exist_row['treatments_status'] == 2 || isset($exist_row['history_status']) && $exist_row['history_status'] == 2 || isset($exist_row['sleep_status']) && $exist_row['sleep_status'] == 2) { ?>
              <a class="warning" href="q_page1.php?pid=<?php echo  $_GET['pid']; ?>&addtopat=1" >
                <span>Warning! Patient has updated their QUESTIONNAIRE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.</span>
              </a>
        <?php }
          $email_sql = "SELECT patientid FROM dental_patients WHERE email_bounce=1 AND patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";

          if ($db->getNumberRows($email_sql) > 0) {
        ?>

          <a class="warning" href="add_patient.php?ed=<?php echo  $_GET['pid']; ?>&pid=<?php echo  $_GET['pid']; ?>&addtopat=1" >
            <span>Warning! Email sent to this patient has bounced. Please click to check patients email.</span>
          </a>

        <?php }
          $rc_sql = "SELECT * FROM dental_insurance WHERE 
                     (status='".DSS_CLAIM_REJECTED."' OR status='".DSS_CLAIM_SEC_REJECTED."')
                     AND patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'";

          $rc_q = $db->getResults($rc_sql);
          $rc_num = count($rc_q);

          if ($rc_num > 0) {
        ?>
          <span class="warning">Warning! Patient has the following rejected claims: <br />

            <?php foreach ($rc_q as $rejected) { ?>
              <a href="view_claim.php?claimid=<?php echo  $rejected['insuranceid']; ?>&pid=<?php echo  $_GET['pid']; ?>">
                <?php echo  $rejected['insuranceid']; ?> - <?php echo  date('m/d/Y', strtotime($rejected['adddate'])); ?>
              </a><br />
            <?php } ?>

          </span>
        <?php }
          $rc_sql = "SELECT *
              FROM dental_hst
              WHERE (
                      status = '".(defined('DSS_HST_REQUSTED') ? DSS_HST_REQUSTED : '')."'
                      OR status = '".(defined('DSS_HST_PENDING') ? DSS_HST_PENDING : '')."'
                      OR status = '".(defined('DSS_HST_SCHEDULED') ? DSS_HST_SCHEDULED : '')."'
                      OR (
                          status = '".(defined('DSS_HST_REJECTED') ? DSS_HST_REJECTED : '')."'
                          AND (viewed IS NULL OR viewed = 0)
                      )
                  )
                  AND patient_id = '".mysqli_real_escape_string($con,$_GET['pid'])."'";

          $rc_q = $db->getResults($rc_sql);
          $pat_hst_num_uncompleted = count($rc_q);

          $pat_hst_status = '';

          if (count($rc_q) > 0) {
        ?>

          <span class="warning">Patient has the following Home Sleep Tests: <br />
        
            <?php
              foreach($rc_q as $hst){          
            ?>

            <a href="/manage/hst_request.php?pid=<?= $hst['patient_id'] ?>&amp;hst_id=<?= $hst['id'] ?>">HST was requested <?php echo  date('m/d/Y', strtotime($hst['adddate'])); ?></a>
              and is currently 

            <?php if($hst['status'] == DSS_HST_REJECTED) { ?>
              <a href="manage_hst.php?status=4&viewed=0"><?php echo  $dss_hst_status_labels[$hst['status']]; ?></a>
            <?php } else { ?>
              <?php echo  $dss_hst_status_labels[$hst['status']]; ?>
            <?php } ?>

            <?php echo ($hst['status'] == DSS_HST_SCHEDULED)?' - ' . $hst['office_notes']:''; ?>

            <?php echo  ($hst['status'] == DSS_HST_REJECTED)?' - ' . $hst['rejected_reason']:''; ?>

            <?php echo  ($hst['status'] == DSS_HST_REJECTED && $hst['rejecteddate']!='')?' - '.date('m/d/Y h:i a', strtotime($hst['rejecteddate'])):''; ?>

            <?php if ($hst['status'] == DSS_HST_REJECTED) { ?>
              <br />
              <a href="manage_hst.php?status=4&viewed=0">Click here</a> to remove this error
            <?php } ?>
            
              <br />
            
            <?php
              $pat_hst_status = $dss_hst_status_labels[$hst['status']];
              }
            ?>

          </span>
        <?php }
            }
        ?>
      </div>
    <?php }
      $sql = "SELECT use_letters from dental_users WHERE userid='" . mysqli_real_escape_string($con,$_SESSION['docid']) . "'";

      $r = $db->getRow($sql);

      $use_letters = ($r['use_letters']=='1');
} //CLOSE HOME PAGE CHECK

$office_type = DSS_OFFICE_TYPE_FRONT;
</template>

<script>
    // module.exports = require('./source.js');
</script>

<style src="./header.css"></style>