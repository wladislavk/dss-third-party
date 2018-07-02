<?php
namespace Ds3\Libraries\Legacy;

session_start();

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/password.php';
require_once __DIR__ . '/../includes/general_functions.php';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/includes/access.php';
require_once __DIR__ . '/includes/form_updates.php';
require_once __DIR__ . '/includes/edx_functions.php';
require_once __DIR__ . '/../includes/help_functions.php';
require_once __DIR__ . '/includes/javascript_includes.php';

$db = new Db();

$userId = intval(isset($_POST['ed']) ? $_POST['ed'] : $_GET['ed']);
$companyIds = $db->getRow("SELECT u.billing_company_id, uc.companyid
    FROM dental_users u
    LEFT JOIN dental_user_company uc ON u.userid = uc.userid
    WHERE u.userid = '$userId'");

$softwareCompanyId = array_get($companyIds, 'companyid');
$billingCompanyId = array_get($companyIds, 'billing_company_id');

/**
 * FO users can be edited by:
 *
 * 1: Super admin - No restrictions
 * 2: Admin - Company scope
 * 3: Basic admin - Company scope
 *
 * is_super() || (is_software() && WITHIN COMPANY SCOPE)
 */
$isSuperAdmin = is_super($_SESSION['admin_access']);
$isSoftwareAdmin = is_software($_SESSION['admin_access']);

$userCompanyId = $isSoftwareAdmin ? $softwareCompanyId : $billingCompanyId;
$isSameCompany = $_SESSION['admincompanyid'] == $userCompanyId;

$canEdit = $isSuperAdmin || $isSoftwareAdmin;
$canCreate = $isSuperAdmin || $isSoftwareAdmin;
$canView = $isSuperAdmin || $isSameCompany || (!$userId && $canCreate);

if (!$canView) { ?>
    <script>
        alert('You are not authorized to access this page.');
    </script>
    <?php
    trigger_error('Die called', E_USER_ERROR);
}

if (!empty($_POST["usersub"]) && $_POST["usersub"] == 1) {
    $userId = intval($_POST['ed']);

    if ($userId && !$canEdit) { ?>
        <script>
            alert('You are not authorized to edit this user.');
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }

    if (!$userId && !$canCreate) { ?>
        <script>
            alert('You are not authorized to create new users.');
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }

    if (isset($_POST['save_but']) || $_POST['username']!='') {
        $sel_check = "select * from dental_users where username = '".$db->escape(trim($_POST["username"]))."' and userid != '".$db->escape($_POST['ed'])."'";
        $query_check=mysqli_query($con,$sel_check);

        if(mysqli_num_rows($query_check)>0) {
            $msg="Username already exist. So please give another Username.";
            ?>
            <script type="text/javascript">
                alert("<?php echo $msg;?>");
                window.location="#add";
            </script>
            <?php
        }
    }
    $sel_check2 = "select * from dental_users where email = '".$db->escape($_POST["email"])."' and userid != '".$db->escape($_POST['ed'])."'";
    $query_check2=mysqli_query($con,$sel_check2);
    if(mysqli_num_rows($query_check2)>0) {
        $msg="Email already exist. So please give another Email.";
        ?>
        <script type="text/javascript">
            alert("<?php echo $msg;?>");
            window.location="#add";
        </script>
        <?php
    } else {
        $isExclusive = (bool)$_POST['is_billing_exclusive'];

        if($_POST["ed"] != "") {
            $old_sql = "SELECT status, username, recover_hash FROM dental_users WHERE userid='".$db->escape($_POST["ed"])."'";
            $old_q = mysqli_query($con,$old_sql);
            $old_r = mysqli_fetch_assoc($old_q);
            $old_status = $old_r['status'];

            $ed_sql = "update dental_users set 
                username = '".$db->escape(trim($_POST["username"]))."',
                user_access=2,
                npi = '".$db->escape($_POST["npi"])."',
                medicare_npi = '".$db->escape($_POST["medicare_npi"])."',
                medicare_ptan = '".$db->escape($_POST["medicare_ptan"])."',
                tax_id_or_ssn = '".$db->escape($_POST["tax_id_or_ssn"])."', 
                ssn = '".$db->escape($_POST['ssn'])."',
                ein = '".$db->escape($_POST['ein'])."',
                practice = '".$db->escape($_POST['practice'])."', 
                first_name = '".$db->escape($_POST["first_name"])."', 
                last_name = '".$db->escape($_POST["last_name"])."',
                email = '".$db->escape($_POST["email"])."', 
                address = '".$db->escape($_POST["address"])."', 
                city = '".$db->escape($_POST["city"])."', 
                state = '".$db->escape($_POST["state"])."', 
                zip = '".$db->escape($_POST["zip"])."', 
                phone = '".$db->escape(num($_POST["phone"]))."', 
                fax = '".$db->escape(num($_POST["fax"]))."',
                use_patient_portal = '".$db->escape($_POST['use_patient_portal'])."',
                use_payment_reports = '".$db->escape($_POST['use_payment_reports'])."',
                use_digital_fax = '".$db->escape($_POST['use_digital_fax'])."',
                use_letters = '".$db->escape($_POST['use_letters'])."',
                tracker_letters = '".$db->escape($_POST['tracker_letters'])."',
                intro_letters = '".$db->escape($_POST['intro_letters'])."',
                use_eligible_api = '".$db->escape($_POST['use_eligible_api'])."',
                eligible_test = '".$db->escape($_POST['eligible_test'])."',
                use_course = '".$db->escape($_POST['use_course'])."',
                use_course_staff = '".$db->escape($_POST['use_course_staff'])."',
                homepage = '".$db->escape($_POST['homepage'])."',
                use_letter_header = '".$db->escape($_POST['use_letter_header'])."',
                user_type = '".$db->escape($_POST['user_type'])."',
                status = '".$db->escape($_POST["status"])."',
                use_service_npi = '".$db->escape($_POST['use_service_npi'])."',
                service_name = '".$db->escape($_POST['service_name'])."',
                service_address = '".$db->escape($_POST['service_address'])."',
                service_city = '".$db->escape($_POST['service_city'])."',
                service_state = '".$db->escape($_POST['service_state'])."',
                service_zip = '".$db->escape($_POST['service_zip'])."',
                service_phone = '".$db->escape($_POST['service_phone'])."',
                service_fax = '".$db->escape($_POST['service_fax'])."',
                service_npi = '".$db->escape($_POST['service_npi'])."',
                service_medicare_npi = '".$db->escape($_POST['service_medicare_npi'])."',
                service_medicare_ptan = '".$db->escape($_POST['service_medicare_ptan'])."',
                service_tax_id_or_ssn = '".$db->escape($_POST['service_tax_id_or_ssn'])."',
                service_ssn = '".$db->escape($_POST['service_ssn'])."',
                service_ein = '".$db->escape($_POST['service_ein'])."',
            ";
            if($old_status!=3 && $_POST['status']==3){
                $ed_sql.= "
                    suspended_reason = '".$db->escape($_POST["suspended_reason"])."',
                    suspended_date = now(),
                ";
            }
            $ed_sql .= "
                billing_company_id = '".$db->escape($_POST['billing_company_id'])."',
                is_billing_exclusive = '$isExclusive',
                plan_id = '".$db->escape($_POST['plan_id'])."',
                billing_plan_id = '".$db->escape($_POST['billing_plan_id'])."',
                access_code_id = '".$db->escape($_POST['access_code_id'])."'
                where userid='".$db->escape($_POST["ed"])."'";
            $db->query($ed_sql);
            $loc_sql = "UPDATE dental_locations SET
                location = '".$db->escape($_POST['mailing_practice'])."', 
                name = '".$db->escape($_POST["mailing_name"])."', 
                address = '".$db->escape($_POST["mailing_address"])."', 
                city = '".$db->escape($_POST["mailing_city"])."', 
                state = '".$db->escape($_POST["mailing_state"])."', 
                zip = '".$db->escape($_POST["mailing_zip"])."', 
                email = '".$db->escape($_POST["mailing_email"])."',
                phone = '".$db->escape(num($_POST["mailing_phone"]))."',
                fax = '".$db->escape(num($_POST["mailing_fax"]))."'
                where default_location=1 AND docid='".$db->escape($_POST["ed"])."'";
            mysqli_query($con,$loc_sql);
            edx_user_update($_POST['ed']);
            help_user_update($_POST['ed']);
            form_update_all($_POST['ed'], true);

            if(is_super($_SESSION['admin_access'])){
                mysqli_query($con,"DELETE FROM dental_user_company WHERE userid='".$db->escape($_POST["ed"])."'");
                mysqli_query($con,"INSERT INTO dental_user_company SET userid='".$db->escape($_POST["ed"])."', companyid='".$db->escape($_POST["companyid"])."'");
            }

            mysqli_query($con,"DELETE FROM dental_user_hst_company WHERE userid='".$db->escape($_POST["ed"])."'");
            foreach($_POST['hst_company'] as $hst_company){
                mysqli_query($con,"INSERT INTO dental_user_hst_company SET userid='".$db->escape($_POST["ed"])."', companyid='".$db->escape($hst_company)."', adddate=now(), ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'");
            }
            if(isset($_POST['reg_but'])){
                $userid = $_POST['ed'];
                $recover_hash = $old_r['recover_hash'];
                $m = "
                    <html>
                    <body>
                    <center>
                        <table width='600'>
                            <tr>
                                <td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td>
                            </tr>
                            <tr>
                                <td width='400'>
                                    <h2>Create your Software Account</h2>
                                    <p>Welcome to the Dental Sleep Solutions&reg; Team! Please click the link below to activate your software account:</p>
                                    <p><a href='http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$userid."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$userid."&hash=".$recover_hash."</a></p>
                                </td>
                                <td width='200'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td>
                            </tr>
                            <tr>
                                <td>
                                    <h3>
                                        Need assistance?
                                        Contact us at 877-95-SNORE or at<br>
                                        Support@dentalsleepsolutions.com
                                    </h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td>
                            </tr>
                        </table>
                    </center>
                    </body>
                    </html>
                ";
                $m .= DSS_EMAIL_FOOTER;
                $headers = 'From: support@dentalsleepsolutions.com' . "\n" .
                    'Content-type: text/html' ."\n" .
                    'Reply-To: support@dentalsleepsolutions.com' . "\n" .
                    'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Account Activation";
                $mail = mail($_POST['email'], $subject, $m, $headers);
                if ($mail) {
                    $e_sql = "UPDATE dental_users SET recover_time = now(), registration_email_date=now() WHERE userid='".$db->escape($userid)."'";
                    mysqli_query($con,$e_sql);
                }
            }
            $msg = "Edited Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_users.php?msg=<?php echo $msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $salt = create_salt();
            $password = gen_password($_POST['password'], $salt);
            $recover_hash = hash('sha256', $r['patientid'].$_POST['email'].rand());

            /**
             * Inherit setting from Billing Company
             */
            $billingCompanyId = (int)$_POST['billing_company_id'];
            $isExclusive = $db->getColumn("SELECT exclusive
                FROM companies
                WHERE id = '$billingCompanyId'", 'exclusive', 0);

            $ins_sql = "insert into dental_users set user_access=2,
                username = '".$db->escape($_POST["username"])."',
                npi = '".$db->escape($_POST["npi"])."',
                medicare_npi = '".$db->escape($_POST["medicare_npi"])."',
                medicare_ptan = '".$db->escape($_POST["medicare_ptan"])."',
                tax_id_or_ssn = '".$db->escape($_POST["tax_id_or_ssn"])."', 
                ssn = '".$db->escape(!empty($_POST['ssn']) ? $_POST['ssn'] : '')."',
                ein = '".$db->escape(!empty($_POST['ein']) ? $_POST['ein'] : '')."',
                practice = '".$db->escape($_POST['practice'])."', 
                password = '".$db->escape($password)."', 
                salt = '".$salt."',
                first_name = '".$db->escape($_POST["first_name"])."', 
                last_name = '".$db->escape($_POST["last_name"])."',
                name = '".$db->escape(trim($_POST["first_name"] . ' ' . $_POST["last_name"]))."',
                email = '".$db->escape($_POST["email"])."', 
                address = '".$db->escape($_POST["address"])."', 
                city = '".$db->escape($_POST["city"])."', 
                state = '".$db->escape($_POST["state"])."', 
                zip = '".$db->escape($_POST["zip"])."', 
                phone = '".$db->escape(num($_POST["phone"]))."', 
                fax = '".$db->escape(num($_POST["fax"]))."',
                use_patient_portal = '".$db->escape($_POST['use_patient_portal'])."',
                use_payment_reports = '".$db->escape($_POST['use_payment_reports'])."',
                use_digital_fax = '".$db->escape($_POST['use_digital_fax'])."',
                use_letters = '".$db->escape($_POST['use_letters'])."',
                tracker_letters = '".$db->escape($_POST['tracker_letters'])."',
                intro_letters = '".$db->escape($_POST['intro_letters'])."',
                use_eligible_api = '".$db->escape(!empty($_POST['use_eligible_api']) ? $_POST['use_eligible_api'] : '')."',
                eligible_test = '".$db->escape(!empty($_POST['eligible_test']) ? $_POST['eligible_test'] : '')."',
                use_course = '".$db->escape(!empty($_POST['use_course']) ? $_POST['use_course'] : '')."',
                use_course_staff = '".$db->escape($_POST['use_course_staff'])."',
                homepage = '".$db->escape($_POST['homepage'])."',
                use_letter_header = '".$db->escape($_POST['use_letter_header'])."',
                user_type = '".$db->escape($_POST["user_type"])."',
                billing_company_id = '".$_POST['billing_company_id']."',
                is_billing_exclusive = '$isExclusive',
                plan_id = '".$_POST['plan_id']."',
                billing_plan_id = '".(!empty($_POST['billing_plan_id']) ? $_POST['billing_plan_id'] : '')."',
                access_code_id = '".$_POST['access_code_id']."',
                use_service_npi = '".$db->escape((!empty($_POST['use_service_npi']) ? $_POST['use_service_npi'] : ''))."',
                service_name = '".$db->escape($_POST['service_name'])."',
                service_address = '".$db->escape($_POST['service_address'])."',
                service_city = '".$db->escape($_POST['service_city'])."',
                service_state = '".$db->escape($_POST['service_state'])."',
                service_zip = '".$db->escape($_POST['service_zip'])."',
                service_phone = '".$db->escape($_POST['service_phone'])."',
                service_fax = '".$db->escape($_POST['service_fax'])."',
                service_npi = '".$db->escape($_POST['service_npi'])."',
                service_medicare_npi = '".$db->escape($_POST['service_medicare_npi'])."',
                service_medicare_ptan = '".$db->escape($_POST['service_medicare_ptan'])."',
                service_tax_id_or_ssn = '".$db->escape($_POST['service_tax_id_or_ssn'])."',
                service_ssn = '".$db->escape((!empty($_POST['service_ssn']) ? $_POST['service_ssn'] : ''))."',
                service_ein = '".$db->escape((!empty($_POST['service_ein']) ? $_POST['service_ein'] : ''))."',
            ";
            if(isset($_POST['reg_but'])){
                $ins_sql .= " recover_hash='".$db->escape($recover_hash)."',
                    recover_time=NOW(), 
                    status=2,";
            }else{
                $ins_sql .= "status = '".$db->escape($_POST["status"])."',";
                if($_POST['status'] == 3){
                    $ins_sql .= "suspended_reason = '".$db->escape($_POST["suspended_reason"])."',";
                    $ins_sql .= "suspended_date = now(),";
                }
            }
            $ins_sql .= " adddate=now(),
                ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'";
            $db->query($ins_sql);
            $userid = mysqli_insert_id($con);
            $loc_sql = "INSERT INTO dental_locations SET
                location = '".$db->escape($_POST['mailing_practice'])."', 
                name = '".$db->escape($_POST["mailing_name"])."', 
                address = '".$db->escape($_POST["mailing_address"])."', 
                city = '".$db->escape($_POST["mailing_city"])."', 
                state = '".$db->escape($_POST["mailing_state"])."', 
                zip = '".$db->escape($_POST["mailing_zip"])."', 
                email = '".$db->escape($_POST["mailing_email"])."',
                phone = '".$db->escape(num($_POST["mailing_phone"]))."',
                fax = '".$db->escape(num($_POST["mailing_fax"]))."',
                default_location=1,
                docid='".$db->escape($userid)."',
                adddate=now(),
                ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'";
            mysqli_query($con,$loc_sql);
            edx_user_update($userid);

            $userid = intval($userid);

            mysqli_query($con,"INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('General', 'FFF9CF', 'general', ".$userid.")");
            mysqli_query($con,"INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Follow-up', 'D6CFFF', 'follow-up', ".$userid.")");
            mysqli_query($con,"INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Sleep Test', 'CFF5FF', 'sleep_test', ".$userid.")");
            mysqli_query($con,"INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Impressions', 'DFFFCF', 'impressions', ".$userid.")");
            mysqli_query($con,"INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('New Pt', 'FFCFCF', 'new_pt', ".$userid.")");
            mysqli_query($con,"INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Deliver Device', 'FBA16C', 'deliver_device', ".$userid.")");

            mysqli_query($con,"INSERT INTO `dental_resources` (name, rank, docid) VALUES ('Chair 1', 1, ".$userid.")");

            $code_sql = "insert into dental_transaction_code (transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, docid, amount_adjust) SELECT transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, ".$userid.", amount_adjust FROM dental_transaction_code WHERE default_code=1";
            $db->query($code_sql);
            $custom_sql = "insert into dental_custom (title, description, docid) SELECT title, description, ".$userid." FROM dental_custom WHERE default_text=1";
            $db->query($custom_sql);

            if(is_super($_SESSION['admin_access'])){
                mysqli_query($con,"INSERT INTO dental_user_company SET userid='".$db->escape($userid)."', companyid='".$db->escape($_POST["companyid"])."'");
            }else{
                mysqli_query($con,"INSERT INTO dental_user_company SET userid='".$db->escape($userid)."', companyid='".$db->escape($_SESSION["companyid"])."'");
            }
            foreach($_POST['hst_company'] as $hst_company){
                mysqli_query($con,"INSERT INTO dental_user_hst_company SET userid='".$db->escape($_POST["ed"])."', companyid='".$db->escape($hst_company)."', adddate=now(), ip_address='".$db->escape($_SERVER['REMOTE_ADDR'])."'");
            }

            if(isset($_POST['reg_but'])){
                $m = "
                    <html>
                    <body>
                    <center>
                        <table width='600'>
                            <tr>
                                <td colspan='2'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_header.png' /></td>
                            </tr>
                            <tr>
                                <td width='400'>
                                    <h2>Create your Software Account</h2>
                                    <p>Welcome to the Dental Sleep Solutions&reg; Team! Please click the link below to activate your software account:</p>
                                    <p><a href='http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$userid."&hash=".$recover_hash."'>http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$userid."&hash=".$recover_hash."</a></p>
                                </td>
                                <td width='200'><img alt='Dental Sleep Solutions' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td>
                            </tr>
                            <tr>
                                <td>
                                    <h3>
                                        Need assistance?
                                        Contact us at 877-95-SNORE or at<br>
                                        Support@dentalsleepsolutions.com
                                    </h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'><img alt='www.dentalsleepsolutions.com' title='www.dentalsleepsolutions.com' src='http://".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer.png' /></td>
                            </tr>
                        </table>
                    </center>
                    </body>
                    </html>
                ";
                $m .= DSS_EMAIL_FOOTER;
                $headers = 'From: support@dentalsleepsolutions.com' . "\n" .
                    'Content-type: text/html' ."\n" .
                    'Reply-To: support@dentalsleepsolutions.com' . "\n" .
                    'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Account Activation";
                $mail = mail($_POST['email'], $subject, $m, $headers);
                if($mail){
                    $e_sql = "UPDATE dental_users SET registration_email_date=now() WHERE userid='".$db->escape($userid)."'";
                    mysqli_query($con,$e_sql);
                }
                $msg = "Added Successfully";
                ?>
                <script type="text/javascript">
                    parent.window.location='manage_users.php?msg=<?php echo $msg;?>';
                </script>
                <?php
                trigger_error("Die called", E_USER_ERROR);
            }else{
                $msg = "Added Successfully";
                ?>
                <script type="text/javascript">
                    parent.window.location='manage_users.php?msg=<?php echo $msg;?>';
                </script>
                <?php
                trigger_error("Die called", E_USER_ERROR);
            }
        }
    }
}
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<input type="hidden" id="dom-api-token" value="<?= adminApiToken() ?>">
<?php
$thesql = "SELECT
        u.*,
        c.companyid,
        l.name AS mailing_name,
        l.address AS mailing_address,
        l.location AS mailing_practice,
        l.city AS mailing_city,
        l.state AS mailing_state,
        l.zip AS mailing_zip,
        l.email AS mailing_email,
        l.phone AS mailing_phone,
        l.fax AS mailing_fax
    FROM dental_users u
    LEFT JOIN dental_user_company c ON u.userid = c.userid
    LEFT JOIN dental_locations l ON l.docid = u.userid AND l.default_location = 1
    WHERE u.userid = '".$db->escape($_REQUEST["ed"])."'";
$themy = mysqli_query($con,$thesql);
$themyarray = mysqli_fetch_array($themy);

if(!empty($msg)) {
    $username = $_POST['username'];
    $npi = $_POST['npi'];
    $medicare_npi = $_POST['medicare_npi'];
    $medicare_ptan = $_POST['medicare_ptan'];
    $tax_id_or_ssn = $_POST['tax_id_or_ssn'];
    $ssn = (!empty($_POST['ssn']) ? $_POST['ssn'] : '');
    $ein = (!empty($_POST['ein']) ? $_POST['ein'] : '');
    $practice = $_POST['practice'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    $mailing_practice = $_POST['mailing_practice'];
    $mailing_name = $_POST['mailing_name'];
    $mailing_address = $_POST['mailing_address'];
    $mailing_city = $_POST['mailing_city'];
    $mailing_state = $_POST['mailing_state'];
    $mailing_zip = $_POST['mailing_zip'];
    $mailing_email = $_POST['mailing_email'];
    $mailing_phone = $_POST['mailing_phone'];
    $mailing_fax = $_POST['mailing_fax'];
    $status = $_POST['status'];
    $suspended_reason = $_POST['suspended_reason'];
    $use_patient_portal = $_POST['use_patient_portal'];
    $use_payment_reports = $_POST['use_payment_reports'];
    $use_digital_fax = $_POST['use_digital_fax'];
    $use_letters = $_POST['use_letters'];
    $tracker_letters = $_POST['tracker_letters'];
    $intro_letters = $_POST['intro_letters'];
    $use_eligible_api = (!empty($_POST['use_eligible_api']) ? $_POST['use_eligible_api'] : '');
    $eligible_test = (!empty($_POST['eligible_test']) ? $_POST['eligible_test'] : '');
    $use_course = (!empty($_POST['use_course']) ? $_POST['use_course'] : '');
    $use_course_staff = $_POST['use_course_staff'];
    $use_letter_header = $_POST['use_letter_header'];
    $homepage = $_POST['homepage'];
    $companyid = $_POST['companyid'];
    $user_type = $_POST['user_type'];
    $billing_company_id = $_POST['billing_company_id'];
    $billing_exclusive = $_POST['is_billing_exclusive'];
    $access_code_id = $_POST['access_code_id'];
    $plan_id = $_POST['plan_id'];
    $billing_plan_id = (!empty($_POST['billing_plan_id']) ? $_POST['billing_plan_id'] : '');
    $use_service_npi = (!empty($_POST['use_service_npi']) ? $_POST['use_service_npi'] : '');
    $service_name = $_POST['service_name'];
    $service_address = $_POST['service_address'];
    $service_city = $_POST['service_city'];
    $service_state = $_POST['service_state'];
    $service_zip = $_POST['service_zip'];
    $service_phone = $_POST['service_phone'];
    $service_fax = $_POST['service_fax'];
    $service_npi = $_POST['service_npi'];
    $service_medicare_npi = $_POST['service_medicare_npi'];
    $service_medicare_ptan = $_POST['service_medicare_ptan'];
    $service_tax_id_or_ssn = $_POST['service_tax_id_or_ssn'];
    $service_ein = (!empty($_POST['service_ein']) ? $_POST['service_ein'] : '');
    $service_ssn = (!empty($_POST['service_ssn']) ? $_POST['service_ssn'] : '');
} else {
    $username = st($themyarray['username']);
    $npi = st($themyarray['npi']);
    $medicare_npi = st($themyarray['medicare_npi']);
    $medicare_ptan = st($themyarray['medicare_ptan']);
    $tax_id_or_ssn = st($themyarray['tax_id_or_ssn']);
    $ssn = st($themyarray['ssn']);
    $ein = st($themyarray['ein']);
    $practice = st($themyarray['practice']);
    $first_name = st($themyarray['first_name']);
    $last_name = st($themyarray['last_name']);
    $email = st($themyarray['email']);
    $address = st($themyarray['address']);
    $city = st($themyarray['city']);
    $state = st($themyarray['state']);
    $zip = st($themyarray['zip']);
    $phone = st($themyarray['phone']);
    $fax = st($themyarray['fax']);
    $mailing_practice = st($themyarray['mailing_practice']);
    $mailing_name = st($themyarray['mailing_name']);
    $mailing_address = st($themyarray['mailing_address']);
    $mailing_city = st($themyarray['mailing_city']);
    $mailing_state = st($themyarray['mailing_state']);
    $mailing_zip = st($themyarray['mailing_zip']);
    $mailing_email = st($themyarray['mailing_email']);
    $mailing_phone = st($themyarray['mailing_phone']);
    $mailing_fax = st($themyarray['mailing_fax']);
    $status = st($themyarray['status']);
    $suspended_reason = st($themyarray['suspended_reason']);
    $use_patient_portal = st($themyarray['use_patient_portal']);
    $use_payment_reports = st($themyarray['use_payment_reports']);
    $use_digital_fax = st($themyarray['use_digital_fax']);
    $use_letters = st($themyarray['use_letters']);
    $tracker_letters = st($themyarray['tracker_letters']);
    $intro_letters = st($themyarray['intro_letters']);
    $use_eligible_api = st($themyarray['use_eligible_api']);
    $eligible_test = st($themyarray['eligible_test']);
    $use_course = st($themyarray['use_course']);
    $use_course_staff = st($themyarray['use_course_staff']);
    $use_letter_header = st($themyarray['use_letter_header']);
    $homepage = st($themyarray['homepage']);
    $companyid = st($themyarray['companyid']);
    $user_type = st($themyarray['user_type']);
    $billing_company_id = $themyarray['billing_company_id'];
    $billing_exclusive = $themyarray['is_billing_exclusive'];
    $plan_id = $themyarray['plan_id'];
    $billing_plan_id = $themyarray['billing_plan_id'];
    $access_code_id = $themyarray['access_code_id'];
    $use_service_npi = $themyarray['use_service_npi'];
    $service_name = $themyarray['service_name'];
    $service_address = $themyarray['service_address'];
    $service_city = $themyarray['service_city'];
    $service_state = $themyarray['service_state'];
    $service_zip = $themyarray['service_zip'];
    $service_phone = $themyarray['service_phone'];
    $service_fax = $themyarray['service_fax'];
    $service_npi = $themyarray['service_npi'];
    $service_medicare_npi = $themyarray['service_medicare_npi'];
    $service_medicare_ptan = $themyarray['service_medicare_ptan'];
    $service_tax_id_or_ssn = $themyarray['service_tax_id_or_ssn'];
    $service_ein = $themyarray['service_ein'];
    $service_ssn = $themyarray['service_ssn'];
}

if(!isset($_GET['ed'])){
    $use_patient_portal = 1;
    $use_letters = 1;
    $tracker_letters = 1;
    $intro_letters = 1;
    $use_course = 0;
    $use_course_staff = 1;
    $homepage = 1;
    $use_letter_header = 1;
    $use_payment_reports = 0;
    $companyid = 4;
    $user_type = 2;
    $use_digital_fax = 1;
}

if($themyarray["userid"] != '') {
    $but_text = "Edit/Save ";
} else {
    $but_text = "Add ";
}
?>
<div class="col-md-6 col-md-offset-3">
    <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger text-center">
            <strong><?php echo  $_GET['msg'] ?></strong>
        </div>
    <?php } ?>
    <?php if (!empty($msg)) { ?>
        <div class="alert alert-success text-center">
            <?php echo  $msg ?>
        </div>
    <?php } ?>
    <div class="page-header">
        <h1>
            <?php echo  $but_text ?>
            <?php echo  (!empty($_GET['heading']) ? $_GET['heading'] : '') ?>
            Contact
            <?php if (!empty($name) && trim($name) != "") { ?>
                &quot;<?php echo $name;?>&quot;
            <?php } ?>
        </h1>
    </div>
    <form name="userfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" class="form-horizontal" id="add-user-form">
        <div class="page-header expanded">
            <strong>ID and Access Details</strong>
        </div>
        <div class="form-group expanded">
            <label for="username" class="col-md-3 col-sm-3 col-xs-3 control-label">Username</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo  $username ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="npi" class="col-md-3 col-sm-3 col-xs-3 control-label">NPI Number</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="npi" id="npi" placeholder="NPI Number" value="<?php echo  $npi ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="medicare_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Medicare Provider (NPI/DME) Number</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="medicare_npi" id="medicare_npi" placeholder="Medicare Provider (NPI/DME) Number" value="<?php echo  $medicare_npi ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="medicare_ptan" class="col-md-3 col-sm-3 col-xs-3 control-label">Medicare PTAN Number</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="medicare_ptan" id="medicare_ptan" placeholder="Medicare PTAN Number" value="<?php echo  $medicare_ptan ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="tax_id_or_ssn" class="col-md-3 col-sm-3 col-xs-3 control-label">Tax ID or SSN</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="tax_id_or_ssn" id="tax_id_or_ssn" placeholder="Tax ID/SSN" value="<?php echo  $tax_id_or_ssn ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label class="col-md-3 col-sm-3 col-xs-3 control-label">EIN or SSN required</label>
            <div class="col-md-2 col-sm-2 col-xs-2 col-md-push-3 col-sm-push-3 col-xs-push-3 checkbox">
                <label>
                    EIN
                    <input id="ein" type="checkbox" name="ein" value="1" <?php echo  ($ein)?'checked="checked"':''; ?>>
                </label>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 col-md-push-3 col-sm-push-3 col-xs-push-3 checkbox">
                <label>
                    SSN
                    <input id="ssn" type="checkbox" name="ssn" value="1" <?php echo  ($ssn)?'checked="checked"':''; ?>>
                </label>
            </div>
        </div>
        <div class="form-group expanded">
            <label for="practice" class="col-md-3 col-sm-3 col-xs-3 control-label">Practice</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="practice" id="practice" placeholder="Practice" value="<?php echo  $practice ?>">
            </div>
        </div>
        <?php if (!isset($_REQUEST['ed'])) { ?>
            <div class="form-group expanded">
                <label for="password" class="col-md-3 col-sm-3 col-xs-3 control-label">Password</label>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Your password">
                </div>
            </div>
            <div class="form-group expanded">
                <label for="password2" class="col-md-3 col-sm-3 col-xs-3 control-label">Confirm your password</label>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm your password">
                </div>
            </div>
        <?php } ?>
        <div class="page-header">
            <strong>Personal Details</strong>
        </div>
        <div class="form-group">
            <label for="first_name" class="col-md-3 col-sm-3 col-xs-3 control-label">First Name</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name" value="<?php echo  $first_name ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="last_name" class="col-md-3 col-sm-3 col-xs-3 control-label">Last Name</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name" value="<?php echo  $last_name ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-md-3 col-sm-3 col-xs-3 control-label">Email</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo  $email ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="address" class="col-md-3 col-sm-3 col-xs-3 control-label">Address</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo  $address ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="city" class="col-md-3 col-sm-3 col-xs-3 control-label">City</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo  $city ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="state" class="col-md-3 col-sm-3 col-xs-3 control-label">State</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo  $state ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="zip" class="col-md-3 col-sm-3 col-xs-3 control-label">Zip/Postal Code</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip/Postal Code" value="<?php echo  $zip ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="col-md-3 col-sm-3 col-xs-3 control-label">Phone</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control extphonemask" name="phone" id="phone" placeholder="Phone number" value="<?php echo  $phone ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="fax" class="col-md-3 col-sm-3 col-xs-3 control-label">Fax</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control phonemask" name="fax" id="fax" placeholder="Fax number" value="<?php echo  $fax ?>">
            </div>
        </div>
        <div class="page-header expanded">
            <strong>Mailing Details</strong>
        </div>
        <div class="form-group expanded">
            <label for="mailing_practice" class="col-md-3 col-sm-3 col-xs-3 control-label">Practice</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="mailing_practice" id="mailing_practice" placeholder="Practice" value="<?php echo  $mailing_practice ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_name" class="col-md-3 col-sm-3 col-xs-3 control-label">Name</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="mailing_name" id="mailing_name" placeholder="Name" value="<?php echo  $mailing_name ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_email" class="col-md-3 col-sm-3 col-xs-3 control-label">Email</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="email" class="form-control" name="mailing_email" id="mailing_email" placeholder="Email" value="<?php echo  $mailing_email ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_address" class="col-md-3 col-sm-3 col-xs-3 control-label">Address</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="mailing_address" id="mailing_address" placeholder="Address" value="<?php echo  $mailing_address ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_city" class="col-md-3 col-sm-3 col-xs-3 control-label">City</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="mailing_city" id="mailing_city" placeholder="City" value="<?php echo  $mailing_city ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_state" class="col-md-3 col-sm-3 col-xs-3 control-label">State</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="mailing_state" id="mailing_state" placeholder="State" value="<?php echo  $mailing_state ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_zip" class="col-md-3 col-sm-3 col-xs-3 control-label">Zip/Postal Code</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="mailing_zip" id="mailing_zip" placeholder="Zip/Postal Code" value="<?php echo  $mailing_zip ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_phone" class="col-md-3 col-sm-3 col-xs-3 control-label">Phone</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control extphonemask" name="mailing_phone" id="mailing_phone" placeholder="Phone number" value="<?php echo  $mailing_phone ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="mailing_fax" class="col-md-3 col-sm-3 col-xs-3 control-label">Fax</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="text" class="form-control phonemask" name="mailing_fax" id="mailing_fax" placeholder="Fax number" value="<?php echo  $mailing_fax ?>">
            </div>
        </div>
        <div class="form-group expanded">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Use Service NPI?</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input type="checkbox" name="use_service_npi" id="use_service_npi" value="1" <?php if($use_service_npi == 1) echo " checked='checked'";?> />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Name</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_name" class="form-control tbox" type="text" name="service_name" value="<?php echo $service_name;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Address</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_address" class="form-control tbox" type="text" name="service_address" value="<?php echo $service_address;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service City</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_city" class="form-control tbox" type="text" name="service_city" value="<?php echo $service_city;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service State</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_state" class="form-control tbox" type="text" name="service_state" value="<?php echo $service_state;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Zip</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_zip" class="form-control tbox" type="text" name="service_zip" value="<?php echo $service_zip;?>"/>
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Phone</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_phone" class="form-control tbox extphonemask" type="text" name="service_phone" value="<?php echo $service_phone;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Fax</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_fax" class="form-control tbox phonemask" type="text" name="service_fax" value="<?php echo $service_fax;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service NPI</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_npi" class="form-control tbox" type="text" name="service_npi" value="<?php echo $service_npi;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Medicare NPI</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_medicare_npi" class="form-control tbox" type="text" name="service_medicare_npi" value="<?php echo $service_medicare_npi;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Medicare PTAN</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_medicare_ptan" class="form-control tbox" type="text" name="service_medicare_ptan" value="<?php echo $service_medicare_ptan;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service Tax ID or SSN</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_tax_id_or_ssn" class="form-control tbox" type="text" name="service_tax_id_or_ssn" value="<?php echo $service_tax_id_or_ssn;?>" />
            </div>
        </div>
        <div class="form-group expanded service_field">
            <label for="use_service_npi" class="col-md-3 col-sm-3 col-xs-3 control-label">Service EIN or SSN</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <input id="service_ein" type="checkbox" name="service_ein" value="1" <?php echo  ($service_ein)?'checked="checked"':''; ?> class="tbox" />
                EIN
                <input id="service_ssn" type="checkbox" name="service_ssn" value="1" <?php echo  ($service_ssn)?'checked="checked"':''; ?> class="tbox" />
                SSN
            </div>
        </div>
        <div class="page-header">
            <strong>Options</strong>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3 control-label">Active services</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_patient_portal" value="1" <?php if($use_patient_portal == 1) echo " checked='checked'";?>>
                    Patient Portal
                </label>
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_digital_fax" value="1" <?php if($use_digital_fax == 1) echo " checked='checked'";?>>
                    Digital Fax
                </label>
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_letters" value="1" <?php if($use_letters == 1) echo " checked='checked'";?>>
                    Letters
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-9 col-md-push-3 col-sm-push-3 col-xs-push-3">
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_eligible_api" value="1" <?php if($use_eligible_api == 1) echo " checked='checked'";?>>
                    Eligible API
                </label>
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_course" value="1" <?php if($use_course == 1) echo " checked='checked'";?>>
                    Course
                </label>
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_course_staff" value="1" <?php if($use_course_staff == 1) echo " checked='checked'";?>>
                    Staff Course
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-9 col-md-push-3 col-sm-push-3 col-xs-push-3">
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="eligible_test" value="1" <?php if($eligible_test == 1) echo " checked='checked'";?>>
                    Eligible Test?
                </label>
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_payment_reports" value="1" <?php if($use_payment_reports == 1) echo " checked='checked'";?>>
                    Payment Reports
                </label>
                <?php if (is_super($_SESSION['admin_access'])) { ?>
                    <label id="dentrix-api-checkbox" class="col-md-4 col-sm-4 col-xs-4" v-cloak>
                        <input type="checkbox" v-model="fields.enabled">
                        Dentrix API
                    </label>
                <?php } ?>
            </div>
        </div>
        <?php if (is_super($_SESSION['admin_access'])) { ?>
            <div class="form-group" id="api-permissions-container" v-cloak>
                <div class="col-md-9 col-sm-9 col-xs-9 col-md-push-3 col-sm-push-3 col-xs-push-3">
                    <label v-repeat="group in groups" class="col-md-4 col-sm-4 col-xs-4">
                        <input type="checkbox" value="{{ group.id }}" v-model="permissions[group.id].enabled">
                        <span v-if="group.name.length < 18">{{ group.name }}</span>
                        <small v-if="group.name.length >= 18">{{ group.name }}</small>
                    </label>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3 control-label">Automated services</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="tracker_letters" value="1" <?php if($tracker_letters == 1) echo " checked='checked'";?>>
                    Tracker Letters
                </label>
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="intro_letters" value="1" <?php if($intro_letters == 1) echo " checked='checked'";?>>
                    Intro Letters
                </label>
            </div>
        </div>
        <div class="form-group expanded">
            <label class="col-md-3 col-sm-3 col-xs-3 control-label">Visuals to use</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="homepage" value="1" <?php if($homepage == 1) echo " checked='checked'";?>>
                    New Homepage
                </label>
                <label class="col-md-4 col-sm-4 col-xs-4">
                    <input type="checkbox" name="use_letter_header" value="1" <?php if($use_letter_header == 1) echo " checked='checked'";?>>
                    Letter Header
                </label>
            </div>
        </div>
        <?php if (is_super($_SESSION['admin_access'])) { ?>
            <div class="page-header" v-cloak v-show="fields.enabled">
                <strong>Dentrix API Details</strong>
            </div>
            <div class="form-group" v-cloak v-show="fields.enabled">
                <label for="user-api_key" class="col-md-3 col-sm-3 col-xs-3 control-label">API key</label>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <div class="input-group">
                        <input type="text" class="form-control" id="user-api_key" v-model="fields.api_key" readonly><span class="input-group-addon" v-on="click: generateApiKey(fields)"><i class="glyphicon glyphicon-refresh"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group" v-cloak v-show="fields.enabled">
                <label for="user-valid_from" class="col-md-3 col-sm-3 col-xs-3 control-label">Valid from</label>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <div class="input-group date" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" id="user-valid_from" v-model="fields.valid_from"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group" v-cloak v-show="fields.enabled">
                <label for="user-valid_to" class="col-md-3 col-sm-3 col-xs-3 control-label">Valid to</label>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <div class="input-group date" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" id="user-valid_to" v-model="fields.valid_to"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="page-header">
                <strong>Administration Details</strong>
            </div>
            <div class="form-group">
                <label for="companyid" class="col-md-3 col-sm-3 col-xs-3 control-label">Admin Company</label>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <select name="companyid" id="companyid" class="form-control">
                       <?php
                       $bu_sql = "SELECT * FROM companies WHERE company_type='".DSS_COMPANY_TYPE_SOFTWARE."' ORDER BY name ASC";
                       $bu_q = mysqli_query($con,$bu_sql);
                       while ($bu_r = mysqli_fetch_assoc($bu_q)) { ?>
                           <option value="<?php echo  $bu_r['id']; ?>" <?php echo  ($bu_r['id'] == $companyid)?'selected="selected"':''; ?>><?php echo  $bu_r['name']; ?></option>
                       <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="user_type" class="col-md-3 col-sm-3 col-xs-3 control-label">User Type</label>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <select name="user_type" id="user_type" class="form-control">
                       <option value="<?php echo  DSS_USER_TYPE_FRANCHISEE; ?>" <?php echo  ($user_type == DSS_USER_TYPE_FRANCHISEE)?'selected="selected"':''; ?>><?php echo  $dss_user_type_labels[DSS_USER_TYPE_FRANCHISEE]; ?></option>
                       <option value="<?php echo  DSS_USER_TYPE_SOFTWARE; ?>" <?php echo  ($user_type == DSS_USER_TYPE_SOFTWARE)?'selected="selected"':''; ?>><?php echo  $dss_user_type_labels[DSS_USER_TYPE_SOFTWARE]; ?></option>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="page-header">
            <strong>Companies Details</strong>
        </div>
        <div class="form-group">
            <label for="billing_company_id" class="col-md-3 col-sm-3 col-xs-3 control-label">Billing Company</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <select name="billing_company_id" id="billing_company_id" class="form-control">
                    <option value="">None</option>
                    <?php
                    $bu_sql = "SELECT * FROM companies WHERE company_type='".DSS_COMPANY_TYPE_BILLING."' ORDER BY name ASC";
                    $bu_q = mysqli_query($con,$bu_sql);

                    while ($bu_r = mysqli_fetch_assoc($bu_q)) { ?>
                        <option value="<?php echo  $bu_r['id']; ?>" <?php echo  ($bu_r['id'] == $billing_company_id)?'selected="selected"':''; ?>><?php echo  $bu_r['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <label for="billing_exclusive" class="col-md-3 control-label">Exclusive?</label>
            <div class="col-md-9">
                <input type="checkbox" name="is_billing_exclusive" id="billing_exclusive" class="form-control" value="1" <?= $billing_exclusive ? 'checked' : '' ?>>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-3 control-label">HST Company</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <?php
                $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
                    LEFT JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".$db->escape($_GET['ed'])."'
                    WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
                $bu_q = mysqli_query($con,$bu_sql);

                while ($bu_r = mysqli_fetch_assoc($bu_q)) { ?>
                    <label class="checkbox">
                        <input type="checkbox" name="hst_company[]" value="<?php echo  $bu_r['id']; ?>"  <?php echo  ($bu_r['uhc_id'])?'checked="checked"':''; ?>>
                        <?php echo  $bu_r['name']; ?>
                    </label>
                <?php } ?>
            </div>
        </div>
        <div class="form-group">
            <label for="access_code_id" class="col-md-3 col-sm-3 col-xs-3 control-label">Access Code</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <select name="access_code_id" id="access_code_id" class="form-control">
                    <?php
                    $p_sql = "SELECT * FROM dental_access_codes ORDER BY access_code ASC";
                    $p_q = mysqli_query($con,$p_sql);

                    while ($p_r = mysqli_fetch_assoc($p_q)) { ?>
                        <option value="<?php echo  $p_r['id']; ?>" <?php echo  ($p_r['id'] == $access_code_id)?'selected="selected"':''; ?>><?php echo  $p_r['access_code']; ?><?php echo  ($p_r['status']=='2')?" - inactive":'';?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="plan_id" class="col-md-3 col-sm-3 col-xs-3 control-label">Software Plan</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <select name="plan_id" id="plan_id" class="form-control">
                    <?php
                    $p_sql = "SELECT * FROM dental_plans WHERE office_type='1' ORDER BY name ASC";
                    $p_q = mysqli_query($con,$p_sql);

                    while ($p_r = mysqli_fetch_assoc($p_q)) { ?>
                        <option value="<?php echo  $p_r['id']; ?>" <?php echo  ($p_r['id'] == $plan_id)?'selected="selected"':''; ?>><?php echo  $p_r['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="billing_plan_id" class="col-md-3 col-sm-3 col-xs-3 control-label">Billing Plan</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <select name="billing_plan_id" id="billing_plan_id" class="form-control">
                    <?php
                    $p_sql = "SELECT * FROM dental_plans WHERE office_type='3' ORDER BY name ASC";
                    $p_q = mysqli_query($con,$p_sql);

                    while ($p_r = mysqli_fetch_assoc($p_q)) { ?>
                        <option value="<?php echo  $p_r['id']; ?>" <?php echo  ($p_r['id'] == $billing_plan_id)?'selected="selected"':''; ?>><?php echo  $p_r['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="page-header">
            <strong>Status Details</strong>
        </div>
        <div class="form-group">
            <label for="status" class="col-md-3 col-sm-3 col-xs-3 control-label">Status</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <select id="status" name="status" class="form-control" onchange="showSuspended();">
                    <option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                    <option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                    <option value="3" <?php if($status == 3) echo " selected";?>>Suspended</option>
                </select>
            </div>
        </div>

        <script type="text/javascript">
            function showSuspended(){
                if($('#status').val()==3){
                    $('#suspended_reason').show();
                }else{
                    $('#suspended_reason').hide();
                }
            }
        </script>

        <div id="suspended_reason" class="form-group" <?php echo  ($status!=3)?'style="display:none;"':''; ?>>
            <label for="suspended_reason" class="col-md-3 col-sm-3 col-xs-3 control-label">Suspended Reason</label>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <textarea name="suspended_reason" id="suspended_reason" class="form-control"><?php echo  $suspended_reason ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-9 col-md-offset-3 col-sm-offset-3 col-xs-offset-3">
                <input type="hidden" name="usersub" value="1">
                <input type="hidden" name="ed" value="<?php echo $themyarray["userid"]?>">
                <input type="hidden" name="docid" value="<?php echo $themyarray["docid"]?>">
                <input type="submit" name="save_but" v-on="click: saveUser" value=" <?php echo $but_text?> User" class="btn btn-primary">
                <?php if ($themyarray["userid"] != '' && $_SESSION['admin_access']==1 && $themyarray['status']!=3) { ?>
                    <a href="javascript:parent.window.location='manage_users.php?delid=<?php echo $themyarray["userid"];?>'" v-on="click: deleteUser" class="btn btn-danger pull-right" title="DELETE">
                        Delete
                    </a>
                    <a href="reset_password.php?id=<?php echo $themyarray["userid"];?>" class="btn btn-default pull-right">Reset Password</a>
                    <?php if ($themyarray['status']==2) { ?>
                        <input type="submit" class="btn btn-info" name="reg_but" onclick="return userregabc(this.form)" value="Send Registration Email">
                    <?php } ?>
                <?php } else { ?>
                    <input type="submit" class="btn btn-info" name="reg_but" onclick="return userregabc(this.form)" value="Send Registration Email">
                    <a href="#" onclick="$('.expanded').toggle(); return false;" class="btn btn-default pull-right">Expand all fields</a>
                <?php } ?>
                <?php if($themyarray['status']==2){
                    $registration_link = "http://".$_SERVER['HTTP_HOST']."/manage/register/activate.php?id=".$themyarray['userid']."&hash=".$themyarray['recover_hash'];
                    ?>
                    <a href="#" onclick="alert('<?php echo  $registration_link; ?>');return false;">Registration Link</a>
                <?php } ?>
                <?php if (getenv('DOCKER_USED') && $isSuperAdmin) { ?>
                    <a class="btn btn-danger delete-stripe-customer" data-docid="<?= (int)$themyarray['userid'] ?>" href="#">
                        Delete Stripe data
                        <span class="fa fa-spinner hidden"></span>
                    </a>
                <?php } ?>
            </div>
        </div>
    </form>
</div>
<?php if(!isset($_GET['ed'])){ ?>
    <script type="text/javascript">
        var hide_expanded = true;
        $('.expanded').hide();
    </script>
<?php } ?>
<script>
    jQuery(function($){
        <?php if (($userId && !$canEdit) || (!$userId && !$canCreate)) { ?>
            $('form[name=userfrm]').find('input, select, button').prop('disabled', true);
        <?php } ?>

        function resetFontAwesomeIndicator ($indicator) {
            $indicator.removeClass('fa-exclamation-triangle fa-spinner fa-spin hidden')
                .attr('title', '')
                .text('')
            ;
        }

        $('a.btn.delete-stripe-customer').on('click', function (e) {
            e.preventDefault();

            var $this = $(this),
                $indicator = $this.find('.fa');

            $this.addClass('disabled');
            resetFontAwesomeIndicator($indicator);
            $indicator.addClass('fa-spinner fa-spin')
                .text(' processing')
            ;

            $.ajax({
                url: '/manage/admin/delete-stripe-customer.php',
                type: 'post',
                data: { docid: $this.data('docid') },
                dataType: 'json',
                success: function (response) {
                    resetFontAwesomeIndicator($indicator);
                    $indicator.addClass('fa-check')
                        .text(' success')
                    ;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var response = errorThrown;

                    if (jqXHR.responseJSON && jqXHR.responseJSON.hasOwnProperty('status')) {
                        response = jqXHR.responseJSON.status;
                    }

                    resetFontAwesomeIndicator($indicator);
                    $indicator.addClass('fa-exclamation-triangle')
                        .attr('title', response)
                        .text(' error')
                    ;
                },
                complete: function () {
                    $this.removeClass('disabled');
                }
            });

            return false;
        });

        $('[name=status]').on('change keydown',function(){
            var $this = $(this);
            
            if ($this.val() === '3') {
                $this.closest('.form-group').next().removeClass('hidden');
            }
            else {
                $this.closest('.form-group').next().addClass('hidden');
            }
        });
        
        $('#access_code_id').on('change',function(){
            var ac_id = $(this).val();
            
            $.ajax({
                url: "/manage/admin/includes/access_code_plan.php",
                type: "post",
                data: {ac_id: ac_id},
                success: function(data){
                    var r = $.parseJSON(data);
                    
                    if (r.error) {}
                    else {
                        $('#plan_id').val(r.plan_id);
                    }
                }
            });
        });
        
        if (typeof hide_expanded !== 'undefined' && hide_expanded) {
            $('.expanded').hide();
        }
    }(jQuery));
</script>
<script type="text/javascript">
    $('#use_service_npi').click(function(){
        check_service_npi();
    });

    function check_service_npi(){
        if($('#use_service_npi').is(':checked')){
            $('.service_field').show();
        }else{
            $('.service_field').hide();
        }
    }
    check_service_npi();
</script>
<?php if (is_super($_SESSION['admin_access'])) { ?>
    <script>
        var apiRoot = <?= json_encode(config('app.apiUrl')) ?>;
    </script>
    <script src="/assets/vendor/moment.js" type="text/javascript"></script>
    <script src="/assets/vendor/vue/vue.js" type="text/javascript"></script>
    <script src="/assets/vendor/vue/vue-resource.min.js" type="text/javascript"></script>
    <script src="/assets/app/add-user.js?v=20180502" type="text/javascript"></script>
<?php } ?>
</body>
</html>
