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
if ($letter_result) {
    foreach ($letter_result as $row) {
        $templateid = $row['templateid'];
        $patientid = $row['patientid'];
        $topatient = $row['topatient'];
        $md_list = $row['md_list'];
        $md_referral_list = $row['md_referral_list'];
    }
}

// Pending and Sent Contacts
$othermd_query = "SELECT md_list, md_referral_list FROM dental_letters where letterid = '".$letterid."' OR parentid = '".$letterid."' ORDER BY letterid ASC;";

$othermd_result = $db->getResults($othermd_query);
$md_array = [];
$md_referral_array = [];
if ($othermd_result) {
    foreach ($othermd_result as $row) {
        if ($row['md_list'] != null) {
            $md_array = array_merge($md_array, explode(",", $row['md_list']));
        }
        if ($row['md_referral_list'] != null) {
            $md_referral_array = array_merge($md_referral_array, explode(",", $row['md_referral_list']));
        }
    }
}

$full_md_list = implode(",", $md_array);
$full_md_referral_list = implode(",", $md_referral_array);
$contacts = get_contact_info('', $full_md_list, $full_md_referral_list);
if ($contacts) {
    foreach ($contacts['mds'] as $contact) {
      $md_contacts[] = array_merge(['type' => 'md'], $contact);
    }
    if (!empty($contacts['md_referrals'])) {
        foreach ($contacts['md_referrals'] as $contact) {
            $md_contacts[] = array_merge(['type' => 'md_referral'], $contact);
        }
    }
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

$patient_info = [];
if ($patient_result) {
    foreach ($patient_result as $row) {
        $patient_info = $row;
    }
}
$patient_info['age'] = floor((time() - strtotime($patient_info['dob'])) / 31556926);

// Get Medical Information
$q3_sql = "SELECT history, medications from dental_q_page3_pivot WHERE patientid = '".$patientid."';";
$q3_myarray = $db->getRow($q3_sql);

$history = $q3_myarray['history'];
$medications = $q3_myarray['medications'];
$history_arr = explode('~',$history);
$history_disp = '';
foreach ($history_arr as $val) {
    if (trim($val) != "") {
        $his_sql = "select history from dental_history where historyid='".trim($val)."' and status=1;";

        $his_myarray = $db->getRow($his_sql);
        if ($his_myarray['history'] != '') {
            if ($history_disp != '') {
                $history_disp .= ' and ';
            }
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

foreach ($medications_arr as $key => $val) {
    if (trim($val) != "") {
        $medications_sql = "select medications from dental_medications where medicationsid='".trim($val)."' and status=1;";

        $medications_myarray = $db->getRow($medications_sql);
        if ($medications_myarray['medications'] != '') {
            if ($medications_disp != '') {
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

$q1_sql = "SELECT date, sleeptesttype, ahi, rdi, t9002, o2nadir, diagnosis, place, dentaldevice FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id ASC LIMIT 1;";

$q1_myarray = $db->getRow($q1_sql);
$first_study_date = st($q1_myarray['date']);
$first_ahi = st($q1_myarray['ahi']);
$first_rdi = st($q1_myarray['rdi']);
$first_o2sat90 = st($q1_myarray['t9002']);
$first_o2nadir = st($q1_myarray['o2nadir']);
$q2_sql = "SELECT date, sleeptesttype, ahi, ahisupine, rdi, t9002, o2nadir, diagnosis, place, dentaldevice FROM dental_summ_sleeplab WHERE patiendid='".$patientid."' ORDER BY id DESC LIMIT 1;";

$q2_myarray = $db->getRow($q2_sql);
$second_study_date = st($q2_myarray['date']);
$second_diagnosis = st($q2_myarray['diagnosis']);
$second_ahi = st($q2_myarray['ahi']);
$second_ahisupine = st($q2_myarray['ahisupine']);
$second_rdi = st($q2_myarray['rdi']);
$second_o2sat90 = st($q2_myarray['t9002']);
$second_o2nadir = st($q2_myarray['o2nadir']);
$second_type_study = st($q2_myarray['sleeptesttype']) . " sleep test";
$sleep_center_name = st($q2_myarray['place']);
$dentaldevice = st($q2_myarray['dentaldevice']);

$sleeplab_sql = "select company from dental_sleeplab where status=1 and sleeplabid='".$sleep_center_name."';";
$sleeplab_myarray = $db->getRow($sleeplab_sql);

$sleeplab_name = st($sleeplab_myarray['company']);

$subj1_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid ASC LIMIT 1;";
$subj1_result = $db->getResults($subj1_query);

if ($subj1_result) {
    foreach ($subj1_result as $row) {
        $subj1 = $row;
    }
}

$subj2_query = "SELECT ep_eadd, ep_sadd, ep_eladd, sleep_qualadd FROM dentalsummfu WHERE patientid = '".$patientid."' ORDER BY followupid DESC LIMIT 1;";

$subj2_result = $db->getResults($subj2_query);
foreach ($subj2_result as $row) {
    $subj2 = $row;
}

// Device Delivery Date
$device_query = "SELECT date_completed FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 7 ORDER BY stepid DESC LIMIT 1;";

$device_result = $db->getRow($device_query);
$delivery_date = date('F d, Y', strtotime($device_result['date_completed']));

// Appointment Date
$appt_query = "SELECT date_scheduled FROM dental_flow_pg2_info WHERE patientid = '".$patientid."' AND segmentid = 4 ORDER BY stepid DESC LIMIT 1;";

$appt_result = $db->getRow($appt_query);
$appt_date = date('F d, Y', strtotime($appt_result['date_scheduled']));

function trigger_letter20($pid)
{
    $letterid = '20';
    $topatient = '1';
    $letter = create_letter($letterid, $pid, '', $topatient);
    if (!is_numeric($letter)) {
        print $letter;
        trigger_error("Die called", E_USER_ERROR);
    } else {
        return $letter;
    }
    return null;
}

// Select BMI
$bmi_query = "SELECT bmi FROM dental_q_page1_pivot WHERE patientid = '".$patientid."';";

$bmi_result = $db->getRow($bmi_query);
$bmi = $bmi_result['bmi'];

// Reason seeking treatment
$reason_query = "SELECT reason_seeking_tx FROM dental_summary_pivot WHERE patientid = '".$patientid."';";

$reason_result = $db->getRow($reason_query);
$reason_seeking_tx = $reason_result['reason_seeking_tx'];

// Symptoms
$sql = "SELECT complaintid FROM dental_q_page1_pivot WHERE patientid = '".$patientid."' LIMIT 1;";

$result = $db->getResults($sql);
if ($result) {
    foreach ($result as $row) {
        $complaint = explode("~", rtrim($row['complaintid'], "~"));
    }
}

if ($complaint) {
    foreach ($complaint as $pair) {
        $idscore = explode("|", $pair);
        $compid[] = $idscore[0];
    }
    foreach ($compid as $id) {
        $sql = "SELECT complaint FROM dental_complaint WHERE complaintid = '".$id."';";

        $result = $db->getResults($sql);
        if ($result) {
            foreach ($result as $row) {
                $symptoms[] = $row['complaint'];
            }
        }
    }
}

if (!isset($symptom_list)) {
    $symptom_list = "";
}

foreach ($symptoms as $key => $value) {
    if ($key != count($symptoms) - 1 && $key != count($symptoms) - 2) {
        $symptom_list .= $value . ", ";
    } elseif ($key == count($symptoms) - 2) {
        $symptom_list .= $value . " and ";
    } else {
        $symptom_list .= $value;
    }
} ?>

<br />
<span class="admin_head">
    <?php echo $title; ?>
</span>
<br />
&nbsp;&nbsp;
<a href="<?php echo (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>" class="editlink" title="Pending Letters">
    <b>&lt;&lt;Back</b></a>
<br /><br>

<?php
if ($topatient) {
    $contact_info = get_contact_info($patientid, $md_list, $md_referral_list);
} else {
    $contact_info = get_contact_info('', $md_list, $md_referral_list);
}
$letter_contacts = [];
if ($contact_info) {
    foreach ($contact_info['patient'] as $contact) {
        $letter_contacts[] = array_merge(['type' => 'patient'], $contact);
    }
    foreach ($contact_info['mds'] as $contact) {
        $letter_contacts[] = array_merge(['type' => 'md'], $contact);
    }
    foreach ($contact_info['md_referrals'] as $contact) {
        $letter_contacts[] = array_merge(['type' => 'md_referral'], $contact);
    }
}

$numletters = count($letter_contacts);
$todays_date = date('F d, Y');

$template = "<p>%todays_date%</p>
    <table>
        <tr>
            <td width=\"50px\">Re:</td>
            <td>%patient_fullname%</td>
        </tr>
        <tr>
            <td width=\"50px\">DOB:</td>
            <td>%patient_dob%</td>
        </tr>
    </table>

    <p>%patient_fullname% is a %patient_age% year old %patient_gender% with a past medical history that includes:   Medications: %medications%</p>

    <p><b>HPI</b>:  Patient underwent a %2ndtype_study% on %2ndstudy_date% due to %reason_seeking_tx%.  Patient has a BMI of %bmi% and had symptoms of %symptoms%.  %He/She% was diagnosed with %2nddiagnosis%.</p>

    <p><b>SUBJECTIVE</b>:  %patient_firstname% presents with subjective complaint(s) of %reason_seeking_tx%.</p>

    <p><b>OBJECTIVE</b>:  %patient_firstname% underwent a %2ndtype_study% on %2ndstudy_date%.  %He/She% was diagnosed with %2nddiagnosis%.  %He/She% had an AHI of %2ndahi%.  On %his/her% back, %his/her% AHI was %2ndahisupine%; during REM sleep %his/her% AHI was [REM AHI from summary sheet].  %He/She% had a low O2 level of %2ndLowO2%;  and %he/she% spent %2ndO2Sat90%% of the night below 90% O2.</p>

    <p><b>ASSESSMENT</b>:  %patient_firstname% was diagnosed with %2nddiagnosis%.  %He/She% is a good candidate for dental device therapy.</p>

    <p><b>PLAN</b>:  Discussed risks, benefits,  and alternatives of treatment options. Recommend [Patient's Treatment Plan]</p>

    <p>Sincerely,
        <br />
        <br />
        <br />
        Dr. %franchisee_fullname%<br />"; ?>

<form action="/manage/dss_to_md_pt_soap.php?pid=<?php echo $patientid?>&lid=<?php echo $letterid?><?php echo (!empty($_GET['backoffice']) && $_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
    <input type="hidden" name="numletters" value="<?php echo $numletters?>" />
    <?php
    if ($_POST != []) {
        foreach ($_POST['duplicate_letter'] as $key => $value) {
            $dupekey = $key;
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
            $search[] = "%salutation%";
            $replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
            $search[] = '%practice%';
            $replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";
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
            $search[] = "%his/her%";
            $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
            $search[] = "%he/she%";
            $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
            $search[] = "%He/She%";
            $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
            $search[] = "%history%";
            $replace[] = "<strong>" . $history_disp . "</strong>";
            $search[] = "%medications%";
            $replace[] = "<strong>" . $medications_disp . "</strong>";
            $search[] = "%sleeplab_name%";
            $replace[] = "<strong>" . $sleeplab_name . "</strong>";
            $search[] = "%1ststudy_date%";
            $replace[] = "<strong>" . $first_study_date . "</strong>";
            $search[] = "%1stRDI/AHI%";
            $replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
            $search[] = "%1stLowO2%";
            $replace[] = "<strong>" . $first_o2nadir . "</strong>";
            $search[] = "%1stTO290%";
            $replace[] = "<strong>" . $first_o2sat90 . "</strong>";
            $search[] = "%2ndtype_study%";
            $replace[] = "<strong>" . $second_type_study . "</strong>";
            $search[] = "%2ndahi%";
            $replace[] = "<strong>" . $second_ahi . "</strong>";
            $search[] = "%2ndahisupine%";
            $replace[] = "<strong>" . $second_ahisupine . "</strong>";
            $search[] = "%2ndrdi%";
            $replace[] = "<strong>" . $second_rdi . "</strong>";
            $search[] = "%2ndO2Sat90%";
            $replace[] = "<strong>" . $second_o2sat90 . "</strong>";
            $search[] = "%2ndstudy_date%";
            $replace[] = "<strong>" . $second_study_date . "</strong>";
            $search[] = "%2ndRDI/AHI%";
            $replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
            $search[] = "%2ndLowO2%";
            $replace[] = "<strong>" . $second_o2nadir . "</strong>";
            $search[] = "%2ndTO290%";
            $replace[] = "<strong>" . $second_o2sat90 . "</strong>";
            $search[] = "%2nddiagnosis%";
            $replace[] = "<strong>" . $second_diagnosis . "</strong>";
            $search[] = "%appt_date%";
            $replace[] = "<strong>" . $appt_date . "</strong>";
            $search[] = "%delivery_date%";
            $replace[] = "<strong>" . $delivery_date . "</strong>";
            $search[] = "%dental_device%";
            $replace[] = "<strong>" . $dentaldevice . "</strong>";
            $search[] = "%1stESS%";
            $replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
            $search[] = "%1stSnoring%";
            $replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
            $search[] = "%1stEnergy%";
            $replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
            $search[] = "%1stQuality%";
            $replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
            $search[] = "%2ndESS%";
            $replace[] = "<strong>" . $subj2['ep_eadd'] . "</strong>";
            $search[] = "%2ndSnoring%";
            $replace[] = "<strong>" . $subj2['ep_sadd'] . "</strong>";
            $search[] = "%2ndEnergy%";
            $replace[] = "<strong>" . $subj2['ep_eladd'] . "</strong>";
            $search[] = "%2ndQuality%";
            $replace[] = "<strong>" . $subj2['sleep_qualadd'] . "</strong>";
            $search[] = "%bmi%";
            $replace[] = "<strong>" . $bmi . "</strong>";
            $search[] = "%reason_seeking_tx%";
            $replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
            $search[] = "%symptoms%";
            $replace[] = "<strong>" . $symptom_list . "</strong>";
            $search[] = "%other_mds%";
            $other_mds = "";
            $count = 1;

            foreach ($md_contacts as $index => $md) {
                $md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
                if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
                    $other_mds .= $md_fullname;
                    if ($count < count($md_contacts)) {
                        $other_mds .= ", ";
                    }
                    $count++;
                }
            }

            $other_mds = rtrim($other_mds, ", ");
            $replace[] = "<strong>" . $other_mds . "</strong>";
            $new_template[$key] = str_replace($replace, $search, $_POST['letter'.$key]);
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
        if (isset($_POST['duplicate_letter']) && !$duplicated) {
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
        $search[] = "%salutation%";
        $replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
        $search[] = '%practice%';
        $replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";
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
        $search[] = "%his/her%";
        $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "his" : "her") . "</strong>";
        $search[] = "%he/she%";
        $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "he" : "she") . "</strong>";
        $search[] = "%He/She%";
        $replace[] = "<strong>" . ($patient_info['gender'] == "Male" ? "He" : "She") . "</strong>";
        $search[] = "%history%";
        $replace[] = "<strong>" . $history_disp . "</strong>";
        $search[] = "%medications%";
        $replace[] = "<strong>" . $medications_disp . "</strong>";
        $search[] = "%sleeplab_name%";
        $replace[] = "<strong>" . $sleeplab_name . "</strong>";
        $search[] = "%1ststudy_date%";
        $replace[] = "<strong>" . $first_study_date . "</strong>";
        $search[] = "%1stRDI/AHI%";
        $replace[] = "<strong>" . $first_rdi . "/" . $first_ahi . "</strong>";
        $search[] = "%1stLowO2%";
        $replace[] = "<strong>" . $first_o2nadir . "</strong>";
        $search[] = "%1stTO290%";
        $replace[] = "<strong>" . $first_o2sat90 . "</strong>";
        $search[] = "%2ndtype_study%";
        $replace[] = "<strong>" . $second_type_study . "</strong>";
        $search[] = "%2ndahi%";
        $replace[] = "<strong>" . $second_ahi . "</strong>";
        $search[] = "%2ndrdi%";
        $search[] = "%2ndahisupine%";
        $replace[] = "<strong>" . $second_ahisupine . "</strong>";
        $replace[] = "<strong>" . $second_rdi . "</strong>";
        $search[] = "%2ndO2Sat90%";
        $replace[] = "<strong>" . $second_o2sat90 . "</strong>";
        $search[] = "%2ndstudy_date%";
        $replace[] = "<strong>" . $second_study_date . "</strong>";
        $search[] = "%2ndRDI/AHI%";
        $replace[] = "<strong>" . $second_rdi . "/" . $second_ahi . "</strong>";
        $search[] = "%2ndLowO2%";
        $replace[] = "<strong>" . $second_o2nadir . "</strong>";
        $search[] = "%2ndTO290%";
        $replace[] = "<strong>" . $second_o2sat90 . "</strong>";
        $search[] = "%2nddiagnosis%";
        $replace[] = "<strong>" . $second_diagnosis . "</strong>";
        $search[] = "%appt_date%";
        $replace[] = "<strong>" . $appt_date . "</strong>";
        $search[] = "%delivery_date%";
        $replace[] = "<strong>" . $delivery_date . "</strong>";
        $search[] = "%dental_device%";
        $replace[] = "<strong>" . $dentaldevice . "</strong>";
        $search[] = "%1stESS%";
        $replace[] = "<strong>" . $subj1['ep_eadd'] . "</strong>";
        $search[] = "%1stSnoring%";
        $replace[] = "<strong>" . $subj1['ep_sadd'] . "</strong>";
        $search[] = "%1stEnergy%";
        $replace[] = "<strong>" . $subj1['ep_eladd'] . "</strong>";
        $search[] = "%1stQuality%";
        $replace[] = "<strong>" . $subj1['sleep_qualadd'] . "</strong>";
        $search[] = "%2ndESS%";
        $replace[] = "<strong>" . $subj2['ep_eadd'] . "</strong>";
        $search[] = "%2ndSnoring%";
        $replace[] = "<strong>" . $subj2['ep_sadd'] . "</strong>";
        $search[] = "%2ndEnergy%";
        $replace[] = "<strong>" . $subj2['ep_eladd'] . "</strong>";
        $search[] = "%2ndQuality%";
        $replace[] = "<strong>" . $subj2['sleep_qualadd'] . "</strong>";
        $search[] = "%bmi%";
        $replace[] = "<strong>" . $bmi . "</strong>";
        $search[] = "%reason_seeking_tx%";
        $replace[] = "<strong>" . $reason_seeking_tx . "</strong>";
        $search[] = "%symptoms%";
        $replace[] = "<strong>" . $symptom_list . "</strong>";
        $search[] = "%other_mds%";
        $other_mds = "";
        $count = 1;

        foreach ($md_contacts as $index => $md) {
            $md_fullname = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
            if ($md_fullname != $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname']) {
                $other_mds .= $md_fullname;
                if ($count < count($md_contacts)) {
                    $other_mds .= ", ";
                }
                $count++;
            }
        }
        $other_mds = rtrim($other_mds, ", ");
        $replace[] = "<strong>" . $other_mds . "</strong>";

        if ($new_template[$key] != null) {
            $letter[$key] = str_replace($search, $replace, $new_template[$key]);
            $new_template[$key] = htmlentities($new_template[$key]);
        } else {
            $letter[$key] = str_replace($search, $replace, $template);
        }

        // Catch Post Send Submit Button and Send letters Here
        if ($_POST['send_letter'][$key] != null && $numletters == $_POST['numletters']) {
            if (count($letter_contacts) == 1) {
                $parent = true;
            }
            $type = $contact['type'];
            $recipientid = $contact['id'];
            if ($_GET['backoffice'] == '1') {
                $message = $letter[$key];
                $search = ["<strong>","</strong>"];
                $message = str_replace($search, "", $message);
                deliver_letter($letterid, $message);
            } else {
                send_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
            }
            if ($parent) { ?>
                <script type="text/javascript">
                    window.location = '<?php echo ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
                </script>
                <?php
            }
            continue;
        }
        // Catch Post Delete Button and Delete letters Here
        if ($_POST['delete_letter'][$key] != null && $numletters == $_POST['numletters']) {
            if (count($letter_contacts) == 1) {
                $parent = true;
            }
            $type = $contact['type'];
            $recipientid = $contact['id'];
            $letterid = delete_letter($letterid, $type, $recipientid, $new_template[$key]);
            if ($parent) { ?>
                <script type="text/javascript">
                    window.location = '<?php echo ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
                </script>
                <?php
            }
            continue;
        } ?>
        <div align="right">
            <button class="addButton" onclick="edit_letter('letter<?php echo $key?>');return false;" >
                Edit Letter
            </button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="duplicate_letter[<?php echo $key?>]" class="addButton" value="Duplicate" />
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button class="addButton" onclick="window.open('dss_intro_to_md_from_dss_print.php?pid=<?php echo $_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
                Print Letter
            </button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button class="addButton" onclick="window.open('dss_intro_to_md_from_dss_word.php?pid=<?php echo $_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
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
                        <?php echo $letter[$key]; ?>
                    </div>
                    <input type="hidden" name="new_template[<?php echo $key?>]" value="<?php echo $new_template[$key]?>" />
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
    } ?>
    <br><br>
</form>
        </td>
    </tr>
</table>

<?php
if (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1') {
    include 'admin/includes/bottom.htm';
} else {
    include 'includes/bottom.htm';
}
?>
