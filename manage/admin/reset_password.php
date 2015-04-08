<?php
  include 'includes/main_include.php';
  include '../includes/constants.inc';
        $check_sql = "SELECT userid, username, email FROM dental_users WHERE userid='".mysqli_real_escape_string($con, $_GET['id'])."'";
        $check_my = mysqli_query($con, $check_sql);

        if(mysqli_num_rows($check_my) >= 1)
        {
                $check_myarray = mysqli_fetch_array($check_my);

                /*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
                mysqli_query($con, $ins_sql);*/
                $recover_hash = hash('sha256', $check_myarray['userid'].$_POST['email'].rand());
                $ins_sql = "UPDATE dental_users set recover_hash='".$recover_hash."', recover_time=NOW() WHERE userid='".$check_myarray['userid']."'";
                mysqli_query($con, $ins_sql);

                $headers = 'From: Dental Sleep Solutions <patient@dentalsleepsolutions.com>' . "\r\n" .
'Content-type: text/html' ."\r\n" .
                    'Reply-To: patient@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Password Reset";
                $message = "Please use this link to reset your password.
<br /><br />
http://".$_SERVER['HTTP_HOST']."/manage/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash;
$message .= "<br /><br />";
$message .= DSS_EMAIL_FOOTER;
                //$ins_id = mysqli_insert_id($con);
                $msg = mail($check_myarray['email'], $subject, $message, $headers);

                ?><br />
			<h3>Password reset and user has been emailed.</h3>
                <?
                die();
        }

?>
