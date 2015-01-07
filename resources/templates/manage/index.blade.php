{!! HTML::style('css/manage/index.css') !!}

<table>
    <tr>
        <td valign="top" style="border-right:1px solid #00457c;width:980px;">
            <div class="home_third first">
                <h3>Navigation</h3>
                <div class="homesuckertreemenu">
                    <ul id="homemenu">
                        <li>
                            {!! HTML::link('#', 'Directory') !!}                      
                            <ul>
                                <li>{!! HTML::link('manage_contact', 'Contacts') !!}</li>
                                <li>{!! HTML::link('manage_referredby', 'Referral List') !!}</li>
                                <li>{!! HTML::link('manage_sleeplab', 'Sleep Labs') !!}</li>
                                <li>{!! HTML::link('manage_fcontact', 'Corporate Contacts') !!}</li>  
                            </ul>
                        </li>
                        <li>
                            {!! HTML::link('#', 'Reports') !!}
                            <ul>
                                <li>{!! HTML::link('ledger_reportfull', 'Ledger') !!}</li>
                                <li>{!! HTML::link('manage_claims', 'Claims $num_pending_claims') !!}</li> 
                                <li>{!! HTML::link('performance', 'Performance') !!}</li>
                                <li>{!! HTML::link('manage_screeners/contacted/0', 'Pt. Screener') !!}</li>
                                <li>{!! HTML::link('manage_vobs', 'VOB History') !!}</li>
    
                                @if ($docId == $userId || $receivedValues['manage_staff'] == 1)
                                    <li>{!! HTML::link('invoice_history', 'Invoices') !!}</li>
                                @endif

                                <li>{!! HTML::link('manage_faxes', 'Fax History') !!}</li>
                                <li>{!! HTML::link('manage_hst', 'Home Sleep Tests') !!}</li>
                            </ul>
                        </li>
                        <li>
                            {!! HTML::link('#', 'Admin', array('class' => 'menu_item')) !!}
                            <ul>
                                <li>{!! HTML::link('manage_claim_setup', 'Claim Setup') !!}</li>
                                <li>{!! HTML::link('manage_profile', 'Profile') !!}</li>
                                <li>
                                    {!! HTML::link('#', 'Text') !!}
                                    <ul>
                                        <li>{!! HTML::link('manage_custom', 'Custom Text') !!}</li>
                                        <li>{!! HTML::link('manage_custom_letters', 'Custom Letters') !!}</li>
                                    </ul>
                                </li>
                                <li>{!! HTML::link('change_list', 'Change List') !!}</li>

                                @if ($userId == $docId || $receivedValues['manage_staff'] == 1)               
                                    <li>{!! HTML::link('manage_transaction_code', 'Transaction Code', array('class' => 'submenu_item')) !!}</li>     
                                @endif
                       
                                <li>{!! HTML::link('manage_staff', 'Staff') !!}</li>
                                <li>
                                    {!! HTML::link('#', 'Scheduler') !!}
                                    <ul>
                                        <li>{!! HTML::link('manage_chairs', 'Resources') !!}</li>
                                        <li>{!! HTML::link('manage_appts', 'Appointment Types') !!}</li>
                                    </ul>
                                </li>
                                <li>{!! HTML::link('export_md', 'Export MD', array('onclick' => "return (prompt('Enter password')=='1234');")) !!}</li>
                                <li>
                                    {!! HTML::link('#', 'DSS Files') !!}
                                    <ul>
                                        @if (!empty($documentCategories)) 
                                            @foreach ($documentCategories as $dss_file)
                                                <li>{!! HTML::link("view_documents/cat/$dss_file['categoryid']", "$dss_file['name']", array('class' => 'submenu_item')) !!}</li>  
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li>{!! HTML::link('manage_locations', 'Manage Locations') !!}</li>
                                <li>{!! HTML::link('data_import', 'Data Import', array('onclick' => "return confirm('Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.');")) !!}</li>   
                
                                @if ($receivedValues['use_eligible_api'] == 1)
                                    <li>{!! HTML::link('manage_enrollment', 'Enrollments') !!}</li>
                                @endif
                            </ul>
                        </li>
                        <li>{!! HTML::link('/screener/auto_login', 'Pt. Screener App') !!}</li>
                        <li>{!! HTML::link('manage_user_forms', 'Forms') !!}</li>
                        <li>
                            {!! HTML::link('#', 'Education') !!}
                            <ul>
                                <li>{!! HTML::link('manual', 'Dental Sleep Solutions Procedures Manual') !!}</li>
                                <li>{!! HTML::link('medicine_manual', 'Dental Sleep Medicine Manual') !!}</li>

                                @if ($userType == $DSS_USER_TYPE_FRANCHISEE)
                                    <li>{!! HTML::link('operations_manual', 'DSS Franchise Operations Manual') !!}</li>                
                                @endif

                                <li>{!! HTML::link('quick_facts', 'Quick Facts Reference') !!}</li>
                                <li>{!! HTML::link('videos', 'Watch Videos') !!}</li> 
                                
                                @if ($docId == @userId)
                                    @if($receivedValues['use_course'] == 1) 
                                        <li>{!! HTML::link('edx_login', 'Get C.E.', array('target' => '_blank')) !!}</li>
                                    @endif
                                @elseif ($course['use_course'] == 1 && $course['use_course_staff'] == 1)
                                        <li>{!! HTML::link('edx_login', 'Get C.E.', array('target' => '_blank')) !!}</li>
                                    @endif
                                @endif

                                <li>{!! HTML::link('edx_certificate', 'Certificates') !!}</li>
                            </ul>
                        </li>
                        <li>{!! HTML::link('sw_tutorials', 'SW Tutorials') !!}</li>
                        <li>{!! HTML::link('calendar', 'Scheduler') !!}</li>
                        <li>{!! HTML::link('manage_patient', 'Manage Pts') !!}</li>
                        <li>{!! HTML::link('#', 'Device Selector', array('onclick' => "loadPopup('includes/device_guide.php'); return false;")) !!}</li>
                    </ul>
                </div>
            </div>
            <div class="home_third">
                <h3>Notifications</h3>

                <?php
                /**

                */
                $num_portal = $num_pc + $num_pi + $num_c;
                /**

                */
                ?>

                <div class="notsuckertreemenu">
                    <ul id="notmenu">
                        <li>
                            <a href="#" class=" count_<?php echo $num_portal; ?> notification bad_count"><?php echo  $num_portal; ?> Web Portal <div class="arrow_right"></div></a>
                            <ul>
                                <li><a href="manage_patient_contacts.php" class=" count_<?php echo  $num_pc; ?> notification bad_count"><span class="count"><?php echo  $num_pc; ?></span><span class="label">Pt Contacts</span></a></li>
                                <li><a href="manage_patient_insurance.php" class=" count_<?php echo  $num_pi; ?> notification bad_count"><span class="count"><?php echo  $num_pi; ?></span><span class="label">Pt Insurance</span></a></li>
                                <li><a href="manage_patient_changes.php" class=" count_<?php echo  $num_c; ?> notification bad_count"><span class="count"><?php echo  $num_c; ?></span><span class="label">Pt Changes</span></a></li>
                            </ul>
           </li>
          </ul>
        </div>  

        <?php if ($use_letters): ?>
          <a href="letters.php?status=pending" class=" count_<?php echo $pending_letters; ?> notification <?php echo ($pending_letters==0)?"good_count":"bad_count"; ?>"><span class="count"><?php echo $pending_letters;?></span><span class="label">Letters</span></a>
        <?php endif ?>

        <?php if ($use_letters && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE): ?>
          
          <a href="letters.php?status=sent&mailed=0" class=" count_<?php echo $unmailed_letters; ?> notification bad_count">
            <span class="count"><?php echo $unmailed_letters;?></span>
            <span class="label">Unmailed Letters</span>
          </a>
        
        <?php endif ?>

        <a href="manage_vobs.php?status=<?php echo DSS_PREAUTH_COMPLETE; ?>&viewed=0" class=" count_<?php echo $num_preauth; ?> notification <?php echo ($num_preauth==0)?"good_count":"great_count"; ?>">
          <span class="count"><?php echo $num_preauth;?></span>
          <span class="label">VOBs</span>
        </a>

        <a href="manage_hst.php?status=<?php echo DSS_HST_COMPLETE; ?>&viewed=0" class=" count_<?php echo $num_hst; ?> notification <?php echo ($num_hst==0)?"good_count":"great_count"; ?>">
          <span class="count"><?php echo $num_hst;?></span>
          <span class="label">HSTs</span>
        </a>

        <a href="manage_hst.php?status=<?php echo DSS_HST_REJECTED; ?>&viewed=0" class=" count_<?php echo $num_rejected_hst; ?> notification <?php echo ($num_rejected_hst==0)?"good_count":"bad_count"; ?>">
          <span class="count"><?php echo $num_rejected_hst;?></span>
          <span class="label">Rejected HSTs</span>
        </a>

        <a href="manage_hst.php?status=<?php echo DSS_HST_REQUESTED; ?>&viewed=0" class=" count_<?php echo $num_requested_hst; ?> notification <?php echo ($num_requested_hst==0)?"good_count":"bad_count"; ?>">
          <span class="count"><?php echo $num_requested_hst;?></span>
          <span class="label">Unsent HSTs</span>
        </a>

        <?php if ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE): ?>
          <a href="manage_claims.php" class="notification  count_<?php echo $num_pending_nodss_claims; ?> <?php echo ($num_pending_nodss_claims==0)?"good_count":"bad_count"; ?>"><span class="count"><?php echo $num_pending_nodss_claims;?></span><span class="label">Pending Claims</span></a>
        <?php endif ?>

        <?php if ($_SESSION['user_type'] == DSS_USER_TYPE_FRANCHISEE): ?>
          <a href="manage_claims.php" class=" count_<?php echo $num_pending_claims; ?> notification <?php echo ($num_pending_claims==0)?"good_count":"bad_count"; ?>"><span class="count"><?php echo $num_pending_claims;?></span><span class="label">Pending Claims</span></a>
        <?php endif ?>

        <?php if ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE): ?>
          <a href="manage_claims.php?unmailed=1" class=" count_<?php echo $num_unmailed_claims; ?> notification <?php echo ($num_unmailed_claims==0)?"good_count":"bad_count"; ?>"><span class="count"><?php echo $num_unmailed_claims;?></span><span class="label">Unmailed Claims</span></a>
        <?php endif ?>

        <a href="manage_rejected_claims.php" class=" count_<?php echo $num_rejected_claims; ?> notification <?php echo ($num_rejected_claims==0)?"good_count":"bad_count"; ?>">
          <span class="count"><?php echo $num_rejected_claims;?></span>
          <span class="label">Rejected Claims</span>
        </a>

        <a href="manage_unsigned_notes.php" class=" count_<?php echo $num_unsigned; ?> notification <?php echo ($num_unsigned==0)?"good_count":"bad_count"; ?>">
          <span class="count"><?php echo $num_unsigned;?></span>
          <span class="label">Unsigned Notes</span>
        </a>

        <?php $num_alerts = $num_rejected_preauth; ?>

        <a href="manage_vobs.php?status=<?php echo DSS_PREAUTH_REJECTED; ?>&viewed=0" class=" count_<?php echo $num_alerts; ?> notification bad_count">
          <span class="count"><?php echo $num_alerts; ?></span>
          <span class="label">Alerts</span>
        </a>

        <a href="manage_faxes.php" class="notification  count_<?php echo $num_fax_alerts; ?> <?php echo ($num_fax_alerts==0)?"good_count":"bad_count"; ?>">
          <span class="count"><?php echo $num_fax_alerts;?></span>
          <span class="label">Failed Faxes</span>
        </a>

        <a href="pending_patient.php" class="notification  count_<?php echo $num_pending_duplicates; ?> <?php echo ($num_pending_duplicates==0)?"good_count":"bad_count"; ?>">
          <span class="count"><?php echo $num_pending_duplicates;?></span>
          <span class="label">Pending Duplicates</span>
        </a>

        <a href="manage_email_bounces.php" class="notification count_<?php echo $num_bounce; ?> <?php echo ($num_bounce==0)?"good_count":"bad_count"; ?>">
          <span class="count"><?php echo $num_bounce;?></span>
          <span class="label">Email Bounces</span>
        </a>

        <a href="#" onclick="$('.notification.count_0').css('display', 'block');$(this).hide();$('#not_show_active').show();return false;" id="not_show_all">Show All</a>
        <a href="#" onclick="$('.notification.count_0').hide();$(this).hide();$('#not_show_all').show();return false;" style="display:none;" id="not_show_active">Show Active</a>
      </div>

      <div class="home_third">

        <h3>Tasks</h3>

        <div class="task_menu index_task">
          <h4>My Tasks</h4>

          <?php             $od_q = $db->getResults($od_sql);
            
            if(count($od_q) > 0):
          ?>

            <h4 style="margin-bottom:0px;color:red;" class="task_od_header">Overdue</h4>
            <ul class="task_od_list">

              <?php foreach ($od_q as $od_r) { ?>

                <li class="task_item task_<?php echo $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>
                  <input type="checkbox" style="float:left; " class="task_status" value="<?php echo $od_r['id']; ?>" />
                  <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                  
                    <?php                      if ($od_r['firstname'] != '' && $od_r['lastname'] != ''){
                      echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                     }
                    ?>
                  </div>
                </li>

              <?php } ?>

            </ul>
          <?php endif ?>

          <?php             $tod_q = $db->getResults($tod_sql);

            if (count($tod_q) > 0):
          ?>
          
            <h4 style="margin-bottom:0px;" class="task_tod_header">Today</h4>
            <ul class="task_tod_list">

              <?php foreach ($tod_q as $od_r) { ?>

                <li class="task_item task_<?php echo $od_r['id']; ?>" style="clear:both;">

                  <div class="task_extra" id="task_extra_<?php echo $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>
                  <input type="checkbox" style="float:left;" class="task_status" value="<?php echo $od_r['id']; ?>" />
                  <div style="float:left; width:170px;">
                  
                    <?php echo $od_r['task']; ?>

                    <?php                      if($od_r['firstname']!='' && $od_r['lastname']!=''){
                      echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                     } 
                    ?>
                  </div>
                </li>

              <?php } ?>

            </ul>
          <?php endif ?>

          <?php             $tom_q = $db->getResults($tom_sql);

            if(count($tom_q) > 0):
          ?>
              <h4 style="margin-bottom:0px;" class="task_tom_header">Tomorrow</h4>
              <ul class="task_tom_list">

                <?php foreach ($tom_q as $od_r) { ?>

                    <li class="task_item task_<?php echo $od_r['id']; ?>" style="clear:both;">
                      <div class="task_extra" id="task_extra_<?php echo $od_r['id']; ?>" >
                        <a href="#" onclick="delete_task('<?php echo $od_r['id']; ?>')" class="task_delete"></a>
                        <a href="#" onclick="loadPopup('add_task.php?id=<?php echo $od_r['id']; ?>')" class="task_edit">Edit</a>
                      </div>
                      <input type="checkbox" style="float:left;" class="task_status" value="<?php echo $od_r['id']; ?>" />
                      <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                      
                        <?php                          if($od_r['firstname']!='' && $od_r['lastname']!=''){
                          echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                         } 
                        ?>

                      </div>
                    </li>

                <?php } ?>

              </ul>

          <?php endif ?>

          <?php             $tw_q = $db->getResults($tw_sql);

            if(count($tw_q) > 0):
          ?>
              <h4 id="task_tw_header" class="task_tw_header">This Week</h4>

              <ul id="task_tw_list">
                <?php foreach ($tw_q as $od_r) { ?>
                  
                  <li class="task_item task_<?php echo $od_r['id']; ?>" style="clear:both;">
                    <div class="task_extra" id="task_extra_<?php echo $od_r['id']; ?>" >
                      <a href="#" onclick="delete_task('<?php echo $od_r['id']; ?>')" class="task_delete"></a>
                      <a href="#" onclick="loadPopup('add_task.php?id=<?php echo $od_r['id']; ?>')" class="task_edit">Edit</a>
                    </div>
                    <input type="checkbox" class="task_status" style="float:left;" value="<?php echo $od_r['id']; ?>" />
                    <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                   
                      <?php                        if($od_r['firstname']!='' && $od_r['lastname']!=''){
                        echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                        } 
                      ?>

                    </div>
                  </li>

                <?php } ?>      
              </ul>

          <?php endif ?>

          <?php             $nw_q = $db->getResults($nw_sql);

            if(count($nw_q) > 0):
          ?>

            <h4 id="task_nw_header" class="task_nw_header">Next Week</h4>

            <ul id="task_nw_list">
              <?php foreach ($nw_q as $od_r) { ?>

                <li class="task_item task_<?php echo $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>
                  <input type="checkbox" class="task_status" style="float:left;" value="<?php echo $od_r['id']; ?>" />
                  <div style="float:left; width:170px;"><?php echo $od_r['task']; ?>
                    <?php                      if($od_r['firstname']!='' && $od_r['lastname']!=''){
                      echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                      } 
                    ?>
                  </div>
                </li>

              <?php } ?>
            </ul>
          <?php endif ?>

          <?php             $lat_q = $db->getResults($lat_sql);

            if(count($lat_q) > 0):
          ?>

            <h4 id="task_lat_header" class="task_lat_header">Later</h4>

            <ul id="task_lat_list">
              <?php  foreach ($lat_q as $od_r) { ?>
              
                <li class="task_item task_<?php echo $od_r['id']; ?>" style="clear:both;">
                  <div class="task_extra" id="task_extra_<?php echo $od_r['id']; ?>" >
                    <a href="#" onclick="delete_task('<?php echo $od_r['id']; ?>')" class="task_delete"></a>
                    <a href="#" onclick="loadPopup('add_task.php?id=<?php echo $od_r['id']; ?>')" class="task_edit">Edit</a>
                  </div>
                  <input type="checkbox" class="task_status" style="float:left;" value="<?php echo $od_r['id']; ?>" />
                  <div style="float:left; width:170px;">
                    
                    <?php date('M d', strtotime($od_r['due_date'])); ?>
                    -
                    <?php echo $od_r['task']; ?>

                    <?php                      if($od_r['firstname']!='' && $od_r['lastname']!=''){
                      echo ' (<a href="add_patient.php?ed='.$od_r['patientid'].'&preview=1&addtopat=1&pid='.$od_r['patientid'].'">'.$od_r['firstname'].' '. $od_r['lastname'].'</a>)';
                     } 
                    ?>

                  </div>
                </li>
              <?php } ?>
            </ul>

          <?php endif ?>

          <br /><br />

          <a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>

        </div>

        <br /><br />

        <h3>Messages</h3>
        
        <div class="task_menu index_task">
          <ul>

            <?php               $m_sql = "SELECT * FROM memo_admin WHERE off_date <= CURDATE()";
              $m_q = $db->getResults($m_sql);

              foreach ($m_q as $m_r) { ?>

                <li><?php echo $m_r['memo']; ?></li>

            <?php } ?>
          </ul>
        </div>

      </div> 
    </td>
  </tr>
</table>