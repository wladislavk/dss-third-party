<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/includes/dual_app.php';
dualAppRedirect('main/index');

include 'includes/top.htm';

$docId = (int)$_SESSION['docid'];
$apiToken = apiToken();

$db = new Db();

$sql = "SELECT manage_staff, use_course, use_eligible_api from dental_users WHERE userid='" . $db->escape($_SESSION['docid']) . "'";
$r = $db->getRow($sql);

$manageStaffSql = "SELECT manage_staff from dental_users WHERE userid='" . $db->escape( $_SESSION['userid']) . "'";
$manageStaff = $db->getRow($manageStaffSql);
?>

<table>
    <tr>
        <td valign="top" style="border-right:1px solid #00457c;width:980px;">
            <link rel="stylesheet" type="text/css" href="css/index.css">
            <div class="home_third first">
                <h3>Navigation</h3>
                <div class="homesuckertreemenu">
                    <ul id="homemenu">
                        <li>
                            <a href="#">Directory</a>
                            <ul>
                                <li><a href="manage_contact.php">Contacts</a></li>
                                <li><a href="manage_referredby.php">Referral List</a></li>
                                <li><a href="manage_sleeplab.php">Sleep Labs</a></li>
                                <li><a href="manage_fcontact.php">Corporate Contacts</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Reports</a>
                            <ul>
                                <li><a href="ledger_reportfull.php">Ledger</a></li>
                                <li><a href="manage_claims.php">Claims (<?= $num_pending_claims; ?>)</a></li>
                                <li><a href="performance.php">Performance</a></li>
                                <li><a href="manage_screeners.php?contacted=0">Pt. Screener</a></li>
                                <li><a href='manage_vobs.php'>VOB History</a></li>
                                <?php
                                if ($_SESSION['docid'] == $_SESSION['userid'] || $r['manage_staff'] == 1): ?>
                                    <li><a href="invoice_history.php">Invoices</a></li>
                                    <?php
                                endif ?>
                                <li><a href="manage_faxes.php">Fax History</a></li>
                                <li><a href="manage_hst.php">Home Sleep Tests</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="menu_item" href="#">Admin</a>
                            <ul>
                                <li><a href="manage_claim_setup.php">Claim Setup</a></li>
                                <li><a href="manage_profile.php">Profile</a></li>
                                <li><a href="#">Text</a>
                                    <ul id="soap-permissions-index-menu" class="soap-permissions"
                                        v-bind:doc-id="<?= $docId ?>" v-bind:patient-id="0">
                                        <li v-cloak v-for="group in groups"
                                            v-if="group.slug == 'soap-notes' && userPermissions[group.id].enabled">
                                            <a href="manage_custom.php?soap=1">Custom SOAP Note</a>
                                        </li>
                                        <li><a href="manage_custom.php">Custom Text</a></li>
                                        <li><a href="manage_custom_letters.php">Custom Letters</a></li>
                                    </ul>
                                </li>
                                <li><a href="change_list.php">Change List</a></li>
                                <?php
                                if ($_SESSION['userid'] == $_SESSION['docid'] || $manageStaff['manage_staff'] == 1): ?>
                                    <li><a class="submenu_item" href="manage_transaction_code.php">Transaction Code</a></li>
                                    <?php
                                endif ?>
                                <li><a href="manage_staff.php">Staff</a></li>
                                <li><a href="#">Scheduler</a>
                                    <ul>
                                        <li><a href="manage_chairs.php">Resources</a></li>
                                        <li><a href="manage_appts.php">Appointment Types</a></li>
                                    </ul>
                                </li>
                                <li><a href="export_md.php" onclick="return (prompt('Enter password') == '1234');">Export MD</a></li>
                                <li><a href="#">DSS Files</a>
                                    <ul>
                                        <?php
                                        $s = "SELECT * FROM dental_document_category WHERE status=1 ORDER BY name ASC";
                                        $sq = $db->getResults($s);
                                        foreach ($sq as $dss_file) { ?>
                                            <li><a class="submenu_item" href="view_documents.php?cat=<?= $dss_file['categoryid']; ?>"><?= $dss_file['name']; ?></a></li>
                                            <?php
                                        } ?>
                                    </ul>
                                </li>
                                <li><a href="manage_locations.php">Manage Locations</a></li>
                                <li><a href="data_import.php" onclick="return confirm('Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.');">Data Import</a></li>
                                <?php
                                if ($r['use_eligible_api'] == 1): ?>
                                    <li><a href="manage_enrollment.php">Enrollments</a></li>
                                    <?php
                                endif ?>
                            </ul>
                        </li>
                        <li><a href="/screener/auto_login.php">Pt. Screener App</a></li>
                        <li><a href="manage_user_forms.php">Forms</a></li>
                        <li><a href="#">Education</a>
                            <ul>
                                <li><a href="manual.php">Dental Sleep Solutions Procedures Manual</a></li>
                                <li><a href="medicine_manual.php">Dental Sleep Medicine Manual</a></li>
                                <?php
                                if ($_SESSION['user_type'] == DSS_USER_TYPE_FRANCHISEE): ?>
                                    <li><a href="operations_manual.php">DSS Franchise Operations Manual</a></li>
                                    <?php
                                endif ?>
                                <li><a href="quick_facts.php">Quick Facts Reference</a></li>
                                <li><a href="videos.php">Watch Videos</a></li>
                                <?php
                                if ($_SESSION['docid'] == $_SESSION['userid']):
                                    if ($r['use_course'] == 1): ?>
                                        <li><a href="edx_login.php" target="_blank">Get C.E.</a></li>
                                        <?php
                                    endif;
                                else:
                                    $course_sql = "
                                        SELECT s.use_course, d.use_course_staff FROM dental_users s
                                        JOIN dental_users d ON d.userid = s.docid
                                        WHERE s.userid='" . $db->escape($_SESSION['userid']). "'
                                    ";
                                    $course_r = $db->getRow($course_sql);
                                    if ($course_r['use_course'] == 1 && $course_r['use_course_staff'] == 1): ?>
                                        <li><a href="edx_login.php" target="_blank">Get C.E.</a></li>
                                        <?php
                                    endif;
                                endif; ?>
                                <li><a href="edx_certificate.php">Certificates</a></li>
                            </ul>
                        </li>
                        <li><a href="sw_tutorials.php">SW Tutorials</a></li>
                        <li><a href="calendar.php">Scheduler</a></li>
                        <li><a href="manage_patient.php">Manage Pts</a></li>
                        <li><a href="#" onclick="loadPopup('includes/device_guide.php'); return false;">Device Selector</a></li>
                    </ul>
                </div>
            </div>
            <div class="home_third">
                <h3>Notifications</h3>
                <?php
                $num_portal = $num_pc + $num_pi + $num_c; ?>
                <div class="notsuckertreemenu">
                    <ul id="notmenu">
                        <li>
                            <a href="#" class=" count_<?= $num_portal; ?> notification bad_count"><?= $num_portal; ?> Web Portal <div class="arrow_right"></div></a>
                            <ul>
                                <li>
                                    <a href="manage_patient_contacts.php" class=" count_<?= $num_pc; ?> notification bad_count">
                                        <span class="count"><?= $num_pc; ?></span>
                                        <span class="label">Pt Contacts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="manage_patient_insurance.php" class=" count_<?= $num_pi; ?> notification bad_count">
                                        <span class="count"><?= $num_pi; ?></span>
                                        <span class="label">Pt Insurance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="manage_patient_changes.php" class=" count_<?= $num_c; ?> notification bad_count">
                                        <span class="count"><?= $num_c; ?></span>
                                        <span class="label">Pt Changes</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php
                if ($use_letters): ?>
                    <a href="letters.php?status=pending" class=" count_<?= $pending_letters; ?> notification <?= ($pending_letters == 0) ? "good_count" : "bad_count"; ?>">
                        <span class="count"><?= $pending_letters; ?></span>
                        <span class="label">Letters</span>
                    </a>
                    <?php
                endif;
                if ($use_letters && $_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE): ?>
                    <a href="letters.php?status=sent&mailed=0" class=" count_<?= $unmailed_letters; ?> notification bad_count">
                        <span class="count"><?= $unmailed_letters;?></span>
                        <span class="label">Unmailed Letters</span>
                    </a>
                    <?php
                endif ?>
                <a href="manage_vobs.php?status=<?= DSS_PREAUTH_COMPLETE; ?>&viewed=0" class=" count_<?= $num_preauth; ?> notification <?= ($num_preauth == 0) ? "good_count" : "great_count"; ?>">
                    <span class="count"><?= $num_preauth; ?></span>
                    <span class="label">VOBs</span>
                </a>
                <?php
                if ($numRejectedPreAuth) { ?>
                    <a href="manage_vobs.php?status=<?= DSS_PREAUTH_REJECTED ?>&viewed=0" class=" count_<?= $numRejectedPreAuth ?> notification bad_count">
                        <span class="count"><?= $numRejectedPreAuth ?></span>
                        <span class="label">Rejected VOBs</span>
                    </a>
                    <?php
                } ?>
                <a href="manage_hst.php?status=<?= DSS_HST_COMPLETE; ?>&viewed=0" class=" count_<?= $num_hst; ?> notification <?= ($num_hst == 0) ? "good_count" : "great_count"; ?>">
                    <span class="count"><?= $num_hst; ?></span>
                    <span class="label">HSTs</span>
                </a>
                <a href="manage_hst.php?status=<?= DSS_HST_REJECTED; ?>&viewed=0" class=" count_<?= $num_rejected_hst; ?> notification <?= ($num_rejected_hst == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_rejected_hst; ?></span>
                    <span class="label">Rejected HSTs</span>
                </a>
                <a href="manage_hst.php?status=<?= DSS_HST_REQUESTED; ?>&viewed=0" class=" count_<?= $num_requested_hst; ?> notification <?= ($num_requested_hst == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_requested_hst; ?></span>
                    <span class="label">Unsent HSTs</span>
                </a>
                <a href="manage_claims.php" class="notification  count_<?= $num_pending_nodss_claims; ?> <?= ($num_pending_nodss_claims == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_pending_nodss_claims; ?></span>
                    <span class="label">Pending Claims</span>
                </a>
                <?php
                if ($_SESSION['user_type'] == DSS_USER_TYPE_SOFTWARE): ?>
                    <a href="manage_claims.php?unmailed=1" class=" count_<?= $num_unmailed_claims; ?> notification <?= ($num_unmailed_claims == 0) ? "good_count" : "bad_count"; ?>">
                        <span class="count"><?= $num_unmailed_claims; ?></span>
                        <span class="label">Unmailed Claims</span>
                    </a>
                    <?php
                endif ?>
                <a href="manage_rejected_claims.php" class=" count_<?= $num_rejected_claims; ?> notification <?= ($num_rejected_claims == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_rejected_claims; ?></span>
                    <span class="label">Rejected Claims</span>
                </a>
                <a href="manage_unsigned_notes.php" class=" count_<?= $num_unsigned; ?> notification <?= ($num_unsigned == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_unsigned; ?></span>
                    <span class="label">Unsigned Notes</span>
                </a>
                <?php
                $num_alerts = $num_rejected_preauth; ?>
                <a href="manage_vobs.php?status=<?= DSS_PREAUTH_REJECTED; ?>&viewed=0" class=" count_<?= $num_alerts; ?> notification bad_count">
                    <span class="count"><?= $num_alerts; ?></span>
                    <span class="label">Alerts</span>
                </a>
                <a href="manage_faxes.php" class="notification  count_<?= $num_fax_alerts; ?> <?= ($num_fax_alerts == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_fax_alerts; ?></span>
                    <span class="label">Failed Faxes</span>
                </a>
                <a href="pending_patient.php" class="notification  count_<?= $num_pending_duplicates; ?> <?= ($num_pending_duplicates == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_pending_duplicates; ?></span>
                    <span class="label">Pending Duplicates</span>
                </a>
                <a href="manage_email_bounces.php" class="notification count_<?= $num_bounce; ?> <?= ($num_bounce == 0) ? "good_count" : "bad_count"; ?>">
                    <span class="count"><?= $num_bounce; ?></span>
                    <span class="label">Email Bounces</span>
                </a>
                <?php
                if ($use_payment_reports): ?>
                    <a href="payment_reports_list.php?unviewed=1" class="notification count_<?= $num_payment_reports; ?> <?= ($num_payment_reports == 0) ? "good_count" : "bad_count"; ?>">
                        <span class="count"><?= $num_payment_reports; ?></span>
                        <span class="label">Payment Reports</span>
                    </a>
                    <?php
                endif; ?>
                <a href="#" onclick="$('.notification.count_0').css('display', 'block');$(this).hide();$('#not_show_active').show();return false;" id="not_show_all">Show All</a>
                <a href="#" onclick="$('.notification.count_0').hide();$(this).hide();$('#not_show_all').show();return false;" style="display:none;" id="not_show_active">Show Active</a>
            </div>
            <div class="home_third">
                <h3>Tasks</h3>
                <div class="task_menu index_task">
                    <h4>My Tasks</h4>
                    <?php
                    $od_q = $db->getResults($od_sql);
                    if (count($od_q) > 0): ?>
                        <h4 style="margin-bottom:0;color:red;" class="task_od_header">Overdue</h4>
                        <ul class="task_od_list">
                            <?php
                            foreach ($od_q as $od_r) { ?>
                                <li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
                                    <div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
                                        <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
                                        <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
                                    </div>
                                    <input type="checkbox" style="float:left; " class="task_status" value="<?= $od_r['id']; ?>" />
                                    <div style="float:left; width:170px;"><?= $od_r['task']; ?>
                                        <?php
                                        if ($od_r['firstname'] != '' && $od_r['lastname'] != '') { ?>
                                            (<a href="add_patient.php?ed=<?= $od_r['patientid'] ?>&addtopat=1&pid=<?= $od_r['patientid'] ?>"><?= $od_r['firstname'] ?> <?= $od_r['lastname'] ?></a>)
                                            <?php
                                        } ?>
                                    </div>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    endif;
                    $tod_q = $db->getResults($tod_sql);
                    if (count($tod_q) > 0): ?>
                        <h4 style="margin-bottom:0;" class="task_tod_header">Today</h4>
                        <ul class="task_tod_list">
                            <?php
                            foreach ($tod_q as $od_r) { ?>
                                <li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
                                    <div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
                                        <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
                                        <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
                                    </div>
                                    <input type="checkbox" style="float:left;" class="task_status" value="<?= $od_r['id']; ?>" />
                                    <div style="float:left; width:170px;">
                                        <?= $od_r['task']; ?>
                                        <?php
                                        if ($od_r['firstname'] != '' && $od_r['lastname'] != '') { ?>
                                            (<a href="add_patient.php?ed=<?= $od_r['patientid'] ?>&addtopat=1&pid=<?= $od_r['patientid'] ?>"><?= $od_r['firstname'] ?> <?= $od_r['lastname'] ?></a>)
                                            <?php
                                        } ?>
                                    </div>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    endif;
                    $tom_q = $db->getResults($tom_sql);
                    if (count($tom_q) > 0): ?>
                        <h4 style="margin-bottom:0;" class="task_tom_header">Tomorrow</h4>
                        <ul class="task_tom_list">
                            <?php
                            foreach ($tom_q as $od_r) { ?>
                                <li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
                                    <div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
                                        <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
                                        <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
                                    </div>
                                    <input type="checkbox" style="float:left;" class="task_status" value="<?= $od_r['id']; ?>" />
                                    <div style="float:left; width:170px;">
                                        <?= $od_r['task']; ?>
                                        <?php
                                        if ($od_r['firstname'] != '' && $od_r['lastname'] != '') { ?>
                                            (<a href="add_patient.php?ed=<?= $od_r['patientid'] ?>&addtopat=1&pid=<?= $od_r['patientid'] ?>"><?= $od_r['firstname'] ?> <?= $od_r['lastname'] ?></a>)
                                            <?php
                                        } ?>
                                    </div>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    endif;
                    $tw_q = $db->getResults($tw_sql);
                    if (count($tw_q) > 0): ?>
                        <h4 id="task_tw_header" class="task_tw_header">This Week</h4>
                        <ul id="task_tw_list">
                            <?php
                            foreach ($tw_q as $od_r) { ?>
                                <li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
                                    <div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
                                        <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
                                        <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
                                    </div>
                                    <input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
                                    <div style="float:left; width:170px;">
                                        <?= $od_r['task']; ?>
                                        <?php
                                        if ($od_r['firstname'] != '' && $od_r['lastname'] != '') { ?>
                                            (<a href="add_patient.php?ed=<?= $od_r['patientid'] ?>&addtopat=1&pid=<?= $od_r['patientid'] ?>"><?= $od_r['firstname'] ?> <?= $od_r['lastname'] ?></a>)
                                            <?php
                                        } ?>
                                    </div>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    endif;
                    $nw_q = $db->getResults($nw_sql);
                    if (count($nw_q) > 0): ?>
                        <h4 id="task_nw_header" class="task_nw_header">Next Week</h4>
                        <ul id="task_nw_list">
                            <?php
                            foreach ($nw_q as $od_r) { ?>
                                <li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
                                    <div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
                                        <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
                                        <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
                                    </div>
                                    <input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
                                    <div style="float:left; width:170px;">
                                        <?= $od_r['task']; ?>
                                        <?php
                                        if ($od_r['firstname'] != '' && $od_r['lastname'] != '') { ?>
                                            (<a href="add_patient.php?ed=<?= $od_r['patientid'] ?>&addtopat=1&pid=<?= $od_r['patientid'] ?>"><?= $od_r['firstname'] ?> <?= $od_r['lastname'] ?></a>)
                                            <?php
                                        } ?>
                                    </div>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    endif;
                    $lat_q = $db->getResults($lat_sql);
                    if (count($lat_q) > 0): ?>
                        <h4 id="task_lat_header" class="task_lat_header">Later</h4>
                        <ul id="task_lat_list">
                            <?php
                            foreach ($lat_q as $od_r) { ?>
                                <li class="task_item task_<?= $od_r['id']; ?>" style="clear:both;">
                                    <div class="task_extra" id="task_extra_<?= $od_r['id']; ?>" >
                                        <a href="#" onclick="delete_task('<?= $od_r['id']; ?>')" class="task_delete"></a>
                                        <a href="#" onclick="loadPopup('add_task.php?id=<?= $od_r['id']; ?>')" class="task_edit">Edit</a>
                                    </div>
                                    <input type="checkbox" class="task_status" style="float:left;" value="<?= $od_r['id']; ?>" />
                                    <div style="float:left; width:170px;">
                                        <?= date('M d', strtotime($od_r['due_date'])); ?>
                                        -
                                        <?= $od_r['task']; ?>
                                        <?php
                                        if ($od_r['firstname'] != '' && $od_r['lastname'] != '') { ?>
                                            (<a href="add_patient.php?ed=<?= $od_r['patientid'] ?>&addtopat=1&pid=<?= $od_r['patientid'] ?>"><?= $od_r['firstname'] ?> <?= $od_r['lastname'] ?></a>)
                                            <?php
                                        } ?>
                                    </div>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    endif ?>
                    <br /><br />
                    <a href="manage_tasks.php" class="button" style="padding:2px 10px;">View All</a>
                </div>
                <br /><br />
                <h3>Messages</h3>
                <div class="task_menu index_task">
                    <ul>
                        <?php
                        $m_sql = "SELECT * FROM memo_admin WHERE off_date <= CURDATE()";
                        $m_q = $db->getResults($m_sql);
                        foreach ($m_q as $m_r) { ?>
                            <li><?= $m_r['memo']; ?></li>
                            <?php
                        } ?>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
</table>

<br /><br />

<script type="text/javascript" src="3rdParty/suckertree/sucker_tree_home.js"></script>

<?php require_once __DIR__ . '/includes/vue-setup.htm'; ?>
<script>
    Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;
</script>
<script src="/assets/app/soap-permissions.js?v=20180502" type="text/javascript"></script>
<script src="/assets/app/vue-cleanup.js" type="text/javascript"></script>
<?php  include 'includes/bottom.htm';?>
