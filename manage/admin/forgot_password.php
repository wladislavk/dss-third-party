<?php namespace Ds3\Libraries\Legacy; ?><?
session_start();
include('includes/main_include.php');
include_once('includes/password.php');
include_once '../includes/constants.inc';
if($_POST["emailsub"] == 1)
{
        $check_sql = "SELECT adminid, username, email FROM admin WHERE email='".mysql_real_escape_string($_POST['email'])."'";
        $check_my = mysql_query($check_sql);
	//echo $check_sql;
        if(mysql_num_rows($check_my) >= 1)
        {
                $check_myarray = mysql_fetch_array($check_my);

                /*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
                mysql_query($ins_sql);*/
                $recover_hash = hash('sha256', $check_myarray['adminid'].$_POST['email'].rand());
                $ins_sql = "UPDATE admin set recover_hash='".$recover_hash."', recover_time=NOW() WHERE adminid='".$check_myarray['adminid']."'";
                mysql_query($ins_sql);

                $headers = 'From: SWsupport@dentalsleepsolutions.com' . "\r\n" .
			'Content-type: text/html' ."\r\n" .
                    'Reply-To: SWsupport@dentalsleepsolutions.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

                $subject = "Dental Sleep Solutions Password Reset";
                $message = "Please use this link to reset your password.
<br /><br />
<a href=\"http://".$_SERVER['HTTP_HOST']."/manage/admin/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash."\">
http://".$_SERVER['HTTP_HOST']."/manage/admin/recover_password.php?un=".$check_myarray['username']."&rh=".$recover_hash."
</a>";
$message .= "<br /><br />";
$message .= DSS_EMAIL_FOOTER;
                //$ins_id = mysql_insert_id();
                $msg = mail($check_myarray['email'], $subject, $message, $headers);

                ?>
                <script type="text/javascript">
                        //alert("<?= $msg; ?>");
                        window.location.replace('index.php?msg=Email sent');
                </script>
                <?
                trigger_error("Die called", E_USER_ERROR);
        }
        else
        {
                $msg='Email address not found';
                ?>
                <script type="text/javascript">
                        window.location.replace('forgot_password.php?msg=<?=$msg;?>');
                </script>
                <?
                trigger_error("Die called", E_USER_ERROR);
        }
}

?>

<?php //require_once dirname(__FILE__) . '/includes/top.htm'; ?>

<div class="page-header">
    <h2>Password Recovery</h2>
</div>

<div class="row">
    <? if($_GET['msg'] != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $_GET['msg'];?>
    </div>
    <? } ?>
    <div class="col-md-6 col-md-push-3">
        <div class="well">
            <form name="loginfrm" method="post" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return loginabc(this)" class="form-inline text-center">
                Email:
                <input type="email" name="email" placeholder="Confirm your email" class="form-control">
                <input type="hidden" name="emailsub" value="1">
                <input type="submit" name="btnsubmit" value="Recover Password" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<?php require_once dirname(__FILE__) . '/includes/bottom.htm'; ?>
