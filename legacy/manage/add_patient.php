<?php
namespace Ds3\Libraries\Legacy;

$patientId = intval($_GET['pid']);

/**
 * @see DSS-348
 *
 * If the patient id is different, maybe the link is malformed
 */
if (isset($_GET['pid']) && (string)$patientId !== (string)$_GET['pid']) {
    $_GET['pid'] = $patientId;
    $_GET['ed'] = $patientId;

    header('Location: /manage/add_patient.php?' . http_build_query($_GET));
    trigger_error('Die called', E_USER_ERROR);
}

if (!isset($_GET['noheaders'])) {
    include 'includes/top.htm';
    include_once 'includes/constants.inc';
} else {
    include_once 'admin/includes/main_include.php';
    include 'includes/sescheck.php';
    include_once 'includes/constants.inc';
    include_once 'includes/authorization_functions.php';
    include_once 'includes/general_functions.php';
    include_once 'includes/notifications.php';
    include_once 'includes/patient_changes.php';
    ?>
    <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
    <link href="css/task.css" rel="stylesheet" type="text/css" />
    <link href="css/notifications.css" rel="stylesheet" type="text/css" />
    <link href="css/search-hints.css" rel="stylesheet" type="text/css">
    <link href="css/top.css" rel="stylesheet" type="text/css" />
    <script>
        var existingPatient = <?= intval($_GET['ed']) ?>,
            patientId = <?= $patientId ?>;
    </script>
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="js/add_patient.js?v=<?= time() ?>"></script>
    <script type="text/javascript" src="js/masks.js"></script>
    <script type="text/javascript" src="script/logout_timer.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <link rel="stylesheet" href="css/letter-form.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="script/autocomplete.js?v=20160719" type="text/javascript"></script>
    <script src="script/autocomplete_local.js?v=20160719" type="text/javascript"></script>
    <?php
}

$db = new Db();

