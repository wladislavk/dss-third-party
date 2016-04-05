<?php namespace Ds3\Libraries\Legacy; ?><?php 
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
        $mailerData = retrieveMailerData($_POST['pid']);

        $pat = $mailerData['patientData'];
        $location_info = $mailerData['mailingData'];
        $mailerData = $location_info + $pat;
        $filename = "user_pin_{$pat['patientid']}.pdf";

        // Set active_status = 2
        sendRegEmail($pat['patientid'], $pat['email'], '', $pat['email'], 2);

        $template = getTemplate('patient/pin-instructions');
        $html = parseTemplate($template, $mailerData);

        create_pdf('User Temporary PIN', $filename, $html, null, '', '', '', $_SESSION['docid']);

        echo "<br /><br /><h3>Temporary PIN document created and email sent to patient.</h3>";
    ?>
        <script type="text/javascript">
            window.location = 'letterpdfs/<?php echo  $filename; ?>';
        </script>
    <?php
        trigger_error("Die called", E_USER_ERROR);
    }
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
        <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
        <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="script/validation.js"></script>
    </head>

    <body style="background:#fff;">
        <br />
        <h3>Online Patient Registration Without Text Messaging:</h3>
        <?php
            $a_sql = "SELECT access_code, access_code_date FROM dental_patients WHERE patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
            
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
                $ins_sql = "UPDATE dental_patients set access_code='".$access_code."', access_code_date = NOW() WHERE patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
                
                $db->query($ins_sql);
        ?> 
                <p>Is this patient unable or unwilling to receive text messages?  If so you can generate a temporary PIN that will allow the user to register without receiving a text message activation code.</p>
                <p>Temporary PIN: <?php echo  $access_code; ?></p>
                <form method="post">
                    <input type="hidden" name="pid" value="<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" />
                    <input type="hidden" name="access_code" value="<?php echo  $access_code; ?>" />
                    <input type="submit" name="email_but" value="Email Patient and Print PIN" />
                </form>
        <?php } ?>
    </body>
</html>
