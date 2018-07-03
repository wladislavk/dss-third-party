<?php
namespace Ds3\Libraries\Legacy;

if ($_GET['backoffice'] == '1') {
    include 'admin/includes/top.htm';
} else {
    include 'includes/top.htm';
}
?>
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/manage/js/edit_letter.js?v=20160404"></script>
<?php
$db = new Db();

$letterid = $db->escape( !empty($_GET['lid']) ? $_GET['lid'] : '');

// Select Letter
$letter_query = "SELECT templateid, patientid, topatient, md_list, md_referral_list FROM dental_letters where letterid = ".$letterid.";";

$letter_result = $db->getResults($letter_query);
if ($letter_result) foreach ($letter_result as $row) {
    $templateid = $row['templateid'];
    $patientid = $row['patientid'];
    $topatient = $row['topatient'];
    $md_list = $row['md_list'];
    $md_referral_list = $row['md_referral_list'];
}

// Get Letter Subject
$template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$templateid.";";

$template_result = $db->getRow($template_query);
$title = $template_result['name'];

// Get Franchisee Name
$franchisee_query = "SELECT name FROM dental_users WHERE userid = '".$_SESSION['docid']."';";

$franchisee_result = $db->getRow($franchisee_query);
$franchisee_name = $franchisee_result['name'];

// Get Patient Information
$patient_query = "SELECT salutation, firstname, middlename, lastname, gender, dob FROM dental_patients WHERE patientid = '".$patientid."';";

$patient_result = $db->getResults($patient_query);
$patient_info = array();
if ($patient_result) foreach ($patient_result as $row) {
    $patient_info = $row;
}
$patient_info['age'] = floor((time() - strtotime($patient_info['dob']))/31556926);

// Get Medical Information
$q3_sql = "SELECT history, medications from dental_q_page3_pivot WHERE patientid = '".$patientid."';";
$q3_myarray = $db->getRow($q3_sql);

$history = $q3_myarray['history'];
$medications = $q3_myarray['medications'];
$history_arr = explode('~',$history);
$history_disp = '';
foreach($history_arr as $val) {
    if(trim($val) != "") {
        $his_sql = "select history from dental_history where historyid='".trim($val)."' and status=1;";
        $his_myarray = $db->getRow($his_sql);

        if($his_myarray['history'] != '') {
            if($history_disp != '') $history_disp .= ' and ';
            $history_disp .= $his_myarray['history'];
        }
    }
}

    $medications_arr = explode('~',$medications);
    $medications_disp = '';
    $medcount = 0;
    foreach ($medications_arr as $val) {
        if ($val != "") {
            $medcount++;
        }
    }

    foreach($medications_arr as $key => $val) {
        if(trim($val) != "") {
            $medications_sql = "select medications from dental_medications where medicationsid='".trim($val)."' and status=1;";
            $medications_myarray = $db->getRow($medications_sql);

            if($medications_myarray['medications'] != '') {
                if($medications_disp != '') {
                    if ($medcount == $key) {
                        $medications_disp .= ', and ';
                    } else {
                        $medications_disp .= ', ';
                    }
                }
                $medications_disp .= $medications_myarray['medications'];
            }
        }
    }

    $q2_sql = "SELECT date, sleeptesttype, ahi, diagnosis FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id DESC LIMIT 1;";
    $q2_myarray = $db->getRow($q2_sql);

    $diagnosis = st($q2_myarray['diagnosis']);
    $ahi = st($q2_myarray['ahi']);
    $type_study = st($q2_myarray['sleeptesttype']) . " sleep test";

    // Appointment Date
    $appt_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";
    $appt_result = $db->getRow($appt_query);

    $appt_date = date('F d, Y', strtotime($appt_result['date_scheduled']));
?>

    <br />
    <span class="admin_head">
        <?php echo $title; ?>
    </span>
    <br />
    &nbsp;&nbsp;
    <a href="<?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>" class="editlink" title="Pending Letters">
        <b>&lt;&lt;Back</b>
    </a>
    <br /><br>