if (!empty($_POST['from_tracker'])) {
    $notes = $db->escape($_POST['tracker_notes']);
    $docId = intval($_SESSION['docid']);

    $db->query("UPDATE dental_patient_summary summary
            LEFT JOIN dental_patients patient ON patient.patientid = summary.pid
        SET summary.tracker_notes = '$notes'
        WHERE summary.pid = '$patientId'
            AND patient.docid = '$docId'");

    trigger_error('Die called', E_USER_ERROR);
}

require_once 'includes/dental_patient_summary.php';
require_once 'admin/includes/password.php';
require_once 'includes/preauth_functions.php';
require_once 'includes/hst_functions.php';

$docId = (int)$_SESSION['docid'];
$b_sql = "
    SELECT c.name, u.is_billing_exclusive AS exclusive
    FROM companies c
    JOIN dental_users u ON c.id = u.billing_company_id
    WHERE u.userid = '$docId'
";
$b_r = $db->getRow($b_sql);
if ($b_r) {
    $exclusive_billing = (!empty($b_r['exclusive']) ? $b_r['exclusive'] : '');
    $billing_co = (!empty($b_r['name']) ? $b_r['name'] : '');
} else {
    $exclusive_billing = 0;
    $billing_co = "DSS";
}

?>
<script type="text/javascript">
  var billing_co = '<?= $billing_co; ?>';
</script>
<?php
$docsql = "SELECT use_patient_portal FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
$docr = $db->getRow($docsql);
$doc_patient_portal = $docr['use_patient_portal'];

include 'includes/similar.php';
function trigger_letter20($pid)
{
    $letterid = '20';
    $md_list = get_mdcontactids($pid);
    $pt_referral_list = get_ptreferralids($pid);
    $letter = create_letter($letterid, $pid, '', '', '', '', $pt_referral_list);
    if (is_numeric($letter)) {
        return $letter;
    }
    echo "Can't send letter 20: " . $letter;
    trigger_error("Die called", E_USER_ERROR);
    return null;
}

// Trigger Letter 20 Thankyou
$pt_referralid = get_ptreferralids($patientId);
if ($pt_referralid) {
    $sql = "SELECT letterid FROM dental_letters WHERE patientid = '$patientId' AND templateid = '20' AND pat_referral_list = '".s_for($pt_referralid)."';";
    $numrows = $db->getNumberRows($sql);
    if ($numrows == 0) {
        trigger_letter20($patientId);
    }
}
?>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<script type="text/javascript" src="/manage/js/patient_dob.js"></script>
<script type="text/javascript" src="/manage/js/add_patient.js?v=<?= time() ?>"></script>
<link rel="stylesheet" href="css/add_patient.css?v=<?= time() ?>" type="text/css" media="screen" />
<?php
/*=======================================================
TRIGGERING LETTERS
=======================================================*/
// Trigger Letter 1 and 2 if New MD was added
function trigger_letter1and2($pid)
{
    $con = $GLOBALS['con'];
    $db = new Db();
    //prevent letters from being generated if letters or intro letters disabled
    $let_sql = "SELECT use_letters, intro_letters FROM dental_users WHERE userid='".mysqli_real_escape_string($GLOBALS['con'], $_SESSION['docid'])."'";
    $let_r = $db->getRow($let_sql);
    if($let_r['use_letters'] && $let_r['intro_letters']){
        $letter1id = "1";
        $letter2id = "2";
        $mdcontacts = [];
        $mdcontacts[] = $_POST['docsleep'];
        $mdcontacts[] = $_POST['docpcp'];
        $mdcontacts[] = $_POST['docdentist'];
        $mdcontacts[] = $_POST['docent'];
        $mdcontacts[] = $_POST['docmdother'];
        $mdcontacts[] = $_POST['docmdother2'];
        $mdcontacts[] = $_POST['docmdother3'];
        $recipients = [];
        foreach ($mdcontacts as $contact) {
            if ($contact != "Not Set") {
                $contact_query = '%,' .  $contact . ',%';
                $letter_query = "SELECT md_list FROM dental_letters WHERE md_list IS NOT NULL AND CONCAT(',', md_list, ',') LIKE '".$contact_query."' AND templateid IN(".$letter1id.",".$letter2id.");";
                $num_rows = $db->getNumberRows($letter_query);
                if ($num_rows == 0 && $contact != "") {
                    $c_sql = "select * from dental_contact where contactid='".mysqli_real_escape_string($GLOBALS['con'], $contact)."' and status=1";
                    $c_q = mysqli_query($GLOBALS['con'], $c_sql);
                    if (count($c_q) > 0) {
                        $recipients[] = $contact;
                    }
                }
            }
        }
        if (count($recipients) > 0) {
            $recipients_list = implode(',', $recipients);
            $letter2 = create_letter($letter2id, $pid, '', '', $recipients_list);

            //DO NOT SENT LETTER 1 (FROM DSS) TO SOFTWARE USER
            if ($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE) {
                $letter1 = create_letter($letter1id, $pid, '', '', $recipients_list);
                if (!is_numeric($letter1)) {
                    echo $letter1;
                    trigger_error("Die called", E_USER_ERROR);
                }
            }
            if (!is_numeric($letter2)) {
                echo $letter2;
                trigger_error("Die called", E_USER_ERROR);
            }
        }
    }
}

function trigger_letter3($pid)
{
    $letterid = '3';
    $topatient = '1';
    $letter = create_letter($letterid, $pid, '', $topatient);
    if (is_numeric($letter)) {
        return $letter;
    }
    echo $letter;
    trigger_error("Die called", E_USER_ERROR);
    return null;
}

/*==========================================
    FORM SUBMISSION
==========================================*/
if (!empty($_POST["patientsub"]) && $_POST["patientsub"] == 1) {
    linkRequestData('dental_patients', $_POST['ed']);

    if ($_POST['p_m_eligible_payer'] != '') {
        $p_m_eligible_payer_id = substr($_POST['p_m_eligible_payer'], 0, strpos($_POST['p_m_eligible_payer'], '-'));
        $p_m_eligible_payer_name = substr($_POST['p_m_eligible_payer'], (strpos($_POST['p_m_eligible_payer'], '-') + 1));
    } else {
        $p_m_eligible_payer_id = '';
        $p_m_eligible_payer_name = '';
    }
    if ($_POST['s_m_eligible_payer'] != '') {
        $s_m_eligible_payer_id = substr($_POST['s_m_eligible_payer'], 0, strpos($_POST['s_m_eligible_payer'], '-'));
        $s_m_eligible_payer_name = substr($_POST['s_m_eligible_payer'], (strpos($_POST['s_m_eligible_payer'], '-') + 1));
    } else {
        $s_m_eligible_payer_id = '';
        $s_m_eligible_payer_name = '';
    }
    $use_patient_portal = $_POST['use_patient_portal'];
    if ($_POST["ed"] != "") { // existing patient (update)
        $s_sql = "
            SELECT referred_by, referred_source, email, password, registration_status, 
                p_m_relation,
                p_m_partyfname, 
                p_m_partylname, 
                ins_dob, 
                p_m_ins_type, 
                p_m_ins_ass, 
                p_m_ins_co, 
                p_m_ins_id, 
                p_m_ins_grp, 
                p_m_ins_plan 
            FROM dental_patients
            WHERE patientid = '$patientId'";
        $s_r = $db->getRow($s_sql);
        $old_referred_by = $s_r['referred_by'];
        $old_referred_source = $s_r['referred_source'];
        $old_p_m_ins_co = $s_r['p_m_ins_co'];
        if ($s_r['registration_status'] == 2 && $_POST['email'] != $s_r['email']) { // if registered attempt to send update email
            sendUpdatedEmail($_GET['pid'], $_POST['email'], $s_r['email'], 'doc');
        } elseif(isset($_POST['sendRem'])) {
            sendRemEmail($_POST['ed'], $_POST['email']); // send reminder email
        } elseif (!isset($_POST['sendReg']) && $s_r['registration_status'] == 1 && trim($_POST['email']) != trim($s_r['email'])) {
            if ($doc_patient_portal && $use_patient_portal) {
                sendRegEmail($_POST['ed'], $_POST['email'], ''); // send reg email if email is updated and not registered
            }
        }

        $ed_sql = "
            update dental_patients 
            set 
                firstname = '".s_for($_POST["firstname"])."', 
                lastname = '".s_for($_POST["lastname"])."', 
                middlename = '".s_for($_POST["middlename"])."', 
                preferred_name = '".s_for($_POST["preferred_name"])."',
                salutation = '".s_for($_POST["salutation"])."',
                member_no = '".s_for((!empty($_POST['member_no']) ? $_POST['member_no'] : ''))."',
                group_no = '".s_for((!empty($_POST['group_no']) ? $_POST['group_no'] : ''))."',
                plan_no = '".s_for((!empty($_POST["plan_no"]) ? $_POST["plan_no"] : ''))."', 
                add1 = '".s_for($_POST["add1"])."', 
                add2 = '".s_for($_POST["add2"])."', 
                city = '".s_for($_POST["city"])."', 
                state = '".s_for($_POST["state"])."', 
                zip = '".s_for($_POST["zip"])."', 
                dob = '".s_for($_POST["dob"])."', 
                gender = '".s_for($_POST["gender"])."', 
                marital_status = '".s_for($_POST["marital_status"])."', 
                ssn = '".s_for(num($_POST["ssn"], false))."', 
                feet= '".s_for($_POST['feet'])."',
                inches= '".s_for($_POST['inches'])."',
                weight= '".s_for($_POST['weight'])."',
                bmi= '".s_for($_POST['bmi'])."',
                home_phone = '".s_for(num($_POST["home_phone"]))."', 
                work_phone = '".s_for(num($_POST["work_phone"]))."', 
                cell_phone = '".s_for(num($_POST["cell_phone"]))."', 
                best_time = '".s_for($_POST["best_time"])."',
                best_number = '".s_for($_POST["best_number"])."',
                email = '".s_for($_POST["email"])."',
        ";
        if ($_POST['email'] != $s_r['email']) {
            $ed_sql .= "email_bounce = 0,";
        }
        $ed_sql .= " 
                patient_notes = '".s_for($_POST["patient_notes"])."', 
                display_alert = '".s_for($_POST["display_alert"])."',
                alert_text = '".s_for(!empty($_POST["alert_text"]) ? $_POST["alert_text"] : '')."', 
                p_d_party = '".s_for(!empty($_POST["p_d_party"]) ? $_POST["p_d_party"] : '')."', 
                p_d_relation = '".s_for(!empty($_POST["p_d_relation"]) ? $_POST["p_d_relation"] : '')."', 
                p_d_other = '".s_for(!empty($_POST["p_d_other"]) ? $_POST["p_d_other"] : '')."', 
                p_d_employer = '".s_for(!empty($_POST["p_d_employer"]) ? $_POST["p_d_employer"] : '')."', 
                p_d_ins_co = '".s_for(!empty($_POST["p_d_ins_co"]) ? $_POST["p_d_ins_co"] : '')."', 
                p_d_ins_id = '".s_for(!empty($_POST["p_d_ins_id"]) ? $_POST["p_d_ins_id"] : '')."', 
                s_d_party = '".s_for(!empty($_POST["s_d_party"]) ? $_POST["s_d_party"] : '')."', 
                s_d_relation = '".s_for(!empty($_POST["s_d_relation"]) ? $_POST["s_d_relation"] : '')."', 
                s_d_other = '".s_for(!empty($_POST["s_d_other"]) ? $_POST["s_d_other"] : '')."', 
                s_d_employer = '".s_for(!empty($_POST["s_d_employer"]) ? $_POST["s_d_employer"] : '')."', 
                s_d_ins_co = '".s_for(!empty($_POST["s_d_ins_co"]) ? $_POST["s_d_ins_co"] : '')."', 
                s_d_ins_id = '".s_for(!empty($_POST["s_d_ins_id"]) ? $_POST["s_d_ins_id"] : '')."', 
                p_m_partyfname = '".s_for($_POST["p_m_partyfname"])."',
                p_m_partymname = '".s_for($_POST["p_m_partymname"])."',
                p_m_partylname = '".s_for($_POST["p_m_partylname"])."',
                p_m_gender = '".s_for($_POST["p_m_gender"])."',
                p_m_ins_grp = '".s_for($_POST["p_m_ins_grp"])."',
                s_m_ins_grp = '".s_for($_POST["s_m_ins_grp"])."',
                p_m_dss_file = '".s_for(!empty($_POST["p_m_dss_file"]) ? $_POST["p_m_dss_file"] : '')."',
                s_m_dss_file = '".s_for(!empty($_POST["s_m_dss_file"]) ? $_POST["s_m_dss_file"] : '')."',
                p_m_same_address = '".s_for($_POST["p_m_same_address"])."',
                s_m_same_address = '".s_for($_POST["s_m_same_address"])."',
                p_m_address = '".s_for($_POST["p_m_address"])."',
                p_m_city = '".s_for($_POST["p_m_city"])."',
                p_m_state = '".s_for($_POST["p_m_state"])."',
                p_m_zip = '".s_for($_POST["p_m_zip"])."',
                s_m_address = '".s_for($_POST["s_m_address"])."',
                s_m_city = '".s_for($_POST["s_m_city"])."',
                s_m_state = '".s_for($_POST["s_m_state"])."',
                s_m_zip = '".s_for($_POST["s_m_zip"])."',
                p_m_ins_type = '".s_for($_POST["p_m_ins_type"])."',
                s_m_ins_type = '".s_for($_POST["s_m_ins_type"])."',
                p_m_ins_ass = '".s_for(!empty($_POST["p_m_ins_ass"]) ? $_POST["p_m_ins_ass"] : '')."',
                s_m_ins_ass = '".s_for(!empty($_POST["s_m_ins_ass"]) ? $_POST["s_m_ins_ass"] : '')."',
                ins_dob = '".s_for($_POST["ins_dob"])."',
                ins2_dob = '".s_for($_POST["ins2_dob"])."',
                p_m_relation = '".s_for($_POST["p_m_relation"])."', 
                p_m_other = '".s_for(!empty($_POST["p_m_other"]) ? $_POST["p_m_other"] : '')."', 
                p_m_employer = '".s_for(!empty($_POST["p_m_employer"]) ? $_POST["p_m_employer"] : '')."', 
                p_m_ins_co = '".s_for($_POST["p_m_ins_co"])."', 
                p_m_ins_id = '".s_for($_POST["p_m_ins_id"])."', 
                p_m_eligible_payer_id = '".$p_m_eligible_payer_id."',
                p_m_eligible_payer_name = '".mysqli_real_escape_string($con,$p_m_eligible_payer_name)."',
                s_m_eligible_payer_id = '".$s_m_eligible_payer_id."',
                s_m_eligible_payer_name = '".mysqli_real_escape_string($con,$s_m_eligible_payer_name)."',
                has_s_m_ins = '".s_for($_POST["s_m_ins"])."',
                s_m_partyfname = '".s_for($_POST["s_m_partyfname"])."',
                s_m_partymname = '".s_for($_POST["s_m_partymname"])."',
                s_m_partylname = '".s_for($_POST["s_m_partylname"])."', 
                s_m_gender = '".s_for($_POST["s_m_gender"])."',
                s_m_relation = '".s_for($_POST["s_m_relation"])."', 
                s_m_other = '".s_for(!empty($_POST["s_m_other"]) ? $_POST["s_m_other"] : '')."', 
                s_m_employer = '".s_for(!empty($_POST["s_m_employer"]) ? $_POST["s_m_employer"] : '')."', 
                s_m_ins_co = '".s_for($_POST["s_m_ins_co"])."', 
                s_m_ins_id = '".s_for($_POST["s_m_ins_id"])."',
                p_m_ins_plan = '".s_for($_POST["p_m_ins_plan"])."',
                s_m_ins_plan = '".s_for($_POST["s_m_ins_plan"])."', 
                employer = '".s_for($_POST["employer"])."', 
                emp_add1 = '".s_for($_POST["emp_add1"])."', 
                emp_add2 = '".s_for($_POST["emp_add2"])."', 
                emp_city = '".s_for($_POST["emp_city"])."', 
                emp_state = '".s_for($_POST["emp_state"])."', 
                emp_zip = '".s_for($_POST["emp_zip"])."', 
                emp_phone = '".s_for(num($_POST["emp_phone"]))."', 
                emp_fax = '".s_for(num($_POST["emp_fax"]))."', 
                plan_name = '".s_for(!empty($_POST["plan_name"]) ? $_POST["plan_name"] : '')."', 
                group_number = '".s_for(!empty($_POST["group_number"]) ? $_POST["group_number"] : '')."', 
                ins_type = '".s_for(!empty($_POST["ins_type"]) ? $_POST["ins_type"] : '')."', 
                accept_assignment = '".s_for(!empty($_POST["accept_assignment"]) ? $_POST["accept_assignment"] : '')."', 
                print_signature = '".s_for(!empty($_POST["print_signature"]) ? $_POST["print_signature"] : '')."', 
                medical_insurance = '".s_for(!empty($_POST["medical_insurance"]) ? $_POST["medical_insurance"] : '')."', 
                mark_yes = '".s_for(!empty($_POST["mark_yes"]) ? $_POST["mark_yes"] : '')."',
                inactive = '".s_for(!empty($_POST["inactive"]) ? $_POST["inactive"] : '')."',
                partner_name = '".s_for($_POST["partner_name"])."',
                docsleep = '".s_for($_POST["docsleep"])."',
                docpcp = '".s_for($_POST["docpcp"])."',
                mark_yes = '".s_for(!empty($_POST["mark_yes"]) ? $_POST["mark_yes"] : '')."',
                docdentist = '".s_for($_POST["docdentist"])."',
                docent = '".s_for($_POST["docent"])."',
                docmdother = '".s_for($_POST["docmdother"])."',
                docmdother2 = '".s_for($_POST["docmdother2"])."',
                docmdother3 = '".s_for($_POST["docmdother3"])."',
                emergency_name = '".s_for($_POST["emergency_name"])."',
                emergency_relationship = '".s_for($_POST["emergency_relationship"])."',
                emergency_number = '".s_for(num($_POST["emergency_number"]))."',
                docent = '".s_for($_POST["docent"])."',
                emergency_name = '".s_for($_POST["emergency_name"])."',
                emergency_number = '".s_for(num($_POST["emergency_number"]))."',
                referred_source = '".s_for($_POST["referred_source"])."',
                referred_by = '".s_for($_POST["referred_by"])."',
                referred_notes = '".s_for($_POST["referred_notes"])."',
                copyreqdate = '".s_for($_POST["copyreqdate"])."',
                status = '".s_for($_POST["status"])."',
                use_patient_portal = '".s_for($_POST["use_patient_portal"])."',
                preferredcontact = '".s_for($_POST["preferredcontact"])."'
            where patientid='".intval($_POST["ed"])."'
        ";
        $db->query($ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
        $db->query("UPDATE dental_patients set email='".mysqli_real_escape_string($con,$_POST['email'])."' WHERE parent_patientid='".mysqli_real_escape_string($con, $_POST["ed"])."'");

        //Remove pending vobs if ins info has changed.
        if ($old_p_m_ins_co != $_POST['p_m_ins_co']
            || $s_r['p_m_relation'] != $_POST['p_m_relation']
            || $s_r['p_m_partyfname'] != $_POST['p_m_partyfname']
            || $s_r['p_m_partylname'] != $_POST['p_m_partylname']
            || $s_r['ins_dob'] != $_POST['ins_dob']
            || $s_r['p_m_ins_type'] != $_POST['p_m_ins_type']
            || (!empty($s_r['p_m_ins_ass']) && $s_r['p_m_ins_ass'] != $_POST['p_m_ins_ass'])
            || $s_r['p_m_ins_id'] != $_POST['p_m_ins_id']
            || $s_r['p_m_ins_grp'] != $_POST['p_m_ins_grp']
            || $s_r['p_m_ins_plan'] != $_POST['p_m_ins_plan'])
        {
            $vob_sql = "
                UPDATE dental_insurance_preauth 
                SET
                    status = " . DSS_PREAUTH_REJECTED . ",
                    reject_reason = '".mysqli_real_escape_string($con,$_SESSION['name'])." altered patient insurance information requiring VOB resubmission on ".date('m/d/Y h:i')."',
                    viewed = 1,
                    updated_at = NOW()
                WHERE patient_id = '".mysqli_real_escape_string($con,$_REQUEST['ed'])."'
                AND (status = ".DSS_PREAUTH_PENDING." OR status=".DSS_PREAUTH_PREAUTH_PENDING.")
            ";
            $vob_update = $db->query($vob_sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
            if (mysqli_affected_rows($GLOBALS['con']) >= 1) {
                $c = create_vob( $_POST['ed'] );
            }
        }

        if (isset($_POST['location'])) {
            $ds_sql = "SELECT * FROM dental_summary where patientid='$patientId'";
            $ds_q = $db->getRow($ds_sql);
            if ($ds_q) {
                $loc_query = "UPDATE dental_summary SET location='".mysqli_real_escape_string($con,$_POST['location'])."' WHERE patientid='$patientId'";
            } else {
                $loc_query = "INSERT INTO dental_summary SET location='".mysqli_real_escape_string($con,$_POST['location'])."', patientid='$patientId'";
            }
            $db->query($loc_query);
        }

        $lsql = "SELECT login, password, registration_status FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con,$_POST['ed'])."'";
        $l = $db->getRow($lsql);
        $login = $l['login'];
        $pass = $l['password'];
        if ($login == '') {
            $clogin = strtolower(substr($_POST["firstname"], 0, 1).$_POST["lastname"]);
            $clogin = preg_replace("/[^A-Za-z]/", "", $clogin);
            $csql = "SELECT login FROM dental_patients WHERE login LIKE '".$clogin."%'";
            $cq = $db->getResults($csql);
            $carray = [];
            if ($cq) {
                foreach ($cq as $c) {
                    array_push($carray, $c['login']);
                }
            }
            if (in_array($clogin, $carray)) {
                $count = 1;
                while (in_array($clogin.$count, $carray)) {
                    $count++;
                }
                $login = strtolower($clogin.$count);
            } else {
                $login = strtolower($clogin);
            }
            $ilsql = "UPDATE dental_patients set login='".mysqli_real_escape_string($con,$login)."'  WHERE patientid='".mysqli_real_escape_string($con, $_POST['ed'])."'";
            $db->query($ilsql);
        }
        if (isset($_POST['sendReg']) && $doc_patient_portal && $_POST['use_patient_portal']) {
            if(trim($_POST['email']) != '' && trim($_POST['cell_phone']) != '') {
                sendRegEmail($_POST['ed'], $_POST['email'], $login, $s_r['email']);
            } else { ?>
                <script type="text/javascript">
                    alert('Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.');
                </script>
                <?php
            }
        }

        if (!empty($_POST['copyreqdate'])) {
          $dateCompleted = date('Y-m-d', strtotime($_POST['copyreqdate']));
        } else {
          $dateCompleted = date('Y-m-d');
        }

        $s1 = "UPDATE dental_flow_pg2_info SET date_completed = '" . $dateCompleted . "' WHERE patientid='".intval($_POST['ed'])."' AND stepid='1';";
        $db->query($s1);

        if ($old_referred_by != $_POST["referred_by"] || $old_referred_source != $_POST["referred_source"]) {
            if ($old_referred_source == 2 && $_POST['referred_source'] == 2) {
                // PHYSICIAN -> PHYSICIAN
                // change pending letters to new referrer
                $sql = "UPDATE dental_letters SET template=null, md_referral_list=".$_POST["referred_by"]." WHERE status=0 AND md_referral_list=".$old_referred_by." AND patientid=".mysqli_real_escape_string($con, $_POST['ed']);
                $db->query($sql);
            } elseif ($old_referred_source == 1 && $_POST['referred_source'] == 1) {
                // PATIENT -> PATIENT
                // change pending letters to new referrer
                $sql = "UPDATE dental_letters SET template=null, pat_referral_list=".$_POST["referred_by"]." WHERE status=0 AND patientid=".mysqli_real_escape_string($con,$_POST['ed'])." AND pat_referral_list='".$old_referred_by."'";
                $db->query($sql);
            } elseif ($old_referred_source == 2 && $_POST['referred_source'] != 2) {
                //PHYSICIAN -> NOT PHYSICIAN
                $l_sql = "SELECT * FROM dental_letters WHERE md_referral_list='".mysqli_real_escape_string($con,$old_referred_by)."'  AND patientid=".mysqli_real_escape_string($con,$_POST['ed'])." AND status=0";
                $l_q = $db->getResults($l_sql);
                if ($l_q) {
                    foreach ($l_q as $l) {
                        delete_letter($l['letterid'], null, 'md_referral', $old_referred_by);
                    }
                }
            } elseif ($old_referred_source == 1 && $_POST['referred_source'] != 1) {
                // PHYSICIAN -> NOT PHYSICIAN
                $l_sql = "SELECT * FROM dental_letters WHERE pat_referral_list='".mysqli_real_escape_string($con,$old_referred_by)."'  AND patientid=".mysqli_real_escape_string($con,$_POST['ed'])." AND status=0";
                $l_q = $db->getResults($l_sql);
                if ($l_q) {
                    foreach ($l_q as $l) {
                        delete_letter($l['letterid'], null, 'pat_referral', $old_referred_by);
                    }
                }
            }
        }

        trigger_letter1and2($_POST['ed']);

        if (!empty($_POST['introletter']) && $_POST['introletter'] == 1) {
            trigger_letter3($_POST['ed']);
        }

        if (isset($_POST['add_ref_but'])) {?>
            <script type="text/javascript">
                window.location = "add_referredby.php?addtopat=<?= $patientId ?>";
            </script>
            <?php
        }

        if (isset($_POST['add_ins_but'])) { ?>
            <script type="text/javascript">
                window.location = "add_contact.php?ctype=ins<?php if (isset($_GET['pid'])) { echo "&pid=".$patientId."&type=11&ctypeeq=1&activePat=".$patientId; } ?>";
            </script>
            <?php
        }

        if (isset($_POST['add_contact_but'])) { ?>
            <script type="text/javascript">
                window.location = "add_patient_to.php?ed=<?= $patientId ?>";
            </script>
            <?php
        }
        if (isset($_POST['sendHST'])) { ?>
            <script type="text/javascript">
                window.location = "hst_request_co.php?ed=<?= $patientId ?>";
            </script>
            <?php
        }

        $msg = "Edited Successfully";
        if (isset($_POST['sendPin'])) {
            $sendPin = "&sendPin=1";
        } else {
            $sendPin = "";
        } ?>
        <script type="text/javascript">
            parent.window.location='add_patient.php?ed=<?= $patientId ?>&addtopat=1&pid=<?= $patientId ?>&msg=<?= $msg; ?><?= $sendPin; ?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $clogin = strtolower(substr($_POST["firstname"], 0, 1) . $_POST["lastname"]);
        $clogin = preg_replace('/[^a-z]+/i', '', $clogin);
        $csql = "SELECT login FROM dental_patients WHERE login LIKE '".$clogin."%'";
        $cq = $db->getResults($csql);
        $carray = [];
        if ($cq) {
            foreach ($cq as $c) {
                array_push($carray, $c['login']);
            }
        }
        if (in_array($clogin, $carray)) {
            $count = 1;
            while (in_array($clogin.$count, $carray)) {
                $count++;
            }
            $login = strtolower($clogin.$count);
        } else {
            $login = strtolower($clogin);
        }
    
        if ($_POST['ssn'] != '') {
            $salt = create_salt();
            $p = preg_replace('/\D/', '', $_POST['ssn']);
            $password = gen_password($p, $salt);
        } else {
            $salt = '';
            $password = '';
        }
        $ins_sql = "
            insert into dental_patients 
            set 
                firstname = '".s_for(ucfirst($_POST["firstname"]))."', 
                lastname = '".s_for(ucfirst($_POST["lastname"]))."', 
                middlename = '".s_for(ucfirst($_POST["middlename"]))."', 
                preferred_name = '".s_for($_POST["preferred_name"])."',
                login = '".$login."',
                salt = '".$salt."',
                password = '".mysqli_real_escape_string($con,$password)."',
                salutation = '".s_for($_POST["salutation"])."',
                member_no = '".s_for(!empty($_POST['member_no']) ? $_POST['member_no'] : '')."',
                group_no = '".s_for(!empty($_POST['group_no']) ? $_POST['group_no'] : '')."',
                plan_no = '".s_for(!empty($_POST["plan_no"]) ? $_POST["plan_no"] : '')."',  
                add1 = '".s_for($_POST["add1"])."', 
                add2 = '".s_for($_POST["add2"])."', 
                city = '".s_for($_POST["city"])."', 
                state = '".s_for($_POST["state"])."', 
                zip = '".s_for($_POST["zip"])."', 
                dob = '".s_for($_POST["dob"])."', 
                gender = '".s_for($_POST["gender"])."', 
                marital_status = '".s_for($_POST["marital_status"])."', 
                ssn = '".s_for(num($_POST["ssn"], false))."', 
                feet= '".s_for($_POST['feet'])."',
                inches= '".s_for($_POST['inches'])."',
                weight= '".s_for($_POST['weight'])."',
                bmi= '".s_for($_POST['bmi'])."',
                home_phone = '".s_for(num($_POST["home_phone"]))."', 
                work_phone = '".s_for(num($_POST["work_phone"]))."', 
                cell_phone = '".s_for(num($_POST["cell_phone"]))."', 
                best_time = '".s_for($_POST["best_time"])."',
                best_number = '".s_for($_POST["best_number"])."',
                email = '".s_for($_POST["email"])."', 
                patient_notes = '".s_for($_POST["patient_notes"])."', 
                display_alert = '".s_for($_POST["display_alert"])."',
                alert_text = '".s_for(!empty($_POST["alert_text"]) ? $_POST["alert_text"] : '')."', 
                p_d_party = '".s_for(!empty($_POST["p_d_party"]) ? $_POST["p_d_party"] : '')."', 
                p_d_relation = '".s_for(!empty($_POST["p_d_relation"]) ? $_POST["p_d_relation"] : '')."', 
                p_d_other = '".s_for(!empty($_POST["p_d_other"]) ? $_POST["p_d_other"] : '')."', 
                p_d_employer = '".s_for(!empty($_POST["p_d_employer"]) ? $_POST["p_d_employer"] : '')."', 
                p_d_ins_co = '".s_for(!empty($_POST["p_d_ins_co"]) ? $_POST["p_d_ins_co"] : '')."', 
                p_d_ins_id = '".s_for(!empty($_POST["p_d_ins_id"]) ? $_POST["p_d_ins_id"] : '')."', 
                s_d_party = '".s_for(!empty($_POST["s_d_party"]) ? $_POST["s_d_party"] : '')."', 
                s_d_relation = '".s_for(!empty($_POST["s_d_relation"]) ? $_POST["s_d_relation"] : '')."', 
                s_d_other = '".s_for(!empty($_POST["s_d_other"]) ? $_POST["s_d_other"] : '')."', 
                s_d_employer = '".s_for(!empty($_POST["s_d_employer"]) ? $_POST["s_d_employer"] : '')."', 
                s_d_ins_co = '".s_for(!empty($_POST["s_d_ins_co"]) ? $_POST["s_d_ins_co"] : '')."', 
                s_d_ins_id = '".s_for(!empty($_POST["s_d_ins_id"]) ? $_POST["s_d_ins_id"] : '')."', 
                p_m_partyfname = '".s_for($_POST["p_m_partyfname"])."',
                p_m_partymname = '".s_for($_POST["p_m_partymname"])."',
                p_m_partylname = '".s_for($_POST["p_m_partylname"])."',  
                p_m_gender = '".s_for($_POST["p_m_gender"])."',
                p_m_relation = '".s_for($_POST["p_m_relation"])."', 
                p_m_other = '".s_for(!empty($_POST["p_m_other"]) ? $_POST["p_m_other"] : '')."', 
                p_m_employer = '".s_for(!empty($_POST["p_m_employer"]) ? $_POST["p_m_employer"] : '')."', 
                p_m_ins_co = '".s_for($_POST["p_m_ins_co"])."', 
                p_m_ins_id = '".s_for($_POST["p_m_ins_id"])."', 
                p_m_eligible_payer_id = '".$p_m_eligible_payer_id."',
                p_m_eligible_payer_name = '".mysqli_real_escape_string($con,$p_m_eligible_payer_name)."',
                s_m_eligible_payer_id = '".$s_m_eligible_payer_id."',
                s_m_eligible_payer_name = '".mysqli_real_escape_string($con,$s_m_eligible_payer_name)."',
                has_s_m_ins = '".s_for($_POST["s_m_ins"])."',
                s_m_partyfname = '".s_for($_POST["s_m_partyfname"])."',
                s_m_partymname = '".s_for($_POST["s_m_partymname"])."',
                s_m_partylname = '".s_for($_POST["s_m_partylname"])."',  
                s_m_gender = '".s_for($_POST["s_m_gender"])."',
                s_m_relation = '".s_for($_POST["s_m_relation"])."', 
                s_m_other = '".s_for(!empty($_POST["s_m_other"]) ? $_POST["s_m_other"] : '')."', 
                s_m_employer = '".s_for(!empty($_POST["s_m_employer"]) ? $_POST["s_m_employer"] : '')."', 
                s_m_ins_co = '".s_for($_POST["s_m_ins_co"])."', 
                s_m_ins_id = '".s_for($_POST["s_m_ins_id"])."',
                p_m_ins_grp = '".s_for($_POST["p_m_ins_grp"])."',
                s_m_ins_grp = '".s_for($_POST["s_m_ins_grp"])."',
                p_m_dss_file = '".s_for(!empty($_POST["p_m_dss_file"]) ? $_POST["p_m_dss_file"] : '')."',
                s_m_dss_file = '".s_for(!empty($_POST["s_m_dss_file"]) ? $_POST["s_m_dss_file"] : '')."',
                p_m_same_address = '".s_for(!empty($_POST["p_m_same_address"]) ? $_POST["p_m_same_address"] : '')."',
                s_m_same_address = '".s_for(!empty($_POST["s_m_same_address"]) ? $_POST["s_m_same_address"] : '')."',
                p_m_address = '".s_for($_POST["p_m_address"])."',
                p_m_city = '".s_for($_POST["p_m_city"])."',
                p_m_state = '".s_for($_POST["p_m_state"])."',
                p_m_zip = '".s_for($_POST["p_m_zip"])."',
                s_m_address = '".s_for($_POST["s_m_address"])."',
                s_m_city = '".s_for($_POST["s_m_city"])."',
                s_m_state = '".s_for($_POST["s_m_state"])."',
                s_m_zip = '".s_for($_POST["s_m_zip"])."',
                p_m_ins_type = '".s_for($_POST["p_m_ins_type"])."',
                s_m_ins_type = '".s_for($_POST["s_m_ins_type"])."',
                p_m_ins_ass = '".s_for(!empty($_POST["p_m_ins_ass"]) ? $_POST["p_m_ins_ass"] : '')."',
                s_m_ins_ass = '".s_for(!empty($_POST["s_m_ins_ass"]) ? $_POST["s_m_ins_ass"] : '')."',
                p_m_ins_plan = '".s_for($_POST["p_m_ins_plan"])."',
                s_m_ins_plan = '".s_for($_POST["s_m_ins_plan"])."',
                ins_dob = '".s_for($_POST["ins_dob"])."',
                ins2_dob = '".s_for($_POST["ins2_dob"])."', 
                employer = '".s_for($_POST["employer"])."', 
                emp_add1 = '".s_for($_POST["emp_add1"])."', 
                emp_add2 = '".s_for($_POST["emp_add2"])."', 
                emp_city = '".s_for($_POST["emp_city"])."', 
                emp_state = '".s_for($_POST["emp_state"])."', 
                emp_zip = '".s_for($_POST["emp_zip"])."', 
                emp_phone = '".s_for(num($_POST["emp_phone"]))."', 
                emp_fax = '".s_for(num($_POST["emp_fax"]))."', 
                plan_name = '".s_for(!empty($_POST["plan_name"]) ? $_POST["plan_name"] : '')."', 
                group_number = '".s_for(!empty($_POST["group_number"]) ? $_POST["group_number"] : '')."', 
                ins_type = '".s_for(!empty($_POST["ins_type"]) ? $_POST["ins_type"] : '')."', 
                accept_assignment = '".s_for(!empty($_POST["accept_assignment"]) ? $_POST["accept_assignment"] : '')."', 
                print_signature = '".s_for(!empty($_POST["print_signature"]) ? $_POST["print_signature"] : '')."', 
                medical_insurance = '".s_for(!empty($_POST["medical_insurance"]) ? $_POST["medical_insurance"] : '')."', 
                mark_yes = '".s_for(!empty($_POST["mark_yes"]) ? $_POST["mark_yes"] : '')."', 
                inactive = '".s_for(!empty($_POST["inactive"]) ? $_POST["inactive"] : '')."',
                docsleep = '".s_for($_POST["docsleep"])."',
                docpcp = '".s_for($_POST["docpcp"])."',
                docdentist = '".s_for($_POST["docdentist"])."',
                docent = '".s_for($_POST["docent"])."',
                docmdother = '".s_for($_POST["docmdother"])."', 
                docmdother2 = '".s_for($_POST["docmdother2"])."',
                docmdother3 = '".s_for($_POST["docmdother3"])."',
                partner_name = '".s_for($_POST["partner_name"])."', 
                emergency_name = '".s_for($_POST["emergency_name"])."',
                emergency_relationship = '".s_for($_POST["emergency_relationship"])."',
                emergency_number = '".s_for(num($_POST["emergency_number"]))."',
                referred_source = '".s_for($_POST["referred_source"])."',
                referred_by = '".s_for($_POST["referred_by"])."',
                referred_notes = '".s_for($_POST["referred_notes"])."',
                copyreqdate = '".s_for($_POST["copyreqdate"])."',
                userid='".$_SESSION['userid']."', 
                docid='".$_SESSION['docid']."', 
                status = '".s_for($_POST["status"])."',
                use_patient_portal = '".s_for($_POST["use_patient_portal"])."',
                adddate=now(),
                ip_address='".$_SERVER['REMOTE_ADDR']."',
                preferredcontact='".s_for($_POST["preferredcontact"])."';
        ";
        $pid = $db->getInsertId($ins_sql);

        if (isset($_POST['location'])) {
            $loc_query = "INSERT INTO dental_summary SET location='".mysqli_real_escape_string($con, $_POST['location'])."', patientid='$patientId'";
            $db->query($loc_query);
        }

        trigger_letter1and2($pid);

        if (isset($_POST['sendReg']) && $doc_patient_portal && $_POST["use_patient_portal"]) {
            if (trim($_POST['email']) != '' && trim($_POST['cell_phone']) != '') {
                sendRegEmail($pid, $_POST['email'], $login);
            } else { ?>
                <script type="text/javascript">
                    alert('Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.');
                </script>
                <?php
            }
        }

        if (!empty($_POST['introletter']) && $_POST['introletter'] == 1) {
            trigger_letter3($pid);
        }
        $flowinsertqry = "INSERT INTO dental_flow_pg1 (`id`,`copyreqdate`,`pid`) VALUES (NULL,'".s_for($_POST["copyreqdate"])."','".$pid."');";
        $flowinsert = $db->query($flowinsertqry);
        if ($flowinsert) {
            if (!empty($referredbyqry)) {
                $referred_result = $db->query($referredbyqry);
                $message = "Successfully updated flowsheet!2";
            }
        }

        $stepid = '1';
        $segmentid = '1';
        $scheduled = strtotime(!empty($copyreqdate) ? $copyreqdate : '');
        $gen_date = date('Y-m-d H:i:s', strtotime($_POST["copyreqdate"]));

        if (empty($_POST["copyreqdate"])) {
            $gen_date = date('Y-m-d');
        }

        $flow_pg2_info_query = "INSERT INTO dental_flow_pg2_info (`patientid`, `stepid`, `segmentid`, `date_scheduled`, `date_completed`) VALUES ('".$pid."', '".$stepid."', '".$segmentid."', '".$scheduled."', '".$gen_date."');";
        $flow_pg2_info_insert = $db->query($flow_pg2_info_query);

        if (!$flow_pg2_info_insert) {
            $message = "MYSQL ERROR:".mysqli_errno($con).": ".mysqli_error($con)."<br/>"."Error inserting Initial Contact Information to Flowsheet Page 2";
        }

        $sim = similar_patients($pid);
        if (count($sim) > 0) { ?>
            <script type="text/javascript">
                parent.window.location='duplicate_patients.php?pid=<?= $pid; ?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $msg = "Patient ".$_POST["firstname"]." ".$_POST["lastname"]." added Successfully";
            if (isset($_POST['sendPin'])) {
                $sendPin = "&sendPin=1";
            } else {
                $sendPin = "";
            } ?>
            <script type="text/javascript">
                alert("<?= $msg; ?>");
                parent.window.location='add_patient.php?pid=<?= $pid; ?>&ed=<?= $pid; ?>&addtopat=1<?= $sendPin; ?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
    }
}

$request_ed = (!empty($_REQUEST['ed'])) ? $_REQUEST['ed'] : '-1';
//Check if user has pending VOB
$vob_sql = "
    SELECT * FROM dental_insurance_preauth
    WHERE patient_id = " . $request_ed . " 
    AND (status=".DSS_PREAUTH_PENDING." 
    OR status=".DSS_PREAUTH_PREAUTH_PENDING.") 
    ORDER BY front_office_request_date DESC 
    LIMIT 1
";
$vob_myarray = $db->getRow($vob_sql);
$pending_vob = count($vob_myarray);
$pending_vob_status = $vob_myarray['status'];

$thesql = "select * from dental_patients where patientid='".$request_ed."'";
$themyarray = $db->getRow($thesql);

if (isset($msg) && $msg != '') {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $preferred_name = $_POST['preferred_name'];
    $salutation = $_POST['salutation'];
    $login = $_POST['login'];
    $member_no = $_POST['member_no'];
    $group_no = $_POST['group_no'];
    $plan_no = $_POST['plan_no'];
    $dob = $_POST['dob'];
    $add1 = $_POST['add1'];
    $add2= $_POST['add2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $ssn = $_POST['ssn'];
    $feet = $_POST['feet'];
    $inches = $_POST['inches'];
    $weight = $_POST['weight'];
    $bmi = $_POST['bmi'];
    $home_phone = $_POST['home_phone'];
    $work_phone = $_POST['work_phone'];
    $cell_phone = $_POST['cell_phone'];
    $best_time = $_POST['best_time'];
    $best_number = $_POST['best_number'];
    $email = $_POST['email'];
    $patient_notes = $_POST['patient_notes'];
    $display_alert = $_POST['display_alert'];
    $alert_text = $_POST['alert_text'];
    $p_d_party = $_POST["p_d_party"];
    $p_d_relation = $_POST["p_d_relation"];
    $p_d_other = $_POST["p_d_other"];
    $p_d_employer = $_POST["p_d_employer"];
    $p_d_ins_co = $_POST["p_d_ins_co"];
    $p_d_ins_id = $_POST["p_d_ins_id"];
    $s_d_party = $_POST["s_d_party"];
    $s_d_relation = $_POST["s_d_relation"];
    $s_d_other = $_POST["s_d_other"];
    $s_d_employer = $_POST["s_d_employer"];
    $s_d_ins_co = $_POST["s_d_ins_co"];
    $s_d_ins_id = $_POST["s_d_ins_id"];
    $p_m_partyfname = $_POST["p_m_partyfname"];
    $p_m_partymname = $_POST["p_m_partymname"];
    $p_m_partylname = $_POST["p_m_partylname"];
    $p_m_gender = $_POST['p_m_gender'];
    $p_m_relation = $_POST["p_m_relation"];
    $p_m_other = $_POST["p_m_other"];
    $p_m_employer = $_POST["p_m_employer"];
    $p_m_ins_co = $_POST["p_m_ins_co"];
    $p_m_ins_id = $_POST["p_m_ins_id"];
    $p_m_ins_payer_id = $_POST['p_m_ins_payer_id'];
    $has_s_m_ins = $_POST["s_m_ins"];
    $s_m_partyfname = $_POST["s_m_partyfname"];
    $s_m_partymname = $_POST["s_m_partymname"];
    $s_m_partylname = $_POST["s_m_partylname"];
    $s_m_gender = $_POST['s_m_gender'];
    $s_m_relation = $_POST["s_m_relation"];
    $s_m_other = $_POST["s_m_other"];
    $s_m_employer = $_POST["s_m_employer"];
    $s_m_ins_co = $_POST["s_m_ins_co"];
    $s_m_ins_id = $_POST["s_m_ins_id"];
    $p_m_ins_grp = $_POST["p_m_ins_grp"];
    $s_m_ins_grp = $_POST["s_m_ins_grp"];
    $p_m_dss_file = $_POST["p_m_dss_file"];
    $s_m_dss_file = $_POST["s_m_dss_file"];
    $p_m_same_address = $_POST["p_m_same_address"];
    $s_m_same_address = $_POST["s_m_same_address"];
    $p_m_address = $_POST["p_m_address"];
    $p_m_city = $_POST["p_m_city"];
    $p_m_state = $_POST["p_m_state"];
    $p_m_zip = $_POST["p_m_zip"];
    $s_m_address = $_POST["s_m_address"];
    $s_m_city = $_POST["s_m_city"];
    $s_m_state = $_POST["s_m_state"];
    $s_m_zip = $_POST["s_m_zip"];
    $p_m_ins_type = $_POST["p_m_ins_type"];
    $s_m_ins_type = $_POST["s_m_ins_type"];
    $p_m_ins_ass = $_POST["p_m_ins_ass"];
    $s_m_ins_ass = $_POST["s_m_ins_ass"];
    $p_m_ins_plan = $_POST["p_m_ins_plan"];
    $s_m_ins_plan = $_POST["s_m_ins_plan"];
    $ins_dob = $_POST["ins_dob"];
    $ins2_dob = $_POST["ins2_dob"];
    $employer = $_POST["employer"];
    $emp_add1 = $_POST["emp_add1"];
    $emp_add2 = $_POST["emp_add2"];
    $emp_city = $_POST["emp_city"];
    $emp_state = $_POST["emp_state"];
    $emp_zip = $_POST["emp_zip"];
    $emp_phone = $_POST["emp_phone"];
    $docsleep = $_POST["docsleep"];
    $docpcp = $_POST["docpcp"];
    $docdentist = $_POST["docdentist"];
    $docent = $_POST["docent"];
    $docmdother = $_POST["docmdother"];
    $docmdother2 = $_POST["docmdother2"];
    $docmdother3 = $_POST["docmdother3"];
    $emp_fax = $_POST["emp_fax"];
    $plan_name = $_POST["plan_name"];
    $group_number = $_POST["group_number"];
    $ins_type = $_POST["ins_type"];
    $status = $_POST["status"];
    $use_patient_portal = $_POST["use_patient_portal"];
    $accept_assignment = $_POST["accept_assignment"];
    $print_signature = $_POST["print_signature"];
    $medical_insurance = $_POST["medical_insurance"];
    $mark_yes = $_POST["mark_yes"];
    $inactive = $_POST["inactive"];
    $partner_name = $_POST["partner_name"];
    $emergency_name = $_POST["emergency_name"];
    $emergency_relationship = $_POST["emergency_relationship"];
    $emergency_number = $_POST["emergency_number"];
    $referred_source = $_POST["referred_source"];
    $referred_by = $_POST["referred_by"];
    $referred_notes = $_POST["referred_notes"];
    $copyreqdate = $_POST["copyreqdate"];
    $preferredcontact = $_POST["preferredcontact"];
    $location = $_POST["location"];
} else {
    $firstname = st($themyarray['firstname']);
    $middlename = st($themyarray['middlename']);
    $lastname = st($themyarray['lastname']);
    $preferred_name = st($themyarray['preferred_name']);
    $salutation = st($themyarray['salutation']);
    $login = st($themyarray['login']);
    $member_no = st($themyarray['member_no']);
    $group_no = st($themyarray['group_no']);
    $plan_no = st($themyarray['plan_no']);
    $dob = st($themyarray['dob']);
    $add1 = st($themyarray['add1']);
    $add2 = st($themyarray['add2']);
    $city = st($themyarray['city']);
    $state = st($themyarray['state']);
    $zip = st($themyarray['zip']);
    $gender = st($themyarray['gender']);
    $marital_status = st($themyarray['marital_status']);
    $ssn = st($themyarray['ssn']);
    $feet = st($themyarray['feet']);
    $inches = st($themyarray['inches']);
    $weight = st($themyarray['weight']);
    $bmi = st($themyarray['bmi']);
    $home_phone = st($themyarray['home_phone']);
    $work_phone = st($themyarray['work_phone']);
    $cell_phone = st($themyarray['cell_phone']);
    $best_time = st($themyarray['best_time']);
    $best_number = st($themyarray['best_number']);
    $email = st($themyarray['email']);
    $patient_notes = st($themyarray['patient_notes']);
    $alert_text = st($themyarray['alert_text']);
    $display_alert = st($themyarray['display_alert']);
    $p_d_party = st($themyarray["p_d_party"]);
    $p_d_relation = st($themyarray["p_d_relation"]);
    $p_d_other = st($themyarray["p_d_other"]);
    $p_d_employer = st($themyarray["p_d_employer"]);
    $p_d_ins_co = st($themyarray["p_d_ins_co"]);
    $p_d_ins_id = st($themyarray["p_d_ins_id"]);
    $s_d_party = st($themyarray["s_d_party"]);
    $s_d_relation = st($themyarray["s_d_relation"]);
    $s_d_other = st($themyarray["s_d_other"]);
    $s_d_employer = st($themyarray["s_d_employer"]);
    $s_d_ins_co = st($themyarray["s_d_ins_co"]);
    $s_d_ins_id = st($themyarray["s_d_ins_id"]);
    $p_m_partyfname = st($themyarray["p_m_partyfname"]);
    $p_m_partymname = st($themyarray["p_m_partymname"]);
    $p_m_partylname = st($themyarray["p_m_partylname"]);
    $p_m_relation = st($themyarray["p_m_relation"]);
    $p_m_gender = st($themyarray["p_m_gender"]);
    $p_m_other = st($themyarray["p_m_other"]);
    $p_m_employer = st($themyarray["p_m_employer"]);
    $p_m_ins_co = st($themyarray["p_m_ins_co"]);
    $p_m_ins_id = st($themyarray["p_m_ins_id"]);
    $p_m_eligible_payer_id = st($themyarray["p_m_eligible_payer_id"]);
    $p_m_eligible_payer_name = st($themyarray["p_m_eligible_payer_name"]);
    $s_m_eligible_payer_id = st($themyarray["s_m_eligible_payer_id"]);
    $s_m_eligible_payer_name = st($themyarray["s_m_eligible_payer_name"]);
    $has_s_m_ins = st($themyarray["has_s_m_ins"]);
    $s_m_partyfname = st($themyarray["s_m_partyfname"]);
    $s_m_partymname = st($themyarray["s_m_partymname"]);
    $s_m_partylname = st($themyarray["s_m_partylname"]);
    $s_m_gender = st($themyarray["s_m_gender"]);
    $s_m_relation = st($themyarray["s_m_relation"]);
    $s_m_other = st($themyarray["s_m_other"]);
    $s_m_employer = st($themyarray["s_m_employer"]);
    $s_m_ins_co = st($themyarray["s_m_ins_co"]);
    $s_m_ins_id = st($themyarray["s_m_ins_id"]);
    $p_m_ins_grp = st($themyarray["p_m_ins_grp"]);
    $s_m_ins_grp = st($themyarray["s_m_ins_grp"]);
    $p_m_dss_file = st($themyarray["p_m_dss_file"]);
    $s_m_dss_file = st($themyarray["s_m_dss_file"]);
    $p_m_same_address = st($themyarray["p_m_same_address"]);
    $s_m_same_address = st($themyarray["s_m_same_address"]);
    $p_m_address = st($themyarray["p_m_address"]);
    $p_m_city = st($themyarray["p_m_city"]);
    $p_m_state = st($themyarray["p_m_state"]);
    $p_m_zip = st($themyarray["p_m_zip"]);
    $s_m_address = st($themyarray["s_m_address"]);
    $s_m_city = st($themyarray["s_m_city"]);
    $s_m_state = st($themyarray["s_m_state"]);
    $s_m_zip = st($themyarray["s_m_zip"]);
    $p_m_ins_type = st($themyarray["p_m_ins_type"]);
    $s_m_ins_type = st($themyarray["s_m_ins_type"]);
    $p_m_ins_ass = st($themyarray["p_m_ins_ass"]);
    $s_m_ins_ass = st($themyarray["s_m_ins_ass"]);
    $p_m_ins_plan = st($themyarray["p_m_ins_plan"]);
    $s_m_ins_plan = st($themyarray["s_m_ins_plan"]);
    $ins_dob = st($themyarray["ins_dob"]);
    $ins2_dob = st($themyarray["ins2_dob"]);
    $employer = st($themyarray["employer"]);
    $emp_add1 = st($themyarray["emp_add1"]);
    $emp_add2 = st($themyarray["emp_add2"]);
    $emp_city = st($themyarray["emp_city"]);
    $emp_state = st($themyarray["emp_state"]);
    $emp_zip = st($themyarray["emp_zip"]);
    $emp_phone = st($themyarray["emp_phone"]);
    $emp_fax = st($themyarray["emp_fax"]);
    $plan_name = st($themyarray["plan_name"]);
    $group_number = st($themyarray["group_number"]);
    $ins_type = st($themyarray["ins_type"]);
    $status = st($themyarray["status"]);
    $use_patient_portal = st($themyarray["use_patient_portal"]);
    $accept_assignment = st($themyarray["accept_assignment"]);
    $print_signature = st($themyarray["print_signature"]);
    $medical_insurance = st($themyarray["medical_insurance"]);
    $mark_yes = st($themyarray["mark_yes"]);
    $docsleep = st($themyarray["docsleep"]);
    if ($docsleep && $docsleep != 'Not Set') {
        $dsql = "
            SELECT dc.lastname, dc.firstname, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
            WHERE contactid=".$docsleep
        ;
        $d = $db->getRow($dsql);
        $docsleep_name = $d['lastname'].", ".$d['firstname'].(($d['contacttype'] != '') ? ' - '.$d['contacttype'] : '');
    } else {
        $docsleep_name = "";
    }

    $docpcp = st($themyarray["docpcp"]);
    if ($docpcp && $docpcp != 'Not Set') {
        $dsql = "
            SELECT dc.lastname, dc.firstname, dc.middlename, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
            WHERE contactid=".$docpcp
        ;
        $d = $db->getRow($dsql);
        $docpcp_name = $d['lastname'].", ".$d['firstname']. " ". $d['middlename'] .(($d['contacttype'] != '') ? ' - '.$d['contacttype'] : '');
    } else {
        $docpcp_name = "";
    }

    $docdentist = st($themyarray["docdentist"]);
    if ($docdentist && $docdentist != 'Not Set') {
        $dsql = "
            SELECT dc.lastname, dc.firstname, dc.middlename, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
            WHERE contactid=".$docdentist
        ;
        $d = $db->getRow($dsql);
        $docdentist_name = $d['lastname'].", ".$d['firstname']. " ". $d['middlename'] .(($d['contacttype'] != '') ? ' - '.$d['contacttype'] : '');
    } else {
        $docdentist_name = "";
    }
    $docent = st($themyarray["docent"]);
    if ($docent && $docent != 'Not Set') {
        $dsql = "
            SELECT dc.lastname, dc.firstname, dc.middlename, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
            WHERE contactid=".$docent
        ;
        $d = $db->getRow($dsql);
        $docent_name = $d['lastname'].", ".$d['firstname']. " ". $d['middlename'] .(($d['contacttype'] != '') ? ' - '.$d['contacttype'] : '');
    } else {
        $docent_name = "";
    }

    $docmdother = st($themyarray["docmdother"]);
    if ($docmdother && $docmdother != 'Not Set') {
        $dsql = "
            SELECT dc.lastname, dc.firstname, dc.middlename, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
            WHERE contactid=".$docmdother
        ;
        $d = $db->getRow($dsql);
        $docmdother_name = $d['lastname'].", ".$d['firstname']. " ". $d['middlename'] .(($d['contacttype'] != '') ? ' - '.$d['contacttype'] : '');
    } else {
        $docmdother_name = "";
    }

    $docmdother2 = st($themyarray["docmdother2"]);
    if ($docmdother2 && $docmdother2 != 'Not Set') {
        $dsql = "
            SELECT dc.lastname, dc.firstname, dc.middlename, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
            WHERE contactid=".$docmdother2
        ;
        $d = $db->getRow($dsql);
        $docmdother2_name = $d['lastname'].", ".$d['firstname']. " ". $d['middlename'] .(($d['contacttype'] != '') ? ' - '.$d['contacttype'] : '');
    } else {
        $docmdother2_name = "";
    }

    $docmdother3 = st($themyarray["docmdother3"]);
    if ($docmdother3 && $docmdother3 != 'Not Set') {
        $dsql = "
            SELECT dc.lastname, dc.firstname, dc.middlename, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
            WHERE contactid=".$docmdother3
        ;
        $d = $db->getRow($dsql);
        $docmdother3_name = $d['lastname'].", ".$d['firstname']. " ". $d['middlename'] .(($d['contacttype'] != '') ? ' - '.$d['contacttype'] : '');
    } else {
        $docmdother3_name = "";
    }

    $inactive = st($themyarray["inactive"]);
    $partner_name = st($themyarray["partner_name"]);
    $emergency_name = st($themyarray["emergency_name"]);
    $emergency_relationship = st($themyarray["emergency_relationship"]);
    $emergency_number = st($themyarray["emergency_number"]);
    $referred_source = st($themyarray["referred_source"]);
    $referred_by = st($themyarray["referred_by"]);
    $referred_notes = st($themyarray["referred_notes"]);
    if ($referred_source == DSS_REFERRED_PATIENT) {
        $rsql = "SELECT lastname, firstname, middlename FROM dental_patients WHERE patientid=".$referred_by;
        $r = $db->getRow($rsql);
        $referred_name = $r['lastname'].", ".$r['firstname'] . " ". $r['middlename'] . " - Patient";
    } elseif ($referred_source == DSS_REFERRED_PHYSICIAN) {
        $rsql = "
            SELECT dc.lastname, dc.firstname, dc.middlename, dct.contacttype FROM dental_contact dc
            LEFT JOIN dental_contacttype dct on dc.contacttypeid=dct.contacttypeid
            WHERE contactid=".$referred_by
        ;
        $r = $db->getRow($rsql);
        $referred_name = $r['lastname'].", ".$r['firstname']. " ". $r['middlename'];
        if ($r['contacttype'] != '') {
            $referred_name .= " - " . $r['contacttype'];
        }
    }

    $copyreqdate = st($themyarray["copyreqdate"]);
    $preferredcontact = st($themyarray["preferredcontact"]);
    $referred_notes = st($themyarray["referred_notes"]);
    $name = st($themyarray['lastname'])." ".st($themyarray['middlename']).", ".st($themyarray['firstname']);

  $loc_sql = "SELECT location from dental_summary_view WHERE patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."';";
  $loc_r = $db->getRow($loc_sql);
  $location = $loc_r['location'];

    $but_text = "Add ";
}

$salutationDefault = '';

if ($salutation === '') {
    $salutationDefault = $gender === 'Female' ? 'Ms.' : 'Mr.';
}
  
if ($themyarray["userid"] != '') {
    $but_text = "Save/Update ";
} else {
    $but_text = "Add ";
}

// Check if required information is filled out
$complete_info = 0;
if (!empty($home_phone) || !empty($work_phone) || !empty($cell_phone)) {
    $patientphone = true;
}
if (!empty($email)) {
    $patientemail = true;
}
if ((!empty($patientemail) || !empty($patientphone)) && !empty($add1) && !empty($city) && !empty($state) && !empty($zip) && !empty($dob) && !empty($gender)) {
    $complete_info = 1;
}
// Determine Whether Patient Info has been set
update_patient_summary((!empty($_GET['ed']) ? $_GET['ed'] : ''), 'patient_info', $complete_info);
?>

<?php
if (isset($msg) && $msg != '') { ?>
    <div align="center" class="red"><?= $msg; ?></div>
    <?php
} ?>

<script type="text/javascript">
    function validate_add_patient (fa) {
        if (clickedBut === 'sendPin') {
            return pinabc(fa);
        }
        p = patientabc(fa);
        var valid = true;
        <?php
        if ($referred_source == 1) {
            $rl_sql = "SELECT * FROM dental_letters WHERE patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND status=0 AND pat_referral_list='".$referred_by."'";
        } else {
            $rl_sql = "SELECT * FROM dental_letters WHERE patientid='".mysqli_real_escape_string($con, (!empty($_GET['pid']) ? $_GET['pid'] : ''))."' AND status=0 AND md_referral_list='".$referred_by."'";
        }
        $rl_q = $db->getResults($rl_sql);

        if (count($rl_q) > 0) { ?>
            if (fa.referred_by.value != '<?= $referred_by; ?>' || fa.referred_source.value != '<?= $referred_source; ?>') {
                if (!confirm("The referrer has been updated. Existing pending letters to the referrer may be updated or deleted and previous changes lost. Proceed?")) {
                    valid = false;
                }
            }
            <?php
        } ?>

      //IF PENDING VOB MAKE SURE INSURANCE HASN'T CHANGED
        if (
            (
                fa.p_m_ins_co.value != '<?= $p_m_ins_co; ?>' ||
                fa.p_m_relation.value != '<?= $p_m_relation; ?>' ||
                fa.p_m_partyfname.value != '<?= $p_m_partyfname; ?>' ||
                fa.p_m_partylname.value != '<?= $p_m_partylname; ?>' ||
                fa.ins_dob.value != '<?= $ins_dob; ?>' ||
                fa.p_m_ins_type.value != '<?= $p_m_ins_type; ?>' ||
                $('.p_m_ins_ass:checked').val() != '<?= $p_m_ins_ass; ?>' ||
                fa.p_m_ins_id.value != '<?= $p_m_ins_id; ?>' ||
                fa.p_m_ins_grp.value != '<?= $p_m_ins_grp; ?>' ||
                fa.p_m_ins_plan.value != '<?= $p_m_ins_plan; ?>'
            ) && <?= ($pending_vob) ? $pending_vob : 0; ?>
        ) {
            <?php
            if ($pending_vob_status == DSS_PREAUTH_PREAUTH_PENDING) { ?>
                if (!confirm('Warning! This patient has a Verification of Benefits (VOB) that is currently awaiting pre-authorization from the insurance company. You have changed the patient\'s insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?')) {
                    return false;
                }
                <?php
            } else { ?>
                if (!confirm('Warning! This patient has a pending Verification of Benefits (VOB). You have changed the patient\'s insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?')) {
                    return false;
                }
                <?php
            } ?>
        }
        $.ajax({
            url: "includes/check_email.php",
            type: "post",
            data: {
                email: fa.email.value<?= (isset($_GET['pid'])) ? ", id: ".$_GET['pid'] : ''; ?>
            },
            async: false,
            success: function (data) {
                var r = $.parseJSON(data);
                if (r.error) {
                    alert("Error: The email address you entered is already associated with another patient. Please enter a different email address.");
                    valid = false;
                }
            },
            failure: function (data) {}
        });
        if (!valid) {
            return false;
        }
        var sendEmail = false;
        var emailConfirm = false;
        $.ajax({
            url: "includes/check_send.php",
            type: "post",
            data: {
                email: fa.email.value<?= (isset($_GET['pid'])) ? ", id: ".$_GET['pid'] : ''; ?>
            },
            async: false,
            success: function (data) {
                var r = $.parseJSON(data);
                if (r.success) {
                    emailConfirm = true;
                    c = confirm("You have changed the patient's email address. The patient must be notified via email or he/she will not be able to access the Patient Portal. Send email notification and proceed?");
                    if (!c) {
                        sendEmail = true;
                    }
                }
            },
            failure: function (data) {}
        });
        if (sendEmail) {
            return false;
        }
        if (clickedBut === "sendReg" && !emailConfirm) {
            if (!regabc(fa)) {
                return false;
            }
        } else if (clickedBut === "sendRem" && !emailConfirm) {
            if (!remabc(fa)) {
                return false;
            }
        }
        if (p) {
            if (document.getElementById('s_m_dss_file_yes').checked) {
                i2 = validateDate('ins2_dob');
            } else {
                i2 = true;
            }
            if (document.getElementById('p_m_dss_file_yes').checked) {
                i = validateDate('ins_dob');
            } else {
                i = true;
            }
        }
        if (p) {
            result = true;
            if (i && i2 && clickedBut !== "sendReg" && clickedBut !== "sendRem") {
                var result = true;
                info = required_info(fa);
                if (info.length == 0) {
                    result = true;
                } else {
                    m = 'Warning! Patient info is incomplete. Software functionality will be disabled for this patient until all required fields are entered. Are you sure you want to continue?\n\n';
                    m += "Missing fields:";
                    for (i = 0; i < info.length; i++) {
                        m += "\n"+info[i];
                    }
                    result = confirm(m);
                }
                if (!result) {
                    return result;
                }
            }

            if (
                trim(fa.p_m_partyfname.value) != "" ||
                trim(fa.p_m_partylname.value) != "" ||
                trim(fa.p_m_relation.value) != "" ||
                trim(fa.ins_dob.value) != "" ||
                trim(fa.p_m_ins_co.value) != "" ||
                trim(fa.p_m_party.value) != "" ||
                trim(fa.p_m_ins_grp.value) != "" ||
                trim(fa.p_m_ins_plan.value) != "" ||
                trim(fa.p_m_ins_type.value) !== "Select Type"
            ) {
                if (!document.getElementById('p_m_dss_file_yes').checked && !document.getElementById('p_m_dss_file_no').checked) {
                    if (
                        $('#p_m_relation').val() != '' ||
                        $('#p_m_partyfname').val() != '' ||
                        $('#p_m_partymname').val() != '' ||
                        $('#p_m_partylname').val() != '' ||
                        $('#ins_dob').val() != '' ||
                        $('#p_m_ins_co').val() != '' ||
                        $('#p_m_party').val() != '' ||
                        $('#p_m_ins_grp').val() != '' ||
                        $('#p_m_ins_plan').val() != '' ||
                        $('#p_m_ins_type').val() != ''
                    ) {
                        alert('Is <?= $billing_co; ?> filing insurance?  Please select Yes or No.');
                        return false;
                    }
                }
            }
            if (document.getElementById('s_m_dss_file_yes').checked && !document.getElementById('p_m_dss_file_yes').checked) {
                alert('<?= $billing_co; ?> must file Primary Insurance in order to file Secondary Insurance.');
                return false;
            }

            if ($('#s_m_ins_type').val() == 1) {
                alert("Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.");
            }
            return result;
        }
        return false;
    }
</script>

<?php
$notifications = find_patient_notifications($patientId);
foreach ($notifications as $not) { ?>
    <div id="not_<?= $not['id']; ?>" class="warning <?= $not['notification_type']; ?>">
        <span><?= $not['notification']; ?> <?= ($not['notification_date']) ? "- ".date('m/d/Y h:i a', strtotime($not['notification_date'])) : ''; ?></span>
        <a href="#" class="close_but" onclick="remove_notification('<?= $not['id']; ?>');return false;">X</a>
    </div>
    <?php
}
if (isset($_GET['search']) && $_GET['search'] != '') {
    if (strpos($_GET['search'], ' ')) {
        $firstname = ucfirst(substr($_GET['search'], 0, strpos($_GET['search'], ' ')));
        $lastname = ucfirst(substr($_GET['search'], strpos($_GET['search'],' ') + 1));
    } else {
        $firstname = ucfirst($_GET['search']);
    }
} ?>

<form name="patientfrm" id="patientfrm" action="<?= $_SERVER['PHP_SELF']; ?>?pid=<?= $patientId ?>&add=1" method="post" onSubmit="return validate_add_patient(this);">
    <script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
    <script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>
    <table width="98%" style="margin-left:11px;" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td>
                <span style="color:#0a5da0; font-weight:bold; font-size:16px;">GENERAL INFORMATION</span>
            </td>
            <td align="right">
                <input type="submit" style="float:right; margin-left: 5px;" value=" <?= $but_text ?> Patient" class="button" />
                <?php
                if ($doc_patient_portal && $use_patient_portal) {
                    if ($themyarray['registration_status'] == 1 || $themyarray['registration_status'] == 0) {  ?>
                        <input type="submit" name="sendReg" value="Send Registration Email" class="button" />
                        <?php
                    } else { ?>
                        <input type="submit" name="sendRem" value="Send Reminder Email" class="button" />
                        <?php
                    }
                }
                ?>
                <span class="endpoint-permissions" style="display: inline-block;"
                      v-bind:doc-id="<?= (int)$_SESSION['docid'] ?>" v-bind:patient-id="<?= $patientId ?>">
                    <button class="button"
                            v-on:click.prevent="toggleEndpoint(group.id)"
                            v-for="group in groups"
                            v-if="group.authorize_per_patient && patientPermissions[group.id].enabled">
                        Deactivate {{ group.name }}
                    </button>
                    <button v-cloak class="button grayButton"
                            v-on:click.prevent="toggleEndpoint(group.id)"
                            v-for="group in groups"
                            v-if="group.authorize_per_patient && !patientPermissions[group.id].enabled">
                        Activate {{ group.name }}
                    </button>
                </span>
                <?php
                $bu_sql = "
                    SELECT h.*, uhc.id as uhc_id FROM companies h 
                    JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'
                    WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' 
                    ORDER BY name ASC
                ";
                $bu_q = $db->getResults($bu_sql);
                if (count($bu_q) > 0) {
                    if (!empty($pat_hst_num_uncompleted) && $pat_hst_num_uncompleted > 0) { ?>
                        <a href="#" onclick="alert('Patient has existing HST with status <?= $pat_hst_status; ?>. Only one HST can be requested at a time.'); return false;" class="button">Order HST</a>
                        <?php
                    } else { ?>
                        <input type="submit" name="sendHST"
                           onclick="return confirm('Click OK to initiate a Home Sleep Test request. The HST request must be electronically signed by an authorized provider before it can be transmitted. You can view and save/update the request on the next screen.');"
                           value="Order HST" class="button"
                        />
                        <?php
                    }
                } ?>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div id="endpoint-permissions-indicator" style="text-align: center;"
                             v-bind:doc-id="<?= (int)$_SESSION['docid'] ?>" v-bind:patient-id="<?= $patientId ?>">
                            <span style="float: none;" v-for="group in groups"
                                  v-if="group.authorize_per_patient && patientPermissions[group.id].enabled">
                                {{ group.name }}: <span style="float: none;" class="red">Active</span>
                            </span>
                                                    <span style="float: none;" v-cloak v-for="group in groups"
                                                          v-if="group.authorize_per_patient && !patientPermissions[group.id].enabled">
                                {{ group.name }}: <span style="float: none;" class="red">Not Active</span>
                            </span>
                        </div>
                        <div id="profile_image" style="float:right; width:270px;">
                            <?php
                            $pid = (!empty($_GET['pid'])) ? $_GET['pid'] : '-1';
                            $itype_sql = "select * from dental_q_image where imagetypeid=4 AND patientid=".$pid." ORDER BY adddate DESC LIMIT 1";
                            $itype_my = $db->getResults($itype_sql);
                            $num_face = count($itype_my);
                            ?>
                            <span style="float:right">
                                <?php
                                if ($num_face == 0) { ?>
                                    <a href="#" onclick="loadPopup('add_image.php?pid=<?= $patientId ?>&sh=<?= (isset($_GET['sh'])) ? $_GET['sh'] : '';?>&it=4&return=patinfo&return_field=profile');return false;" >
                                        <img src="images/add_patient_photo.png" />
                                    </a>
                                    <?php
                                } else {
                                    foreach ($itype_my as $image) { ?>
                                        <img src="display_file.php?f=<?= $image['image_file'] ?>" style="max-height:150px;max-width:200px;float:right;" />
                                        <?php
                                    }
                                } ?>
                            </span>
                        </div>
                        <label class="desc" id="title0" for="Field0" style="float:left;">Name<span id="req_0" class="req">*</span></label>
                        <div style="float:left; clear:left;">
                            <span>
                                <select name="salutation" style="width:80px;">
                                    <option value="Mr." <?php if ($salutation == "Mr." || $salutationDefault == 'Mr.') { echo "selected='selected'"; } ?>>Mr.</option>
                                    <option value="Mrs." <?php if ($salutation == "Mrs.") { echo "selected='selected'"; } ?>>Mrs.</option>
                                    <option value="Ms." <?php if ($salutation == "Ms." || $salutationDefault == 'Ms.') { echo "selected='selected'"; } ?>>Ms.</option>
                                    <option value="Dr." <?php if ($salutation == "Dr.") { echo "selected='selected'"; } ?>>Dr.</option>
                                </select>
                                <label for="salutation">Salutation</label>
                            </span>
                            <span>
                                <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="<?= $firstname ?>" maxlength="255" style="width:150px;" />
                                <label for="firstname">First Name</label>
                            </span>
                            <span>
                                <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="<?= $lastname ?>" maxlength="255" style="width:190px;" />
                                <label for="lastname">Last Name</label>
                            </span>
                            <span>
                                <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="<?= $middlename ?>" style="width:30px;" maxlength="1" />
                                <label for="middlename">MI</label>
                            </span>
                            <span>
                                <input id="preferred_name" name="preferred_name" type="text" class="field text addr tbox" value="<?= $preferred_name ?>" maxlength="255" style="width:150px" />
                                <label for="preferred_name">Preferred Name</label>
                            </span>
                        </div>
                        <div style="float:left">
                            <span>
                                <input id="home_phone" name="home_phone" type="text" class="phonemask field text addr tbox" value="<?= $home_phone ?>"  maxlength="255" style="width:100px;" />
                                <label for="home_phone">Home Phone<span id="req_0" class="req">*</span></label>
                            </span>
                            <span>
                                <input id="cell_phone" name="cell_phone" type="text" class="phonemask field text addr tbox" value="<?= $cell_phone ?>"  maxlength="255" style="width:100px;" />
                                <label for="cell_phone">Cell Phone</label>
                            </span>
                            <span>
                                <input id="work_phone" name="work_phone" type="text" class="extphonemask field text addr tbox" value="<?= $work_phone ?>" maxlength="255" style="width:150px;" />
                                <label for="work_phone">Work Phone</label>
                            </span>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="<?= $email ?>" maxlength="255" style="width:275px;" />
                                <label for="email">Email/Pt. Portal Login</label>
                            </span>
                        </div>
                        <div style="clear:both">
                            <span style="width:140px;">
                                <select id="best_time" name="best_time">
                                    <option value="">Please Select</option>
                                    <option value="morning" <?= ($best_time == 'morning') ? 'selected="selected"' : ''; ?>>Morning</option>
                                    <option value="midday" <?= ($best_time == 'midday') ? 'selected="selected"' : ''; ?>>Mid-Day</option>
                                    <option value="evening" <?= ($best_time == 'evening') ? 'selected="selected"' : ''; ?>>Evening</option>
                                </select>
                                <label for="best_time">Best time to contact</label>
                            </span>
                            <span style="width:150px;">
                                <select id="best_number" name="best_number">
                                    <option value="">Please Select</option>
                                    <option value="home" <?= ($best_number == 'home') ? 'selected="selected"' : ''; ?>>Home Phone</option>
                                    <option value="work" <?= ($best_number == 'work') ? 'selected="selected"' : ''; ?>>Work Phone</option>
                                    <option value="cell" <?= ($best_number == 'cell') ? 'selected="selected"' : ''; ?>>Cell Phone</option>
                                </select>
                                <label for="best_number">Best number to contact</label>
                            </span>
                            <span style="width:160px;">
                                <select id="preferredcontact" name="preferredcontact">
                                    <option value="paper" <?php if ($preferredcontact == 'paper') echo " selected"; ?>>Paper Mail</option>
                                    <option value="email" <?php if ($preferredcontact == 'email') echo " selected"; ?>>Email</option>
                                </select>
                                <label>Preferred Contact Method</label>
                            </span>
                            <div>Portal:
                                <span style="color:#933; float:none;">
                                    <?php
                                    if ($themyarray['use_patient_portal'] == 1) {
                                        switch ($themyarray['registration_status']) {
                                            case 0:
                                                echo 'Unregistered';
                                                break;
                                            case 1:
                                                echo 'Registration Emailed '.date('m/d/Y h:i a', strtotime($themyarray['registration_senton'])) . ' ET';
                                                break;
                                            case 2:
                                                echo 'Registered';
                                                break;
                                        }
                                    } else {
                                        echo 'Patient Portal In-active';
                                    } ?>
                                </span>
                                <br />
                                <input type="submit" name="sendPin" value="Patient can't receive text message?" class="button" />
                                <?php
                                if ($themyarray['registration_status'] == 1) { ?>
                                    PIN Code: <b id="access-code"><?= $themyarray['access_code']; ?></b>
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">Address <span id="req_0" class="req">*</span></label>
                        <div>
                            <span>
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="<?= $add1 ?>" style="width:225px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="<?= $add2 ?>" style="width:175px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="<?= $city ?>" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" autocomplete="off" class="field text addr tbox" value="<?= $state ?>" style="width:25px;" maxlength="2" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="<?= $zip ?>" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip / Post Code </label>
                            </span>
                            <?php
                            $loc_sql = "SELECT * FROM dental_locations WHERE docid='".(!empty($docid) ? $docid : '')."'";
                            $loc_q = $db->getResults($loc_sql);
                            $num_loc = count($loc_q);
                            if ($num_loc >= 1) { ?>
                                <span>
                                    <select name="location">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($loc_q as $loc_r) { ?>
                                            <option <?= ($location == $loc_r['id'] || ($loc_r['default_location'] == 1 && !isset($_GET['pid']))) ? 'selected="selected"' : ''; ?>value="<?= $loc_r['id']; ?>"><?= $loc_r['location']; ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                    <label for="location">Office Site</label>
                                </span>
                                <?php
                            } ?>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input id="dob" name="dob" type="text" class="field text addr tbox calendar" value="<?= $dob ?>" style="width:100px;" maxlength="255" onChange="validateDate('dob');" /><span id="req_0" class="req">*</span>
                                <label for="dob">Birthday</label>
                            </span>
                            <span>
                                <select name="gender" id="gender" class="field text addr tbox" style="width:100px;">
                                    <option value="">Select</option>
                                    <option value="Male" <?php if ($gender == 'Male') { echo " selected"; } ?>>Male</option>
                                    <option value="Female" <?php if ($gender == 'Female') { echo " selected"; } ?>>Female</option>
                                </select>
                                <span id="req_0" class="req">*</span>
                                <label for="gender">Gender</label>
                            </span>
                            <span style="width:150px">
                                <input id="ssn" name="ssn" type="text" class="ssnmask field text addr tbox" value="<?= $ssn ?>" maxlength="255" style="width:100px;" />
                                <label for="ssn">Social Security No.</label>
                            </span>
                            <span>
                                <select name="feet" id="feet" class="field text addr tbox" style="width:100px;" tabindex="5" onchange="cal_bmi();" >
                                    <option value="0">Feet</option>
                                    <?php
                                    for ($i = 1; $i < 9; $i++) { ?>
                                        <option value="<?= $i ?>" <?php if ($feet == $i) { echo " selected"; } ?>><?= $i ?></option>
                                        <?php
                                    }?>
                                </select>
                                <label for="feet">Height: Feet</label>
                            </span>
                            <span>
                                <select name="inches" id="inches" class="field text addr tbox" style="width:100px;" tabindex="6" onchange="cal_bmi();">
                                    <option value="-1">Inches</option>
                                    <?php
                                    for ($i = 0; $i < 12; $i++) { ?>
                                        <option value="<?= $i ?>" <?php if ($inches != '' && $inches == $i) echo " selected"; ?>><?= $i ?></option>
                                        <?php
                                    } ?>
                                </select>
                                <label for="inches">Inches</label>
                            </span>
                            <span>
                                <select name="weight" id="weight" class="field text addr tbox" style="width:100px;" tabindex="7" onchange="cal_bmi();">
                                    <option value="0">Weight</option>
                                    <?php
                                    for ($i = 80; $i <= 500; $i++) { ?>
                                        <option value="<?= $i ?>" <?php if ($weight == $i) { echo " selected"; } ?>><?= $i ?></option>
                                        <?php
                                    } ?>
                                </select>
                                <label for="weight">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            </span>
                            <span>
                                <span style="color:#000000; padding-top:2px;">BMI</span>
                                <input id="bmi" name="bmi" type="text" class="field text addr tbox" value="<?= $bmi ?>" tabindex="8" maxlength="255" style="width:50px;" readonly="readonly" />
                            </span>
                            <span>
                                <label for="bmi">
                                    &lt; 18.5 is Underweight
                                    <br />
                                    &nbsp;&nbsp;&nbsp;
                                    18.5 - 24.9 is Normal
                                    <br />
                                    &nbsp;&nbsp;&nbsp;
                                    25 - 29.9 is Overweight
                                    <br />
                                    &gt; 30 is Obese
                                </label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="frmhead">
                <ul>
                    <li>
                        <div>
                            <span>
                                <select name="marital_status" id="marital_status" class="field text addr tbox" style="width:130px;" >
                                    <option value="">Select</option>
                                    <option value="Married" <?php if ($marital_status == 'Married') { echo " selected"; } ?>>Married</option>
                                    <option value="Single" <?php if ($marital_status == 'Single') { echo " selected"; } ?>>Single</option>
                                    <option value="Life Partner" <?php if ($marital_status == 'Life Partner') { echo " selected"; } ?>>Life Partner</option>
                                    <option value="Minor" <?php if ($marital_status == 'Minor') { echo " selected"; } ?>>Minor</option>
                                </select>
                                <label for="marital_status">Marital Status</label>
                            </span>
                            <span>
                                <input id="partner_name" name="partner_name" type="text" class="field text addr tbox" value="<?= $partner_name ?>"  maxlength="255" />
                                <label for="partner_name">Partner/Guardian Name</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
            <td valign="top" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <textarea name="patient_notes"  id="patient_notes" class="field text addr tbox" style="width:410px;" ><?= $patient_notes; ?></textarea>
                                <label for="patient_notes">Patient Notes</label>
                            </span>
                        </div>
                        <div class="alert-text">
                            <span>
                                <label for="alert_text" style="display: inline">Patient alert (display text notification at top of chart)?</label>
                                <input type="radio" name="display_alert" value="1" onclick="$('#alert_text').show()" <?= ($display_alert) ? 'checked="checked"' : ''; ?>>Yes
                                <input type="radio" name="display_alert" value="0" onclick="$('#alert_text').hide()" <?= (!$display_alert) ? 'checked="checked"' : ''; ?>>No
                            </span>
                            <textarea name="alert_text" id="alert_text" <?= ($display_alert) ? 'class="show-alert-text"' : 'class="hide-alert-text"'; ?>><?= $alert_text; ?></textarea>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">In case of an emergency</label>
                        <div>
                            <span>
                                <input id="emergency_name" name="emergency_name" type="text" class="field text addr tbox" value="<?= $emergency_name ?>" maxlength="255" style="width:200px;" />
                                <label for="emergency_name">Name</label>
                            </span>
                            <span>
                                <input id="emergency_relationship" name="emergency_relationship" type="text" class="field text addr tbox" value="<?php echo $emergency_relationship?>" maxlength="255" style="width:150px;" />
                                <label for="emergency_relationship">Relationship</label>
                            </span>
                            <span>
                                <input id="emergency_number" name="emergency_number" type="text" class="extphonemask field text addr tbox" value="<?php echo $emergency_number?>" maxlength="255" style="width:150px;" />
                                <label for="emergency_number">Number</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="color:#0a5da0; font-weight:bold; font-size:16px;">REFERRED BY</span>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">&nbsp;</label>
                        <div>
                            <div style="float:left;">
                                <?php
                                if (empty($copyreqdate)) {
                                    $copyreqdate = date('m/d/Y');
                                } ?>
                                <input id="copyreqdate" name="copyreqdate" type="text" class="field text addr tbox calendar" value="<?= $copyreqdate; ?>"  style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" />
                                <label>Date</label>
                            </div>
                            <div style="float:left;" id="referred_source_div">
                                <input name="referred_source_r" <?= ($referred_source == DSS_REFERRED_PATIENT||$referred_source == DSS_REFERRED_PHYSICIAN)?'checked="checked"':''; ?> type="radio" value="person" onclick="show_referredby('person', '')" /> Person
                                <input id="referred_source_r_media" name="referred_source_r" <?= ($referred_source == DSS_REFERRED_MEDIA)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_MEDIA; ?>" onclick="show_referredby('notes', <?= DSS_REFERRED_MEDIA; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_MEDIA]; ?>
                                <input name="referred_source_r" <?= ($referred_source == DSS_REFERRED_FRANCHISE)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_FRANCHISE; ?>" onclick="show_referredby('notes',<?= DSS_REFERRED_FRANCHISE; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_FRANCHISE]; ?>
                                <input name="referred_source_r" <?= ($referred_source == DSS_REFERRED_DSSOFFICE)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_DSSOFFICE; ?>" onclick="show_referredby('notes',<?= DSS_REFERRED_DSSOFFICE; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_DSSOFFICE]; ?>
                                <input name="referred_source_r" <?= ($referred_source == DSS_REFERRED_OTHER)?'checked="checked"':''; ?> type="radio" value="<?= DSS_REFERRED_OTHER; ?>" onclick="show_referredby('notes',<?= DSS_REFERRED_OTHER; ?>)" /> <?= $dss_referred_labels[DSS_REFERRED_OTHER]; ?>
                            </div>
                            <div style="clear:both;float:left;">
                                <div id="referred_person" <?= ($referred_source != DSS_REFERRED_PATIENT && $referred_source != DSS_REFERRED_PHYSICIAN) ? 'style="display:none;margin-left:100px;"' : 'style="margin-left:100px"'; ?>>
                                    <input type="text" id="referredby_name" onclick="updateval(this)" autocomplete="off" name="referredby_name" value="<?= (!empty($referred_name)) ? $referred_name : 'Type referral name'; ?>" style="width:300px;" />
                                    <input type="button" class="button" style="width:150px;" onclick="loadPopupRefer('add_contact.php?addtopat=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&from=add_patient');" value="+ Create New Contact" />
                                    <br />
                                    <div id="referredby_hints" class="search_hints" style="margin-top:20px; display:none;">
                                        <ul id="referredby_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="referred_notes" <?= ($referred_source != DSS_REFERRED_MEDIA && $referred_source != DSS_REFERRED_FRANCHISE && $referred_source != DSS_REFERRED_DSSOFFICE && $referred_source != DSS_REFERRED_OTHER) ? 'style="display:none;margin-left:200px;"' : 'style="margin-left:200px;"'; ?>>
                                    <textarea name="referred_notes" style="width:300px;"><?= $referred_notes; ?></textarea>
                                </div>
                                <input type="hidden" name="referred_by" id="referred_by" value="<?= $referred_by; ?>" />
                                <input type="hidden" name="referred_source" id="referred_source" value="<?= $referred_source; ?>" />
                            </div>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="color:#0a5da0; font-weight:bold; font-size:16px;">EMPLOYER</span>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">Employer Information</label>
                        <div>
                            <span>
                                <input id="employer" name="employer" type="text" class="field text addr tbox" value="<?= $employer; ?>" style="width:325px;" maxlength="255" />
                                <label for="employer">Employer</label>
                            </span>
                            <span>
                                <input id="emp_phone" name="emp_phone" type="text" class="extphonemask field text addr tbox" value="<?= $emp_phone ?>" style="width:150px;" maxlength="255" />
                                <label for="emp_phone">&nbsp;&nbsp;Phone</label>
                            </span>
                            <span>
                                <input id="emp_fax" name="emp_fax" type="text" class="phonemask field text addr tbox" value="<?= $emp_fax ?>" style="width:120px;" maxlength="255" />
                                <label for="emp_fax">Fax</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="emp_add1" name="emp_add1" type="text" class="field text addr tbox" value="<?= $emp_add1 ?>" style="width:225px;" maxlength="255" />
                                <label for="emp_add1">Address1</label>
                            </span>
                            <span>
                                <input id="emp_add2" name="emp_add2" type="text" class="field text addr tbox" value="<?= $emp_add2 ?>" style="width:175px;" maxlength="255" />
                                <label for="emp_add2">Address2</label>
                            </span>
                            <span>
                                <input id="emp_city" name="emp_city" type="text" class="field text addr tbox" value="<?= $emp_city ?>" style="width:200px;" maxlength="255" />
                                <label for="emp_city">City</label>
                            </span>
                            <span>
                                <input id="emp_state" name="emp_state" type="text" autocomplete="off" class="field text addr tbox" value="<?= $emp_state ?>" style="width:80px;" maxlength="255" />
                                <label for="emp_state">State</label>
                            </span>
                            <span>
                                <input id="emp_zip" name="emp_zip" type="text" class="field text addr tbox" value="<?= $emp_zip ?>" style="width:80px;" maxlength="255" />
                                <label for="emp_zip">Zip Code </label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a name="p_m_ins"></a>
                <span style="color:#0a5da0; font-weight:bold; font-size:16px;">INSURANCE</span>
            </td>
        </tr>
        <?php
        $api_sql = "
            SELECT use_eligible_api FROM dental_users
            WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'
        ";
        $api_r = $db->getRow($api_sql);
        if ($api_r['use_eligible_api'] == 1) { ?>
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    Insurance Co.
                    <input type="text" id="ins_payer_name" onclick="updateval(this)" autocomplete="off" name="ins_payer_name" value="<?= ($p_m_eligible_payer_id != '') ? $p_m_eligible_payer_id.' - '.$p_m_eligible_payer_name : 'Type insurance payer name'; ?>" style="width:300px;" />
                    <br />
                    <div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                        <ul id="ins_payer_list" class="search_list">
                            <li class="template" style="display:none"></li>
                        </ul>
                    </div>
                    <input type="hidden" name="p_m_eligible_payer" id="p_m_eligible_payer" value="<?= $p_m_eligible_payer_id."-".$p_m_eligible_payer_name; ?>" />
                </td>
            </tr>
            <?php
        } ?>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc" id="title0" for="Field0">Primary Medical &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            if ($exclusive_billing) { ?>
                                <?= $billing_co ?> filing insurance
                                <?php
                            } else { ?>
                                <a onclick="return false;" class="plain" title="Select YES if you would like <?= $billing_co; ?> to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended)."><?= $billing_co; ?> filing insurance?</a>
                                <input id="p_m_dss_file_yes" class="dss_file_radio" type="radio" name="p_m_dss_file" value="1" <?php if ($p_m_dss_file == '1') { echo "checked='checked'"; } ?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                <input id="p_m_dss_file_no" class="dss_file_radio" type="radio" name="p_m_dss_file" value="2" <?php if ($p_m_dss_file == '2') { echo "checked='checked'"; } ?>>No
                                <?php
                            } ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a onclick="return false" class="plain" title="Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO.">Insured Address same as Pt. address?</a>
                            <input type="radio" onclick="$('#p_m_address_fields').hide();" name="p_m_same_address" value="1" <?php if ($p_m_same_address !== '2') { echo "checked='checked'"; } ?>> Yes
                            <input type="radio" onclick="$('#p_m_address_fields').show();" name="p_m_same_address" value="2" <?php if ($p_m_same_address == '2') { echo "checked='checked'"; } ?>> No
                        </label>
                        <div>
                            <span>
                                <select id="p_m_relation" name="p_m_relation" class="field text addr tbox" style="width:200px;">
                                    <option value="" <?php if ($p_m_relation == '') { echo " selected"; } ?>>None</option>
                                    <option value="Self" <?php if ($p_m_relation == 'Self') { echo " selected"; } ?>>Self</option>
                                    <option value="Spouse" <?php if ($p_m_relation == 'Spouse') { echo " selected"; } ?>>Spouse</option>
                                    <option value="Child" <?php if ($p_m_relation == 'Child') { echo " selected"; } ?>>Child</option>
                                    <option value="Other" <?php if ($p_m_relation == 'Other') { echo " selected"; } ?>>Other</option>
                                </select>
                                <label for="work_phone">Relationship to insured party</label>
                            </span>
                            <span>
                                <input id="p_m_partyfname" name="p_m_partyfname" type="text" class="field text addr tbox" value="<?= $p_m_partyfname ?>" maxlength="255" style="width:150px;" />
                                <input id="p_m_partymname" name="p_m_partymname" type="text" class="field text addr tbox" value="<?= $p_m_partymname ?>" maxlength="255" style="width:50px;" />
                                <input id="p_m_partylname" name="p_m_partylname" type="text" class="field text addr tbox" value="<?= $p_m_partylname ?>" maxlength="255" style="width:150px;" />
                                <label for="p_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
                            <span>
                                <input id="ins_dob" name="ins_dob" type="text" class="field text addr tbox calendar" value="<?= $ins_dob ?>" maxlength="255" style="width:150px;" onChange="validateDate('ins_dob');" />
                                <label for="ins_dob">Insured Date of Birth</label>
                            </span>
                            <span>
                                <select name="p_m_gender" id="p_m_gender" class="field text addr tbox" style="width:100px;" >
                                    <option value="">Select</option>
                                    <option value="Male" <?php if ($p_m_gender == 'Male') { echo " selected"; } ?>>Male</option>
                                    <option value="Female" <?php if ($p_m_gender == 'Female') { echo " selected"; } ?>>Female</option>
                                </select>
                                <span id="req_0" class="req">*</span>
                                <label for="p_m_gender">Insured Gender</label>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul id="p_m_address_fields" <?= ($p_m_same_address == "1") ? 'style="display:none;"' : ''; ?>>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input id="p_m_address" name="p_m_address" type="text" class="field text addr tbox" value="<?= $p_m_address ?>" style="width:225px;" maxlength="255" />
                                <label for="p_m_address">Insured Address</label>
                            </span>
                            <span>
                                <input id="p_m_city" name="p_m_city" type="text" class="field text addr tbox" value="<?= $p_m_city ?>" style="width:200px;" maxlength="255" />
                                <label for="p_m_city">Insured City</label>
                            </span>
                            <span>
                                <input id="p_m_state" name="p_m_state" type="text" autocomplete="off" class="field text addr tbox" value="<?= $p_m_state ?>" style="width:80px;" maxlength="2" />
                                <label for="p_m_state">Insured State</label>
                            </span>
                            <span>
                                <input id="p_m_zip" name="p_m_zip" type="text" class="field text addr tbox" value="<?= $p_m_zip ?>" style="width:80px;" maxlength="255" />
                                <label for="p_m_zip">Insured Zip Code </label>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <select id="p_m_ins_type" name="p_m_ins_type" class="field text addr tbox" onchange="update_insurance_type()" style="width:200px;">
                                    <option value=""></option>
                                    <option value="1" <?php if ($p_m_ins_type == '1') { echo " selected='selected'"; } ?>>Medicare</option>
                                    <option value="2" <?php if ($p_m_ins_type == '2') { echo " selected='selected'"; } ?>>Medicaid</option>
                                    <option value="3" <?php if ($p_m_ins_type == '3') { echo " selected='selected'"; } ?>>Tricare Champus</option>
                                    <option value="4" <?php if ($p_m_ins_type == '4') { echo " selected='selected'"; } ?>>Champ VA</option>
                                    <option value="5" <?php if ($p_m_ins_type == '5') { echo " selected='selected'"; } ?>>Group Health Plan</option>
                                    <option value="6" <?php if ($p_m_ins_type == '6') { echo " selected='selected'"; } ?>>FECA BLKLUNG</option>
                                    <option value="7" <?php if ($p_m_ins_type == '7') { echo " selected='selected'"; } ?>>Other</option>
                                </select>
                                <label for="p_m_ins_type">Insurance Type</label>
                            </span>
                            <span>
                                <input class="p_m_ins_ass" id="p_m_ins_ass_yes" type="radio" name="p_m_ins_ass" value="Yes" <?php if ($p_m_ins_ass == 'Yes') { echo " checked='checked'"; } ?>>Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="p_m_ins_ass pay_to_patient_radio" id="p_m_ins_ass_no" type="radio" name="p_m_ins_ass" value="No" <?php if ($p_m_ins_ass == 'No') { echo " checked='checked'"; } ?>>Payment to Patient
                            </span>
                            <span style="float:right">
                                <?php
                                $itype_sql = "select * from dental_q_image where imagetypeid=10 AND patientid=".$pid." ORDER BY adddate DESC LIMIT 1";
                                $image = $db->getRow($itype_sql);
                                if (!$image) { ?>
                                    <button id="p_m_ins_card" onclick="loadPopup('add_image.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&sh=<?= (isset($_GET['sh'])) ? $_GET['sh'] : ''; ?>&it=10&return=patinfo');return false;" class="addButton">
                                        + Add Insurance Card Image
                                    </button>
                                    <?php
                                } else { ?>
                                    <button id="p_m_ins_card" onclick="window.open('display_file.php?f=<?= rawurlencode($image['image_file']) ?>','welcome','width=800,height=400,scrollbars=yes'); return false;" class="addButton">
                                        View Insurance Card Image
                                    </button>
                                    <?php
                                } ?>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <select id="p_m_ins_co" name="p_m_ins_co" class="field text addr tbox" onchange="updateNumber('p_m_ins_phone');" style="width:200px;">
                                    <option value="">Select Insurance Company</option>
                                    <?php
                                    $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE status=1 AND merge_id IS NULL AND contacttypeid = '11' AND docid='".$_SESSION['docid']."' order by company ASC";
                                    $ins_contact_qry_run = $db->getResults($ins_contact_qry);
                                    if ($ins_contact_qry_run) {
                                        foreach ($ins_contact_qry_run as $ins_contact_res) { ?>
                                            <option value="<?= $ins_contact_res['contactid']; ?>" <?php if ($p_m_ins_co == $ins_contact_res['contactid']) { echo 'selected="selected"'; } ?>><?= addslashes($ins_contact_res['company']); ?></option>
                                            <?php
                                        }
                                    } ?>
                                </select>
                                <label for="p_m_ins_co">Insurance Co.</label><br />
                                <input type="button" class="button" style="width:215px;" onclick="loadPopupRefer('add_contact.php?from=add_patient&from_id=p_m_ins_co&ctype=ins<?php if (isset($_GET['pid'])) { echo "&pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid'];} ?>');" value="+ Create New Insurance Company" />
                            </span>
                            <span>
                                <input id="p_m_party" name="p_m_ins_id" type="text" class="field text addr tbox" value="<?= $p_m_ins_id ?>" maxlength="255" style="width:190px;" />
                                <label for="p_m_ins_id">Insurance ID.</label>
                            </span>
                            <span>
                                <input
                                    id="p_m_ins_grp"
                                    name="p_m_ins_grp"
                                    type="text"
                                    class="field text addr tbox"
                                    <?php
                                    if ($p_m_ins_type == '1') { ?>
                                        value="NONE"
                                        readonly="readonly"
                                        <?php
                                    } else { ?>
                                        value="<?= $p_m_ins_grp?>"
                                        <?php
                                    } ?>
                                    maxlength="255"
                                    style="width:100px;"
                                />
                                <label for="p_m_ins_grp">Group #</label>
                            </span>
                            <span>
                                <input
                                    id="p_m_ins_plan"
                                    name="p_m_ins_plan"
                                    type="text"
                                    class="field text addr tbox"
                                    <?php
                                    if ($p_m_ins_type == '1') { ?>
                                        value=""
                                        readonly="readonly"
                                        <?php
                                    } else { ?>
                                        value="<?= $p_m_ins_plan ?>"
                                        <?php
                                    } ?>
                                    maxlength="255"
                                    style="width:200px;"
                                />
                                <label for="p_m_ins_plan">Plan Name</label>
                            </span>
                            <span>
                                <textarea id="p_m_ins_phone" name="p_m_ins_phone" class="field text addr tbox" disabled="disabled" style="width:190px;height:60px;background:#ccc;"></textarea>
                                <label for="p_m_ins_phone">Address</label>
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <div style="height:40px;display:block;">
                            <span>
                                <label style="display:inline;">Does patient have secondary insurance?</label>
                                <input type="radio" value="Yes" <?= ($has_s_m_ins == "Yes") ? 'checked="checked"' : ''; ?> name="s_m_ins" onclick="$('.s_m_ins_div').show();" /> Yes
                                <input type="radio" value="No" <?= ($has_s_m_ins != "Yes") ? 'checked="checked"' : ''; ?> name="s_m_ins" onclick="$('.s_m_ins_div').hide(); $('#s_m_address_fields').hide();" /> No
                            </span>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <?php
        if ($api_r['use_eligible_api'] == 1) { ?>
            <tr>
                <td valign="top" colspan="2" class="frmhead">
                    Insurance Co.
                    <input type="text" id="s_m_ins_payer_name" onclick="updateval(this)" autocomplete="off" name="s_m_ins_payer_name" value="<?= ($s_m_eligible_payer_id != '') ? $s_m_eligible_payer_id.' - '.$s_m_eligible_payer_name : 'Type insurance payer name'; ?>" style="width:300px;" />
                    <br />
                    <div id="s_m_ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                        <ul id="s_m_ins_payer_list" class="search_list">
                            <li class="template" style="display:none"></li>
                        </ul>
                    </div>
                    <input type="hidden" name="s_m_eligible_payer" id="s_m_eligible_payer" value="<?= $s_m_eligible_payer_id."-".$s_m_eligible_payer_name; ?>" />
                </td>
            </tr>
            <?php
        } ?>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">
                        <label class="desc s_m_ins_div" id="title0" for="Field0" <?= ($has_s_m_ins != "Yes") ? 'style="display:none;"' : ''; ?>>
                            Secondary Medical&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            if ($exclusive_billing) { ?>
                                <?= $billing_co ?> filing insurance
                                <?php
                            } else { ?>
                                <a onclick="return false;" class="plain" title="Select YES if you would like <?= $billing_co; ?> to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended)."><?= $billing_co; ?> filing insurance?</a>
                                <input id="s_m_dss_file_yes" type="radio" class="dss_file_radio" name="s_m_dss_file" value="1" <?php if ($s_m_dss_file == '1') { echo "checked='checked'"; } ?> />Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                <input id="s_m_dss_file_no" type="radio" class="dss_file_radio" name="s_m_dss_file" value="2" <?php if ($s_m_dss_file == '2') { echo "checked='checked'"; } ?> />No
                                <?php
                            } ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a onclick="return false" class="plain" title="Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO.">Insured Address same as Pt. address?</a>
                            <input type="radio" onclick="$('#s_m_address_fields').hide();" name="s_m_same_address" value="1" <?php if ($s_m_same_address !== '2') { echo "checked='checked'"; } ?> /> Yes
                            <input type="radio" onclick="$('#s_m_address_fields').show();" name="s_m_same_address" value="2" <?php if ($s_m_same_address == '2') { echo "checked='checked'"; } ?> /> No
                        </label>
                        <div class="s_m_ins_div" <?= ($has_s_m_ins != "Yes") ? 'style="display:none;"' : ''; ?>>
                            <span>
                                <select id="s_m_relation" name="s_m_relation" class="field text addr tbox" style="width:200px;">
                                    <option value="" <?php if ($s_m_relation == '') { echo " selected"; } ?>>None</option>
                                    <option value="Self" <?php if ($s_m_relation == 'Self') { echo " selected"; } ?>>Self</option>
                                    <option value="Spouse" <?php if ($s_m_relation == 'Spouse') { echo " selected"; } ?>>Spouse</option>
                                    <option value="Child" <?php if ($s_m_relation == 'Child') { echo " selected"; } ?>>Child</option>
                                    <option value="Other" <?php if ($s_m_relation == 'Other') { echo " selected"; } ?>>Other</option>
                                </select>
                                <label for="s_m_relation">Relationship to insured party</label>
                            </span>
                            <span>
                                <input id="s_m_partyfname" name="s_m_partyfname" type="text" class="field text addr tbox" value="<?= $s_m_partyfname?>" maxlength="255" style="width:150px;" />
                                <input id="s_m_partymname" name="s_m_partymname" type="text" class="field text addr tbox" value="<?= $s_m_partymname?>" maxlength="255" style="width:50px;" />
                                <input id="s_m_partylname" name="s_m_partylname" type="text" class="field text addr tbox" value="<?= $s_m_partylname?>" maxlength="255" style="width:150px;" />
                                <label for="s_m_partyfname">Insured party First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Middle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last</label>
                            </span>
                            <span>
                                <input id="ins2_dob" name="ins2_dob" type="text" class="field text addr tbox calendar" value="<?= $ins2_dob?>" maxlength="255" style="width:150px;" onChange="validateDate('ins2_dob');" />
                                <label for="ins2_dob">Insured Date of Birth</label>
                            </span>
                            <span>
                                <select name="s_m_gender" id="s_m_gender" class="field text addr tbox" style="width:100px;" >
                                    <option value="">Select</option>
                                    <option value="Male" <?php if ($s_m_gender == 'Male') { echo " selected"; } ?>>Male</option>
                                    <option value="Female" <?php if ($s_m_gender == 'Female') { echo " selected"; } ?>>Female</option>
                                </select>
                                <span id="req_0" class="req">*</span>
                                <label for="s_m_gender">Insured Gender</label>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul id="s_m_address_fields" <?= ($s_m_same_address == "1" || $has_s_m_ins != "Yes") ? 'style="display:none;"' : ''; ?>>
                    <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input id="s_m_address" name="s_m_address" type="text" class="field text addr tbox" value="<?= $s_m_address ?>" style="width:225px;"  maxlength="255" />
                                <label for="s_m_address">Insured Address</label>
                            </span>
                            <span>
                                <input id="s_m_city" name="s_m_city" type="text" class="field text addr tbox" value="<?= $s_m_city ?>" style="width:200px;" maxlength="255" />
                                <label for="s_m_city">Insured City</label>
                            </span>
                            <span>
                                <input id="s_m_state" name="s_m_state" type="text" autocomplete="off" class="field text addr tbox" value="<?= $s_m_state ?>" style="width:80px;" maxlength="2" />
                                <label for="s_m_state">Insured State</label>
                            </span>
                            <span>
                                <input id="s_m_zip" name="s_m_zip" type="text" class="field text addr tbox" value="<?= $s_m_zip ?>" style="width:80px;" maxlength="255" />
                                <label for="s_m_zip">Insured Zip Code </label>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul>
                    <li id="foli8" class="complex">
                        <div  class="s_m_ins_div" <?= ($has_s_m_ins != "Yes") ? 'style="display:none;"' : ''; ?>>
                            <span>
                                <select id="s_m_ins_type" name="s_m_ins_type" onchange="checkMedicare()" class="field text addr tbox" style="width:200px;">
                                    <option value=""></option>
                                    <option value="1" <?php if ($s_m_ins_type == '1') { echo " selected='selected'"; } ?>>Medicare</option>
                                    <option value="2" <?php if ($s_m_ins_type == '2') { echo " selected='selected'"; } ?>>Medicaid</option>
                                    <option value="3" <?php if ($s_m_ins_type == '3') { echo " selected='selected'"; } ?>>Tricare Champus</option>
                                    <option value="4" <?php if ($s_m_ins_type == '4') { echo " selected='selected'"; } ?>>Champ VA</option>
                                    <option value="5" <?php if ($s_m_ins_type == '5') { echo " selected='selected'"; } ?>>Group Health Plan</option>
                                    <option value="6" <?php if ($s_m_ins_type == '6') { echo " selected='selected'"; } ?>>FECA BLKLUNG</option>
                                    <option value="7" <?php if ($s_m_ins_type == '7') { echo " selected='selected'"; } ?>>Other</option>
                                </select>
                                <label for="s_m_ins_type">Insurance Type</label>
                            </span>
                            <span>
                                <input id="s_m_ins_ass_yes" type="radio" name="s_m_ins_ass" value="Yes" <?php if ($s_m_ins_ass == 'Yes') { echo " checked='checked'"; } ?> />Accept Assignment of Benefits &nbsp;&nbsp;&nbsp;&nbsp;
                                <input id="s_m_ins_ass_no pay_to_patient_radio" type="radio" name="s_m_ins_ass" value="No" <?php if ($s_m_ins_ass == 'No') { echo " checked='checked'"; } ?> />Payment to Patient
                            </span>
                            <span style="float:right">
                                <?php
                                $itype_sql = "select * from dental_q_image where imagetypeid=12 AND patientid=".$pid." ORDER BY adddate DESC LIMIT 1";
                                $image = $db->getRow($itype_sql);
                                if (!$image) { ?>
                                    <button id="s_m_ins_card" onclick="loadPopup('add_image.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&sh=<?= (isset($_GET['sh'])) ? $_GET['sh'] : ''; ?>&it=12&return=patinfo');return false;" class="addButton">
                                        + Add Insurance Card Image
                                    </button>
                                    <?php
                                } else { ?>
                                    <button id="s_m_ins_card" onclick="window.open('display_file.php?f=<?= rawurlencode($image['image_file']) ?>','welcome','width=800,height=400,scrollbars=yes'); return false;" class="addButton">
                                        View Insurance Card Image
                                    </button>
                                    <?php
                                } ?>
                            </span>
                        </div>
                    </li>
                </ul>
                <ul>
                    <li id="foli8" class="complex">
                        <div class="s_m_ins_div" style="position:relative;<?= $has_s_m_ins != 'Yes' ? 'display:none;' : '' ?>">
                            <span>
                                <select id="s_m_ins_co" name="s_m_ins_co" class="field text addr tbox" style="width:200px;" onchange="updateNumber2('s_m_ins_phone')">
                                    <option value="">Select Insurance Company</option>
                                    <script type="text/javascript">
                                        insurance_nums = [];
                                        <?php
                                        $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE status=1 AND merge_id IS NULL AND contacttypeid = '11' AND docid='".$_SESSION['docid']."' ORDER BY company ASC";
                                        $ins_contact_qry_run = $db->getResults($ins_contact_qry);
                                        if ($ins_contact_qry_run) {
                                            foreach ($ins_contact_qry_run as $ins_contact_res) { ?>
                                                insurance_nums[<?= $ins_contact_res['contactid']; ?>] = "<?= $ins_contact_res['add1']; ?>\n<?= $ins_contact_res['add2']; ?><?= ($ins_contact_res['add2']) ? '\n' : ''; ?><?= $ins_contact_res['city']; ?> <?= $ins_contact_res['state']; ?> <?= $ins_contact_res['zip']; ?>\n<?= format_phone($ins_contact_res['phone1']); ?>"
                                                document.write('<option value="<?= $ins_contact_res['contactid']; ?>" <?php if ($s_m_ins_co == $ins_contact_res['contactid']) { echo 'selected="selected"'; } ?>><?= addslashes($ins_contact_res['company']); ?></option>');
                                                <?php
                                            }
                                        } ?>
                                    </script>
                                </select>
                                <label for="s_m_ins_co">Insurance Co.</label><br />
                                <input type="button" class="button" style="width:215px;" onclick="loadPopupRefer('add_contact.php?from=add_patient&from_id=s_m_ins_co&ctype=ins<?php if (isset($_GET['pid'])) { echo "&pid=".$_GET['pid']."&type=11&ctypeeq=1&activePat=".$_GET['pid']; } ?>');" value="+ Create New Insurance Company" />
                            </span>
                            <span>
                                <input id="s_m_party" name="s_m_ins_id" type="text" class="field text addr tbox" value="<?= $s_m_ins_id ?>" maxlength="255" style="width:190px;" />
                                <label for="s_m_ins_id">Insurance ID.</label>
                            </span>
                            <span>
                                <input id="s_m_ins_grp" name="s_m_ins_grp" type="text" class="field text addr tbox" value="<?= $s_m_ins_grp ?>" maxlength="255" style="width:100px;" />
                                <label for="s_m_ins_grp">Group #</label>
                            </span>
                            <span>
                                <input id="s_m_ins_plan" name="s_m_ins_plan" type="text" class="field text addr tbox" value="<?= $s_m_ins_plan ?>" maxlength="255" style="width:200px;" />
                                <label for="s_m_ins_plan">Plan Name</label>
                            </span>
                            <span>
                                <textarea id="s_m_ins_phone" name="s_m_ins_phone" type="text" class="field text addr tbox" disabled="disabled" style="width:190px;height:60px;background:#ccc;"></textarea>
                                <label for="s_m_ins_phone">Address</label>
                            </span>
                            <button id="clear-secondary-insurance" class="button" style="position:absolute;bottom:5px;right:5px;" onclick="if (confirm('Empty all fields in Secondary Insurance?')) { clearInfo(); } return false;">
                                &mdash; Clear All Values
                            </button>
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="color:#0a5da0; font-weight:bold; font-size:16px;">CONTACT SECTION</span>
            </td>
        </tr>
        <tr>
            <td class="frmhead" colspan="2">
                <table id="contactmds" style="float:left;">
                    <tr>
                        <td>
                            <span style="padding-left:10px; float:left;">Add medical contacts so they can receive correspondence about this patient.</span>
                            <span style="float:left; margin-left:20px;"><input type="button" class="button" style="float:left; width:150px;" onclick="loadPopupRefer('add_contact.php?addtopat=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&from=add_patient');" value="+ Create New Contact" /></span>
                            <ul>
                                <li  id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Primary Care MD</label>
                                    <div id="docpcp_static_info" style="<?php echo ($docpcp!='')?'':'display:none'; ?>">
                                        <span id="docpcp_name_static" style="width:300px;"><?= $docpcp_name; ?></span>
                                        <a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docpcp;?>');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docpcp_static_info').hide();$('#docpcp_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docpcp_name" style="width:300px;<?php echo ($docpcp!='')?'display:none;':'';?>" onclick="updateval(this)" autocomplete="off" name="docpcp_name" value="<?= ($docpcp != '') ? $docpcp_name : 'Type contact name'; ?>" />
                                    <br />
                                    <div id="docpcp_hints" class="search_hints" style="display:none;">
                                        <ul id="docpcp_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docpcp" id="docpcp" value="<?= $docpcp; ?>" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">ENT</label>
                                    <div id="docent_static_info" style="<?php echo ($docent!='')?'':'display:none'; ?>">
                                        <span id="docent_name_static" style="width:300px;"><?= $docent_name; ?></span>
                                        <a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docent; ?>');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docent_static_info').hide();$('#docent_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docent_name" style="width:300px;<?php echo ($docent!='')?'display:none':''; ?>" onclick="updateval(this)" autocomplete="off" name="docent_name" value="<?= ($docent != '') ? $docent_name : 'Type contact name'; ?>" />
                                    <br />
                                    <div id="docent_hints" class="search_hints" style="display:none;">
                                        <ul id="docent_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docent" id="docent" value="<?= $docent; ?>" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Sleep MD</label>
                                    <div id="docsleep_static_info" style="<?php echo ($docsleep!='')?'':'display:none'; ?>">
                                        <span id="docsleep_name_static" style="width:300px;"><?= $docsleep_name; ?></span>
                                        <a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docsleep; ?>');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docsleep_static_info').hide();$('#docsleep_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docsleep_name" style="width:300px;<?php echo ($docsleep!='')?'display:none':''; ?>" onclick="updateval(this)" autocomplete="off" name="docsleep_name" value="<?= ($docsleep != '') ? $docsleep_name : 'Type contact name'; ?>" />
                                    <br />
                                    <div id="docsleep_hints" class="search_hints" style="display:none;">
                                        <ul id="docsleep_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docsleep" id="docsleep" value="<?= $docsleep; ?>" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <ul>
                                <li  id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Dentist</label>
                                    <div id="docdentist_static_info" style="<?php echo ($docdentist!='')?'':'display:none'; ?>">
                                        <span id="docdentist_name_static" style="width:300px;"><?= $docdentist_name; ?></span>
                                        <a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docdentist; ?>');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docdentist_static_info').hide();$('#docdentist_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docdentist_name" style="width:300px;<?php echo ($docdentist!='')?'display:none':''; ?>" onclick="updateval(this)" autocomplete="off" name="docdentist_name" value="<?= ($docdentist != '') ? $docdentist_name : 'Type contact name'; ?>" />
                                    <br />
                                    <div id="docdentist_hints" class="search_hints" style="display:none;">
                                        <ul id="docdentist_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docdentist" id="docdentist" value="<?= $docdentist; ?>" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Other MD</label>
                                    <div id="docmdother_static_info" style="<?php echo ($docmdother!='')?'':'display:none;'; ?>height:25px;">
                                        <span id="docmdother_name_static" style="width:300px;"><?= $docmdother_name; ?></span>
                                        <a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother; ?>');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docmdother_static_info').hide();$('#docmdother_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docmdother_name" style="width:300px;<?php echo ($docmdother!='')?'display:none':''; ?>" onclick="updateval(this)" autocomplete="off" name="docmdother_name" value="<?= ($docmdother != '') ? $docmdother_name : 'Type contact name'; ?>" />
                                    <?php
                                    if ($docmdother2 == '' || $docmdother3 == '') { ?>
                                        <a href="#" id="add_new_md" onclick="add_md(); return false;"  style="clear:both" class="addButton">+ Add Additional MD</a>
                                        <?php
                                    } ?>
                                    <br />
                                    <div id="docmdother_hints" class="search_hints" style="display:none;">
                                        <ul id="docmdother_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docmdother" id="docmdother" value="<?= $docmdother; ?>" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr id="docmdother2_tr" <?= ($docmdother2 == '') ? 'style="display:none;"' : ''; ?>>
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Other MD 2</label>
                                    <div id="docmdother2_static_info" style="<?php echo ($docmdother2!='')?'':'display:none'; ?>">
                                        <span id="docmdother2_name_static" style="width:300px;"><?= $docmdother2_name; ?></span>
                                        <a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother2; ?>');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docmdother2_static_info').hide();$('#docmdother2_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docmdother2_name" style="width:300px;<?php echo ($docmdother2!='')?'display:none':''; ?>" onclick="updateval(this)" autocomplete="off" name="docmdother2_name" value="<?= ($docmdother2 != '') ? $docmdother2_name : 'Type contact name'; ?>" />
                                    <br />
                                    <div id="docmdother2_hints" class="search_hints" style="display:none;">
                                        <ul id="docmdother2_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docmdother2" id="docmdother2" value="<?= $docmdother2; ?>" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr id="docmdother3_tr" <?= ($docmdother3 == '') ? 'style="display:none;"' : ''; ?>>
                        <td>
                            <ul>
                                <li id="foli8" class="complex">
                                    <label style="display: block; float: left; width: 110px;">Other MD 3</label>
                                    <div id="docmdother3_static_info" style="<?php echo ($docmdother3!='')?'':'display:none'; ?>">
                                        <span id="docmdother3_name_static" style="width:300px;"><?= $docmdother3_name; ?></span>
                                        <a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother3; ?>');return false;" class="addButton">Quick View</a>
                                        <a href="#" onclick="$('#docmdother3_static_info').hide();$('#docmdother3_name').show();return false;" class="addButton">Change Contact</a>
                                    </div>
                                    <input type="text" id="docmdother3_name" style="width:300px;<?php echo ($docmdother3!='')?'display:none':''; ?>" onclick="updateval(this)" autocomplete="off" name="docmdother3_name" value="<?= ($docmdother3 != '') ? $docmdother3_name : 'Type contact name'; ?>" />
                                    <br />
                                    <div id="docmdother3_hints" class="search_hints" style="display:none;">
                                        <ul id="docmdother3_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="docmdother3" id="docmdother3" value="<?= $docmdother3; ?>" />
                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">Patient Status</td>
            <td valign="top" class="frmdata">
                <select name="status" id="status" class="tbox" onchange="updatePPAlert()">
                    <option value="1" <?php if ($status == 1) { echo " selected"; } ?>>Active</option>
                    <option value="2" <?php if ($status == 2) { echo " selected"; } ?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
        <?php
        if ($doc_patient_portal) { ?>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Portal Status
                    <br />
                    <span id="ppAlert" style="font-weight:normal;font-size:12px; <?php echo ($status == 2)?'':'display:none;'; ?>">Patient is in-active and will not be able to access<br />Patient Portal regardless of the setting of this field.</span>
                </td>
                <td valign="top" class="frmdata">
                    <select name="use_patient_portal" class="tbox">
                        <option value="1" <?php if ($use_patient_portal == 1) { echo " selected"; } ?>>Active</option>
                        <option value="0" <?php if ($use_patient_portal != '' && $use_patient_portal == 0) { echo " selected"; } ?>>In-Active</option>
                    </select>
                    <br />&nbsp;
                </td>
            </tr>
            <?php
        } ?>
        <tr>
            <td valign="top">
                <?php
                $sql = "SELECT generated_date FROM dental_letters WHERE templateid = '3' AND deleted = '0' AND patientid = '". (!empty($_GET['pid']) ? $_GET['pid'] : '') ."' ORDER BY generated_date ASC LIMIT 1;";
                $result = $db->getRow($sql);
                if (!$result) { ?>
                    <input id="introletter" name="introletter" type="checkbox" value="1" /> Send Intro Letter to DSS patient
                    <?php
                } else {
                    $date_generated = array_shift($result); ?>
                    DSS Intro Letter Sent to Patient <?= $date_generated ?>
                    <?php
                } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <span class="red">* Required Fields</span><br />
                <input type="hidden" name="patientsub" value="1" />
                <input type="hidden" name="ed" value="<?= $themyarray["patientid"] ?>" />
                <input type="submit" value=" <?= $but_text ?> Patient" class="button" />
            </td>
        </tr>
    </table>
</form>
</div>
<?php
if (!isset($_GET['noheaders'])) { ?>
    <div style="margin:0 auto;background:url(images/dss_05.png) no-repeat top left;width:980px; height:28px;"> </div>
    <?php
} ?>
  </td>
</tr>
<!-- Stick Footer Section Here -->
</table>
<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
<div id="popupRefer" style="height:550px; width:750px;">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>

<?php require_once __DIR__ . '/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/endpoint-permissions.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/endpoint-permissions-indicator.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>

<?php
if (isset($_REQUEST['readonly'])) { ?>
    <script type="text/javascript">
        $('input').attr('readonly', 'readonly');
        $('select').attr('disabled', 'disabled');
        $('input:submit, input:button, button, a').hide();
    </script>
    <?php
} ?>
</body>
</html>
