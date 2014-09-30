<?php
  include 'includes/top2.htm';
?>

  <br />
  
  <div>
    <table>
      <tr>
        <td valign="top" style="border-right:1px solid #00457c;width:290px;">
          <div style="padding-left:10px; padding-right:10px; margin-right:5px;" id="formLeftC">
            <?php
              $adminmemo_check_sql = "SELECT * FROM memo_admin";

              $adminmemo_check_qry = $db->getResults($adminmemo_check_sql);
              foreach ($adminmemo_check_qry as $adminmemo_array) {
                if ($adminmemo_array['memo'] != NULL || $adminmemo_array['memo'] != '') {
                  $todays_date = date("Y-m-d"); 
                  $exp_date = $adminmemo_array['off_date'];
                  $today = strtotime($todays_date);
                  $expiration_date = strtotime($exp_date);

                  if ($expiration_date > $today) {
	          ?>
                    <div style="color:#ff0000; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;">
                      <span class="admin_head" style="color:#ff0000;"><em> Global Memo: </em></span>
                    </div>

        	          <br />

        	          <table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
                      <tr>
                        <td valign="top">  
                          <?php
                            echo "". $adminmemo_array['memo'] . "<br />";
                          ?>
                        </td>
                      </tr>
                    </table>

                    <br />
            <?php } else {
                  }
                }
              } 
            ?>

            <div style="color:#00457c; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;">
              <span class="admin_head" style="color:#00457c;"><em> Todays Memo: </em></span>
            </div>

          	<br />

          	<table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
              <tr>
                <td valign="top">    
                  <?php 
                    $memouserid = $_SESSION['userid'];
                    $memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid}";

                    $memo_check_qry = $db->getResults($memo_check_sql);
                    if (count($memo_check_qry)) foreach ($memo_check_qry as $memo_array) {
                      if ($memo_array != NULL || $memo_array != '') {
                        echo $memo_array['memo'] . "<br /><hr />";
                      }
                    }
                  ?>

                  <a href="Javascript: ;" target="_blank" class="viewtable" title="EDIT" onclick="Javascript: loadPopup('memo.php'); getElementById('popupMemo').style.top = '200px'; return false;">Edit Memo</a>
                </td>    
              </tr>
            </table>

            <br /> 

            <?php if ($num_rejected_preauth > 0) { ?>
              <a href="manage_vobs.php?status=<?php echo  DSS_PREAUTH_REJECTED; ?>&viewed=0" class="notification bad_count">
                <?php echo  $num_rejected_preauth; ?> Alerts
              </a>
            <?php } ?>

            <?php if ($pending_letters > 0 && $use_letters) { ?>
              <a href="letters.php?status=pending" class="notification <?php echo  ($pending_letters==0)?"good_count":"bad_count"; ?>">
                <?php echo  $pending_letters;?> Letters
              </a>
            <?php } ?>

            <?php if ($unmailed_letters > 0 && $use_letters && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
              <a href="letters.php?status=sent&mailed=0" class="notification bad_count">
                <?php echo  $unmailed_letters;?> Unmailed Letters
              </a>
            <?php } ?>

            <?php if ($num_preauth > 0) { ?>
              <a href="manage_vobs.php?status=<?php echo  DSS_PREAUTH_COMPLETE; ?>&viewed=0" class="notification <?php echo  ($num_preauth==0)?"good_count":"great_count"; ?>">
                <?php echo  $num_preauth;?> Verifications
              </a>
            <?php } ?>

            <?php if ($num_bounce !=0 ) { ?>
              <a href="manage_email_bounces.php" class="notification <?php echo  ($num_bounce==0)?"good_count":"bad_count"; ?>">
                <?php echo  $num_bounce;?> Email Bounces
              </a>
            <?php } ?>

            <?php if ($num_unsigned !=0 ) { ?>
              <a href="manage_unsigned_notes.php" class="notification <?php echo  ($num_unsigned==0)?"good_count":"bad_count"; ?>">
                <?php echo  $num_unsigned;?> Unsigned Notes
              </a>
            <?php } ?>

            <?php if ($num_pending_nodss_claims !=0 && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
              <a href="manage_claims.php" class="notification <?php echo  ($num_pending_nodss_claims==0)?"good_count":"bad_count"; ?>">
                <?php echo  $num_pending_nodss_claims;?> Pending Claims
              </a>
            <?php } ?>

            <?php if ($num_unmailed_claims !=0 && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
              <a href="manage_claims.php?unmailed=1" class="notification <?php echo  ($num_unmailed_claims==0)?"good_count":"bad_count"; ?>">
                <?php echo  $num_unmailed_claims;?> Unmailed Claims
              </a>
            <?php } ?>

            <div class="task_menu index_task">
              <h3>My Tasks</h3>

              <?php
                if ($od_num > 0) {
              ?>

                  <h4 style="margin-bottom:0px;color:red;" class="task_od_header">Overdue</h4>
                  <ul class="task_od_list">

                    <?php foreach ($od_q as $od_r) { ?>
                      <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                        <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                          <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                          <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                        </div>

                        <input type="checkbox" style="float:left; " class="task_status" value="<?php echo  $od_r['id']; ?>" />
                        
                        <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                          <?php
                            if($od_r['firstname']!='' && $od_r['lastname']!=''){
                              echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                            }
                          ?>
                        </div>
                      </li>
                    <?php } ?>

                  </ul>

              <?php
                }

                if ($tod_num > 0) {
              ?>

                  <h4 style="margin-bottom:0px;" class="task_tod_header">Today</h4>
                  <ul class="task_tod_list">

                    <?php foreach ($tod_q as $od_r) { ?>
                      <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                        <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                          <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                          <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                        </div>

                        <input type="checkbox" style="float:left;" class="task_status" value="<?php echo  $od_r['id']; ?>" />
                        
                        <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                          <?php
                            if($od_r['firstname']!='' && $od_r['lastname']!=''){
                              echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                            }
                          ?>
                        </div>
                      </li>
                    <?php } ?>

                  </ul>
                
              <?php
                }

                if ($tom_num > 0) {
              ?>
                
                  <h4 style="margin-bottom:0px;" class="task_tom_header">Tomorrow</h4>
                  <ul class="task_tom_list">

                    <?php foreach($tom_q as $od_r) { ?>
                      <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                        <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                          <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                          <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                        </div>

                        <input type="checkbox" style="float:left;" class="task_status" value="<?php echo  $od_r['id']; ?>" />
                        
                        <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                          <?php
                            if($od_r['firstname']!='' && $od_r['lastname']!=''){
                              echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                            }
                          ?>
                        </div>
                      </li>
                    <?php } ?>

                  </ul>
              <?php
                }

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
                        
                        <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                          <?php
                            if($od_r['firstname']!='' && $od_r['lastname']!=''){
                              echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                            }
                          ?>
                        </div>
                      </li>
                    <?php } ?>

                  </ul>

              <?php
                } 

                if ($nw_num > 0) {
              ?>

                  <h4 id="task_nw_header" class="task_nw_header">Next Week</h4>
                  <ul id="task_nw_list">

                    <?php foreach($nw_q as $od_r) { ?>
                      <li class="task_item task_<?php echo  $od_r['id']; ?>" style="clear:both;">
                        <div class="task_extra" id="task_extra_<?php echo  $od_r['id']; ?>" >
                          <a href="#" onclick="delete_task('<?php echo  $od_r['id']; ?>')" class="task_delete"></a>
                          <a href="#" onclick="loadPopup('add_task.php?id=<?php echo  $od_r['id']; ?>')" class="task_edit">Edit</a>
                        </div>

                        <input type="checkbox" class="task_status" style="float:left;" value="<?php echo  $od_r['id']; ?>" />
                        
                        <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                          <?php
                            if($od_r['firstname']!='' && $od_r['lastname']!=''){
                              echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                            }
                          ?>
                        </div>
                      </li>
                    <?php } ?>

                  </ul>

              <?php 
                }

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
                              echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                            }
                          ?>
                        </div>
                      </li>
                    <?php } ?>

                  </ul>
              <?php
                }
              ?>

              <br /><br />

              <a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>
            </div>

            <div style="margin-top:25px;  width:100%;">&nbsp;</div> 
            <hr />
            <div style="margin-top:0px; width:100%;">&nbsp;</div>         
          </div>
        </td>
        <td valign="top">
          <div style="width:660px; float:right; margin-left:5px;">
            <table width="660" border="0" align="center" cellpadding="0" cellspacing="0">
        	    <tr>
        		    <td valign="top" class="em_title">
            			<?php if ($_SESSION['username'] <> '') { ?>
            				Welcome <?php echo $_SESSION['username'];?>
            			<?php } else { ?>
            				Welcome to <?php echo $sitename;?>
            			<?php }?>
        		    </td>
	            </tr>
            </table>

            <br /><br />

            <?php 
              if($_SESSION['userid'] != '') {
              	$welcome_sql = "select * from dental_doc_welcome where status=1 and (docid = '' or docid like '%~".$_SESSION['docid']."~%') order by sortby";
              	
                $welcome_my = $db->getResults($welcome_sql);
              	foreach ($welcome_my as $welcome_myarray) {
              		if (st($welcome_myarray['video_file']) != '') { 
            ?>
              			<center>
              			  <a href="Javascript: ;" class="click" title="Welcome Video" onclick="Javascript: loadPopup('welcome_detail.php?v_f=<?php echo st($welcome_myarray['video_file'])?>'); getElementById('popupContact').style.top = '200px'; return false;">
              				Click Here for Welcome Video </a>
              			</center>
					  <?php }	?>
		              <?php echo html_entity_decode(st($welcome_myarray['description'])); ?>
		              
                  <br />
		        <?php
                }
            ?>
              	<center>
                  <img src="images/cpanelImgMap_06.jpg" width="474" height="466" border="0" usemap="#Map" />

                  <map name="Map" id="Map">
                    <area shape="rect" alt="PATIENTS" title="Manage Patients" coords="13,4,234,230" href="manage_patient.php" />
                    <area shape="rect" alt="LEDGER/REPORTS" title="Ledger Reports" coords="233,4,462,231" href="ledger.php" />
                    <area shape="rect" alt="DIRECTORY/CONTACTS" title="Contacts" coords="13,230,233,459" href="directory.php" />
                    <area shape="rect" alt="TOOLS" title="Configuration" coords="232,230,462,458" href="tools.php" />
                  </map>
                </center>
                
                <br />

                <?php if($_SESSION['username'] <> '') { ?>
              			    <font style="font-size:15px; font-weight:bold; color:#00457c;"><center>Welcome <?php echo $_SESSION['username'];?> -</font><font style="font-size:17px; font-weight:bold; color:#000000;"> Select A Category</center></font>
              	<?php } else { ?>
              				  <font style="font-size:15px; font-weight:bold; color:#00457c;"><center>Welcome to <?php echo $sitename;?></center></font>
              	<?php } ?>

                <br />	

            <?php
              }
            ?>
          </div>
        </td>
      </tr>
    </table>

    <br /><br />

<?php include 'includes/bottom.htm';?>