<?php 
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include_once('admin/includes/password.php');
    //include('includes/general_functions.php');
    include 'includes/constants.inc';
?>

    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
    <script type="text/javascript" src="/manage/includes/modal.js"></script>
    <link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
    <link rel="stylesheet" href="css/modal.css" />

<?php
    if(isset($_POST['email_but'])){
        $sql = "SELECT * FROM dental_patients WHERE patientid='".mysql_real_escape_string($_POST['pid'])."'";
        
        $pat = $db->getRow($sql);
        if($pat['recover_hash']==''){
            $recover_hash = hash('sha256', $pat['patientid'].$r['email'].rand());
            $ins_sql = "UPDATE dental_patients set access_type=2, text_num=0, text_date=NOW(), registration_senton=NOW(), registration_status=1, recover_hash='".$recover_hash."', recover_time=NOW() WHERE patientid='".$pat['patientid']."'";
            
            $db->query($ins_sql);
        }else{
            $ins_sql = "UPDATE dental_patients set registration_senton=NOW(), access_type=2, registration_status=1 WHERE patientid='".$pat['patientid']."'";
            
            $db->query($ins_sql);
            $recover_hash = $pat['recover_hash'];
        }

        $usql = "SELECT l.phone mailing_phone, u.user_type, u.logo, l.location mailing_practice, l.address mailing_address, l.city mailing_city, l.state mailing_state, l.zip mailing_zip from dental_users u inner join dental_patients p
                 on u.userid=p.docid 
                 LEFT JOIN dental_locations l ON l.docid = u.userid AND l.default_location=1
    	         where p.patientid='".mysql_real_escape_string($_POST['pid'])."'";
        $loc_sql = "SELECT location FROM dental_summary where patientid='".mysql_real_escape_string($pat['patientid'])."'";

        $loc_r = $db->getRow($loc_sql);
        if($loc_r['location'] != '' && $loc_r['location'] != '0'){
            $location_query = "SELECT * FROM dental_locations WHERE id='".mysql_real_escape_string($loc_r['location'])."' AND docid='".mysql_real_escape_string($pat['docid'])."'";
        }else{
            $location_query = "SELECT * FROM dental_locations WHERE default_location=1 AND docid='".mysql_real_escape_string($pat['docid'])."'";
        }

        $location_info = $db->getRow($location_query);

        $ur = $db->getRow($usql);
        $n = $location_info['phone'];

        $html = '
            <p>Welcome '.$pat['firstname'].' '.$pat['lastname'].'! Your medical record access is just a few steps away.</p>

            <p>You\'ll receive an email with instructions for accessing your records online. The email was sent to:</p>
            <p>'.$pat['email'].'</p>
            <br />
            <p>For your privacy, you\'ll need to enter the following temporary PIN when you login the first time:<p>
            <p>'.$pat['access_code'].'</p>

            <p>We look forward to seeing you at your next visit!</p>
            <p>'.$location_info['location'].'<br />
            '.$location_info['address'].'<br />
            '.$location_info['city'].' '.$location_info['state'].' '.$location_info['zip'].'<br />
            '.$location_info['phone'].'</p>
            ';

        $filename = 'user_pin_'.$pat['patientid'].'.pdf';
        create_pdf('User Temporary PIN', $filename, $html, null, '', '', '', $_SESSION['docid']);
        $e = $pat['email'];
        if($ur['user_type'] == DSS_USER_TYPE_SOFTWARE){
            $logo = "../../../shared/q_file/".$ur['logo'];
        }else{
            $logo = "/reg/images/email/reg_logo.gif";
        }

        $m = "<html><body><center>
            <table width='600'>
            <tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_header_fo.png' /></td></tr>
            <tr><td width='400'>
            <h2>Your New Account</h2>
            <p>A new patient account has been created for you by ".$location_info['location'].".<br />Your Patient Portal login information is:</p>
            <p><b>Email:</b> ".$e."</p>
            </td><td><img alt='Logo' src='".$_SERVER['HTTP_HOST'].$logo."' /></td></tr>
            <tr><td colspan='2'>
            <center>
            <h2>Save Time - Complete Your Paperwork Online</h2>
            </center>
            <p>Click the link below to log in and complete your patient forms online. Paperless forms take only a few minutes to complete and let you avoid unnecessary waiting during your next visit. Saving trees is good too!</p>
            <center><h3><a href='http://".$_SERVER['HTTP_HOST']."/reg/activate.php?id=".$pat['patientid']."&hash=".$recover_hash."'>Click Here to Complete Your Forms Online</a></h3></center>
            </td></tr>
            <tr><td>
            <p>".$location_info['location']."<br />
            ".$location_info['address']."<br />
            ".$location_info['city']." ".$location_info['state']." ".$location_info['zip']."<br />
            ".format_phone($location_info['phone'])."</p>
            <h3>Need Assistance?</h3>
            <p><b>Contact us at ".format_phone($n)."</b></p>
            </td></tr>
            <tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer_fo.png' /></td></tr>
            </table>
            </center><span style=\"font-size:12px;\">This email was sent by Dental Sleep Solutions&reg; on behalf of ".$ur['mailing_practice'].". ".DSS_EMAIL_FOOTER."</span></body></html>";
        
        $headers = 'From: Dental Sleep Solutions <patient@dentalsleepsolutions.com>' . "\r\n" .
                   'Content-type: text/html' ."\r\n" .
                   'Reply-To: patient@dentalsleepsolutions.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        $subject = "Online Patient Registration";
        mail($e, $subject, $m, $headers);
        echo "<br /><br /><h3>Temporary PIN document created and email sent to patient.</h3>";
    ?>
        <script type="text/javascript">
            window.location = 'letterpdfs/<?php echo  $filename; ?>';
        </script>
    <?php
        die();
    }
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript" src="script/validation.js"></script>
    </head>

    <body style="background:#fff;">
        <br />
        <h3>Online Patient Registration Without Text Messaging:</h3>
        <?php
            $a_sql = "SELECT access_code, access_code_date FROM dental_patients WHERE patientid='".$_GET['pid']."'";
            
            $a_r = $db->getRow($a_sql);
            if($a_r['access_code']!='' && !isset($_GET['reset'])){
            $access_code = $a_r['access_code'];
            $c_date = date('m/d/Y', strtotime($a_r['access_code_date'])); 
            $e_date = date('m/d/Y', strtotime(date('Y-m-d', strtotime($a_r['access_code_date']) ). "+5 days"));
        ?>
        A temporary PIN was created for this patient on <?php echo  $c_date; ?> and is valid until <?php echo  $e_date; ?>.  The temporary PIN is: <?php echo  $access_code; ?>.
        <br /><br />
        <a href="patient_access_code.php?pid=<?php echo  $_GET['pid']; ?>&reset=1">Generate New PIN</a>
        <?php
            }else{
                $access_code = rand(100000, 999999);
                $ins_sql = "UPDATE dental_patients set access_code='".$access_code."', access_code_date = NOW() WHERE patientid='".$_GET['pid']."'";
                
                $db->query($ins_sql);
        ?> 
                <p>Is this patient unable or unwilling to receive text messages?  If so you can generate a temporary PIN that will allow the user to register without receiving a text message activation code.</p>
                <p>Temporary PIN: <?php echo  $access_code; ?></p>
                <form method="post">
                    <input type="hidden" name="pid" value="<?php echo  $_GET['pid']; ?>" />
                    <input type="hidden" name="access_code" value="<?php echo  $access_code; ?>" />
                    <input type="submit" name="email_but" value="Email Patient and Print PIN" />
                </form>
        <?php } ?>
    </body>
</html>