<?php
    if ($topatient) {
      $contact_info = get_contact_info($patientid, $md_list, $md_referral_list);
    } else {
      $contact_info = get_contact_info('', $md_list, $md_referral_list);
    }
    $letter_contacts = array();
    if ($contact_info) {
        if (!empty($contact_info['patient'])) foreach ($contact_info['patient'] as $contact) {
          $letter_contacts[] = array_merge(array('type' => 'patient'), $contact);
        }
        foreach ($contact_info['mds'] as $contact) {
          $letter_contacts[] = array_merge(array('type' => 'md'), $contact);
        }
        if (!empty($contact_info['md_referrals'])) foreach ($contact_info['md_referrals'] as $contact) {
          $letter_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
        }
    }
    $numletters = count($letter_contacts);
    $todays_date = date('F d, Y');

    $template = "<p>%todays_date%</p>
        <p>
        %patient_fullname%<br />
        %addr1%<br />
        %addr2%
        %city%, %state% %zip%<br />
        </p>
    
        <p>Dear %patient_firstname%:</p>
    
        <p>It's hard to believe that it was nearly three years ago that we delivered your dental device.  I hope that you are wearing your device and continuing to reap the benefits of better sleep and better health.  I am writing to you today because most dental devices begin to show significant wear around the three year mark.   Since these devices are considered \"durable medical equipment,\" most insurers will pay to have them remade if necessary, so we'd like to encourage you to set up an appointment so that we can evaluate your device for possible replacement.</p>
    
        <p>Please give us a call here at the office to schedule an appointment.  We look forward to seeing you soon!</p>
    
        <p>Sincerely,
        <br />
        <br />
        <br />
        Dr. %franchisee_fullname%</p>";
?>
    <form action="/manage/dss_to_pt_30month_follow_up.php?pid=<?php echo $patientid?>&lid=<?php echo $letterid?><?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post">
        <input type="hidden" name="numletters" value="<?php echo $numletters?>" />
        <?php
            if ($_POST != []) {
                if (!empty($_POST['duplicate_letter'])) {
                    foreach ($_POST['duplicate_letter'] as $key => $value) {
                        $dupekey = $key;
                    }
                }
                // Check for updated templates
                foreach ($letter_contacts as $key => $contact) {
                    $search = [];
                    $replace = [];
                    $search[] = '%todays_date%';
                    $replace[] = "<strong>" . $todays_date . "</strong>";
                    $search[] = '%md_fullname%';
                    $replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . " " . $letter_contacts[$key]['firstname'] . " " . $letter_contacts[$key]['lastname'] . "</strong>";
                    $search[] = '%md_lastname%';
                    $replace[] = "<strong>" . $letter_contacts[$key]['lastname'] . "</strong>";
                    $search[] = '%addr1%';
                    $replace[] = "<strong>" . $letter_contacts[$key]['add1'] . "</strong>";
                    $search[] = '%addr2%';
                    $replace[] = ($letter_contacts[$key]['add2']) ? "<strong>" . $letter_contacts[$key]['add2'] . "</strong><br />" : "<!--%addr2%-->";
                    $search[] = '%city%';
                    $replace[] = "<strong>" . $letter_contacts[$key]['city'] . "</strong>";
                    $search[] = '%state%';
                    $replace[] = "<strong>" . $letter_contacts[$key]['state'] . "</strong>";
                    $search[] = '%zip%';
                    $replace[] = "<strong>" . $letter_contacts[$key]['zip'] . "</strong>";
                    $search[] = "%franchisee_fullname%";
                    $replace[] = "<strong>" . $franchisee_name . "</strong>";
                    $search[] = "%patient_fullname%";
                    $replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
                    $search[] = "%patient_dob%";
                    $replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
                    $search[] = "%patient_firstname%";
                    $replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
                    $search[] = "%patient_age%";
                    $replace[] = "<strong>" . $patient_info['age'] . "</strong>";
                    $search[] = "%patient_gender%";
                    $replace[] = "<strong>" . $patient_info['gender'] . "</strong>";
                    $search[] = "%His/Her%";
                    $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
                    $search[] = "%he/she%";
                    $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
                    $search[] = "%He/She%";
                    $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
                    $search[] = "%history%";
                    $replace[] = "<strong>" . $history_disp . "</strong>";
                    $search[] = "%medications%";
                    $replace[] = "<strong>" . $medications_disp . "</strong>";
                    $search[] = "%type_study%";
                    $replace[] = "<strong>" . $type_study . "</strong>";
                    $search[] = "%ahi%";
                    $replace[] = "<strong>" . $ahi . "</strong>";
                    $search[] = "%diagnosis%";
                    $replace[] = "<strong>" . $diagnosis . "</strong>";
                    $search[] = "%appt_date%";
                    $replace[] = "<strong>" . $appt_date . "</strong>";
                    $other_mds = "";
                    $count = 1;

                    foreach ($letter_contacts as $index => $md) {
                        if ($key != $index) {
                            $other_mds .= $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
                            if ($count < $numletters - 1) {
                                $other_mds .= ", ";
                            }
                            $count++;
                        }
                    }

                    $replace[] = "<strong>" . $other_mds . "</strong>";
                    $new_template[$key] = str_replace($replace, $search, (!empty($_POST['letter'.$key]) ? $_POST['letter'.$key] : ''));
                    // Letter hasn't been edited, but a new template exists in hidden field
                    if ($new_template[$key] == null && $_POST['new_template'][$key] != null) {
                        $new_template[$key] = $_POST['new_template'][$key];
                    }
                    // Template hasn't changed
                    if ($new_template[$key] == $template) {
                        $new_template[$key] = null;
                    }
                }
                // Duplicate Letter Template
                if (isset($_POST['duplicate_letter']) && empty($duplicated)) {
                    $dupe_template = $new_template[$dupekey];
                    foreach ($letter_contacts as $key => $contact) {
                      $new_template[$key] = $dupe_template;
                    }
                }
                // Reset Letter
                if (isset($_POST['reset_letter'])) {
                    foreach ($_POST['reset_letter'] as $key => $value) {
                        $resetid = $key;
                    }
                    $new_template[$resetid] = null;
                }
            }

            foreach ($letter_contacts as $key => $contact) {
                // Token search and replace arrays
                $search = array();
                $replace = array();
                $search[] = '%todays_date%';
                $replace[] = "<strong>" . $todays_date . "</strong>";
                $search[] = '%md_fullname%';
                $replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
                $search[] = '%md_lastname%';
                $replace[] = "<strong>" . $contact['lastname'] . "</strong>";
                $search[] = '%addr1%';
                $replace[] = "<strong>" . $contact['add1'] . "</strong>";
                $search[] = '%addr2%';
                $replace[] = ($contact['add2']) ? "<strong>" . $contact['add2'] . "</strong><br />" : "<!--%addr2%-->";
                $search[] = '%city%';
                $replace[] = "<strong>" . $contact['city'] . "</strong>";
                $search[] = '%state%';
                $replace[] = "<strong>" . $contact['state'] . "</strong>";
                $search[] = '%zip%';
                $replace[] = "<strong>" . $contact['zip'] . "</strong>";
                $search[] = '%franchisee_fullname%';
                $replace[] = "<strong>" . $franchisee_name . "</strong>";
                $search[] = "%patient_fullname%";
                $replace[] = "<strong>" . $patient_info['salutation'] . " " . $patient_info['firstname'] . " " . $patient_info['lastname'] . "</strong>";
                $search[] = "%patient_dob%";
                $replace[] = "<strong>" . $patient_info['dob'] . "</strong>";
                $search[] = "%patient_firstname%";
                $replace[] = "<strong>" . $patient_info['firstname'] . "</strong>";
                $search[] = "%patient_age%";
                $replace[] = "<strong>" . $patient_info['age'] . "</strong>";
                $search[] = "%patient_gender%";
                $replace[] = "<strong>" . $patient_info['gender'] . "</strong>";
                $search[] = "%His/Her%";
                $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "His" : "Her") . "</strong>";
                $search[] = "%he/she%";
                $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
                $search[] = "%He/She%";
                $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
                $search[] = "%history%";
                $replace[] = "<strong>" . $history_disp . "</strong>";
                $search[] = "%medications%";
                $replace[] = "<strong>" . $medications_disp . "</strong>";
                $search[] = "%type_study%";
                $replace[] = "<strong>" . $type_study . "</strong>";
                $search[] = "%ahi%";
                $replace[] = "<strong>" . $ahi . "</strong>";
                $search[] = "%diagnosis%";
                $replace[] = "<strong>" . $diagnosis . "</strong>";
                $search[] = "%appt_date%";
                $replace[] = "<strong>" . $appt_date . "</strong>";
                $search[] = "%other_mds%";
                $other_mds = "";
                $count = 1;

                foreach ($letter_contacts as $index => $md) {
                    if ($key != $index) {
                        $other_mds .= $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
                        if ($count < $numletters - 1) {
                            $other_mds .= ", ";
                        }
                        $count++;
                    }
                }

                $replace[] = "<strong>" . $other_mds . "</strong>";

                if (!empty($new_template[$key])) {
                    $letter[$key] = str_replace($search, $replace, $new_template[$key]);
                    $new_template[$key] = htmlentities($new_template[$key]);
                } else {
                    $letter[$key] = str_replace($search, $replace, $template);
                }
                // Catch Post Send Submit Button and Send letters Here
                if (!empty($_POST['send_letter'][$key]) && $numletters == $_POST['numletters']) {
                    if (count($letter_contacts) == 1) {
                        $parent = true;
                    }
                    $type = $contact['type'];
                    $recipientid = $contact['id'];
                    if (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1') {
                        $message = $letter[$key];
                        $search= array("<strong>","</strong>");
                        $message = str_replace($search, "", $message);
                        deliver_letter($letterid, $message);
                    } else {
                        send_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
                    }
                    if ($parent) {
                        ?>
                        <script type="text/javascript">
                            window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
                        </script>
                        <?php
                    }
                    continue;
                }
                // Catch Post Delete Button and Delete letters Here
                if (!empty($_POST['delete_letter'][$key]) && $numletters == $_POST['numletters']) {
                    if (count($letter_contacts) == 1) {
                        $parent = true;
                    }
                    $type = $contact['type'];
                    $recipientid = $contact['id'];
                    $letterid = delete_letter($letterid, $type, $recipientid, $new_template[$key]);
                    if ($parent) {
                        ?>
                        <script type="text/javascript">
                            window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
                        </script>
                        <?php
                    }
                    continue;
                }
?>
                <div align="right">
                    <button class="addButton" onclick="edit_letter('letter<?php echo $key?>');return false;" >
                        Edit Letter
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="duplicate_letter[<?php echo $key?>]" class="addButton" value="Duplicate" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="addButton" onclick="window.open('dss_intro_to_md_from_dss_print.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','Print_letter','width=800,height=500,scrollbars=1');" >
                        Print Letter
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="addButton" onclick="window.open('dss_intro_to_md_from_dss_word.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','word_letter','width=800,height=500,scrollbars=1');" >
                        Word Document
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="send_letter[<?php echo $key?>]" class="addButton" value="Send Letter" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
                    <tr>
                        <td valign="top">
                            <div id="letter<?php echo $key?>">
                            <?php print $letter[$key]; ?>
                            </div>
                            <input type="hidden" name="new_template[<?php echo $key?>]" value="<?php echo (!empty($new_template[$key]) ? $new_template[$key] : '')?>" />
                        </td>
                    </tr>
                </table>
                <div align="right">
                    <input type="submit" name="reset_letter[<?php echo $key?>]" class="addButton" value="Reset" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="delete_letter[<?php echo $key?>]" class="addButton" value="Delete" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <hr width="90%" />
<?php
            }
?>
            <br><br>
            </form>
        </td>
    </tr>
</table>

<?php
if(!empty($_GET['backoffice']) && $_GET['backoffice'] == '1') {
    include 'admin/includes/bottom.htm';
} else {
    include 'includes/bottom.htm';
}
?>
